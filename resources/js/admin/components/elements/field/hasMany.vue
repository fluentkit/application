<template>
    <div class="fk-admin-field-has-many">
        <fk-admin-title>{{ field.label }}</fk-admin-title>
        <p v-if="field.description" class="description">{{ field.description }}</p>
        <fk-admin-table
            :columns="tableColumns"
            :rows="fieldValue"
        >
            <div slot="table-header">header actions</div>
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

    export default {
        name: 'fk-admin-field-has-many',
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
