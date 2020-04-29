<script>
    import { mapGetters } from 'vuex';
    import request from '../../mixins/request';
    import form from '../../mixins/form';
    import progress from '../mixins/progress';
    import toast from '../mixins/toast';
    import modal from '../mixins/modal';
    import url from "../../utils/url";

    export default {
        mixins: [request, form, progress, toast, modal],
        provide () {
            return {
                screen: this
            };
        },
        data () {
            return {
                fields: null,
                attributes: null,
                actions: null,
            }
        },
        computed: {
            ...mapGetters('sections', [
                'currentScreen',
                'currentSection'
            ]),
            $section () {
                return this.currentSection;
            },
            $screen () {
                return this.currentScreen;
            },
            primaryActions () {
                return this.actionsFor('primary');
            }
        },
        methods: {
            getScreenUrl (append = '', includeQuery = true) {
                const { $section, $screen } = this;
                let path = url`/admin/${$section.id}/${$screen.id}`;
                if (append !== '') {
                    path = path + url`/${append}`;
                }
                if (includeQuery) {
                    path = path + this.requestQuery;
                }

                return path;
            },
            async getScreenData (key) {
                const { data } = await this.$request().get(this.getScreenUrl(key));

                if (key === 'attributes' && Array.isArray(data[key])) {
                    return {};
                }

                return data[key];
            },
            async initScreen (data = ['fields', 'attributes', 'actions'], cb = async () => {}) {
                try {
                    const responses = await Promise.all(data.map(key => this.getScreenData(key)));

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
            actionsFor (location = 'primary') {
                return Object.keys(this.actions)
                    .map(id => this.actions[id])
                    .filter(({ meta: { location: actionLocation } }) => actionLocation === location)
                    .reduce((actions, action) => {
                        actions[action.id] = action;
                        return actions;
                    }, {});
            },
            async performAction (action, data = {}, cb = async () => {}) {
                if (this.actionIs(action, 'route_action')) {
                    return this.routeAction(action, data);
                } else if (this.actionIs(action, 'modal_action')) {
                    return this.modalAction(action, data, cb);
                }

                return await this.submitAction(action, data, cb);
            },
            actionIs (action, type) {
                return action.type === type;
            },
            async routeAction (action, data) {
                const { id: name, params: includeParams } = action.meta.route;
                const params = {};
                includeParams.forEach(p => {
                    params[p] = data[p];
                });

                return await this.$router.push({ name, params });
            },
            async modalAction (action, data, cb) {
                const { modal: { title, body, size } } = action.meta;
                return this.$modal(title, body, {
                        ...data,
                        actions: action.actions,
                        size
                    })
                    .$on('action', async (modalAction, modal) => {
                        if (modalAction.type === 'modal_close_action') return modal.close();
                        await this.performAction(
                            {
                                ...modalAction,
                                parentId: action.id
                            },
                            data,
                            cb
                        );
                        modal.close();
                    });
            },
            async submitAction (action, data = {}, cb = async () => {}) {
                const disabled = action.disabled;
                try {
                    action.disabled = true;
                    this.$progress().start();
                    const response = await this.$form.post(
                        this.getScreenUrl(`${action.parentId ? action.parentId + '.' : ''}${action.id}`),
                        data
                    );
                    await this.handleActionResponse(response.data);
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
                const { message, type, meta, reloads } = data;
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

                    return;
                }

                // if were still on the same screen lets reload attributes requested by response
                reloads.forEach(async property => {
                    this[property] = await this.getScreenData(property);
                });
            }
        },
        render () {
            return false;
        }
    }
</script>
