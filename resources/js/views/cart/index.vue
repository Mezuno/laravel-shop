<template>
    <!--    <div v-for="productInCart in productsInCart">-->
    <!--        {{ productInCart.title }}-->
    <!--    </div>-->
    <div>
        <div class="container-xxl mt-5 mb-5">


            <div class="d-flex">

                <div class="card border border-0 cart-card w-75 me-5 overflow-hidden" id="cart-card">
                    <div class="card-body ps-4" id="cart-card2">
                        <div class="d-flex flex-wrap justify-content-between" id="cartTitle">
                            <h3 class="card-title mt-1 ">Корзина<h3 v-if="this.productsInCart.length === 0" class="">
                                пока пуста</h3></h3>
                            <div v-if="this.productsInCart.length > 6" @click="openCartList()" class="btn openCartList">
                                <i class="fas fa-chevron-up h4 openCartListIcon"></i>
                            </div>
                        </div>

                        <div v-for="(productInCart, index) in productsInCart" class="row mt-4 productsInCartList"
                             id="productsInCartList">
                            <div class="col-2">
                                <router-link :to="{name: 'products.show', params: {id: productInCart.id}}">
                                    <img src="../../../../storage/app/public/images/images-for-slider/for-slider.jpg"
                                         class="w-100 productImgInCart">
                                </router-link>

                            </div>

                            <div class="col-3">
                                <router-link class="text-decoration-none" :to="{name: 'products.show', params: {id: productInCart.id}}">
                                    <p class="card-text h5 text-dark">{{ index + 1 }}. {{ productInCart.title }}</p>
                                </router-link>
                                <p class="text-secondary h6">Инфо о товаре</p>
                            </div>
                            <div class="col-2">

                            </div>
                            <div class="col-3">
                                <div @click="decQty(productInCart, index)" type="button" class="border border-0 rounded btn btn-light text-decoration-none me-2 divMinus"><i
                                    class="fas fa-minus text-dark"></i></div>
                                <input @change="changeQty(productInCart, index)"  maxlength="3" class="w-25 me-2 border-0 input-qty" :value="productInCart.qty">
                                <div @click="incQty(productInCart, index)" type="button" class="border border-0 rounded btn btn-light text-decoration-none divPlus"><i
                                    class="fas fa-plus plus"></i></div>
                                </div>
                            <div class="col-1 text-nowrap">
                                {{ productInCart.qty * productInCart.price }} ₽
                            </div>
                            <div class="col-1">
                                <div @click="deleteProductAsCart(productInCart, index)" type="button" class="btn">
                                    <i class="fas fa-trash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="this.productsInCart.length !== 0" class="card border border-0 cart-card w-25 h-100">
                    <div v-if="orderErrors" v-for="orderError in orderErrors" class="alert alert-danger">
                        {{ orderError }}
                    </div>
                    <div class="card-body px-4">
                        <h3 class="card-title mt-1 mb-3">Оформить заказ</h3>
                        <div>
                            <input class="w-100 mb-3 border border-dark rounded form-control" type="text" v-model="name" placeholder="Ваше имя" style="height: 45px;">
                            <input class="w-100 mb-3 border border-dark rounded form-control" type="text" v-model="email" placeholder="Электронная почта" style="height: 45px;">
                            <input class="w-100 mb-3 border border-dark rounded form-control" type="text" v-model="address" placeholder="Адресс доставки" style="height: 45px;">
                        </div>
                        <div class="mt-2">
                            <h6 class="text-dark text-nowrap">Итого: {{ totalPrice }} ₽</h6>
                            <div @click.prevent="storeOrder();" type="button" class="btn btn-outline-dark w-100">
                                Оформить
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "cart",

    mounted() {
        this.getProductsInCart()
        this.$nextTick(function () {
            this.openCartList()
        })
    },

    data() {
        return {
            productsInCart: [],
            name: '',
            email: '',
            address: '',
            orderErrors: []
        }
    },

    computed: {
        totalPrice: function () {
            let total = 0
            this.productsInCart.forEach(productInCart => {
                total += Number(productInCart.price) * Number(productInCart.qty)
            })
            return total
        },

    },

    methods: {

        getHeight(id) {
            let idCartCard = document.getElementById(id)
            let styles = window.getComputedStyle(idCartCard, null)
            let height = styles.height;
            return (height)
        },

        getMargin(id) {
            let idCartCard = document.getElementById(id)
            let styles = window.getComputedStyle(idCartCard, null)
            let margin = styles.marginTop + styles.marginBottom;
            return (margin)
        },

        getPadding(id) {
            let idCartCard = document.getElementById(id)
            let styles = window.getComputedStyle(idCartCard, null)
            let margin = styles.paddingTop + styles.paddingBottom;
            return (margin)
        },

        openCartList() {
            let lengthProducts = this.productsInCart.length
            // let height = "1000px"
            if (this.isOpened === false) {
                console.log("if")
                // height = this.getPadding("cart-card2") + this.getHeight("cartTitle") + (this.getMargin("productsInCartList") + this.getHeight("productsInCartList")) * lengthProducts + "px"
                // height = this.getHeight("cart-card") + "px"
                document.getElementsByClassName("openCartList")[0].style.transform = "rotate(-180deg)"
                document.getElementsByClassName("cart-card")[0].style.height = "78px"
                setTimeout(function () {
                    for (let i = 0; i < lengthProducts; i++) {
                        document.getElementsByClassName("productsInCartList")[i].style.display = "none"
                    }
                }, 200);

                this.isOpened = true

            } else {
                console.log("else")
                document.getElementsByClassName("openCartList")[0].style.transform = "rotate(0deg)"
                document.getElementsByClassName("cart-card")[0].style.height = "960px"

                console.log(lengthProducts)
                for (let i = 0; i < lengthProducts; i++) {
                    document.getElementsByClassName("productsInCartList")[i].style.display = "flex"
                }
                this.isOpened = false
            }
        },



        updateInfoOnPage(product, indexInCart) {
            //
        },

        decQty(product, indexInCart) {
            let cart = localStorage.getItem('cart')
            let inputQty = Number(document.getElementsByClassName("input-qty")[indexInCart].value)
            if (product.qty > 1) {
                cart = JSON.parse(cart)
                cart[indexInCart].qty = inputQty - 1
                localStorage.setItem('cart', JSON.stringify(cart))
                product.qty = inputQty
                product.qty = product.qty - 1;
            }
        },

        incQty(product, indexInCart) {
            let cart = localStorage.getItem('cart')
            let inputQty = Number(document.getElementsByClassName("input-qty")[indexInCart].value)
            if (product.qty < 999) {
                cart = JSON.parse(cart)
                cart[indexInCart].qty = inputQty + 1
                localStorage.setItem('cart', JSON.stringify(cart))
                product.qty = inputQty
                product.qty = product.qty + 1;
            }
        },

        changeQty(product, indexInCart) {
            let cart = JSON.parse(localStorage.getItem('cart'))
            let inputQty = Number(document.getElementsByClassName("input-qty")[indexInCart].value)

            if (inputQty > 0 && inputQty < 1000) {
                cart[indexInCart].qty = inputQty
            } else if (inputQty < 1) {
                cart[indexInCart].qty = 1
                inputQty = 1
            } else if (inputQty > 999) {
                cart[indexInCart].qty = 999
                inputQty = 999
            }
            this.$root.setProductsInCart(cart)
            product.qty = inputQty
            //this.updateInfoOnPage(product, indexInCart)
        },

        deleteProductAsCart(product, indexInCart) {
            let cart = localStorage.getItem('cart')
            cart = JSON.parse(cart)
            console.log(cart[indexInCart])
            cart.splice(indexInCart, 1)
            localStorage.setItem('cart', JSON.stringify(cart))
            this.productsInCart = cart
        },


        getProductsInCart() {
            this.productsInCart = JSON.parse(localStorage.getItem('cart'))
        },

        storeOrder() {
            axios.post('http://localhost:8000/api/order', {
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
