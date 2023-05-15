<script>
import {mapActions} from "vuex";

export default {
    name: "cartMixin",

    methods: {
        ...mapActions({
            addToCartProducts:"cartProducts/addToCartProducts",
        }),

        addToCart(product, buttonId) {
            document.getElementById(buttonId).innerText = 'Добавляем'

            let newProduct = {
                'id': product.id,
                'title': product.title,
                'description': product.description,
                'price': Number(product.price),
                'image_url': product.image_url,
                'vendor_code': product.vendor_code,
                'qty': 1
            }

            this.addToCartProducts({newProduct, product})

            // КОСТЫЛЬ ----------
            let productInCartQty;
            this.productsInCart?.forEach((productInCart) => {
                if (productInCart.id === product.id) {
                    productInCartQty = productInCart.qty
                }
            })
            // --------------------

            this.switchAddToCartButtonClasses(buttonId, productInCartQty)
        },

        matchCartList(product, buttonId) {
            if (this.productsInCart && this.productsInCart?.length > 0) {
                this.productsInCart?.forEach((productInCart) => {
                    if (productInCart.id === product.id) {
                        this.switchAddToCartButtonClasses(buttonId, productInCart.qty)
                    }
                })
            }
        },

        decQty(product, index) {
            if (product.qty > 1) {
                let qty = Number(document.getElementsByClassName("input-qty")[index].value) - 1
                this.changeItemQtyCartProducts({index, qty})
                product.qty = qty;
            }
        },

        incQty(product, index) {
            if (product.qty < 999) {
                let qty = Number(document.getElementsByClassName("input-qty")[index].value) + 1
                this.changeItemQtyCartProducts({index, qty})
                product.qty = qty;
            }
        },

        stretchCartButton(buttonId) {
            document.getElementById(buttonId).classList.remove('col-10')
            document.getElementById(buttonId).classList.add('col-12')
        },

        switchAddToCartButtonClasses(buttonId, qty) {
            document.getElementById(buttonId).innerText = 'Добавлено! (' + qty + 'шт.)'
            document.getElementById(buttonId).classList.remove('btn-main')
            document.getElementById(buttonId).classList.add('btn-additional')
        },
    }
}
</script>
