<template>
    <div class="fk-admin-field-panel">
        <fk-admin-title>{{ field.label }}</fk-admin-title>
        <p v-if="field.description" class="description">{{ field.description }}</p>
        <fk-admin-panel>
            <fk-admin-field-row
                v-for="field in field.fields"
                :key="field.id"
                :field="field"
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
            value: {
                type: Object,
                required: true
            }
        }
    }
</script>

<style>
    .fk-admin-field-panel > .description {
        @apply .text-gray-600 .italic .mb-4;
    }
</style>
