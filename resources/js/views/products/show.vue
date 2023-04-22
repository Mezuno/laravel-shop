<template>
    <div>
        <div class="container-xxl mt-5" >

            <div v-if="!loaded" class="d-flex justify-content-center pt-5">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-if="loaded" class="row mb-5" style="padding-left: 30px; padding-right: 30px;">

                <div class="col-1">
                    <img @click="pictureReplacement(product.image_url, 0)" :src="product.image_url" alt="" class="mb-2 w-100 small-product-img current-small-product-img" style="cursor: pointer; border-radius: 7px;" >
                    <img @click="pictureReplacement(productImage.url, index+1)" v-for="(productImage, index) in product.product_images" :src="productImage.url" alt="" class="mb-2 w-100 small-product-img" style="cursor: pointer; border-radius: 7px;">
                </div>

                <div class="col-4">
                    <img :src="product.image_url" class="figure-img w-100 show-product-img" alt="" id="bigProductImage">
                </div>

                <div class="col-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>{{ product.title }}</h3>
                    </div>
                    <p class="flex-grow-1">{{ product.description }}</p>
                </div>

                <div class="card border border-0 cart-card col-3 h-100 p-4">

                    <h5 class="card-text text-dark fw-bold">{{ product.price.slice(0, -3) }}<h5
                        class="ms-2 d-inline text-dark">₽</h5></h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <a @click.prevent="addToCart(product)" class="w-100 m-0 btn btn-outline-dark" id="addToCartButton">
                            В корзину
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <h5 class="ps-3 m-0 text-danger" v-if="authenticated">
                            <i @click.prevent="switchWish(product)" id="addToWishlistHeart" class="far fa-heart heart-fas" style="cursor: pointer;"></i>
                        </h5>
                    </div>
                </div>

            </div>

            <div class="d-flex" style="margin-left: 25px" v-if="loaded && Object.keys(reviews).length > 0">
                <h2>Отзывы</h2>
                <span class="ms-1 h5">{{ product.reviews_count }}</span>
            </div>

            <div v-if="loaded && Object.keys(reviews).length > 0" class="d-flex align-items-center" style="margin-left: 25px">
                <h3>{{ product.avg_rate }}</h3>
                <div class="float-left text-nowrap ms-2">
                    <i v-for="star in Math.ceil(product.avg_rate)" class="fas fa-star rate text-warning"></i>
                    <i v-for="star in 5 - Math.ceil(product.avg_rate)" class="far fa-star rate text-warning"></i>
                </div>
            </div>

            <carousel :snapAlign="'start'" :items-to-show="3" v-if="loaded && Object.keys(reviews).length > 0">

                    <slide v-for="review in reviews" :key="review.id" style="padding: 40px 30px 40px 30px">

                            <div class="cart-card p-4 w-100 h-100 card-pointer d-flex flex-column align-items-start">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <h5>{{ review.user.name }} <span class="h6 text-secondary text-nowrap" v-if="review.user.id === this.$store.state.auth.user.id">(Ваш отзыв)</span></h5>
                                    </div>
                                    <div class="float-left text-nowrap" v-if="loaded">
                                        <i v-for="star in review.rate" class="fas fa-star rate text-warning"></i>
                                        <i v-for="star in 5 - review.rate" class="far fa-star rate text-warning"></i>
                                    </div>
                                </div>

                                <div class="float-left mb-2">
                                    <span class="text-secondary">{{ review.created }}</span>
                                </div>

                                <div class="float-left">
                                    <h6>{{ review.title }}</h6>
                                </div>
                                <div class="float-left">
                                    <p>{{ review.body.slice(0,150) }}<span class="h6" v-if="review.body.slice(0,100).length < review.body.length">... Читать далее</span></p>
                                </div>
