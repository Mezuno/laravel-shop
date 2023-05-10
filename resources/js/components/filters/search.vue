<template>

    <div class="search">

        <input
            @keydown.enter="startSearch"
            @input="updateSearchInputValue"
            class="search-input"
            placeholder="Поиск"
            id="search-input"
            autocomplete="off"
            :value="searchInputValue"
        >

        <div @click="startSearch" class="cursor-pointer search-button">
            <i class="fa fa-search search-button__icon"></i>
        </div>

    </div>

</template>

<script>
export default {
    name: "search",

    props: {
        searchInputValue: {
            type: String,
            default: '',
        },
        searchValue: {
            type: String,
            default: '',
        }
    },

    methods: {

        startSearch() {
            if (document.getElementById('search-input').value === '') {
                document.getElementById('search-input').focus()
                return
            }
            this.$emit('startSearch', document.getElementById('search-input').value)
        },

        updateSearchInputValue() {
            this.$emit('updateSearchInputValue', document.getElementById('search-input').value)
        },
    },
}
</script>

<style scoped>

</style>
