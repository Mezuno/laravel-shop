<template>

    <div class="filters d-inline-flex mb-4">

        <sort @click="openOrHide('sort')" v-model:sortOpened="opened.sort"/>

        <category @click="openOrHide('category')" v-model:categoryOpened="opened.category" v-model:categories="filters.categories"/>

        <tag @click="openOrHide('tag')" v-model:tagOpened="opened.tag" v-model:tags="filters.tags"/>

        <price @click="openOrHide('price')" v-model:priceOpened="opened.price"/>

        <div class="filter-button cursor-pointer unselectable">Применить фильтры</div>

    </div>


</template>

<script>
import category from "../../components/filters/category.vue";
import price from "../../components/filters/price.vue";
import sort from "../../components/filters/sort.vue";
import tag from "../../components/filters/tag.vue";

export default {
    name: "filters",

    props: {
        filters: {
            type: Object,
        }
    },

    components: {
        category,
        price,
        sort,
        tag,
    },

    data() {
        return {
            opened: {
                sort: false,
                category: false,
                tag: false,
                price: false,
            }
        }
    },

    created() {
        window.addEventListener('click',(event) => {
            for (let openedKey in this.opened) {
                if (event.target === document.getElementsByClassName(openedKey+'-title')[0] || event.target === document.getElementsByClassName(openedKey+'-text')[0]) {
                    return
                }
                this.opened[openedKey] = false
            }
        })
    },

    methods: {
        openOrHide(key) {
            for (let openedKey in this.opened) {
                if (this.opened[openedKey]) {
                    this.opened[openedKey] = false
                    if (openedKey === key) {
                        return
                    }
                }
                if (openedKey === key) {
                    this.opened[openedKey] = true
                }
            }
        },


    }


}
</script>

<style scoped>

</style>
