<template>
  <div>
    <div class="container-xxl mt-5">
      <h1>Главная</h1>

    </div>
  </div>
</template>

<script>
export default {
  name: "Index",
  mounted() {
    this.getProducts();
  },
  data() {
    return {
      products: []
    }
  },
  methods: {
    getProducts() {
      this.axios.post('http://localhost:8000/api/products', {}).then(response => {
        this.products = response.data.data
        this.loaded = true
        this.loadedProducts = true
        console.log(response.data)
        // console.log(this.products)
      });
    },
  }
}
</script>

<style scoped>

</style>