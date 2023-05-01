<template>

    <div>
        <div class="container-xxl mt-5 mb-5">

            <div v-if="Object.keys(successOrder).length > 0" class="alert alert-success col-6">
                Заказ номер {{ successOrder.id }} успешно оформлен!<br>
                Товары:
                <ul class="mb-0">
                    <li v-for="product in successOrder.products">
                        {{ product.title }} (Артикул: {{ product.vendor_code }}) - {{ product.price }} x {{ product.qty }} = {{ product.price * product.qty }} ₽
                    </li>
                </ul>
                <div>
                    Адрес: {{ successOrder.address }}
                </div>
                <div>
                    Сумма: {{ successOrder.total_price }} ₽
                </div>
            </div>

            <div v-if="Object.keys(successOrder).length > 0" class="alert alert-warning">
                <b>Остальная дата, приходящая с успешным оформлением(можно дополнить окно успешного оформления)</b><br>
                <pre>{{ successOrder }}</pre>
            </div>

            <div class="d-flex">
                <div class="border border-0 cart-card w-75 h-100 me-5 overflow-hidden" id="cart-card">
                    <div class="p-4" id="cart-card2">
                        <div class="cartList" id="cartList">
                            <div class="d-flex flex-wrap justify-content-between" id="cartTitle">

                                <h3 class="card-title mt-1 ">
                                    Корзина
                                    <span v-if="Object.keys(productsInCart).length <= 0" class="d-inline">пока пуста</span>
                                </h3>

                                <div v-show="productsInCart && productsInCart.length > 2" @click="openCartList()" class="btn openCartList">
                                    <h4><i class="fas fa-chevron-up openCartListIcon"></i></h4>
                                </div>

                            </div>



                            <div v-show="productsInCart" v-for="(product, index) in productsInCart" :key="product.id" class="row mt-4 productsInCartList" :id="`productInCartList${product.id}`">
                                <product-in-cart class="row mt-4 productInCartList" :product="product" :index="index" />
                            </div>
                        </div>
                    </div>
                </div>

                <div v-show="productsInCart !== null && Object.keys(productsInCart).length > 0" class="card border border-0 cart-card w-25 h-100">
                    <div class="card-body px-4">
                        <h3 class="card-title mt-1 mb-3">Оформить заказ</h3>
                        <div>
                            <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                                <div class="alert alert-danger">
                                    <div v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</div>
                                </div>
                            </div>
                            <input class="w-100 mb-3 border border-dark rounded form-control shadow-none" type="text" v-model="storeOrderData.name" placeholder="Ваше имя" style="height: 45px;">
                            <input class="w-100 mb-3 border border-dark rounded form-control shadow-none" type="text" v-model="storeOrderData.email" placeholder="Электронная почта" style="height: 45px;">
                            <input class="w-100 mb-3 border border-dark rounded form-control shadow-none" type="text" v-model="storeOrderData.address" placeholder="Адресс доставки" style="height: 45px;">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input shadow-none border-dark" type="checkbox" value="" id="flexCheckDefault" data-bs-toggle="tooltip" data-bs-html="true" title="Авторизируйтесь или зарегистрируйтесь чтобы было удобнее заказывать и пользоваться сайтом">
                            <label class="form-check-label shadow-none " for="flexCheckDefault">
                                Запомнить адресс?
                            </label>
                        </div>

                        <div class="mt-2">
                            <div class="text-dark text-nowrap">
                                <div class="d-flex justify-content-between" style="font-size: 0.9rem;">
                                    <p class="mb-2 text-secondary">Товары, {{ totalCount }}шт</p>
                                    <p class="mb-2 text-secondary">{{ totalPrice }} ₽</p>
                                </div>
                                <h4 class="d-flex justify-content-between">
                                    <span>Итого: </span>
                                    <span>{{ totalPrice }} ₽</span>
                                </h4>
                            </div>
                            <div @click.prevent="storeOrder();" type="button" class="btn btn-outline-dark w-100">
                                {{ orderProcessing ? 'Оформляем' : 'Оформить' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import {mapActions, mapMutations} from "vuex";
import cartMixin from "@/mixins/cartMixin.vue";
import ProductInCart from "../../components/products/ProductInCart.vue";
import getElementPropertiesMixin from "../../mixins/getElementPropertiesMixin.vue";

export default {
    name: "cart",
    components: {ProductInCart},
    mixins: [cartMixin,getElementPropertiesMixin],

    data() {
        return {
            storeOrderData: {
                products: this.productsInCart,
                name: '',
                email: '',
                address: '',
                total_price: this.totalPrice
            },

            cart: {
                isOpened: true,
                height: 0,
                titleHeight: 0,
            },

            orderProcessing: null,
            validationErrors: {},
            successOrder: {},
        }
    },

    computed: {
        productsInCart: function () {
            return this.$store.state.cartProducts.products
        },
        authenticated: function () {
            return this.$store.state.auth.authenticated
        },
        wishlist: function () {
            return this.$store.state.auth.wishlist
        },
        totalPrice: function () {
            let total = 0
            if (this.productsInCart && this.productsInCart.length > 0) {
                this.productsInCart.forEach(productInCart => {
                    total += Number(productInCart.price) * Number(productInCart.qty)
                })
            }
            return total
        },
        totalCount: function () {
            let total = 0
            if (this.productsInCart && this.productsInCart.length > 0) {
                this.productsInCart.forEach(productInCart => {
                    total += Number(productInCart.qty)
                })
            }
            return total
        },
    },

    mounted() {
        if (this.authenticated) {
            this.setStoreOrderData()
        }
        this.setTotalPrice()
        setTimeout(() => {document.getElementById('cartList').style.height = this.getHeight('cartList')}, 1000)
    },

    methods: {
        ...mapActions({
            removeItemFromCart:"cartProducts/removeItemFromCart",
            setCartProducts:"cartProducts/setCartProducts",
            changeItemQtyCartProducts:"cartProducts/changeItemQtyCartProducts",
        }),

        storeOrder() {
            this.storeOrderData.products = this.$store.state.cartProducts.products
            console.log(this.storeOrderData.products);
            this.orderProcessing = true
            window.axios.post('http://localhost:8000/api/order', this.storeOrderData).then(({data}) => {
                this.setCartProducts({})
                this.successOrder = data.data
                this.validationErrors = {}
            }).catch(({response})=>{
                if(response.status===422){
                    this.validationErrors = response.data.errors
                } else{
                    this.validationErrors = {}
                    alert(response.data.message)
                }
            }).finally(()=>{
                this.orderProcessing = false
            })
        },

        setStoreOrderData() {
            this.storeOrderData.name = this.$store.state.auth.user.name
            this.storeOrderData.email = this.$store.state.auth.user.email
            this.storeOrderData.address = this.$store.state.auth.user.address
        },

        setTotalPrice() {
            this.storeOrderData.total_price = this.totalPrice
        },

        openCartList() {
            this.cart.titleHeight = Math.round(parseFloat(this.getHeight('cartTitle'))* 100) / 100;
            console.log(this.cart.titleHeight)
            let qtyProducts = this.productsInCart?.length;
            if (qtyProducts === undefined) {
                return null
            }

            if (this.cart.isOpened === false) {
                document.getElementsByClassName("openCartList")[0].style.transform = "rotate(0deg)"
                this.setCartHeight()
                this.cart.isOpened = true
                console.log(this.cart.height)

            } else {
                document.getElementsByClassName("openCartList")[0].style.transform = "rotate(-180deg)"
                document.getElementById('cartList').style.height = (String(this.cart.titleHeight) + 'px')

                this.cart.height = (parseFloat(this.getMargin('productInCartList'+this.productsInCart[0].id)) + parseFloat(this.getHeight('productInCartList'+this.productsInCart[0].id))) * qtyProducts + parseFloat(this.getHeight('cartTitle'))
                this.cart.height = Math.round(this.cart.height * 100) / 100;
                console.log(this.cart.height)
                this.cart.isOpened = false
            }
        },

        setCartHeight() {
            let qtyProducts = this.productsInCart?.length;
            this.cart.height = (parseFloat(this.getMargin('productInCartList'+this.productsInCart[0].id)) + parseFloat(this.getHeight('productInCartList'+this.productsInCart[0].id))) * qtyProducts + parseFloat(this.getHeight('cartTitle'))
            this.cart.height = Math.round(this.cart.height * 100) / 100;
            document.getElementById('cartList').style.height = (String(this.cart.height) + 'px')
        },

        removeProductFromCart (product) {
            this.removeItemFromCart(product)
            this.setCartHeight()
        },

    }
}

</script>

<style scoped>

</style>
