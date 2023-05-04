<template>

    <div class="price me-2 d-inline-flex align-items-center">

        <div class="price-title cursor-pointer unselectable">
            <span class="price-text">Цена ₽</span>
        </div>

        <div @click.stop v-show="priceOpened" class="price-choice row">
            <div class="price-min col-6 px-0">
                <span class="unselectable">От</span>
                <input @input="changeMinPrice($event)" class="price-min-input" maxlength="5" v-model="price.min">
            </div>

            <div class="price-max col-6 px-0">
                <span class="unselectable">До</span>
                <input @input="changeMaxPrice($event)" class="price-max-input" maxlength="5" v-model="price.max">
            </div>

        </div>


    </div>

</template>

<script>
export default {
    name: "price",

    props: {
        priceOpened: {
            type: Boolean
        }
    },

    data() {
        return {
            price: {
                min: '0',
                max: '99999',
            }
        }
    },

    methods: {

        changeMinPrice(event) {
            let valid = false
            for (let i = 0; i < 10; i++) {
                if (event.target.value[event.target.value.length-1] === String(i)) {
                    valid = true
                    if (event.target.value[0] === '0') {
                        document.getElementsByClassName("price-min-input")[0].value = event.target.value.slice(1)
                        this.price.min = event.target.value.slice(1)
                    }
                    document.getElementsByClassName("price-min-input")[0].value = event.target.value
                    this.price.min = event.target.value
                    return
                }
            }
            if (event.target.value.length === 0 || event.target.value[0] === '0') {
                this.price.min = '0'
                document.getElementsByClassName("price-min-input")[0].value = '0'
                return
            }
            if (valid === false) {
                this.price.min = event.target.value.slice(0, event.target.value.length-1)
            }
        },

        changeMaxPrice(event) {
            let valid = false
            for (let i = 0; i < 10; i++) {
                if (event.target.value[event.target.value.length-1] === String(i)) {
                    valid = true
                    if (event.target.value[0] === '0') {
                        document.getElementsByClassName("price-max-input")[0].value = event.target.value.slice(1)
                        this.price.max = event.target.value.slice(1)
                    }
                    document.getElementsByClassName("price-max-input")[0].value = event.target.value
                    this.price.max = event.target.value
                    return
                }
            }
            if (event.target.value.length === 0 || event.target.value[0] === '0') {
                this.price.max = '0'
                document.getElementsByClassName("price-max-input")[0].value = '0'
                return
            }
            if (valid === false) {
                this.price.max = event.target.value.slice(0, event.target.value.length-1)
            }
        },
    },
}
</script>

<style scoped>

</style>
