<template>

    <div class="category me-2 d-inline-flex align-items-center">
        <div class="category-title cursor-pointer unselectable">
            <i class="category-icon fas fa-list me-2"></i>
            <span class="category-text">Категория</span>
        </div>

        <div @click.stop class="category-list" v-show="categoryOpened" >

            <div class="category-item" v-for="(item, index) in categories">

                <div @click="changeCheckedCategory(index)" class="text-nowrap">
                    <radio :checkedIndex="checkedIndex" :index="index">
                        <span class="unselectable">{{ item.title }}</span>
                    </radio>
                </div>

            </div>

        </div>

    </div>

</template>

<script>
import radio from "../customButtons/radio.vue";

export default {
    name: "category",

    components: {radio},

    props: {
        categoryOpened: {
            type: Boolean,
        },
        categories: {
            type: Object,
        },
        checkedIndex: {
            type: Number
        }
    },

    methods: {
        changeCheckedCategory(index) {
            this.$emit('checkCategory', index)
        },
    },
}
</script>

<style scoped>

</style>
