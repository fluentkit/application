<template>
    <a
        class="cursor-pointer text-center font-semibold py-3 px-6 rounded shadow-md w-auto mb-10"
        :class="typeClasses"
        @click.prevent="$emit('click', $event)"
    >
        <slot />
    </a>
</template>

<script>
    export default {
        name: 'fk-admin-button',
        props: {
            type: {
                type: String,
                default: 'default',
                validator: value => ['default', 'info', 'success', 'danger'].includes(value)
            }
        },
        computed: {
            typeClasses () {
                return {
                    default: ['bg-white', 'hover:bg-gray-300'],
                    info: ['bg-blue-500', 'hover:bg-blue-600', 'text-white'],
                    success: ['bg-green-500', 'hover:bg-green-600', 'text-white'],
                    danger: ['bg-red-500', 'hover:bg-red-600', 'text-white']
                }[this.type];
            }
        }
    }
</script>
