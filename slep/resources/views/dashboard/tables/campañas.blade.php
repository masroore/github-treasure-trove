@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-coreui.css') }}" rel="stylesheet">

    <!--link href="{{ asset('css/dev/selectdt.css') }}" rel="stylesheet"-->
    <link href="{{ asset('tags.css') }}" rel="stylesheet">
@endsection

@section('content')
  <!-- Icons-->
  <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
  <link href="{{ asset('css/brand.min.css') }}" rel="stylesheet">
  {{ csrf_field() }}  
  <div class="container" style="display:none">
  <script type="text/javascript">
      const data = @json($data);
      const data_busquedas = [];
      const busquedas = @json($busquedas);
  </script>
  <div class="row justify-content-around" style="background:#20202a;">
      <div class="card col-md-12" style="background:transparent;border-color: transparent;">
      <div class="card-header text-center"><strong>Campañas</strong></div>
      <div class="card-body" style="background-color: #23242d;">
        <form action="/tables/campañas_def" method="POST" role="form">
          <div class="row justify-content-around" style="margin:10px">
            <div class="col-md-12">
              <input type="search" class="form-control form-control-sm" placeholder="Ingrese el nombre de la nueva campaña" name="nombreCampaña" id="nombreCampaña" required>
            </div>
            <div class="col-md-12">
              <br>
              <center><button id="cc" class="btn btn-block btn-primary" type="submit">Crear Campaña</button></center>
            </div>
          </div>
        </form>
        <br>
      </div>
    </div>
    <!--RESULTADOS-->
    <div class="card col-md-12" style="background:transparent;border-color: transparent;">
      <div class="card-body" style="background-color: #23242d;">
        <table class="table table-responsive-sm table-striped table-hover table-outline mb-0 nowrap" style="width:100%" id="tablaCampañas"></table><br>
      </div>
    </div>
  </div>
</div>

<!-- add Modal -->
<div class="modal fade" id="addModal" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    
    <div class="modal-content" style="background-color: #21222c;">
      <div class="modal-header" style="border-color: #21222c;">
        <h5 class="modal-title" id="addModalLabel">Agregar Búsquedas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if(!empty($busquedas))
        <select id="select2-add" name="busquedas_select[]" class="form-control form-control-sm" required>
        <option selected disabled>Seleccionar una busqueda...</option>
        <!--select id="busquedas_select" name="busquedas_select[]" multiple required-->
          @foreach($busquedas->reverse() as $llave => $valor)
            <option value="{{ $valor['id'] }}"> {{ $valor['nombre_busqueda'] }} : {{ $valor['palabra_busqueda'] }}</option>
          @endforeach
        </select>
        @else
          <input class="form-control form-control-sm" type="text" name="busquedas" id="busquedas" placeholder="No existen busquedas">
        @endif
      </div>
      <div class="modal-footer" style="border-color: #21222c;">
        <button id="closeAddModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="addSearch()">Agregar</button>
      </div>
    </div>
  </div>
</div>
<!-- delete Modal -->
<div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: #21222c;">
      <div class="modal-header" style="border-color: #21222c;">
        <h5 class="modal-title" id="deleteModalLabel">Quitar Búsquedas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <select id="select2-del" name="d_busquedas_select[]" class="form-control form-control-sm" required>
        </select>
        <!--select id="d_busquedas_select" name="d_busquedas_select[]" multiple required>
        </select-->
      </div>
      <div class="modal-footer" style="border-color: #21222c;">
        <button id="closeDeleteModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onclick="deleteSearch()">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<!-- add Tags Modal -->
<div class="modal fade" id="addTagsModal" tabindex="-1" role="dialog" aria-labelledby="addTagsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTagsModalLabel">Agregar Etiquetas</h5><br>
        <h6 class="modal-title" id="addTagsModalSubtitle"></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="row">
            <div class="col-sm-12 col-lg-12"> 
              <input id="tagsOfCampania" name="tagsOfCampania" type="text" value="" data-role="tagsinput"/> 
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="closeTagsModal" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="addTagsCampania()">Agregar</button>
      </div>
    </div>
  </div>
</div>
<!--div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 25%"></div>
</div-->
@endsection

@section('javascript')

    

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
    <!--script src="{{ asset('js/dev/multiple-select.js') }}"></script-->
    <script src="{{ asset('tags.js') }}"></script>

    <script src="{{ asset('js/dev/cargaDinamica.js') }}"></script>
    <script src="{{ asset('js/dev/cargaCampaña.js') }}"></script>

@endsection
