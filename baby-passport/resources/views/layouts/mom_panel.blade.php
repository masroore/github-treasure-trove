<!DOCTYPE html>
<html lang="es">
<head>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-134820805-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-134820805-1');
    </script>

    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5L7QXMW');</script>
    <!-- End Google Tag Manager -->


    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '325371284750533');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
             src="https://www.facebook.com/tr?id=325371284750533&ev=PageView
&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->


    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="{{asset('img/miscellaneous/fav.jpg')}}" type="image/x-icon"/>
    <!-- CRITICAL CSS -->
    <style>
        @font-face {
            font-family: "Campton";
            font-display: auto;
            src: url({{asset('fonts/Campton-SemiBold.otf')}});
        }

        @font-face {
            font-family: "Roboto";
            font-display: auto;
            src: url({{asset('fonts/Roboto-Regular.ttf')}});
        }

        body {
            font-family: "Roboto", Arial, Helvetica, sans-serif !important;
        }

        body h1,
        body h2,
        body h3,
        body h4,
        body h5 {
            font-family: "Campton", Arial, Helvetica, sans-serif;
        }
    </style>

    <!-- END CRITICAL CSS -->
    @yield('title')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset(mix('/css/mom_panel/mom_panel.css'))}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @yield('custom_styles')

</head>
<body>


<!--FLOATING BUTTONS-->
<a class="btn btn-flat btn-whatsapp btn-whats">
    <i class="fab fa-whatsapp"></i>
</a>
<a class="btn btn-flat btn-blue-call btn-call" href="tel:+5214422371427">
    <i class="fas fa-phone"></i>
</a>
<!--END FLOATING BUTTONS-->


@yield('navbar')

<div class="container-fluid px-0">
    @yield('content')
</div>

@yield('footer')



<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function () {
        var widget_id = 'ZmnyDLs1Vu';
        var d = document;
        var w = window;

        function l() {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = '//code.jivosite.com/script/widget/' + widget_id
            ;var ss = document.getElementsByTagName('script')[0];
            ss.parentNode.insertBefore(s, ss);
        }

        if (d.readyState == 'complete') {
            l();
        } else {
            if (w.attachEvent) {
                w.attachEvent('onload', l);
            } else {
                w.addEventListener('load', l, false);
            }
        }
    })();
</script>
<!-- {/literal} END JIVOSITE CODE -->


<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5L7QXMW"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->


<a id="DATA" data-url="{{URL::to('/')}}"></a>
<script src="{{asset(mix('/js/mom_panel/mom_panel.js'))}}"></script>


@yield('custom_scripts')
</body>
</html>
