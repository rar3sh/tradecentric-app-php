import { createApp } from "vue";
import App from "./components/App.vue";
import moment from 'moment';

const app = createApp(App);

app.provide('moment', moment);

app.config.globalProperties.$formatDate = function (value) {
    return moment(value).format('YYYY-MM-DD HH:mm');
};

app.mount("#order_app");
