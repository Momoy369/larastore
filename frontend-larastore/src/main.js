import { createApp } from 'vue'
import App from './App.vue'

// Import Router
import router from './router'

// Import store Vuex
import store from './store'

const app = createApp(App)

// Use router in vue js with plugin "use"
app.use(router)

// Use store in vue js with plugin "use
app.use(store)

// Define mixins for global function
app.mixin({
    methods: {
        // Money thousands
        moneyFormat(number) {
            let reverse = number.toString().split('').reverse().join(''),
            thousands = reverse.match(/\d{1,3}/g)
            thousands = thousands.join('.').split('').reverse().join('')
            return thousands
        },

        // Calculate discount
        calculateDiscount(product) {
            return product.price - (product.price * (product.discount)/100)
        }
    }
});

app.mount('#app')
