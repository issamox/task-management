<template>
    <Nav></Nav>
    <router-view></router-view>
</template>
<script>
import Nav from './components/Nav.vue'
import Login from "./components/Login.vue";
export default {
    components : {
        Nav,
        Login
    }
}
</script>
