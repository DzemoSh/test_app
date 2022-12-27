require('./bootstrap');

import Vue from 'vue';
window.Vue = require('vue').default;

import Router from 'vue-router';
Vue.use(Router);
import routes from './routes';

// axios
import axios from './axios.js'
Vue.prototype.$http = axios

// Vuesax Component Framework
import Vuesax from 'vuesax'
Vue.use(Vuesax)
//Vuesax styles
import 'vuesax/dist/vuesax.css'

const app = new Vue({
    el: '#app',
    router: new Router(routes)
});
