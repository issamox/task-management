import { createRouter , createWebHistory } from 'vue-router'

import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import dashboard from '../components/dashboard.vue';
import project from '../components/project.vue';


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
    {
        path      : '/',
        name      : 'dashboard',
        component : dashboard
    },
    {
        path: '/project/:id/',
        name: 'project.show',
        component: project,
        props: true
    }

]

const router = createRouter({
    routes,
    history : createWebHistory()
});

router.beforeEach((to, from, next) => {
    const publicPages = ['/login', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('userToken');

    if (authRequired && !loggedIn) {
        next('/login');
    } else {
        next();
    }
});

export default router;
