@extends('dashboard.base')

@section('css')
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">Códigos de Establecimientos</div>
            <div class="card-body">
              <table id="mantenedor_dt" class="table table-responsive-sm table-hover table-outline mb-0">
              </table>
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- /.row-->
    </div>
  </div>

  <!--Edit-->
  <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editItemModalLabel">Editar Elemento</h5><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" style="background-color: #23242d00;border-color: #18192400;">

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;">N°</i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_n" id="edit_n" disabled>
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;"><small>RBD</small></i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_rbd" id="edit_rbd" required>
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;"><small>DV</small></i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_dv" id="edit_dv" required>
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;" class="cil-building"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_est" id="edit_est" required>
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;" class="cil-map"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_com" id="edit_com" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="closeeditItemModal" type="button" class="btn btn-danger" data-dismiss="modal" onclick="clearFields()">Cancelar</button>
          <button id="successeditItemModal" type="button" class="btn btn-primary" data-dismiss="modal" onclick="edit()">Editar</button>
        </div>
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
    <script src="{{ asset('js/slep/mantenedores.js') }}"></script>
@endsection
