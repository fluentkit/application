import Vue from 'vue';
import createRouter from './router';

// Global components
import layout from './components/layout/layout';

// Export app creator
export default config => {
    // Apply filters
    Vue.filter('url', path => config.assetUrl+path);

    const registerComponents = comps => comps.forEach(component => Vue.component(component.name, component));

    registerComponents([
        // layout
        require('./components/layout/background').default,
        // elements
        require('./components/elements/title').default,
        require('./components/elements/panel').default,
        require('./components/elements/button').default,
        // fields
        require('./components/elements/field/row').default,
        require('./components/elements/field/panel').default,
        require('./components/elements/field/label').default,
        require('./components/elements/field/input').default,
    ]);

    return new Vue({
        router: createRouter(config),
        components: {
            [layout.name]: layout
        },
        data () {
            return config;
        },
        render (createElement) {
            const { sections } = this;
            return createElement('fk-admin-layout', { props: { sections } });
        }
    });
}
