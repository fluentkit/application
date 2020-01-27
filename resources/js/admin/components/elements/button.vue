<template>
    <button
        class="cursor-pointer text-center font-semibold py-3 px-6 rounded shadow-md w-auto mb-10"
        :class="buttonClasses"
        :disabled="disabled"
        @click.prevent="onClick"
    >
        <slot />
    </button>
</template>

<script>
    export default {
        name: 'fk-admin-button',
        props: {
            type: {
                type: String,
                default: 'default',
                validator: value => ['default', 'info', 'success', 'danger'].includes(value)
            },
            disabled: {
                type: Boolean,
                default: false
            }
        },
        computed: {
            buttonClasses () {
                return {
                    default: {
                        disabled: ['bg-white', 'hover:bg-gray-300'],
                        enabled: ['bg-white', 'hover:bg-gray-300']
                    },
                    info: {
                        disabled: ['bg-blue-700', 'text-gray-300'],
                        enabled: ['bg-blue-500', 'hover:bg-blue-600', 'text-white']
                    },
                    success: {
                        disabled: ['bg-green-700', 'text-gray-300'],
                        enabled: ['bg-green-500', 'hover:bg-green-600', 'text-white']
                    },
                    danger: {
                        disabled: ['bg-red-700', 'text-gray-300'],
                        enabled: ['bg-red-500', 'hover:bg-red-600', 'text-white']
                    }
                }[this.type][this.disabled ? 'disabled' : 'enabled'];
            }
        },
        methods: {
            onClick ($event) {
                if (this.disabled) {
                    return;
                }

                this.$emit('click', $event);
            }
        }
    }
</script>
