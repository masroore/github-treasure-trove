/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
require('../payment/bank.reference')
require('../payment/payment.history')

Headroom = require("headroom.js");


var header = document.getElementById("main-header");
if (header != null) {
    var headroom = new Headroom(header, {
        offset: 205,
        tolerance: 5,
        classes: {
            initial: "animated",
            pinned: "fadeInDown",
            unpinned: "fadeOutUp"
        }
    });
    headroom.init();
}


$(function () {

    $("[data-chat]").on("click", function () {
        jivo_api.showProactiveInvitation("¿Tienes problemas para registrarte?");
        jivo_api.open();
    });
    //CAll

    $(".btn-call,[data-call]").on("click", function () {
        window.open("tel:+524421127793");
        return false;
    });

    //Whatsapp
    $(".btn-whats,[data-whats]").on("click", function () {

        text = "Informes Baby Passport";
        window.open(
            "https://api.whatsapp.com/send?phone=524421127793" + "&text=" + text
        );

        return false;
    });






});
