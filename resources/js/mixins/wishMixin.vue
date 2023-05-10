<script>

import router from "@/router";

export default {
    name: "wishMixin",

    methods: {
        switchWish(product, buttonId) {
            let removed = false

            if (Object.keys(this.wishlist).length === 0) {
                this.storeWish(product, buttonId)
            } else {
                this.wishlist.forEach((wish) => {
                    if (wish.product_id === product.id) {
                        this.removeWish(wish, buttonId)
                        removed = true
                        return {};
                    }
                })

                if (!removed) {
                    this.storeWish(product, buttonId)
                }
            }
        },

        storeWish(product, buttonId) {
            if (!this.$store.state.auth.authenticated) {
                router.push('/user/login')
            } else {
                this.switchHeartClasses(buttonId)

                this.addItemToWishlist({
                    'user_id': this.user.id,
                    'product_id': product.id,
                    'product': product,
                })
            }
        },

        removeWish(wish, buttonId) {
            this.switchHeartClasses(buttonId)
            this.removeItemFromWishlist(wish)
        },

        matchWishlist(product, buttonId) {
            if (this.wishlist.length !== 0) {
                for (let i = 0; i < this.wishlist.length; i++) {
                    if (this.wishlist[i].product_id === product.id) {
                        this.switchHeartClasses(buttonId)
                    }
                }
            }
        },

        switchHeartClasses(id) {
            if (document.getElementById(id).classList.contains('fas')) {
                document.getElementById(id).classList.add('far')
                document.getElementById(id).classList.remove('fas')
            } else {
                document.getElementById(id).classList.add('fas')
                document.getElementById(id).classList.remove('far')
            }
        },
    }
}
</script>
