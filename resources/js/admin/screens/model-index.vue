<template>
    <fk-admin-background v-if="!attributes || !fields || !actions"/>
    <div v-else class="fk-admin-screen-model-index">
        <div class="header">
            <fk-admin-title>
                {{ $screen.modelPluralLabel }}
            </fk-admin-title>
            <fk-admin-button
                type="info"
                @click="$router.push({ name: `${$section.id}.create` })"
            >
                Add {{ $screen.modelLabel }}
            </fk-admin-button>
        </div>
        <div class="actions"></div>
        <table>
            <thead>
                <tr>
                    <th v-for="field in fields">{{ field.label }}</th>
                    <th class="actions"></th>
                </tr>
            </thead>
            <tbody>
                <template v-if="models.length">
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
                                @click="tableAction(action, model)"
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
                </template>
                <tr v-else>
                    <td class="no-results" :colspan="Object.keys(fields).length + 1">
                        No Results
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
    import FkAdminButton from "../components/elements/button";

	export default {
		name: 'fk-admin-screen-model-index',
        components: {FkAdminButton},
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
                    await this.$router.push({
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
            async tableAction (action, { id }) {
		        this.$screen.action(action, { id });
            }
        }
	}
</script>

<style>
    .fk-admin-screen-model-index {
        @apply .mb-10;
    }

    .fk-admin-screen-model-index .header {
        @apply .flex .flex-row .justify-between .items-center;
    }

    .fk-admin-screen-model-index .header .fk-admin-button {
        @apply .mb-6;
    }

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

    .fk-admin-screen-model-index table td.no-results {
        @apply .text-center;
    }

    .fk-admin-screen-model-index table td.actions {
        @apply .flex .justify-end;
    }
    .fk-admin-screen-model-index table .fk-admin-button {
        @apply .mb-0 .ml-2;
    }

    .fk-admin-screen-model-index > .pagination {
        @apply .shadow-md .bg-gray-100 .rounded-b .flex;
    }

    .fk-admin-screen-model-index > .pagination > .totals {
        @apply .py-3 .px-4 .text-gray-600 .text-sm .ml-auto;
    }
</style>
