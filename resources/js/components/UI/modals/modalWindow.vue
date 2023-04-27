<template>

    <div class="modal-window" v-show="openModal" @click.stop="hideModal">
        <div @click.stop class="dialog-content">
            <slot></slot>
        </div>
    </div>

</template>

<script>
export default {
    name: "modal-window",

    props: {
        openModal: {
            type: Boolean,
            default: false
        },
        writeReview: {
            type: Boolean,
            default: false
        },
        currentReview: {
            type: Boolean,
            default: false
        },
    },
    methods: {
        hideModal() {
            console.log('ke')
            this.$emit('update:openModal', false)
            // console.log(this.$emit('update:writeReview', false))
            // console.log(this.$emit('update:currentReview', false))

            // document.getElementsByClassName('body-scroll')[0].style.overflow = "scroll"
        }
    }
}
</script>

<style scoped>


</style>
