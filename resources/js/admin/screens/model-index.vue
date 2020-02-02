<template>
    <fk-admin-background v-if="!attributes || !fields || !actions"/>
    <div v-else class="fk-admin-screen-model-index">
        <div class="actions"></div>
        <table>
            <thead>
                <tr>
                    <th v-for="field in fields">{{ field.label }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="model in models" :key="model.id">
                    <td v-for="field in fields" :key="field.id">
                        <component
                            v-if="!field.hidden"
                            :is="field.component"
                            :field="{ ...field, withoutLayout: true }"
                            :errors="$form.errors"
                            :value="model"
                        />
                    </td>
                    <td class="actions">
                        <fk-admin-button
                            v-for="action in actions"
                            :key="action.id"
                            :type="action.meta.button.type"
                            size="sm"
                            @click="performAction(action, model)"
                        >
                            <i
                                v-if="action.meta.button.icon"
                                class="fa"
                                :class="action.meta.button.icon"
                            />
                            {{ action.label }}
                        </fk-admin-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">
            <fk-admin-pagination
                :page="attributes.current_page"
                :pages="attributes.last_page"
                @click="goToPage"
            />
            <div class="totals">
                {{ attributes.from }} - {{ attributes.to }} of {{ attributes.total }}
            </div>
        </div>
    </div>
</template>

<script>
    import screenBase from './base';
    import url from '../../utils/url';

	export default {
		name: 'fk-admin-screen-model-index',
        extends: screenBase,
        computed: {
            models () {
		        return this.attributes.data;
            }
        },
        async created () {
            await this.initScreen();
        },
        methods: {
		    async goToPage (page) {
                try {
                    this.$router.push({
                        name: this.$route.name,
                        params: {
                            ...this.$route.params
                        },
                        query: {
                            ...this.$route.query,
                            page
                        }
                    });

                    this.attributes = await this.$screen.get('attributes');
                } catch (e) {
                    this.$error(e);
                } finally {
                    this.$progress().done();
                }
            },
            async performAction (action, model) {
                try {
                    this.$progress().start();
                    const { $section, $screen } = this;
                    const { data } = await this.$request().post(url`/admin/${$section.id}/${$screen.id}/${action.id}`+this.requestQuery, { id: model.id });
                    this.handleResponse(data);
                } catch (e) {
                    if (this.$isValidationError(e)) {
                        this.$error(this.$form.message);
                    } else {
                        this.$error(e);
                    }
                } finally {
                    this.$progress().done();
                }
            },
            handleResponse (data) {
                const { message, type, meta } = data;
                if (type === 'notification') {
                    this['$'+meta.toast.type](message);
                } else if (type === 'redirect') {
                    const { redirect: { url, route, params }, notification } = meta;

                    if (notification) {
                        this.handleResponse(notification);
                    }

                    if (url) {
                        window.location.href = url;
                        return;
                    }

                    this.$router.push({ name: route, params });
                }
            }
        }
	}
</script>

<style>
    .fk-admin-screen-model-index > .actions {
        @apply .p-4 .shadow-md .bg-white .rounded-t .border-b;
    }

    .fk-admin-screen-model-index table {
        @apply .table-auto .shadow-md .bg-white;
    }

    .fk-admin-screen-model-index table tr {
        @apply .border-b;
    }

    .fk-admin-screen-model-index table th {
        @apply .px-4 .py-2 .border-b .bg-gray-200 .text-left .text-xs .uppercase .font-semibold .text-gray-600;
    }

    .fk-admin-screen-model-index table tbody tr:hover {
        @apply .bg-gray-100;
    }

    .fk-admin-screen-model-index table td {
        @apply .px-4 .py-3;
    }

    .fk-admin-screen-model-index table .fk-admin-button {
        @apply .mb-0;
    }

    .fk-admin-screen-model-index > .pagination {
        @apply .shadow-md .bg-gray-100 .rounded-b .flex;
    }

    .fk-admin-screen-model-index > .pagination > .totals {
        @apply .py-3 .px-4 .text-gray-600 .text-sm .ml-auto;
    }
</style>
