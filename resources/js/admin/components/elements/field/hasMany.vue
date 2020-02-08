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
                        size="sm"
                        type="info"
                        @click="editRow(row)"
                    >
                        <i class="fa fa-pencil-alt" />
                    </fk-admin-button>
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
    import modal from '../../../mixins/modal';
    import request from '../../../../mixins/request';
    import form from '../../../../mixins/form';
    import url from "../../../../utils/url";

    export default {
        name: 'fk-admin-field-has-many',
        extends: field,
        mixins: [request, form, modal],
        inject: ['screen'],
        computed: {
            tableColumns () {
                return Object.keys(this.field.indexFields)
                    .map(id => this.field.indexFields[id])
                    .filter(({ hidden }) => !hidden)
                    .map(field => ({ ...field, classes: [] }))
                    .concat([{ id: 'actions', label: 'Actions', align: 'center', classes: ['actions'] }])
            }
        },
        methods: {
            rowClasses (classes, row, column) {
                if (row['__fk_delete']) {
                    return classes.concat(['deleted']);
                }
                if (row['__fk_modified']) {
                    return classes.concat(['modified']);
                }

                return classes;
            },
            editRow (row) {
                const action = this.field.actions.edit;
                const { modal: { title, size } } = action.meta;
                const data = {
                    $form: this.$form,
                    attributes: row,
                    field: this.field,
                    fields: this.field.editFields
                };

                const modal = this.$modal(
                    title,
                    `
                        <component
                            v-for="field in fields"
                            :key="field.id"
                            :is="field.component"
                            v-if="!field.hidden"
                            :field="field"
                            :errors="$form.errors"
                            :value="attributes"
                            @input="$emit('input', $event)"
                        />
                    `,
                    {
                        ...data,
                        actions: action.actions,
                        size
                    }
                )
                .$on('input', attributes => {
                    modal.data.attributes = attributes;
                })
                .$on('action', async (modalAction, modal) => {
                    if (modalAction.type === 'modal_close_action') return modal.close();

                    try {
                        modalAction.disabled = true;
                        this.screen.$progress().start();
                        const { $section, $screen } = this.screen;
                        const response = await this.$form.post(
                            url`/admin/${$section.id}/${$screen.id}/${action.id}.${modalAction.id}`+this.requestQuery,
                            {
                                attributes: modal.data.attributes,
                                field: this.field
                            }
                        );
                        await this.screen.handleActionResponse(response.data);
                        Object.keys(modal.data.attributes).forEach(attribute => {
                            this.$set(row, attribute, modal.data.attributes[attribute]);
                        });
                        this.$set(row, '__fk_modified', true);
                        modal.close();
                    } catch (e) {
                        if (this.screen.$isValidationError(e)) {
                            this.screen.$error(this.$form.message);
                        } else {
                            this.screen.$error(e);
                        }
                    } finally {
                        modalAction.disabled = false;
                        this.screen.$progress().done();
                    }
                });
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
