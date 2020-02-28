<template>
    <fk-admin-field-row
        v-show="!isHidden"
        :field="field"
        :errors="errors"
    >
        <div
            v-if="isReadOnly"
            class="fk-admin-field-input"
        >
            {{ fieldValue }}
        </div>
        <input
            v-else
            :type="field.type"
            :id="'field-'+field.id"
            class="fk-admin-field-input"
            :class="{ error: errors.has(field.id) }"
            :value="fieldValue"
            :disabled="isDisabled"
            @input="updateValue($event.target.value)"
        />
    </fk-admin-field-row>
</template>

<script>
    import field from './field';

    export default {
        name: 'fk-admin-field-input',
        extends: field,
        created () {
            if (!['text', 'email', 'number', 'password'].includes(this.field.type)) {
                throw new Error('Invalid field type supplied!');
            }
        }
    }
</script>

<style>
    div.fk-admin-field-input {

    }
    input.fk-admin-field-input {
        @apply .shadow .appearance-none .border .rounded .w-full .py-2 .px-3 .text-gray-700 .leading-tight;
        height: 40px;
    }
    input.fk-admin-field-input:focus {
        @apply .outline-none .shadow-outline;
    }
    input.fk-admin-field-input[disabled] {
        @apply .bg-gray-300 .cursor-not-allowed;
    }
    input.fk-admin-field-input.error {
        @apply .border-red-500;
    }
</style>
