<template>
    <div class="all">

        <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none">
            <img :src="product.image_url" class="card-img-top" width="200px" alt="">
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

            <div class="d-flex justify-content-between flex-grow-1 align-items-end mb-3">
                <h5 class="card-text text-secondary fw-bold w-100 m-0">{{ product.price.slice(0, -3) }}
                    <h6 class="ms-1 d-inline"><i class="fas fa-ruble-sign"></i></h6></h5>
                <p class="card-text text-secondary w-100 m-0">Артикул: {{ product.vendor_code }}</p>
            </div>

            <div class="row px-2 align-items-center">
                <a @click.prevent="addToCart(product)" href="" class="m-0 btn btn-warning text-white border-0 col-10" style="white-space: nowrap;" :id="`addCart${product.id}`">
                    В корзину
                    <i class="fas fa-shopping-cart"></i>
                </a>

                <h5 v-if="authenticated" class="p-0 m-0 col-2">
                    <a class="text-danger ms-3">
                        <i @click.prevent="switchWish(product)" class="far fa-heart" :id="`heart${product.id}`" style="cursor: pointer;"></i>
                    </a>
                </h5>
            </div>
        </div>

    </div>
</template>

<script>
import wishHeart from "./UI/wishHeart.vue";

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
    },

    data() {
        return {
            authenticated: this.$store.state.auth.authenticated,
            productsInCart: this.$root.productsInCart,
            user: this.$store.state.auth.user,
        }
    },

    mounted: function () {
        this.$nextTick(function (){
            if (this.authenticated) {
                this.matchWishlist(this.product)
                // this.checkWishlist(this.product, this.wishlist)
            } else {
                this.stretchCartButton(this.product)
            }
            this.getCartList(this.product)
        })
    },

    methods: {
        stretchCartButton(product) {
            document.getElementById('addCart'+product.id).classList.remove('col-10')
            document.getElementById('addCart'+product.id).classList.add('col-12')
        },
        // checkWishlist(product, wish) {
        //
        //     if (this.wishlist.length !== 0) {
        //         for (let i = 0; i < this.wishlist.length; i++) {
        //             if (this.wishlist[i].product_id === product.id) {
        //
        //                 document.getElementById('heart'+product.id).classList.remove('far')
        //                 document.getElementById('heart'+product.id).classList.add('fas')
        //
        //             }
        //         }
        //     }
        //
        // },

        addToCart(product) {

            document.getElementById('addCart'+product.id).innerText = 'Добавляем'
            let productInCartQty

            let cart = localStorage.getItem('cart')

            let newProduct = [{
                'id': product.id,
                'title': product.title,
                'price': product.price,
                'image_url': product.image_url,
                'vendor_code': product.vendor_code,
                'qty': 1
            }]

            if (!cart) {
                localStorage.setItem('cart', JSON.stringify(newProduct))
                productInCartQty = 1
            } else {
                cart = JSON.parse(cart)

                cart.forEach(productInCart => {
                    if (productInCart.id === product.id) {
                        productInCart.qty = Number(productInCart.qty) + 1
                        newProduct = null
                        productInCartQty = productInCart.qty
                    }
                })
                if (newProduct != null) {
                    productInCartQty = 1
                }
                Array.prototype.push.apply(cart, newProduct)

                localStorage.setItem('cart', JSON.stringify(cart))
                this.$root.getProductsInCart()
            }

            document.getElementById('addCart'+product.id).innerText = 'Добавлено! (' + productInCartQty + 'шт.)'
            document.getElementById('addCart'+product.id).classList.remove('btn-warning')
            document.getElementById('addCart'+product.id).classList.add('btn-success')
        },

        getCartList(product) {
            this.productsInCart?.forEach((productInCart) => {
                if (productInCart.id === product.id) {
                    document.getElementById('addCart'+product.id).innerText = 'Добавлено! (' + productInCart.qty + 'шт.)'
                    document.getElementById('addCart'+product.id).classList.remove('btn-warning')
                    document.getElementById('addCart'+product.id).classList.add('btn-success')
                }
            })
        },

        switchWish(product) {
            let removed = false
            if (this.$parent.wishlist.length === 0) {
                this.storeWish(product)
            } else {
                this.$parent.wishlist.forEach((wish) => {
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
            this.$root.getWishlist()
            this.$parent.getWishlist()
        },

        storeWish(product) {
            document.getElementById('heart'+product.id).classList.remove('far')
            document.getElementById('heart'+product.id).classList.add('fas')
            // console.log(product.id)
            axios.post('/api/wish', {
                user_id: this.user.id,
                product_id: product.id
            })
                .then(response => {
                    // console.log(response);
                    // console.log('added to wishlist');
                })
                .catch(error => {
                    document.getElementById('heart'+product.id).classList.remove('fas')
                    document.getElementById('heart'+product.id).classList.add('far')
                    // console.log(error);
                    // console.log('error add to wishlist');
                })
        },

        removeWish(wish) {
            document.getElementById('heart'+wish.product.id).classList.remove('fas')
            document.getElementById('heart'+wish.product.id).classList.add('far')
            axios.delete('/api/wish/'+wish.id+'/delete')
                .then(response => {
                    // console.log(response);
                    // console.log('removed from wishlist');
                })
                .catch(error => {
                    document.getElementById('heart'+wish.product.id).classList.add('fas')
                    document.getElementById('heart'+wish.product.id).classList.remove('far')
                    // console.log(error);
                    // console.log('error remove from wishlist');
                })
        },

        matchWishlist(product) {
            if (this.$parent.wishlist.length !== 0) {
                for (let i = 0; i < this.$parent.wishlist.length; i++) {
                    if (this.$parent.wishlist[i].product_id === product.id) {
                        document.getElementById('heart'+product.id).classList.remove('far')
                        document.getElementById('heart'+product.id).classList.add('fas')
                    }
                }
            }
        },
    }
}
</script>

<style scoped>

</style>
