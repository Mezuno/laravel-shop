<template>
    <div class="container d-flex justify-content-center flex-column align-items-center mt-5 w-25">
        <h2 class="mb-4">Вход</h2>
        <form action="">
            <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                <div class="alert alert-danger">
                    <div v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</div>
                </div>
            </div>
            <input v-model="loginData.email" type="email" placeholder="E-mail" class="mb-2 form-control">
            <input v-model="loginData.password" type="password" placeholder="Пароль" class="mb-2 form-control">
            <button class="btn btn-dark" @click.prevent="login()">{{ !processing ? 'Войти' : 'Загрузка' }}</button>
        </form>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name: "Login",

    data() {
        return {
            loginData: {
                email: "",
                password: ""
            },
            processing: null,
            validationErrors: {}
        }
    },

    methods: {
        ...mapActions({
            signIn:'auth/login'
        }),
        async login(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login',this.loginData).then(({data})=>{
                this.signIn()
            }).catch(({response})=>{
                if(response.status===422){
                    this.validationErrors = response.data.errors
                } else{
                    this.validationErrors = {}
                    alert(response.data.message)
                }
            }).finally(()=>{
                this.processing = false
            })
        },

    }
}
</script>

<style scoped>

</style>
