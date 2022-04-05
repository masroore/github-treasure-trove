@extends('dashboard.base')
@section('css')
    <link href="{{ asset('css/dev/mdashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dev/informeLector.css') }}" rel="stylesheet">
@endsection
@section('content')
  <script type="text/javascript">
    const original_data = @json($data);
    const informe_busquedas = @json($informe_busquedas);
  </script>
  <div class="container" style="background-color:#181924;">
    <div class="fade-in">
      <div class="card"><div class="card-body text-center font-weight-bold" id="titleInforme"></div></div>
      <div class="card">
        <div class="card-title">
          <div class="text-center font-weight-bold" style="margin-top:10px">
            INFORME LECTOR
          </div>
        </div>
        <div class="section" id="gridContainer">
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="c-chart-wrapper" style="height:300px;margin-top:40px;" id="graph-inside">
              <canvas class="chart" id="graph-inter" height="300"></canvas>
            </div>
          </div>
          <div class="col-lg-6" style="align-self: center">
            <div id="wordscloud"></div>
          </div>
        </div> 
        <div class="row">
          <div class="col-sm-12">    
            <table id="table_informe" class="table table-striped table-bordered" role="grid" style="border-collapse: collapse !important"></table>
          </div>  
        </div>       
      </div>
    </div>
  </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('js/dev/cargaDinamica.js') }}"></script>
    <script src="{{ asset('js/dev/menuDashboard.js') }}"></script>
    <script src="{{ asset('js/dev/informe.js') }}"></script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
@endsection