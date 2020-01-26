<template>
    <nav class="flex items-center h-16 px-12 bg-white shadow-md">
        <i v-if="$section" class="fas mr-2" :class="$section.icon" />
        <span v-for="(title, index) in titles" class="mr-2">
            <i v-if="index !== 0" class="fas mr-1 fa-chevron-right" /> {{ title }}
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
