<script>
export default {
    name: "filtersMixin",

    methods: {

        sortAndFilterProducts(products, filters) {
            let localProducts = products
            localProducts = this.filterProductsByPrice(localProducts, filters.price)
            localProducts = this.filterProductsByCategory(localProducts, filters.category)
            localProducts = this.filterProductsByTags(localProducts, filters.tags)
            localProducts = this.sortProductsBy(localProducts, filters.sort)
            return localProducts
        },

        filterProductsByPrice(products, price) {
            return products.filter(product => (Number(product.price) >= price.min && Number(product.price) <= price.max))
        },

        filterProductsByCategory(products, category) {
            if (category === 0) {
                return products
            }
            return products.filter(product => product.category.id === category)
        },

        filterProductsByTags(products, tags) {
            if (tags.length === 0) {
                return products
            }
            let filteredProducts = []
            let intermediateProducts = []
            tags.forEach((tag, index) => {
                intermediateProducts[index] = []
                products.forEach((product) => {
                    if (product.tags.length > 0) {
                        product.tags.forEach((productTag) => {
                            if (productTag.id-1 === tag) {
                                console.log(productTag.id, tag)
                                intermediateProducts[index].push(product)
                            }
                        })
                    }
                })
                filteredProducts = filteredProducts.concat(intermediateProducts[index])
            })
            return _.uniq(filteredProducts)
        },

        sortProductsBy(products, sortBy) {
            let sortProducts = products
            if (sortBy === 0) {
                return sortProducts
            }
            if (sortBy === 1) {
                return sortProducts
            }
            if (sortBy === 2) {
                return sortProducts.sort(function (firstProduct, secondProduct) {
                    return Number(firstProduct.price) - Number(secondProduct.price);
                })
            }
            if (sortBy === 3) {
                return sortProducts.sort(function (firstProduct, secondProduct) {
                    return Number(secondProduct.price) - Number(firstProduct.price);
                })
            }
            if (sortBy === 4) {
                return sortProducts.sort(function (firstProduct, secondProduct) {
                    return Number(secondProduct.avg_rate) - Number(firstProduct.avg_rate);
                })
            }
        },

    }
}
</script>

