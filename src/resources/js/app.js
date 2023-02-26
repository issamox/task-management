import './bootstrap';

import 'bootstrap/dist/css/bootstrap.css';

import LaravelVuePagination from 'laravel-vue-pagination';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';



import {createApp} from 'vue'

import App from './App.vue'
import router from './router';

const app = createApp(App);

app.use(VueSweetalert2);
app.use(router);
app.component('Pagination',LaravelVuePagination);

app.mount('#app');

