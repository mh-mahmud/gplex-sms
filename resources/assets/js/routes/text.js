window.Vue = require('vue');
// Inbound Component
const TextList = Vue.component('TextList', require('../views/text/list.vue'));

export default [
    // inbound route
    {name: 'TextList', path: '/text-list', component: TextList},
];