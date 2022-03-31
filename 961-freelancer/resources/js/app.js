/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueSocketio from 'vue-socket.io';
import socketio from 'socket.io-client';



window.Vue = require('vue').default;
import VueRouter from 'vue-router'
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
window.Vue.prototype.$socket = socketio.connect('https://961freelancer.com:22000');
Vue.use(new VueSocketio({
    debug: true,
    connection: 'https://961freelancer.com:22000',
}))
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.use(VueRouter)



const example = require('./components/ExampleComponent.vue').default;
const example2 = require('./components/O2oCall.vue').default;

const routes = [
    {
        path: '/',
        component: example
    },
    {
        path: '/o2ocall',
        component: example2,
        props: true
    }
];

const router = new VueRouter({
    routes
})
// Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    router
});
