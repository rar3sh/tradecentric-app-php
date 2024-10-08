<template>
    <h3 v-show="order?.id"> EDIT ORDER #{{ order.order_number }} from {{$formatDate(order.created_at)}}</h3>
    <h3 v-show="!order?.id"> Add Order</h3>

    <ConfirmAction id="delete_confirm_modal"
                   title="Confirmation"
                   content="Are you sure you want to delete the order? It cannot be undone."
                   @confirm="deleteOrder"/>

    <div class="alert alert-warning align-items-center" role="alert"
         v-show="errorMessage.length > 0"
         v-on:click="errorMessage = ''"
    >
            {{ errorMessage }}
    </div>

    <div class="container">
        <div class="text-center" v-show="this.loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="container" id="order_form" v-show="!this.loading">
            <form class="" role="search">
                <div class="row">
                    <div class="col-md-4" id="buyer_group">
                        <label>Buyer Name</label>
                        <input type="text" class="form-control" placeholder="Ex: John Doe"
                               v-model="order.buyer_name"
                               minlength="5"
                        >
                    </div>

                    <div class="col-md-4" id="total_group">
                        <label>Total</label>
                        <input type="number" class="form-control" placeholder="Ex: 250" min="0" v-model="order.total">
                    </div>

                    <div class="col-md-3" style="padding-top: 20px;">
                        <button class="btn btn-success search-btn" type="submit" @click.prevent="submit">Save</button>
                    </div>

                    <div class="col-md-3" style="padding-top: 20px;" v-if="order?.id">
                        <button class="btn btn-danger"
                                data-bs-toggle="modal" data-bs-target="#delete_confirm_modal"
                            >Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { Order } from '../Models/Order.ts'
import ConfirmAction from './Modals/ConfirmAction.vue'

export default {
    name: 'AddEditOrder',
    components: { ConfirmAction },
    data () {
        return {
            loading: false,
            order: new Order(),
            errorMessage: '',
        }
    },
    methods: {
        async getOrder (orderId) {
            this.loading = true

            try {
                return axios.get('/api/orders/' + orderId)
            } catch (error) {
                console.log(error)
            } finally {
                this.loading = false
            }
        },
        async deleteOrder () {
            this.loading = true
            try {
                await axios.delete('/api/orders/' + this.order.id)
                this.redirectToList()
            } catch (error) {
                console.log(error)
            } finally {
                this.loading = false
            }
        },
        async submit () {
            this.loading = true

            try {
                if (this.order?.id) {
                    await axios.patch('/api/orders/' + this.order.id, this.order)
                } else {
                    await axios.post('/api/orders', this.order)
                }
                this.redirectToList()
            } catch (error) {
                this.errorMessage = error.response.data.message
                console.log(error)
            } finally {
                this.loading = false
            }
        },
        redirectToList () {
            this.$router.push('/orders')
        }
    },
    computed: {
      orderId() {
          return this.$route.params.orderId;
      }
    },
    async mounted () {
        if (this.$route?.params.orderId) {
            let response = await this.getOrder(this.$route.params.orderId)

            let order = new Order()
            order.id = response.data.id
            order.buyer_name = response.data.buyer_name
            order.order_number = response.data.order_number
            order.total = response.data.total

            this.order = order
        }
    }
}
</script>
