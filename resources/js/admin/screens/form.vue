<template>
    <fk-admin-background v-if="!attributes"/>
    <div v-else class="flex flex-col flex-grow">
        <fk-admin-field-row v-for="field in $screen.fields" :key="field.id" :field="field" v-model="attributes[field.id]"/>
        <div class="flex flex-row">
            <fk-admin-button type="info" @click="saveForm">Save Changes</fk-admin-button>
        </div>
    </div>
</template>

<script>
    import url from '../../utils/url';

	export default {
		name: 'fk-admin-screen-form',
        data () {
            return {
                attributes: null
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
                    this.$progress().start();
                    const { $section, $screen } = this;
                    const {
                        data: { data: { request, message } }
                    } = await this.$request().post(url`/admin/${$section.id}/${$screen.id}/saveAttributes`, { attributes: this.attributes });
                    console.log(request);
                    this.$success(message);
                } catch (e) {
                    this.$error(e);
                } finally {
                    this.$progress().done();
                }
            }
        }
	}
</script>
