<template>
    <div v-else class="fk-admin-field-row" :class="{ error: errors.has(field.id) }">
        <fk-admin-field-label :label="field.label" :required="field.required && !field.readOnly && !field.disabled" />
        <div class="input">
            <slot />
            <p v-if="errors.has(field.id)" class="error">{{ errors.first(field.id) }}</p>
            <p v-if="field.description" class="description">{{ field.description }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-field-row',
        props: {
            field: {
                type: Object,
                required: true
            },
            errors: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style>
    .fk-admin-field-row {
        @apply .flex .flex-row .items-baseline;
    }
    .fk-admin-field-row.error {
        @apply .bg-red-100;
    }

    .fk-admin-field-row > .input {
        @apply .flex .flex-col .flex-grow;
    }
    .fk-admin-field-row > .input > .description {
        @apply .text-gray-600 .italic .mt-2 .text-sm;
    }
    .fk-admin-field-row > .input > .error {
        @apply .text-red-500 .italic .mt-2;
    }
</style>
