import Vue from 'vue';
import Router from 'vue-router';
import axios from 'axios';

import createRouter from './router'

Vue.use(Router);

export default config => {
    return new Vue({
        data () {
            return config;
        },
        http: axios,
        router: createRouter(config)
    });
}
