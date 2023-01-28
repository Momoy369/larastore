// Import global API
import Api from '../../api/Api'

const category = {

    // Set namespace
    namespaced: true,

    // State
    state: {

        // Index categories
        categories: [],

        // Product in category
        productInCategory: [],

    },

    // Mutations
    mutations: {

        // Set state categories dengan data dari response
        GET_CATEGORIES(state, categories) {
            state.categories = categories
        },

        // Set state productInCategory dengan data dari response
        PRODUCT_IN_CATEGORY(state, products) {
            state.productInCategory = products
        }

    },

    // Actions
    actions: {

        // Action getCategories
        getCategories({ commit }) {

            // Get data categories ke server
            Api.get('/categories')
            .then(response => {

                // Commit ke mutation GET_CATEGORIES dengan response data
                commit('GET_CATEGORIES', response.data.categories)
            })
            .catch(error => {

                // Show error log dari response
                console.log(error)
            })
        },

        // Action get data product berdasarkan category
        getProductInCategory({ commit }, slug) {

            // Get data product by category ke server
            Api.get(`/category/${ slug }`)
            .then(response => {

                // Commit ke mutations PRODUCT_IN_CATEGORY dengan response data
                commit('PRODUCT_IN_CATEGORY', response.data.product)
            }).catch(error => {

                console.log(error)
            })
        }

    },

    // Getters
    getters: {

    }
}

export default category