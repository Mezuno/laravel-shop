<script>
import {mapActions} from "vuex";

export default {
    name: "validationMixin",

    methods: {
        changeMinPrice(event) {

            if (event.target.value === '') {
                document.getElementsByClassName("price-min-input")[0].value = '0'
                this.price.min = '0'
                this.$emit('setPrice', this.price)
                return
            }

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
                    this.$emit('setPrice', this.price)
                    return
                }
            }

            if (event.target.value.length === 0 || event.target.value[0] === '0') {
                this.price.min = '0'
                document.getElementsByClassName("price-min-input")[0].value = '0'
                this.$emit('setPrice', this.price)
                return
            }

            if (valid === false) {
                this.price.min = event.target.value.slice(0, event.target.value.length-1)
            }

        },

        changeMaxPrice(event) {

            if (event.target.value === '') {
                document.getElementsByClassName("price-max-input")[0].value = '0'
                this.price.max = '0'
                this.$emit('setPrice', this.price)
                return
            }

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
                    this.$emit('setPrice', this.price)
                    return
                }
            }

            if (event.target.value.length === 0 || event.target.value[0] === '0') {
                this.price.max = '0'
                document.getElementsByClassName("price-max-input")[0].value = '0'
                this.$emit('setPrice', this.price)
                return
            }

            if (valid === false) {
                this.price.max = event.target.value.slice(0, event.target.value.length-1)
            }

        },

        changeQty(product, index, event) {

            let emitData = {
                index: index,
                value: '1'
            }

            if (event.target.value === '') {
                document.getElementsByClassName("input-qty")[index].value = '1'
                this.$emit('setQty', emitData)
                return
            }

            let valid = false

            for (let i = 0; i < 10; i++) {
                if (event.target.value[event.target.value.length-1] === String(i)) {
                    console.log('valid')
                    valid = true
                    emitData.value = event.target.value
                    this.$emit('setQty', emitData)
                    return
                }
            }

            if (valid === false) {
                let ke = event.target.value.slice(0, -1)
                document.getElementsByClassName("input-qty")[index].value = ke
                emitData.value = ke
                this.$emit('setQty', emitData)
            }
        },

    }
}
</script>
