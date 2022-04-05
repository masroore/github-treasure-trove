@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/dev/selectdt.css') }}" rel="stylesheet">
    <link href="{{ asset('tags.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
    
@endsection

@section('content')
<!-- Icons-->
<link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
<link href="{{ asset('css/brand.min.css') }}" rel="stylesheet">
{{ csrf_field() }}  
<div class="container" style="display:none">
<script type="text/javascript">
    const data = [];
    const data_busquedas = @json($busquedas);
    const id = @json($id);
</script>
<div class="row justify-content-around" style="background:#20202a;">
  <div class="card col-md-6" style="background:transparent;border-color: transparent;">
    <div class="card-header text-center"><strong>Campaña</strong></div>
        <div class="card-body" style="background-color: #23242d;">
          <form action="/tables/consulta_resultados" method="GET" role="form"> {{ csrf_field() }}
            <div class="form-group-consulta row">
            <div class="col-md-12">
                <center>Nombre Campaña</center><br><input type="text" class="form-control form-control-sm" 
                          name="nombreCampaña" id="nombreCampaña" readonly>
              </div>
              <div class="col-md-6">
                <br><center>Fecha Campaña</center><br><input type="date" class="form-control form-control-sm" 
                          name="fechaCampaña" id="fechaCampaña" readonly>
              </div>
              <div class="col-md-6">
                <br><center>Hora Campaña</center><br><input type="datetime" class="form-control form-control-sm" 
                          name="horaCampaña" id="horaCampaña" readonly>
              </div>
              <div class="col-md-6">
                <br><center>Total Busquedas</center><br><input type="text" class="form-control form-control-sm" 
                          name="totalBusquedas" id="totalBusquedas" readonly>
              </div>
              <div class="col-md-6">
                <br><center>Total Resultados</center><br><input type="text" class="form-control form-control-sm" 
                          name="totalPosts" id="totalPosts" readonly>
              </div>
              <div class="col-md-12">
                <br><center>Rango de la campaña</center>
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
        <div class="card" id="fuentesV2" style="background-color:transparent;border-color:transparent"></div>
        
        <div class="card ontop" style="/*top: 3.9em !important;*/padding-bottom: 1.5em;">
          <div class="card-header" style="background-color: transparent;border-color: transparent;"><center><h6 id="titleTagsDiv"></h6></center></div>
            <div class="row">
              <div class="col-8 col-lg-10 col-md-9"> 
                <input id="tagsOfCampaignV2" name="tagsOfCampaignV2" type="text" value="" data-role="tagsinput"/> 
              </div>
              <div class="col-4 col-lg-2 col-md-3">
                <a id="addTagsToCamp" class="btn btn-info float-right-md" onclick="addTagsToCamp()" >Aceptar <i class="cil-plus"></i></a>
              </div>
            </div>
        </div>
        <table class="table table-responsive-sm table-hover table-outline mb-0" Style="width:100%" id="tablaBusquedas"></table><br>
        <table class="table table-responsive-sm table-hover table-outline mb-0" Style = "width: 100%" id="tablaResultados" ></table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')

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
    <script src="{{ asset('tags.js') }}"></script>

    <script src="{{ asset('js/dev/multiple-select.js') }}"></script>

    <script src="{{ asset('js/toastr.js') }}"></script>
    <script src="{{ asset('js/toastrs.js') }}"></script>

    <script src="{{ asset('js/dev/d3.v4.js') }}"></script>
    <script src="{{ asset('js/dev/d3.layout.cloud.js') }}"></script> 

    <script src="{{ asset('js/dev/cargaDinamica.js') }}"></script>
    <script src="{{ asset('js/dev/cargaCampaña.js') }}"></script>
@endsection
