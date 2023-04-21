<template>
    <div style="overflow: hidden; min-height: 100vh">
        <nav class="navbar navbar-expand p-0">
            <div class="d-flex justify-content-center w-100">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">Доставка и оплата</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">О компании</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">Отызвы клиентов</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">Как сделать заказ?</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">Промокоды</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">Контакты</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="#" class="nav-link">Корпоративным клиентам</router-link>
                    </li>
                </ul>
            </div>
        </nav>

        <nav class="navbar navbar-expand p-4 navbar-light bg-light bg-img">
            <div class="container-xxl" style="z-index: 3">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <h1><router-link to="/" class="nav-link">LOGO</router-link></h1>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto me-auto">
                    <li class="nav-item d-flex text-dark">
                        <h2 class="d-flex align-items-center mb-0"><i class="fas fa-phone"></i></h2>
                        <div>
                            <h4 class="m-0 pb-0">
                                <a href="tel:+79999999999" class="nav-link link-dark pb-0">
                                    +7 (999) 999-99-99
                                </a>
                            </h4>
                            <div class="ps-2">
                                9:00-21:00 Каждый день
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto me-auto">
                    <li class="nav-item">
                        <router-link to="#" class="nav-link btn btn-warning text-dark">Перезвоните мне</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item d-flex align-items-center btn btn-warning me-2">
                        <h4 class="m-0"><router-link to="/wishlist" class="cart-img text-dark m-0 p-0"><i class="fas fa-heart"></i></router-link></h4>
                    </li>
                    <li class="nav-item">
                        <router-link to="/cart" class="cart-img btn btn-warning text-dark d-flex align-items-center"><h4 class="mb-0 me-2"><i class="fas fa-shopping-cart"></i></h4><h5 class="p-0 m-0">{{ totalPrice }}</h5><i class="fas fa-ruble-sign"></i></router-link>
                    </li>
                </ul>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-warning bg-warning">
            <div class="container-xxl">
                <router-link class="navbar-brand" to="/">Магазин</router-link>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <router-link to="/" class="nav-link">Главная</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/products" class="nav-link">Каталог</router-link>
                        </li>
                        <!--            <li class="nav-item dropdown">-->
                        <!--              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">-->
                        <!--                Dropdown-->
                        <!--              </a>-->
                        <!--              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">-->
                        <!--                <li><a class="dropdown-item" href="#">Action</a></li>-->
                        <!--                <li><a class="dropdown-item" href="#">Another action</a></li>-->
                        <!--                <li><hr class="dropdown-divider"></li>-->
                        <!--                <li><a class="dropdown-item" href="#">Something else here</a></li>-->
                        <!--              </ul>-->
                        <!--            </li>-->
                        <!--            <li class="nav-item">-->
                        <!--              <a class="nav-link disabled">Disabled</a>-->
                        <!--            </li>-->
                    </ul>

                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
<!--                        <li class="nav-item">-->
<!--                            <a href="" class="nav-link">-->
<!--                                {{ authenticated }}-->
<!--                            </a>-->
<!--                        </li>-->
                        <li v-show="authenticated" class="nav-item">
                            <router-link to="/profile" class="nav-link">Личный кабинет</router-link>
                        </li>
                        <li v-show="!authenticated" class="nav-item">
                            <router-link to="/user/login" class="nav-link">Войти</router-link>
                        </li>
                        <li v-show="!authenticated" class="nav-item">
                            <router-link to="/user/registration" class="nav-link">Регистрация</router-link>
                        </li>
                        <li v-show="authenticated" class="nav-item">
                            <a href="#" @click.prevent="logout()" class="nav-link">Выйти</a>
                        </li>
                    </ul>

                    <!--          Поиск (добавить позже)   -->

<!--                              <form class="d-flex">-->
<!--                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
<!--                                <button class="btn btn-outline-success" type="submit">Search</button>-->
<!--                              </form>-->

                </div>
            </div>
            <div>
<!--                <router-link to="/cart" class="cart-img text-white px-4 pb-2"><i class="fas fa-shopping-cart"></i></router-link>-->
                <div class="cart pt-3" style="z-index: 100">
                    <div class="w-25">

                    </div>
                    <aside class="border border-left" id="cart">
                        <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white"
                             style="width: 380px;">
                            <div style="overflow-y: scroll; height: 516px;">
                                <div v-for="productInCart in productsInCart" class="list-group list-group-flush border-bottom scrollarea">
                                    <div href="#" class="list-group-item list-group-item-action py-3 lh-tight"
                                       aria-current="true">
                                        <div class="d-flex w-100 align-items-center justify-content-between">
                                            <router-link class="text-decoration-none" :to="{name: 'products.show', params: {id: productInCart.id}}">
                                                <strong class="mb-1 text-dark">{{ productInCart.title }}</strong>
                                            </router-link>
                                            <small class="text-secondary fw-bold">{{ productInCart.price }} руб</small>
                                        </div>
                                        <div class="col-10 mb-1 small d-flex justify-content-between">
                                            <router-link :to="{name: 'products.show', params: {id: productInCart.id}}">
                                                <img :src="productInCart.image_url" width="50" alt="Отсутствует фото товара">
                                            </router-link>
                                            <p class="d-inline-block text-secondary fw-bold">x{{ productInCart.qty }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-bottom d-flex w-100 align-items-center justify-content-between">
                                <!--                    <a href="#" class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none">-->
                                <!--                        <svg class="bi " width="30" height="24">-->
                                <!--                            <use xlink:href="#bootstrap"></use>-->
                                <!--                        </svg>-->
                                <!--                        <span class="fs-5 fw-semibold ">Корзина</span>-->
                                <!--                    </a>-->
                                <span class="fs-5 fw-semibold d-flex align-items-center flex-shrink-0 p-3">Всего:</span>
                                <small class="text-secondary fw-bold p-3">{{ totalPrice }} руб</small>
                                <router-link to="/cart" class="btn btn-primary">Заказать</router-link>
                            </div>
                        </div>
                        <!--      <div>-->
                        <!--        <ul>-->
                        <!--        </ul>-->
                        <!--      </div>-->
                    </aside>
                </div>
            </div>
        </nav>

        <router-view></router-view>

        <footer>
        </footer>
    </div>
</template>

<script>

import {mapActions} from 'vuex'
export default {
    name: 'App',

    computed: {
        user: function () {
            return this.$store.state.auth.user
        },
        authenticated: function () {
            return this.$store.state.auth.authenticated
        },
        productsInCart: function () {
            return this.$store.state.cartProducts.products
        },
        wishlist: function () {
            return this.$store.state.auth.wishlist
        },
        totalPrice: function () {
            let total = 0
            if (this.productsInCart) {
                this.productsInCart?.forEach(productInCart => {
                    total += Number(productInCart.price) * Number(productInCart.qty)
                })
            }
            return total
        },
    },

    updated() {
        if (this.authenticated) {
            this.getWishlist()
        }
    },

    // renderTriggered({ key, target, type }) {
    //     console.log({ key, target, type })
    // },

    methods: {
        ...mapActions({
            signOut:"auth/logout",
            setWishlist:"auth/setWishlist",
        }),
        async logout(){
            await axios.post('/logout').then(({data})=>{
                this.signOut()
                this.$router.push({name:"user.login"})
            })
        },

        async getWishlist() {
            await this.setWishlist()
        },

        setProductsInCart(productsInCart) {
             localStorage.setItem('cart', JSON.stringify(productsInCart))
        },
    }
}
</script>

<style>

</style>
