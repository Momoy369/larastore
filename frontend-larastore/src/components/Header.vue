<template>
    <header class="section-header">
        <section class="header-main border-bottom">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-3 col-7">
                        <router-link :to="{name: 'home'}" class="text-decoration-none" data-abc="true">
                            <span class="logo">
                                <i class="fas fa-store-alt"></i>
                                LARASTORE
                            </span>
                        </router-link>
                    </div>
                    <div class="col-md-5 d-none d-md-block">
                        <form class="search-wrap">
                            <div class="input-group w-100">
                                <input type="text" class="form-control search-form" style="width: 55%;border: 1px solid #ffffff;" name="q" placeholder="What do you want to buy?">
                                <div class="input-group-append" style="background-color: azure;">
                                    <button class="btn search-button" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 col-5">
                        <div class="d-flex justify-content-end">
                            <div class="cart-header">
                                <router-link :to="{name: 'cart'}" class="btn seacrh-button btn-md" style="color: #ffffff;background-color: #ef8d66; border-color: #ffffff;">
                                
                                    <i class="fa fa-shopping-cart"></i>
                                     {{ cartCount   }} | Rp. {{ moneyFormat(cartTotal) }}

                                </router-link>
                            </div>
                            <div class="account">
                                <router-link :to="{name: 'login'}" v-if="!isLoggedIn" class="btn seacrh-button btn-md d-none d-md-block ml-4">
                                    <i class="fa fa-user-circle"></i>
                                    ACCOUNT
                                </router-link>
                                <router-link :to="{name: 'dashboard'}" v-else class="btn search-button btn-md d-none d-md-block ml-4">
                                    <i class="fa fa-tachometer-alt"></i>
                                    DASHBOARD
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </header>
</template>

<script>

    import { computed, onMounted } from 'vue'
    import { useStore } from 'vuex'

    export default {
        name: 'HeaderComponent',

        setup() {

            // Store vuex
            const store = useStore()

            // Computed
            const isLoggedIn = computed(() => {

                // Get getters isLoggedIn dari module auth
                return store.getters['auth/isLoggedIn']

            })

            // Cart Count
            const cartCount = computed(() => {

                // Get getter "cartCount" dari module auth
                return store.getters['cart/cartCount']
            })

            // Cart Total
            const cartTotal = computed(() => {

                // Get getter "cartTotal" dari module auth
                return store.getters['cart/cartTotal']
            })

            // Mounted
            onMounted(() => {

                // Check state token
                const token = store.state.auth.token

                if(!token) {
                    return
                }

                // Saat mounted, akan memanggil action "cartCount" di module "Cart"
                store.dispatch('cart/cartCount')

                // Saat mounted, akan memanggil action "cartTotal" di module "Cart"
                store.dispatch('cart/cartTotal')
            })

            return {
                store,
                isLoggedIn,
                cartTotal,
                cartCount,
            }
        }
    }
</script>