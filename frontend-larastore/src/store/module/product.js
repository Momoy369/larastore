import Api from '../../api/Api'

const product = {

    // Set namespace
    namespaced: true,

    // State
    state: {

        // Index products
        products: [],

        // Detail product
        product: {},
    },

    // Mutations
    mutations: {

        // Set state products dengan data dari response
        GET_PRODUCTS(state, products) {
            state.products = products
        },

        // Set state product dengan data dari response
        DETAIL_PRODUCT(state, product) {
            state.product = product
        },
    },

    // Actions
    actions: {

        // Action getProducts
        getProducts({ commit }) {

            // Get data sliders ke server
            Api.get('/products')
            .then(response => {

                // Commit ke mutation GET_PRODUCTS dengan response data
                commit('GET_PRODUCTS', response.data.products)
            })
            .catch(error => {

                // Show error log dari response
                console.log(error)
            })
        },

        getDetailProduct({ commit }, slug) {

            // Get data product ke server
            Api.get(`/product/${slug}`)
            .then(response => {

                // Commit ke mutation GET_PRODUCTS dengan response data
                commit('DETAIL_PRODUCT', response.data.product)
            }).catch(error => {
                console.log(error)
            })
        }
    },

    // Getters
    getters: {

    }
}

export default product