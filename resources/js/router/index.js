import { createRouter , createWebHistory } from 'vue-router'

import Login from '../components/Login.vue';
import Register from '../components/Register.vue';

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

]
export default createRouter({
    routes,
    history : createWebHistory()
});
