import url from "../../utils/url";

export default {
    computed: {
        $section () {
            return this.$route.meta.section;
        },
        $screen () {
            return {
                ...this.$route.meta.screen,
                get: this.getScreenData
            };
        }
    },
    methods: {
        async getScreenData (key) {
            const { $section, $screen } = this;

            const { data } = await this.$request().get(url`/admin/${$section.id}/${$screen.id}/${key}`+this.requestQuery);

            return data[key];
        }
    }
}
