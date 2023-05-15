<script>
export default {
    name: "hideScrollMixin",

    methods: {
        hideScroll() {
            document.getElementsByClassName('body-scroll')[0].style.overflowY = 'hidden'
            document.getElementsByClassName('body-scroll')[0].style.paddingRight = '16px'
        },
        addScroll() {
            document.getElementsByClassName('body-scroll')[0].style.overflowY = ''
            document.getElementsByClassName('body-scroll')[0].style.paddingRight = ''
        }
    },
}
</script>
