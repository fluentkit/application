export default {
    computed: {
        $section () {
            return this.$route.meta.section;
        },
        $screen () {
            return this.$route.meta.screen;
        }
    }
}
