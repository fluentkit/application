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
        @apply .flex-1 .bg-white .shadow-md .rounded .p-10 .mb-10;
    }

    .fk-admin-panel > *:last-child {
        @apply .mb-0;
    }
</style>
