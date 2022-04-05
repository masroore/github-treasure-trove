$(document).ready(function () {
    //menuBar
    $(".menuBar").click(function (e) {
        $(".main-nav").addClass("open");
        $("#page-contianer").addClass("m-menu-open");
    });
    //Close btn
    $(".close").click(function (e) {
        $(".main-nav").removeClass("open");
        $("#page-contianer").removeClass("m-menu-open");
    });
    //close menu on outside click
    $("html").on("click", function (e) {
        if (e.target.id == "page-contianer") {
            $(".main-nav").removeClass("open");
            $("#page-contianer").removeClass("m-menu-open");
        }
    });
    //Social btn
    $(".social_btn").click(function (e) {
        if ($(".social_btns").hasClass("social-open") == true) {
            $(".social_btns").removeClass("social-open");
        } else {
            $(".social_btns").addClass("social-open");
        }
    });

    let feature_slider = $(".feature-post-slider");

    feature_slider.owlCarousel({
        loop: true,
        dots: false,
        autoplay: true,
        center: true,
        margin: 5,
        lazyLoad: true,
        responsive: {
            0: {
                items: 1,
                margin: 0
            },
            600: {
                items: 2
            },
            1024: {
                items: 3,
                autoplay: false
            }
        }
    });

    //Carousel Nav Buttons
    $(".btn-prev").click(function (e) {
        feature_slider.trigger("prev.owl.carousel");
    });
    $(".btn-next").click(function (e) {
        feature_slider.trigger("next.owl.carousel");
    });

    // Sweet alert 2 code===============================================
    $(document).on("click", "#delete", function (e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-success"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            })
            .then(result => {
                if (result.value) {
                    // Get action url from data attribute
                    $action = $(this).data("action");
                    //  Set delete form action attribute to that url
                    $("#deleteForm").attr("action", $action);
                    // Submit the form
                    $("#deleteForm").submit();

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        "Cancelled",
                        "Your imaginary file is safe :)",
                        "error"
                    );
                }
            });
    });


    /* slug making */
    $('input#title').keyup(function (e) {
        var slug = $('input#title').val().toLowerCase().replace(/[^a-zA-Z]/g, "-");
        $('input#slug').val(slug);
    });

});
