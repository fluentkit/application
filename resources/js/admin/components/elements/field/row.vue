<template>
    <fk-admin-field-panel v-if="field.type === 'panel'" :field="field" :value="value" @input="$emit('input', $event)" />
    <div v-else class="flex flex-row items-baseline mb-10">
        <fk-admin-field-label :label="field.label" :required="field.required" />
        <div class="flex flex-col flex-grow">
            <fk-admin-field-input :type="field.type" :id="field.id" :value="value" @input="$emit('input', $event)" />
            <p v-if="field.description" class="text-gray-600 italic mt-2">{{ field.description }}</p>
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
            value: {}
        }
    }
</script>
