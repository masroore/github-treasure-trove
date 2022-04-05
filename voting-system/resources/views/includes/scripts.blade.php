@section('script')
    @stack("js-scripts")
    <script src="{{ asset('assets/styles/bootstrap4/popper.js') }}"></script>
    <script src="{{ asset('assets/styles/bootstrap4/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/greensock/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/greensock/TimelineMax.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/greensock/animation.gsap.min.') }}js"></script>
    <script src="{{ asset('assets/plugins/greensock/ScrollToPlugin.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/plugins/easing/easing.js') }}"></script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

    @if (Route::currentRouteName() === 'welcome' || Route::currentRouteName() === 'group' || Route::currentRouteName() === 'profile' || Route::currentRouteName() === 'dashboard' || Route::currentRouteName() === 'chart')
        <script src="{{ asset('assets/plugins/slick-1.8.0/slick.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
    @endif
    @if (Route::currentRouteName() === 'detail')
        <script src="{{ asset('assets/js/product_custom.js') }}"></script>
    @endif
    <script>
        $(".addtowishlist").click(function(e) {
            e.preventDefault();

            var formdata = new FormData()
            formdata.append("createuser", CREATEUSER);
            formdata.append("device", $(this).data('data'));

            fetch(`${APP_URL}/api/product/wishlist`, {
                method: "POST",
                body: formdata,
            }).then(function(res) {
                return res.json()
            }).then(function(data) {
                if (!data.ok) {
                    console.log(data.msg)
                    return;
                }
                console.log(data.msg)
                $("#refresh-wishlist").load(window.location.href + " #refresh-wishlist");
            }).catch(function(err) {
                if (err) {
                    console.log(err)
                }
            })
        });


        $(".vote").click(function(e) {
            e.preventDefault();

            if (!Boolean(CREATEUSER)) {
                window.location.href = `${APP_URL}/auth/google`;
                return;
            }

            var group = $(this).data('group');
            var artist = $(this).data('artist')
            var name = $(this).data('name');

            var formdata = new FormData()
            formdata.append("userid", CREATEUSER);
            formdata.append("group", group);
            formdata.append("artist", artist);
            
            Swal.fire({
                text: `Are you sure you want to vote for ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Vote'

            }).then((result) => {
                if (result.value) {
                    fetch(`${APP_URL}/api/vote`, {
                        method: "POST",
                        body: formdata,
                    }).then(function(res) {
                        return res.json()
                    }).then(function(data) {
                        if (!data.ok) {

                            Swal.fire({
                                icon: "error",
                                text: data.msg
                            });
                            return;
                        }
                        $(".artist_"+group+"_"+artist).load(window.location.href + " .artist_"+group+"_"+artist);
                        Swal.fire({
                            icon: "success",
                            html: `Your vote has been recorded. Thank you for supporting ${name} 👍 <br> <a href="${APP_URL}/dashboard">Click to view votes results</a>`
                        });
                    }).catch(function(err) {
                        if (err) {
                            console.log(err)
                        }
                    })
                }
            })
        });

    </script>
@show
