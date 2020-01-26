<template>
    <input
        :type="type"
        :id="'field-'+id"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        :value="value"
        @input="$emit('input', $event.target.value)"
    />
</template>

<script>
    export default {
        name: 'fk-admin-field-input',
        props: {
            type: {
                type: String,
                required: true,
                validator: value => ['text', 'email', 'number', 'password', 'textarea'].includes(value)
            },
            id: {
                type: String,
                required: true
            },
            value: {}
        }
    }
</script>
