<template>
    <div>
        <div class="container-xxl mt-5">
            <h1 class="mb-4">Профиль</h1>
            <div v-if="this.$root.user">
                <p>{{ this.$root.user.name }}</p>
                <p>{{ this.$root.user.email }}</p>
                <h2>Заказы</h2>

                <div v-if="!orderLoader" class="d-flex justify-content-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div v-if="orders && orderLoader" v-for="order in orders" class="d-flex mb-3">
                    <div class="p-2">#{{ order.id }}</div>
                    <div class="p-2">Товары:</div>
                    <div v-for="orderProduct in order.products" class="p-2">
                        <router-link :to="`/products/${orderProduct.id}`">{{ orderProduct.title }}</router-link>,
                    </div>
                </div>
                <h2>Желаемое</h2>
                <div v-if="wishlist" v-for="(wish, index) in wishlist" class="d-flex">
                    <div class="p-2">#{{ index+1 }}</div>
                    <router-link class="p-2" :to="`/products/${wish.product.id}`">
                        <img :src="wish.product.image_url" width="50" height="50" alt="">
                    </router-link>
                    <router-link class="p-2" :to="`/products/${wish.product.id}`">{{ wish.product.title }}</router-link>
                    <i class="fas fa-times" @click.prevent="removeWish(wish)"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Profile",

    data() {
        return {
            // user: null,
            orders: [],
            wishlist: [],
            orderLoader: null
        }
    },

    mounted() {
        // this.user = this.$root.getUserFromLocalStorage()
        this.getOrders()
        this.getWishlist()
    },

    methods: {
        getOrders() {
            this.orderLoader = false
            axios.post('/api/orders', {
                user_id: this.$root.user.id
            })
                .then(response => {
                    this.orders = response.data.data
                    console.log(response);
                    this.orderLoader = true
                })
                .catch(error => {
                    console.log(error);
                })
        },
        getWishlist() {
            axios.post('/api/wishlist', {
                user_id: this.$root.user.id
            })
                .then(response => {
                    this.wishlist = response.data.data
                    console.log(this.wishlist);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        removeWish(wish) {
            axios.delete('/api/wish/'+wish.id+'/delete')
                .then(response => {
                    console.log(response);
                    this.wishlist = this.wishlist.filter(w => w.id !== wish.id);
                })
                .catch(error => {
                    console.log(error);
                })
        },
    }
}
</script>

<style scoped>

</style>
