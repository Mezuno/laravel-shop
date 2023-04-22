<template>
    <div>
        <div class="container-xxl mt-5">
            <div class="d-flex justify-content-center mb-5">

                <div id="carouselExampleCaptions" class="carousel slide w-100 d-flex " data-bs-ride="carousel" data-bs-interval="3000" style="height: 300px; ">
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

            <div class="d-flex flex-wrap justify-content-between">

                <div class="hoverDiv overflow-hidden mb-3">
                    <div class="card imgHover border-0" style="width: 19rem;">
                        <a class="hoverLink" href="">
                            <div class="blackoutDiv">
                                <img class="cropped-img blackoutImg" width="286" height="180" src="../../../../storage/app/public/images/images-for-slider/for-slider.jpg" alt="Card image">
                            </div>
                        </a>
                    </div>
                </div>
                <div class="hoverDiv overflow-hidden mb-3">
                    <div class="card imgHover border-0" style="width: 19rem;">
                        <a class="hoverLink" href="">
                            <div class="blackoutDiv">
                                <img class="cropped-img blackoutImg" width="286" height="180" src="../../../../storage/app/public/images/images-for-slider/for-slider.jpg" alt="Card image">
                            </div>
                        </a>
                    </div>
                </div>
                <div class="hoverDiv overflow-hidden mb-3">
                    <div class="card imgHover border-0" style="width: 19rem;">
                        <a class="hoverLink" href="">
                            <div class="blackoutDiv">
                                <img class="cropped-img blackoutImg" width="286" height="180" src="../../../../storage/app/public/images/images-for-slider/for-slider.jpg" alt="Card image">
                            </div>
                        </a>
                    </div>
                </div>
                <div class="hoverDiv overflow-hidden mb-3">
                    <div class="card imgHover border-0" style="width: 19rem;">
                        <a class="hoverLink" href="">
                            <div class="blackoutDiv">
                                <img class="cropped-img blackoutImg" width="286" height="180" src="../../../../storage/app/public/images/images-for-slider/for-slider.jpg" alt="Card image">
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <h2 class="mt-4">Популярные товары</h2>
            <carousel v-show="!loading" :items-to-show="5" class="mb-4 row">
                <slide v-for="product in products" :key="product.id" class="p-3">
                    <div class="card rounded-3">
                        <div class="card-img-top col-4 rounded-3 rounded-top">
                            <img :src="product.image_url" alt="" class="w-100">
                        </div>
                        <div class="card-body d-flex flex-column align-items-start justify-content-start">
                            <h4 class="">{{ product.title }}</h4>
                            <p>
                                {{ product.description.slice(0,40) }}<span v-if="product.description.slice(0,40).length < product.description.length">...</span>
                            </p>
                            <h5 class="text-secondary">{{ product.price }} ₽</h5>
                            <div class="d-flex justify-content-between w-100">
                                <button class="btn btn-warning"><i class="fas fa-shopping-cart"></i></button>
                                <router-link :to="`/products/${product.id}`" class="ms-2 btn btn-primary">К товару</router-link>
                            </div>
                        </div>
                    </div>
                </slide>


                <template #addons>
                    <navigation />
                </template>
            </carousel>
        </div>
    </div>
</template>

<script>
var myCarousel = document.querySelector('#myCarousel')
var carousel = new bootstrap.Carousel(myCarousel)

import { Carousel, Slide, Navigation } from 'vue3-carousel'

export default {
    name: "Index",

    components: {
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
