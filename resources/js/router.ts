import OrderAddEdit from './components/OrderAddEdit.vue'
import Main from './components/Main.vue'
import Charts from './components/Charts.vue'
import ListOrders from './components/ListOrders.vue'
import {createRouter, createWebHashHistory} from 'vue-router';

const routes = [
    { path: '/', name: 'Home', component: Main},
    { path: '/charts', name: 'Charts', component: Charts},
    { path: '/orders', name: 'List Orders', component: ListOrders},
    { path: '/orders/:orderId', name: 'EditOrder', component: OrderAddEdit},
    { path: '/orders/add', name: 'AddOrder', component: OrderAddEdit}
]

const router = createRouter({
    history: createWebHashHistory(),
    routes,
    strict: false
});

export default router
