<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>{{ config('app.name') }}</title>
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

  <script defer src="{{asset('js/app.js')}}"></script>
  @livewireStyles

</head>
<body class="c-app c-no-layout-transition">
@include('parts.sidebar')
<div class="c-wrapper">
@include('parts.header')
<div class="c-body">
  <main class="c-main">
    <div class="container-fluid">
      <div class="animate__animated animate__fadeIn">
        @yield('container')
       </div>
        </div>
     </main>
</div>
 @include('parts.footer')
  </div>
 @livewireScripts 
</body>
</html>