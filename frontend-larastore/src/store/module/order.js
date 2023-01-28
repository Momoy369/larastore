// Import global API
import Api from '../../api/Api'

const order = {

    // Set namespace true
    namespaced: true,

    // State
    state: {

        // Define state orders
        orders: [],

        // Define detail order
        detailOrder: {},

        // Define product in order
        productInOrder: [],

    },

    // Mutations
    mutations: {

        // Get order
        GET_ORDER(state, orders) {
            state.orders = orders // Assign state orders dari hasil response
        },

        // Detail order
        DETAIL_ORDER(state, detailOrder) {
            state.detailOrder = detailOrder // Assign state detailOrder dari hasil response
        },

        // Product in order
        PRODUCT_IN_ORDER(state, product) {
            state.productInOrder = product // Assgin state productInOrder dari hasil response
        }

    },

    // Actions
    actions: {

        // Action getOrder
        getOrder({ commit }) {

            // Define variable token
            const token = localStorage.getItem('token')

            Api.defaults.headers.common['Authorization'] = "Bearer " + token

            Api.get('/order')

            .then(response => {

                // Commit ke mutation GET_ORDER
                commit('GET_ORDER', response.data.data)
            })
        },

        // Action detailOrder
        detailOrder({ commit }, snap_token) {

            // Define variable token
            const token = localStorage.getItem('token')

            Api.defaults.headers.common['Authorization'] = "Bearer " + token
            Api.get(`order/${snap_token}`)

            .then(response => {

                // Commit mutation DETAIL_ORDER
                commit('DETAIL_ORDER', response.data.data)

                // Commit mutation PRODUCT_IN_ORDER
                commit('PRODUCT_IN_ORDER', response.data.product)
            })
        }

    },

    // Getters
    getters: {

        // Getters getOrder
        getOrder(state) {
            return state.orders
        },

        // Getter detailOrder
        detailOrder(state) {
            return state.detailOrder
        },

        // Getter productInOrder
        productInOrder(state) {
            return state.productInOrder
        }

    }
}

export default order