<!--                                <div>-->
<!--                                    достоинства-->
<!--                                    <div v-if="review.advantages">-->
<!--                                        {{ review.advantages }}-->
<!--                                    </div>-->
<!--                                    <div v-else>-->
<!--                                        достоинства не указаны-->
<!--                                    </div>-->
<!--                                    недостатки-->
<!--                                    <div v-if="review.flaws">-->
<!--                                        {{ review.flaws }}-->
<!--                                    </div>-->
<!--                                    <div v-else>-->
<!--                                        недостатки не указаны-->
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                    </slide>

                    <template #addons>
                        <navigation v-if="Object.keys(reviews).length > 3"/>
                    </template>
            </carousel>

            <div v-else-if="loaded" class="cart-card p-4 h-100 m-4 col-6">
                Отзывов пока нету (и слова нету нету ;с)
            </div>


            <div v-if="Object.keys(successReview).length > 0" class="m-4 alert alert-success col-4">
                Ваш отзыв успешно отправлен! Публикация отзыва произойдет после успешной модерции.<br>
            </div>

<!--            <div v-if="Object.keys(successReview).length > 0" class="m-4 alert alert-warning">-->
<!--                <b>Остальная дата, приходящая с успешным оформлением(можно дополнить окно успешного оформления)</b><br>-->
<!--                <pre>{{ successReview }}</pre>-->
<!--            </div>-->


            <div v-if="authenticated && !userReview && loaded" class="cart-card p-4 h-100 m-4 col-6">
                <div class="d-flex flex-column">
                    <div class="d-flex">
                        <h3>Оставьте свой отзыв!</h3>
                        <p class="alert alert-info p-1 ms-4 px-2" v-if="Object.keys(reviews).length <= 0">Будьте первым!</p>
                    </div>

                    <div class="col-12" v-if="Object.keys(userReviewValidationErrors).length > 0">
                        <div class="alert alert-danger">
                            <div v-for="(value, key) in userReviewValidationErrors" :key="key">{{ value[0] }}</div>
                        </div>
                    </div>

                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="Заголовок" v-model="storeReviewData.title">
                    </div>
                    <div class="input-group mb-2">
                        <input type="number" class="form-control" placeholder="Оценка" v-model="storeReviewData.rate">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="Достоинства" v-model="storeReviewData.advantages">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="Недостатки" v-model="storeReviewData.flaws">
                    </div>
                    <div class="input-group mb-2">
                        <textarea type="text" class="form-control" placeholder="Текст отзыва" v-model="storeReviewData.body"></textarea>
                    </div>

                    <button class="btn btn-primary col-3" @click="storeReview()">Оставить отзыв</button>

                </div>
            </div>

