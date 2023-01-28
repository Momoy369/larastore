<template>
    <div class="continer-fluid mb-5 mt-4">
        <div class="row">
            <div class="col-md-3 mb-4">
                <CustomerMenu />
            </div>
            <div class="col-md-9 mb-4">
                <div class="card border-0 rounded shadow">
                    <div class="card-body">
                        <h5 class="font-weight-bold">
                            <i class="fas fa-shopping-cart"></i>
                            ORDER DETAILS
                        </h5>
                        <hr>
                        <table class="table table-bordered">
                            <tr>
                                <td style="width: 25%;">NO. INVOICE</td>
                                <td style="width: 1%;">: </td>
                                <td>
                                    {{ detailOrder.invoice }}
                                </td>
                            </tr>
                            <tr>
                                <td>FULLNAME</td>
                                <td>:</td>
                                <td>
                                    {{ detailOrder.name }}
                                </td>
                            </tr>
                            <tr>
                                <td>PHONE/WHATSAPP</td>
                            <td>:</td>
                            <td>{{ detailOrder.phone }}</td>
                            </tr>
                            <tr>
                                <td>COURIER / SERVICE / COST</td>
                                <td>:</td>
                                <td>
                                    {{ detailOrder.courier }} / {{ detailOrder.service }} / R. {{ detailOrder.cost_courier }}
                                </td>
                            </tr>
                            <tr>
                                <td>ADDRESS</td>
                                <td>:</td>
                                <td>
                                    {{ detailOrder.address }}
                                </td>
                            </tr>
                            <tr>
                                <td>GRAND TOTAL</td>
                                <td>:</td>
                                <td>Rp. {{ detailOrder.grand_total }}</td>
                            </tr>
                            <tr>
                                <td>STATUS</td>
                                <td>:</td>
                                <td>
                                    <button @click="payment(detailOrder.snap_token)" v-if="detailOrder.status == 'pending'" class="btn btn-primary">
                                        PAY NOW
                                    </button>
                                    <button v-else-if="detailOrder.status == 'success'" class="btn btn-success">
                                        {{ detailOrder.status }}
                                    </button>
                                    <button v-else-if="detailOrder.status == 'expired'" class="btn btn-warning">
                                        {{ detailOrder.status }}
                                    </button>
                                    <button v-else-if="detailOrder.status == 'failed'" class="btn btn-danger">
                                        {{ detailOrder.status }}
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="card border-0 rounded shadow mt-4">
                    <div class="card-body">
                        <h5>
                            <i class="fa fa-shopping-cart"></i>
                            ORDER DETAILS
                        </h5>
                        <hr>
                        <table class="table" style="border-style: solid !important; border-color: rgb(198, 206, 214) !important;">
                        
                            <tbody>
                                <tr v-for="product in productInOrder" :key="product.id" style="background: #edf2f7;">
                                    <td class="b-none" width="25%">
                                        <div class="wrapper-image-cart">
                                            <img :src="product.image" style="width: 100%; border-radius: .5rem;">
                                        </div>
                                    </td>
                                    <td class="b-none" width="50%">
                                        <h5>
                                            <b>{{ product.product_name }}</b>
                                        </h5>
                                        <table class="table-borderless" style="font-size: 14px;">
                                            <tr>
                                                <td style="padding: .20rem;">QTY</td>
                                                <td style="padding: .20rem;">:</td>
                                                <td style="padding: .20rem;"><b>{{ product.qty }}</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="b-none text-right">
                                        <p class="m-0 font-weight-bold">
                                            Rp. {{ moneyFormat(product.price) }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

// Import customer menu component
import CustomerMenu from '@/components/CustomerMenu'
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'
import { useRoute, useRouter } from 'vue-router'

export default {

    name: 'OrderShowComponent',

    components: {

        // Customer menu component
        CustomerMenu
    },

    setup() {

        // Store Vuex
        const store = useStore()

        // Router and route Vue Router
        const route = useRoute()
        const router = useRouter()

        // Mounted
        onMounted(() => {

            // Panggil action "detailOrder" di dalam module "order" di Vuex
            store.dispatch('order/detailOrder', route.params.snap_token)
        })

        // Computed
        const detailOrder = computed(() => {

            // Panggil getter dengan nama "detailOrder" di dalam module "order" Vuex
            return store.getters['order/detailOrder']
        })

        // Computed
        const productInOrder = computed(() => {

            // Panggil getter dengan nama "productInOrder" di dalam module "order" Vuex
            return store.getters['order/productInOrder']
        })

        // Function payment "Midtrans"
        function payment(snap_token) {

            window.snap.pay(snap_token, {

                onSuccess: function () {
                    router.push({name: 'detail_order', params:{snap_token: snap_token}})
                },

                onPending: function () {
                    router.push({name: 'detail_order', params:{snap_token: snap_token}})
                },

                onError: function () {
                    router.push({name: 'detail_order', params:{snap_token: snap_token}})
                },
            })
        }

        return {
            store,
            route,
            router,
            detailOrder,
            productInOrder,
            payment
        }
    }
    
}

</script>