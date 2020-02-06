<template>
    <fk-admin-field-row
        :field="{ ...field, id: field.id+'.id' }"
        :errors="errors"
    >
        <div v-if="!fieldValue && isReadOnly">-</div>
        <fk-admin-field-route
            v-else-if="isReadOnly"
            :field="{ ...this.field.fields.route, id: this.field.id+'.id', withoutLayout: true }"
            :errors="errors"
            :value="value"
        />
        <fk-admin-field-select
            v-else
            :field="{ ...this.field.fields.input, id: this.field.id+'.id', withoutLayout: true }"
            class="fk-admin-belongs-to-input"
            :errors="errors"
            :value="value"
            @input="$emit('input', $event)"
        />
    </fk-admin-field-row>
</template>

<script>
    import field from './field';

    export default {
        name: 'fk-admin-field-belongs-to',
        extends: field
    }
</script>

<style>
    /* hack to hide sub field errors until we make the form errors more flexible */
    .fk-admin-belongs-to-input p.error {
        @apply .hidden;
    }
</style>
