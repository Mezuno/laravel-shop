<template>
    <div>
        <div class="container-xxl mt-5">
            <h1 class="mb-4">Каталог</h1>

            <!-- Pagination -->
            <div class="row" v-if="pagination.last_page > 1">
                <ul class="pagination text-center align-items-center">
                    <li v-if="pagination.current_page !== 1" class="next"><a
                        @click.prevent="getProducts(pagination.current_page-1)" href="" class="nav-link text-dark"><i
                        class="fas fa-arrow-left"></i></a></li>

                    <li v-for="link in pagination.links" class="pe-1 ps-1">
                        <template v-if="Number(link.label) &&
                              (pagination.current_page - link.label < 2 &&
                              pagination.current_page - link.label > -2) ||
                              Number(link.label) === 1 || Number(link.label) === pagination.last_page
                        ">
                            <a @click.prevent="getProducts(link.label)"
                               :class="link.active ? 'text-dark rounded-circle btn btn-warning' : 'rounded-circle text-light btn btn-dark'"
                               href="#"
                               style="width: 40px">{{ link.label }}</a>
                        </template>
                        <template v-if="Number(link.label) &&
                              pagination.current_page !== 3 &&
                              (pagination.current_page - link.label === 2) ||
                              (pagination.current_page !== pagination.last_page - 2 &&
                              pagination.current_page - link.label === -2)
                        ">
                            <a class="nav-link text-dark p-2">...</a>
                        </template>
                    </li>

                    <li v-if="pagination.current_page !== pagination.last_page" class="next">
                        <a @click.prevent="getProducts(pagination.current_page+1)" href="" class="nav-link text-dark"><i
                            class="fas fa-arrow-right"></i></a>
                    </li>
                </ul>
            </div>
            <!-- end Pagination -->

            <div v-if="!loaded" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>



            <h3 class="mb-3">Фильтры</h3>
            <filters class="mb-5" v-model:filters="filters"></filters>



<!--            <div class="d-flex flex-column flex-grow-1 col-2 me-4 mb-4" style="max-width: 200px;">-->
<!--                <h3 class="mb-3">Фильтры</h3>-->
<!--                <form v-if="filters" class="d-flex" id="filterForm">-->
<!--                    <div class="d-flex flex-column">-->
<!--                        <h5>Категории</h5>-->
<!--                        <div class="d-flex" style="margin: 0 -7px;">-->
<!--                            <div v-for="category in filters.categories"-->
<!--                                 class="form-control pb-0 d-flex align-items-baseline mx-2">-->
<!--                                <p class="me-2 mb-2 text-nowrap">{{ category.title }}</p>-->
<!--                                <input v-model="dataToGetProducts.categories" type="checkbox" :id="category.id" :value="category.id">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="d-flex flex-column ms-4">-->
<!--                        <h5>Теги</h5>-->
<!--                        <div class="d-flex" style="margin: 0 -7px;">-->
<!--                            <div v-for="tag in filters.tags" class="form-control pb-0 d-flex align-items-baseline mb-2 mx-2">-->
<!--                                <p class="me-2 mb-2 text-nowrap">{{ tag.title }}</p>-->
<!--                                <input v-model="dataToGetProducts.tags" type="checkbox" :id="tag.id" :value="tag.id">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

<!--                    <button form="filterForm" @click.prevent="filterProducts()" class="btn btn-outline-dark ms-3 h-100 align-self-center">Применить</button>-->
<!--                </form>-->
<!--            </div>-->

            <div v-if="loaded" class="w-0">
                <div class="row products-in-catalog">
                    <product-card v-if="loadedProducts" v-for="product in products" :identifier="'Catalog'" :product="product" class="col-3 mb-4 px-3" :key="product.id"/>
                </div>

            </div>


            <div class="row" v-if="pagination.last_page > 1">
                <ul class="pagination text-center align-items-center">
                    <li v-if="pagination.current_page !== 1" class="next"><a
                        @click.prevent="getProducts(pagination.current_page-1)" href="" class="nav-link text-dark"><i
                        class="fas fa-arrow-left"></i></a></li>

                    <li v-for="link in pagination.links" class="pe-1 ps-1">
                        <template v-if="Number(link.label) &&
                              (pagination.current_page - link.label < 2 &&
                              pagination.current_page - link.label > -2) ||
                              Number(link.label) === 1 || Number(link.label) === pagination.last_page
                        ">
                            <a @click.prevent="getProducts(link.label)"
                               :class="link.active ? 'text-dark rounded-circle btn btn-warning' : 'rounded-circle text-light btn btn-dark'"
                               href="#"
                               style="width: 40px">{{ link.label }}</a>
                        </template>
                        <template v-if="Number(link.label) &&
                              pagination.current_page !== 3 &&
                              (pagination.current_page - link.label === 2) ||
                              (pagination.current_page !== pagination.last_page - 2 &&
                              pagination.current_page - link.label === -2)
                        ">
                            <a class="nav-link text-dark p-2">...</a>
                        </template>
                    </li>

                    <li v-if="pagination.current_page !== pagination.last_page" class="next">
                        <a @click.prevent="getProducts(pagination.current_page+1)" href="" class="nav-link text-dark"><i
                            class="fas fa-arrow-right"></i></a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</template>

<script>
import ProductCard from "../../components/products/ProductCard.vue";
import Filters from "../../components/filters/filters.vue";

import {mapActions} from "vuex";

export default {
    name: "products.index",

    components: {
        Filters,
        ProductCard,
    },

    data() {
        return {
            loadedProducts: false,
            products: [],
            loaded: false,
            filters: [],
            dataToGetProducts: {
                categories: [],
                tags: [],
                price: [],
                page: 1,
            },
            pagination: [],
        }
    },

    mounted() {
        this.getProducts()
        this.getFilterList()
        if (this.authenticated) {
            this.setWishlist()
        }
    },

    unmounted() {
        if (this.authenticated) {
            this.syncWishlist()
        }
    },

    computed: {
        user: function () {
            return this.$store.state.auth.user
        },
        wishlist: function () {
            return this.$store.state.auth.wishlist
        },
        authenticated: function () {
            return this.$store.state.auth.authenticated
        }
    },

    methods: {
        ...mapActions({
            syncWishlist:"auth/syncWishlist",
            setWishlist:"auth/setWishlist",
        }),

        filterProducts() {
            this.loadedProducts = false
            this.getProducts();
        },

        getProducts(page = 1) {
            this.dataToGetProducts.page = page
            axios.post('/api/products', this.dataToGetProducts).then(response => {
                this.products = response.data.data
                this.pagination = response.data.meta
                this.loaded = true
                this.loadedProducts = true
            });
        },

        getFilterList() {
            axios.get('http://localhost:8000/api/products/filters').then(response => {
                this.filters = response.data
            });
        },
    }
}
</script>

<style scoped>

</style>
