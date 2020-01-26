<template>
    <ul class="flex flex-col text-gray-300">
        <li v-for="section in sections" :key="section.id" :id="'section-'+section.id" class="flex flex-col">
            <router-link :to="{ name: section.id }" class="px-5 pt-2 pb-2 hover:bg-gray-900">
                <i class="fas mr-2" :class="section.icon" />
                {{ section.label }}
            </router-link>
            <ul v-if="Object.keys(section.screens).length" class="flex flex-col text-gray-500">
                <li v-for="screen in section.screens" :key="screen.id" :id="'screen-'+screen.id">
                    <router-link :to="{ name: section.id+'.'+screen.id }" class="block pl-12 pr-5 py-1 text-sm hover:bg-gray-900">
                        {{ screen.label }}
                    </router-link>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script>
    export default {
        name: 'fk-admin-sidebar-menu',
        props: {
            sections: {
                type: Object,
                required: true
            }
        }
    }
</script>
