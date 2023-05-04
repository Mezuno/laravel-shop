<template>

    <div
        class="custom-button-radio d-inline-flex align-items-center"
    >
        <div :class="(checkedIndex === index) ? 'custom-button-radio-checked' : 'custom-button-radio-unchecked'"/>
        <slot></slot>
    </div>

</template>

<script>
export default {
    name: "radio",

    props: {
        checkedIndex: {
            type: Number
        },
        index: {
            type: Number
        }
    },
}
</script>

<style scoped>

</style>
