
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import { sync } from 'vuex-router-sync';

window.Vue = require('vue');

Vue.use(VueRouter);

import router from './router';
import store from './vuex';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.config.debug = true;
Vue.config.devtools = true;

import AppMain from './components/AppMain.vue'

sync(store, router)

const app = new Vue({
    name: 'BundesligaChallenge',
    components: {
        AppMain
    },
    store,
    router,
    render: h => h(AppMain)
}).$mount('#app');
