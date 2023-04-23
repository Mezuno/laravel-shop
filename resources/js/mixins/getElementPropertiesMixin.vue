<script>
export default {
    name: "getElementPropertiesMixin",

    methods: {
        getHeight(id) {
            return window.getComputedStyle(document.getElementById(id), null).height;
        },

        getMargin(id) {
            return window.getComputedStyle(document.getElementById(id), null).margin;
        },

        getPadding(id) {
            return window.getComputedStyle(document.getElementById(id), null).padding;
        },
    }
}
</script>
