<template>
    <div class="all">

        <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none">
            <img :src="product.image_url" class="card-img-top" alt="">
        </router-link>
        <div class="d-flex flex-column p-3 flex-grow-1">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="card-title text-black">
                    <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none">
                        {{ product.title }}
                    </router-link>
                </h6>
            </div>
            <p class="card-text">{{ product.category.title }}</p>
            <p v-for="tag in product.tags" class="alert alert-warning p-1 d-inline-block">{{ tag.title }}</p>

            <div class="d-flex flex-grow-1">
                <p class="me-2">{{ product.avg_rate }}</p>
                <p class="text-warning d-inline-block">
                    <i v-for="n in Math.round(product.avg_rate)" class="fas fa-star"></i>
                    <i v-for="n in 5 - Math.round(product.avg_rate)" class="far fa-star"></i>
                </p>
                <p class="ms-2">({{ product.reviews_count }})</p>
            </div>
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h5 class="card-text text-secondary fw-bold w-100 m-0">{{ product.price.slice(0, -3) }}
                    <h6 class="ms-1 d-inline"><i class="fas fa-ruble-sign"></i></h6></h5>
                <p class="card-text text-secondary w-100 m-0">Артикул: {{ product.vendor_code }}</p>
            </div>

            <div class="row px-2 align-items-center">
                <a @click.prevent="addToCart(product, 'addCart'+identifier+product.id)" href="" class="m-0 btn btn-warning text-white border-0 col-10" style="white-space: nowrap;" :id="`addCart${identifier}${product.id}`">
                    В корзину
                    <i class="fas fa-shopping-cart"></i>
                </a>

                <h5 v-if="authenticated" class="p-0 m-0 col-2">
                    <a class="text-danger ms-3">
                        <i @click.prevent="switchWish(product, `heart${identifier}${product.id}`)" class="far fa-heart" :id="`heart${identifier}${product.id}`" style="cursor: pointer;"></i>
                    </a>
                </h5>
            </div>
        </div>

    </div>
</template>

<script>
import wishHeart from "./UI/wishHeart.vue";
import {mapActions} from "vuex";
import cartMixin from "@/mixins/cartMixin.vue";
import wishMixin from "@/mixins/wishMixin.vue";

export default {
    name: "productCardInCatalog",

    mixins: [cartMixin, wishMixin],

    components: {
        wishHeart
    },

    props: {
        product: {
            type: Object,
            required: true,
        },
        identifier: {
            type: String
        },
    },

    computed: {
        productsInCart() {
            return this.$store.state.cartProducts.products
        },
        authenticated() {
            return this.$store.state.auth.authenticated
        },
        user() {
            return this.$store.state.auth.user
        },
        wishlist() {
            return this.$store.state.auth.wishlist
        }
    },

    mounted: function () {
        this.$nextTick(function (){
            if (this.authenticated) {
                this.matchWishlist(this.product, 'heart'+this.identifier+this.product.id)
            } else {
                this.stretchCartButton('addCart'+this.identifier+this.product.id)
            }
            this.matchCartList(this.product, 'addCart'+this.identifier+this.product.id)
        })
    },

    methods: {
        ...mapActions({
            removeItemFromWishlist:"auth/removeItemFromWishlist",
            setWishlist:"auth/setWishlist",
            addItemToWishlist:"auth/addItemToWishlist",
            addToCartProducts:"cartProducts/addToCartProducts",
        }),
    }
}
</script>

<style scoped>

</style>
