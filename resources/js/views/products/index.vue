<template>
    <div>
        <div class="container-xxl mt-5">

            <h1 class="mb-4">Каталог</h1>

<!--            &lt;!&ndash; Pagination &ndash;&gt;-->
<!--            <div class="row" v-if="pagination.last_page > 1">-->
<!--                <ul class="pagination text-center align-items-center">-->


<!--                    &lt;!&ndash; Arrow left &ndash;&gt;-->
<!--                    <li v-if="pagination.current_page !== 1" class="next">-->
<!--                        <a @click.prevent="getProducts(pagination.current_page-1)" href="" class="nav-link text-minor">-->
<!--                            <i class="fas fa-arrow-left"></i>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    &lt;!&ndash; end Arrow left &ndash;&gt;-->

<!--                    &lt;!&ndash; Main pagination list &ndash;&gt;-->
<!--                    <li v-for="link in pagination.links" class="pe-1 ps-1">-->

<!--                        &lt;!&ndash; Pagination list &ndash;&gt;-->
<!--                        <template v-if="Number(link.label) &&-->
<!--                              (pagination.current_page - link.label < 2 &&-->
<!--                              pagination.current_page - link.label > -2) ||-->
<!--                              Number(link.label) === 1 || Number(link.label) === pagination.last_page-->
<!--                        ">-->
<!--                            <a @click.prevent="getProducts(link.label)"-->
<!--                               :class="link.active ? 'text-minor rounded-circle btn btn-main' : 'rounded-circle text-light btn btn-minor'"-->
<!--                               href="#"-->
<!--                               style="width: 40px">{{ link.label }}</a>-->
<!--                        </template>-->
<!--                        &lt;!&ndash; end Pagination list &ndash;&gt;-->

<!--                        &lt;!&ndash; ... &ndash;&gt;-->
<!--                        <template v-if="Number(link.label) &&-->
<!--                              pagination.current_page !== 3 &&-->
<!--                              (pagination.current_page - link.label === 2) ||-->
<!--                              (pagination.current_page !== pagination.last_page - 2 &&-->
<!--                              pagination.current_page - link.label === -2)-->
<!--                        ">-->
<!--                            <a class="nav-link text-minor p-2">...</a>-->
<!--                        </template>-->
<!--                        &lt;!&ndash; end ... &ndash;&gt;-->
<!--                    </li>-->
<!--                    &lt;!&ndash; end Main pagination list &ndash;&gt;-->

<!--                    &lt;!&ndash; Arrow right &ndash;&gt;-->
<!--                    <li v-if="pagination.current_page !== pagination.last_page" class="next">-->
<!--                        <a @click.prevent="getProducts(pagination.current_page+1)" href="" class="nav-link text-minor">-->
<!--                            <i class="fas fa-arrow-right"></i>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    &lt;!&ndash; end Arrow right &ndash;&gt;-->
<!--                </ul>-->
<!--            </div>-->
<!--            &lt;!&ndash; end Pagination &ndash;&gt;-->


            <h3 class="mb-3">Фильтры</h3>
            <filters
                @getDataToGetProducts="fillDataToGetProducts"
                class="mb-4"
                v-model:filters="filters"
                v-model:dataToGetProducts="dataToGetProducts"
            />



            <div v-if="!loaded" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-if="loaded && Object.keys(sortedAndFilteredProducts).length === 0">
                Ничего не найдено, попробуйте изменить фильтры
            </div>

            <div v-if="loaded" class="w-100">
                <div class="row products-in-catalog">
                    <product-card
                        v-if="loadedProducts"
                        v-for="product in sortedAndFilteredProducts"
                        :identifier="'Catalog'"
                        :product="product"
                        class="col-6 col-sm-6 col-md-4 col-lg-3 mb-4 px-3"
                        :key="product.id"
                    />
                </div>
            </div>


        </div>
    </div>
</template>

<script>
import filtersMixin from "@/mixins/filtersMixin.vue";
import ProductCard from "@/components/products/ProductCard.vue";
import Filters from "@/components/filters/filters.vue";
import radio from "@/components/customButtons/radio.vue";
import checkbox from "@/components/customButtons/checkbox.vue";

import {mapActions} from "vuex";

export default {
    name: "products.index",

    components: {
        Filters,
        ProductCard,
        radio,
        checkbox
    },

    mixins: [filtersMixin],

    data() {
        return {
            loadedProducts: false,
            products: [],
            filteredProducts: [],
            filteredByPriceProducts: [],
            filteredByCategoryProducts: [],
            filteredByTagsProducts: [],
            sortedProducts: [],
            sortedAndFilteredProducts: [],
            loaded: false,
            filters: [],
            dataToGetProducts: {
                sort: 0,
                category: 0,
                tags: [],
                price: {
                    min: '0',
                    max: '99999'
                },
            },
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
        },
    },

    methods: {
        ...mapActions({
            syncWishlist:"auth/syncWishlist",
            setWishlist:"auth/setWishlist",
        }),

        fillDataToGetProducts(dataToGetProducts) {
            this.dataToGetProducts.sort = 0
            this.dataToGetProducts.category = 0
            this.dataToGetProducts.tags = []
            this.dataToGetProducts.price = dataToGetProducts.price
            this.dataToGetProducts.category = dataToGetProducts.category
            this.dataToGetProducts.sort = dataToGetProducts.sort
            dataToGetProducts.tags.forEach((item, index) => {
                this.dataToGetProducts.tags[index] = item + 1
            })
            this.filteredByCategoryProducts = {}
            this.filteredByTagsProducts = {}
            this.filterProductsByCategory(this.dataToGetProducts.category)
        },

        getProducts() {
            axios.get('/api/products').then(response => {
                this.products = response.data.data
                this.filteredProducts = this.products
                this.sortedProducts = this.filteredProducts
                this.sortedAndFilteredProducts = this.sortedProducts
                this.loaded = true
                this.loadedProducts = true
            });
        },

        getFilterList() {
            axios.get('/api/products/filters').then(response => {
                this.filters = response.data
                this.filters.categories.unshift({id: 0, title: 'Все категории', })
            });
        },
    }
}
</script>

<style scoped>

</style>
