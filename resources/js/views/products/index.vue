<template>
    <div>
        <div class="container-xxl container-lg mt-5">

            <!-- Pagination -->
<!--            <div class="row" v-if="pagination.last_page > 1">-->
<!--&lt;!&ndash;                <ul class="pagination text-center align-items-center">&ndash;&gt;-->
<!--&lt;!&ndash;    &ndash;&gt;-->
<!--&lt;!&ndash;    &ndash;&gt;-->
<!--&lt;!&ndash;                    &lt;!&ndash; Arrow left &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                    <li v-if="pagination.current_page !== 1" class="next">&ndash;&gt;-->
<!--&lt;!&ndash;                        <a @click.prevent="getProducts(pagination.current_page-1)" href="" class="nav-link text-minor">&ndash;&gt;-->
<!--&lt;!&ndash;                            <i class="fas fa-arrow-left"></i>&ndash;&gt;-->
<!--&lt;!&ndash;                        </a>&ndash;&gt;-->
<!--&lt;!&ndash;                    </li>&ndash;&gt;-->
<!--&lt;!&ndash;                    &lt;!&ndash; end Arrow left &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;    &ndash;&gt;-->
<!--&lt;!&ndash;                    &lt;!&ndash; Main pagination list &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                    <li v-for="link in pagination.links" class="pe-1 ps-1">&ndash;&gt;-->
<!--&lt;!&ndash;    &ndash;&gt;-->
<!--&lt;!&ndash;                        &lt;!&ndash; Pagination list &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                        <template v-if="Number(link.label) &&&ndash;&gt;-->
<!--&lt;!&ndash;                              (pagination.current_page - link.label < 2 &&&ndash;&gt;-->
<!--&lt;!&ndash;                              pagination.current_page - link.label > -2) ||&ndash;&gt;-->
<!--&lt;!&ndash;                              Number(link.label) === 1 || Number(link.label) === pagination.last_page&ndash;&gt;-->
<!--&lt;!&ndash;                        ">&ndash;&gt;-->
<!--&lt;!&ndash;                            <a @click.prevent="getProducts(link.label)"&ndash;&gt;-->
<!--&lt;!&ndash;                               :class="link.active ? 'text-minor rounded-circle btn btn-main' : 'rounded-circle text-light btn btn-minor'"&ndash;&gt;-->
<!--&lt;!&ndash;                               href="#"&ndash;&gt;-->
<!--&lt;!&ndash;                               style="width: 40px">{{ link.label }}</a>&ndash;&gt;-->
<!--&lt;!&ndash;                        </template>&ndash;&gt;-->
<!--&lt;!&ndash;                        &lt;!&ndash; end Pagination list &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;    &ndash;&gt;-->
<!--&lt;!&ndash;                        &lt;!&ndash; ... &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                        <template v-if="Number(link.label) &&&ndash;&gt;-->
<!--&lt;!&ndash;                              pagination.current_page !== 3 &&&ndash;&gt;-->
<!--&lt;!&ndash;                              (pagination.current_page - link.label === 2) ||&ndash;&gt;-->
<!--&lt;!&ndash;                              (pagination.current_page !== pagination.last_page - 2 &&&ndash;&gt;-->
<!--&lt;!&ndash;                              pagination.current_page - link.label === -2)&ndash;&gt;-->
<!--&lt;!&ndash;                        ">&ndash;&gt;-->
<!--&lt;!&ndash;                            <a class="nav-link text-minor p-2">...</a>&ndash;&gt;-->
<!--&lt;!&ndash;                        </template>&ndash;&gt;-->
<!--&lt;!&ndash;                        &lt;!&ndash; end ... &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                    </li>&ndash;&gt;-->
<!--&lt;!&ndash;                    &lt;!&ndash; end Main pagination list &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;    &ndash;&gt;-->
<!--&lt;!&ndash;                    &lt;!&ndash; Arrow right &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                    <li v-if="pagination.current_page !== pagination.last_page" class="next">&ndash;&gt;-->
<!--&lt;!&ndash;                        <a @click.prevent="getProducts(pagination.current_page+1)" href="" class="nav-link text-minor">&ndash;&gt;-->
<!--&lt;!&ndash;                            <i class="fas fa-arrow-right"></i>&ndash;&gt;-->
<!--&lt;!&ndash;                        </a>&ndash;&gt;-->
<!--&lt;!&ndash;                    </li>&ndash;&gt;-->
<!--&lt;!&ndash;                    &lt;!&ndash; end Arrow right &ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                </ul>&ndash;&gt;-->
<!--            </div>-->
            <!-- end Pagination -->

            <h1 v-if="searchValue === ''" class="mb-4">Каталог</h1>
            <h1 v-else class="mb-4">
                По запросу «{{ searchValue }}» найдено {{ searchedProductsAfterFilter.length }} товаров
            </h1>

            <h3 class="mb-3">Фильтры</h3>
            <filters
                @getDataToGetProducts="fillDataToGetProducts"
                class="mb-4"
                v-model:filters="filters"
                v-model:dataToGetProducts="dataToGetProducts"
                :searchValue="searchValue"
                @deleteCurrentSearchValue="deleteCurrentSearchValue"
            />

            <div v-if="!loaded" class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-if="loaded && Object.keys(searchedProductsAfterFilter).length === 0">
                Ничего не найдено, попробуйте изменить фильтры или поисковый запрос
            </div>

            <div v-if="loaded" class="w-100">
                <div class="row products-in-catalog">
                    <product-card
                        v-if="loadedProducts"
                        v-for="product in searchedProductsAfterFilter"
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
import ProductCard from "@/components/products/ProductCard.vue";
import Filters from "@/components/filters/filters.vue";
import filtersMixin from "@/mixins/filtersMixin.vue";

