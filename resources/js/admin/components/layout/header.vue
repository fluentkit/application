<template>
    <nav class="fk-admin-header">
        <i v-if="icon" class="fas" :class="icon" />
        <template v-for="({ route: name, label }, index) in titles">
            <router-link v-if="index === 0" :to="{ name }" :key="index" class="title">
                <i v-if="index !== 0" class="fas fa-chevron-right" /> {{ label }}
            </router-link>
            <span v-else :key="index" class="title">
                <i v-if="index !== 0" class="fas fa-chevron-right" /> {{ label }}
            </span>
        </template>
        <fk-admin-user />
    </nav>
</template>

<script>
    import { mapGetters } from 'vuex';
    import user from './user';

	export default {
		name: 'fk-admin-header',
        components: {
		    [user.name]: user
        },
        computed: {
		    ...mapGetters('sections', [
		        'currentSection',
                'currentScreen'
            ]),
            titles () {
                const { currentSection: section, currentScreen: screen } = this;

                if (!section || !screen) return [];

                if (screen.hideSectionTitle) return [ { label: screen.label, route: `${section.id}.${screen.id}` } ];

                return [ { label: section.label, route: section.id }, { label: screen.label, route: `${section.id}.${screen.id}` } ];
            },
            icon () {
                const { currentSection: section, currentScreen: screen } = this;

                if (!section || !screen) return '';

                return screen.icon && screen.icon !== '' ? screen.icon : section.icon;
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
