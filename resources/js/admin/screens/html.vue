<template>
    <div class="flex flex-grow m-10" v-html="html"></div>
</template>

<script>
	export default {
		name: 'fk-admin-screen-html',
        data () {
            return {
                html: '<div class="flex-1 bg-white shadow-md rounded p-10 m-4 text-center">Loading...</div>'
            }
        },
        async created () {
            try {
                const { meta: { section, screen } } = this.$route;
                const { data: { data: { html } } } = await this.$request().post('/admin/'+section.id+'/'+screen.id+'/getHtml');
                this.html = html;
            } catch (e) {
                this.$error(e);
            } finally {
                this.$progress().done();
            }
        }
	}
</script>
