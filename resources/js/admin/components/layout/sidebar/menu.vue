<template>
    <ul class="fk-admin-sidebar-menu">
        <li v-for="section in sections" :key="section.id" v-if="!section.hidden" :id="'section-'+section.id" class="item">
            <router-link :to="{ name: section.id }">
                <i class="fas mr-2" :class="section.icon" />
                {{ section.label }}
            </router-link>
            <ul v-if="showSubMenu(section)" class="sub-menu">
                <li v-for="screen in section.screens" :key="screen.id" v-if="!screen.hidden" :id="'screen-'+screen.id" class="item">
                    <router-link :to="{ name: section.id+'.'+screen.id }">
                        {{ screen.label }}
                    </router-link>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        name: 'fk-admin-sidebar-menu',
        computed: {
            ...mapGetters('sections', [
                'sections'
            ])
        },
        methods: {
            showSubMenu (section) {
                if (Object.keys(section.screens).length < 2) return false;

                const visibleScreens = Object.keys(section.screens)
                    .map(key => section.screens[key])
                    .filter(screen => !screen.hidden)
                    .length;

                return visibleScreens > 1;
            }
        }
    }
</script>

<style>
    .fk-admin-sidebar-menu {
        @apply .flex .flex-col .text-gray-300;
    }
    .fk-admin-sidebar-menu > .item {
        @apply .flex .flex-col;
    }
    .fk-admin-sidebar-menu > .item > a {
        @apply .px-5 .pt-2 .pb-2;
    }
    .fk-admin-sidebar-menu > .item > a:hover {
        @apply .bg-gray-900;
    }
    .fk-admin-sidebar-menu > .item > .sub-menu {
        @apply .flex .flex-col .text-gray-500;
    }
    .fk-admin-sidebar-menu > .item > .sub-menu > .item a {
        @apply .block .pl-12 .pr-5 .py-1 .text-sm;
    }
    .fk-admin-sidebar-menu > .item > .sub-menu > .item a:hover {
        @apply .bg-gray-900;
    }
</style>
