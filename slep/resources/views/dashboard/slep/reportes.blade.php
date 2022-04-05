@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
          <div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-sm-6 col-lg-6 col-sm-12">
                  <div class="card text-white bg-primary">
                    <div class="card-body">
                      <div class="btn-group float-right">
                        <button class="btn btn-transparent p-0" type="button" aria-haspopup="true" aria-expanded="false">
                          <svg class="c-icon">
                            <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-menu"></use>
                          </svg>
                        </button>
                        <!--div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Acción</a><a class="dropdown-item" href="#">{{ __('dashboard.another_action') }}</a><a class="dropdown-item" href="#">{{ __('dashboard.something_else_here') }}</a></div-->
                      </div>
                      <div class="text-value-lg" id="totalMes">-</div>
                      <div>Monto total gastado en el mes de Noviembre</div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-6 col-sm-12">
                  <div class="card text-white bg-warning">
                    <div class="card-body">
                      <button class="btn btn-transparent p-0 float-right" type="button">
                        <svg class="c-icon">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-menu"></use>
                        </svg>
                      </button>
                      <div class="text-value-lg" id="totalAño">-</div>
                      <div>Monto total gastado en el año 2021</div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-5">
                      <h4 class="card-title mb-0">Total por Establecimiento</h4>
                      <div class="small text-muted">2021</div>
                    </div>
                    <!-- /.col-->
                  </div>
                  <!-- /.row-->
                  <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                    <canvas class="chart" id="reporte-chart" height="300"></canvas>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">Gastos por Establecimiento</div>
                    <div class="card-body">
                      <table id="reporte_dt" class="table table-responsive-sm table-hover table-outline mb-0">
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
              </div>
            </div>
          </div>

@endsection

@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.js') }}"></script>
    
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/slep/reportes.js') }}"></script>
@endsection
