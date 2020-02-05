<template>
    <fk-admin-field-row
        :field="field"
        :errors="errors"
    >
        <div v-if="!value[this.field.id] && field.readOnly">-</div>
        <fk-admin-field-route
            v-else-if="field.readOnly"
            :field="{ ...this.field.fields.route, id: 'id', withoutLayout: true }"
            :errors="errors"
            :value="value[this.field.id]"
        />
        <fk-admin-field-select
            v-else
            :field="{ ...this.field.fields.input, id: 'id', withoutLayout: true }"
            :errors="errors"
            :value="value[this.field.id] || {}"
            @input="updateValue"
        />
    </fk-admin-field-row>
</template>

<script>
    export default {
        name: 'fk-admin-field-belongs-to',
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
