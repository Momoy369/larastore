// Import global API
import Api from '../../api/Api'

const slider = {

    // Set namespace
    namespaced: true,

    // State
    state: {

        // Index slider
        sliders: []

    },

    // Mutations
    mutations: {

        // Set state sliders dengan data dari response
        GET_SLIDERS(state, sliders) {
            state.sliders = sliders
        }

    },

    // Actions
    actions: {

        // Action getSlider
        getSliders({ commit }) {

            // Get data sliders ke server
            Api.get('/sliders')
            .then(response => {

                // Commit ke mutation GET_SLIDERS dengan response data
                commit('GET_SLIDERS', response.data.sliders)
            })
            .catch(error => {

                // Show error log dari response
                console.log(error)
            })
        }

    },

    // Getters
    getters: {

    }
}

export default slider