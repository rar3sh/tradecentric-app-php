import AddEditOrder from './components/AddEditOrder.vue'
import Charts from './components/Charts.vue'
import ListOrders from './components/ListOrders.vue'
import {createRouter, createWebHashHistory} from 'vue-router';

const routes = [
    { path: '/', name: 'Home', component: ListOrders},
    { path: '/charts', name: 'Charts', component: Charts},
    { path: '/orders', name: 'List Orders', component: ListOrders},
    { path: '/orders/add', name: 'AddOrder', component: AddEditOrder},
    { path: '/orders/:orderId', name: 'EditOrder', component: AddEditOrder}
]

const router = createRouter({
    history: createWebHashHistory(),
    routes,
    strict: false
});

export default router
