<template>
    <input
        :type="type"
        class="fk-auth-input"
        :class="{ error }"
        :value="value"
        @input="$emit('input', $event.target.value)"
    />
</template>

<script>
    export default {
        name: 'fk-auth-input',
        props: {
            type: {
                type: String,
                default: 'text'
            },
            error: {
                type: Boolean,
                default: false
            },
            value: {
                type: String
            }
        }
    }
</script>

<style>
    .fk-auth-input {
        @apply .shadow .appearance-none .border .rounded .py-2 .px-3 .mb-8 .text-gray-700 .leading-tight;
    }
    .fk-auth-input:focus {
        @apply .outline-none .shadow-outline;
    }

    .fk-auth-input.error {
        @apply .border .border-red-500 .mb-3;
    }
</style>
