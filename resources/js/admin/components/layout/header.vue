<template>
    <nav class="fk-admin-header">
        <i v-if="icon" class="fas" :class="icon" />
        <template v-for="(title, index) in titles">
            <router-link v-if="index === 0" :to="{ name: title.route }" :key="index" class="title">
                <i v-if="index !== 0" class="fas fa-chevron-right" /> {{ title.label }}
            </router-link>
            <span v-else :key="index" class="title">
                <i v-if="index !== 0" class="fas fa-chevron-right" /> {{ title.label }}
            </span>
        </template>
        <fk-admin-user :avatar="$user.avatar" :links="userLinks" />
    </nav>
</template>

<script>
    import userMixin from '../../mixins/user';

    import user from './user';

	export default {
		name: 'fk-admin-header',
        mixins: [userMixin],
        components: {
		    [user.name]: user
        },
        props: {
		    userLinks: {
		        type: Array,
                default: () => ([])
            }
        },
        computed: {
            section () {
                return this.$route.meta.section;
            },
            screen () {
                return this.$route.meta.screen;
            },
            titles () {
                const { section, screen } = this;

                if (!section || !screen) return [];

                if (screen.hideSectionTitle) return [ { label: screen.label, route: `${section.id}.${screen.id}` } ];

                return [ { label: section.label, route: section.id }, { label: screen.label, route: `${section.id}.${screen.id}` } ];
            },
            icon () {
                const { section, screen } = this;

                if (!section || !screen) return '';

                return screen.icon !== '' ? screen.icon : section.icon;
            }
        }
	}
</script>

<style>
    .fk-admin-header {
        @apply .flex .items-center .h-16 .px-12 .bg-white .shadow-md .fixed .top-0 .z-10;
    }
    .fk-admin-header > .fas {
        @apply .mr-2;
    }
    .fk-admin-header > .title {
        @apply .mr-2;
    }
    .fk-admin-header > .title > .fas {
        @apply .mr-1;
    }
</style>
