<script>
    import screenBase from './base';
    import request from '../../mixins/request';
    import screen from '../mixins/screen';
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
            await this.initScreen(['template', 'attributes', 'actions']);
        },
        render (createElement) {
		    const { attributes = {}, actions = {} } = this.$data || {};

		    return createElement({
                mixins: [request, screen, progress, toast],
                components: {
                    [background.name]: background
                },
                data () {
                    return {
                        attributes,
                        actions
                    }
                },
                template: this.template
            });
        }
	}
</script>
