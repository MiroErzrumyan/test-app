import VueRouter from 'vue-router';
import {router} from "./routes";
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import Vue from 'vue'
import Vuex from 'vuex'
import store from './vuex/index';
import VueCookies from 'vue-cookies';
import {BootstrapVueIcons} from "bootstrap-vue";


require('./components')
require('./bootstrap');
window.Vue = require('vue').default;
window.store = store

Vue.use(Vuex)
Vue.use(VueRouter);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueCookies)
Vue.use(BootstrapVueIcons)
Vue.use(require('vue-multiselect/dist/vue-multiselect.min.css'))

window.axios.defaults.headers.common['Authorization'] = 'Bearer ' +  Vue.prototype.$cookies.get('token');

const app = new Vue({
    el: '#app',
    router,
    store
});
