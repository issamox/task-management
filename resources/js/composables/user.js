import { ref } from 'vue';
import axios from "axios";
import { useRouter } from 'vue-router';

export default function useUser(){
    const router    = useRouter();
    const errors    = ref('');

    const storeUser  = async (data) => {
        errors.value = ''
        try {
            await axios.post('/api/register', data)
            await router.push({name: 'login'})
        } catch (e) {
            if (e.response.status === 422) {
                errors.value = e.response.data.errors
            }
        }
    }

   const login  = async (user) => {
    await axios.post(  '/api/login', user).then(response => {
        if (response.data.authorisation.token) {
            localStorage.setItem('userToken', JSON.stringify(response.data.authorisation.token));
        }
        }).catch((e) => {
        if (e.response.status === 422  ) {
            errors.value = e.response.data.errors
        }
        if (e.response.status === 401  ) {
            alert(e.response.data.message);
        }
    });
    }

    return {
        errors,
        storeUser,
        login
    }
}
