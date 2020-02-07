<template>
    <div class="fk-admin-field-has-many">
        <fk-admin-title>{{ field.label }}</fk-admin-title>
        <p v-if="field.description" class="description">{{ field.description }}</p>
        <fk-admin-table
            :columns="tableColumns"
            :rows="fieldValue"
            :rowClass="rowClasses"
        >
            <div slot="table-header"> </div>
            <template
                v-for="column in tableColumns"
                :slot="column.id"
                slot-scope="{ row, column }"
            >
                <component
                    v-if="field.indexFields[column.id]"
                    :is="field.indexFields[column.id].component"
                    :field="{ ...field.indexFields[column.id], withoutLayout: true }"
                    :errors="errors"
                    :value="row"
                />
                <template v-if="column.id === 'actions'">
                    <fk-admin-button
                        v-if="row['__fk_delete']"
                        size="sm"
                        @click="restoreRow(row)"
                    >
                        <i class="fa fa-undo" />
                    </fk-admin-button>
                    <fk-admin-button
                        v-else
                        size="sm"
                        type="danger"
                        @click="markRowDeleted(row)"
                    >
                        <i class="fa fa-trash" />
                    </fk-admin-button>
                </template>
            </template>
            <template slot="table-footer">
                <div class="totals">
                    {{ fieldValue.length }}
                </div>
            </template>
        </fk-admin-table>
    </div>
</template>

<script>
    import field from './field';
    import FkAdminButton from "../button";

    export default {
        name: 'fk-admin-field-has-many',
        components: {FkAdminButton},
        extends: field,
        computed: {
            tableColumns () {
                return Object.keys(this.field.indexFields)
                    .map(id => this.field.indexFields[id])
                    .filter(({ hidden }) => !hidden)
                    .map(field => {
                        return {
                            ...field,
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
            }
        },
        methods: {
            rowClasses (classes, row, column) {
                if (row['__fk_delete']) {
                    return classes.concat(['deleted']);
                }

                return classes;
            },
            markRowDeleted (row) {
                this.$set(row, '__fk_delete', true);
            },
            restoreRow (row) {
                this.$delete(row, '__fk_delete');
            }
        }
    }
</script>

<style>
    .fk-admin-field-has-many {
        @apply .flex .flex-col .mb-10;
    }
    .fk-admin-field-has-many > .description {
        @apply .text-gray-600 .italic .mb-4;
    }
</style>
