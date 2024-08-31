import { createApp } from "vue";
import Main from "./components/Main.vue";
import moment from 'moment';
import router from './router'

const app = createApp(Main);

app.provide('moment', moment);
app.use(router);

app.config.globalProperties.$formatDate = function (value) {
    return moment(value).format('YYYY-MM-DD HH:mm');
};

router.isReady().then(() => {
    app.mount("#order_app");
})
