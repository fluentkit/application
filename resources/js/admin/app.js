import Vue from 'vue';
import Router from 'vue-router';
import axios from 'axios';
import NProgress from 'nprogress';
import Toasted from 'vue-toasted';

import createRouter from './router';
import HtmlScreen from './screens/html';

NProgress.configure({ parent: '#screen-container' });

const Bus = new Vue();

Vue.use(Router);
Vue.use(Toasted, {
    keepOnHover: true,
    iconPack: 'fontawesome',
    theme: 'fluentkit',
    position: 'bottom-right',
    duration: 5000
});

Vue.mixin({
    methods: {
        $request () {
            return axios;
        },
        $progress () {
            return NProgress;
        },
        $bus () {
            return Bus;
        },
        _mergeToastOptions (options, defaults = {}) {
            options = {
                close: true,
                action: [],
                ...defaults,
                ...options
            };
            if (options.close) {
                options.action.push({
                    text: 'close',
                    onClick: (e, toast) => toast.goAway(0)
                });
            }

            return options;
        },
        $toast (message, options = {}) {
            options = this._mergeToastOptions(options);
            return this.$toasted.show(message, options);
        },
        $info (message, options = {}) {
            options = this._mergeToastOptions(options, { icon: 'info' });
            return this.$toasted.info(message, options);
        },
        $success (message, options = {}) {
            options = this._mergeToastOptions(options, { icon: 'check' });
            return this.$toasted.success(message, options);
        },
        // Errors are special in that they work just like other toasts, but additionally accept an error object,
        // and can construct the error toast directly from it.
        $error (message, options = {}) {
            if (message instanceof Error) {
                const error = message;
                message = error.message;
                if (error.response) {
                    const { data: { message: responseMessage } } = error.response;
                    if (responseMessage) {
                        message = message + ': ' + responseMessage;
                    }
                }
            }
            options = this._mergeToastOptions(options, { icon: 'exclamation', duration: null });
            return this.$toasted.error(message, options);
        }
    }
});

Vue.component(HtmlScreen.name, HtmlScreen);

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
        router,
        data () {
            return config;
        },
        computed: {
            headerTitles () {
                const { section, screen } = this.$route.meta;

                if (!section || !screen) {
                    return [];
                }

                if (section.id === 'dashboards') {
                    return [
                        screen.label
                    ];
                }

                return [
                    section.label,
                    screen.label
                ]
            }
        }
    });
}
