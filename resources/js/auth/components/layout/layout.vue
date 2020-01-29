<template>
    <div class="fk-auth-layout bg-gradient">
        <section class="screen-container">
            <img :src="'storage/logo.png' | url" class="logo" />
            <div class="main">
                <router-view></router-view>
            </div>
            <router-link v-if="!isForgotPassword" :to="{ name: 'login.forgot' }">
                Forgot Password
            </router-link>
            <router-link v-if="isForgotPassword" :to="{ name: 'login' }">
                Login
            </router-link>
        </section>
    </div>
</template>

<script>
    export default {
        name: 'fk-auth-layout',
        computed: {
            isForgotPassword () {
                return this.$route.name === 'login.forgot';
            }
        }
    }
</script>

<style>
    @tailwind base;

    @tailwind components;

    html {
        font-family: 'Open Sans', sans-serif;
        @apply .text-gray-800;
    }
    *, *:before, *:after {
        box-sizing: border-box;
    }

    .bg-gradient {
        background: #177aa2; /* Old browsers */
        background: -moz-linear-gradient(45deg,  #177aa2 0%, #6cbe58 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,#177aa2), color-stop(100%,#6cbe58)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(45deg,  #177aa2 0%,#6cbe58 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(45deg,  #177aa2 0%,#6cbe58 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(45deg,  #177aa2 0%,#6cbe58 100%); /* IE10+ */
        background: linear-gradient(45deg,  #177aa2 0%,#6cbe58 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#177aa2', endColorstr='#6cbe58',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
    }

    .fk-auth-layout {
        @apply .h-screen .flex .flex-col .justify-center .items-center;
    }

    .fk-auth-layout .screen-container {
        @apply .flex .flex-col .items-center .-mt-32;
        width: 24rem;
    }

    .fk-auth-layout .screen-container .logo {
        @apply .w-32 .mb-4;
    }

    .fk-auth-layout .screen-container .main {
        @apply .flex .w-full .bg-white .shadow-md .rounded .p-10 .mb-4;
    }

    .fk-auth-layout .screen-container > a {
        @apply .text-white;
    }

    .fk-auth-layout .screen-container > a:hover {
        @apply .text-gray-300;
    }

    /*@tailwind utilities;*/
</style>