<!--            <div v-if="authenticated && userReview && loaded" class="cart-card p-4 h-100 m-4 col-6">-->
<!--                <div class="d-flex flex-column">-->
<!--                    <h3>Ваш отзыв</h3>-->
<!--                    <div>-->
<!--                        <p class="fw-bold mb-0">Заголовок</p>-->
<!--                        <p>{{ userReview.title }}</p>-->
<!--                    </div>-->
<!--&lt;!&ndash;                    <i v-for="star in userReview.rate" class="far fa-star rate d-none text-warning"></i>&ndash;&gt;-->
<!--                    <div class="mb-2">-->
<!--                        <p class="fw-bold mb-0">Оценка</p>-->
<!--                        <p>{{ userReview.rate }}</p>-->
<!--                    </div>-->
<!--                    <div class="mb-2">-->
<!--                        <p class="fw-bold mb-0">Приемущества</p>-->
<!--                        <p>{{ userReview.advantages }}</p>-->
<!--                    </div>-->
<!--                    <div class="mb-2">-->
<!--                        <p class="fw-bold mb-0">Недостатки</p>-->
<!--                        <p>{{ userReview.flaws }}</p>-->
<!--                    </div>-->
<!--                    <div class="mb-2">-->
<!--                        <p class="fw-bold mb-0">Текст отзыва</p>-->
<!--                        <p>{{ userReview.body }}</p>-->
<!--                    </div>-->
<!--                    <div class="mb-2">-->
<!--                        <p class="fw-bold mb-0">Дата</p>-->
<!--                        <p>{{ userReview.created }}</p>-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <p class="fw-bold mb-2">Статус</p>-->
<!--                        <p v-if="userReview.confirmed" class="alert alert-success">Отзыв подтвержден {{ userReview.confirmed }}</p>-->
<!--                        <p v-if="!userReview.confirmed" class="alert alert-warning">Ваш отзыв еще не проверен</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

            <h2 v-if="loaded">Похожие товары</h2>
            <carousel :snapAlign="'start'" :wrapAround="true" :items-to-show="4" v-if="loaded && Object.keys(sameProducts).length > 0">
                <slide v-for="sameProduct in sameProducts" :key="sameProduct.id" style="padding-left: 30px; padding-right: 30px; padding-top: 40px;">
                    <product-card-in-catalog :identifier="'SameProduct'" :product="sameProduct" class="card product-card-hover p-0 h-100" :key="sameProduct.id" style="width: 15rem;"/>
                </slide>
                <template #addons>
                    <navigation />
                </template>
            </carousel>

            <h2 v-if="loaded">Смотрели ранее</h2>
            <carousel :snapAlign="'start'" :items-to-show="4" v-if="loaded && Object.keys(previousWatched).length > 0">
                <slide v-for="productWatched in previousWatched" :key="productWatched.id" style="padding-left: 30px; padding-right: 30px; padding-top: 40px;">
                    <product-card-in-catalog :identifier="'PreviousWatched'" :product="productWatched" class="card product-card-hover p-0 h-100" :key="productWatched.id" style="width: 15rem;"/>
                </slide>
                <template #addons>
                    <navigation />
                </template>
            </carousel>
        </div>
    </div>
</template>

<script>
import ProductCardInCatalog from "../../components/productCardInCatalog.vue";

import { Carousel, Slide, Navigation } from 'vue3-carousel'
import {mapActions} from "vuex";

