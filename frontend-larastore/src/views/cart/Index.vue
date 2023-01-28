<template>
    <div class="container-fluid mb-5 mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <h5>
                            <i class="fa fa-shopping-cart"></i>
                            ORDER DETAILS
                        </h5>
                        <hr>
                        <table class="table" style="border-style: solid !important; border-color: rgb(198, 206, 214) !important;">
                            <tbody>
                                <tr v-for="cart in carts" :key="cart.id" style="background: #edf2f7;">
                                    <td class="b-none" width="25%">
                                        <div class="wrapper-image-cart">
                                            <img :src="cart.product.image" style="width: 100%; border-radius: .5rem;">
                                        </div>
                                    </td>
                                    <td class="b-none" width="50%">
                                        <h5>
                                            <b>{{ cart.product.title }}</b>
                                        </h5>
                                        <table class="table-borderless" style="font-size: 14px;">
                                            <tr>
                                                <td style="padding: .20rem;">QTY</td>
                                                <td style="padding: .20rem;">:</td>
                                                <td style="padding: .20rem;">{{ cart.quantity   }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="b-none text-right">
                                        <p class="m-0 font-weight-bold">
                                            Rp. {{ moneyFormat(cart.price)   }}
                                        </p>

                                        <p class="m-0">
                                            <s style="text-decoration-color: red">
                                                Rp. {{ moneyFormat(cart.product.price * cart.quantity)   }}
                                            </s>
                                        </p>
                                        <br>
                                        <div class="text-right">
                                            <button  @click.prevent="removeCart(cart.id)" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-default">
                            <tbody>
                                <tr>
                                    <td class="set-td text-left" width="60%">
                                        <p class="m-0">TOTAL</p>
                                    </td>
                                    <td class="set-td text-right" width="30%">&nbsp; : Rp.</td>
                                    <td class="text-right set-td">
                                        <p class="m-0" id="subtotal">
                                            {{ moneyFormat(cartTotal)   }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="set-td text-left border-0">
                                        <p class="m-0">COST COURIER (<strong>{{ cartWeight }}</strong> gram<b>(s)</b>)</p>
                                    </td>
                                    <td class="set-td border-0 text-right">&nbsp; : Rp.</td>
                                    <td class="set-td border-0 text-right">
                                        <p class="m-0" id="ongkir-cart"> {{ moneyFormat(state.courier_cost) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-left border-0">
                                        <p class="font-weight-bold m-0 h5 text-uppercase">
                                            Grand Total
                                        </p>
                                    </td>
                                    <td class="border-0 text-right">&nbsp; : Rp.</td>
                                    <td class="border-0 text-right">
                                        <p class="font-weight-bold m-0" align="right">
                                            {{ moneyFormat(state.grandTotal) }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow rounded">
                    <!-- Start Ongkos Kirim -->

                    <div class="card-body">
                        <h5><i class="fa fa-user-circle"></i> DELIVERY DETAILS</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">FULLNAME</label>
                                    <input type="text" class="form-control" id="nama_lengkap" placeholder="Enter fullname" v-model="state.name">
                                    <div class="mt-2 alert alert-danger" v-if="validation.name">
                                        Enter your fullname
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">PHONE/WHATSAPP</label>
                                    <input type="number" class="form-control" id="phone" placeholder="Enter your phone number" v-model="state.phone">
                                    <div class="mt-2 alert alert-danger" v-if="validation.phone">
                                        Enter your phone number
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">PROVINCE</label>
                                    <select class="form-control" v-model="state.province_id" @change="getCities">
                                        <option value="">-- CHOOSE PROVINCE --</option>
                                        <option v-for="province in state.provinces" :key="province.id" :value="province.province_id">{{ province.name   }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">CITY/DISTRICT</label>
                                    <select class="form-control" v-model="state.city_id" @change="getCourier">
                                        <option value="">-- CHOOSE CITY --</option>
                                        <option v-for="city in state.cities" :key="city.id" :value="city.city_id">{{ city.name   }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" v-if="state.courier">
                                    <label class="font-weight-bold">COURIER AGENT</label>
                                    <br>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="courier" value="jne" id="ongkos_kirim-jne" class="form-check-input-select-courier" v-model="state.courier_type" @change="getOngkir">
                                        <label class="form-check-label font-weight-bold mr-4" for="ongkos_kirim-jne">JNE</label>

                                        <input type="radio" name="courier" value="tiki" id="ongkos_kirim-tiki" class="form-check-input-select-courier" v-model="state.courier_type" @change="getOngkir">
                                        <label class="form-check-label font-weight-bold mr-4" for="ongkos_kirim-tiki">TIKI</label>

                                        <input type="radio" name="courier" value="pos" id="ongkos_kirim-pos" class="form-check-input-select-courier" v-model="state.courier_type" @change="getOngkir">
                                        <label class="form-check-label font-weight-bold mr-4" for="ongkos_kirim-pos">POS</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" v-if="state.cost">
                                    <hr>
                                    <label class="font-weight-bold">
                                        COURIER SERVICE
                                    </label>
                                    <br>
                                    <div class="form-check form-check-inline" v-for="value in state.costs" :key="value.service">
                                        <input type="radio" class="form-check-input" name="cost" :id="value.service" :value="value.cost[0].value+'|'+value.service" v-model="state.costService" @change="getCostService">
                                        <label :for="value.service" class="form-check-label font-weight-normal mr-5">
                                            {{ value.service }} - Rp. {{ moneyFormat(value.cost[0].value) }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">
                                        COMPLETE ADDRESS
                                    </label>
                                    <textarea name="address" id="alamat" rows="3" class="form-control" placeholder="Complete address with zip code" v-model="state.address"></textarea>
                                    <div class="mt-2 alert alert-danger" v-if="validation.address">
                                        Enter Complete Address
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" v-if="state.buttonCheckout">
                                <button @click.prevent="checkout" class="btn btn-primary btn-lg btn-block">
                                    CHECKOUT
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- End Ongkos kirim -->

                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import router from '@/router'
import { onMounted, computed, reactive } from 'vue'
    import { useStore } from 'vuex'
    import Api from '../../api/Api'

    export default {
        name: 'CartComponent',

        setup() {

            // Store vuex
            const store = useStore()

            // Mounted Cart
            onMounted(() => {

                // Menjalankan beberapa actions di module cart
                store.dispatch('cart/cartCount') // Untuk memanggil action "cartCount" di module "Cart"

                store.dispatch('cart/cartTotal') // Untuk memanggil action "cartTotal" di module "Cart"

                store.dispatch('cart/cartWeight') // Untuk memanggil action "cartWeight" di module "Cart"
            })

            // Get data cart dari getters cart di module cart
            const carts = computed(() => {
                return store.getters['cart/getCart']
            })

            // Get total cart dari state cartTotal di module Cart
            const cartTotal = computed(() => {
                return store.state.cart.cartTotal
            })

            const cartWeight = computed(() => {
                return store.state.cart.cartWeight
            })

            // Remove Cart

            function removeCart(cart_id) {
            
            // Panggil actions "removeCart" di module "cart" dengan parameter
            "cart_id"
            store.dispatch('cart/removeCart', cart_id)
            }

            // Ongkos kirim

            // Define state form
            const state = reactive({
                name:           '', // State name
                phone:          '', // State phone
                address:        '', // State address
                provinces:      [], // state provinsi
                province_id:    '', // state ID provinsi
                cities:         [], // state cities/kota
                city_id:        '', // state ID city/kota
                courier:        false, // state pilihan kurir
                courier_type:   '', //state jenis kurir
                cost:           false, // state cost kurir
                costs:          '', // state costs kurir
                costService:    '', // state get data cost dan service pengiriman
                courier_cost:   0, // state untuk menyimpan cost kurir
                courier_service: '', // state untuk menyimpan service kurir
                buttonCheckout: false, // state button checkout
                grandTotal:      0 // state untuk grand Total
            })

            // Define state validation
            const validation = reactive({
                name: false, // Validation name
                phone: false, // Validation phone
                address: false // Validation alamat
            })

            // Mounted data provinsi
            const provinces = onMounted(() => {

                Api.get('/rajaongkir/provinces')
                .then(response => {

                    state.provinces = response.data.data // Assign state provinces dengan data hasil response
                }).catch(error => {
                    console.log(error)
                })
            })

            // Fungsi mendapatkan data kota berdasarkan ID provinsi
            function getCities() {
                Api.get('/rajaongkir/cities', {
                    params: {
                        province_id: state.province_id // ID Provinsi
                    }
                }).then(response => {

                    state.cities = response.data.data // Assign state cities dengan data hasil response
                }).catch(error => {
                    console.log(error)
                })
            }

            // Fungss menampilkan pilihan kurir
            function getCourier() {

                // Set state courier menjadi true untuk menampilkan pilihan kurir
                state.courier = true
            }

            // Fungsi untuk mendapatkan biaya ongkos kirim
            function getOngkir() {

                // Check berat produk
                if(cartWeight.value == 0) {
                    alert('Please choose product first!')
                    return
                }

                Api.post('/rajaongkir/checkOngkir', {
                    city_destination: state.city_id,
                    weight: cartWeight.value,
                    courier: state.courier_type
                }).then(response => {

                    // Set state cost menjadi true untuk menampilkan pilihan cost pengiriman
                    state.cost = true

                    // Assign state costs dengan hasil response
                    state.costs = response.data.data.costs
                }).catch(error => {
                    console.log(error)
                })
            }

            // Fungsi untuk mengambil biaya ongkos kirim dan service kurir
            function getCostService() {

                // Split value dengan menghapus string -> |
                let shipping = state.costService.split("|")

                // Set state cost dan service
                state.courier_cost = shipping[0]
                state.courier_service = shipping[1]

                // Hitung Grand Total
                const token = store.state.auth.token

                Api.defaults.headers.common['Authorization'] = "Bearer " + token
                Api.get('cart/total').then(response => {

                    // Jumlahkan total cart dan cost pengiriman
                    state.grandTotal = parseInt(response.data.total) + parseInt(state.courier_cost)
                })

                // Show button checkout
                state.buttonCheckout = true
            }

            // Method/Function Checkout
            function checkout() {

                // Cek apakah ada nama, phone, address, dan berat produk?
                if(state.name && state.phone && state.address && cartWeight.value)
                {

                    // Define variable
                    let data = {
                        name: state.name,
                        phone: state.phone,
                        province_id: state.province_id,
                        city_id: state.city_id,
                        courier_type: state.courier_type,
                        courier_service: state.courier_service,
                        courier_cost: state.courier_cost,
                        weight: cartWeight.value,
                        address: state.address,
                        grandTotal: state.grandTotal,
                    }
                    store.dispatch('cart/checkout', data).then(response => {

                        // Jika berhasil, maka arahkan ke detail order dengan 
                        // parameter snap_token Midtrans
                        router.push({
                            name: 'detail_order',
                            params: {
                                snap_token: response[0].snap_token
                            }
                        })
                    }).catch(error => {
                        console.log(error)
                    })
                }

                // Cek validasi name
                if(!state.name) {
                    validation.name = true
                }

                // Cek validasi phone
                if(!state.phone) {
                    validation.phone = true
                }

                // Cek validasi address
                if(!state.address) {
                    validation.address = true
                }
            }


            return {
                carts,
                cartTotal,
                cartWeight,
                removeCart,
                state,
                validation,
                provinces,
                getCities,
                getCourier,
                getOngkir,
                getCostService,
                checkout,
            }
        }
    }

</script>
