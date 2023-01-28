// Import global API
import Api from '../../api/Api'

const auth = {
   
    // Set namespace true
    namespaced: true,

    // State
    state: {
      
        // State untuk token, menggunakan localStorage untuk menyimpan
        // informasi tentang token JWT
        token: localStorage.getItem('token') || '',

        // State user, menggunakan localStorage untuk menyimpan data user
        // yang sedang login
        user: JSON.parse(localStorage.getItem('user')) || {},
    },
    // Mutations
    mutations: {
        // Update state token dan state user dari hasil response
        AUTH_SUCCESS(state, token, user) {
            state.token = token // Assign state token dengan response token
            state.user = user // Assign state user dengan response data user
        },
        // Update state user dari hasil response register/login
        GET_USER(state, user) {
            state.user = user // Assign state user dengan response data user
        },

        // Fungsi logout
        AUTH_LOGOUT(state) {
            state.token = '' // Set state token ke empty
            state.user = {} // Set state user ke empty array
        }
    },
    // Actions
    actions: {
        
        // Action register
        register({ commit }, user) {
            
            // Define callback promise
            return new Promise((resolve, reject) => {
                
                // Send data ke server
                Api.post('/register', {
                
                    // Data yang dikirim ke server untuk proses register
                    name: user.name,
                    email: user.email,
                    password: user.password,
                    password_confirmation: user.password_confirmation
                })
                .then(response => {
                
                    // Define variable dengan isi hasil response dari server
                    const token = response.data.token
                    const user = response.data.user

                    // Set localStorage untuk menyimpan token dan data user
                    localStorage.setItem('token', token)
                    localStorage.setItem('user', JSON.stringify(user))
                    
                    // Set default header Axios dengan token
                    Api.defaults.headers.common['Authorization'] = "Bearer " + token

                    // Commit auth success ke mutations
                    commit('AUTH_SUCCESS', token, user)

                    // Commit get user ke mutations
                    commit('GET_USER', user)

                    // Resolve ke component dengan hasil response
                    resolve(response)
                })
                .catch(error => {
                    // Jika gagal, remove localStorage dengan key token
                    localStorage.removeItem('token')

                    // Reject ke component dengan hasil response
                    reject(error.response.data)
                })
            })
        },
    
        // Action getUser
        getUser({ commit }) {
            
            // Ambil data token dari localStorage
            const token = localStorage.getItem('token')
            
            Api.defaults.headers.common['Authorization'] = "Bearer " + token
            Api.get('/user')
            .then(response => {
           
                // Commit ke mutation GET_USER hasil response
                commit('GET_USER', response.data.user)
            })
        },

        // Action logout
        logout({ commit }) {

            // Define callback promise
            return new Promise((resolve) => {

                // Commit ke mutations AUTH_LOGOUT
                commit('AUTH_LOGOUT')

                // Remove value dari localStorage
                localStorage.removeItem('token')
                localStorage.removeItem('user')

                // Commit ke module Cart untuk set mutations dan state cart menjadi kosong
                commit('cart/GET_CART', 0, { root: true })
                commit('cart/TOTAL_CART', 0, { root: true })

                // Delete header Axios
                delete Api.defaults.headers.common['Authorization']

                // Return resolve ke component
                resolve()
            })
        },

        // Action login
        login({ commit }, user) {

            // Define callback promise
            return new Promise((resolve, reject) => {

                Api.post('/login', {

                    // Data yang dikirim ke server
                    email: user.email,
                    password: user.password
                })
                .then(response => {

                    // Define variable dengan isi hasil response dari server
                    const token = response.data.token
                    const user = response.data.user

                    // Set localStorage untuk menyimpan token dan data user
                    localStorage.setItem('token', token)
                    localStorage.setItem('user', JSON.stringify(user))

                    // Set default header Axios dengan token
                    Api.defaults.headers.common['Authorization'] = "Bearer " + token

                    // Commit auth success ke mutation
                    commit('AUTH_SUCCESS', token, user)

                    // Commit get user ke mutation
                    commit('GET_USER', user)

                    // commit cart total dan cart count ke state yang ada di module cart
                    // Get data cart
                    Api.get('/cart')
                    .then(response => {

                        // Commit mutation GET_CART
                        commit('cart/GET_CART', response.data.cart, { root: true }) 
                        // Kita menambahkan root menjadi true karena beda module

                    })

                    // Get total cart
                    Api.get('/cart/total')
                    .then(response => {

                        // Commit mutation TOTAL_CART
                        commit('cart/TOTAL_CART', response.data.total, { root: true })
                    })

                    // Resolve ke component dengan hasil response
                    resolve(response)
                })
                .catch(error => {

                    // Jika gagal, remove localStoraga dengan key token
                    localStorage.removeItem('token')

                    // Reject ke component dengan hasil response
                    reject(error.response.data)
                })
            })
        }
    },
  
    // Getters
    getters: {
  
        // Get current user
        currentUser(state) {
            return state.user // Return dengan data user
        },
  
        // LoggedIn
        isLoggedIn(state) {
            return state.token // Return dengan data token
        },
    }
}

export default auth