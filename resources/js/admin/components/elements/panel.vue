<template>
    <div class="fk-admin-panel">
        <slot />
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-panel'
    }
</script>

<style>
    .fk-admin-panel {
        @apply .flex-1 .bg-white .shadow-md .rounded .mb-10;
    }

    .fk-admin-panel > * {
        @apply .px-10 .py-6;
    }
    .fk-admin-panel > *:first-child {
        @apply .pt-10;
    }

    .fk-admin-panel > *:last-child {
        @apply .pb-10 .mb-0;
    }
</style>
