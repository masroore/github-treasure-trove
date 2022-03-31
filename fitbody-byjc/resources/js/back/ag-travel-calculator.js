window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Datetime component
 */
import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css' // You need a specific loader for CSS files
Vue.use(Datetime)
/**
 * Vue Select2 component
 */
import vSelect from 'vue-select'
import "vue-select/src/scss/vue-select.scss";
Vue.component('v-select', vSelect)
/**
 * Vue Local Storege component
 */
import { Vue2Storage } from 'vue2-storage'
Vue.use(Vue2Storage, {
    prefix: 'agot_',
    driver: 'local',
    ttl: 60 * 60 * 2 * 1000 // 2h in milisec.
})

Vue.component('ag-travel-calculator', require('./components/TravelCalculator/TravelCalculator').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#agtc-app',
});
