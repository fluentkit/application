<template>
    <fk-admin-field-panel v-if="field.type === 'panel'" :field="field" :value="value" @input="$emit('input', $event)" />
    <div v-else class="fk-admin-field-row">
        <fk-admin-field-label :label="field.label" :required="field.required" />
        <div class="input">
            <fk-admin-field-input :type="field.type" :id="field.id" :value="value" @input="$emit('input', $event)" />
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
            value: {}
        }
    }
</script>

<style>
    .fk-admin-field-row {
        @apply .flex .flex-row .items-baseline .mb-10;
    }
    .fk-admin-field-row > .input {
        @apply .flex .flex-col .flex-grow;
    }
    .fk-admin-field-row > .input > .description {
        @apply .text-gray-600 .italic .mt-2;
    }
</style>
