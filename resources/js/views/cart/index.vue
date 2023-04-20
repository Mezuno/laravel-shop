<template>
<!--        <div v-for="productInCart in productsInCart">-->
<!--            {{ productInCart.title }}-->
<!--        </div>-->
    <div>
        <div class="container-xxl mt-5 mb-5">

<!--            <p>-->
<!--                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">-->
<!--                    Link with href-->
<!--                </a>-->
<!--                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">-->
<!--                    Button with data-target-->
<!--                </button>-->
<!--            </p>-->
<!--            <div class="collapse" id="collapseExample">-->
<!--                <div class="card card-body">-->

<!--                </div>-->
<!--            </div>-->

<!--            <div class="card-header d-flex align-items-center justify-content-between">-->
<!--                <p class="h4 mb-0">Добавить новость</p>-->
<!--                <button class="btn rounded-circle shadow-none" data-bs-toggle="collapse" href="#collapseCreateNews" @click="adsasd">-->
<!--                    <i class="fas fa-chevron-up"></i>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="collapse" id="collapseCreateNews">-->
<!--                <div class="card-body d-flex flex-column">-->
<!--                    <form class="d-flex flex-column" method="post" enctype="multipart/form-data">-->

<!--                        <div class="alert alert-danger w-100">-->
<!--                            <ul>аааааа</ul>-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->

            <div v-if="Object.keys(successOrder).length > 0" class="alert alert-success col-4">
                Заказ номер {{ successOrder.id }} успешно оформлен!<br>
                Товары:
                <ul class="mb-0">
                    <li v-for="product in successOrder.products">
                        {{ product.title }} (Артикул: {{ product.vendor_code }}) - {{ product.price }} ₽
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
                <div class="card border border-0 cart-card w-75 me-5 overflow-hidden" id="cart-card">
                    <div class="card-body ps-4" id="cart-card2">
                        <div class="d-flex flex-wrap justify-content-between" id="cartTitle">
                            <h3 class="card-title mt-1 ">
                                Корзина
<!--                                <div v-if="Object.keys(productsInCart).length <= 0" class="d-inline">пока пуста</div>-->
                            </h3>
                            <div v-if="productsInCart" v-show="productsInCart.length > 6" @click="openCartList()" class="btn openCartList">
                                <i class="fas fa-chevron-up h4 openCartListIcon"></i>
                            </div>
                        </div>

                        <div v-show="productsInCart" v-for="(product, index) in productsInCart" class="row mt-4 productsInCartList"
                             id="productsInCartList">
                            <div class="col-2">
                                <router-link :to="{name: 'products.show', params: {id: product.id}}">
                                    <img :src="product.image_url"
                                         class="w-100 productImgInCart">
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
                                    <input @change="changeQty(product, index)"  maxlength="3" class="w-25 me-2 input-qty" :value="product.qty">
                                    <div @click="incQty(product, index)" type="button" class="border border-0 rounded btn btn-light text-decoration-none divPlus"><i
                                        class="fas fa-plus plus"></i></div>
                                </div>
                                <div class="col-2 text-nowrap">
                                    {{ product.qty * product.price }} ₽
                                </div>
                                <div class="col-1">
                                    <div @click="deleteProductAsCart(product, index)" type="button" class="">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div v-show="productsInCart != null && productsInCart.length !== 0" class="card border border-0 cart-card w-25 h-100">
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
<!--                        <input type="checkbox" class="btn-check" id="btn-check-2-outlined" checked autocomplete="off" data-bs-toggle="tooltip" data-bs-html="true" title="Авторизируйтесь или зарегистрируйтесь чтобы было удобнее заказывать и пользоваться сайтом">-->
<!--                        <label class="btn btn-outline-secondary" for="btn-check-2-outlined">Запомнить данные?</label><br>-->
                        <div class="form-check ">
                            <input class="form-check-input shadow-none border-dark" type="checkbox" value="" id="flexCheckDefault" data-bs-toggle="tooltip" data-bs-html="true" title="Авторизируйтесь или зарегистрируйтесь чтобы было удобнее заказывать и пользоваться сайтом">
                            <label class="form-check-label shadow-none " for="flexCheckDefault">
                                Запомнить данные?
                            </label>
                        </div>
