window.Vue = require('vue');
// Inbound Component
const TextList = Vue.component('TextList', require('../views/text/list.vue'));
const AutoMessage = Vue.component('AutoMessage', require('../views/autoMessage/message_settings.vue'));

export default [
    // inbound route
    // {name: 'TextList', path: '/text-list', component: TextList},
    {name: 'InboundList', path: '/inbound-list', component: TextList},
    {name: 'AutoMessage', path: '/auto-message-settings', component: AutoMessage},
];