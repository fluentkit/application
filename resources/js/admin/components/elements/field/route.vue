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
    import field from './field';

    export default {
        name: 'fk-admin-field-route',
        extends: field,
        computed: {
            routeIdParam () {
                if (this.field.meta.route.idFrom) {
                    return this.dotGet(this.value, this.field.meta.route.idFrom, this.fieldValue);
                }

                return this.fieldValue;
            },
            routeLabel () {
                if (this.field.meta.route.from) {
                    const value = this.dotGet(this.value, this.field.meta.route.from);

                    if (value) {
                        return value;
                    }
                }

                if (this.field.meta.route.label) return this.field.meta.route.label;

                return this.fieldValue;
            }
        },
        methods: {
            async goToRoute () {
                await this.$router.push({
                    name: this.field.meta.route.id,
                    params: {
                        id: this.routeIdParam
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
