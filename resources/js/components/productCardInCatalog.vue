<template>
    <div class="all">
        <img :src="product.image_url" class="card-img-top" width="200px" alt="">

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
            <div class="d-flex justify-content-between flex-grow-1 mb-3">
                <h5 class="card-text text-secondary fw-bold w-100 m-0">{{ product.price.slice(0, -3) }}
                    <h6 class="ms-1 d-inline"><i class="fas fa-ruble-sign"></i></h6></h5>
                <p class="card-text text-secondary w-100 m-0">Артикул: {{ product.vendor_code }}</p>
            </div>
            <div class="row px-2">
                <a @click.prevent="addToCart(product)" href="" class=" m-0 btn btn-warning text-white border-0 col-10" style="white-space: nowrap;" :id="`addCart${product.id}`">
                    В корзину
                    <i class="fas fa-shopping-cart"></i>
                </a>

                <h5 v-if="this.$root.token" class="p-0 m-0 ps-1 col-2">
                    <a class="p-2 pb-0 mb-0 text-danger ms-2">

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

        }
    },
    mounted: function () {
        this.$nextTick(function (){
            if (this.$root.token) {
                this.getWishlist(this.product)
                // this.checkWishlist(this.product, this.wishlist)
            } else {
                this.stretchCartButton(this.product)
            }
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
            } else {
                cart = JSON.parse(cart)

                cart.forEach(productInCart => {
                    if (productInCart.id === product.id) {
                        productInCart.qty = Number(productInCart.qty) + 1
                        newProduct = null
                    }
                })
                Array.prototype.push.apply(cart, newProduct)

                localStorage.setItem('cart', JSON.stringify(cart))
                this.$root.getProductsInCart()
            }
        },

        switchWish(product) {
            let removed = false
            if (this.wishlist.length === 0) {
                this.storeWish(product)
            } else {
                for (let i = 0; i < this.wishlist.length; i++) {
                    if (this.wishlist[i].product_id === product.id) {
                        this.removeWish(this.wishlist[i])
                        removed = true
                        break
                    }
                }
                if (!removed) {
                    this.storeWish(product)
                }
            }
            this.getWishlist()
        },
        storeWish(product) {
            // console.log(product.id)
            axios.post('/api/wish', {
                user_id: this.$root.user.id,
                product_id: product.id
            })
                .then(response => {
                    document.getElementById('heart'+product.id).classList.remove('far')
                    document.getElementById('heart'+product.id).classList.add('fas')
                    // console.log('added to wishlist');
                })
                .catch(error => {
                    // console.log(error);
                })
        },
        removeWish(wish) {
            axios.delete('/api/wish/'+wish.id+'/delete')
                .then(response => {
                    // console.log(response);
                    document.getElementById('heart'+wish.product.id).classList.remove('fas')
                    document.getElementById('heart'+wish.product.id).classList.add('far')
                    document.getElementById('x'+wish.id).remove()
                })
                .catch(error => {
                    // console.log(error);
                })
        },
        getWishlist(product) {
            axios.post('/api/wishlist', {
                user_id: this.$root.user.id
            })
                .then(response => {
                    this.wishlist = response.data.data
                    if (this.wishlist.length !== 0) {
                        for (let i = 0; i < this.wishlist.length; i++) {
                            if (this.wishlist[i].product_id === product.id) {
                                document.getElementById('heart'+product.id).classList.remove('far')
                                document.getElementById('heart'+product.id).classList.add('fas')
                            }
                        }
                    }

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
