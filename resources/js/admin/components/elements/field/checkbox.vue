<template>
    <fk-admin-field-row
        :field="field"
        :errors="errors"
    >
        <label
            :id="'field-'+field.id"
            class="fk-admin-field-checkbox"
            :class="{ error: errors.has(field.id) }"
        >
            <input
                type="checkbox"
                :checked="value[field.id]"
                :disabled="field.disabled || field.readOnly"
                @click="updateValue"
            />
            <span v-if="field.meta.checkbox.label">
                {{ field.meta.checkbox.label }}
            </span>
        </label>
    </fk-admin-field-row>
</template>

<script>
    export default {
        name: 'fk-admin-field-checkbox',
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
        methods: {
            updateValue () {
                const payload = {
                    ...this.value,
                    [this.field.id]: !this.value[this.field.id]
                };
                this.$emit('input', payload);
            }
        }
    }
</script>
