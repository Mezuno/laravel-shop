<template>
  <div>
    <div class="container-xxl mt-5">

      <div class="d-flex justify-content-center pt-5">

        <div v-if="!loaded">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        <div v-if="loaded" class="d-flex flex-wrap justify-content-between">

          <div class="d-inline-flex mb-4"><!-- data-bs-toggle="modal" :data-bs-target="`#exampleModal${product.id}`" -->

            <div class="d-flex flex-column me-2">
              <img v-for="productImage in product.product_images" :src="productImage.url" alt="" width="50" class="mb-2">
            </div>
            <div class="bg-image hover-zoom hovereffect">
              <img :src="product.image_url" class="figure-img" width="500" height="500" alt="...">
            </div>
            <div class="d-flex flex-column p-3 pb-0 pt-0 flex-grow-0">
              <div class="d-flex justify-content-between align-items-center">
                <h3>{{ product.title }}</h3>
              </div>
              <p class="flex-grow-1">{{ product.description }}</p>
              <h5 class="card-text text-secondary fw-bold">{{ product.price.slice(0, -3) }}<h6 class="ms-2 d-inline"><i class="fas fa-ruble-sign"></i></h6></h5>
              <div class="d-flex justify-content-between align-items-center">
                <a href="#" class="w-100 m-0 btn btn-warning">В корзину <i class="fas fa-shopping-cart"></i></a>
                <h5 class="p-0 m-0"><a @onclick.prevent="" class="p-2 pb-0 mb-0 text-danger ms-2"><i class="far fa-heart"></i></a></h5>
              </div>
            </div>


          </div>

        </div>

      </div>
    </div>
  </div>
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
      this.axios.get(`http://localhost:8000/api/products/${id}`).then(response => {
        this.product = response.data.data
        this.loaded = true
        console.log(response)
      });
    },
    getCategoriesList() {
      this.axios.get('http://localhost:8000/api/categories').then(response => {
        this.categories = response.data.data
        // console.log(response)
        // console.log(this.categories)
      });
    }
  }
}
</script>

<style scoped>

</style>