<template>
    <nav class="fk-admin-header">
        <i v-if="icon" class="fas" :class="icon" />
        <span v-for="(title, index) in titles" class="title">
            <i v-if="index !== 0" class="fas fa-chevron-right" /> {{ title }}
        </span>
        <fk-admin-user :avatar="$user.avatar" :links="userLinks" />
    </nav>
</template>

<script>
    import screen from '../../mixins/screen';
    import userMixin from '../../mixins/user';

    import user from './user';

	export default {
		name: 'fk-admin-header',
        mixins: [screen, userMixin],
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
            titles () {
                const { $section, $screen } = this;

                if (!$section || !$screen) {
                    return [];
                }

                if ($screen.hideSectionTitle) {
                    return [
                        $screen.label
                    ];
                }

                return [
                    $section.label,
                    $screen.label
                ]
            },
            icon () {
                const { $section, $screen } = this;

                if (!$section || !$screen) {
                    return '';
                }

                return $screen.icon !== '' ? $screen.icon : $section.icon;
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
