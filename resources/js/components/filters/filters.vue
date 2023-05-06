<template>

    <div class="filters">

        <div class="d-inline-flex mb-4">
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

            <div @click="resetDataToGetProducts('all')" class="btn btn-additional cursor-pointer unselectable">Сбросить фильтры</div>
        </div>


        <div class="filters-selected mb-4">
            <div
                class="filters-selected-delete"
                v-for="category in filters.categories"
                v-show="dataToGetProducts.category !== 0 && dataToGetProducts.category === category.id"
            >
                <span class="filters-selected-delete__title unselectable">{{ category.title }}</span>
                <i @click="resetDataToGetProducts('category')" class="fas fa-times filters-selected-delete__icon cursor-pointer"></i>
            </div>
            <div v-for="tagsChecked in dataToGetProducts.tags">
                <div
                    class="filters-selected-delete"
                    v-for="tag in filters.tags"
                    v-show="tagsChecked === tag.id"
                >
                    <span class="filters-selected-delete__title unselectable">{{ tag.title }}</span>
                    <i @click="resetDataToGetProducts('tag', tag.id)" class="fas fa-times filters-selected-delete__icon cursor-pointer"></i>
                </div>
            </div>

            <div
                class="filters-selected-delete"
                v-show="dataToGetProducts.price.min !== '0' || dataToGetProducts.price.max !== '99999'"
            >
                    <span class="filters-selected-delete__title unselectable">
                        От {{ dataToGetProducts.price.min }}₽ До {{ dataToGetProducts.price.max }}₽
                    </span>
                <i @click="resetDataToGetProducts('price')" class="fas fa-times filters-selected-delete__icon cursor-pointer"></i>
            </div>
        </div>

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
        },
        dataToGetProducts: {
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
                sort: this.dataToGetProducts.sort,
                category: this.dataToGetProducts.category,
                tags: this.dataToGetProducts.tags,
                price: this.dataToGetProducts.price
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

        resetDataToGetProducts(reset, tagId) {
            if (reset === 'all') {
                this.checkedIndex.category = 0
                this.checkedIndex.tags = []
                this.checkedIndex.price.min = '0'
                this.checkedIndex.price.max = '99999'
                this.setDataToGetProducts()
                return
            }
            if (reset === 'category') {
                this.checkedIndex.category = 0
                this.setDataToGetProducts()
                return
            }
            if (reset === 'tag') {
                this.checkedIndex.tags.forEach((tag, i) => {
                    if (tag+1 === tagId) {
                        this.checkedIndex.tags.splice(i, 1)
                    }
                })
                this.setDataToGetProducts()
                return
            }
            if (reset === 'price') {
                this.checkedIndex.price.min = '0'
                this.checkedIndex.price.max = '99999'
                this.setDataToGetProducts()
            }
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
            this.checkedIndex.price = price
            this.setDataToGetProducts()
        },
    }


}
</script>

<style scoped>

</style>
