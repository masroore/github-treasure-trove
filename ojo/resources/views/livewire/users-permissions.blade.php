<div>
  
  @if($event=="index") 
  <h4>Permisos de usuario</h4>
    <div class="navbar row">
      <div></div>
      <div class="float-right">
       <button wire:click="create" class="btn btn-OUTLINE-primary"> Nuevo permiso</button>
      </div>
    </div>
    <div class="container">

      <div class="row">
        @foreach($permisos as $p)
        <div class="col-md-2">
        <div class="card bg-secondary">
          <div class="card-header">
          <h3 class="card-title">{{$p->name}}</h3>
          </div>
          <div class="card-body">
            <p>
            <button wire:click="destroy({{$p->id}})" class="btn btn-outline-danger">Eliminar</button>
            </p>
          </div>
        </div>
        </div>
        @endforeach
        </div>

    </div> 
 @elseif($event=="create")
  
    <h4>Crear nuevo permiso</h4>
    <div class="navbar row">
      <div></div>
      <div class="float-right">
       <button wire:click="index" class="btn btn-secondary"><i class="bi bi-arrow-return-left"></i> Retornar</button>
      </div>
    </div>
    <div class="container">
      <form  wire:submit.prevent="store">
              <div class="form-group">
                <label class="form-label">Permiso</label>
                <input type="text" wire:model.lazy="name" class="form-control" required>
                @error('name') <span class="d-block text-danger error  mb-4">{{ $message }}</span>@enderror
              </div>

            <div class="text-center">
                <button class="btn btn-outline-primary btn-lg" type="submit">Crear permiso</button>
            </div>
      </form>
</div>
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

