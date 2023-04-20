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

            <div v-if="loaded" class="d-flex col w-100">

                <div class="d-flex flex-column flex-grow-1 col-2 me-4" style="max-width: 200px;">
                    <form class="" v-if="filters">
                        <h3 class="mb-3">Фильтры</h3>
                        <h5>Категории</h5>
                        <div v-for="category in filters.categories"
                             class="form-control pb-0 d-flex align-items-baseline mb-2">
                            <p class="me-2">{{ category.title }}</p>
                            <input v-model="categories" type="checkbox" :id="category.id" :value="category.id">
                        </div>
                        <h5 class="mt-4">Теги</h5>
                        <div v-for="tag in filters.tags" class="form-control pb-0 d-flex align-items-baseline mb-2">
                            <p class="me-2">{{ tag.title }}</p>
                            <input v-model="tags" type="checkbox" :id="tag.id" :value="tag.id">
                        </div>

                        <button @click.prevent="filterProducts()" class="btn btn-my-theme">Применить</button>
                    </form>
                </div>

                <div v-if="!loadedProducts" class="d-flex justify-content-center col-10">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>



                <div v-if="loadedProducts" class="row">
                    <product-card-in-catalog v-for="product in products" :product="product" class="card col-4 me-4 mb-4 product-card-hover p-0" :key="product.id" style="width: 15rem;"/>
                </div>

            </div>


        </div>
    </div>
</template>

<script>
import ProductCardInCatalog from "../../components/productCardInCatalog.vue";
export default {
    name: "products.index",
    components: {
        ProductCardInCatalog,

    },
    data() {
        return {
            loadedProducts: false,
            products: [],
            loaded: false,
            filters: [],
            categories: [],
            tags: [],
            price: [],
            pagination: [],
            wishlist: this.$root.wishlist,
            user: this.$store.state.auth.user,
        }
    },

    mounted() {
        this.getProducts()
        this.getFilterList()
        if (this.$store.state.auth.authenticated) {
            this.getWishlist()
        }
    },

    methods: {
        filterProducts() {
            this.loadedProducts = false
            this.getProducts();
        },

        getProducts(page = 1) {
            axios.post('/api/products', {
                categories: this.categories,
                tags: this.tags,
                prices: this.price,
                page: page
            }).then(response => {
                this.products = response.data.data
                this.pagination = response.data.meta
                // console.log(this.products);
                this.loaded = true
                this.loadedProducts = true
            });
        },

        getFilterList() {
            axios.get('http://localhost:8000/api/products/filters').then(response => {
                this.filters = response.data
            });
        },

        getWishlist() {
            axios.post('/api/wishlist', {
                user_id: this.user.id
            })
                .then(response => {
                    this.wishlist = response.data.data

                })
                .catch(error => {
                    console.log(error);
                })
        },
    }
}
</script>

<style scoped>

</style>
