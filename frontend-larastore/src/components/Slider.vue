<template>
    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item" v-for="(slider, id) in sliders" :class="{ active: id==0 }" :key='slider.id'>
                <img :src="slider.image" class="d-block w-100 rounded-lg">

            </div>
        </div>
        <a href="#carousel" class="carousel-control-prev" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a href="#carousel" class="carousel-control-next" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</template>

<script>

import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'

export default {

    name: 'SliderComponent',

    setup() {

        // Store Vuex
        const store = useStore()

        // onMounted akan menjalankan action "getSlider" di module "slider"
        onMounted(() => {
            store.dispatch('slider/getSliders')
        })

        // Computed properti digunakan untuk mendapatkan data dari state
        // "slider" di module "slider"
        const sliders = computed(() => {
            return store.state.slider.sliders
        })

        return {
            store,
            sliders
        }
    }
}

</script>