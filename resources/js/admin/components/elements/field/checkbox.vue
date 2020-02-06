<template>
    <fk-admin-field-row
        :field="field"
        :errors="errors"
    >
        <label
            :id="'field-'+field.id"
            class="fk-admin-field-checkbox"
            :class="{ error: errors.has(field.id) }"
        >
            <input
                type="checkbox"
                :checked="fieldValue"
                :disabled="isDisabled || isReadOnly"
                @click="updateValue(!fieldValue)"
            />
            <span v-if="field.meta.checkbox.label">
                {{ field.meta.checkbox.label }}
            </span>
        </label>
    </fk-admin-field-row>
</template>

<script>
    import field from './field';

    export default {
        name: 'fk-admin-field-checkbox',
        extends: field
    }
</script>
