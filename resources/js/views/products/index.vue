<template>
  <div>
    <div class="container-xxl mt-5">
      <h1 class="mb-4">Каталог</h1>

      <!-- Pagination -->
      <div class="row" v-if="pagination.last_page > 1">
        <ul class="pagination text-center">
          <li v-if="pagination.current_page !== 1" class="next"><a @click.prevent="getProducts(pagination.current_page-1)" href="" class="nav-link text-dark"><i class="fas fa-arrow-left"></i></a></li>

          <li v-for="link in pagination.links" class="pe-1 ps-1">
            <template v-if="Number(link.label) &&
              (pagination.current_page - link.label < 2 &&
              pagination.current_page - link.label > -2) ||
              Number(link.label) === 1 || Number(link.label) === pagination.last_page
              ">
              <a @click.prevent="getProducts(link.label)" :class="link.active ? 'nav-link text-dark rounded-circle btn btn-warning' : 'nav-link rounded-circle text-light btn btn-dark'" href="#">{{ link.label }}</a>
            </template>
            <template v-if="Number(link.label) &&
              pagination.current_page !== 3 &&
              (pagination.current_page - link.label === 2) ||
              (pagination.current_page !== pagination.last_page - 2 &&
              pagination.current_page - link.label === -2)
              ">
              <a class="nav-link text-dark">...</a>
            </template>
          </li>

          <li v-if="pagination.current_page !== pagination.last_page" class="next">
            <a @click.prevent="getProducts(pagination.current_page+1)" href="" class="nav-link text-dark"><i class="fas fa-arrow-right"></i></a>
          </li>
        </ul>
      </div>
      <!-- end Pagination -->

      <div v-if="!loaded" class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>

      <div v-if="loaded" class="d-flex justify-content-between col w-100">

        <div class="d-flex flex-column flex-grow-1 col-2 me-4" style="max-width: 200px;">
          <form class="" v-if="filters">
            <h3 class="mb-3">Фильтры</h3>
            <h5>Категории</h5>
            <div v-for="category in filters.categories" class="form-control pb-0 d-flex align-items-baseline mb-2">
              <p class="me-2">{{ category.title }}</p>
              <input v-model="categories" type="checkbox" :id="category.id" :value="category.id">
            </div>
            <h5 class="mt-4">Теги</h5>
            <div v-for="tag in filters.tags" class="form-control pb-0 d-flex align-items-baseline mb-2">
              <p class="me-2">{{ tag.title }}</p>
              <input v-model="tags" type="checkbox" :id="tag.id" :value="tag.id">
            </div>

            <button @click.prevent="filterProducts()" class="btn btn-primary">Применить</button>
          </form>
        </div>

        <div v-if="!loadedProducts" class="d-flex justify-content-center col-10">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

        <div v-if="loadedProducts" class="d-flex flex-wrap justify-content-between">


          <div v-for="product in products" class="card d-inline-flex col-4 mb-4 product-card-hover" style="width: 15rem;"><!-- data-bs-toggle="modal" :data-bs-target="`#exampleModal${product.id}`" -->

            <img :src="product.image_url" class="card-img-top" width="200px" alt="...">
            <div class="d-flex flex-column p-3 flex-grow-1">
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="card-title text-black">
                  <router-link :to="{name: 'products.show', params: {id: product.id}}" class="text-dark text-decoration-none">{{ product.title }}</router-link>
                </h6>
              </div>
              <p class="card-text">{{ product.category.title }}</p>
              <p class="card-text text-secondary flex-grow-1">Артикул: {{ product.vendor_code }}</p>
              <p v-for="tag in product.tags" class="alert alert-warning p-1 d-inline-block">{{ tag.title }}</p>
              <h5 class="card-text text-secondary fw-bold">{{ product.price.slice(0, -3) }}<h6 class="ms-2 d-inline"><i class="fas fa-ruble-sign"></i></h6></h5>
              <div class="d-flex justify-content-between align-items-center">
                <a @click.prevent="addToCart(product.id)" href="" class="w-100 m-0 btn btn-warning text-white border-0">В корзину <i class="fas fa-shopping-cart"></i></a>
                <h5 class="p-0 m-0"><a @click.prevent="" class="p-2 pb-0 mb-0 text-danger ms-2"><i class="far fa-heart"></i></a></h5>
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
  name: "products.index",
  mounted() {
    this.getProducts();
    this.getFilterList();
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
    }
  },
  methods: {
    addToCart(id) {

      let cart = localStorage.getItem('cart')

      let newProduct = [{
        'id': id,
        'qty': 1
      }]

      if (!cart) {
        localStorage.setItem('cart', JSON.stringify(newProduct))
      } else {
        cart = JSON.parse(cart)

        cart.forEach(productInCart => {
          if (productInCart.id === id) {
            productInCart.qty = Number(productInCart.qty) + 1
            newProduct = null
          }
        })
        Array.prototype.push.apply(cart, newProduct)

        localStorage.setItem('cart', JSON.stringify(cart))

      }


    },
    filterProducts() {
      this.loadedProducts = false
      this.getProducts();
    },
    getProducts(page = 1) {
      this.axios.post('http://localhost:8000/api/products', {
        categories: this.categories,
        tags: this.tags,
        prices: this.price,
        page: page
      }).then(response => {
        this.products = response.data.data
        this.pagination = response.data.meta
        this.loaded = true
        this.loadedProducts = true
      });
    },
    getFilterList() {
      this.axios.get('http://localhost:8000/api/products/filters').then(response => {
        this.filters = response.data
      });
    }
  }
}
</script>

<style scoped>

</style>
