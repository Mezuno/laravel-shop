<template>
    <div v-if="callMeLater" @click.stop="$parent.hideModal">
        <div class="content-in-modal" @click.stop>

            <h3>Проконсультируйте меня</h3>
            <p>Наш оператор перезвонит Вам в течение 5 минут</p>
            <form action="">
                <input type="text" class="mb-3 form-control p-2 px-3" placeholder="Номер телефона">
                <button @click.prevent class="btn btn-dark w-100">Свяжитесь со мной</button>
            </form>

            <div @click="$parent.hideModal" class="cursor-pointer close-modal-button d-flex align-items-center justify-content-center">
                <i class="fas fa-times"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ModalCallMeLater",

    props: {
        callMeLater: {
            type: Boolean,
            default: false,
        }
    }
}
</script>

<style scoped>

</style>
