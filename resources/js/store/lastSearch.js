export default {
    namespaced: true,

    state: {
        searches: [],
        searchesPopular: ['keee', 'kee', 'kekeke', 'delat ke', 'ilia ke', 'keee', 'kee', 'kekeke', 'delat ke', 'ilia ke'],
    },

    getters: {
        searches(state) {
            return state.searches
        },
        searchesPopular(state) {
            return state.searchesPopular
        },
    },

    mutations: {
        ADD_ITEM_TO_LAST_SEARCHES (state, search) {
            state.searches.unshift(search)
        },
        REMOVE_ITEM_FROM_LAST_SEARCHES (state, index) {
            state.searches.splice(index, 1)
        },
        SET_LAST_SEARCHES (state, searches) {
            state.searches = searches
        },
    },

    actions: {
        addItemToLastSearch({commit}, search) {
            commit('ADD_ITEM_TO_LAST_SEARCHES', search)
        },

        removeItemFromLastSearch({commit}, index) {
            commit('REMOVE_ITEM_FROM_LAST_SEARCHES', index)
        },

        setLastSearch({commit}, searches) {
            commit('REMOVE_ITEM_FROM_LAST_SEARCHES', searches)
        },

        // setPopularSearches({commit}) {
        //     axios.get()
        // }
    }
}
