<template>
    <div v-show="!isHidden" class="fk-admin-field-has-many">
        <div class="header">
            <fk-admin-title>{{ field.label }}</fk-admin-title>
            <fk-admin-button
                :type="createAction.meta.button.type"
                size="sm"
                @click="addRow"
            >
                <i
                    v-if="createAction.meta.button.icon"
                    class="fa"
                    :class="createAction.meta.button.icon"
                />
                {{ createAction.label }}
            </fk-admin-button>
        </div>
        <p v-if="field.description" class="description">{{ field.description }}</p>
        <fk-admin-table
            :columns="tableColumns"
            :rows="rows"
            :rowClass="rowClasses"
        >
            <template
                v-for="column in tableColumns"
                :slot="column.id"
                slot-scope="{ row, index, column }"
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
                        @click="editRow(row, index)"
                    >
                        <i class="fa fa-pencil-alt" />
                    </fk-admin-button>
                    <fk-admin-button
                        v-if="row['__fk_delete']"
                        size="sm"
                        @click="restoreRow(row, index)"
                    >
                        <i class="fa fa-undo" />
                    </fk-admin-button>
                    <fk-admin-button
                        v-else
                        size="sm"
                        type="danger"
                        @click="markRowDeleted(row, index)"
                    >
                        <i class="fa fa-trash" />
                    </fk-admin-button>
                </template>
            </template>
            <template slot="table-footer">
                <div class="totals">
                    {{ rows.length }}
                </div>
            </template>
        </fk-admin-table>
    </div>
</template>

<script>
    import field from './field';
    import modal from '../../../mixins/modal';
    import form from '../../../../mixins/form';

    export default {
        name: 'fk-admin-field-has-many',
        extends: field,
        mixins: [form, modal],
        inject: ['screen'],
        computed: {
            tableColumns () {
                return Object.keys(this.field.indexFields)
                    .map(id => this.field.indexFields[id])
                    .filter(({ hidden }) => !hidden)
                    .map(field => ({ ...field, classes: [] }))
                    .concat([{ id: 'actions', label: 'Actions', align: 'center', classes: ['actions'] }])
            },
            createAction () {
                return this.field.actions.create;
            },
            editAction () {
                return this.field.actions.edit;
            },
            rows () {
                return this.fieldValue || [];
            }
        },
        methods: {
            rowClasses (classes, row, column) {
                if (row['__fk_new']) {
                    return classes.concat(['new']);
                }
                if (row['__fk_delete']) {
                    return classes.concat(['deleted']);
                }
                if (row['__fk_modified']) {
                    return classes.concat(['modified']);
                }

                return classes;
            },
            createFormModal (action, fields = {}, attributes = {}, cb = () => {}) {
                const { modal: { title, size } } = action.meta;
                const data = {
                    $form: this.$form,
                    attributes,
                    field: this.field,
                    fields
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
                        const { data } = await this.$form.post(
                            this.screen.currentScreenUrl(`${action.id}.${modalAction.id}`),
                            {
                                attributes: modal.data.attributes,
                                field: this.field
                            }
                        );
                        await this.screen.handleActionResponse(data);
                        cb(modalAction, modal, data);
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

                return modal;
            },
            addRow () {
                this.createFormModal(
                    this.createAction,
                    this.field.createFields,
                    {},
                    (action, modal, responseData) => {
                        this.updateValue([
                            ...this.rows,
                            {
                                ...modal.data.attributes,
                                '__fk_new': true
                            }
                        ]);
                    }
                );
            },
            editRow (row, index) {
                this.createFormModal(
                    this.editAction,
                    this.field.editFields,
                    row,
                    (action, modal, responseData) => {
                        Object.keys(modal.data.attributes).forEach(attribute => {
                            this.$set(row, attribute, modal.data.attributes[attribute]);
                        });
                        if (!row['__fk_new']) {
                            this.$set(row, '__fk_modified', true);
                        }
                    }
                );
            },
            markRowDeleted (row, index) {
                if (row['__fk_new']) {
                    const value = [...this.rows];
                    value.splice(index, 1);
                    this.updateValue(value);
                    return;
                }
                this.$set(row, '__fk_delete', true);
            },
            restoreRow (row, index) {
                this.$delete(row, '__fk_delete');
            }
        }
    }
</script>

<style>
    .fk-admin-field-has-many {
        @apply .flex .flex-col .mb-10;
    }
    .fk-admin-field-has-many .header {
        @apply .flex .flex-row .justify-between .items-center .mb-4;
    }

    .fk-admin-field-has-many .header > * {
        @apply .mb-0;
    }

    .fk-admin-field-has-many .header > .fk-admin-button:nth-child(2) {
        @apply .ml-auto;
    }

    .fk-admin-field-has-many .header .fk-admin-button {
        @apply .ml-2;
    }

    .fk-admin-field-has-many > .description {
        @apply .text-gray-600 .italic .mb-4;
    }
</style>
