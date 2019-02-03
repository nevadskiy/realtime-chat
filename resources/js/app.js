import store from './store';

require('./bootstrap');

window.Vue = require('vue');

Vue.component('conversations-dashboard', require('./components/ConversationsDashboard.vue').default);

const app = new Vue({
    el: '#app',
    store,
});
