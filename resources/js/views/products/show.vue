<template>
    <div>
        <div class="container-xxl mt-5 ">

            <div v-if="!loaded" class="d-flex justify-content-center pt-5">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-if="loaded" class="row mb-5">

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

            <carousel :items-to-show="1.5">
                <slide v-for="slide in 10" :key="slide">
                    {{ slide }}
                </slide>

                <template #addons>
                    <navigation />
                    <pagination />
                </template>
            </carousel>

            <div class="reviews row">
                <div v-for="review in reviews" class="col-4">

                    <div class="cart-card p-4 h-100 card-pointer">
                        <div class="d-flex justify-content-between">
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

                        <div>
                            <span class="text-secondary">{{ review.created }}</span>
                        </div>

                        <div>
                            <h6>{{ review.title }}</h6>
                        </div>
                        <div>
                            {{ review.body }}
                        </div>
<!--                        <div>-->
<!--                            достоинства-->
<!--                            <div v-if="review.advantages">-->
<!--                                {{ review.advantages }}-->
<!--                            </div>-->
<!--                            <div v-else>-->
<!--                                достоинства не указаны-->
<!--                            </div>-->
<!--                            недостатки-->
<!--                            <div v-if="review.flaws">-->
<!--                                {{ review.flaws }}-->
<!--                            </div>-->
<!--                            <div v-else>-->
<!--                                недостатки не указаны-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script>

import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

export default {
    name: "products.show",
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    mounted() {
        this.getCategoriesList();
        this.getProduct(this.$router.currentRoute._value.params.id);
        this.getReviews();
        this.getRate();
    },
    data() {
        return {
            product: null,
            categories: [],
            loaded: false,
            reviews: [],
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
            console.log(document.getElementById("bigProductImage"))
        },
        getReviews() {
            axios.post('/api/reviews', {product_id:this.$router.currentRoute._value.params.id})
                .then((response) => {
                    this.reviews = response.data.data
                    console.log(response);

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
        }
    }
}
</script>

<style scoped>

</style>
