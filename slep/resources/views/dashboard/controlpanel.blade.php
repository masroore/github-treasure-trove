@extends('dashboard.base')
@section('css')
  <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dev/multiple-select.css') }}" rel="stylesheet">
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/select2-coreui.css') }}" rel="stylesheet">
  <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">

  <link href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css" rel="stylesheet">
  <link href="{{ asset('css/dev/selectdt.css') }}" rel="stylesheet">
@endsection

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="container fade-in">
    <div class="row justify-content-around" style="background:transparent;">
      <div class="card col-12" style="background:transparent;">
        <div class="card-header text-center"><strong>Panel de Control: <?php echo $title;?></strong></div>
        <div class="card-body" style="background-color: #23242d;">
          <table id="cpaneltable" class="table table-responsive-sm table-hover table-outline mb-0" style="width: 100%"></table>
        </div>
      </div>
    </div>
  </div>
  <!--MODAL USUARIO-->
  <div class="modal fade-in" id="userDetailsModal" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userDetailsModalLabel">Detalles de Usuario</h5><br>
          <h6 class="modal-title" id="userDetailsModalSubtitle"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" id="user_details" style="background-color: #191925;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
  <!--MODAL BUSQUEDA-->
  <div class="modal fade-in" id="busquedaDetailsModal" tabindex="-1" role="dialog" aria-labelledby="busquedaDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="busquedaDetailsModalLabel">Detalles de la Búsqueda</h5><br>
          <h6 class="modal-title" id="busquedaDetailsModalSubtitle"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" id="busqueda_details" style="background-color: #191925;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
   <!--MODAL CAMPAÑA-->
  <div class="modal fade-in" id="campañaDetailsModal" tabindex="-1" role="dialog" aria-labelledby="campañaDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="campañaDetailsModalLabel">Detalles de Campaña</h5><br>
          <h6 class="modal-title" id="campañaDetailsModalSubtitle"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" id="campaña_details" style="background-color: #191925;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <!--Edit Rol Modal-->
  <div class="modal fade" id="editRolModal" tabindex="-1" role="dialog" aria-labelledby="editRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editRolModalLabel">Editar Usuario</h5><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" style="background-color: #23242d00;border-color: #18192400;">

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;">ID</i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_id" id="edit_id" disabled style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-user" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_name" id="edit_name" required style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;">@</i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_email" id="edit_email" required style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-sitemap" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <select class="custom-select" id="edit_rol" style="background-color: #424249;">
                <option selected disabled>Seleccionar...</option>
                <option value="Administrador">Administrador</option>
                <option value="Usuario">Usuario</option>
                <option value="Invitado">Invitado</option>
                <option value="Gestor">Gestor</option>
              </select>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button id="closeEditRolModal" type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearFields()">Cancelar</button>
          <button id="successEditRolModal" type="button" class="btn btn-primary" data-dismiss="modal" onclick="editSelectedRow_newData()">Editar</button>
        </div>
      </div>
    </div>
  </div>
  <!--New Rol Modal-->
  <div class="modal fade" id="newRolModal" tabindex="-1" role="dialog" aria-labelledby="newRolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newRolModalLabel">Nuevo Usuario</h5><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" style="background-color: #23242d00;border-color: #18192400;">

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-user" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Ingrese un nombre para el usuario" name="new_name" id="new_name" required style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;">@</i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Ingrese una direccion e-mail para el usuario" name="new_email" id="new_email" required style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-lock-locked" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Ingrese la clave del usuario" name="new_pass" id="new_pass" required style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-building" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Ingrese la empresa del usuario" name="new_ent" id="new_ent" required style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-sitemap" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <select class="custom-select" id="new_rol" style="background-color: #424249;">
                <option selected disabled>Seleccionar un rol...</option>
                <option value="Administrador">Administrador</option>
                <option value="Usuario">Usuario</option>
                <option value="Invitado">Invitado</option>
                <option value="Gestor">Gestor</option>
              </select>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button id="closeNewRolModal" type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearFields()">Cancelar</button>
          <button id="successNewRolModal" type="button" class="btn btn-primary" data-dismiss="modal" onclick="newUser()">Agregar</button>
        </div>
      </div>
    </div>
  </div>

  <!--Edit Medio Modal-->
  <div class="modal fade" id="editMedioModal" tabindex="-1" role="dialog" aria-labelledby="editMedioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editMedioModalLabel">Editar Medio Social</h5><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" style="background-color: #23242d00;border-color: #18192400;">

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i style="min-width: 1em;max-width: 1em;">ID</i>
                </span>
              </div>
              <input type="text" class="form-control" name="edit_id_Medios" id="edit_id_Medios" disabled style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-user" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Ingrese el nombre del medio" name="edit_nombre_Medios" id="edit_nombre_Medios" required style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-sitemap" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <select class="custom-select" id="edit_tipo_Medios" style="background-color: #424249;">
                <option selected disabled>Seleccionar tipo del medio...</option>
                <option value="Escrito">Escrito</option>
                <option value="Digital">Digital</option>
              </select>
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-sitemap" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <select class="custom-select" id="edit_alcance_Medios" style="background-color: #424249;">
                <option selected disabled>Seleccionar alcance del medio...</option>
                <option value="Nacional">Nacional</option>
                <option value="Regional">Regional</option>
                <option value="Ciudades">Ciudades</option>
              </select>
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-building" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Ingrese la URL del medio" name="edit_url_Medios" id="edit_url_Medios" required style="border: none;">
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-image-plus" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="edit_image_upload" accept="image/png">
                <label class="custom-file-label" for="edit_image_upload">Seleccionar un archivo...</label>
              </div>
              <div class="input-group-append">
                <button class="btn btn-light" id="edit_image_upload_clear" type="button"><i class="cil-trash" style="color: var(--danger); min-width: 1em;max-width: 1em;"></i></button>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button id="closeEditMedioModal" type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearFields_Medios()">Cancelar</button>
          <button id="successEditMedioModal" type="button" class="btn btn-primary" disabled><span id="new_medio_add_btn" onclick="editSelectedRow_newData_Medios()" style="min-width: 100%;min-height: 100%;display: inline-block;">Editar</span></button>
        </div>
      </div>
    </div>
  </div>
  <!--New Medio Modal-->
  <div class="modal fade" id="newMedioModal" tabindex="-1" role="dialog" aria-labelledby="newMedioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newMedioModalLabel">Nuevo Medio Social</h5><br>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card" style="background-color: #23242d00;border-color: #18192400;">

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-user" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Ingrese el nombre del medio" name="new_nombre_Medios" id="new_nombre_Medios" required style="border: none;">
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-sitemap" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <select class="custom-select" id="new_tipo_Medios" style="background-color: #424249;">
                <option selected disabled>Seleccionar tipo del medio...</option>
                <option value="Escrito">Escrito</option>
                <option value="Digital">Digital</option>
              </select>
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-sitemap" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <select class="custom-select" id="new_alcance_Medios" style="background-color: #424249;">
                <option selected disabled>Seleccionar alcance del medio...</option>
                <option value="Nacional">Nacional</option>
                <option value="Regional">Regional</option>
                <option value="Ciudades">Ciudades</option>
              </select>
            </div>

            <div class="input-group mb-1">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-building" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Ingrese la URL del medio" name="new_url_Medios" id="new_url_Medios" required style="border: none;">
            </div>

            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="cil-image-plus" style="min-width: 1em;max-width: 1em;"></i>
                </span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="new_image_upload" accept="image/png">
                <label class="custom-file-label" for="inew_image_upload">Seleccionar un archivo...</label>
              </div>
              <div class="input-group-append">
                <button class="btn btn-light" id="new_image_upload_clear" type="button"><i class="cil-trash" style="color: var(--danger); min-width: 1em;max-width: 1em;"></i></button>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button id="closeNewMedioModal" type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearFields_Medios()">Cancelar</button>
          <button id="successNewMedioModal" type="button" class="btn btn-primary" disabled><span id="new_medio_add_btn" onclick="newMedio()" style="min-width: 100%;min-height: 100%;display: inline-block;">Agregar</span></button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('javascript')
  <script type="text/javascript">
    const env_url_base = "{{ env('APP_URL') }}";
    const data = @json($data);
    const title = @json($title);
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

  <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
  
  <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>

  <script src="{{ asset('js/dev/multiple-select.js') }}"></script>
  <script src="{{ asset('js/toastr.js') }}"></script>
  <script src="{{ asset('js/toastrs.js') }}"></script>

  <script src="{{ asset('js/dev/loading_script.js') }}"></script>
  <script src="{{ asset('js/dev/control.js') }}"></script>
  <script src="{{ asset('js/dev/dates_format.js') }}"></script>
@endsection