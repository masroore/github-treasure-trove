try {

    //---- MDBOOTSTRAP ----
    window.$ = window.jQuery = require('jquery/dist/jquery');
    window.Popper = require('mdbootstrap/js/popper.min');
    require('mdbootstrap/js/bootstrap.min');
    require('mdbootstrap/js/mdb.min');


    window.moment = require("moment");
    window.moment.updateLocale("es");


    require("smartwizard");
    require("bootstrap-datepicker");
    require("bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min");
    require("bootstrap-select/dist/js/bootstrap-select");
    require("bootstrap-select/dist/js/i18n/defaults-es_ES");
    require("parsleyjs");
    require("parsleyjs/dist/i18n/es");
    require("block-ui");
    require('../panel/utils');

    Headroom = require("headroom.js");


} catch (e) {

    console.log(e);
}


