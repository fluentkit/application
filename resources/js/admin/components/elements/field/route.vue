<template>
    <fk-admin-field-row
        :field="field"
        :errors="errors"
    >
        <a
            class="fk-admin-field-route"
            @click.prevent="goToRoute"
        >
            {{ routeLabel }}
        </a>
    </fk-admin-field-row>
</template>

<script>
    export default {
        name: 'fk-admin-field-route',
        props: {
            field: {
                type: Object,
                required: true
            },
            errors: {
                type: Object,
                required: true
            },
            value: {
                type: Object,
                required: true
            }
        },
        computed: {
            routeLabel () {
                if (this.field.meta.route.from) {
                    const from = this.field.meta.route.from.split('.');
                    let value = this.value;
                    for (let i = 0;i < from.length;i++) {
                        if (!value[from[i]]) {
                            value = false;
                            break;
                        }
                        value = value[from[i]];
                    }

                    if (value) {
                        return value;
                    }
                }

                if (this.field.meta.route.label) return this.field.meta.route.label;

                return this.value[this.field.id];
            }
        },
        methods: {
            async goToRoute () {
                await this.$router.push({
                    name: this.field.meta.route.id,
                    params: {
                        id: this.value[this.field.id]
                    }
                });
            }
        }
    }
</script>

<style>
    a.fk-admin-field-route {
        @apply .text-blue-500 .font-semibold .cursor-pointer;
    }
    a.fk-admin-field-route:hover {
        @apply .text-blue-700;
    }
</style>
