<template>
    <div class="bg-gradient h-16 flex items-center shadow-md">
        <img class="flex w-10 h-auto ml-3 mr-2" :src="'storage/logo.png' | url" />
        <h1 class="flex text-2xl uppercase mr-5">Fluent<strong>Kit</strong></h1>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-sidebar-header'
    }
</script>
