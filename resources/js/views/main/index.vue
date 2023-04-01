<template>
    <div>
        <div class="container-xxl mt-5">
            <h1>Главная</h1>

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
                                    <img src="../../../../storage/app/public/images/images-for-slider/for-slider.jpg" class="d-block w-100 sliderBlackoutImg" alt="...">
                                </div>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a class="sliderLink" href="">
                                <div class="sliderBlackoutDiv">
                                    <img src="../../../../storage/app/public/images/images-for-slider/for-slider.jpg" class="d-block w-100 sliderBlackoutImg" alt="...">
                                </div>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a class="sliderLink" href="">
                                <div class="sliderBlackoutDiv">
                                    <img src="../../../../storage/app/public/images/images-for-slider/for-slider.jpg" class="d-block w-100 sliderBlackoutImg" alt="...">
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
        </div>
    </div>
</template>

<script>
var myCarousel = document.querySelector('#myCarousel')
var carousel = new bootstrap.Carousel(myCarousel)

export default {
    name: "Index",

}
</script>

<style scoped>

</style>
