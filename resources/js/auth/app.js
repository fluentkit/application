import Vue from 'vue';
import createRouter from './router';

// Global components
import layout from './components/layout/layout';
import input from './components/input';

// Export app creator
export default config => {
    // Apply filters
    Vue.filter('url', path => config.assetUrl+path);

    // Apply components
    Vue.component(input.name, input);

    return new Vue({
        router: createRouter(config),
        components: {
            [layout.name]: layout
        },
        data () {
            return config;
        },
        render (createElement) {
            return createElement('fk-auth-layout');
        }
    });
}
