<template>

    <div v-if="readReview" @click.stop="$parent.hideModal">

        <div class="modal-content" @click.stop>

            <div class="p-4 w-100 h-100 d-flex flex-column align-items-start">

                <div class="d-flex justify-content-between w-100">
                    <div>
                        <h5>{{ currentOpenReview.review.user.name }} <span class="h6 text-secondary text-nowrap" v-if="currentOpenReview.review.user.id === this.$store.state.auth.user.id">(Ваш отзыв)</span></h5>

                    </div>
                    <div class="float-left text-nowrap">
                        <i v-for="star in currentOpenReview.review.rate" class="fas fa-star rate text-warning"></i>
                        <i v-for="star in 5 - currentOpenReview.review.rate" class="far fa-star rate text-warning"></i>
                    </div>
                </div>

                <div class="float-left mb-2">
                    <span class="text-secondary">{{ currentOpenReview.review.created }}</span>
                </div>

                <div class="float-left">
                    <h6>{{ currentOpenReview.review.title }}</h6>
                </div>

                <div class="float-left">
                    <p class="mb-0">{{ currentOpenReview.review.body}}</p>
                    <p class="mb-0"><span class="h6">Преимущества: </span>{{ currentOpenReview.review.advantages}}</p>
                    <p class="mb-0"><span class="h6">Недостатки: </span>{{ currentOpenReview.review.flaws}}</p>
                </div>

                <div v-if="currentOpenReview.indexInReviews !== 0" @click="prevReview(currentOpenReview.indexInReviews)" class="cursor-pointer review-in-modal__prev d-flex justify-content-center align-items-center">
                    <i class="fas fa-chevron-left"></i>
                </div>

                <div v-if="currentOpenReview.indexInReviews !== reviews.length-1" @click="nextReview(currentOpenReview.indexInReviews)" class="cursor-pointer review-in-modal__next d-flex justify-content-center align-items-center">
                    <i class="fas fa-chevron-right"></i>
                </div>

                <div @click="$parent.hideModal" class="cursor-pointer modal-close-button d-flex align-items-center justify-content-center">
                    <i class="fas fa-times"></i>
                </div>

            </div>

        </div>

    </div>

</template>

<script>
export default {
    name: "ModalReadReviews",
    props: {
        readReview: {
            type: Boolean,
            default: false
        },
        currentOpenReview: {
            type: Object
        },
        reviews: {
            type: Object
        },
    },

    methods: {
        nextReview(index) {
            this.currentOpenReview.review = this.reviews[index+1]
            this.currentOpenReview.indexInReviews += 1
        },
        prevReview(index) {
            this.currentOpenReview.review = this.reviews[index-1]
            this.currentOpenReview.indexInReviews -= 1
        },
    }
}
</script>

<style scoped>

</style>
