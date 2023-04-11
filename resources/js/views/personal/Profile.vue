<template>
    <div>
        <div class="container-xxl mt-5">

            <modal-window v-model:openModal="modalVisibility">
                <div class="content-in-modal">
                    <h3 class="mb-3">
                        Выберите что хотите изменить
                    </h3>
                    <div class="mb-3">
                        <button class="btn btn-outline-dark me-3 shadow-none" @click.prevent="showInputName">
                            Имя
                        </button>
                        <button class="btn btn-outline-dark me-3 shadow-none" @click.prevent="showInputMail">
                            Электронная почта
                        </button>
                        <button class="btn btn-outline-dark me-3 shadow-none" @click.prevent="showInputPhone">
                            Телефон
                        </button>
                        <button class="btn btn-outline-dark shadow-none" @click.prevent="showInputPassword">
                            Пароль
                        </button>
                    </div>
                    <div>
                        <input v-show="inputNameShow" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-name" type="text" v-model="name" placeholder="Имя" style="height: 45px;">
                        <input v-show="inputMailShow" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-mail" type="text"  placeholder="Электронная почта" style="height: 45px;">
                        <input v-show="inputPhoneShow" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-phone" type="text"  placeholder="Телефон" style="height: 45px;">
                        <input v-show="inputPasswordShow" class="w-100 border border-dark rounded form-control shadow-none mb-3 input-password" type="text"  placeholder="Пароль" style="height: 45px;">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button @click="saveChanges" class="btn btn-outline-dark mt-3 shadow-none"> Сохранить изменения</button>
                    </div>
                    </div>
            </modal-window>

            <h1 class="mb-4">Профиль</h1>
            <div v-if="!orderLoader" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div v-if="this.$root.user && orderLoader">

                <div class="row">

                    <router-link to="/profile" class="col-6 pe-3 text-decoration-none text-dark" href="#" @click.prevent="openModal">
                        <div class=" cart-card ps-4 pt-4 pb-4 h-100">
                            <div class="d-flex flex flex-wrap justify-content-between">
                                <h2 class="mb-3">{{ this.$root.user.name }}</h2>
                                <h5><i class="fas fa-pen pe-4"></i></h5>
                            </div>
                            <h2 class="mb-3">Почта: {{ this.$root.user.email }}</h2>
                            <h2 class="">Телефон:</h2>
                        </div>
                    </router-link>

                    <router-link to="/orders" class="col-6 ps-3 text-decoration-none text-dark" href="#">
                        <div class=" cart-card ps-4 pt-4 pb-4 h-100">
                            <div class="d-flex flex flex-wrap justify-content-between">
                                <h2>Заказы</h2>
                                <h5><i class="fas fa-truck-moving pe-4"></i></h5>
                            </div>

<!--                            <i class="fas fa-truck-moving"></i>-->
<!--                            <i class="fas fa-truck-loading"></i>-->
                            <div v-if="orders && orderLoader" v-for="order in orders" class="d-flex mb-3">
                                <div class="p-2">#{{ order.id }}</div>
                                <div class="p-2">Товары:</div>
                                <div v-for="orderProduct in order.products" class="p-2">
                                    <router-link :to="`/products/${orderProduct.id}`">{{ orderProduct.title }}</router-link>
                                </div>
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
                        <div class="cart-card ps-4 pt-4 pb-4 h-100">
                            <div class="d-flex flex flex-w2ap justify-content-between">
                                <h2>Корзина</h2>
                                <h4><i class="fas fa-shopping-cart pe-4"></i></h4>
                            </div>
                            <div v-if="wishlist" v-for="(wish, index) in wishlist" class="d-flex">
                                <div class="p-2">#{{ index + 1 }}</div>
                                <router-link class="p-2" :to="`/products/${wish.product.id}`">
                                    <img :src="wish.product.image_url" width="50" height="50" alt="">
                                </router-link>
                                <router-link class="p-2 text-decoration-none" :to="`/products/${wish.product.id}`" style="color: #343a40">
                                    {{ wish.product.title }}
                                </router-link>
                                <i class="fas fa-trash" @click.prevent="removeWish(wish)"></i>
                            </div>
                        </div>
                    </router-link>

                    <router-link to="/wishlist" class="col-4 ps-3 text-decoration-none text-dark" href="#">
                        <div class="cart-card ps-4 pt-4 pb-4 h-100">
                            <div class="d-flex flex flex-w2ap justify-content-between">
                                <h2>Желаемое</h2>
                                <h4><i class="fas fa-heart text-red pe-4"></i></h4>
                            </div>
                            <div v-if="wishlist" v-for="(wish, index) in wishlist" class="d-flex">
                                <div class="p-2">#{{ index + 1 }}</div>
                                <router-link class="p-2" :to="`/products/${wish.product.id}`">
                                    <img :src="wish.product.image_url" width="50" height="50" alt="">
                                </router-link>
                                <router-link class="p-2 text-decoration-none" :to="`/products/${wish.product.id}`" style="color: #343a40">
                                    {{ wish.product.title }}
                                </router-link>
                                <i class="far fa-heart text-red" style="color: #dc3545;" @click.prevent="removeWish(wish)"></i>
                            </div>
                        </div>
                    </router-link>

                </div>
            </div>
<!--            <div v-else>-->
<!--                <h3 class="mb-4">Войдите или зарегистрируйтесь чтобы просматривать профиль</h3>-->
<!--            </div>-->
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
            // user: null,
            orders: [],
            wishlist: [],
            orderLoader: null,
            modalVisibility: false,
            inputNameShow: false,
            inputMailShow: false,
            inputPhoneShow: false,
            inputPasswordShow: false,
        }
    },

    mounted() {
        // this.user = this.$root.getUserFromLocalStorage()
        this.getOrders()
        this.getWishlist()
    },

    methods: {
        showInputName() {
            if (this.inputNameShow) {
                this.inputNameShow = false
            } else {
                this.inputNameShow = true
            }
        },
        showInputMail() {
            if (this.inputMailShow) {
                this.inputMailShow = false
            } else {
                this.inputMailShow = true
            }
        },
        showInputPhone() {
            if (this.inputPhoneShow) {
                this.inputPhoneShow = false
            } else {
                this.inputPhoneShow = true
            }
        },
        showInputPassword() {
            if (this.inputPasswordShow) {
                this.inputPasswordShow = false
            } else {
                this.inputPasswordShow = true
            }
        },
        saveChanges(){
            this.modalVisibility = false
            this.inputNameShow = false
            this.inputMailShow = false
            this.inputPhoneShow = false
            this.inputPasswordShow = false
        },

        openModal() {
            this.modalVisibility = true
            // document.getElementsByClassName('body-scroll')[0].style.overflow = "hidden"


        },
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
        getWishlist() {
            axios.post('/api/wishlist', {
                user_id: this.$root.user.id
            })
                .then(response => {
                    this.wishlist = response.data.data
                    console.log(this.wishlist);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        removeWish(wish) {
            axios.delete('/api/wish/' + wish.id + '/delete')
                .then(response => {
                    console.log(response);
                    this.wishlist = this.wishlist.filter(w => w.id !== wish.id);
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
