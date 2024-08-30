<template>
    <div id="main_page_container">
        <div class="container">
            <h2 class="title-top">Purchase Orders</h2>
        </div>

        <ConfirmAction id="bulk_delete_confirm_modal"
                       title="Confirmation"
                       content="Are you sure you want to delete the selected items. It cannot be undone."
                       @confirm="bulkDeleteOrders"
        />

        <!-- FILTER   -->
        <div class="container">
            <div class="container-fluid">
                <form class="d-flex" role="search">
                    <div class="col-md-3 filter-group">
                        <label>Order Number</label>
                        <input type="text" class="form-control" placeholder="Ex: TDC000000"
                               v-model="filters['order_number']"
                        >
                    </div>

                    <div class="col-md-3 filter-group">
                        <label>Buyer Name</label>
                        <input type="text" class="form-control" placeholder="Ex: John Doe"
                               v-model="filters['buyer_name']">
                    </div>

                    <div class="col-md-3 filter-group">
                        <label>Total Value Greater then</label>
                        <input type="number" class="form-control" placeholder="Ex: 250" min="0"
                               v-model="filters['total_minimum']">
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success search-btn" type="submit" @click.prevent="onFiltersChanged"
                        >Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center" v-show="this.loading">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div class="container" id="orders-table">
            <div class="container bulk-actions-container">
                <div class="col-md-12" v-show="this.selectedOrders.length > 0">
                    <button class="btn btn-primary m-2" @click.prevent="resetSelection">Reset Selection</button>
                    <button class="btn btn-danger m-2"
                            data-bs-toggle="modal" data-bs-target="#bulk_delete_confirm_modal"
                    >Delete Selected Orders</button>
                </div>
            </div>
            <table class="table">
                <thead class="table-light">
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>Buyer Name</th>
                    <th>Total</th>
                    <th>Date Received</th>
                    <th>Date Updated</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody v-show="this.hasOrders">
                <tr v-for="(order, index) in this.orders" :key="order.id" class="order-row">
                    <td>
                        <input type="checkbox"
                               class="form-check-input mt-0"
                               :id="'order_' + order.id"
                               :checked="selectedOrders.includes(order.id)"
                               @click="selectOrder($event, order)"
                        >
                    </td>
                    <td>{{ index + 1 }}</td>
                    <td>{{ order.order_number }}</td>
                    <td>{{ order.buyer_name }}</td>
                    <td>{{ order.total }}</td>
                    <td>{{ $formatDate(order.created_at) }}</td>
                    <td>{{ $formatDate(order.updated_at) }}</td>
                    <td>
                        <button class="btn btn-success" @click.prevent="showOrder">Edit</button>
                    </td>
                </tr>
                </tbody>
                <div class="row" v-show="!this.hasOrders">
                    <h1 class="text-center">No data to display.</h1>
                </div>
            </table>
        </div>
    </div>
</template>


<script>
import axios from 'axios'
import ConfirmAction from './Modals/ConfirmAction.vue'

export default {
    name: 'App',
    components: { ConfirmAction },
    data () {
        return {
            loading: false,
            orders: [],
            page: 1,
            pageSize: 20,
            filters: {
                'order_number': '',
                'buyer_name': '',
                'total_minimum': ''
            },
            ordersCount: 0,
            selectedOrders: []
        }
    },
    methods: {
        toggleLoading (value = true) {
            this.loading = value
        },

        onFiltersChanged () {
            this.refreshOrdersList()
        },

        onPaginationChanged (page, pageSize) {
            this.page = page
            this.pageSize = pageSize
            this.refreshOrdersList()
        },

        showOrder (orderId) {

        },

        async refreshOrdersList () {
            this.resetSelection();
            this.toggleLoading()
            try {
                let response = await axios.get('/api/orders?' + this.queryFilters)
                this.parseOrdersResponse(response.data)
            } catch (error) {
                console.log(error)
                this.orders = []
            } finally {
                this.toggleLoading(false)
            }
        },

        async bulkDeleteOrders () {
            this.toggleLoading()
            try {
                await axios.post('/api/orders/delete-bulk', {
                    "ids": this.selectedOrders
                })
            } catch (error) {
                console.log(error)
            } finally {
                this.toggleLoading(false)
            }
            await this.refreshOrdersList()
        },

        parseOrdersResponse (apiResponse) {
            this.orders = apiResponse.data
            this.ordersCount = apiResponse.total
            this.page = apiResponse.current_page
            this.pageSize = apiResponse.per_page
            console.log('new data', this.orders)
            console.log('this.ordersCount', this.ordersCount)
        },

        selectOrder (event, order) {
            if (event.target.checked) {
                if (this.selectedOrders.indexOf(order.id) === -1) { //missing from selection
                    this.selectedOrders.push(order.id)
                    console.log('checked', order.id)
                }
                console.log('selectedOrders', this.selectedOrders)
                return
            }

            if (this.selectedOrders.indexOf(order.id) > -1) {   //exists in selection
                this.selectedOrders.splice(this.selectedOrders.indexOf(order.id), 1)
                console.log('Unchecked', order.id)
            }
            console.log('selectedOrders', this.selectedOrders)
        },

        resetSelection () {
            this.selectedOrders = []
            console.log('selectedOrders', this.selectedOrders)
        }
    },
    computed: {
        queryFilters () {
            let query = ''
            for (const [key, value] of Object.entries(this.filters)) {
                if (value !== '') {
                    query += `${key}=${value}&`
                }
            }
            query += `perPage=${this.pageSize}&` + `page=${this.page}`
            return query
        },

        hasOrders () {
            return this.orders.length > 0
        }
    },
    mounted () {
        this.refreshOrdersList()
    }
}
</script>

<style scoped>
.title-top {
    margin-bottom: 20px;
    margin-left: 30px;
}

.form-control {
    margin-top: 3px;
}

.filter-group {
    margin-left: 10px;
    margin-right: 10px;
}

.bulk-actions-container {
    margin: 20px 0px;
    height: 50px;
}

.search-btn {
    margin-top: 25px;
}

#orders-table {
    margin-top: 20px;
}

#orders-table .order-row {
    vertical-align: middle;
}
</style>
