@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-coreui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Icons-->
<link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
<link href="{{ asset('css/brand.min.css') }}" rel="stylesheet">
{{ csrf_field() }}  
  <div class="container" style="display:none">
    
    <div class="row justify-content-around" style="background:#20202a;">
      <div class="card col-md-6" style="background:transparent;border-color: transparent;">
        <div class="card-header text-center"><strong>Consulta Medios</strong></div>
        <div class="card-body" style="background-color: #23242d;">
          <form action="/tables/consulta_resultados" method="GET" role="form"> {{ csrf_field() }}
            <div class="row">
              <div class="col-md-12">
                <br><center>
                <label>Identificador de Búsqueda</label>
                <fieldset class="form-group" style="display: flex;">
                  <select name="selectBusquedaMedios" id="select2-1" class="form-control select2-single" >
                    @if(!empty($data))
                      <option selected disabled>Seleccionar...</option>
                      @foreach($data->reverse() as $llave => $valor)
                      <option value="{{ $valor['id'] }}">{{ $valor['nombre_busqueda'] }}: {{ $valor['palabra_busqueda'] }}</option>
                      @endforeach
                    @else
                      <option selected disabled>No existe ninguna busqueda</option>
                    @endif 
                  </select>
                 </fieldset>
                </center>
              </div><br>
              <div class="col-md-6">
                <br><center>Fecha Búsqueda</center><br><input type="date" class="form-control form-control-sm" 
                          name="fechaBusqueda" id="fechaBusqueda" readonly>
              </div>
              <div class="col-md-6">
                <br><center>Hora Búsqueda</center><br><input type="datetime" class="form-control form-control-sm" 
                          name="horaBusqueda" id="horaBusqueda" readonly>
              </div>
              <div class="col-md-12">
                <br><center>Total Posteos</center><br><input type="text" class="form-control form-control-sm" 
                          name="totalPosts" id="totalPosts" readonly>
              </div>
              <div class="col-md-12">
                <br><center>Rango de la búsqueda</center>
                <div class="row">
                  <div class="col">
                    <br><input type="date" class="form-control form-control-sm" 
                    name="fechaRangoDesde" id="fechaRangoDesde" readonly>
                  </div>
                  <div class="col">
                    <br><input type="date" class="form-control form-control-sm" 
                    name="fechaRangoHasta" id="fechaRangoHasta" readonly>
                  </div>  
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!--NUBE DE PALABRAS-->
      <div class="card col-md-6" style="background:transparent;border-color: transparent;">
      <div class="card-header text-center"><strong>Nube de Palabras</strong></div>
      <div class="card-body justify-content-center align-items-center" id="wordscloud" style="background-color: #23242d;min-height: 310px !important;align-items:center;;align-content:center">
          <!--center><div id="wordscloud" style="background-color: #23242d;min-height: 30vh !important;"></div><!--/center-->
          <div id="loadingWordcloud" class="sk-circle align-middle" hidden>
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
      <!--RESULTADOS-->
      <div class="card col-md-12" style="background:transparent;border-color: transparent;">
        <div class="card-body" style="background-color: #23242d;">
          <div class="card" id="fuentesMedios" style="background-color:transparent;border-color:transparent"></div>
          <table id="tablaMedios" class="table table-responsive-sm table-hover table-outline mb-0" Style = "width: 100%"></table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
    <script type="text/javascript">
      const av_medios = @json($medios);
    </script>
    <script defer src="{{ asset('js/fa/fontawesome-free/js/brands.js') }}"></script>
    <script defer src="{{ asset('js/fa/fontawesome-free/js/solid.js') }}"></script>
    <script defer src="{{ asset('js/fa/fontawesome-free/js/fontawesome.js') }}"></script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/advanced-forms.js') }}"></script>

    <script src="{{ asset('js/dev/multiple-select.js') }}"></script>

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

    <script src="{{ asset('js/dev/cargaMedios.js') }}"></script>
 
@endsection