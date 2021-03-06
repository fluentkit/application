import Vue from 'vue';

const createModalContainer = () => {
    if (document.getElementById('fk-modal-container')) return;

    const container = document.createElement('div');
    container.id = 'fk-modal-container';
    document.body.appendChild(container);
};

const modalStringsToComponent = (string, data) => {
    if (typeof string !== 'object') {
        string = {
            props: Object.keys(data).concat(['$emit']),
            template: `<div>${string}</div>`
        };
    }

    return string;
};

export default {
    data () {
        return {
            modalInstance: null
        }
    },
    methods: {
        $modal (title = '', body = '', data = {}) {
            createModalContainer();

            title = modalStringsToComponent(title, data);
            body = modalStringsToComponent(body, data);

            this.modalInstance = new Vue({
                data () {
                    return {
                        data: {
                            ...data,
                            // Hack to emit events within child components as the root instance which can be
                            // consumed via this.$modal().$on(...);
                            $emit: (...args) => this.$emit(...args)
                        },
                        body,
                        title,
                        actions: data.actions
                    };
                },
                computed: {
                    that () {
                        return this;
                    }
                },
                template: `
                    <div id="fk-modal-container">
                        <div class="backdrop" @click="close"/>
                        <div class="fk-admin-modal" :class="data.size">
                            <div class="title">
                                <component :is="title" v-bind="data"/>
                                <a @click.prevent="close" class="close">
                                    <i class="fa fa-times"/>
                                </a>
                            </div>
                            <div class="body">
                                <component :is="body" v-bind="data"/>
                            </div>
                            <div v-if="Object.keys(actions).length" class="footer">
                                <fk-admin-button
                                    v-for="action in actions"
                                    :key="action.id"
                                    :type="action.meta.button.type"
                                    :disabled="action.disabled"
                                    @click="$emit('action', action, that)"
                                >
                                    <i v-if="action.meta.button.icon" class="fa" :class="action.meta.button.icon" />
                                    {{ action.label }}
                                </fk-admin-button>
                            </div>
                        </div>
                    </div>`,
                methods: {
                    close () {
                        this.$destroy();
                    }
                },
                destroyed () {
                    if (typeof this.$el.remove === 'function') this.$el.remove();
                }
            });

            this.modalInstance.$mount('#fk-modal-container');

            return this.modalInstance;
        }
    }
}
