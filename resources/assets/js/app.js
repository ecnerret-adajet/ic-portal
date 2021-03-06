
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuex from 'vuex';
import StoreData from './vuex/store';

Vue.use(Vuex);

const store = new Vuex.Store(StoreData);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('company-home', require('./components/CompanyHome.vue'));
Vue.component('company-show', require('./components/CompanyShow.vue'));
Vue.component('reliever-home', require('./components/RelieverHome.vue'));
Vue.component('user-home', require('./components/UserHome.vue'));
Vue.component('user-create', require('./components/UserCreate.vue'));
Vue.component('profile-edit', require('./components/ProfileEdit.vue'));
Vue.component('roles-permissions', require('./components/RolesPermissions.vue'));
Vue.component('disclaimer', require('./components/Disclaimer.vue'));


const app = new Vue({
    el: '#app',
    store
});
