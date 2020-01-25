import createApp from './admin/app';

window.fkAdmin = createApp(window.fkAdminConfig).$mount('#admin');
