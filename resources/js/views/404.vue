<template>
    <div class="mt-5">
        <div class="d-flex flex-column align-items-center justify-content-center">
            <h1>404 Не найдено</h1>
            <h2 class="mb-3">Похоже, вы зашли на несуществующую страницу</h2>
            <router-link to="/">
                <div class="btn btn-main">
                    <h5>Вернуться на главную</h5>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "404",
}
</script>

<style scoped>

</style>
