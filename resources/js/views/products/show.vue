<template>
    <div>
        <div class="container-xxl mt-5">

            <modal-window v-if="loaded" v-model:openModal="modalVisibility" style="z-index: 1000">
                <div class="content-in-modal">
                    <div v-if="authenticated && !userReview && loaded" class="p-4">
                        <div class="d-flex flex-column">
                            <div class="d-flex">
                                <h3>Оставьте свой отзыв к товару «{{ product.title }}»</h3>
                                <p class="alert alert-info p-1 ms-4 px-2" v-if="Object.keys(reviews).length <= 0">Будьте первым!</p>
                            </div>

                            <div class="col-12" v-if="Object.keys(userReviewValidationErrors).length > 0">
                                <div class="alert alert-danger">
                                    <div v-for="(value, key) in userReviewValidationErrors" :key="key">{{ value[0] }}</div>
                                </div>
                            </div>

                            <div class="input-group mb-2">
                                <input type="text" class="form-control w-100" placeholder="Заголовок" v-model="storeReviewData.title">
                            </div>
                            <div @mouseout="outMouseOver">
                                <h4>
                                    <i v-for="i in 5" @mouseover="onMouseOver(i)" @click="changeReviewDataRate(i)" class="far fa-star text-warning cursor-pointer" :id="`rate-in-modal${i-1}`"></i>
                                </h4>
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

                            <button class="btn btn-primary" @click="storeReview()">Оставить отзыв</button>

                        </div>
                    </div>
                </div>
            </modal-window>

            <div v-if="!loaded" class="d-flex justify-content-center pt-5">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-if="loaded" class="row mb-5" style="padding-left: 30px; padding-right: 30px;">

                <div class="col-1">
                    <img @mouseover="pictureReplacement(product.image_url, 0)" :src="product.image_url" alt="" class="mb-2 w-100 small-product-img current-small-product-img" style="cursor: pointer; border-radius: 7px;" >
                    <img @mouseover="pictureReplacement(productImage.url, index+1)" v-for="(productImage, index) in product.product_images" :src="productImage.url" alt="" class="mb-2 w-100 small-product-img" style="cursor: pointer; border-radius: 7px;">
                </div>

                <div class="col-4">
                    <img :src="product.image_url" class="figure-img w-100 show-product-img" alt="" id="bigProductImage">
                </div>

                <div class="col-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>{{ product.title }}</h3>
                    </div>
                    <p class="flex-grow-1">{{ product.description }}</p>
                    <div class="float-left text-nowrap">
                        <i v-for="star in Math.round(product.avg_rate)" class="fas fa-star rate text-warning"></i>
                        <i v-for="star in 5 - Math.round(product.avg_rate)" class="far fa-star rate text-warning"></i>
                        <a class="link-secondary ms-2 cursor-pointer text-decoration-none" style="border-bottom: dashed 1px; font-size: 0.9rem;">
                            <div class="d-inline">{{ product.reviews_count }}
                                <span class="1ke" v-if="(product.reviews_count > 9) && (product.reviews_count < 21 )">Отзывов</span>
                                <span class="2ke" v-else-if="product.reviews_count.toString().slice(-1) === '1'">Отзыв</span>
                                <span class="3ke" v-else-if="product.reviews_count.toString().slice(-1) === '2' || '3' || '4' ">Отзыва</span>
                                <span class="4ke" v-else>Отзывов</span>
                            </div>
                        </a>
                        <p class="text-secondary mt-2">Артикул: <span class="text-dark">{{ product.vendor_code }}</span></p>

                        <div class="text-wrap" style="font-size: 0.9rem;">
                            <p v-for="(prop, index) in product.content">{{ index + ': '}} <span class="text-secondary">{{ prop }}</span></p>
                        </div>

                    </div>
                </div>

                <div class="card border border-0 cart-card col-3 h-100 p-4">

                    <div class="d-flex justify-content-between">
                        <h3 class="card-text text-dark fw-bold">
                            {{ product.price.slice(0, -3) }}<span class="ms-2 d-inline text-dark">₽</span>
                        </h3>
                        <h4 class="ps-3 m-0 text-danger">
                            <i @click.prevent="switchWish(product, 'addToWishlistHeart')" id="addToWishlistHeart" class="far fa-heart heart-fas" style="cursor: pointer;"></i>
                        </h4>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a @click.prevent="addToCart(product, 'addToCartButton')" class="w-100 m-0 btn btn-outline-dark" id="addToCartButton">
                            В корзину
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex" style="margin-left: 25px" v-if="loaded && Object.keys(reviews).length > 0">
                        <h2>Отзывы</h2>
                        <span class="ms-1 h5">{{ product.reviews_count }}</span>
                    </div>
                    <div v-if="loaded && Object.keys(reviews).length > 0" class="d-flex align-items-center" style="margin-left: 25px">
                        <h3>{{ product.avg_rate }}</h3>
                        <div class="float-left text-nowrap ms-2">
                            <i v-for="star in Math.round(product.avg_rate)" class="fas fa-star rate text-warning"></i>
                            <i v-for="star in 5 - Math.round(product.avg_rate)" class="far fa-star rate text-warning"></i>
                        </div>
                    </div>
                </div>
                <div v-if="authenticated && !userReview && loaded" class="btn btn-outline-dark px-4" style="margin-right: 30px" @click="openModal">
                    Оставить отзыв
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
                                    <p class="mb-0">{{ review.body.slice(0,150) }}<span class="h6" v-if="review.body.slice(0,100).length < review.body.length">... </span></p>
                                    <span class="text-nowrap h6">Читать далее</span>
                                </div>
                            </div>
                    </slide>

                    <template #addons>
                        <navigation v-if="Object.keys(reviews).length > 3"/>
                    </template>
            </carousel>

            <div v-else-if="loaded" class="cart-card p-4 h-100 m-4 col-6">
                Отзывов пока нету
            </div>

            <div v-if="Object.keys(successReview).length > 0" class="m-4 alert alert-success col-4">
                Ваш отзыв успешно отправлен! Публикация отзыва произойдет после успешной модерции.<br>
            </div>

            <h2 v-if="loaded" class="px-4 mt-3 mb-0">Похожие товары</h2>
            <carousel :snapAlign="'start'" :items-to-show="4.8" v-if="loaded && Object.keys(sameProducts).length > 0">
                <slide v-for="sameProduct in sameProducts" :key="sameProduct.id" style="padding-top: 40px;">
                    <product-card-in-catalog :identifier="'SameProduct'" :product="sameProduct" class="card product-card-hover p-0 h-100" :key="sameProduct.id" style="width: 15rem;"/>
                </slide>
                <template #addons>
                    <navigation />
                </template>
            </carousel>

            <h2 v-if="loaded" class="px-4 mt-3 mb-0">Смотрели ранее</h2>
            <carousel :snapAlign="'start'" :items-to-show="4.8" v-if="loaded && Object.keys(previousWatched).length > 0">
                <slide v-for="productWatched in previousWatched" :key="productWatched.id" style="padding-top: 40px;">
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
import modalWindow from "../../components/UI/modalWindow.vue";