<!--                        <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-html="true" title="<em>Подсказка</em> <u>с</u> <b>HTML</b>">-->
<!--                            Авторизируйтесь или зарегистрируйтесь чтобы было удобнее заказывать и пользоваться сайтом-->
<!--                        </button>-->


<!--                        <input type="checkbox" class="btn-check" id="btn-check-2-outlined" checked autocomplete="off">-->
<!--                        <label class="btn btn-outline-dark" for="btn-check-2-outlined">Запомнить данные?</label><br>-->

<!--                        <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-html="true" title="<em>Подсказка</em> <u>с</u> <b>HTML</b>">-->
<!--                            Всплывающая подсказка с HTML-->
<!--                        </button>-->

                        <div class="mt-2">
                            <h6 class="text-dark text-nowrap">Итого: {{ totalPrice }} ₽</h6>
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
export default {
    name: "cart",

    data() {
        return {
            productsInCart: this.$root.productsInCart,

            storeOrderData: {
                products: this.$root.productsInCart,
                name: '',
                email: '',
                address: '',
                total_price: null
            },

            cartOpened: true,
            isOpenA: false,
            orderProcessing: null,
            validationErrors: {},
            successOrder: {},
            wishlist: {}
        }
    },

    computed: {
        totalPrice: function () {
            let total = 0
            if (this.productsInCart) {
                this.productsInCart.forEach(productInCart => {
                    total += Number(productInCart.price) * Number(productInCart.qty)
                })
            }
            return total
        },

    },

    mounted() {
        this.$nextTick(function () {
            this.openCartList()
        })
        if (this.$store.state.auth.user) {
            this.setName()
            this.setEmail()
            this.setAddress()
        }
        this.setTotalPrice()

    },

    methods: {
        storeOrder() {
            this.orderProcessing = true
            window.axios.post('http://localhost:8000/api/order', this.storeOrderData).then(({data}) => {
                this.productsInCart = []
                this.$root.productsInCart = []
                localStorage.removeItem('cart')
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

        setName() {
            this.storeOrderData.name = this.$store.state.auth.user.name
        },
        setEmail() {
            this.storeOrderData.email = this.$store.state.auth.user.email
        },
        setAddress() {
            this.storeOrderData.address = this.$store.state.auth.user.address
        },
        setTotalPrice() {
            this.storeOrderData.total_price = this.totalPrice
        },

        openCartList() {
            // let lengthProducts = this.productsInCart?.length
            // let height = "1000px"
            let lengthProducts = this.productsInCart?.length;
            if (lengthProducts === undefined) {
                return null
            }

            if (this.isOpened === false) {
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
                document.getElementsByClassName("openCartList")[0].style.transform = "rotate(0deg)"
                // document.getElementsByClassName("cart-card")[0].style.height = "960px"
                document.getElementsByClassName("cart-card")[0].style.height = ""
                // console.log(lengthProducts)
                for (let i = 0; i < lengthProducts; i++) {
                    document.getElementsByClassName("productsInCartList")[i].style.display = "flex"
                }
                this.isOpened = false
            }
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
            let cart = JSON.parse(localStorage.getItem('cart'))
            cart.splice(indexInCart, 1)
            localStorage.setItem('cart', JSON.stringify(cart))
            this.$root.getProductsInCart()
            this.productsInCart = this.$root.productsInCart
        },

        // adsasd() {
        //     if (this.cartOpened){
        //         document.getElementById("collapseCreateNews").classList.add('collapse')
        //         document.getElementById("collapseCreateNews").classList.remove('show')
        //     } else {
        //         document.getElementById("collapseCreateNews").classList.add('show')
        //     }
        // },

        // getHeight(id) {
        //     let idCartCard = document.getElementById(id)
        //     let styles = window.getComputedStyle(idCartCard, null)
        //     let height = styles.height;
        //     return (height)
        // },
        //
        // getMargin(id) {
        //     let idCartCard = document.getElementById(id)
        //     let styles = window.getComputedStyle(idCartCard, null)
        //     let margin = styles.marginTop + styles.marginBottom;
        //     return (margin)
        // },
        //
        // getPadding(id) {
        //     let idCartCard = document.getElementById(id)
        //     let styles = window.getComputedStyle(idCartCard, null)
        //     let margin = styles.paddingTop + styles.paddingBottom;
        //     return (margin)
        // },


        updateInfoOnPage(product, indexInCart) {
            //
        },
    }
}

</script>

<style scoped>

</style>
