import Vue from 'vue';
import Router from 'vue-router';

import loginScreen from './screens/login'

const createRoutes = config => {
    return [
        {
            path: '/login',
            name: 'login',
            component: loginScreen
        },
        {
            path: '/login/forgot-password',
            name: 'login.forgot',
            component: {
                template: `<div>forgot</div>`
            }
        }
    ];
};

export default config => {
    Vue.use(Router);

    return new Router({
        routes: createRoutes(config),
        mode: 'history',
        base: '/admin/'
    });
};
