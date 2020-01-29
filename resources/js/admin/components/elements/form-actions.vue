<template>
    <div class="fk-admin-form-actions">
        <fk-admin-button
            v-for="action in actions"
            :key="action.id"
            :type="action.buttonType"
            :disabled="action.disabled"
            @click="$emit('click', action)"
        >
            <i v-if="action.icon" class="fa" :class="action.icon"></i>
            {{ action.label }}
        </fk-admin-button>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-form-actions',
        props: {
            actions: {
                type: Array,
                required: true
            }
        }
    }
</script>

<style>
    .fk-admin-form-actions > .fk-admin-button {
        @apply .mr-2;
    }
    .fk-admin-form-actions > .fk-admin-button:last-child {
        @apply .mr-0;
    }
</style>
