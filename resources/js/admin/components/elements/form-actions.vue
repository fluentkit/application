<template>
    <div class="fk-admin-form-actions">
        <fk-admin-button
            v-for="action in actions"
            :key="action.id"
            :type="action.meta.button.type"
            :disabled="action.disabled"
            @click="$emit('click', action)"
        >
            <i v-if="action.meta.button.icon" class="fa" :class="action.meta.button.icon"></i>
            {{ action.label }}
        </fk-admin-button>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-form-actions',
        props: {
            actions: {
                type: Object,
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
