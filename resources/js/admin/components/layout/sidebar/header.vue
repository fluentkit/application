<template>
    <div class="fk-admin-sidebar-header bg-gradient">
        <img :src="'storage/logo.png' | url" />
        <h1>Fluent<strong>Kit</strong></h1>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-sidebar-header'
    }
</script>

<style>
    .fk-admin-sidebar-header {
        @apply .h-16 .flex .items-center .shadow-md .text-white;
    }
    .fk-admin-sidebar-header img {
        @apply .flex .w-10 .h-auto .ml-3 .mr-2;
    }
    .fk-admin-sidebar-header h1 {
        @apply .flex .text-2xl .uppercase .mr-5;
    }
</style>
