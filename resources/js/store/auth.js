import axios from 'axios'
import router from '@/router'

export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{},
        wishlist:[],
    },
    getters:{
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        },
        wishlist(state){
            return state.wishlist
        },
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        },
        SET_WISHLIST (state, value) {
            state.wishlist = value
        },
        ADD_ITEM_TO_WISHLIST (state, wish) {
            state.wishlist.unshift(wish)
        },
        REMOVE_ITEM_FROM_WISHLIST (state, wish) {
            state.wishlist = state.wishlist.filter(w => w.id !== wish.id)
        },
    },
    actions:{
        login({commit}){
            return axios.get('/api/user').then(({data})=>{
                commit('SET_USER', data)
                commit('SET_AUTHENTICATED', true)
                router.push({name:'profile'})
            }).catch(({response:{data}})=>{
                commit('SET_USER', {})
                commit('SET_AUTHENTICATED', false)
            })
        },

        logout({commit}){
            commit('SET_USER', {})
            commit('SET_AUTHENTICATED', false)
            commit('SET_WISHLIST', {})
        },

        setWishlist(context) {
            return axios.post('/api/wishlist', {
                user_id: context.state.user.id
            })
                .then(response => {
                    context.commit('SET_WISHLIST', response.data.data)
                })
                .catch(error => {
                    console.log(error);
                })
        },

        syncWishlist({state}) {
            axios.post('/api/wishlist/sync', {
                user_id: state.user.id,
                products: state.wishlist,
            })
                .catch((error) => {
                    console.log(error);
                })
        },

        addItemToWishlist({commit, state}, wish) {
            commit('ADD_ITEM_TO_WISHLIST', wish)
        },

        removeItemFromWishlist({commit}, wish) {
            commit('REMOVE_ITEM_FROM_WISHLIST', wish)
        },
    }
}
