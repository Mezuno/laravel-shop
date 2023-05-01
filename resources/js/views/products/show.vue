<template>
    <div>
        <div class="container-xxl mt-5">

            <modal-write-review
                class="modal-window"
                v-if="loaded"
                v-model:writeReview="modalVisibility.writeReview"
                v-model:userReview="userReview"
                v-model:product="product"
                v-model:reviews="reviews"
                v-model:storeReviewData="storeReviewData"
                v-model:userReviewValidationErrors="userReviewValidationErrors"
            />

            <modal-read-reviews
                class="modal-window"
                v-if="loaded"
                v-model:readReview="modalVisibility.readReview"
                v-model:currentOpenReview="currentOpenReview"
                v-model:reviews="reviews"
            />

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
                        <h3>{{ product.title }} - {{ product.company.title }}</h3>

                    </div>
                    <div class="mb-2 fw-semibold h5">{{ product.category.title }}</div>

                    <div v-if="product.tags.length !== 0" class="mb-3">

                        <h6 v-for="(tag, index) in product.tags" class="d-inline" style="width: fit-content">
                            {{ tag.title }}<span v-if="index < product.tags.length-1">/</span>
                        </h6>
                    </div>
                    <p class="flex-grow-1">{{ product.description }}</p>
                    <div class="float-left text-nowrap">
                        <i v-for="star in Math.round(product.avg_rate)" class="fas fa-star rate text-warning"></i>
                        <i v-for="star in 5 - Math.round(product.avg_rate)" class="far fa-star rate text-warning"></i>
                        <a @click="openModalReadReviews(reviews[currentOpenReview.indexInReviews], currentOpenReview.indexInReviews)" class="link-secondary ms-2 cursor-pointer text-decoration-none more" style="border-bottom: dashed 1px; font-size: 0.9rem;">
                            <div class="d-inline">
                                {{ product.reviews_count }}
                                <span v-if="(product.reviews_count > 9) && (product.reviews_count < 21 )">Отзывов</span>
                                <span v-else-if="product.reviews_count.toString().slice(-1) === '1'">Отзыв</span>
                                <span v-else-if="(product.reviews_count.toString().slice(-1) === '2') || (product.reviews_count.toString().slice(-1) === '3') || (product.reviews_count.toString().slice(-1) === '4') ">Отзыва</span>
                                <span v-else>Отзывов</span>
                            </div>
                        </a>
                        <p class="text-secondary mt-2">Артикул: <span class="text-dark">{{ product.vendor_code }}</span></p>

                        <div class="text-wrap" style="font-size: 0.9rem;">
                            <div v-for="(prop, key, index) in product.content">

                                <div v-show="index < 3 || showProperties" class="gradient-parent mb-3">
                                    <div v-show="index === 2 && !showProperties" class="gradient w-100 h-100"></div>
                                    {{ key + ': '}}
                                    <span class="text-secondary">{{ prop }}</span>
                                </div>
                                <p v-if="index === 2 && !showProperties" style="border-bottom: dashed 1px; font-size: 0.9rem;" class="d-inline">
                                    <span @click="showProperties=true" class="h6 more cursor-pointer">
                                        Развернуть характеристики
                                    </span>
                                </p>

                            </div>

                            <p v-if="showProperties" style="border-bottom: dashed 1px; font-size: 0.9rem;" class="d-inline">
                                <span @click="showProperties=false" class="h6 more cursor-pointer">
                                    Скрыть
                                </span>
                            </p>

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
                <div v-if="!userReview && loaded" class="btn btn-outline-dark px-4" style="margin-right: 30px" @click="openModalWriteReviews">
                    Оставить отзыв
                </div>
            </div>

            <carousel :breakpoints="breakpointsReviews" :snapAlign="'start'" :items-to-show="3" v-if="loaded && Object.keys(reviews).length > 0">

                    <slide v-for="(review, index) in reviews" :key="review.id" style="padding: 40px 30px 40px 30px">

                            <div @click="openModalReadReviews(review, index)" class="cart-card p-4 w-100 h-100 d-flex flex-column align-items-start cursor-pointer">
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

                                <div class="">
                                    <div class="float-left">
                                        <h6>{{ review.title }}</h6>
                                    </div>
                                    <div class="float-left">
                                        <p class="mb-0">{{ review.body.slice(0,150) }}<span class="h6" v-if="review.body.slice(0,100).length < review.body.length">... </span></p>
                                        <span class="text-nowrap h6">Читать далее</span>
                                    </div>
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
            <carousel :breakpoints="breakpointsProducts" :mouseDrag="false" :snapAlign="'start'" :items-to-show="4" v-if="loaded && Object.keys(sameProducts).length > 0">
                <slide v-for="sameProduct in sameProducts" :key="sameProduct.id" style="padding: 40px;">
                    <alternative-product-card :identifier="'SameProduct'" :product="sameProduct" class="" :key="sameProduct.id" style="width: 18rem;"/>
                </slide>
                <template #addons>
                    <navigation />
                </template>
            </carousel>

            <h2 v-if="loaded" class="px-4 mt-3 mb-0">Смотрели ранее</h2>
            <carousel :breakpoints="breakpointsProducts" :mouseDrag="false" :snapAlign="'start'" :items-to-show="4" v-if="loaded && Object.keys(previousWatched).length > 0">
                <slide v-for="productWatched in previousWatched" :key="productWatched.id" style="padding: 40px;">
                    <alternative-product-card :identifier="'PreviousWatched'" :product="productWatched" class="" :key="productWatched.id" style="width: 18rem;"/>
                </slide>
                <template #addons>
                    <navigation />
                </template>
            </carousel>

        </div>
    </div>
