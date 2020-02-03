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
        mounted () {
            this.$modal(
                'Create {{ foo }}',
                `<pre @click="$emit('foobar')">{{ $props }}</pre><p>jhrfklw;</p><p>jhrfklw;</p><p>jhrfklw;</p><p>jhrfklw;</p><p>jhrfklw;</p><p>jhrfklw;</p><p>jhrfklw;</p><p>jhrfklw;</p>`,
                {
                    foo: 'bar',
                    actions: [
                        {
                            id: 'delete',
                            type: 'danger',
                            label: 'Delete',
                            icon: 'fa-trash'
                        },
                        {
                            id: 'add',
                            type: 'info',
                            label: 'Add New',
                            icon: 'fa-user'
                        }
                    ]
                }
            ).$on('action', (action, modal) => {
                this.$modal(
                    'Create 2',
                    `bar<pre>{{ $props }}</pre>`
                );
                //modal.close();
            }).$on('foobar', () => {
                console.log('got here!');
            });
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
