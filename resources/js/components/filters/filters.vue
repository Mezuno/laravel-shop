<template>

    <div class="filters d-inline-flex mb-4">


        <sort
            @click="openOrHide('sort')"
            v-model:sortOpened="opened.sort"
            v-model:checkedIndex="checkedIndex.sort"
            @checkSort="changeCheckedSort"
        />

        <category
            @click="openOrHide('category')"
            v-model:categoryOpened="opened.category"
            v-model:categories="filters.categories"
            v-model:checkedIndex="checkedIndex.category"
            @checkCategory="changeCheckedCategory"
        />

        <tag
            @click="openOrHide('tag')"
            v-model:tagOpened="opened.tag"
            v-model:tags="filters.tags"
            v-model:checkedIndex="checkedIndex.tags"
            @checkTags="changeCheckedTags"
        />

        <price
            @click="openOrHide('price')"
            v-model:priceOpened="opened.price"
            @setPriceMin="setPrice"
        />

        <div @click="resetDataToGetProducts" class="btn btn-additional cursor-pointer unselectable">Сбросить фильтры</div>

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
            },
            checkedIndex: {
                sort: 0,
                category: 0,
                tags: [],
                price: {
                    min: '0',
                    max: '99999'
                }
            },

        }
    },

    created() {
        window.addEventListener('click',(event) => {
            for (let openedKey in this.opened) {
                if (event.target === document.getElementsByClassName(openedKey+'-title')[0]
                    || event.target === document.getElementsByClassName(openedKey+'-text')[0]
                    || event.target === document.getElementsByClassName(openedKey+'-icon')[0]
                    || event.target === document.getElementsByClassName(openedKey+'-icon')[1])
                {
                    return
                }
                this.opened[openedKey] = false
            }
        })
    },

    methods: {

        resetDataToGetProducts() {
            this.checkedIndex.sort = 0
            this.checkedIndex.category = 0
            this.checkedIndex.tags = []
            this.checkedIndex.price.min = '0'
            this.checkedIndex.price.max = '99999'
            this.setDataToGetProducts()
        },

        setDataToGetProducts() {
            this.$emit('getDataToGetProducts', this.checkedIndex)
        },

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
        changeCheckedSort(index) {
            this.checkedIndex.sort = index
            this.setDataToGetProducts()
        },
        changeCheckedCategory(index) {
            this.checkedIndex.category = index
            this.setDataToGetProducts()
        },
        changeCheckedTags(index) {
            if (this.checkedIndex.tags.includes(index)) {
                this.checkedIndex.tags.splice(this.checkedIndex.tags.indexOf(index), 1)
                this.setDataToGetProducts()
                return
            }
            this.checkedIndex.tags.push(index)
            this.setDataToGetProducts()
        },

        setPrice(price) {
            console.log(price)
            this.checkedIndex.price = price
            this.setDataToGetProducts()
        },
    }


}
</script>

<style scoped>

</style>
