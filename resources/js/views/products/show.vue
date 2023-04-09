<template>
    <div>
        <div class="container-xxl mt-5 ">

<!--            <div class="d-flex justify-content-center pt-5">-->

                <div v-if="!loaded" class="d-flex justify-content-center pt-5">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div v-if="loaded" class="row mb-5 ">

                    <div class="col-1">
                        <img @click="pictureReplacement(product.image_url)" :src="product.image_url" alt="" class="mb-2 w-100" style="cursor: pointer; border-radius: 7px;" >
                        <img @click="pictureReplacement(productImage.url)" v-for="productImage in product.product_images" :src="productImage.url" alt="" class="mb-2 w-100" style="cursor: pointer; border-radius: 7px;">
                    </div>

                    <div class="col-4">
                        <img :src="product.image_url" class="figure-img w-100 show-product-img" alt="" id="bigProductImage">
                    </div>

                    <div class="col-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>{{ product.title }}</h3>
                        </div>
                        <p class="flex-grow-1">{{ product.description }}</p>
                    </div>

                    <div class="card border border-0 cart-card col-3 h-100 p-4">

                        <h5 class="card-text text-dark fw-bold">{{ product.price.slice(0, -3) }}<h5
                            class="ms-2 d-inline text-dark">₽</h5></h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="w-100 m-0 btn btn-outline-dark">В корзину
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                            <h5 class="p-0 m-0 p-2 pb-0 mb-0 ms-2 text-danger">
                                    <div @click.prevent="" class="position-relative">
                                        <i class="far fa-heart heart-far position-absolute" style="display: block; opacity: 1; cursor: pointer;"></i>
                                        <i class="fas fa-heart heart-fas position-absolute" style="display: none; opacity: 0.5; cursor: pointer;"></i>
                                    </div>
                            </h5>
                        </div>
                    </div>

                </div>

            </div>
        </div>
<!--    </div>-->
</template>

<script>
export default {
    name: "products.show",
    mounted() {
        this.getCategoriesList();
        this.getProduct(this.$router.currentRoute._value.params.id);
    },
    data() {
        return {
            product: null,
            categories: [],
            loaded: false,

        }
    },
    methods: {
        getProduct(id) {
            axios.get(`http://localhost:8000/api/products/${id}`).then(response => {
                this.product = response.data.data
                this.loaded = true
            });
        },
        getCategoriesList() {
            axios.get('http://localhost:8000/api/categories').then(response => {
                this.categories = response.data.data
            });
        },
        pictureReplacement(uri) {
            document.getElementById("bigProductImage").src = uri;
            console.log(document.getElementById("bigProductImage"))
        }
    }
}
</script>

<style scoped>

</style>
