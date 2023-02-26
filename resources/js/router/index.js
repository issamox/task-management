import { createRouter , createWebHistory } from 'vue-router'

import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import dashboard from '../components/dashboard.vue';

const routes = [
    {
        path      : '/login',
        name      : 'login',
        component : Login
    },
    {
        path      : '/register',
        name      : 'register',
        component : Register
    },
    {
        path      : '/dashboard',
        name      : 'dashboard',
        component : dashboard
    },

]
export default createRouter({
    routes,
    history : createWebHistory()
});
