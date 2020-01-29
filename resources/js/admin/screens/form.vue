<template>
    <fk-admin-background v-if="!attributes"/>
    <div v-else class="flex flex-col flex-grow">
        <fk-admin-field-row v-for="field in $screen.fields" :key="field.id" :field="field" v-model="attributes"/>
        <div class="flex flex-row">
            <fk-admin-button type="info" :disabled="$form.processing" @click="saveForm">{{ buttonText }}</fk-admin-button>
        </div>
    </div>
</template>

<script>
    import url from '../../utils/url';
    import form from '../../mixins/form';

	export default {
		name: 'fk-admin-screen-form',
        mixins: [form],
        data () {
            return {
                attributes: null,
                buttonText: 'Save Changes'
            }
        },
        async created () {
            try {
                const { $section, $screen } = this;
                const {
                    data: { data: { attributes } }
                } = await this.$request().post(url`/admin/${$section.id}/${$screen.id}/getAttributes`);
                this.attributes = attributes;
            } catch (e) {
                this.$error(e);
            } finally {
                this.$progress().done();
            }
        },
        methods: {
		    async saveForm () {
                try {
                    this.buttonText = 'Saving';
                    this.$progress().start();
                    const { $section, $screen } = this;
                    const {
                        data: { data: { request, message } }
                    } = await this.$form.post(url`/admin/${$section.id}/${$screen.id}/saveAttributes`, { attributes: this.attributes });
                    console.log(request);
                    this.$success(message);
                } catch (e) {
                    this.$error(e);
                } finally {
                    this.buttonText = 'Save Changes';
                    this.$progress().done();
                }
            }
        }
	}
</script>
