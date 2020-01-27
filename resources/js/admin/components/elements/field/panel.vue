<template>
    <div>
        <fk-admin-title>{{ field.label }}</fk-admin-title>
        <p v-if="field.description" class="text-gray-600 italic mb-4">{{ field.description }}</p>
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
