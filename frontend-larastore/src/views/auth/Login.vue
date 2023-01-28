<template>
    <div class="container-fluid mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div v-if="validation.message" class="mt-2 alert alert-danger">
                    {{ validation.message }}
                </div>
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <h4>LOGIN</h4>
                        <hr>
                        <form @submit.prevent="login">
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" v-model="user.email" class="form-control" placeholder="Email Address">
                            </div>
                            <div v-if="validation.email" class="mt-2 alert alert-danger">
                                {{ validation.email[0] }}
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" v-model="user.password" class="form-control" placeholder="Enter password">
                            </div>
                            <div v-if="validation.password" class="mt-2 alert alert-danger">
                                {{ validation.password[0] }}
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label for="exampleCheck1" class="form-check-label">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
                        </form>
                    </div>
                </div>
                <div class="register mt-3 text-center">
                    <p>
                        Do not have an account? <router-link :to="{name: 'register'}">Register now!</router-link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import { ref, reactive } from 'vue'
    import { useStore } from 'vuex'
    import { useRouter } from 'vue-router'
    
    export default {
        name: 'LoginComponent',

        setup() {

            // User state
            const user = reactive({
                email: '',
                password: ''
            })

            // Validation state
            const validation = ref([])

            // Store vuex
            const store = useStore()

            // Route
            const router = useRouter()

            // Method login
            function login() {

                // Define variable
                let email = user.email
                let password = user.password

                // Panggil action "login" dari module "auth" di vuex
                store.dispatch('auth/login', {
                    email,
                    password
                })
                .then(() => {

                    // Redirect to dashboard
                    router.push({name: 'dashboard'})
                })
                .catch(error => {

                    // Assign validation message
                    validation.value = error
                })
            }

            // Return object
            return {
                user,
                validation,
                login
            }
        }
    }
</script>