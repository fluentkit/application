<template>
    <fk-admin-field-row
        v-show="!isHidden"
        :field="field"
        :errors="keyValueErrors()"
    >
        <div class="fk-admin-field-key-value">
            <div class="headers">
                <div>{{ field.keyLabel }}</div>
                <div>{{ field.valueLabel }}</div>
            </div>
            <div v-for="(value, key) in fieldValue" class="values">
                <component
                    :is="field.keyField.component"
                    :field="{ ...field.keyField, disabled: isDisabled, readOnly: isReadOnly, withoutLayout: true }"
                    :errors="keyValueErrors(key)"
                    :value="{ key }"
                    @input="updateKey(key, $event)"
                />
                <component
                    :is="field.valueField.component"
                    :field="{ ...field.valueField, disabled: isDisabled, readOnly: isReadOnly, withoutLayout: true }"
                    :errors="keyValueErrors(key)"
                    :value="{ value }"
                    @input="updateKeyValue(key, $event)"
                />
                <fk-admin-button
                    v-if="!isReadOnly"
                    size="sm"
                    type="transparent"
                    :disabled="isDisabled"
                    @click="deleteKey(key)"
                >
                    <i class="fa fa-trash" />
                </fk-admin-button>
            </div>
            <fk-admin-button
                v-if="!isReadOnly"
                size="sm"
                type="info"
                :disabled="isDisabled"
                @click="addKey"
            >
                <i class="fa fa-plus-circle" /> {{ field.addLabel }}
            </fk-admin-button>
        </div>
    </fk-admin-field-row>
</template>

<script>
    import field from './field';

    export default {
        name: 'fk-admin-field-key-value',
        extends: field,
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

                        for (const key in this.fieldValue) {
                            if (this.errors.has(`${this.field.id}.${key}`)) return true;
                        }
                    },
                    get: () => {
                        const errors = [];
                        if (this.errors.has(this.field.id)) {
                            this.errors.get(this.field.id).forEach(error => errors.push(error));
                        }

                        for (const key in this.fieldValue) {
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

                        for (const key in this.fieldValue) {
                            if (this.errors.has(`${this.field.id}.${key}`)) {
                                return this.errors.first(`${this.field.id}.${key}`);
                            }
                        }

                        return '';
                    }
                }
            },
            updateKey (oldKey, { key: newKey }) {
                if (Object.keys(this.fieldValue).includes(newKey)) return this.$forceUpdate();

                const update = { ...this.fieldValue };
                update[newKey] = update[oldKey];
                delete update[oldKey];

                this.updateValue(update);
            },
            updateKeyValue (key, { value }) {
                const update = { ...this.fieldValue };
                update[key] = value;

                this.updateValue(update);
            },
            deleteKey (key) {
                if (this.field.readOnly) return;

                const update = { ...this.fieldValue };
                delete update[key];

                this.updateValue(update);
            },
            addKey () {
                if (this.field.readOnly) return;

                this.updateValue({
                    ...this.fieldValue,
                    '': ''
                });
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
