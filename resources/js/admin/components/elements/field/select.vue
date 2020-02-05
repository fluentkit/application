<template>
    <fk-admin-field-row
        :field="field"
        :errors="errors"
    >
        <div
            v-if="field.readOnly"
            class="fk-admin-field-select"
        >
            {{ readOnlyValue }}
        </div>
        <select
            v-else
            :id="'field-'+field.id"
            class="fk-admin-field-select"
            :class="{ error: errors.has(field.id) }"
            :value="value[field.id]"
            :disabled="field.disabled"
            @input="updateValue($event.target.value)"
        >
            <option v-for="option in field.options" :key="option.id" :value="option.id">
                {{ option.label }}
            </option>
        </select>
    </fk-admin-field-row>
</template>

<script>
    export default {
        name: 'fk-admin-field-select',
        props: {
            field: {
                type: Object,
                required: true
            },
            errors: {
                type: Object,
                required: true
            },
            value: {
                type: Object,
                required: true
            }
        },
        computed: {
            readOnlyValue () {
                const { label = this.value[this.field.id] } = this.field.options.find(({ id }) => this.value[this.field.id]);

                return label;
            }
        },
        methods: {
            updateValue (value) {
                const payload = {
                    ...this.value,
                    [this.field.id]: value
                };
                this.$emit('input', payload);
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
