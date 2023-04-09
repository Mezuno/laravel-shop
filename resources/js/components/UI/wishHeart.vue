<template>
    <h5 class="p-0 m-0 p-2 pb-0 mb-0 ms-0 text-danger">
        <div @click.prevent="" class="position-relative">
            <i class="far fa-heart position-absolute" style="display: block; opacity: 0.8; cursor: pointer;"></i>
        </div>
    </h5>

<!--    <a  class="p-2 pb-0 mb-0 text-danger ms-2">-->
<!--        <i class="far fa-heart" :id="`heart${product.id}`"></i>-->
<!--    </a>-->
</template>

<script>
export default {
    name: "wish-heart",

}
</script>

<style scoped>

</style>
