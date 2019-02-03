import Vuex from 'vuex';

require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.use(Vuex);

const app = new Vue({
    el: '#app'
});
