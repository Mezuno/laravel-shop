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
                    <img @click="pictureReplacement(product.image_url)" :src="product.image_url" alt="" class="mb-2 w-100" style="cursor: pointer; border-radius: 7px;" >
                    <img @click="pictureReplacement(productImage.url)" v-for="productImage in product.product_images" :src="productImage.url" alt="" class="mb-2 w-100" style="cursor: pointer; border-radius: 7px;">
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
                        <a href="#" class="w-100 m-0 btn btn-outline-dark">В корзину
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <h5 class="p-0 m-0 p-2 pb-0 mb-0 ms-2 text-danger">
                                <div @click.prevent="" class="position-relative">
                                    <i class="far fa-heart heart-far position-absolute" style="display: block; opacity: 1; cursor: pointer;"></i>
                                    <i class="fas fa-heart heart-fas position-absolute" style="display: none; opacity: 0.5; cursor: pointer;"></i>
                                </div>
                        </h5>
                    </div>
                </div>

            </div>

            <carousel :items-to-show="3" v-if="loaded && Object.keys(reviews).length > 0">

                    <slide v-for="review in reviews" :key="review.id" style="padding-left: 30px; padding-right: 30px; padding-top: 40px;">

                            <div class="cart-card p-4 h-100 card-pointer d-flex flex-column align-items-start">
                                <div class="d-flex justify-content-between w-100">
                                    <div>
                                        <h5>{{ review.user.name }}</h5>
                                    </div>
                                    <div>
                                        <i class="fas fa-star rate d-none text-warning"></i>
                                        <i class="far fa-star rate d-none text-warning"></i>
                                        <i class="far fa-star rate d-none text-warning"></i>
                                        <i class="far fa-star rate d-none text-warning"></i>
                                        <i class="far fa-star rate d-none text-warning"></i>
                                    </div>
                                </div>

                                <div class="float-left">
                                    <span class="text-secondary">{{ review.created }}</span>
                                </div>

                                <div class="float-left">
                                    <h6>{{ review.title }}</h6>
                                </div>
                                <div class="float-left">
                                    {{ review.body }}
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
                        <navigation />
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

            <div v-if="authenticated && userReview && loaded" class="cart-card p-4 h-100 m-4 col-6">
                <div class="d-flex flex-column">
                    <h3>Ваш отзыв</h3>
                    <div>
                        <p class="fw-bold mb-0">Заголовок</p>
                        <p>{{ userReview.title }}</p>
                    </div>
<!--                    <i v-for="star in userReview.rate" class="far fa-star rate d-none text-warning"></i>-->
                    <div class="mb-2">
                        <p class="fw-bold mb-0">Оценка</p>
                        <p>{{ userReview.rate }}</p>
                    </div>
                    <div class="mb-2">
                        <p class="fw-bold mb-0">Приемущества</p>
                        <p>{{ userReview.advantages }}</p>
                    </div>
                    <div class="mb-2">
                        <p class="fw-bold mb-0">Недостатки</p>
                        <p>{{ userReview.flaws }}</p>
                    </div>
                    <div class="mb-2">
                        <p class="fw-bold mb-0">Текст отзыва</p>
                        <p>{{ userReview.body }}</p>
                    </div>
                    <div class="mb-2">
                        <p class="fw-bold mb-0">Дата</p>
                        <p>{{ userReview.created_at }}</p>
                    </div>
                    <div class="mb-2">
                        <p class="fw-bold mb-0">Статус</p>
                        <p v-if="userReview.confirmed_at">Отзыв подтвержден {{ userReview.confirmed_at }}</p>
                        <p v-if="!userReview.confirmed_at">Ваш отзыв еще не проверен</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

import { Carousel, Slide, Navigation } from 'vue3-carousel'

export default {
    name: "products.show",

    components: {
        Carousel,
        Slide,
        Navigation,
    },

    mounted() {
        this.getCategoriesList();
        this.getProduct(this.$router.currentRoute._value.params.id);
        this.getReviews();
        this.getRate();
        if (this.$store.state.auth.authenticated) {
            this.getUserReview();
        }
    },

    data() {
        return {
            product: null,
            categories: [],
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
            authenticated: this.$store.state.auth.authenticated,
            successReview: {},
            userReview: {},
        }
    },

    methods: {
        getProduct(id) {
            axios.get(`http://localhost:8000/api/products/${id}`).then(response => {
                this.product = response.data.data
                this.loaded = true
            });
        },
        getCategoriesList() {
            axios.get('http://localhost:8000/api/categories').then(response => {
                this.categories = response.data.data
            });
        },
        pictureReplacement(uri) {
            document.getElementById("bigProductImage").src = uri;
            // console.log(document.getElementById("bigProductImage"))
        },
        getReviews() {
            axios.post('/api/reviews', {product_id:this.$router.currentRoute._value.params.id})
                .then((response) => {
                    this.reviews = response.data.data
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
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getUserReview() {
            axios.post('/api/review/check', {
                user_id: this.$store.state.auth.user.id,
                product_id: this.$router.currentRoute._value.params.id,
            })
                .then((response) => {
                    if (response.data) {
                        this.userReview = response.data[0]
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        getRate() {
            setTimeout(() => {
                let rate = document.getElementsByClassName("rate")
                let counter = 0
                this.reviews.forEach(review => {
                    for (let i = 0; i < review.rate; i++) {
                        rate[i+counter*5].classList.remove('far')
                        rate[i+counter*5].classList.add('fas')
                    }
                    for (let i = 0; i < 5; i++) {
                        rate[i+counter*5].classList.remove('d-none')
                    }
                    counter++
                })
            }, 2000)
        },

    }
}
</script>

<style scoped>

</style>
