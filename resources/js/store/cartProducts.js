
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
        ADD_ITEM_TO_CART (state, product) {
            Array.prototype.push.apply(state.products, product)
        },
        CHANGE_ITEM_QTY (state, {indexInCart, qty}) {
            state.products[indexInCart].qty = qty
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

                commit('ADD_ITEM_TO_CART', newProduct)
            }
        },

        changeItemQtyCartProducts({commit}, {indexInCart, qty}) {
            commit('CHANGE_ITEM_QTY', {indexInCart, qty})
        },

        setCartProducts({commit}, value) {
            commit('SET_CART_PRODUCTS', value)
        },

        removeItemFromCart({commit}, product) {
            commit('REMOVE_ITEM_FROM_CART', product)
        },
    }
}
