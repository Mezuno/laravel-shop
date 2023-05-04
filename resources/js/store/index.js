import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import auth from '@/store/auth'
import cartProducts from '@/store/cartProducts'
import previousWatched from '@/store/previousWatched'
import lastSearch from '@/store/lastSearch'

const store = createStore({
    plugins:[
        createPersistedState()
    ],
    modules:{
        auth,
        cartProducts,
        previousWatched,
        lastSearch,
    }
})

export default store
