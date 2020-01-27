import Vue from 'vue';
import createRouter from './router';

// Global Mixins
import requestMixin from './mixins/global/request';
import busMixin from './mixins/global/bus';
import screenMixin from './mixins/global/screen';
import progressMixin from './mixins/global/progress';
import toastMixin from './mixins/global/toast';

// Global components
import layout from './components/layout/layout';
import background from './components/layout/background';

// Element components
import title from './components/elements/title';
import panel from './components/elements/panel';
import button from './components/elements/button';

// Field components
import fieldRow from './components/elements/field/row';
import fieldPanel from './components/elements/field/panel';
import fieldLabel from './components/elements/field/label';
import fieldInput from './components/elements/field/input';

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

    // Register layout components
    Vue.component(background.name, background);

    // Register element components
    Vue.component(title.name, title);
    Vue.component(panel.name, panel);
    Vue.component(button.name, button);

    // Register field components
    Vue.component(fieldRow.name, fieldRow);
    Vue.component(fieldPanel.name, fieldPanel);
    Vue.component(fieldLabel.name, fieldLabel);
    Vue.component(fieldInput.name, fieldInput);

    return new Admin({
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
