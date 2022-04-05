/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {



    window.$ = window.jQuery = require('jquery/dist/jquery');
    window.Popper = require('mdbootstrap/js/popper.min');
    require('mdbootstrap/js/bootstrap.min');
    require('mdbootstrap/js/mdb.min');




    window.moment = require("moment");
    window.moment.updateLocale("es");
    require('pusher-js');

    require('jquery-toast-plugin');

    require("bootstrap");
    require("smartwizard");
    require("fullcalendar/dist/fullcalendar");
    require("fullcalendar/dist/locale/es");
    require("fullcalendar/dist/gcal");

    require("bootstrap-datepicker");
    require("bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min");
    require("bootstrap-select/dist/js/bootstrap-select");
    require("bootstrap-select/dist/js/i18n/defaults-es_ES");
    require("bootstrap-fileinput/js/fileinput");
    require("bootstrap-fileinput/js/locales/es");
    require("bootstrap-fileinput/themes/fas/theme");
    require("parsleyjs");
    require("parsleyjs/dist/i18n/es");
    require("block-ui");
    require('froala-editor/js/froala_editor.pkgd.min');
    require('froala-editor/js/languages/es');


    var dt = require('datatables.net-bs4')(window, $);
    var buttons = require('datatables.net-buttons-bs4')(window, $);
    require('datatables.net-responsive-bs4')(window, $);


} catch (e) {

    console.log(e.message);
}


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

//window.axios = require("axios");
//window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

/*let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
    console.error(
        "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token"
    );
}*/

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

//import Echo from 'laravel-echo'

//window.Pusher = require('pusher-js');

//window.Echo = new Echo({
//    broadcaster: 'pusher',
//    key: 'a38982f5d8e02b4bb37f',
//    cluster: 'us2',
//    encrypted: true,
//namespace: 'App.Events'
//});
