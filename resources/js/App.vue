<template>
    <div style="overflow: hidden;">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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


                    <!--          Поиск (добавить позже)   -->

                    <!--          <form class="d-flex">-->
                    <!--            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
                    <!--            <button class="btn btn-outline-success" type="submit">Search</button>-->
                    <!--          </form>-->

                </div>
            </div>
            <div>
                <router-link to="/cart" class="cart-img text-white px-4 pb-2"><i class="fas fa-shopping-cart"></i></router-link>
                <div class="cart pt-3" style="z-index: 100">
                    <div class="w-25">

                    </div>
                    <aside class="border border-left" id="cart">
                        <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white"
                             style="width: 380px;">
                            <div v-for="productInCart in productsInCart" class="list-group list-group-flush border-bottom scrollarea">
                                <a href="#" class="list-group-item list-group-item-action py-3 lh-tight"
                                   aria-current="true">
                                    <div class="d-flex w-100 align-items-center justify-content-between">
                                        <strong class="mb-1">{{ productInCart.title }}</strong>
                                        <small class="text-secondary fw-bold">{{ productInCart.price }} руб</small>
                                    </div>
                                    <div class="col-10 mb-1 small d-flex justify-content-between">
                                        <img :src="productInCart.image_url" width="50" alt="Отсутствует фото товара">
                                        <p class="d-inline-block text-secondary fw-bold">x{{ productInCart.qty }}</p>
                                    </div>
                                </a>
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

export default {
    name: 'App',
    mounted() {
        this.getProductsInCart()
    },

    data() {
        return {
            productsInCart: [],
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
        }
    }
}
</script>

<style>

</style>
