<template>

    <div class="tag me-2 d-inline-flex align-items-center">
        <div class="tag-title cursor-pointer unselectable">
            <i class="fas fa-bars me-2"></i>
            <span>Тэги</span>
        </div>

        <div @click.stop class="tag-list" v-show="tagOpened" >

            <div class=" tag-item" v-for="(item, index) in tags">

                <input class="tag-checkbox" type="checkbox" name="tag">
                {{item.title}}

            </div>

        </div>

    </div>

</template>

<script>
export default {
    name: "tag",

    props: {
        tagOpened: {
            type: Boolean,
        },
        tags: {
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
