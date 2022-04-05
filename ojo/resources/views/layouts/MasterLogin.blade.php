<html>
<head>
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>{{ config('app.name') }}</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  {!! htmlScriptTagJsApi(['lang' => 'es']) !!}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <style>
    .c-app {
      margin: 0;
      padding: 0;
      background-color:#A4ADC5;
    }
    #tsparticles {
    /*   background; */
    width: 100%;
    height: 100%;
    position: absolute;
}
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tsparticles/1.18.11/tsparticles.min.js"> </script>
 </head> 
<body class="c-app flex-row align-items-center">
<div id="tsparticles"></div>
<div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4 animate__animated animate__flipInX">
        <img src="/images/logo.png" class="img-fluid">
              <div class="card text-dark bg-secondary my-3 shadow">
                    <div class="card-body">
                      @yield('content')
                    </div>
                  </div>
                </div>
              </div>
            </div>  
<script  src="{{asset('js/app.js')}}"></script>
<script>
tsParticles.load("tsparticles", {
            particles: {
                number: {
                    value: 250
                },
                color: {
                    value: "#CED6EE",
                    animation: {
                        enable: true,
                        speed: 10,
                        sync: false
                    }
                },
                shape: {
                    type: "circle",
                },
                collisions: {
                    enable: true,
                },
                size: {
                    value: 6,
                    random: true,
                    animation: {
                    enable: true,
                    speed: 30,
                    minimumValue: 0.1,
                    sync: false
                },
                move: {
                    enable: true,
                },
                }
            } 
          } );
</script>
</body>
</html>