import { Carousel, Slide, Navigation } from 'vue3-carousel'
import {mapActions} from "vuex";
import cartMixin from "@/mixins/cartMixin.vue";
import wishMixin from "@/mixins/wishMixin.vue";

export default {
    name: "products.show",

    mixins: [cartMixin, wishMixin],

    components: {
        Carousel,
        Slide,
        Navigation,
        ProductCardInCatalog,
        modalWindow,
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
                rate: 0,
                body: "",
                flaws: "",
                advantages: "",
            },
            successReview: {},
            userReview: null,
            userReviewValidationErrors: {},
            sameProducts: {},
            modalVisibility: false,
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
        previousWatched: function () {
            return this.$store.state.previousWatched.products
        },
    },

    mounted() {
        this.getProduct(this.$router.currentRoute._value.params.id);
        this.getReviews();
    },

    unmounted() {
        if (this.authenticated) {
            this.syncWishlist()
        }
    },

    methods: {
        ...mapActions({
            syncWishlist:"auth/syncWishlist",
            removeItemFromWishlist:"auth/removeItemFromWishlist",
            addItemToWishlist:"auth/addItemToWishlist",
            addToCartProducts:"cartProducts/addToCartProducts",
            addItemToPreviousWatched:"previousWatched/addItemToPreviousWatched",
        }),

        getProduct(id) {
            axios.get(`http://localhost:8000/api/products/${id}`).then(response => {
                this.loaded = true
                this.product = response.data.data
                this.product.content = JSON.parse(this.product.content)
                this.getSameProducts()
            })
            .catch(({response}) => {
                if (response.status === 404) {
                    this.$router.push({name:'404'})
                }
            })
            .finally(() => {
                this.matchCartList(this.product, 'addToCartButton')
                this.addItemToPreviousWatched(this.product)
                if (this.authenticated) {
                    this.matchWishlist(this.product, 'addToWishlistHeart')
                    this.getUserReview();
                }
            });
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


        openModal() {
            this.modalVisibility = true
        },

        changeReviewDataRate(rate) {
            for (let i = 0; i < rate; i++) {
                this.switchRateInModal(i, 'far')
            }
            this.storeReviewData.rate = rate
            this.outMouseOver()
        },

        onMouseOver(id) {
            for (let i = 0; i < id; i++) {
                this.switchRateInModal(i, 'far')
            }
        },

        outMouseOver() {
            for (let i = this.storeReviewData.rate; i < 5; i++) {
                this.switchRateInModal(i, 'fas')
            }
        },


        // вроде костыли, заменить на refs итп при возможности

        switchRateInModal(i, state) {
            document.getElementById('rate-in-modal'+i).classList.remove(state)
            if (state === 'far') {
                document.getElementById('rate-in-modal'+i).classList.add('fas')
            } else if (state === 'fas') {
                document.getElementById('rate-in-modal'+i).classList.add('far')
            }
        },
    }
}
</script>

<style scoped>

</style>
