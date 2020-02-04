<template>
    <fk-admin-background v-if="!attributes || !fields || !actions"/>
    <div v-else class="fk-admin-screen-form">
        <component v-for="field in fields" :key="field.id" :is="field.component" v-if="!field.hidden" :field="field" :errors="$form.errors" v-model="attributes"/>
        <fk-admin-form-actions :actions="primaryActions" @click="formAction"/>
    </div>
</template>

<script>
    import screenBase from './base';

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
		    async formAction (action) {
		        const data = { ...this.$data };
		        delete data.modalInstance;
		        delete data.form;
		        await this.$screen.action(action, data);
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
