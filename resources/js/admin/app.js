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
import sidebarHeader from './components/layout/sidebar/header';
import sidebarMenu from './components/layout/sidebar/menu';

// Element components
import title from './components/elements/title';
import panel from './components/elements/panel';
import button from './components/elements/button';

// Field components
import fieldRow from './components/elements/field/row';
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

    // Register element components
    Vue.component(title.name, title);
    Vue.component(panel.name, panel);
    Vue.component(button.name, button);

    // Register field components
    Vue.component(fieldRow.name, fieldRow);
    Vue.component(fieldLabel.name, fieldLabel);
    Vue.component(fieldInput.name, fieldInput);

    return new Admin({
        router: createRouter(config, progress),
        components: {
            [header.name]: header,
            [sidebarHeader.name]: sidebarHeader,
            [sidebarMenu.name]: sidebarMenu
        },
        data () {
            return config;
        }
    });
}
