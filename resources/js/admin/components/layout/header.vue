<template>
    <nav class="fk-admin-header">
        <i v-if="$section" class="fas" :class="$section.icon" />
        <span v-for="(title, index) in titles" class="title">
            <i v-if="index !== 0" class="fas fa-chevron-right" /> {{ title }}
        </span>
    </nav>
</template>

<script>
	export default {
		name: 'fk-admin-header',
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
        }
	}
</script>

<style>
    .fk-admin-header {
        @apply .flex .items-center .h-16 .px-12 .bg-white .shadow-md .fixed .top-0 .w-full .z-10;
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
