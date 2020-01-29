<template>
    <nav class="fk-admin-header">
        <i v-if="$section" class="fas" :class="$section.icon" />
        <span v-for="(title, index) in titles" class="title">
            <i v-if="index !== 0" class="fas fa-chevron-right" /> {{ title }}
        </span>
        <div class="user" @click="logout">
            <img :src="$user.avatar" />
        </div>
    </nav>
</template>

<script>
    import screen from '../../mixins/screen';
    import user from '../../mixins/user';

	export default {
		name: 'fk-admin-header',
        mixins: [screen, user],
        computed: {
            titles () {
                const { $section, $screen } = this;

                if (!$section || !$screen) {
                    return [];
                }

                if ($section.id === 'dashboards') {
                    return [
                        $screen.label
                    ];
                }

                return [
                    $section.label,
                    $screen.label
                ]
            }
        },
        methods: {
		    logout () {
                window.location.href = '/logout';
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
    .fk-admin-header .user {
        @apply .flex .w-10 .h-auto .ml-auto .rounded-full .overflow-hidden;
    }
</style>
