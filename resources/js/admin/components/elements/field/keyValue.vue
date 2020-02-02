<template>
    <fk-admin-field-row
        :field="field"
        :errors="keyValueErrors()"
    >
        <div class="fk-admin-field-key-value">
            <div class="headers">
                <div>{{ field.keyLabel }}</div>
                <div>{{ field.valueLabel }}</div>
            </div>
            <div v-for="(value, key) in values" class="values">
                <component
                    :is="field.keyField.component"
                    :field="{ ...field.keyField, disabled: field.disabled, readOnly: field.readOnly, withoutLayout: true }"
                    :errors="keyValueErrors(key)"
                    :value="{ key }"
                    @input="updateKey(key, $event)"
                />
                <component
                    :is="field.valueField.component"
                    :field="{ ...field.valueField, disabled: field.disabled, readOnly: field.readOnly, withoutLayout: true }"
                    :errors="keyValueErrors(key)"
                    :value="{ value }"
                    @input="updateValue(key, $event)"
                />
                <fk-admin-button
                    v-if="!field.readOnly"
                    size="sm"
                    type="transparent"
                    :disabled="field.disabled"
                    @click="deleteKey(key)"
                >
                    <i class="fa fa-trash" />
                </fk-admin-button>
            </div>
            <fk-admin-button
                v-if="!field.readOnly"
                size="sm"
                type="info"
                :disabled="field.disabled"
                @click="addKey"
            >
                <i class="fa fa-plus-circle" /> {{ field.addLabel }}
            </fk-admin-button>
        </div>
    </fk-admin-field-row>
</template>

<script>
    import FkAdminButton from "../button";
    export default {
        name: 'fk-admin-field-key-value',
        components: {FkAdminButton},
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
            values () {
                return this.value[this.field.id];
            }
        },
        methods: {
            keyValueErrors (rowKey) {
                if (rowKey) {
                    return {
                        has: () => this.errors.has(this.field.id) || this.errors.has(`${this.field.id}.${rowKey}`),
                        get: () => ([]),
                        first: () => ''
                    }
                }

                return {
                    has: () => {
                        if (this.errors.has(this.field.id)) return true;

                        for (const key in this.values) {
                            if (this.errors.has(`${this.field.id}.${key}`)) return true;
                        }
                    },
                    get: () => {
                        const errors = [];
                        if (this.errors.has(this.field.id)) {
                            this.errors.get(this.field.id).forEach(error => errors.push(error));
                        }

                        for (const key in this.values) {
                            if (this.errors.has(`${this.field.id}.${key}`)) {
                                this.errors.get(`${this.field.id}.${key}`).forEach(error => errors.push(error));
                            }
                        }

                        return errors;
                    },
                    first: () => {
                        if (this.errors.has(this.field.id)) {
                            return this.errors.first(this.field.id);
                        }

                        for (const key in this.values) {
                            if (this.errors.has(`${this.field.id}.${key}`)) {
                                return this.errors.first(`${this.field.id}.${key}`);
                            }
                        }

                        return '';
                    }
                }
            },
            updateKey (oldKey, { key: newKey }) {
                if (Object.keys(this.values).includes(newKey)) return this.$forceUpdate();

                const update = {};
                Object.keys(this.values).forEach(key => {
                    if (key === oldKey) {
                        update[newKey] = this.values[key];
                        return;
                    }

                    update[key] = this.values[key];
                });

                this.$emit('input', {
                    ...this.value,
                    [this.field.id]: update
                });
            },
            updateValue (key, { value }) {
                const update = {
                    ...this.value,
                    [this.field.id]: { ...this.values }
                };
                update[this.field.id][key] = value;

                this.$emit('input', update);
            },
            deleteKey (key) {
                if (this.field.readOnly) return;

                const update = {
                    ...this.value,
                    [this.field.id]: { ...this.values }
                };
                delete update[this.field.id][key];

                this.$emit('input', update);
            },
            addKey () {
                if (this.field.readOnly) return;

                const update = {
                    ...this.value,
                    [this.field.id]: {
                        ...this.values,
                        '': ''
                    }
                };

                this.$emit('input', update);
            }
        }
    }
</script>

<style>
    .fk-admin-field-key-value .headers {
        @apply .flex .flex-row .mb-2 .font-semibold .uppercase .text-xs;
    }
    .fk-admin-field-key-value > .headers > div {
        @apply .mb-0 .flex-grow;
    }
    .fk-admin-field-key-value > .headers > div:first-child {
        @apply .max-w-xs .mr-2;
    }

    .fk-admin-field-key-value > .values {
        @apply .flex .flex-row .items-start .mb-2;
    }
    .fk-admin-field-key-value > .values > * {
        @apply .mb-0 .flex-grow;
    }
    .fk-admin-field-key-value > .values > div:first-child {
        @apply .max-w-xs .mr-2;
    }
    .fk-admin-field-key-value > .values > .fk-admin-field-row {
        @apply .flex-grow .mr-2;
    }
    .fk-admin-field-key-value > .values > .fk-admin-field-row > .input > .error {
        @apply .mt-0;
    }
    .fk-admin-field-key-value > .values > .fk-admin-button {
        @apply .m-0 .flex-grow-0 .text-gray-500;
    }

    .fk-admin-field-key-value .fk-admin-button {
        @apply .mb-0;
    }
</style>
