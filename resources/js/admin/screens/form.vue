<template>
    <fk-admin-background v-if="!attributes || !fields || !actions"/>
    <div v-else class="flex flex-col flex-grow">
        <fk-admin-field-row v-for="field in fields" :key="field.id" :field="field" v-model="attributes"/>
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
        async created () {
            try {
                const { $section, $screen } = this;

                const [fieldRequest, attributeRequest, actionRequest] = await Promise.all([
                    this.$request().post(url`/admin/${$section.id}/${$screen.id}/getFields`),
                    this.$request().post(url`/admin/${$section.id}/${$screen.id}/getAttributes`),
                    this.$request().post(url`/admin/${$section.id}/${$screen.id}/getActions`),
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
                        data: { message, type, attributes }
                    } = await this.$form.post(url`/admin/${$section.id}/${$screen.id}/${action.action}`, { attributes: this.attributes });
                    this['$'+type](message);
                    this.attributes = attributes;
                } catch (e) {
                    this.$error(e);
                } finally {
                    action.disabled = false;
                    this.$progress().done();
                }
            }
        }
	}
</script>
