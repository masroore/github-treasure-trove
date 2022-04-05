@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/dev/mdashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
@endsection

@section('content')
            <script type="text/javascript">
                    const original_data = @json($data);
            </script>

          <div class="container" style="background-color:#181924;display:none;">
            <div class="fade-in">
              <!--Antiguas cartas superiores-->
              <div class="row">
                <div style="display: none">
                  <canvas class="chart" id="card-chart1" height="70"></canvas>
                  <canvas class="chart" id="card-chart2" height="70"></canvas>
                  <canvas class="chart" id="card-chart3" height="70"></canvas>
                  <canvas class="chart" id="card-chart4" height="70"></canvas>
                </div>
              </div>
              <!-- /.row-->
              <div class="card">
                <div class="card-body">
                  <div class="row" id="totalcards">
                  </div>
                </div>
              </div>
              <!-- /.row-->

              <!--Autores y Posteos-->
              <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                          <h4 class="card-title mb-0">Autores y posteos</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body">
                            <!--Datatable-->
                                <div>
                                    <div class="row">
                                        <div class="col-sm-12">         
                                            <table id="table_autores" class="table table-striped table-hover table-bordered responsive" role="grid" style="border-collapse: collapse !important">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="mt-3 col-md-6">
                                        <strong>Comunidad por Interacción por viralización</strong>
                                        <div class="mt-3">
                                            <table id="table_comunidad_x_interaccion_x_viralizacion" class="table table-hover responsive table-bordered"></table>
                                        </div>
                                    </div>
                                    <!--NUBE DE PALABRAS-->
                                    <div class="mt-3 card col-md-6" style="background:transparent;border-color: transparent;">
                                    <strong>Nube de Palabras</strong>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')
    <!--script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.bundle.js"></script>
    <script src="{{ asset('js/coreui-chartjs.js') }}"></script-->
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

    <script src="{{ asset('js/dev/cargaMedios.js') }}"></script>
    <script src="{{ asset('js/dev/menuDashboardMedios.js') }}"></script>
@endsection


