<template>
    <div>
        <div class="container-xxl mt-5">
            <div class="d-flex justify-content-center mb-5">

                <div id="carouselExampleCaptions" class="carousel slide w-100 d-flex " data-bs-ride="carousel" data-bs-interval="3000" >
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a class="sliderLink" href="">
                                <div class="sliderBlackoutDiv">
                                    <img src="../../../../storage/app/public/images/images-for-slider/1300x300-(red).png" class="d-block w-100 sliderBlackoutImg" alt="...">
                                </div>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a class="sliderLink" href="">
                                <div class="sliderBlackoutDiv">
                                    <img src="../../../../storage/app/public/images/images-for-slider/1300x300-(blue).png" class="d-block w-100 sliderBlackoutImg" alt="...">
                                </div>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a class="sliderLink" href="">
                                <div class="sliderBlackoutDiv">
                                    <img src="../../../../storage/app/public/images/images-for-slider/1300x300-(green).png" class="d-block w-100 sliderBlackoutImg" alt="...">
                                </div>
                            </a>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Предыдущий</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Следующий</span>
                    </button>
                </div>

            </div>

            <div class="d-flex flex-wrap justify-content-between mb-5 banners">

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(blue).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(blue).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(blue).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(blue).png" alt="...">
                </div>

            </div>

            <div class="d-flex flex-wrap justify-content-between mb-5 banners">

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(red).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(red).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(red).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(red).png" alt="...">
                </div>


            </div>

            <h2 class="mt-4 mb-4">Популярные товары</h2>

            <div v-show="!loading"  class="row">
                <product-card v-for="product in products" :key="product.id" :identifier="'Main'" :product="product" class="col-3 mb-5 px-3"/>
            </div>

            <div class="d-flex flex-wrap justify-content-between mb-5 banners">

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(green).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(green).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(green).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(green).png" alt="...">
                </div>


            </div>

            <div class="d-flex flex-wrap justify-content-between mb-5 banners">

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(yellow).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(yellow).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(yellow).png" alt="...">
                </div>

                <div class="banner col-4 cursor-pointer">
                    <div class="banner-background"></div>
                    <img class="banner-image" width="300" height="180" src="../../../../storage/app/public/images/images-for-banners/300x180-(yellow).png" alt="...">
                </div>


            </div>

        </div>
    </div>
</template>

<script>
import ProductCard from "@/components/products/ProductCard.vue";

import { Carousel, Slide, Navigation } from 'vue3-carousel'

export default {
    name: "Index",

    components: {
        ProductCard,
        Carousel,
        Slide,
        Navigation,
    },

    data() {
        return {
            products: [],
            loading: null,
        }
    },

    mounted() {
        this.getProducts()
    },

    methods: {
        getProducts() {
            this.loading = true
            axios.get('/api/products/main', {Accept: 'application/json'})
                .then((response) => {
                    this.products = response.data.data
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
}
</script>

<style scoped>

</style>
