<template>
    <div class="fk-admin-background">
        <img :src="'storage/logo-inverted.png' | url" />
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-background'
    }
</script>

<style>
    .fk-admin-background {
        @apply .flex .w-full .h-screen .justify-center .items-center;
    }
    .fk-admin-background img {
        @apply .w-32 .h-auto;
        opacity: 0.04;
    }
</style>
