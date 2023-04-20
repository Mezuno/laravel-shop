<template>
    <div>
        <div class="container-xxl mt-5">

            <modal-window v-model:openModal="modalVisibility" style="z-index: 1000">
                <div class="content-in-modal">
                    <h3 class="mb-3">
                        Выберите что хотите изменить
                    </h3>
                    <div class="mb-3">
                        <button class="btn btn-outline-dark me-3 shadow-none" @click.prevent="inputShow.name = !inputShow.name">
                            Имя
                        </button>
                        <button class="btn btn-outline-dark me-3 shadow-none" @click.prevent="inputShow.mail = !inputShow.mail">
                            Электронная почта
                        </button>
                        <button class="btn btn-outline-dark me-3 shadow-none" @click.prevent="inputShow.phone = !inputShow.phone">
                            Телефон
                        </button>
                        <button class="btn btn-outline-dark shadow-none" @click.prevent="inputShow.password = !inputShow.password">
                            Пароль
                        </button>
                    </div>
                    <div>
                        <input v-show="inputShow.name" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-name" type="text" placeholder="Имя" style="height: 45px;">
                        <input v-show="inputShow.mail" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-mail" type="text"  placeholder="Электронная почта" style="height: 45px;">
                        <input v-show="inputShow.phone" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-phone" type="text"  placeholder="Телефон" style="height: 45px;">
                        <input v-show="inputShow.password" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-password" type="text"  placeholder="Пароль" style="height: 45px;">
                        <input v-show="inputShow.password" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-password" type="text"  placeholder="Подтвердите Пароль" style="height: 45px;">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button @click="saveChanges" class="btn btn-outline-dark mt-3 shadow-none"> Сохранить изменения</button>
                    </div>
                    </div>
            </modal-window>

            <h1 class="mb-4">Профиль</h1>
            <div v-if="profileLoading" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div v-if="user && !profileLoading">

                <div class="row">

                    <router-link to="/profile" class="col-6 pe-3 text-decoration-none text-dark" href="#" @click.prevent="openModal">
                        <div class=" cart-card p-4 h-100">
                            <div class="d-flex flex flex-wrap justify-content-between">
                                <h2 class="mb-3">{{ user.name }}</h2>
                                <h5><i class="fas fa-pen"></i></h5>
                            </div>
                            <h2 class="mb-3">Почта: {{ user.email }}</h2>
                            <h2 class="">Телефон:</h2>
                        </div>
                    </router-link>

                    <router-link to="/orders" class="col-6 ps-3 text-decoration-none text-dark" href="#">
                        <div class="cart-card p-4 h-100">
                            <div class="d-flex flex flex-wrap justify-content-between">
                                <h2>Заказы</h2>
                                <h5><i class="fas fa-truck-moving"></i></h5>
                            </div>

<!--                            <i class="fas fa-truck-moving"></i>-->
<!--                            <i class="fas fa-truck-loading"></i>-->
                            <div class="d-flex" style="overflow: scroll; overflow-y: hidden">
                                <div v-if="orders && !profileLoading" v-for="order in orders.slice(0, 3)" class="d-flex me-3">
                                    <div class="d-flex flex-column border border-secondary border-0 border-end pe-3">
                                        <div class="d-flex justify-content-between">
                                            <div class="p-2">Номер: {{ order.id }}</div>
                                            <div class="p-2">Сумма: {{ order.total_price }} ₽</div>
                                        </div>
                                        <div class="p-2">Товары:</div>
                                        <div class="d-flex">
                                            <div v-for="orderProduct in order.products" class="p-2 card mb-4 mx-2">
                                                <img :src="orderProduct.image_url" width="100" height="100" alt="">
                                                <router-link :to="`/products/${orderProduct.id}`" class="link-dark">{{ orderProduct.title }}</router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <a class="link-secondary float-right pe-4">Все заказы</a>
                            </div>
                        </div>
                    </router-link>

                </div>


                <div class="row mt-4">

                    <router-link to="/purchases" class="col-4 pe-3 text-decoration-none text-dark" href="#">
                        <div class=" cart-card ps-4 pt-4 pb-4 h-100">
                            <h2 class="mb-3">Совершенные покупки</h2>
                        </div>
                    </router-link>

                    <router-link to="/cart" class="col-4 ps-3 text-decoration-none text-dark" href="#">
                        <div class="cart-card p-4 h-100">
                            <div class="d-flex flex flex-w2ap justify-content-between">
                                <h2>Корзина</h2>
                                <h4><i class="fas fa-shopping-cart"></i></h4>
                            </div>
