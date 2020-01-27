<template>
    <input
        :type="type"
        :id="'field-'+id"
        class="fk-admin-field-input"
        :value="value[id]"
        @input="updateValue($event.target.value)"
    />
</template>

<script>
    export default {
        name: 'fk-admin-field-input',
        props: {
            type: {
                type: String,
                required: true,
                validator: value => ['text', 'email', 'number', 'password', 'textarea'].includes(value)
            },
            id: {
                type: String,
                required: true
            },
            value: {}
        },
        methods: {
            updateValue (value) {
                const payload = {
                    ...this.value,
                    [this.id]: value
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
</style>
