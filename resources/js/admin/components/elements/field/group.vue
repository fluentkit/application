<template>
    <fk-admin-field-row
        :field="field"
        :errors="errors"
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
    export default {
        name: 'fk-admin-field-group',
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
            fields () {
                const fields = {};
                Object.keys(this.field.fields).forEach(field => {
                    fields[field] = {
                        ...this.field.fields[field],
                        disabled: this.field.fields[field].disabled || this.field.disabled,
                        readOnly: this.field.fields[field].readOnly || this.field.readOnly
                    };
                });

                return fields;
            }
        }
    }
</script>

<style>
    .fk-admin-field-group > * {
        @apply .py-6;
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
</style>
