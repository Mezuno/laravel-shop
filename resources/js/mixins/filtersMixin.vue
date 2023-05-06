<script>
export default {
    name: "filtersMixin",

    methods: {
        filterProductsByCategory(category) {

            if (category === 0) {
                this.filteredByCategoryProducts = this.filterProductsByPrice(this.products, this.dataToGetProducts.price)
                this.filterProductsByTags(this.dataToGetProducts.tags)
                return
            }
            this.filteredByCategoryProducts = this.filterProductsByPrice(this.products, this.dataToGetProducts.price).filter(product => product.category.id === category)
            this.filterProductsByTags(this.dataToGetProducts.tags)
        },

        filterProductsByTags(tags) {
            this.filteredProducts = []
            if (tags.length === 0) {
                this.filteredProducts = this.filteredByCategoryProducts
                this.sortProducts(this.dataToGetProducts.sort)
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
            this.sortProducts(this.dataToGetProducts.sort)
        },

        sortProducts(sortBy) {
            this.sortedAndFilteredProducts = this.filteredProducts
            this.sortedProducts = this.filteredProducts
            if (sortBy === 0) {
                return
            }
            if (sortBy === 1) {
                return
            }
            if (sortBy === 2) {
                this.sortedProducts.sort(function (a, b) {
                    return Number(a.price) - Number(b.price);
                })
                this.sortedAndFilteredProducts = this.sortedProducts
                return
            }
            if (sortBy === 3) {
                this.sortedProducts.sort(function (a, b) {
                    return Number(a.price) - Number(b.price);
                })
                this.sortedAndFilteredProducts = this.sortedProducts.reverse()
                return
            }
            if (sortBy === 4) {
                this.sortedProducts.sort(function (a, b) {
                    return Number(a.avg_rate) - Number(b.avg_rate);
                })
                this.sortedAndFilteredProducts = this.sortedProducts.reverse()
            }
        },

        filterProductsByPrice(products, price) {
            return products.filter(product => (Number(product.price) >= price.min && Number(product.price) <= price.max))
        },
    }
}
</script>

