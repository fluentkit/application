<script>
    import request from '../../mixins/request';
    import form from '../../mixins/form';
    import progress from '../mixins/progress';
    import toast from '../mixins/toast';
    import modal from '../mixins/modal';
    import url from "../../utils/url";

    export default {
        mixins: [request, form, progress, toast, modal],
        data () {
            return {
                fields: null,
                attributes: null,
                actions: null,
            }
        },
        computed: {
            $section () {
                return this.$route.meta.section;
            },
            $screen () {
                return {
                    ...this.$route.meta.screen,
                    get: this.getScreenData,
                    action: this.performAction
                };
            }
        },
        methods: {
            async getScreenData (key) {
                const { $section, $screen } = this;

                const { data } = await this.$request().get(url`/admin/${$section.id}/${$screen.id}/${key}`+this.requestQuery);

                return data[key];
            },
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
            },
            async performAction (action, data = {}, cb = async () => {}) {
                if (action.meta.confirmable) {
                    const { modal: { title, body, cancel, confirm } } = action.meta;
                    this.$modal(title, body, {
                            ...data,
                            actions: [cancel, confirm]
                        })
                        .$on('action', async (modalAction, modal) => {
                            if (modalAction.id === 'cancel') return modal.close();
                            await this.submitAction(action, data, cb);
                            modal.close();
                        });
                    return;
                }
                await this.submitAction(action, data, cb);
            },
            async submitAction (action, data = {}, cb = async () => {}) {
                const disabled = action.disabled;
                try {
                    action.disabled = true;
                    this.$progress().start();
                    const { $section, $screen } = this;
                    const response = await this.$form.post(url`/admin/${$section.id}/${$screen.id}/${action.id}`+this.requestQuery, data);
                    await this.handleActionResponse(response.data);
                    this.attributes = await this.$screen.get('attributes');
                    await cb(response);
                } catch (e) {
                    if (this.$isValidationError(e)) {
                        this.$error(this.$form.message);
                    } else {
                        this.$error(e);
                    }
                } finally {
                    action.disabled = disabled;
                    this.$progress().done();
                }
            },
            async handleActionResponse (data) {
                const { message, type, meta } = data;
                if (type === 'notification') {
                    this['$'+meta.toast.type](message);
                } else if (type === 'redirect') {
                    const { redirect: { url, route, params }, notification } = meta;

                    if (notification) {
                        this.handleActionResponse(notification);
                    }

                    if (url) {
                        window.location.href = url;
                        return;
                    }

                    // sometimes we might be navigating to the same route
                    try {
                        await this.$router.push({ name: route, params });
                    } catch (e) {}
                }
            }
        },
        render () {
            return false;
        }
    }
</script>