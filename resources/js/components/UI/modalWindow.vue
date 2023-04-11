<template>

    <div class="modal-window" v-show="openModal" @click.stop="hideModal">
        <div @click.stop class="dialog-content">
            <slot></slot>
        </div>
    </div>


<!--    <div class="dialog" v-show="show" @click.stop="hideDialog">-->
<!--        <div @click.stop class="dialog-content">-->
<!--            <slot></slot>-->
<!--        </div>-->
<!--    </div>-->
</template>

<script>
export default {
    name: "modal-window",
    props: {
        openModal: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        hideModal() {
            this.$emit('update:openModal', false)
            // document.getElementsByClassName('body-scroll')[0].style.overflow = "scroll"
        }
    }
}
</script>

<style scoped>

.modal-window {
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    background-color: rgba(0,0,0, 0.4);
    position: fixed;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
