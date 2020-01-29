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
                templateData: {
                    attributes: {},
                    actions: {}
                }
            }
        },
        async created () {
            try {
                const { $section, $screen } = this;

                const [templateRequest, attributeRequest, actionRequest] = await Promise.all([
                    this.$request().post(url`/admin/${$section.id}/${$screen.id}/getTemplate`),
                    this.$request().post(url`/admin/${$section.id}/${$screen.id}/getAttributes`),
                    this.$request().post(url`/admin/${$section.id}/${$screen.id}/getActions`),
                ]);

                const { data: { template } } = templateRequest;
                const { data: { attributes } } = attributeRequest;
                const { data: { actions } } = actionRequest;

                this.template = template;
                this.templateData.attributes = attributes;
                this.templateData.actions = actions;
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
