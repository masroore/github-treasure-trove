<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{!! csrf_token() !!}">
  <meta name="baseurl" content="{{url('')}}">
  <title>Unlocked</title>

  <!-- Bootstrap core CSS -->

  <link href="{{asset('frontend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

  <!-- Custom styles for this template -->
  <!-- <link href="{{asset('frontend/css/small-business.css')}}" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

  <!-- new css -->
  <!-- CSS Files -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('assets/css/fontawesome/css/all.css')}}" />
  <link href="{{asset('assets/css/slick.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/slick-theme.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/aos.css')}}" rel="stylesheet">
  <!-- Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet">
  <!-- new css end -->

</head>

<body>

  <!--------------HEADER SECTION START HERE------------->
  @include('partials.header')
  <!--------------HEADER SECTION ENDS HERE-------------->

  @yield('content')

  <!-------------FOOTER SECTION START HERE---------------->
  @include('partials.footer')
  <!-------------FOOTER SECTION ENDS HERE---------------->

  <!-- Bootstrap core JavaScript -->
  @show
  <script>
    var baseurl = $('meta[name="baseurl"]').prop('content');
    var token = $('meta[name="csrf-token"]').prop('content');
  </script>

  <!-- <script src="{{asset('frontend/vendor/jquery/jquery.min.js')}}">
  </script>
  <script src="{{asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('backend/js/jquery.validate.min.js')}}"></script>
  <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script> -->

  <!-- // new js start -->
  <!-- JS Files -->
  <script src="{{asset('assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/js/slick.js')}}"></script>
  <script src="{{asset('assets/js/aos.js')}}"></script>
  <script src="{{asset('assets/js/main.js')}}"></script>


  <script>
    AOS.init({
      duration: 1200,
    });
  </script>
  <!-- // new js end -->

  @yield('scripts')
</body>

</html>