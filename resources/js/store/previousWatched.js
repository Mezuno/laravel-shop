
export default {
    namespaced: true,
    state:{
        products:[],
    },
    getters:{
        products(state){
            return state.products
        },
    },
    mutations:{
        REMOVE_ITEM_FROM_PREVIOUS_WATCHED_PRODUCTS (state, index) {
            state.products.splice(index, 1)
        },
        ADD_ITEM_TO_PREVIOUS_WATCHED_PRODUCTS (state, product) {
            state.products.unshift(product)
        },
    },
    actions:{

        addItemToPreviousWatched({commit, state}, product) {
            if (!state.products || Object.keys(state.products).length < 1) {
                commit('ADD_ITEM_TO_PREVIOUS_WATCHED_PRODUCTS', product)
            } else {
                state.products.forEach((productPreviousWatched, index) => {
                    if (productPreviousWatched.id === product.id) {
                        commit('REMOVE_ITEM_FROM_PREVIOUS_WATCHED_PRODUCTS', index)
                    }
                })
                commit('ADD_ITEM_TO_PREVIOUS_WATCHED_PRODUCTS', product)
            }
        },
    }
}
