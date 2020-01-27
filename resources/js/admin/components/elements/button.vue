<template>
    <button
        class="fk-admin-button"
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
                return [this.type];
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

<style>
    .fk-admin-button {
        @apply .cursor-pointer .text-center .font-semibold .py-3 .px-6 .rounded .shadow-md .w-auto .mb-10;
    }

    /**
     * Default
     */
    .fk-admin-button.default {
        @apply .bg-white;
    }
    .fk-admin-button.default:hover {
        @apply .bg-gray-300;
    }
    .fk-admin-button.default[disabled],
    .fk-admin-button.default[disabled]:hover{
        @apply .bg-gray-500;
    }

    /**
     * Info
     */
    .fk-admin-button.info {
        @apply .bg-blue-500 .text-white;
    }
    .fk-admin-button.info:hover {
        @apply .bg-blue-600;
    }
    .fk-admin-button.info[disabled],
    .fk-admin-button.info[disabled]:hover{
        @apply .bg-blue-700 .text-gray-300;
    }

    /**
     * Success
     */
    .fk-admin-button.success {
        @apply .bg-green-500 .text-white;
    }
    .fk-admin-button.success:hover {
        @apply .bg-green-600;
    }
    .fk-admin-button.success[disabled],
    .fk-admin-button.success[disabled]:hover{
        @apply .bg-green-700 .text-gray-300;
    }

    /**
     * Danger
     */
    .fk-admin-button.danger {
        @apply .bg-red-500 .text-white;
    }
    .fk-admin-button.danger:hover {
        @apply .bg-red-600;
    }
    .fk-admin-button.danger[disabled],
    .fk-admin-button.danger[disabled]:hover{
        @apply .bg-red-700 .text-gray-300;
    }
</style>
