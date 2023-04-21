import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '@/store/auth'
import cartProducts from '@/store/cartProducts'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        cartProducts
    }
})

export default store
