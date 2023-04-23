import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '@/store/auth'
import cartProducts from '@/store/cartProducts'
import previousWatched from '@/store/previousWatched'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        cartProducts,
        previousWatched,
    }
})

export default store
