require('./bootstrap');
window.Vue = require('vue');
import Shop from './components/Shop.vue';

Vue.component('shop', Shop);
new Vue({el: '#app-container'});