
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
            console.log(product);
            state.products = state.products.filter(p => p.id !== product.id)
            console.log(state.products);
        },
    },
    actions:{

        addToCartProducts({commit, state}, {newProduct, product}) {
            let productInCartQty

            console.log(newProduct);
            console.log(product);
            console.log(state.products);

            if (!state.products) {
                state.products = [newProduct]
                productInCartQty = 1
            } else {
                state.products.forEach(productInCart => {
                    if (productInCart.id === product.id) {
                        productInCart.qty = Number(productInCart.qty) + 1
                        newProduct = null
                        productInCartQty = productInCart.qty
                    }
                })
                if (newProduct != null) {
                    productInCartQty = 1
                }
                Array.prototype.push.apply(state.products, newProduct)
            }
        },

        removeItemFromCart({commit}, product) {
            console.log(product);
            commit('REMOVE_ITEM_FROM_CART', product)
        },
    }
}
