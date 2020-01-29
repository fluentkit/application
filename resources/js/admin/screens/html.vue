<script>
    import url from '../../utils/url';
    import request from '../../mixins/request';
    import screen from '../mixins/screen';
    import progress from '../mixins/progress';
    import toast from '../mixins/toast';
    import background from '../components/layout/background';

	export default {
		name: 'fk-admin-screen-html',
        mixins: [request, screen, progress, toast],
        data () {
            return {
                template: `<fk-admin-background />`,
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
                mixins: [request, screen, progress, toast],
                components: {
                    [background.name]: background
                },
                data () {
                    return {
                        ...templateData
                    }
                },
                template: this.template
            });
        }
	}
</script>
