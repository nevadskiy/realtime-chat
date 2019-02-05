import store from './store';

require('./bootstrap');

window.Vue = require('vue');

Vue.component('conversation-form', require('./components/forms/ConversationForm.vue').default);
Vue.component('conversation-reply-form', require('./components/forms/ConversationReplyForm.vue').default);
Vue.component('conversation-add-user-form', require('./components/forms/ConversationAddUserForm.vue').default);
Vue.component('conversations-dashboard', require('./components/ConversationsDashboard.vue').default);
Vue.component('conversations', require('./components/Conversations.vue').default);
Vue.component('conversation', require('./components/Conversation.vue').default);

const app = new Vue({
    el: '#app',
    store,
});
