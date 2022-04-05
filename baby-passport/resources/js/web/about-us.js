import {CountUp} from "countup.js";
import 'appear/dist/appear';
import 'owl.carousel';

$(function () {

    //Set countup animations when the countup section appears
    appear({
        init: () => {

        },
        elements: () => {

            return document.getElementsByClassName('countups');
        },
        appear: (element) => {

            const partnersCountUp = new CountUp('partners-countup', 10);
            partnersCountUp.start();

            const birthsCountUp = new CountUp('births-countup', 6000);
            birthsCountUp.start();

            const pacientsCountUp = new CountUp('pacients-countup', 6200);
            pacientsCountUp.start();

        },
        bounds: 0,
        reappear: true
    });


    /*----VIDEO SLIDER ----*/
    $('.video-carousel').owlCarousel({
        items: 1,
        nav: true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        autoPlay: 2500,
        slideSpeed: 1500,
        paginationSpeed: 1500,
        dots: false,
        lazyLoad: true,
        loop: true
    });


    //Whatsapp-doctor
$(".btn-whatsdoctor,[data-whats]").on("click", function () {

var name = document.getElementById("name-doctor").value
var speciality = document.getElementById("speciality").value
var city = document.getElementById("city").value

var text = `*Quiero información para formar parte del equipo de BabyPassport* %0a`;
        text += `   *Nombre:* ${name} %0a`;
        text += `   *Especialidad:* ${speciality } %0a`;
        text += `   *Ciudad:* ${city} %0a`;

window.open(
    "https://api.whatsapp.com/send?phone=524421127793" + "&text=" + text
);

return false;
}); 


//Whatsapp-aliado-baby-passport
$(".btn-whats-doctor-aliado,[data-whats]").on("click", function () {
console.log("holo")

    var text = "Informes para ser parte del equipo Baby Passport";
    
    window.open(
        "https://api.whatsapp.com/send?phone=524421127793" + "&text=" + text
    );
    
    return false;
    });  



});



    
    

