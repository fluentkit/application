<template>
    <div class="fk-admin-user">
        <button class="user">
            <img :src="avatar" @click="toggleMenu" />
        </button>
        <button v-if="menuOpen" class="clickaway" @click="closeMenu" />
        <div v-if="menuOpen" class="menu">
            <a v-for="(link, index) in links" :key="index" :class="link.type || ''" @click.prevent="clickLink(link)">{{ link.text }}</a>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: 'fk-admin-user',
        data () {
            return {
                menuOpen: false
            };
        },
        computed: {
            ...mapGetters('auth', [
                'avatar'
            ]),
            ...mapGetters('userLinks', [
                'links'
            ])
        },
        methods: {
            toggleMenu () {
                this.menuOpen = !this.menuOpen;
            },
            closeMenu () {
                this.menuOpen = false;
            },
            clickLink ({ route }) {
                this.closeMenu();
                this.$router.push(route);
            }
        }
    }
</script>

<style>
    .fk-admin-user {
        @apply .flex .block .w-10 .h-10 .ml-auto .relative;
    }
    .fk-admin-user .user {
        @apply .rounded-full .border .overflow-hidden .relative .z-10 .outline-none;
    }
    .fk-admin-user .user:focus {
        @apply .shadow-outline;
    }

    .fk-admin-user .user img {
        @apply .w-full .h-full .object-cover;
    }

    .fk-admin-user .clickaway {
        @apply .w-full .h-full .fixed .top-0 .right-0 .bottom-0 .left-0 .cursor-default;
        @apply .bg-black .opacity-25;
    }

    .fk-admin-user .menu {
        @apply .bg-white .border .rounded .shadow-xl .flex .flex-col;
        @apply .absolute .right-0 .top-auto .mt-1 .-mr-4;
        min-width: 12rem;
    }

    .fk-admin-user .menu a {
        @apply .flex-1 .px-4 .py-2 .cursor-pointer .text-sm;
    }
    .fk-admin-user .menu a:hover {
        @apply .bg-gray-200;
    }
    .fk-admin-user .menu a.divider {
        @apply .border-t .border-gray-300 .p-0 .h-0 .overflow-hidden;
    }
</style>
