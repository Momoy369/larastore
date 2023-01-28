// Import Vuex
import { createStore } from 'vuex'

// Import module auth
import auth from './module/auth'

// Import module order
import order from './module/order'

// Import module category
import category from './module/category'

// Import module slider
import slider from './module/slider'

// Import module product
import product from './module/product'

// Import module cart
import cart from './module/cart'

// Create Store Vuex
export default createStore({
    modules: {
        auth,
        order,
        category,
        slider,
        product,
        cart,
    }
})