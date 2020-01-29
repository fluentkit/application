<template>
    <div class="fk-admin-background">
        <img :src="'storage/logo-inverted.png' | url" />
        <slot />
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-background',
        props: {
            title: {
                type: String
            },
            content: {
                type: String
            }
        }
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

    .fk-admin-background h1 {
        @apply .text-4xl .font-bold;
    }
    .fk-admin-background p {

     }
</style>
