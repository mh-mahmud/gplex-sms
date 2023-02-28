window.Vue = require('vue');

const Chats = Vue.component('Chats', require('../views/chats/chats.vue'));

export default [
    {name: 'Chats', path: '/', component: Chats},
    {name: 'Chats', path: '/chats', component: Chats},
];