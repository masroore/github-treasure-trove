/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

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

    $("#load").fadeOut(1500);
    $("[data-chat]").on("click", function () {
        jivo_api.showProactiveInvitation("¿Tienes problemas para registrarte?");
        jivo_api.open();
    });
    //CAll
    $(".btn-call,[data-call]").on("click", function () {
        /*  gtag("event", "llamada", {
             event_category: "llamada_realizada"
         }); */

        window.open("tel:+524421127793");
        return false;
    });

    //Whatsapp
    $(".btn-whats,[data-whats]").on("click", function () {
        /* gtag("event", "whatsapp_general", {
            event_category: "whatsapp_enviado",
            event_label: "general"
        }); */
         
        text = "Informes Baby Passport";
        window.open(
            "https://api.whatsapp.com/send?phone=524421127793" + "&text=" + text
        );

        return false;
    });


    //Whatsapp-price
    $(".btn-whats-price,[data-whats]").on("click", function () {
        /* gtag("event", "whatsapp_general", {
            event_category: "whatsapp_enviado",
            event_label: "general"
        }); */
         
        text = "Informes del plan de pagos de Baby Passport";
        window.open(
            "https://api.whatsapp.com/send?phone=524421127793" + "&text=" + text
        );

        return false;
    });

//Whatsapp-data
    $(".btn-whatsData,[data-whats]").on("click", function () {
var name = document.getElementById("name").value
var phone = document.getElementById("phone").value
var hospital = document.getElementById("hospital").value

        text = `    *Quiero agendar una cita* %0a`;
        text += `    *Nombre:* ${name} %0a`;
        text += `   *Teléfono:* ${phone} %0a`;
        text += `   *Hospital:* ${hospital} %0a`;
        window.open(
            "https://api.whatsapp.com/send?phone=524421127793" + "&text=" + text
        );

        return false;
    });

  //Whatsapp-packge
  $(".btn-whatspackge,[data-whats]").on("click", function (packge) {

        text = `    *Quiero agendar una cita* %0a`;
        text += `    *Paquete:* ${packge.delegateTarget.value} %0a`;
        
        window.open(
            "https://api.whatsapp.com/send?phone=524421127793" + "&text=" + text
        );
});  



});


  

//window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/* const app = new Vue({
    el: '#app'
});
 */
