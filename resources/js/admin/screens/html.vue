<script>
    import url from '../../utils/url';

	export default {
		name: 'fk-admin-screen-html',
        data () {
            return {
                template: '<div class="flex-1 bg-white shadow-md rounded p-10 m-4 text-center">Loading...</div>',
                templateData: {}
            }
        },
        async created () {
            try {
                const { $section, $screen } = this;
                const {
                    data: { data: { template, data } }
                } = await this.$request().post(url`/admin/${$section.id}/${$screen.id}/getHtml`);
                this.template = template;
                this.templateData = data;
            } catch (e) {
                this.$error(e);
            } finally {
                this.$progress().done();
            }
        },
        render (createElement) {
		    const { templateData = {} } = this.$data || {};
		    return createElement({
                data () {
                    return {
                        ...templateData
                    }
                },
                template: `<div class="flex flex-grow m-10">${this.template}</div>`
            });
        }
	}
</script>
