<html class="informe_bck" style="background: white;">
  <title>Birs</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="description" content="Ingeniería Periodística - Escucha inteligente de redes sociales">
  <meta name="author" content="Sergio A.Slacker">
  <meta name="keyword" content="RRSS, Buscador, Inteligente, Redes, Sociales, Birs">
  <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/favicon/favicon.png') }}">
  <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
  <link href="{{ asset('css/brand.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dev/devLoading.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/flag.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dev/mdashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
  <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dev/informeLector.css') }}" rel="stylesheet">

  <script type="text/javascript">
    const original_data = @json($data);
    const informe_busquedas = @json($informe_busquedas);
  </script>
<body class="informe_bck">
<div class="container" id="container-informe-lector" style="display:none; background-color:white;">
      <!--Titulo, Logo, Detalles del informe-->
      <div class="card" style="margin-top: 2%; border:transparent;">
        <img src="{{ url('/assets/brand/black_birs.png') }}" alt="Logo Birs" width="80" height="80" style="align-self: center;">
        <div class="card-body text-center font-weight-bold" id="titleInforme" style="padding-top:0.12rem"></div>
        <div class="text-center font-weight-bold" style="font-size: large;">Informe Lector</div>
      </div>
      <!--Grid 3x3-->
      <div class="card">
        <div class="section" id="gridContainer"></div>
      </div>
      <!--Grafico a la izquierda ; Wordscloud a la derecha-->
      <div class="row justify-content-around" style="margin-right: 0px;margin-left: 0;" id="doublecard">
        <div class="card col-md-6" style="background:transparent;border-color: transparent;">
          <div class="c-chart-wrapper" style="height:300px;margin-top:40px;" id="graph-inside">
            <canvas class="chart" id="graph-inter" height="300"></canvas>
          </div>
        </div>
        <div class="card col-md-6" style="background:transparent;border-color: transparent;">
          <div class="c-chart-wrapper card-body justify-content-center align-items-center" id="wordscloud" style="background-color: #ffffff;min-height: 310px !important;align-items:center !important;;align-content:center !important">
            <div id="loadingWordcloud" class="sk-circle" hidden>
              <div class="sk-circle1 sk-child"></div>
              <div class="sk-circle2 sk-child"></div>
              <div class="sk-circle3 sk-child"></div>
              <div class="sk-circle4 sk-child"></div>
              <div class="sk-circle5 sk-child"></div>
              <div class="sk-circle6 sk-child"></div>
              <div class="sk-circle7 sk-child"></div>
              <div class="sk-circle8 sk-child"></div>
              <div class="sk-circle9 sk-child"></div>
              <div class="sk-circle10 sk-child"></div>
              <div class="sk-circle11 sk-child"></div>
              <div class="sk-circle12 sk-child"></div>
            </div>
          </div>  
        </div>  
      </div> 

      <div class="card" style="border-color: transparent;">    
        <div class="card-body">
          <table id="table_informe" class="table table-responsive-sm table-hover table-outline mb-0" role="grid" style="border-collapse: collapse !important"></table>
        </div>
      </div>  

  </div>
</body>
  

  <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
  <script src="{{ asset('js/coreui-utils.js') }}"></script>
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script src="{{ asset('js/tooltips.js') }}"></script>
  <script src="{{ asset('js/dev/wordsCloud.js') }}"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/coreui-chartjs.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>

  <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('js/datatables.js') }}"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
  <script src="{{ asset('js/dev/d3.v4.js') }}"></script>
  <script src="{{ asset('js/dev/d3.layout.cloud.js') }}"></script> 
  <script src="{{ asset('js/dev/multiple-select.js') }}"></script>
  <script src="{{ asset('js/dev/cargaDinamica.js') }}"></script>
  <script src="{{ asset('js/dev/wordsCloud.js') }}"></script>
  <script src="{{ asset('js/dev/menuDashboard.js') }}"></script>
  <script src="{{ asset('js/dev/informe.js') }}"></script>
</html>