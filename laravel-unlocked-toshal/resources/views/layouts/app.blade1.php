<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="baseurl" content="{{secure_url('')}}">
    <link rel="icon" href="{{asset('frontend/images/hosting_favicon.png')}}" type="image/png" sizes="16x16">
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:type" content="website" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/style.css')}}?{{get_timestamp()}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/custom.css')}}?{{get_timestamp()}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/custom-style.css')}}?{{get_timestamp()}}">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/responsive.css')}}?{{get_timestamp()}}">
    <!-- range-slider-cdn -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <meta name="google-site-verification" content="qCurKRl9SHqWIYIbauLXbZmBpbUCGQZfSuuZb5AZKkQ" />
  <title> Recordgone </title>
  </head>

  <body>

  @include('layouts/header')
	
  @yield('content')
  @include('layouts/footer')

     <!-- footer-end -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="{{asset('frontend/js/slim.js')}}"></script>
    <script src="{{asset('frontend/js/popper.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
    <script>
		var baseurl = jQuery('meta[name="baseurl"]').prop('content');
		var token = jQuery('meta[name="csrf-token"]').prop('content');
    </script>
    <script src="{{asset('backend/js/jquery.validate.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="{{asset('frontend/js/custom.js')}}?{{get_timestamp()}}"></script>
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('backend/js/sweetalert.min.js')}}"></script>
        
    @yield('scripts')
	<script>
        jQuery(window).scroll(function(){
            if(jQuery(this).scrollTop() > 50){
                jQuery('header').addClass('fixed-header');
            }
            else{
                jQuery('header').removeClass('fixed-header');
            }
        });
        

        jQuery(document).ready(function () { 
            jQuery(".search-bar, .search-icon").click(function (e) {
                if(jQuery("#navbarCollapse").hasClass('show'))
                {
                    jQuery("#navbarCollapse").removeClass('show');
                }
                if(jQuery(".addnavMenu").hasClass('show-menu'))
                {
                    jQuery(".addnavMenu").removeClass('show-menu');
                }
                jQuery(".btn-wrapper input").toggleClass("active");
                jQuery(".btn-wrapper").toggleClass("active");
                e.stopPropagation()
            });
            jQuery("section").not(jQuery(".btn-wrapper, .addnavMenu")).on('click', function (event) {
                
                if(jQuery("#search-box-main").hasClass('active'))
                {
                    jQuery("#search-box-main").removeClass('active');
                }
                if(jQuery(".addnavMenu").hasClass('show-menu'))
                {
                    jQuery(".addnavMenu").removeClass('show-menu');
                }
                if(jQuery("#navbarCollapse").hasClass('show'))
                {
                    jQuery("#navbarCollapse").removeClass('show');
                }
            });
            
            jQuery(".sidebar-menu-toggle").click(function (e) {
                jQuery(".sidebar-menu > ul").toggleClass("show");
            });

        });
        
    </script>
    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5fd21d67f8e56b0018781817&product=inline-share-buttons" async="async"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-50VXPPHWP2"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'G-50VXPPHWP2');
</script>
</body>
</html>

