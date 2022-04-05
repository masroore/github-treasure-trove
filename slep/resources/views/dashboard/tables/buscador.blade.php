@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">

    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-coreui.css') }}" rel="stylesheet">

    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="container" style="display:none">
      <div class="row justify-content-around">
        <div class="card col-md-6">
          <div class="card-header text-center"><strong>Realizar una búsqueda</strong></div>
          <form action="/tables/buscador" method="POST" role="form">
          <div class="card-body">
            
              <div id="tabla_filter" class="row">

                <div class="item1 col-md-12">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="cil-short-text"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese un nombre para la búsqueda" name="nombreBusqueda" id="nombreBusqueda" required>
                  </div>
                </div>
                
                <br><br><br><br>

                <div class="item2 col-md-12">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="cil-search"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Ingrese el termino que desea buscar" name="palabraClave" id="palabraClave" required><br>
                  </div>
                </div>

                <br><br><br><br>

                <div class="itemCampaña col-md-12 ">
                  @if(!empty($campañas))
                  <fieldset class="form-group" style="display: flex;">
                  <select id="select2-1" name="campañas_select[]" class="form-control form-control-sm" required>
                  <!--select id="campañas_select" name="campañas_select[]" multiple required-->
                    <option selected disabled>Seleccionar una campaña...</option>
                    @foreach($campañas->reverse() as $llave => $valor)
                      <option value="{{ $valor['id'] }}"> {{ $valor['nombre_campania'] }}</option>
                    @endforeach
                  </select>
                  @else
                    <input class="form-control form-control-sm" type="text" name="campañas" id="campañas" placeholder="No existen campañas">
                  @endif
                  <br>
                </div>

                

                <div class="item3 col-md-12">
                  <center>
                    <label>Rango de la búsqueda</label>
                    <div class="row">
                      <div class="col"><input type="date" class="form-control form-control-sm" name="fecha1" id="fecha1" required></div>
                      <div class="col"><input type="date" class="form-control form-control-sm" name="fecha2" id="fecha2" required></div>
                    </div>
                  </center>  
                </div>   
            
              </div>
          </div>
          <div class="card-footer text-center">
            <button id="buscarButton" class="btn btn-block btn-primary" type="submit" disabled>
              <span id="btn_srch_span" style="min-width: 100%;min-height: 100%;display: inline-block;">Buscar</span>
            </button>
          </div>
          </form>
    </div>

@endsection

@section('javascript')
    <script type="text/javascript">
      const env_url_base = "{{ env('APP_URL') }}";
    </script>
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
    <script src="{{ asset('js/dev/loading_script.js') }}"></script>
    <script src="{{ asset('js/dev/busquedaDefault.js') }}"></script>
    <script src="{{ asset('js/dev/multiple-select.js') }}"></script>

    <script src="{{ asset('js/toastr.js') }}"></script>
    <script src="{{ asset('js/toastrs.js') }}"></script>
    
    <!--script src="{{ asset('js/dev/cargaDinamica.js') }}"></script-->
@endsection



<!--
@section('content')
        <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                <div class="card-header"> <h2><center>Realizar Búsqueda</center></h2></div>
                <div class="card-body">

                  <form action="/tables/buscador" method="POST" role="form">
                  {{ csrf_field() }}
                  <div id="fb-root"></div>

                    <div id="tabla_filter" class="form-group">
                    
                        <div class="item1">
                          <center><h5>Nombre Búsqueda</h5><br>
                            <input type="search" class="form-control form-control-sm" placeholder="Ingrese el nombre de la nueva búsqueda" 
                                   name="nombreBusqueda" id="nombreBuscqueda">
                          </center>
                        </div><br>

                        <div id="tabla_filter" class="item2">
                          <center><h5>Palabras Clave</h5><br>
                              <input type="search" class="form-control form-control-sm" placeholder="Ingrese el termino que desea buscar" 
                                     name="palabraClave" id="palabraClave">

                              <br></center>
                        </div><br>

                        <div class="item3">
                          <center><h5>Extensión de la Búsqueda</h5><br>
                          <div class="row">
                            <div class="col"><input type="date" class="form-control form-control-sm" name="fecha1" id="fecha1"></div>
                            <div class="col"><input type="date" class="form-control form-control-sm" name="fecha2" id="fecha2"></div>
                          </div>
                          </center>
                        </div>
                      
                        <div class="itemCampaña">
                          <center><h5>Campaña</h5><br>
                            <input type="search" class="form-control form-control-sm" placeholder="Ingrese el nombre de la campaña" 
                                   name="nombreCampaña" id="nombreCampaña">
                          </center>
                        </div>
                        <div class="item6">
                          <button id="buscarButton" class="btn btn-block btn-primary" type="submit" click=>Buscar</button>
                        </div>
                  </form>
                  
              </div>
            </div>
          </div>

@endsection
-->