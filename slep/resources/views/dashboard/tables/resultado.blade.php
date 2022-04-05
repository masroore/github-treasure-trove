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
  <div class="container" style="display:none">
  <div class="row justify-content-around" style="background:#20202a;">
      <div class="card col-md-6" style="background:transparent;border-color: transparent;">
      <div class="card-header text-center"><strong>Resultados</strong></div>
        <div class="card-body" style="background-color: #23242d;">
          <form action="/tables/consulta_resultados" method="GET" role="form"> {{ csrf_field() }}
            <div class="form-group-consulta row">

                <script type="text/javascript">
                    const one_search = @json($b);
                </script>
 
              <div class="col-md-6">
                <br><center>Nombre Búsqueda</center><br><input type="text" class="form-control form-control-sm" 
                          name="nombreBusqueda" id="nombreBusqueda" readonly>
              </div>
              <div class="col-md-6">
                <br><center>Palabras Clave</center><br><input type="text" class="form-control form-control-sm" 
                          name="keyWords" id="keyWords" readonly>
              </div>
              

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
          <div class="card" id="fuentesV2" style="background-color:transparent;border-color:transparent">
            <div class="row text-center">
              <div class="col-sm-6 col-lg-3">
                  <div class="card">
                      <div class="card-header bg-twitter content-center">
                          <svg class="c-icon c-icon-3xl text-white my-4">
                          <use xlink:href="../assets/icons/brands/brands-symbol-defs.svg#twitter"></use>
                          </svg>
                          <div class="c-chart-wrapper">
                          <canvas id="social-box-chart-1" height="90"></canvas>
                          </div>
                      </div>
                      <div class="card-body row text-center">
                          <div class="col">
                              <div class="text-value-xl">0</div>
                              <div class="text-uppercase text-muted small">Seguidores</div>
                          </div>
                          <div class="c-vr"></div>
                          <div class="col">
                              <div class="text-value-xl">0</div>
                              <div class="text-uppercase text-muted small">Tweets</div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                  <div class="card">
                      <div class="card-header bg-youtube content-center">
                          <svg class="c-icon c-icon-3xl text-white my-4">
                          <use xlink:href="../assets/icons/brands/brands-symbol-defs.svg#youtube"></use>
                          </svg>
                          <div class="c-chart-wrapper">
                          <canvas id="social-box-chart-1" height="90"></canvas>
                          </div>
                      </div>
                      <div class="card-body row text-center">
                          <div class="col">
                          <div class="text-value-xl">0</div>
                          <div class="text-uppercase text-muted small">Subs</div>
                          </div>
                          <div class="c-vr"></div>
                          <div class="col">
                          <div class="text-value-xl">0</div>
                          <div class="text-uppercase text-muted small">Videos</div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                  <div class="card">
                      <div class="card-header bg-facebook content-center">
                          <svg class="c-icon c-icon-3xl text-white my-4">
                          <use xlink:href="../assets/icons/brands/brands-symbol-defs.svg#facebook-f"></use>
                          </svg>
                          <div class="c-chart-wrapper">
                          <canvas id="social-box-chart-1" height="90"></canvas>
                          </div>
                      </div>
                      <div class="card-body row text-center">
                          <div class="col">
                          <div class="text-value-xl">0</div>
                          <div class="text-uppercase text-muted small">Seguidores</div>
                          </div>
                          <div class="c-vr"></div>
                          <div class="col">
                          <div class="text-value-xl">0</div>
                          <div class="text-uppercase text-muted small">Posts</div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-lg-3">
                  <div class="card">
                      <div class="card-header bg-instagram content-center">
                          <svg class="c-icon c-icon-3xl text-white my-4">
                          <use xlink:href="../assets/icons/brands/brands-symbol-defs.svg#instagram"></use>
                          </svg>
                          <div class="c-chart-wrapper">
                          <canvas id="social-box-chart-1" height="90"></canvas>
                          </div>
                      </div>
                      <div class="card-body row text-center">
                          <div class="col">
                          <div class="text-value-xl">0</div>
                          <div class="text-uppercase text-muted small">Seguidores</div>
                          </div>
                          <div class="c-vr"></div>
                          <div class="col">
                          <div class="text-value-xl">0</div>
                          <div class="text-uppercase text-muted small">Posts</div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
          <!--div class="card ontop" style="padding-bottom: 1.5em;">
            <div class="card-header" style="background-color: transparent;border-color: transparent;"><center><h6 id="titleMultipleOptions"></h6></center></div>
            <div class="row">
              <div class="btns_options col-md-4 col-sm-6"> 
                <a id="openMultipleTagsModalBtn2" class="btn btn-info" onclick="showMultipleTags()">Etiquetar <i class="cil-tags"></i></a>
                <a id="deleteMultipleRows2" class="btn btn-danger" onclick="checkDeleteMultipleRows()">Eliminar <i class="cil-trash"></i></a>
              </div>
            </div-->
            <table id="tablaPostsV3" class="table table-responsive-sm table-hover table-outline mb-0" Style = "width: 100%"></table>
          </div>    
          
          <table id="resultados_sumatoria" class="table table-responsive-sm table-hover table-outline mb-0" Style = "width: 100%" hidden></table>
        </div>
      </div>
    </div>
  </div>
  <!--Modal Tags-->
  <div class="modal fade" id="tagsModal" tabindex="-1" role="dialog" aria-labelledby="tagsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tagsModalLabel">Agregar etiquetas al resultado</h5><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div id="tagsInModal" class="row" style="margin: 4%;">

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="closeTagsModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <!--Multiple Modal Tags-->
  <div class="modal fade" id="multipleTagsModal" tabindex="-1" role="dialog" aria-labelledby="multipleTagsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="multipleTagsModalLabel">Agregar etiquetas a los resultados</h5><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div id="multipleTagsInModal" class="row" style="margin: 4%;">

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="closeMultipleTagsModal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
    <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
    <script src="{{ asset('tags.js') }}"></script>

    <script src="{{ asset('js/toastr.js') }}"></script>
    <script src="{{ asset('js/toastrs.js') }}"></script>
    
    <script src="{{ asset('js/dev/d3.v4.js') }}"></script>
    <script src="{{ asset('js/dev/d3.layout.cloud.js') }}"></script> 

    <script src="{{ asset('js/dev/cargaDinamica.js') }}"></script>
    <script src="{{ asset('js/dev/one_search.js') }}"></script>
@endsection