<template>
    <div class="container d-flex justify-content-center flex-column align-items-center mt-5 w-25">
        <h2 class="mb-4">Регистрация</h2>
        <form action="">
            <input v-model="name" type="text" placeholder="Имя" class="mb-2 form-control">
            <input v-model="email" type="email" placeholder="E-mail" class="mb-2 form-control">
            <input v-model="password" type="password" placeholder="Пароль" class="mb-2 form-control">
            <input v-model="password_confirmation" type="password" placeholder="Подтвердите пароль" class="mb-2 form-control">
            <button class="btn btn-dark" @click.prevent="register()">{{ !processing ? 'Зарегестрироваться' : 'Загрузка' }}</button>
        </form>
        <p>{{ response }}</p>
    </div>
</template>

<script>
export default {
    name: "Registration",

    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            processing: null,
            response: null
        }
    },

    methods: {
        register() {
            this.processing = true;
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    })
                        .then(response => {
                            localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN'])
                            this.$root.token = response.config.headers['X-XSRF-TOKEN']
                            this.getUserData()
                        })
                        .catch(error => {
                            console.log(error.response)
                            this.processing = false
                            this.response = 'Ошибка '+error.response.data.message
                        })
                })
        },

        getUserData() {
            axios.get('/api/user')
                .then(response => {
                    localStorage.setItem('user', JSON.stringify(response.data))
                    console.log(response)
                    this.$router.push({ name: 'profile' })
                }).catch(error => {
                    console.log(error)
                });
        },
    }
}
</script>

<style scoped>

</style>
