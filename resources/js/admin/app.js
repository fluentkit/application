import Vue from 'vue';
import createRouter from './router';

// Global Mixins
import requestMixin from './mixins/global/request';
import busMixin from './mixins/global/bus';
import screenMixin from './mixins/global/screen';
import { default as progressMixin, progress } from './mixins/global/progress';
import toastMixin from './mixins/global/toast';

// Global components
import header from './components/layout/header';

// Export app creator
export default config => {
    const Admin = Vue.extend();

    // Apply global mixins
    Vue.mixin(requestMixin);
    Vue.mixin(busMixin);
    Vue.mixin(screenMixin);
    Vue.mixin(progressMixin);
    Vue.mixin(toastMixin);

    // Apply filters
    Vue.filter('url', path => config.assetUrl+path);

    return new Admin({
        router: createRouter(config, progress),
        components: {
            [header.name]: header
        },
        data () {
            return config;
        }
    });
}
