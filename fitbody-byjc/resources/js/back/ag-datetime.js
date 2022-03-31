window.Vue = require('vue');

import Datetime from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css' // You need a specific loader for CSS files
Vue.use(Datetime)


Vue.component('ag-datepicker', require('./components/DatePicker/DatePicker').default);

const app = new Vue({
    el: '#sl-app',
});
