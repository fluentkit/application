<template>
    <div class="fk-admin-title">
        <slot />
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-title'
    }
</script>

<style>
    .fk-admin-title {
        @apply .text-2xl .text-gray-800 .mb-4;
    }
</style>
