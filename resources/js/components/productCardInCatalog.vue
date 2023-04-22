<template>
    <div class="all">

        <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none">
            <img :src="product.image_url" class="card-img-top" height="258" alt="">
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
                    <i v-for="n in Math.ceil(product.avg_rate)" class="fas fa-star"></i>
                    <i v-for="n in 5 - Math.ceil(product.avg_rate)" class="far fa-star"></i>
                </p>
                <p class="ms-2">({{ product.reviews_count }})</p>
            </div>
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h5 class="card-text text-secondary fw-bold w-100 m-0">{{ product.price.slice(0, -3) }}
                    <h6 class="ms-1 d-inline"><i class="fas fa-ruble-sign"></i></h6></h5>
                <p class="card-text text-secondary w-100 m-0">Артикул: {{ product.vendor_code }}</p>
            </div>

            <div class="row px-2 align-items-center">
                <a @click.prevent="addToCart(product)" href="" class="m-0 btn btn-warning text-white border-0 col-10" style="white-space: nowrap;" :id="`addCart${identifier}${product.id}`">
                    В корзину
                    <i class="fas fa-shopping-cart"></i>
                </a>

                <h5 v-if="authenticated" class="p-0 m-0 col-2">
                    <a class="text-danger ms-3">
                        <i @click.prevent="switchWish(product)" class="far fa-heart" :id="`heart${identifier}${product.id}`" style="cursor: pointer;"></i>
                    </a>
                </h5>
            </div>
        </div>

    </div>
</template>

<script>
import wishHeart from "./UI/wishHeart.vue";
import {mapActions} from "vuex";

export default {
    name: "productCardInCatalog",

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

    data() {
        return {
            // authenticated: this.$store.state.auth.authenticated,
            // user: this.$store.state.auth.user,
        }
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
                this.matchWishlist(this.product)
            } else {
                this.stretchCartButton(this.product)
            }
            this.getCartList(this.product)
        })
    },

    methods: {
        ...mapActions({
            removeItemFromWishlist:"auth/removeItemFromWishlist",
            setWishlist:"auth/setWishlist",
            addItemToWishlist:"auth/addItemToWishlist",
            addToCartProducts:"cartProducts/addToCartProducts",
        }),

        stretchCartButton(product) {
            document.getElementById('addCart'+this.identifier+product.id).classList.remove('col-10')
            document.getElementById('addCart'+this.identifier+product.id).classList.add('col-12')
        },

        addToCart(product) {
            document.getElementById('addCart'+this.identifier+product.id).innerText = 'Добавляем'

            let newProduct = [{
                'id': product.id,
                'title': product.title,
                'price': Number(product.price),
                'image_url': product.image_url,
                'vendor_code': product.vendor_code,
                'qty': 1
            }]

           this.addToCartProducts({newProduct, product})

            // КОСТЫЛЬ ----------
            let productInCartQty;
            this.productsInCart?.forEach((productInCart) => {
                if (productInCart.id === product.id) {
                    productInCartQty = productInCart.qty
                }
            })
            // --------------------

            document.getElementById('addCart'+this.identifier+product.id).innerText = 'Добавлено! (' + productInCartQty + 'шт.)'
            document.getElementById('addCart'+this.identifier+product.id).classList.remove('btn-warning')
            document.getElementById('addCart'+this.identifier+product.id).classList.add('btn-success')
        },

        getCartList(product) {
            if (this.productsInCart && this.productsInCart?.length > 0) {
                this.productsInCart?.forEach((productInCart) => {
                    if (productInCart.id === product.id) {
                        document.getElementById('addCart'+this.identifier+product.id).innerText = 'Добавлено! (' + productInCart.qty + 'шт.)'
                        document.getElementById('addCart'+this.identifier+product.id).classList.remove('btn-warning')
                        document.getElementById('addCart'+this.identifier+product.id).classList.add('btn-success')
                    }
                })
            }
        },

        switchWish(product) {
            let removed = false

            if (this.wishlist.length === 0) {
                this.storeWish(product)
            } else {
                this.wishlist.forEach((wish) => {
                    if (wish.product_id === product.id) {
                        this.removeWish(wish)
                        removed = true
                        return;
                    }
                })

                if (!removed) {
                    this.storeWish(product)
                }
            }
        },

        storeWish(product) {
            document.getElementById('heart'+this.identifier+product.id).classList.remove('far')
            document.getElementById('heart'+this.identifier+product.id).classList.add('fas')

            this.addItemToWishlist({
                'user_id': this.user.id,
                'product_id': product.id,
                'product': product,
            })
        },

        removeWish(wish) {
            document.getElementById('heart'+this.identifier+wish.product.id).classList.remove('fas')
            document.getElementById('heart'+this.identifier+wish.product.id).classList.add('far')
            this.removeItemFromWishlist(wish)
        },

        matchWishlist(product) {
            if (this.$root.wishlist.length !== 0) {
                for (let i = 0; i < this.$root.wishlist.length; i++) {
                    if (this.$root.wishlist[i].product_id === product.id) {
                        document.getElementById('heart'+this.identifier+product.id).classList.remove('far')
                        document.getElementById('heart'+this.identifier+product.id).classList.add('fas')
                    }
                }
            }
        },
    }
}
</script>

<style scoped>

</style>
