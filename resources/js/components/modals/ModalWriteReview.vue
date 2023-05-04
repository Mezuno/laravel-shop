<template>

    <div v-if="writeReview" @click.stop="$parent.hideModal">

        <div @click.stop class="content-in-modal">

            <div v-if="!userReview" class="p-4">
                <div class="d-flex flex-column">
                    <div class="d-flex">
                        <h3>Оставьте свой отзыв к товару «{{ product.title }}»</h3>
                        <p class="alert alert-info p-1 ms-4 px-2" v-if="Object.keys(reviews).length <= 0">Будьте первым!</p>
                    </div>

                    <div class="col-12" v-if="Object.keys(userReviewValidationErrors).length > 0">
                        <div class="alert alert-danger">
                            <div v-for="(value, key) in userReviewValidationErrors" :key="key">{{ value[0] }}</div>
                        </div>
                    </div>

                    <div class="input-group mb-2">
                        <input type="text" class="form-control w-100" placeholder="Заголовок" v-model="storeReviewData.title">
                    </div>
                    <div @mouseout="outMouseOver">
                        <h4>
                            <i v-for="i in 5" @mouseover="onMouseOver(i)" @click="changeReviewDataRate(i)" class="far fa-star text-warning cursor-pointer" :id="`rate-in-modal${i-1}`"></i>
                        </h4>
                    </div>

                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="Достоинства" v-model="storeReviewData.advantages">
                    </div>
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" placeholder="Недостатки" v-model="storeReviewData.flaws">
                    </div>
                    <div class="input-group mb-2">
                        <textarea style="max-height: 10rem; min-height: 5rem" maxlength="300" type="text" class="form-control" placeholder="Текст отзыва" v-model="storeReviewData.body"></textarea>
                    </div>

                    <button class="btn btn-primary" @click="$parent.storeReview()">Оставить отзыв</button>

                    <div @click="$parent.hideModal" class="cursor-pointer close-modal-button d-flex align-items-center justify-content-center">
                        <i class="fas fa-times"></i>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "ModalWriteReview",

    props: {
        writeReview: {
            type: Boolean,
            default: false
        },
        userReview: {
            type: Object,
        },
        product: {
            type: Object,
        },
        reviews: {
            type: Object,
        },
        storeReviewData: {
            type: Object,
        },
        userReviewValidationErrors: {
            type: Object,
        },
    },

    methods: {
        changeReviewDataRate(rate) {
            for (let i = 0; i < rate; i++) {
                this.switchRateInModal(i, 'far')
            }
            this.storeReviewData.rate = rate
            this.outMouseOver()
        },

        onMouseOver(id) {
            for (let i = 0; i < id; i++) {
                this.switchRateInModal(i, 'far')
            }
        },

        outMouseOver() {
            for (let i = this.storeReviewData.rate; i < 5; i++) {
                this.switchRateInModal(i, 'fas')
            }
        },


        // вроде костыли, заменить на refs итп при возможности

        switchRateInModal(i, state) {
            document.getElementById('rate-in-modal'+i).classList.remove(state)
            if (state === 'far') {
                document.getElementById('rate-in-modal'+i).classList.add('fas')
            } else if (state === 'fas') {
                document.getElementById('rate-in-modal'+i).classList.add('far')
            }
        },
    }

}
</script>

<style scoped>

</style>
