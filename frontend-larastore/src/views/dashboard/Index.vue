<template>
    <div class="container-fluid mb-5 mt-4">
        <div class="row">
            <div class="col-md-3 mb-4">
                <CustomerMenu />
            </div>
            <div class="col-md-9 mb-4">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <h5 class="font-weight-bold">
                            <i class="fas fa-tachometer-alt"></i>
                            DASHBOARD
                        </h5>
                        <hr>
                        Welcome <strong>{{ user.name }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Import customer menu component
    import CustomerMenu from '@/components/CustomerMenu'
    import { computed, onMounted, reactive } from 'vue'
    import { useStore } from 'vuex'

    export default {
        name: 'DashboardComponent',
        components: {
            // Customer menu component
            CustomerMenu
        },

        setup() {
            // Store vuex
            const store = useStore()
            // Mounted
            onMounted(() => {
                // Panggil action "getUser" dari module "auth" Vuex
                store.dispatch('auth/getUser')
            })
            // Computed
            const user = computed(() => {
                // Panggil getters dengan nama "currentUser" dari module "auth"
                return store.getters['auth/currentUser']
            })

            // Return a state and function
            return {
                store,
                user,
                reactive
            }
        }
    }
</script>