<template>
    <div class="container d-flex justify-content-center flex-column align-items-center mt-5 w-25">
        <h2 class="mb-4">Регистрация</h2>
        <form action="" class="col-8">
            <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                <div class="alert alert-danger">
                    <div v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</div>
                </div>
            </div>
            <input v-model="user.name" type="text" placeholder="Имя" class="mb-2 form-control form-control-lg">
            <input v-model="user.email" type="email" placeholder="E-mail" class="mb-2 form-control form-control-lg">
            <input v-model="user.password" type="password" placeholder="Пароль" class="mb-2 form-control form-control-lg">
            <input v-model="user.password_confirmation" type="password" placeholder="Подтвердите пароль" class="mb-2 form-control form-control-lg">
            <p>Есть аккаунт? <router-link to="/user/login">Войти</router-link></p>
            <button class="btn btn-dark btn-lg w-100" @click.prevent="register()">{{ !processing ? 'Зарегестрироваться' : 'Загрузка' }}</button>
        </form>
        <p>{{ response }}</p>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name: "Registration",

    data() {
        return {
            user: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            validationErrors:{},
            processing: null,
            response: null
        }
    },

    methods: {
        ...mapActions({
            signIn:'auth/login'
        }),
        async register() {
            this.processing = true;
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/register', this.user)
                        .then(response=>{
                            this.validationErrors = {}
                            this.signIn()
                        })
                        .catch(({response})=>{
                            console.log(response);
                            if(response.status===422){
                                this.validationErrors = response.data.errors
                            }else{
                                this.validationErrors = {}
                                alert(response.data.message)
                            }
                        }).finally(()=>{
                        this.processing = false
                    })
                })
        },
    }
}
</script>

<style scoped>

</style>
