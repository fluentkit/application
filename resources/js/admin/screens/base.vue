<script>
    import request from '../../mixins/request';
    import form from '../../mixins/form';
    import screen from '../mixins/screen';
    import progress from '../mixins/progress';
    import toast from '../mixins/toast';

    export default {
        mixins: [request, form, screen, progress, toast],
        data () {
            return {
                fields: null,
                attributes: null,
                actions: null,
            }
        },
        methods: {
            async initScreen (data = ['fields', 'attributes', 'actions'], cb = async () => {}) {
                try {
                    const responses = await Promise.all(data.map(key => this.$screen.get(key)));

                    data.forEach((key, index) => {
                        this[key] = responses[index];
                    });

                    await cb();
                } catch (e) {
                    this.$error(e);
                } finally {
                    this.$progress().done();
                }
            }
        },
        render () {
            return false;
        }
    }
</script>
