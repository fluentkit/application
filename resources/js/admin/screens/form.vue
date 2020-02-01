<template>
    <fk-admin-background v-if="!attributes || !fields || !actions"/>
    <div v-else class="fk-admin-screen-form">
        <component v-for="field in fields" :key="field.id" :is="field.component" v-if="!field.hidden" :field="field" :errors="$form.errors" v-model="attributes"/>
        <fk-admin-form-actions :actions="actions" @click="performAction"/>
    </div>
</template>

<script>
    import url from '../../utils/url';
    import request from '../../mixins/request';
    import form from '../../mixins/form';
    import screen from '../mixins/screen';
    import progress from '../mixins/progress';
    import toast from '../mixins/toast';

	export default {
		name: 'fk-admin-screen-form',
        mixins: [request, form, screen, progress, toast],
        data () {
            return {
                fields: null,
                attributes: null,
                actions: null,
                buttonText: 'Save Changes'
            }
        },
        computed: {
		    requestQuery () {
		        const params = [];
		        for (const param in this.$route.params) {
		            if (this.$route.params.hasOwnProperty(param)) {
                        params.push(`${param}=${this.$route.params[param]}`)
                    }
                }

		        if (!params.length) {
		            return '';
                }

		        return `?${params.join('&')}`;
            }
        },
        async created () {
            try {
                const { $section, $screen } = this;

                const [fieldRequest, attributeRequest, actionRequest] = await Promise.all([
                    this.$request().get(url`/admin/${$section.id}/${$screen.id}/fields`+this.requestQuery),
                    this.$request().get(url`/admin/${$section.id}/${$screen.id}/attributes`+this.requestQuery),
                    this.$request().get(url`/admin/${$section.id}/${$screen.id}/actions`+this.requestQuery),
                ]);

                const { data: { fields = {} } } = fieldRequest;
                const { data: { attributes = {} } } = attributeRequest;
                const { data: { actions } } = actionRequest;
                this.fields = fields;
                this.attributes = attributes;
                this.actions = actions;
            } catch (e) {
                this.$error(e);
            } finally {
                this.$progress().done();
            }
        },
        methods: {
		    async performAction (action) {
                try {
                    action.disabled = true;
                    this.$progress().start();
                    const { $section, $screen } = this;
                    const {
                        data: { message, type, meta, attributes }
                    } = await this.$form.post(url`/admin/${$section.id}/${$screen.id}/${action.id}`+this.requestQuery, { attributes: this.attributes });
                    if (type === 'notification') {
                        this['$'+meta.toast.type](message);
                    }
                    this.attributes = attributes;
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
