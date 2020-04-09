<template>
    <div class="fk-admin-field-row" :class="{ error: errors.has(field.id), [field.layout]: true }">
        <fk-admin-field-label v-if="!field.withoutLayout" :label="field.label" :required="field.required && !field.readOnly && !field.disabled" />
        <div class="input">
            <slot />
            <p v-if="errors.has(field.id)" class="error">{{ errors.first(field.id) }}</p>
            <p v-if="field.description" class="description" v-html="field.description"></p>
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

    .fk-admin-field-row.stacked {
        @apply .flex-col;
    }
    .fk-admin-field-row.stacked > * {
        @apply .w-full;
    }
    .fk-admin-field-row.stacked > .fk-admin-field-label {
        @apply .mb-4;
    }

    .fk-admin-field-row > .input {
        @apply .flex .flex-col .flex-grow;
    }
    .fk-admin-field-row > .input > .description {
        @apply .text-gray-600 .italic .mt-2 .text-sm;
    }
    .fk-admin-field-row > .input > p.error {
        @apply .text-red-500 .italic .mt-2;
    }
</style>
