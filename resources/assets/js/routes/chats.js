window.Vue = require('vue');

const Chats = Vue.component('Chats', require('../views/chats/chats.vue'));
const DispositionList = Vue.component('DispositionList', require('../views/disposition/list.vue'));
const DispositionAdd = Vue.component('DispositionAdd', require('../views/disposition/disposition_add.vue'));

export default [
    {name: 'Chats', path: '/', component: Chats},
    {name: 'Chats', path: '/chats', component: Chats},
    {name: 'DispositionList', path: '/disposition-list', component: DispositionList},
    {name: 'DispositionAdd', path: '/disposition-add', component: DispositionAdd},
];