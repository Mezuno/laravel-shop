<template>
    <div>
        <div class="col-2">
            <router-link :to="{name: 'products.show', params: {id: product.id}}">
                <img :src="product.image_url" class="w-100 productImgInCart" alt="Картинка продукта">
            </router-link>

        </div>
        <div class="col-10 row ">
            <div class="col-3">
                <router-link class="text-decoration-none" :to="{name: 'products.show', params: {id: product.id}}">
                    <p class="card-text h5 text-dark">{{ index + 1 }}. {{ product.title }}</p>
                </router-link>
                <p class="text-secondary h6">Инфо о товаре</p>
            </div>
            <div class="col-3">

            </div>
            <div class="col-3 text-nowrap">
                <div @click="decQty(product, index)" type="button" class="border border-0 rounded btn btn-light text-decoration-none me-2 divMinus"><i
                    class="fas fa-minus text-dark"></i></div>
                <input @input="changeQty(product, index)"  maxlength="3" class="w-25 me-2 input-qty" :value="product.qty">
                <div @click="incQty(product, index)" type="button" class="border border-0 rounded btn btn-light text-decoration-none divPlus"><i
                    class="fas fa-plus plus"></i></div>
            </div>
            <div class="col-2 text-nowrap">
                {{ product.qty * product.price }} ₽
            </div>
            <div class="col-1">
                <div @click="this.$parent.removeProductFromCart(product)" type="button" class="">
                    <i class="far fa-trash-alt hover-circle"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import cartMixin from "@/mixins/cartMixin.vue";
import {mapActions} from "vuex";

export default {
    name: "ProductInCart",
    mixins: [cartMixin],
    props: {
        product: {
            type: Object
        },
        index: {
            type: Number
        }
    },

    methods: {
        ...mapActions({
            setCartProducts:"cartProducts/setCartProducts",
            changeItemQtyCartProducts:"cartProducts/changeItemQtyCartProducts",
        }),
    }

}
</script>

<style scoped>

</style>