</template>

<script>
import ModalWindow from "../../components/UI/modals/modalWindow.vue";
import AlternativeProductCard from "../../components/products/AlternativeProductCard.vue";
import ModalReadReviews from "../../components/UI/modals/ModalReadReviews.vue";
import ModalWriteReview from "../../components/UI/modals/ModalWriteReview.vue";

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
        ModalWindow,
        AlternativeProductCard,
        ModalReadReviews,
        ModalWriteReview,
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
            showProperties: false,
            successReview: {},

            userReview: null,
            userReviewValidationErrors: {},
            sameProducts: {},
            modalVisibility: {
                readReview: false,
                writeReview: false,
            },
            currentOpenReview: {
                indexInReviews: 0,
                review: {},
            },

            breakpointsReviews: {
                0: {
                    itemsToShow: 1,
                },
                800: {
                    itemsToShow: 2,
                },
                1300: {
                    itemsToShow: 3,
                },
            },
            breakpointsProducts: {
                0: {
                    itemsToShow: 2,
                },
                800: {
                    itemsToShow: 3,
                },
                1300: {
                    itemsToShow: 4,
                },
            },
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

    },

    watch:{
        $route (from, to) {
            this.loaded = false
            window.scrollTo(0, this.top);
            this.getProduct(from.params.id)
            this.getUserReview()
        }
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


        openModalReadReviews(review, index) {
            this.currentOpenReview.review = review
            this.currentOpenReview.indexInReviews = index
            this.modalVisibility.readReview = true
            document.getElementsByClassName('body-scroll')[0].style.overflowY = 'hidden'
            document.getElementsByClassName('body-scroll')[0].style.paddingRight = '16px'
        },
        openModalWriteReviews() {
            this.modalVisibility.writeReview = true
            document.getElementsByClassName('body-scroll')[0].style.overflowY = 'hidden'
            document.getElementsByClassName('body-scroll')[0].style.paddingRight = '16px'
        },
        hideModal() {
            this.modalVisibility.visibility = false
            this.modalVisibility.writeReview = false
            this.modalVisibility.readReview = false
            document.getElementsByClassName('body-scroll')[0].style.overflowY = ''
            document.getElementsByClassName('body-scroll')[0].style.paddingRight = ''
        },
        nextReview(index) {
            this.currentOpenReview.review = this.reviews[index+1]
            this.currentOpenReview.indexInReviews += 1
        },
        prevReview(index) {
            this.currentOpenReview.review = this.reviews[index-1]
            this.currentOpenReview.indexInReviews -= 1
        },

        getProduct(id) {
            axios.get(`http://localhost:8000/api/products/${id}`).then(response => {
                this.loaded = true
                this.product = response.data.data
                this.product.content = JSON.parse(this.product.content)
                this.getReviews();
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
                    this.modalVisibility = false
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
                        console.log(response.data.data)
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        },

        getSameProducts() {
            let tags = []
            this.product.tags.forEach((tag) => {
                tags.push(tag.id)
            })
            axios.post('/api/products', {
                categories: this.product.category,
                tags: tags,
                page: 1
            }).then(response => {
                this.sameProducts = response.data.data
                this.sameProducts.forEach((product, index) =>{
                    if (product.id === this.product.id) {
                        this.sameProducts.splice(index, 1)
                    }
                })
            });
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
