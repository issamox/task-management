<template>
    <div class="d-flex align-items-center justify-content-center form-container">
        <div class="flex-fill">
            <h1 class="page-title">Register</h1>
            <form @submit.prevent="saveUser">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" id="name" v-model="form.name" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" v-model="form.email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" v-model="form.password" class="form-control">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
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
            'name': '',
            'email': '',
            'password': '',
        })
        const { errors, storeUser } = useUser()
        const saveUser = async () => {
            await storeUser({...form});
        }
        return {
            form,
            errors,
            saveUser
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
