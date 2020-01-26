<template>
    <label class="flex w-64 mr-10">
        {{ label }}
        <span v-if="required" class="text-red-500 ml-2">*</span>
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