import {mapActions} from "vuex";

export default {
    name: "products.index",

    components: {
        Filters,
        ProductCard,
    },

    props: {
        searchValue: {
            type: String,
            default: '',
        }
    },

    mixins: [filtersMixin],

    data() {
        return {
            loaded: false,
            loadedProducts: false,
            products: [],
            filteredProducts: [],
            searchedProductsAfterFilter : [],
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

    watch: {
        searchValue() {
            this.searchedProductsAfterFilter = this.search(this.filteredProducts, this.searchValue)
            return this.searchValue
        }
    },

    methods: {
        ...mapActions({
            syncWishlist:"auth/syncWishlist",
            setWishlist:"auth/setWishlist",
        }),

        deleteCurrentSearchValue() {
            this.$emit('deleteCurrentSearchValue')
        },

        parseSearchValue(searchValue) {

            let lower = searchValue.toLowerCase()
            let parse = lower.split(' ')
            return parse.filter(item => item !== '' && item !== null)
        },

        fillDataToGetProducts(dataToGetProducts) {
            this.dataToGetProducts = dataToGetProducts
            this.filteredProducts = this.products
            this.filteredProducts = this.sortAndFilterProducts(this.products, dataToGetProducts)
            this.searchedProductsAfterFilter = this.filteredProducts
            if (this.searchValue !== '') {
                this.searchedProductsAfterFilter = this.search(this.filteredProducts, this.searchValue)
            }
        },

        search(products, search) {
            let localProducts = products
            let parsedSearch = this.parseSearchValue(search)
            localProducts.forEach((product) => {
                product.coincidences = 0
                parsedSearch.forEach((word) => {
                    if (product.title.toLowerCase().includes(word)) {
                        product.coincidences = product.coincidences + 3
                    }
                    if (product.company.title.toLowerCase().includes(word)) {
                        product.coincidences = product.coincidences + 3
                    }
                    if (product.description.toLowerCase().includes(word)) {
                        product.coincidences = product.coincidences + 2
                    }
                    if (product.category.title.toLowerCase().includes(word)) {
                        product.coincidences = product.coincidences + 1
                    }
                    product.tags.forEach((tag) => {
                        if (tag.title.toLowerCase().includes(word)) {
                            product.coincidences = product.coincidences + 1
                        }
                    })
                })
            })
            localProducts.sort((firstProduct, secondProduct) => {
                return Number(secondProduct.coincidences) - Number(firstProduct.coincidences);
            })
            // localProducts.forEach((product, index) => {
            //     if (product.coincidences === 0) {
            //         localProducts.splice(index, 1)
            //     }
            // })
            return localProducts
        },

        getProducts() {
            axios.get('/api/products').then(response => {
                this.products = response.data.data
                this.searchedProductsAfterFilter = this.products
                this.filteredProducts = this.products
                this.loaded = true
                this.loadedProducts = true
            });
        },

        getFilterList() {
            axios.get('/api/products/filters').then(response => {
                this.filters = response.data
                this.filters.tags.forEach((tag) => {
                    tag.id = tag.id-1
                })
                this.filters.categories.unshift({id: 0, title: 'Все категории', })
            });
        },
    }
}
</script>

<style scoped>

</style>
