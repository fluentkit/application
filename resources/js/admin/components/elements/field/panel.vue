<template>
    <div class="fk-admin-field-panel">
        <fk-admin-title>{{ field.label }}</fk-admin-title>
        <p v-if="field.description" class="description">{{ field.description }}</p>
        <fk-admin-panel>
            <component
                v-for="field in fields"
                :key="field.id"
                :is="field.component"
                v-if="!field.hidden"
                :field="field"
                :errors="errors"
                :value="value"
                @input="$emit('input', $event)"
            />
        </fk-admin-panel>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-field-panel',
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
    .fk-admin-field-panel > .description {
        @apply .text-gray-600 .italic .mb-4;
    }
</style>
