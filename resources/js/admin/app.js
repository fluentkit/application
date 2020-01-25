import Vue from 'vue';
import Router from 'vue-router';
import axios from 'axios';
import NProgress from 'nprogress';

import createRouter from './router'

NProgress.configure({ parent: '#screen-container' });

Vue.use(Router);

Vue.mixin({
    methods: {
        request () {
            return axios;
        },
        progress () {
            return NProgress;
        }
    }
});

Vue.component('screen-type-html', {
    template: `<div class="flex flex-grow m-10" v-html="html"></div>`,
    data () {
        return {
            html: '<div class="flex-1 bg-white shadow-md rounded p-10 m-4 text-center">Loading...</div>'
        }
    },
    async created () {
        try {
            const { meta: { section, screen } } = this.$route;
            const { data: { data: { html } } } = await this.request().post('/admin/'+section.id+'/'+screen.id+'/getHtml');
            this.html = html;
        } catch (e) {
            console.log(e);
        } finally {
            this.progress().done();
        }
    }
});

const Admin = Vue.extend();

export default config => {
    const router = createRouter(config);
    router.beforeResolve((to, from, next) => {
        if (to.name) {
            NProgress.start();
        }
        next();
    });

    // each screen component is responsible for indicating its finished loading.
    // router.afterEach((to, from) => {
    //     NProgress.done();
    // });

    return new Admin({
        data () {
            return config;
        },
        router
    });
}
