<template>
    <fk-admin-field-row
        v-show="!isHidden"
        :field="field"
        :errors="groupErrors"
    >
        <div class="fk-admin-field-group">
            <component
                v-for="field in fields"
                :key="field.id"
                :is="field.component"
                :field="field"
                :errors="errors"
                :value="value"
                @input="$emit('input', $event)"
            />
        </div>
    </fk-admin-field-row>
</template>

<script>
    import field from './field';

    export default {
        name: 'fk-admin-field-group',
        extends: field,
        computed: {
            groupErrors () {
                return {
                    has: key => {
                        if (key === this.field.id) {
                            for (const field in this.fields) {
                                if (this.errors.has(this.field.fields[field].id)) {
                                    return true;
                                }
                            }

                            return false;
                        }

                        return this.errors.has(key);
                    },
                    get: this.errors.get,
                    first: this.errors.first
                }
            },
            fields () {
                const fields = {};
                Object.keys(this.field.fields).forEach(field => {
                    fields[field] = {
                        ...this.field.fields[field],
                        disabled: this.isDisabled || this.field.disabled,
                        readOnly: this.isReadOnly || this.field.readOnly
                    };
                });

                return fields;
            }
        }
    }
</script>

<style>
    .fk-admin-field-group > * {
        @apply .py-3;
    }

    .fk-admin-field-group > *:first-child {
        @apply .pt-0;
    }
    .fk-admin-field-group > *:last-child {
        @apply .pb-6 .-mb-6;
    }

    .fk-admin-field-group > .error {
        @apply .-mx-10 .px-10;
    }
    .fk-admin-field-group > .error:first-child {
        @apply .pt-6 .-mt-6;
    }
    .fk-admin-field-group > .error:last-child {
        @apply .pb-6 .-mb-6;
    }
</style>
