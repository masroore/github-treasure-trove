<div>
  
  @if($event=="index") 
  
  <h4>Usuarios</h4>
    <div class="navbar row">
      <div class="form-group">
        <input type="text" wire:keydown.enter="index" wire:model="s" class="form-control" placeholder="Buscar">
      </div>
      <div class="float-right">
       <button wire:click="create" class="btn btn-OUTLINE-primary"> Nuevo usuario</button>
      </div>
    </div>
  
    <table class="table table-striped">
      <thead>
        <th>#</th>
        <th></th>
        <th>Nombres y apellidos</th>
        <th>Telefono</th>
        <th>Email</th>
        <th>Grupo</th>
        <th>Última IP</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($users as $d)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>
            @if($d->is_active == 1) <button wire:click="changeStatus({{$d->user_id}})" class="btn btn-sm btn-outline-success">Activo</button> @else <button wire:click="changeStatus({{$d->user_id}})" class="btn btn-sm btn-outline-danger">Inactivo</button> @endif
            @if($d->FA == 1) <span class="btn btn-sm btn-outline-success">2FA</span>  @endif
          </td>
          <td class="small">{{$d->nombres}}, {{$d->paterno}} {{$d->materno}}</td>
          <td class="small">{{$d->telefono}}</td>
          <td class="small">{{$d->email}}</td>
          <td class="small">{{$d->grupo}}</td>
          <td>{{$d->last_ip}}</td>
          <td>
          <button wire:click="edit({{$d->user_id}})" class="btn btn-sm btn-outline-primary">Editar</button>
          <button wire:click="destroy({{$d->user_id}})" class="btn btn-sm btn-outline-danger">Eliminar</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  
   {{ $users->links('livewire.paginate.custom') }}
      
 @elseif($event=="create")
  
    <h4>Crear nuevo usuario</h4>
    <div class="navbar row">
      <div></div>
      <div class="float-right">
       <button wire:click="index" class="btn btn-secondary"><i class="bi bi-arrow-return-left"></i> Retornar</button>
      </div>
    </div>
      <form  wire:submit.prevent="store">
        <div class="row">

            <div class="col-md-4">

              <div class="form-group">
                <label class="form-label">Nombres</label>
                <input type="text" wire:model="nombres" class="form-control" required>
                @error('nombres') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label class="form-label">Apellido paterno</label>
                <input type="text" wire:model="paterno" class="form-control" required>
                @error('paterno') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label class="form-label">Apellido materno</label>
                <input type="text" wire:model="materno" class="form-control" required>
                @error('materno') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>

               <div class="form-group">
                <label class="form-label">DNI</label>
                <input type="number" wire:model="dni" class="form-control">
                 @error('dni') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>

            </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Contraseña</label>
                  <input type="password" wire:model="password" class="form-control" required>
                  @error('password') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group">
                  <label class="form-label">Email</label>
                  <input type="email" wire:model="email" class="form-control" required> 
                  @error('email') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                  <label class="form-label">Telefono</label>
                  <input type="text" wire:model="telefono" class="form-control">
                  @error('telefono') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
                </div>

              </div>

              <div class="col-md-4">

              <h4 class="h3 my-3">Permisos</h4>

              <div class="row">

                @foreach($PermissionAll as $key => $value)
                <div class="col-md-3">

                  <div class="custom-control custom-switch my-3">

                  <input type="checkbox" class="custom-control-input" id="customSwitch{{$value->id}}" wire:model.lazy="registroPermisos" value="{{$value->name}}" >
                  
                  <label class="custom-control-label" for="customSwitch{{$value->id}}">{{$value->name}}</label>

                  </div>

                </div>
                @endforeach 
                
              </div>

              <h4 class="h3 mb-3">Grupo</h4>

              <div class="form-group">
                <select class="custom-select custom-select-lg mb-3" wire:model="grupo_id" required>
                  <option selected>- Seleccionar grupo -</option>
                    @foreach($grupos as $g) 
                    <option value="{{$g->id}}">{{$g->grupo}}</option>
                    @endforeach
                </select>

              </div>

              </div>

        </div>
            <div class="text-center">
                <button class="btn btn-outline-primary btn-lg" type="submit">Crear usuario</button>
            </div>
           
      </form>
  
  @elseif($event=="edit")
  
   <h4>Editar </h4>
    <div class="navbar row">
      <div></div>
      <div class="float-right">
       <button wire:click="index" class="btn btn-secondary"><i class="bi bi-arrow-return-left"></i> Retornar</button>
      </div>
    </div>
      <form  wire:submit.prevent="update({{$user_id}})">
        <div class="row">
            <div class="col-md-4">
              
              <div class="form-group">
                <label class="form-label">Nombres</label>
                <input type="text" wire:model="nombres" class="form-control" value="{{$nombres}}" required>
                @error('nombres') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>
              
              <div class="form-group">
                <label class="form-label">Apellido paterno</label>
                <input type="text" wire:model="paterno" class="form-control" required>
                @error('paterno') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>

              <div class="form-group">
                <label class="form-label">Apellido materno</label>
                <input type="text" wire:model="materno" class="form-control" required>
                @error('materno') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>
              
               <div class="form-group">
                <label class="form-label">DNI</label>
                <input type="text" wire:model="dni" class="form-control" value="{{$dni}}">
                 @error('dni') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>
              <div class="card bg-secondary">
                <div class="card-body">
                  <div class="form-group">
                  <label class="form-label">Contraseña</label>
                  <input type="text" wire:model="password" class="form-control">
                  @error('password') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
                  <div class="mute text-dark py-3">(*) Cambiar contraseña</div>
                  </div>
                </div>
              </div>


            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" wire:model="email" class="form-control" value="{{$email}}">
                @error('email') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>
              
              <div class="form-group">
                <label class="form-label">Telefono</label>
                <input type="text" wire:model="telefono" class="form-control" value="{{$telefono}}">
                @error('telefono') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>
            </div>

            <div class="col-md-4">
            <h4 class="h3 my-3">Permisos</h4>
              
              <div class="row">
              @foreach($PermissionAll as $key => $value)
              <div class="col-md-3">
              <div class="custom-control custom-switch my-3">

                <input type="checkbox" class="custom-control-input" id="customSwitch{{$value->id}}"
                
                      @foreach($UserPermission as $Ukey => $Uvalue)

                      @if($Uvalue == $value->name)

                        checked="checked"

                      @endif

                      @endforeach
                >
                <label wire:click="ChangePermission({{$value->id}}, {{$user_id}})" class="custom-control-label" for="customSwitch{{$value->id}}">{{$value->name}}</label>

                </div>
                </div>
                @endforeach 

              </div>

              <h4 class="h3 my-3">2FA</h4>
              <p>Eliminar vinculación de doble factor de autenticidad.</p>
              <button wire:click="reset2FA({{$user_id}})" class="btn btn-outline-primary btn-lg">2FA Reset</button>
            </div>    
          </div>  
  <div class="text-center">
    <button class="btn btn-outline-primary" type="submit">Guardar cambios</button>
  </div>
  @endif
  
</div>
