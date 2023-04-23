<template>

    <div class="container">
<!--        <div class="row mt-5">-->

<!--        <div class="row mt-5">-->
<!--            <div v-for="item in items" class="col-3 px-5 mb-4">-->
<!--                <ProductCard :item="item"></ProductCard>-->
<!--            </div>-->
<!--        </div>-->

<!--            <div v-for="(item, index) in items" class="col-3 px-5 mb-4">-->
<!--                <div @mouseout="hideProductCardContent(index)" @mouseover="emergingProductCardContent(index)" class="product-card">-->

<!--                    <div class="absolute-background" :id="`absoluteBackground${index}`">-->
<!--                        <img class="w-100 image-in-product-card cursor-pointer" src="http://localhost:8000/storage/images/products/900x1200-(red).png" alt="">-->
<!--                    </div>-->
<!--                    <div>-->
<!--                        <img class="w-100 image-in-product-card" src="http://localhost:8000/storage/images/products/900x1200-(red).png" alt="" :id="`image${index}`">-->
<!--                    </div>-->


<!--                    <div class="content-in-product-card d-flex flex-column">-->
<!--                        <div :id="`contentVisible${index}`">-->
<!--                            <h4>37 ₽</h4>-->
<!--                            <h5>Названиееее</h5>-->
<!--                        </div>-->

<!--                        <div class="content-in-product-card-emerging flex-column" :id="`contentInvisible${index}`">-->
<!--                            <div class="btn btn-warning">-->
<!--                                добавить в корзину-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <div class="heart-in-product cursor-pointer">-->
<!--                        <h3><i class="far fa-heart"></i></h3>-->
<!--                    </div>-->

<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>

</template>

<script>
import getElementPropertiesMixin from "@/mixins/getElementPropertiesMixin.vue";
import ProductCard from "@/components/products/ProductCard.vue";

export default {
    name: "purchases",
    components: {ProductCard},

    mixins: [getElementPropertiesMixin],

    data() {
        return {
            items:[1,2,3,4,5,6,7,8]
        }
    },

    mounted() {

    },

    methods: {
        // emergingProductCardContent(id) {
        //     document.getElementById('absoluteBackground'+id).style.boxShadow = ('0 0 40px #ddd')
        //     document.getElementById('absoluteBackground'+id).style.opacity = ('1')
        //     document.getElementById('image'+id).style.zIndex = ('600')
        //     document.getElementById('absoluteBackground'+id).style.zIndex = ('300')
        //
        //     document.getElementById('contentInvisible'+id).style.display = ('flex')
        //
        //     let heightImage = this.getHeight('image'+id)
        //     let heightContentVisible = this.getHeight('contentVisible'+id)
        //     let heightContentInvisible = this.getHeight('contentInvisible'+id)
        //
        //
        //     let heightBg = 30 + parseFloat(heightImage) + parseFloat(heightContentVisible) + parseFloat(heightContentInvisible) + 'px'
        //
        //
        //
        //     document.getElementById('absoluteBackground'+id).style.height = (heightBg)
        // },
        //
        // hideProductCardContent(id) {
        //     document.getElementById('absoluteBackground'+id).style.boxShadow = ('0 0 0 #ddd;')
        //     document.getElementById('absoluteBackground'+id).style.opacity = ('0')
        //     document.getElementById('image'+id).style.zIndex = ('200')
        //     document.getElementById('contentInvisible'+id).style.display = ('none')
        //
        // },

        // emergingProductCardContent(id) {
        //     let absoluteBackground = document.getElementById('absoluteBackground'+id)
        //     absoluteBackground.style.boxShadow = ('0 0 40px #ddd')
        //     absoluteBackground.style.opacity = ('1')
        //     absoluteBackground.style.zIndex = ('300')
        //
        //     document.getElementById('image'+id).style.zIndex = ('600')
        //     document.getElementById('contentInvisible'+id).style.display = ('flex')
        //
        //     absoluteBackground.style.height = 30 +
        //         parseFloat(this.getHeight('image'+id)) +
        //         parseFloat(this.getHeight('contentVisible'+id)) +
        //         parseFloat(this.getHeight('contentInvisible'+id)) + 'px'
        // },
        //
        // hideProductCardContent(id) {
        //     document.getElementById('absoluteBackground'+id).style = ('')
        //     document.getElementById('image'+id).style.zIndex = ('200')
        //     document.getElementById('contentInvisible'+id).style.display = ('none')
        // },


    },
}
</script>

<style scoped>

</style>
