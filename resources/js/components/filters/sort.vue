<template>

    <div class="sort me-2 d-inline-flex align-items-center">

        <div class="sort-title cursor-pointer unselectable">
            <i class="sort-icon fas fa-long-arrow-alt-up"></i>
            <i class="sort-icon fas fa-long-arrow-alt-down me-2"></i>
            <span class="sort-text">{{sortBy[checkedIndex]}}</span>
        </div>
        <div v-show="sortOpened" class="pseudo-el-sort"></div>

        <div @click.stop class="sort-list" v-show="sortOpened">

            <div class="sort-item" v-for="(item, index) in sortBy">

                <div @click="changeCheckedSort(index)" class="text-nowrap">
                    <radio :checkedIndex="checkedIndex" :index="index">
                        <span class="unselectable">{{ item }}</span>
                    </radio>
                </div>

            </div>

        </div>

    </div>

</template>

<script>
import radio from "../customButtons/radio.vue";

export default {
    name: "sort",

    components: {radio},

    props: {
        sortOpened: {
            type: Boolean
        },
        checkedIndex: {
            type: Number
        }
    },

    data() {
        return {
            sortBy: ['По умолчанию', 'По популярности','По возрастанию цены','По убыванию цены','По рейтингу'],
        }
    },

    methods: {
        changeCheckedSort(index) {
            this.$emit('checkSort', index)
        },
    },

}
</script>

<style scoped>

</style>
