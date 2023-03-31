<template>
<!--    <div v-for="productInCart in productsInCart">-->
<!--        {{ productInCart.title }}-->
<!--    </div>-->
    <div>
        <div class="container-xxl mt-5">
            <h1>Коризна</h1>
            <div class="d-flex flex-column">
                <div class="row w-25">
                    <div v-if="orderErrors" v-for="orderError in orderErrors" class="alert alert-danger">{{ orderError }}</div>
                    <input type="text" v-model="name" placeholder="name">
                    <input type="text" v-model="email" placeholder="email">
                    <input type="text" v-model="address" placeholder="address">
                    <button @click.prevent="storeOrder();" class="btn btn-primary">Оформить</button>
                </div>
                <div v-for="productInCart in productsInCart" class="card p-2">
                    {{ productInCart.title }}
                    {{ productInCart.price }}руб.
                    x{{ productInCart.qty }}
                </div>

                <p class="text-secondary">Итого: {{ totalPrice }}</p>

<!--                <input class="btn-dark" @onclick.prevent="storeOrder();" value="Оформить заказ">-->

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "cart",

    mounted() {
        this.getProductsInCart()
    },

    data() {
        return {
            productsInCart: [],
            name: '',
            email: '',
            address: '',
            orderErrors: [],
        }
    },

    computed: {
        totalPrice: function () {
            let total = 0
            this.productsInCart.forEach(productInCart => {
                total += Number(productInCart.price) * Number(productInCart.qty)
            })
            return total
        }
    },

    methods: {
        getProductsInCart() {
            this.productsInCart = JSON.parse(localStorage.getItem('cart'))
        },

        storeOrder() {
            this.axios.post('http://localhost:8000/api/orders', {
                'products': this.productsInCart,
                'name': this.name,
                'email': this.email,
                'address': this.address,
                'total_price': this.totalPrice,
                'error': this.orderErrors,
            }).then(response => {
                console.log(response.data.data);
            }).catch(error => {
                console.log(error.response.data.errors)
                this.orderErrors = Object.values(error.response.data.errors);
                console.log(this.orderErrors);
            });
        },
    }
}
</script>

<style scoped>

</style>
