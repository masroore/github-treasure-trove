import 'owl.carousel';
import {CountUp} from "countup.js";
import 'appear/dist/appear';

$(function () {


    /*----MAIN COPY SLIDER ----*/
    $('.main-carousel').owlCarousel({
        items: 1,
        nav: true,
        navClass: ['owl-prev btn btn-ce-soir btn-lg white-text waves-effect waves-light','owl-next'],
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        dots: false,
        lazyLoad: true,
        slideSpeed: 41000,
        stopOnHover: true,
        loop: true
    });


    //Set bounceIndown animation when cities section appears
    appear({
        init: () => {

        },
        elements: () => {

            return document.getElementsByClassName('cities');
        },
        appear: (element) => {

            $(element).addClass('bounceInDown animated slow');


        },
        disappear: (element) => {
            $(element).removeClass('bounceInDown animated slow');
        },
        reappear: false,
        bounds: 0
    });


    //Set fadeInLeft animation when ads section appears
    appear({
        init: () => {

        },
        elements: () => {
            return document.getElementsByClassName('ads');
        },
        appear: (element) => {
            $(element).addClass('fadeInLeft animated fast');
        },
        disappear: (element) => {
            $(element).removeClass('fadeInLeft animated fast');
        },
        reappear: true,
        bounds: 100
    });


    //Set zoomIn animation on blog items when the blog section appears
    appear({
        init: () => {

        },
        elements: () => {
            return document.getElementsByClassName('blogs');
        },
        appear: (element) => {

            const blogItems = $(element).find('.blog-item');


            for (let i = 0; i < blogItems.length; ++i) {
                setTimeout(() => {
                    $(blogItems[i]).addClass('zoomIn animated fast');
                }, 400 * i);
            }


        },
        disappear: (element) => {
            $(element).find('.blog-item').removeClass('zoomIn animated fast');
        },
        reappear: true,
        bounds: 0
    });

    //Set countup animations when the countup section appears
    appear({
        init: () => {

        },
        elements: () => {

            return document.getElementsByClassName('countups');
        },
        appear: (element) => {

            const partnersCountUp = new CountUp('partners-countup', 30);
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
        navText: ['<i class="fa fa-angle-left" style="color:#DDDDDD;" aria-hidden="true"></i>', '<i class="fa fa-angle-right" style="color:#DDDDDD;" aria-hidden="true"></i>'],
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        autoPlay: 2500,
        slideSpeed: 1500,
        paginationSpeed: 1500,
        dots: false,
        lazyLoad: true,
        loop: true
    });


    /*
            var iframe = document.querySelector('iframe');
            var player = new Vimeo.Player(iframe);


            player.on("play", function () {
                $(".embed-responsive-play").hide();
                $(".carousel").carousel("pause");
                $("header").hide();

            });
            player.on("pause", function () {
                $(".embed-responsive-play").show();
            });


        $(".embed-responsive-play").on("click", function () {
            player.play();
        });
    */

});
