<template>
    <div>
        <div @mouseout="hideProductCardContent(product.id)" @mouseover="emergingProductCardContent(product.id)" class="product-card">

            <div class="absolute-background" :id="`absoluteBackground${product.id}`">
                <img class="w-100 image-in-product-card cursor-pointer" :src="product.image_url" alt="">
            </div>
            <div>
                <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none cursor-pointer">
                    <img class="w-100 image-in-product-card" :src="product.image_url" alt="" :id="`image${product.id}`">
                </router-link>
            </div>

            <div class="content-in-product-card d-flex flex-column w-100">
                <div :id="`contentVisible${product.id}`">
                    <h5 class="mt-2 mb-0">{{ product.price.slice(0, -3) }} ₽</h5>
                    <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none">
                        <span class="fw-semibold">{{ product.company.title }}</span> / {{ product.title }}
                    </router-link>
                    <div class="d-flex flex-grow-1">
                        <p class="text-warning d-inline-block">
                            <i v-for="n in Math.round(product.avg_rate)" class="fas fa-star"></i>
                            <i v-for="n in 5 - Math.round(product.avg_rate)" class="far fa-star"></i>
                        </p>
                        <p class="ms-2">({{ product.reviews_count }})</p>
                    </div>
                </div>

                <div class="content-in-product-card-emerging flex-column" :id="`contentInvisible${product.id}`">

                    <p class="card-text">{{ product.category.title }}</p>

                    <div v-if="product.tags.length !== 0" class="mb-3">
                        <h6 v-for="(tag, index) in product.tags" class="d-inline" style="width: fit-content">
                            {{ tag.title }}<span v-if="index < product.tags.length-1">/</span>
                        </h6>
                    </div>

                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <p class="card-text text-secondary w-100 m-0">Артикул: {{ product.vendor_code }}</p>
                    </div>

                    <div @click.prevent="addToCart(product, `addCart${identifier}${product.id}`)"
                         class="m-0 btn btn-warning text-white border-0 col-12"
                         style="white-space: nowrap; width: fit-content" :id="`addCart${identifier}${product.id}`">
                        В корзину <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <div class="heart-in-product cursor-pointer">
                <h3><i @click.prevent="switchWish(product, `heart${identifier}${product.id}`)" :id="`heart${identifier}${product.id}`" class="far fa-heart"></i></h3>
            </div>

        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import cartMixin from "@/mixins/cartMixin.vue";
import wishMixin from "@/mixins/wishMixin.vue";
import getElementPropertiesMixin from "@/mixins/getElementPropertiesMixin.vue";

export default {
    name: "ProductCard",

    props: {
        product: {
            type: Object,
            required: true,
        },
        identifier: {
            type: String
        },
    },

    mixins: [getElementPropertiesMixin, cartMixin, wishMixin],

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

        emergingProductCardContent(id) {
            let absoluteBackground = document.getElementById('absoluteBackground'+id)
            absoluteBackground.style.boxShadow = ('0 0 40px #ddd')
            absoluteBackground.style.opacity = ('1')
            absoluteBackground.style.zIndex = ('600')

            document.getElementById('image'+id).style.zIndex = ('600')
            document.getElementById('contentInvisible'+id).style.display = ('flex')
            document.getElementById('contentInvisible'+id).style.zIndex = ('800')

            absoluteBackground.style.height = 30 +
                parseFloat(this.getHeight('image'+id)) +
                parseFloat(this.getHeight('contentVisible'+id)) +
                parseFloat(this.getHeight('contentInvisible'+id)) + 'px'
        },

        hideProductCardContent(id) {
            document.getElementById('absoluteBackground'+id).style = ('')
            document.getElementById('image'+id).style.zIndex = ('200')
            document.getElementById('contentInvisible'+id).style.display = ('none')
        },
    }
}
</script>

<style scoped>

</style>
