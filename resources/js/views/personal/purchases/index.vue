<template>

    <div class="container">
        <div class="row mt-5">

            <div ref="items" v-for="(item, index) in items" class="col-3 px-4 mb-4">
                <div @mouseout="hideProductCardContent(index)" @mouseover="emergingProductCardContent(index)" class="product-card">

                    <div class="absolute-background" :id="`absoluteBackground${index}`">
                        <img class="w-100 image-in-product-card cursor-pointer" src="http://localhost:8000/storage/images/products/900x1200-(red).png" alt="">
                    </div>
                    <div>
                        <img class="w-100 image-in-product-card" src="http://localhost:8000/storage/images/products/900x1200-(red).png" alt="" :id="`image${index}`">
                    </div>


                    <div class="content-in-product-card d-flex flex-column">
                        <div :id="`contentVisible${index}`">
                            <h4>4534 ₽</h4>
                            <h5>Названиееее</h5>
                        </div>

                        <div class="content-in-product-card-emerging flex-column" :id="`contentInvisible${index}`">
                            <div class="btn btn-warning">
                                добавить в корзину
                            </div>
                        </div>
                    </div>



                    <div class="heart-in-product cursor-pointer">
                        <h3><i class="far fa-heart"></i></h3>
                    </div>

                </div>
            </div>





        </div>
    </div>

</template>

<script>
export default {
    name: "purchases",

    data() {
        return {
            items:[1,2,3,4,5,6,7,8]
        }
    },

    mounted() {

    },

    methods: {
        emergingProductCardContent(id) {
            document.getElementById('absoluteBackground'+id).style.boxShadow = ('0 0 40px #ddd')
            document.getElementById('absoluteBackground'+id).style.opacity = ('1')
            document.getElementById('image'+id).style.zIndex = ('600')
            document.getElementById('absoluteBackground'+id).style.zIndex = ('300')

            document.getElementById('contentInvisible'+id).style.display = ('flex')

            let heightImage = this.getHeight('image'+id)
            let heightContentVisible = this.getHeight('contentVisible'+id)
            let heightContentInvisible = this.getHeight('contentInvisible'+id)


            let heightBg = 30 + parseFloat(heightImage) + parseFloat(heightContentVisible) + parseFloat(heightContentInvisible) + 'px'



            document.getElementById('absoluteBackground'+id).style.height = (heightBg)
        },
        hideProductCardContent(id) {
            document.getElementById('absoluteBackground'+id).style.boxShadow = ('0 0 0 #ddd;')
            document.getElementById('absoluteBackground'+id).style.opacity = ('0')
            document.getElementById('image'+id).style.zIndex = ('200')
            document.getElementById('contentInvisible'+id).style.display = ('none')

        },

        getHeight(id) {
            return window.getComputedStyle(document.getElementById(id), null).height;
        },

        getMargin(id) {
            return window.getComputedStyle(document.getElementById(id), null).margin;
        },

        getPadding(id) {
            return window.getComputedStyle(document.getElementById(id), null).padding;
        },
    },
}
</script>

<style scoped>

</style>
