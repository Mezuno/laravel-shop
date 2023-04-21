
export default {
    namespaced: true,
    state:{
        products:{},
    },
    getters:{
        products(state){
            return state.products
        },
    },
    mutations:{
        SET_CART_PRODUCTS (state, value) {
            state.products = value
        },
        REMOVE_ITEM_FROM_CART (state, product) {
            state.products = state.products.filter(p => p.id !== product.id)
        },
    },
    actions:{

        storeOrder() {
            // maybe later...
        },

        addToCartProducts({commit, state}, {newProduct, product}) {
            if (!state.products || Object.keys(state.products).length < 1) {
                state.products = newProduct
            } else {
                state.products.forEach(productInCart => {
                    if (productInCart.id === product.id) {
                        productInCart.qty = Number(productInCart.qty) + 1
                        newProduct = null
                    }
                })
                Array.prototype.push.apply(state.products, newProduct)
            }
        },

        changeItemQtyCartProducts({state}, {indexInCart, count}) {
            state.products[indexInCart].qty = count
        },

        setCartProducts({commit}, value) {
            commit('SET_CART_PRODUCTS', value)
        },

        removeItemFromCart({commit}, product) {
            commit('REMOVE_ITEM_FROM_CART', product)
        },
    }
}
