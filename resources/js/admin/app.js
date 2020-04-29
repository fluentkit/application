import Vue from 'vue';
import { sync } from 'vuex-router-sync';
import createStore from './store';
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
        require('./components/elements/table').default,
        require('./components/elements/pagination').default,
        // fields
        require('./components/elements/field/row').default,
        require('./components/elements/field/panel').default,
        require('./components/elements/field/group').default,
        require('./components/elements/field/label').default,
        require('./components/elements/field/input').default,
        require('./components/elements/field/checkbox').default,
        require('./components/elements/field/select').default,
        require('./components/elements/field/route').default,
        require('./components/elements/field/keyValue').default,
        require('./components/elements/field/belongsTo').default,
        require('./components/elements/field/hasMany').default,
        require('./components/elements/field/belongsToMany').default,
        // form
        require('./components/elements/form-actions').default,
    ]);

    const store = createStore(config);
    const router = createRouter(config);

    // Sync router with store
    sync(store, router);

    return new Vue({
        store,
        router,
        components: {
            [layout.name]: layout
        },
        data () {
            return config;
        },
        render (createElement) {
            return createElement('fk-admin-layout');
        }
    });
}
