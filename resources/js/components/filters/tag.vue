<template>

    <div class="tag me-2 d-inline-flex align-items-center">
        <div class="tag-title cursor-pointer unselectable">
            <i class="tag-icon fas fa-tags me-2"></i>
            <span class="tag-text">Теги</span>
        </div>

        <div @click.stop class="tag-list" v-show="tagOpened" >

            <div class=" tag-item" v-for="(item, index) in tags">

                <div @click="changeCheckedTags(index)" class="text-nowrap">
                    <checkbox :checkedIndex="checkedIndex" :index="index">
                        <span class="unselectable">{{ item.title }}</span>
                    </checkbox>
                </div>

            </div>

        </div>

    </div>

</template>

<script>
import checkbox from "../customButtons/checkbox.vue";

export default {
    name: "tag",

    components: {checkbox},

    props: {
        tagOpened: {
            type: Boolean,
        },
        tags: {
            type: Object,
        },
        checkedIndex: {
            type: Array
        }
    },

    data() {
        return {

        }
    },

    methods: {
        changeCheckedTags(index) {
            this.$emit('checkTags', index)
        },
    },
}
</script>

<style scoped>

</style>
