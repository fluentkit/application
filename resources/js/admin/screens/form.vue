<template>
    <fk-admin-background v-if="!attributes || !fields || !actions"/>
    <div v-else class="fk-admin-screen-form">
        <component v-for="field in fields" :key="field.id" :is="field.component" v-if="!field.hidden" :field="field" :errors="$form.errors" v-model="attributes"/>
        <fk-admin-form-actions :actions="actions" @click="performAction"/>
    </div>
</template>

<script>
    import screenBase from './base';
    import url from '../../utils/url';

	export default {
		name: 'fk-admin-screen-form',
        extends: screenBase,
        data () {
            return {
                buttonText: 'Save Changes'
            }
        },
        async created () {
            await this.initScreen();
        },
        methods: {
		    async performAction (action) {
                try {
                    action.disabled = true;
                    this.$progress().start();
                    const { $section, $screen } = this;
                    const { data } = await this.$form.post(url`/admin/${$section.id}/${$screen.id}/${action.id}`+this.requestQuery, { attributes: this.attributes });
                    this.handleResponse(data);
                    this.attributes = data.attributes;
                } catch (e) {
                    if (this.$isValidationError(e)) {
                        this.$error(this.$form.message);
                    } else {
                        this.$error(e);
                    }
                } finally {
                    action.disabled = false;
                    this.$progress().done();
                }
            },
            handleResponse (data) {
                const { message, type, meta } = data;
                if (type === 'notification') {
                    this['$'+meta.toast.type](message);
                } else if (type === 'redirect') {
                    const { redirect: { url, route, params }, notification } = meta;

                    if (notification) {
                        this.handleResponse(notification);
                    }

                    if (url) {
                        window.location.href = url;
                        return;
                    }

                    this.$router.push({ name: route, params });
                }
            }
        }
	}
</script>

<style>
    .fk-admin-screen-form > .fk-admin-field-row {
        @apply .py-6;
    }
    .fk-admin-screen-form > .fk-admin-field-row.error {
        @apply .-mx-10 .px-10;
    }
</style>
