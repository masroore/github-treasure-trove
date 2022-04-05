@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="{{ asset('css/dev/selectdt.css') }}" rel="stylesheet">
    <link href="{{ asset('tags.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Icons-->
<link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
<link href="{{ asset('css/brand.min.css') }}" rel="stylesheet">
{{ csrf_field() }}  
  <div class="container">
 

    <div class="row justify-content-around" style="margin:10px">
    <div class="card col-md-12 ontop" style="padding-bottom: 1.5em;">
            <div class="card-header" style="background-color: transparent;border-color: transparent;"><center><h5>Registro de Búsquedas</h5></center></div>
            <div class="row">
              <div class="col-md-4 col-sm-6"> 
                <a class="btn btn-info" onclick="load_data()">Actualizar <i class="cil-sync"></i></a>
              </div>
            </div>
          </div>
      <div class="card col-md-12">
        
        <div class="card-body">
          <table id="tablaRegistros" class="table table-responsive-sm table-hover table-outline mb-0" Style = "width: 100%"></table>
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

    <script src="{{ asset('js/dev/loading_script.js') }}"></script>
    <script src="{{ asset('js/dev/registros.js') }}"></script>
    
    <script src="{{ asset('js/dev/d3.v4.js') }}"></script>
    <script src="{{ asset('js/dev/d3.layout.cloud.js') }}"></script> 
@endsection