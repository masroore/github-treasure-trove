window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
//window.Vue = require('vue');


Vue.component('ag-auto-suggestion', require('./components/Autosuggestion/Autosuggestion').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#ag-auto-suggestion-app',
});
