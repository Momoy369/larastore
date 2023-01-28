// Import global API
import Api from '../../api/Api'

const cart = {
    
    //set namespace true
    namespaced: true,
    
    //state
    state: {

        // Cart
        cart: [],

        // Total Cart
        cartTotal: 0,

        // CartWeight
        cartWeight: 0,
    
    },
    
    //mutations
    mutations: {

        // Get data cart
        GET_CART(state, product) {
            state.cart = product
        },

        // Get total cart
        TOTAL_CART(state, total) {
            state.cartTotal = total
        },

        // Get cart weight
        CART_WEIGHT(state, weight) {
            state.cartWeight = weight
        },

        // Clear all cart
        CLEAR_CART(state) {
            state.cart = []
            state.cartTotal = 0
            state.cartWeight = 0
        }
    
    },
    
    //actions
    actions: {

        // Action addToCart
        addToCart({ commit }, { product_id, price, quantity, weight }) {

            // Get data token user
            const token = localStorage.getItem('token')
            const user = JSON.parse(localStorage.getItem('user'))

            // Set Axios header dengan type Authorization + Bearer Token
            Api.defaults.headers.common['Authorization'] = "Bearer " + token

            // Send data Cart ke server
            Api.post('/cart', {
                product_id: product_id,
                price: price,
                quantity: quantity,
                weight: weight,
                customer_id: user.id
            })
            .then(() => {

                // Get data Cart
                Api.get('/cart')
                .then(response => {

                    // Commitmutation GET_CART
                    commit('GET_CART', response.data.cart)
                })

                // Get total Cart
                Api.get('/cart/total')
                .then(response => {

                    // Commit mutation TOTAL_CART
                    commit('TOTAL_CART', response.data.total)
                })
            })
        },

        // Cart Count
        cartCount({ commit }) {

            // Get data token dan user
            const token = localStorage.getItem('token')

            // Set Axios header dengan type Authorization + Bearer token
            Api.defaults.headers.common['Authorization'] = "Bearer " + token

            // Get data cart
            Api.get('/cart')
            .then(response => {

                // Commit mutation GET_CART
                commit('GET_CART', response.data.cart)
            })
        },

        // Cart Total
        cartTotal({ commit }) {

            // Get data token dan user
            const token = localStorage.getItem('token')

            // Set Axios header dengan type Authorization + Bearer token
            Api.defaults.headers.common['Authorization'] = "Bearer " + token

            // Get data Cart
            Api.get('cart/total')
            .then(response => {

                // Commit mutations GET_CART
                commit('TOTAL_CART', response.data.total)
            })
        },

        // Cart Weight
        cartWeight({ commit }) {

            // Get data token dan user
            const token = localStorage.getItem('token')

            // Set Axios header dengan type Authorization + Bearer token
            Api.defaults.headers.common['Authorization'] = "Bearer " + token

            Api.get('/cart/totalWeight')
            .then(response => {

                // Commit mutation CART_WEIGHT
                commit('CART_WEIGHT', response.data.total)
            })
        },

        // Action removeCart
        removeCart({ commit }, cart_id) {

            // Get data token dan user
            const token = localStorage.getItem('token')

            // Set Axios header dengan Authorization + Bearer token
            Api.defaults.headers.common['Authorization'] = "Bearer " + token

            Api.post('/cart/remove', {
                cart_id: cart_id
            })
            .then(() => {

                // Get Cart
                Api.get('/cart')
                .then(response => {
                    commit('GET_CART', response.data.cart)
                })

                // Get total cart
                Api.get('/cart/total')
                .then(response => {
                    commit('TOTAL_CART', response.data.total)
                })

                // Get total cart weight
                Api.get('/cart/totalWeight')
                .then(response => {
                    commit('CART_WEIGHT', response.data.total)
                })
            })
        },

        // Checkout
        checkout({ commit }, data) {

            return new Promise((resolve, reject) => {

                Api.post('/checkout', {
                    courier:        data.courier_type,
                    service:        data.courier_service,
                    cost:           data.courier_cost,
                    weight:         data.weight,
                    name:           data.name,
                    phone:          data.phone,
                    province:       data.province_id,
                    city:           data.city_id,
                    address:        data.address,
                    grand_total:    data.grandTotal
                }).then(response => {

                    resolve(response.data)

                    // Remove all Cart on Database
                    Api.post('/cart/removeAll').then(() => {

                        // Clear cart
                        commit('CLEAR_CART')
                    }).catch(error => {
                        console.log(error)
                    })
                }).catch(error => {
                    reject(error)
                })
            })
        }
    
    },
    
    //getters
    getters: {

        // Get cart
        getCart(state) {
            return state.cart
        },

        // Count Cart
        cartCount(state) {
            return state.cart.length
        },

        // Cart Total
        cartTotal(state) {
            return state.cartTotal
        }
    
    }
   
}

export default cart