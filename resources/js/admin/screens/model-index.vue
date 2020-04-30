<template>
    <fk-admin-background v-if="!attributes || !fields || !actions"/>
    <div v-else class="fk-admin-screen-model-index">
        <div class="header">
            <fk-admin-title>
                {{ currentScreen.modelPluralLabel }}
            </fk-admin-title>
            <fk-admin-button
                v-for="action in primaryActions"
                :key="action.id"
                :type="action.meta.button.type"
                @click="performAction(action, attributes)"
            >
                <i
                    v-if="action.meta.button.icon"
                    class="fa"
                    :class="action.meta.button.icon"
                />
                {{ action.label }}
            </fk-admin-button>
        </div>
        <fk-admin-table
            :columns="tableColumns"
            :rows="models"
            :searchable="false"
        >
            <input
                slot="table-header"
                type="text"
                id="search"
                class="fk-admin-field-input"
                :value="$route.query.search"
                @input="search($event.target.value)"
            />
            <template
                v-for="column in tableColumns"
                :slot="column.id"
                slot-scope="{ row, column }"
            >
                <component
                    v-if="fields[column.id]"
                    :is="fields[column.id].component"
                    :field="{ ...fields[column.id], withoutLayout: true }"
                    :errors="$form.errors"
                    :value="row"
                />
                <fk-admin-button
                    v-else-if="column.id === 'actions'"
                    v-for="action in actionsFor('table')"
                    :key="action.id"
                    :type="action.meta.button.type"
                    size="sm"
                    @click="tableAction(action, row)"
                >
                    <i
                        v-if="action.meta.button.icon"
                        class="fa"
                        :class="action.meta.button.icon"
                    />
                    {{ action.label }}
                </fk-admin-button>
            </template>
            <template slot="table-footer">
                <fk-admin-pagination
                    :page="attributes.current_page"
                    :pages="attributes.last_page"
                    @click="goToPage"
                />
                <div class="totals">
                    {{ attributes.from }} - {{ attributes.to }} of {{ attributes.total }}
                </div>
            </template>
        </fk-admin-table>
    </div>
</template>

<script>
    import screenBase from './base';

	export default {
		name: 'fk-admin-screen-model-index',
        extends: screenBase,
        data () {
		    return {
		        searchBouncer: null
            };
        },
        computed: {
		    tableColumns () {
		        return Object.keys(this.fields)
                    .map(id => this.fields[id])
                    .filter(({ hidden }) => !hidden)
                    .map(({ id, label, align }) => {
                        return {
                            id,
                            label,
                            align,
                            classes: []
                        }
                    })
                    .concat([
                        {
                            id: 'actions',
                            label: 'Actions',
                            align: 'center',
                            classes: ['actions']
                        }
                    ])
            },
            models () {
		        return this.attributes.data;
            }
        },
        async created () {
            await this.initScreen();
        },
        methods: {
		    async search (search) {
                if (this.searchBouncer) clearTimeout(this.searchBouncer);
                this.searchBouncer = setTimeout(async () => {
                    try {
                        if (search === '') {
                            search = undefined;
                        }
                        await this.$router.push({
                            query: {
                                ...this.$route.query,
                                search
                            }
                        });

                        await this.setScreenData(['attributes']);
                    } catch (e) {
                        this.$error(e);
                    } finally {
                        this.$progress().done();
                    }
                }, 500);
            },
		    async goToPage (page) {
                try {
                    await this.$router.push({
                        query: {
                            ...this.$route.query,
                            page
                        }
                    });

                    await this.setScreenData(['attributes']);
                } catch (e) {
                    this.$error(e);
                } finally {
                    this.$progress().done();
                }
            },
            async tableAction (action, model) {
		        this.performAction(action, model);
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

    .fk-admin-screen-model-index .header > .fk-admin-button:nth-child(2) {
        @apply .ml-auto;
    }

    .fk-admin-screen-model-index .header .fk-admin-button {
        @apply .mb-6 .ml-2;
    }
</style>
