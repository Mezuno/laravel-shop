<template>

    <div class="price me-2 d-inline-flex align-items-center">

        <div class="price-title cursor-pointer unselectable">
            <span class="price-text">Цена ₽</span>
        </div>

        <div @click.stop v-show="priceOpened" class="price-choice">
            <div class="price-min px-0">
                <span class="unselectable">От</span>
                <input @input="changeMinPrice($event)" autocomplete="off" inputmode="numeric" class="price-min-input" maxlength="5" v-model="price.min">
            </div>

            <div class="price-max px-0">
                <span class="unselectable">До</span>
                <input @input="changeMaxPrice($event)" autocomplete="off" inputmode="numeric" class="price-max-input" maxlength="5" v-model="price.max">
            </div>

        </div>


    </div>

</template>

<script>

import validationMixin from "../../mixins/validationMixin.vue";

export default {
    name: "price",

    mixins: [validationMixin],

    props: {
        priceOpened: {
            type: Boolean,
        },
        priceMinMax: {
            type: Object,
        },
    },

    data() {
        return {
            price: {
                min: '0',
                max: '99999',
            }
        }
    },

    methods: {


    },
}
</script>

<style scoped>

</style>
