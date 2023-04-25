<template>
    <div @mouseout="hideProductCardContent(identifier, product.id)" @mouseover="emergingProductCardContent(identifier, product.id)" class="product-card">

        <div class="absolute-background" :id="`absoluteBackground${identifier}${product.id}`">
            <img class="w-100 image-in-product-card cursor-pointer" :src="product.image_url" alt="">
        </div>
        <div>
            <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none cursor-pointer">
                <img class="w-100 image-in-product-card" :src="product.image_url" alt="" :id="`image${identifier}${product.id}`">
            </router-link>
        </div>

        <div class="content-in-product-card d-flex flex-column w-100">
            <div :id="`contentVisible${identifier}${product.id}`">

                <h5 class="mb-0 mt-2">{{ product.price.slice(0, -3) }} ₽</h5>
                <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none">
                    {{ product.title }}
                </router-link>

                <div class="d-flex flex-grow-1">
                    <p class="text-warning d-inline-block mb-0">
                        <i v-for="n in Math.round(product.avg_rate)" class="fas fa-star"></i>
                        <i v-for="n in 5 - Math.round(product.avg_rate)" class="far fa-star"></i>
                    </p>
                    <p class="ms-2 mb-0">({{ product.reviews_count }})</p>
                </div>

            </div>

        </div>

    </div>
</template>

<script>
import getElementPropertiesMixin from "@/mixins/getElementPropertiesMixin.vue";

export default {
    name: "AlternativeProductCard",

    props: {
        product: {
            type: Object,
            required: true,
        },
        identifier: {
            type: String
        },
    },

    mixins: [getElementPropertiesMixin],

    methods: {

        emergingProductCardContent(identifier, id) {
            let absoluteBackground = document.getElementById('absoluteBackground'+identifier+id)
            absoluteBackground.style.boxShadow = ('0 0 30px #ddd')
            absoluteBackground.style.opacity = ('1')
            absoluteBackground.style.zIndex = ('600')

            document.getElementById('image'+identifier+id).style.zIndex = ('600')

            absoluteBackground.style.height = 30 +
                parseFloat(this.getHeight('image'+identifier+id)) +
                parseFloat(this.getHeight('contentVisible'+identifier+id)) + 'px'
        },

        hideProductCardContent(identifier, id) {
            document.getElementById('absoluteBackground'+identifier+id).style = ('')
            document.getElementById('image'+identifier+id).style.zIndex = ('200')
        },
    }
}
</script>

<style scoped>

</style>
