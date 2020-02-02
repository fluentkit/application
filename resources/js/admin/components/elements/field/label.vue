<template>
    <label class="fk-admin-field-label">
        {{ label }}
        <span v-if="required" class="required">*</span>
    </label>
</template>

<script>
    export default {
        name: 'fk-admin-field-label',
        props: {
            label: {
                type: String
            },
            required: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style>
    .fk-admin-field-label {
        @apply .flex .w-48 .mr-10;
    }
    .fk-admin-field-label > .required {
        @apply .text-red-500 .ml-2;
    }
</style>
