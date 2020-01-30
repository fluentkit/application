<template>
    <input
        :type="field.type"
        :id="'field-'+field.id"
        class="fk-admin-field-input"
        :class="{ error: errors.has(field.id) }"
        :value="value[field.id]"
        @input="updateValue($event.target.value)"
    />
</template>

<script>
    export default {
        name: 'fk-admin-field-input',
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
        created () {
            if (!['text', 'email', 'number', 'password'].includes(this.field.type)) {
                throw new Error('Invalid field type supplied!');
            }
        },
        methods: {
            updateValue (value) {
                const payload = {
                    ...this.value,
                    [this.field.id]: value
                };
                this.$emit('input', payload);
            }
        }
    }
</script>

<style>
    .fk-admin-field-input {
        @apply .shadow .appearance-none .border .rounded .w-full .py-2 .px-3 .text-gray-700 .leading-tight;
    }
    .fk-admin-field-input:focus {
        @apply .outline-none .shadow-outline;
    }
    .fk-admin-field-input.error {
        @apply .border-red-500;
    }
</style>
