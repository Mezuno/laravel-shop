<template>

    <div class="category me-2 d-inline-flex align-items-center">
        <div class="category-title cursor-pointer unselectable">
            <i class="fas fa-bars me-2"></i>
            <span>Категория</span>
        </div>

        <div @click.stop class="category-list" v-show="categoryOpened" >

            <div class="category-item" v-for="(item, index) in categories">

                <input v-if="index===0" class="category-radio" type="radio" name="category" checked>
                <input v-else class="category-radio" type="radio" name="category">
                {{item.title}}

            </div>

        </div>

    </div>

</template>

<script>
export default {
    name: "category",

    props: {
        categoryOpened: {
            type: Boolean,
        },
        categories: {
            type: Object,
        }
    },

    data() {
        return {

        }
    },

    methods: {

    },
}
</script>

<style scoped>

</style>
