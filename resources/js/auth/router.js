import Vue from 'vue';
import Router from 'vue-router';

import loginScreen from './screens/login';
import forgotScreen from './screens/forgot';
import resetScreen from './screens/reset';

const createRoutes = config => {
    return [
        {
            path: '/login',
            name: 'login',
            component: loginScreen
        },
        {
            path: '/forgot-password',
            name: 'login.forgot',
            component: forgotScreen
        },
        {
            path: '/reset-password/:token',
            name: 'login.reset',
            component: resetScreen
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
