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

            <div v-if="!loaded" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>



            <h3 class="mb-3">Фильтры</h3>
            <filters @getDataToGetProducts="fillDataToGetProducts" class="mb-5" v-model:filters="filters"></filters>

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

<!--                    <button form="filterForm" @click.prevent="filterProducts()" class="btn btn-outline-minor ms-3 h-100 align-self-center">Применить</button>-->
<!--                </form>-->
<!--            </div>-->

            <div v-if="loaded" class="w-0">
                <div class="row products-in-catalog">
                    <product-card
                        v-if="loadedProducts"
                        v-for="product in filteredProducts"
                        :identifier="'Catalog'"
                        :product="product"
                        class="col-3 mb-4 px-3"
                        :key="product.id"
                    />
                </div>
            </div>


<!--            <div class="row" v-if="pagination.last_page > 1">-->
<!--                <ul class="pagination text-center align-items-center">-->
<!--                    <li v-if="pagination.current_page !== 1" class="next"><a-->
<!--                        @click.prevent="getProducts(pagination.current_page-1)" href="" class="nav-link text-minor"><i-->
<!--                        class="fas fa-arrow-left"></i></a></li>-->

<!--                    <li v-for="link in pagination.links" class="pe-1 ps-1">-->
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
<!--                        <template v-if="Number(link.label) &&-->
<!--                              pagination.current_page !== 3 &&-->
<!--                              (pagination.current_page - link.label === 2) ||-->
<!--                              (pagination.current_page !== pagination.last_page - 2 &&-->
<!--                              pagination.current_page - link.label === -2)-->
<!--                        ">-->
<!--                            <a class="nav-link text-minor p-2">...</a>-->
<!--                        </template>-->
<!--                    </li>-->

<!--                    <li v-if="pagination.current_page !== pagination.last_page" class="next">-->
<!--                        <a @click.prevent="getProducts(pagination.current_page+1)" href="" class="nav-link text-minor"><i-->
<!--                            class="fas fa-arrow-right"></i></a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->

        </div>
    </div>
</template>

<script>
import ProductCard from "../../components/products/ProductCard.vue";
import Filters from "../../components/filters/filters.vue";
import radio from "../../components/customButtons/radio.vue";
import checkbox from "../../components/customButtons/checkbox.vue";

import {mapActions} from "vuex";

export default {
    name: "products.index",

    components: {
        Filters,
        ProductCard,
        radio,
        checkbox
    },

    data() {
        return {
            loadedProducts: false,
            products: [],
            filteredProducts: [],
            filteredByCategoryProducts: [],
            filteredByTagsProducts: [],
            loaded: false,
            filters: [],
            dataToGetProducts: {
                category: 0,
                tags: [],
                price: [],
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

        filteredList() {
            let categoryId = this.dataToGetProducts.category;
            return this.products.filter(function (elem) {
                if(categoryId === 0) return true;
                else return elem.products.indexOf(categoryId) > -1;
            })
        }
    },

    methods: {
        ...mapActions({
            syncWishlist:"auth/syncWishlist",
            setWishlist:"auth/setWishlist",
        }),

        fillDataToGetProducts(dataToGetProducts) {
            this.dataToGetProducts.category = 0
            this.dataToGetProducts.tags = []
            this.dataToGetProducts.price = ['0', '99999']
            this.dataToGetProducts.category = dataToGetProducts.category
            dataToGetProducts.tags.forEach((item, index) => {
                this.dataToGetProducts.tags[index] = item + 1
            })
            this.filteredByCategoryProducts = []
            this.filteredByTagsProducts = []
            this.filterProductsByCategory(this.dataToGetProducts.category)
        },

        filterProductsByCategory(category) {
            if (category === 0) {
                this.filteredByCategoryProducts = this.products
                this.filterProductsByTags(this.dataToGetProducts.tags)
                return
            }
            this.filteredByCategoryProducts = this.products.filter(product => product.category.id === category)
            this.filterProductsByTags(this.dataToGetProducts.tags)
        },

        filterProductsByTags(tags) {
            this.filteredProducts = []
            if (tags.length === 0) {
                this.filteredProducts = this.filteredByCategoryProducts
                return
            }

            tags.forEach((tag, index) => {
                this.filteredByTagsProducts[index] = []
                this.filteredByCategoryProducts.forEach(product => {

                    if (product.tags.length > 0) {

                        product.tags.forEach((productTag) => {

                            if (productTag.id === tag) {
                                this.filteredByTagsProducts[index].push(product)


                            }
                        })
                    }
                })
                this.filteredProducts = _.uniq(this.filteredProducts.concat(this.filteredByTagsProducts[index]))
            })
            console.log(this.filteredProducts)
        },

        getProducts() {
            axios.get('/api/products').then(response => {
                this.products = response.data.data
                this.filteredProducts = this.products
                // console.log(this.products)
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
