<template>
    <div class="container d-flex justify-content-center flex-column align-items-center mt-5 w-25">
        <h2 class="mb-4">Вход</h2>
        <form action="">
            <input v-model="loginData.email" type="email" placeholder="E-mail" class="mb-2 form-control">
            <input v-model="loginData.password" type="password" placeholder="Пароль" class="mb-2 form-control">
            <button class="btn btn-dark" @click.prevent="login()">{{ !processing ? 'Войти' : 'Загрузка' }}</button>
        </form>
        <p>{{ response }}</p>
    </div>
</template>

<script>
export default {
    name: "Login",

    data() {
        return {
            loginData: {
                email: null,
                password: null
            },
            processing: null,
            response: null
        }
    },

    methods: {
        login() {
            this.processing = true
            axios.get('/sanctum/csrf-cookie')
                .then(response => {
                    axios.post('/login', this.loginData)
                        .then((res) => {
                            console.log(res);
                            localStorage.setItem('x_xsrf_token', res.config.headers['X-XSRF-TOKEN'])
                            this.$root.token = res.config.headers['X-XSRF-TOKEN']
                            this.getUserData()
                        })
                        .catch((error) => {
                            this.processing = false
                            console.log(error);
                            this.response = 'Ошибка '+error.response.data.message
                        });
            });
        },

        getUserData() {
            axios.get('/api/user').then(response => {
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
