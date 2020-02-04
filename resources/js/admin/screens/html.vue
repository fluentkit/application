<script>
    import screenBase from './base';
    import request from '../../mixins/request';
    import progress from '../mixins/progress';
    import toast from '../mixins/toast';
    import background from '../components/layout/background';

	export default {
		name: 'fk-admin-screen-html',
        extends: screenBase,
        data () {
            return {
                template: `<fk-admin-background />`,
            }
        },
        async created () {
            await this.initScreen(['template', 'fields', 'attributes', 'actions']);
        },
        render (createElement) {
		    const { fields = {}, attributes = {}, actions = {} } = this.$data || {};

		    return createElement({
                mixins: [request, progress, toast],
                components: {
                    [background.name]: background
                },
                data () {
                    return {
                        fields,
                        attributes,
                        actions
                    }
                },
                template: this.template
            });
        }
	}
</script>
