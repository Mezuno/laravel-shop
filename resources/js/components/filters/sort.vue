<template>

    <div class="sort me-2 d-inline-flex align-items-center">

        <div class="sort-title cursor-pointer unselectable">
            <i class="fas fa-long-arrow-alt-up"></i>
            <i class="fas fa-long-arrow-alt-down me-2"></i>
            <span class="sort-text">{{sortBy[currentSortIndex]}}</span>
        </div>
        <div v-show="sortOpened" class="pseudo-el-sort"></div>

        <div @click.stop class="sort-list" v-show="sortOpened">

            <div class="sort-item" v-for="(item, index) in sortBy">

                <input v-if="index===0" @click="changeCurrentSort(index)" class="sort-radio" type="radio" name="sort" checked>
                <input v-else @click="changeCurrentSort(index)" class="sort-radio" type="radio" name="sort">
                {{item}}

            </div>

        </div>

    </div>

</template>

<script>
export default {
    name: "sort",

    props: {
        sortOpened: {
            type: Boolean
        },
    },

    data() {
        return {
            sortBy: ['По популярности','По возрастанию цены','По убыванию цены','По рейтингу'],
            currentSortIndex: 0,

        }
    },

    methods: {
        changeCurrentSort(index) {
            this.currentSortIndex = index
        },
    },

}
</script>

<style scoped>

</style>
