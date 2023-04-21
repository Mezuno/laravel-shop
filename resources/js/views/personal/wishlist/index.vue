<template>
    <div class="container-xxl mt-5 mb-5">
        <div class="d-flex">

            <div class="border cart-card w-100 overflow-hidden " id="cart-card">

                <div class="d-flex flex-wrap justify-content-between ms-5 mt-4" id="cartTitle">
                    <h3 class="">Избранное</h3>
                </div>

                <div class="row px-5 pt-4 pb-4 ">
                    <div v-if="wishlist" v-for="(wish, index) in wishlist" class="col-3 mb-3">

                        <router-link class="" :to="`/products/${wish.product.id}`">
                            <img class="w-100" :src="wish.product.image_url" alt="" style="border-radius: 15px;">
                        </router-link>

                        <router-link class="p-2 text-decoration-none" :to="`/products/${wish.product.id}`" style="color: #343a40">
                            {{ wish.product.title }}
                        </router-link>

                        <i class="far fa-heart text-red" style="color: #dc3545;" @click.prevent=""></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "wishlist",
    data() {
        return {
            wishlist: this.$store.state.auth.wishlist,
        }
    },

    methods: {

    }
}
</script>

<style scoped>

</style>
