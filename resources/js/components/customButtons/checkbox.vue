<template>

    <div class="custom-button-checkbox d-inline-flex align-items-center">
        <div :class="(checkedIndex.includes(index)) ? 'custom-button-checkbox-checked' : 'custom-button-checkbox-unchecked'">
            <i class="fas fa-check custom-button-checkbox-checked-icon"></i>
        </div>
        <slot></slot>
    </div>

</template>

<script>
export default {
    name: "checkbox",

    props: {
        checkedIndex: {
            type: Array
        },
        index: {
            type: Number
        }
    },
}
</script>

<style scoped>

</style>
