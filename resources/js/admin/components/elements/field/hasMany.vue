<template>
    <div class="fk-admin-field-has-many">
        <fk-admin-title>{{ field.label }}</fk-admin-title>
        <p v-if="field.description" class="description">{{ field.description }}</p>
        <fk-admin-table
            :columns="tableColumns"
            :rows="value[field.id]"
        >
            <div slot="table-header">header actions</div>
            <template
                v-for="column in tableColumns"
                :slot="column.id"
                slot-scope="{ row, column }"
            >
                <component
                    v-if="field.fields[column.id]"
                    :is="field.fields[column.id].component"
                    :field="{ ...field.fields[column.id], withoutLayout: true }"
                    :errors="errors"
                    :value="row"
                />
            </template>
            <template slot="table-footer">
<!--                <fk-admin-pagination-->
<!--                    :page="attributes.current_page"-->
<!--                    :pages="attributes.last_page"-->
<!--                    @click="goToPage"-->
<!--                />-->
                <div class="totals">
                    {{ value[field.id].length }}
                </div>
            </template>
        </fk-admin-table>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-field-has-many',
        props: {
            field: {
                type: Object,
                required: true
            },
            errors: {
                type: Object,
                required: true
            },
            value: {
                type: Object,
                required: true
            }
        },
        computed: {
            tableColumns () {
                return Object.keys(this.field.fields)
                    .map(id => this.field.fields[id])
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
