<template>
    <div class="fk-admin-layout">
        <section class="sidebar">
            <fk-admin-sidebar-header></fk-admin-sidebar-header>
            <fk-admin-sidebar-menu :sections="sections"></fk-admin-sidebar-menu>
        </section>
        <section class="main">
            <fk-admin-header :user-links="mappedUserLinks"></fk-admin-header>
            <div id="progress-container"></div>
            <div id="screen-container">
                <router-view :key="$route.path"></router-view>
            </div>
        </section>
    </div>
</template>

<script>
    import progress from '../../mixins/progress';

    import header from './header';
    import sidebarHeader from './sidebar/header';
    import sidebarMenu from './sidebar/menu';

    export default {
        name: 'fk-admin-layout',
        mixins: [progress],
        components: {
            [header.name]: header,
            [sidebarHeader.name]: sidebarHeader,
            [sidebarMenu.name]: sidebarMenu
        },
        props: {
            sections: {
                type: Object,
                required: true
            },
            user: {
                type: Object,
                required: true
            },
            userLinks: {
                type: Array,
                default: () => ([])
            }
        },
        computed: {
            mappedUserLinks () {
                return this.userLinks.map(({ type = 'link', text, name, params = {}, query = {} }) => {
                    return {
                        type,
                        text,
                        click: () => this.$router.push({ name, params, query })
                    };
                });
            }
        },
        mounted () {
            this.$progress().configure({ parent: '#progress-container' });
            this.$progress().start();
            this.$router.beforeResolve((to, from, next) => {
                if (to.name) {
                    this.$progress().start();
                }
                next();
            });
        }
    }
</script>

<style>
    @tailwind base;

    @tailwind components;

    @import '~nprogress/nprogress.css';

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

    /**
     * Toasted
     */
    .toasted-container.bottom-right {
        min-width: 32rem !important;
        @apply .right-0 .bottom-0 .mr-4 .mb-4 .max-w-full !important;
    }
    .fluentkit.toasted {
        @apply .rounded .shadow-md .text-white .bg-gray-500 .py-3 .px-4;
        @apply .w-full .justify-start !important;
    }
    .fluentkit.toasted .action {
        @apply .p-0 .m-0 .pl-4 .no-underline !important;
    }
    .fluentkit.toasted .action:first-of-type {
        @apply .ml-auto !important;
    }
    .fluentkit.toasted .action:hover {
        @apply .text-gray-300;
    }
    .fluentkit.toasted .fa {
        @apply .m-0 .p-0 .pr-4 !important;
    }
    .fluentkit.toasted .fa.after {
        @apply .pr-0 .pl-4 !important;
    }
    .fluentkit.toasted.info {
        @apply .bg-blue-500;
    }
    .fluentkit.toasted.success {
        @apply .bg-green-500;
    }
    .fluentkit.toasted.error {
        @apply .bg-red-500;
    }

    /**
     * Layout styling
     **/
    .fk-admin-layout {
        @apply .flex .h-screen;
    }

    .fk-admin-layout .sidebar {
        @apply .flex-none .bg-gray-800 .h-screen;
        width: 210px;
    }

    .fk-admin-layout .main {
        @apply .flex-col .bg-gray-200 .h-screen .w-full .overflow-auto .pt-16;
        width: calc(100% - 210px);
        min-width: 578px;
    }
    .fk-admin-layout .main > .fk-admin-header {
        width: calc(100% - 210px);
        min-width: 578px;
    }

    .fk-admin-layout .main #progress-container {
        @apply .h-10 .sticky .top-0 .left-0 .overflow-visible .w-full;
    }

    .fk-admin-layout .main #screen-container {
        @apply .flex .px-10;
    }

    .fk-admin-layout .main #screen-container > * {
        @apply .flex .flex-col .flex-grow;
    }

    /*@tailwind utilities;*/
</style>
