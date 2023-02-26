<template>
    <div class="d-flex align-items-center justify-content-center form-container">
        <div class="flex-fill">
            <h1 class="page-title">Login</h1>
            <form @submit.prevent="getUser">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" v-model="form.email" class="form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" v-model="form.password" class="form-control">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>

            </form>
        </div>
    </div>
    <hr>
    <div v-if="errors" class="container">
        <div v-for="(v, k) in errors" :key="k" class="alert alert-danger" role="alert">
            <div v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </div>
        </div>
    </div>
</template>

<script>
import { reactive } from "vue";
import useUser from "../composables/user";
export default {
    setup() {
        const form = reactive({
            'email': '',
            'password': '',
        })
        const { errors, login } = useUser()
        const getUser = async () => {
            await login({...form});
        }
        return {
            form,
            errors,
            getUser,
        }
    }
}
</script>
<style scoped>
.form-container{
    padding: 20px;
    background-color: #1a202c;
    color: #ffffff;
    width: 50%;
    margin: 30px auto;
}
.form-container input{
    width: 100%;
}
</style>
