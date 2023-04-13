<template>

    <div class="container-xxl mt-5 mb-5">
        <div class="d-flex">

            <div class="card border border-0 cart-card w-100 overflow-hidden" id="cart-card">

                <div class="d-flex flex-wrap justify-content-between ms-5 mt-4" id="cartTitle">
                    <h3 class="">Заказы</h3>

                </div>
                <div class="px-5 pt-4 pb-4 ">
                    <div v-if="orders" v-for="order in orders" class="row mb-3">
                        <div class="col-1">Товары:</div>
                        <div class="col-1">
                            <div v-for="orderProduct in order.products">
                                <router-link :to="`/products/${orderProduct.id}`">{{ orderProduct.title }}</router-link>
                            </div>
                        </div>
                        <div class="col-4">
                            Адресс: {{ order.address }}
                        </div>
                        <div class="col-2">
                            Статус доставки:
                        </div>
                        <div class="col-2">
                            Едет
                            <i class="fas fa-truck-moving"></i>
<!--                            <i class="fas fa-truck-loading"></i>-->
                        </div>
                    </div>
                    <div v-else >
                        <h3 class="d-flex justify-content-center align-items-center">Вы ещё ничего не заказали</h3>
                        <div class="d-flex justify-content-center align-items-center">
                            <router-link to="/" class="btn btn-outline-warning rounded-0">Перейти на главную</router-link>
                            <router-link to="/cart" class="btn btn-outline-dark ms-4 rounded-0">перейти в корзину</router-link>
                        </div>
                        <div class="d-flex justify-content-center align-items-center">

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>




</template>

<script>
export default {
    name: "orders",
    data() {
        return {
            orders: [],
        }
    },
    mounted() {
        // this.user = this.$root.getUserFromLocalStorage()
        this.getOrders()
    },
    methods: {
        getOrders() {
            this.orderLoader = false
            axios.post('/api/orders', {
                user_id: this.$root.user.id
            })
                .then(response => {
                    this.orders = response.data.data
                    console.log(response);
                    this.orderLoader = true
                })
                .catch(error => {
                    console.log(error);
                })
        },
    }

}
</script>

<style scoped>

</style>