export default {
    name: "products.show",

    components: {
        Carousel,
        Slide,
        Navigation,
    },

    data() {
        return {
            product: null,
            loaded: false,
            reviews: [],
            storeReviewData: {
                user_id: this.$store.state.auth.user.id,
                product_id: this.$router.currentRoute._value.params.id,
                title: "",
                rate: null,
                body: "",
                flaws: "",
                advantages: "",
            },
            successReview: {},
            userReview: null,
            userReviewValidationErrors: {},
            sameProducts: {},
            previousWatched: {},
        }
    },

    computed: {
        authenticated: function () {
            return this.$store.state.auth.authenticated
        },
        productsInCart: function () {
            return this.$store.state.cartProducts.products
        },
        wishlist: function () {
            return this.$store.state.auth.wishlist
        },
        user: function () {
            return this.$store.state.auth.user
        },
    },

    mounted() {
        this.getProduct(this.$router.currentRoute._value.params.id);
        this.getReviews();
    },

    unmounted() {
        this.syncWishlist()
    },

    methods: {
        ...mapActions({
            syncWishlist:"auth/syncWishlist",
            removeItemFromWishlist:"auth/removeItemFromWishlist",
            addItemToWishlist:"auth/addItemToWishlist",
            addToCartProducts:"cartProducts/addToCartProducts",
        }),

        getProduct(id) {
            axios.get(`http://localhost:8000/api/products/${id}`).then(response => {
                this.product = response.data.data
                this.loaded = true
                this.getSameProducts()
                setTimeout(() => {
                    this.getCartList(this.product)
                    this.matchWishlist(this.product)
                    this.setPreviousWatched(this.product)
                    if (this.authenticated) {
                        this.getUserReview();
                    }
                }, 1000);
            });
        },

        setPreviousWatched(product) {
            let previousWatched = []
            previousWatched = localStorage.getItem('previous-watched')

            if (!previousWatched) {
                localStorage.setItem('previous-watched', JSON.stringify([product]))
            } else {
                previousWatched = JSON.parse(previousWatched)

                previousWatched.forEach((productInPreviousWatched, index) => {
                    if (productInPreviousWatched.id === product.id) {
                        previousWatched.splice(index, 1)
                    }
                })

                previousWatched.unshift(product);

                localStorage.setItem('previous-watched', JSON.stringify(previousWatched))
            }

            this.previousWatched = JSON.parse(localStorage.getItem('previous-watched'))
        },

        pictureReplacement(uri, index) {
            document.getElementById("bigProductImage").src = uri;
            for (let i = 0; i < this.product.product_images.length+1; i++) {
                document.getElementsByClassName('small-product-img')[i].classList.remove('current-small-product-img')
            }
            document.getElementsByClassName('small-product-img')[index].classList.add('current-small-product-img')
            // console.log(document.getElementById("bigProductImage"))
        },

        getReviews() {
            axios.post('/api/reviews', {product_id:this.$router.currentRoute._value.params.id})
                .then((response) => {
                    this.reviews = response.data.data
                    this.reviews.forEach((review, index) =>{
                        if (review.user.id === this.$store.state.auth.user.id) {
                            this.reviews.splice(index, 1)
                            this.reviews.unshift(review)
                        }
                    })
                })
                .catch((error) => {
                    console.log(error);
                })
        },

        storeReview() {
            axios.post('/api/review', this.storeReviewData)
                .then((response) => {
                    this.successReview = response.data.data
                    this.storeReviewData = {}
                    this.userReview = response.data.data
                    this.userReviewValidationErrors = {}
                })
                .catch(({response})=>{
                    if(response.status===422){
                        this.userReviewValidationErrors = response.data.errors
                    } else{
                        this.userReviewValidationErrors = {}
                        alert(response.data.message)
                    }
                })
        },

        getUserReview() {
            axios.post('/api/review/check', {
                user_id: this.user.id,
                product_id: this.$router.currentRoute._value.params.id,
            })
                .then((response) => {
                    if (response.data.data) {
                        this.userReview = response.data.data
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        },

        getSameProducts() {
            axios.post('/api/products', {
                categories: this.product.category,
                // tags: this.product.tags,
                page: 1
            }).then(response => {
                this.sameProducts = response.data.data
            });
        },

        addToCart(product) {
            document.getElementById('addToCartButton').innerText = 'Добавляем'

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

            this.switchAddToCartButtonClasses(productInCartQty)
        },

        getCartList(product) {
            if (this.productsInCart && this.productsInCart?.length > 0) {
                this.productsInCart?.forEach((productInCart) => {
                    if (productInCart.id === product.id) {
                        this.switchAddToCartButtonClasses(productInCart.qty)
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
                        return {};
                    }
                })

                if (!removed) {
                    this.storeWish(product)
                }
            }
        },

        storeWish(product) {
            this.switchHeartClasses()

            this.addItemToWishlist({
                'user_id': this.user.id,
                'product_id': product.id,
                'product': product,
            })
        },

        removeWish(wish) {
            this.switchHeartClasses()
            this.removeItemFromWishlist(wish)
        },

        matchWishlist(product) {
            if (this.wishlist.length !== 0) {
                for (let i = 0; i < this.wishlist.length; i++) {
                    if (this.wishlist[i].product_id === product.id) {
                        this.switchHeartClasses()
                    }
                }
            }
        },


        // вроде костыли, заменить на refs итп при возможности

        switchAddToCartButtonClasses(qty) {
            document.getElementById('addToCartButton').innerText = 'Добавлено! (' + qty + 'шт.)'
            document.getElementById('addToCartButton').classList.remove('btn-outline-dark')
            document.getElementById('addToCartButton').classList.add('btn-dark')
        },

        switchHeartClasses() {
            if (document.getElementById('addToWishlistHeart').classList.contains('fas')) {
                document.getElementById('addToWishlistHeart').classList.add('far')
                document.getElementById('addToWishlistHeart').classList.remove('fas')
            } else {
                document.getElementById('addToWishlistHeart').classList.add('fas')
                document.getElementById('addToWishlistHeart').classList.remove('far')
            }
        }
    }
}
</script>

<style scoped>

</style>
