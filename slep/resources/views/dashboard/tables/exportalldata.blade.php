@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/dev/selectdt.css') }}" rel="stylesheet">
    <link href="{{ asset('tags.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-coreui.css') }}" rel="stylesheet">

@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Icons-->
<link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
<link href="{{ asset('css/brand.min.css') }}" rel="stylesheet">
  <div class="container">
    <div class="row justify-content-around" style="background:#20202a;">
      <!--TODOS LOS RESULTADOS-->
      <div class="card col-md-12" style="background:transparent;border-color: transparent;">
      <div class="card-header" style="background-color: transparent;border-color: transparent;">
        <h6><center>Exportar Base de Datos</center></h6>
      </div>
        <div class="card-body" style="background-color: #23242d;">
          <div class="row">
            <div class="col-8 col-lg-10 col-md-9"> 
              <fieldset class="form-group" style="display: flex;">
                <select name="select_campania_reporte" id="select2-1" class="form-control form-control-sm">
                @if(!empty($campanias_data))
                  <option selected disabled>Seleccionar una campaña...</option>
                  <option value="-1">Todas las campañas</option>
                  @foreach($campanias_data->reverse() as $llave => $valor)
                    <option value="{{ $valor['id'] }}">{{ $valor['nombre_campania'] }}</option>
                  @endforeach
                @else
                  <option selected disabled>No existe ninguna campaña</option>
                @endif 
                </select>
              </fieldset>
            </div>
            <div class="col-4 col-lg-2 col-md-3">
              <a id="reload_reportes" class="btn btn-danger float-right-md" onclick="export_database()" >Actualizar <i class="cil-sync"></i></a>
            </div>
          </div>
          <br>
          <table id="reporte_campania" class="table table-responsive table-hover table-outline mb-0" Style = "width: 100%"></table>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('javascript')
    <script type="text/javascript">
      const env_url_base = "{{ env('APP_URL') }}";
    </script>
    <script defer src="{{ asset('js/fa/fontawesome-free/js/brands.js') }}"></script>
    <script defer src="{{ asset('js/fa/fontawesome-free/js/solid.js') }}"></script>
    <script defer src="{{ asset('js/fa/fontawesome-free/js/fontawesome.js') }}"></script>

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
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    <script src="{{ asset('tags.js') }}"></script>

    <script src="{{ asset('js/toastr.js') }}"></script>
    <script src="{{ asset('js/toastrs.js') }}"></script>

    <script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/advanced-forms.js') }}"></script>

    <script src="{{ asset('js/dev/d3.v4.js') }}"></script>
    <script src="{{ asset('js/dev/d3.layout.cloud.js') }}"></script> 

    <script src="{{ asset('js/dev/loading_script.js') }}"></script>
    <script src="{{ asset('js/dev/exportAll.js') }}"></script>
@endsection