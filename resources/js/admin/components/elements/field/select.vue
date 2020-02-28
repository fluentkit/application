<template>
    <fk-admin-field-row
        v-show="!isHidden"
        :field="field"
        :errors="errors"
    >
        <div
            v-if="isReadOnly"
            class="fk-admin-field-select"
        >
            {{ readOnlyValue }}
        </div>
        <select
            v-else
            :id="'field-'+field.id"
            class="fk-admin-field-select"
            :class="{ error: errors.has(field.id) }"
            :value="fieldValue"
            :disabled="isDisabled"
            @input="updateValue($event.target.value)"
        >
            <option v-for="option in field.options" :key="option.id" :value="option.id">
                {{ option.label }}
            </option>
        </select>
    </fk-admin-field-row>
</template>

<script>
    import field from './field';

    export default {
        name: 'fk-admin-field-select',
        extends: field,
        computed: {
            readOnlyValue () {
                const { label } = this.field.options.find(({ id }) => this.fieldValue);

                return label || this.fieldValue;
            }
        }
    }
</script>

<style>
    div.fk-admin-field-select {

    }
    select.fk-admin-field-select {
        @apply .block .shadow .appearance-none .border .rounded .w-full .py-2 .px-4 .bg-white .text-gray-700 .leading-tight;
        height: 40px;
    }
    select.fk-admin-field-select:focus {
        @apply .outline-none .shadow-outline;
    }
    select.fk-admin-field-select[disabled] {
        @apply .bg-gray-300 .cursor-not-allowed;
    }
    select.fk-admin-field-select.error {
        @apply .border-red-500;
    }
</style>