<!--                            <p v-if="Object.keys(productsInCart).length <= 0" class="d-inline">Корзина пока пуста</p>-->
                            <div v-if="productsInCart" v-for="(product, index) in productsInCart" class="d-flex align-items-center">
                                <router-link class="p-2" :to="`/products/${product.id}`">
                                    <img :src="product.image_url" width="50" height="50" alt="">
                                </router-link>
                                <router-link class="p-2 text-decoration-none flex-grow-1" :to="`/products/${product.id}`" style="color: #343a40">
                                    {{ product.title }}
                                </router-link>
                                <i class="fas fa-trash me-4 link-danger" :id="`removeProductFromCart${product.id}`" @click.prevent="deleteProductAsCart(product, index)" style="color: #dc3545;"></i>
                            </div>
                        </div>
                    </router-link>

                    <router-link to="/wishlist" class="col-4 ps-3 text-decoration-none text-dark" href="#">
                        <div class="cart-card p-4 h-100">
                            <div class="d-flex flex flex-w2ap justify-content-between">
                                <h2>Желаемое</h2>
                                <h4><i class="fas fa-heart text-red"></i></h4>
                            </div>
                            <p v-if="Object.keys(wishlist).length <= 0" class="d-inline">Список желаемых товров пуст</p>
                            <div v-if="wishlist" v-for="(wish, index) in wishlist" class="d-flex align-items-center">
                                <router-link class="p-2" :to="`/products/${wish.product.id}`">
                                    <img :src="wish.product.image_url" width="50" height="50" alt="">
                                </router-link>
                                <router-link class="p-2 text-decoration-none flex-grow-1" :to="`/products/${wish.product.id}`" style="color: #343a40">
                                    {{ wish.product.title }}
                                </router-link>
                                <i class="fas fa-trash me-4 link-danger" :id="`removeWish${wish.product.id}`" style="color: #dc3545;" @click.prevent="removeWish(wish)"></i>
                            </div>
                        </div>
                    </router-link>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ModalWindow from "../../components/UI/modalWindow.vue";
export default {
    name: "Profile",
    components: {
        ModalWindow
    },
    data() {
        return {
            user: this.$store.state.auth.user,
            orders: [],
            wishlist: this.$root.wishlist,
            productsInCart: this.$root.productsInCart,
            profileLoading: null,
            modalVisibility: false,
            inputShow: {
                name: false,
                mail: false,
                phone: false,
                password: false,
            },
        }
    },

    mounted() {
        this.getOrders()
        this.wishlist = this.$root.wishlist
    },

    methods: {
        deleteProductAsCart(product, indexInCart) {
            let cart = JSON.parse(localStorage.getItem('cart'))
            cart.splice(indexInCart, 1)
            localStorage.setItem('cart', JSON.stringify(cart))
            this.$root.getProductsInCart()
            this.productsInCart = this.$root.productsInCart
        },

        // ?????? недописано?
        saveChanges() {
            this.modalVisibility = false
            this.inputShow.name = false
            this.inputShow.mail = false
            this.inputShow.phone = false
            this.inputShow.password = false
        },

        openModal() {
            this.modalVisibility = true
        },

        getOrders() {
            this.profileLoading = true
            axios.post('/api/orders', {
                user_id: this.user.id
            })
                .then(response => {
                    this.orders = response.data.data
                    this.profileLoading = false
                })
                .catch(error => {
                    console.log(error);
                })
        },

        removeWish(wish) {
            axios.delete('/api/wish/' + wish.id + '/delete')
                .then(response => {
                    this.$root.wishlist = this.wishlist.filter(w => w.id !== wish.id);
                    this.wishlist = this.$root.wishlist
                })
                .catch(error => {
                    console.log(error);
                })
        },

    }
}




</script>

<style>


</style>
