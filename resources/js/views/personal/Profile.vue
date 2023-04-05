<template>
    <div>
        <div class="container-xxl mt-5">
            <h1 class="mb-4">Профиль</h1>
            <div v-if="user">
                <p>{{ user.name }}</p>
                <p>{{ user.email }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Profile",

    data() {
        return {
            user: null,
        }
    },

    mounted() {
        this.user = this.$root.getUserFromLocalStorage()
    },

    // methods: {
    //     getUserFromLocalStorage() {
    //         this.user = JSON.parse(localStorage.getItem('user'))
    //     },
    // }
}
</script>

<style scoped>

</style>
