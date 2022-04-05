/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {

    //---- MDBOOTSTRAP ----
    window.$ = window.jQuery = require('mdbootstrap/js/jquery-3.4.1.min');
    window.Popper = require('mdbootstrap/js/popper.min');
    require('mdbootstrap/js/bootstrap.min');
    require('mdbootstrap/js/mdb.min');

    window.moment = require("moment");
    window.moment.updateLocale("es");



    require("parsleyjs");
    require("parsleyjs/dist/i18n/es");

    Headroom = require("headroom.js");
    Masonry = require('masonry-layout/dist/masonry.pkgd');


} catch (e) {
}
