
<div>
    
<div class="navbar row">

<div class="form-group">
<button class="btn btn-outline-primary" wire:click="addElemento(1)"><i class="bi bi-plus-circle"></i> Teléfono</button>
<button class="btn btn-outline-primary" wire:click="addElemento(2)"><i class="bi bi-plus-circle"></i> Cuenta Bancaria</button>
<button class="btn btn-outline-primary" wire:click="addElemento(3)"><i class="bi bi-plus-circle"></i> Tarjeta de debito</button>
<button class="btn btn-outline-primary" wire:click="addElemento(4)"><i class="bi bi-plus-circle"></i> Correo Electronico</button>
<button class="btn btn-outline-primary" wire:click="addElemento(5)"><i class="bi bi-plus-circle"></i> Pagina Web</button>
<button class="btn btn-outline-primary" wire:click="addElemento(6)"><i class="bi bi-plus-circle"></i> Red Social</button>
<button class="btn btn-outline-primary" wire:click="addElemento(7)"><i class="bi bi-plus-circle"></i> Imagen</button>
</div>

<div class="float-right">

<button class="btn btn-secondary" wire:click="index()"><i class="bi bi-arrow-return-left"></i> Retornar</button>

</div>
</div>

@if($form_addElemento === TRUE)

@if($tipo_elemento == 1)

<div class="card my-3 animate__animated animate__fadeIn">
    <div class="card-header">
    <h5 class="card-title">Agregar telefono 
    <div class="float-right">
        <button class="btn btn-secondary" wire:click="$set('tipo_elemento', 0)"><i class="bi bi-dash-circle"></i> Cerrar</button>
    </div>
    </h5>
    
    </div>
    <div class="card-body">
        <form method="post" wire:submit.prevent="storeElemento(1)">
            <div class="container">
            <div class="row">
            <div class="col-md-4">
            <div class="form-group">
            <label for="operador">Empresa comunicaciones</label>
            <select class="custom-select" wire:model.defer="operador_id">
                <option value="">- Escoger operadora -</option>
                @foreach($operadoras as $operadora)
                <option value="{{ $operadora->id}}">{{ $operadora->name}}</option>
                @endforeach
            </select>
                </div>    
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label for="telefono">Número de telefono</label>
                    <input class="form-control" type="text" wire:model.defer="telefono" id="telefono" required placeholder="Número de telefono">
                </div>   
                </div>
                <div class="col-md-4">
                <div class="form-group">
                    <label for="sistema">Sistema operativo</label>
                    <select class="custom-select" wire:model.defer="sistema_id">
                        <option value="">- Escoger sistema -</option>
                        @foreach($sistemas as $sistema)
                        <option value="{{ $sistema->id}}">{{ $sistema->name}}</option>
                        @endforeach
                    </select>
                </div>  
                </div>
            </div>
            <div class="text-center my-3">
                    <button class="btn btn-outline-primary">Agregar Telefono</button>
            </div>
            </div>
            </form>
            </div>
</div>

@elseif($tipo_elemento == 2)
<div class="card my-3 animate__animated animate__fadeIn">
    <div class="card-header">
    <h5 class="card-title">Agregar cuenta bancaria
        <div class="float-right">
            <button class="btn btn-secondary" wire:click="$set('tipo_elemento', 0)">Cerrar</button>
        </div>
    </h5>
    </div>
    <div class="card-body">
        <form method="post" wire:submit.prevent="storeElemento(2)">
            <div class="container">
            <div class="row">

                <div class="col-md-4">
                <div class="form-group">
                    <label for="banco">Entidad bancaria</label>
                    <select class="custom-select" wire:model.defer="banco_id">
                        <option value="">- Escoger banco -</option>
                        @foreach($bancos as $b)
                        <option value="{{ $b->id}}">{{ $b->banco}}</option>
                        @endforeach
                    </select>
                </div>    
                </div>

                <div class="col-md-4">
                <div class="form-group">
                    <label for="cuenta_bancaria">Número de cuenta bancaria</label>
                    <input class="form-control" type="text" wire:model.defer="cuenta_bancaria" id="cuenta_bancaria" required placeholder="Cuenta bancaria">
                </div>   
                </div>

                <div class="col-md-4">
                <div class="form-group">
                <label for="moneda">Moneda</label>
                <select wire:model.defer="moneda" class="custom-select" required>
                    <option value="" selected>- Moneda -</option>
                    <option value="Soles">Soles</option>    
                    <option value="Dolares">Dolares</option>  
                    <option value="Euros">Euros</option>  
                </select>
                </div>   
                </div>

            </div>
            <div class="text-center my-3">
                    <button class="btn btn-outline-primary">Agregar cuenta bancaria</button>
            </div>
            </div>
            </form>
            </div>
</div>

@elseif($tipo_elemento == 3)
<div class="card my-3 animate__animated animate__fadeIn">
    <div class="card-header">
    <h5 class="card-title">Agregar Tarjeta de debito/credito
        <div class="float-right">
            <button class="btn btn-secondary" wire:click="$set('tipo_elemento', 0)">Cerrar</button>
        </div>
    </h5>
    </div>
    <div class="card-body">
        <form method="post" wire:submit.prevent="storeElemento(3)">
            <div class="container">
            <div class="row">

                <div class="col-md-6">
                <div class="form-group">
                    <label for="banco">Entidad bancaria</label>
                    <select class="custom-select" wire:model.defer="banco_id">
                        <option value="">- Escoger banco -</option>
                        @foreach($bancos as $b)
                        <option value="{{ $b->id}}">{{ $b->banco}}</option>
                        @endforeach
                    </select>
                    @error('banco_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>    
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="tarjeta">Número de Tarjeta de debito/credito</label>
                    <input class="form-control" type="text" wire:model.defer="numero_tarjeta" id="tarjeta" required placeholder="Número de tarjeta">
                    @error('numero_tarjeta') <span class="text-danger">{{ $message }}</span> @enderror
                </div>   
                </div>



            </div>
            <div class="text-center my-3">
                    <button class="btn btn-outline-primary">Agregar tarjeta de debito/credito</button>
            </div>
            </div>
            </form>
            </div>
</div>

@elseif($tipo_elemento == 4)
<div class="card my-3 animate__animated animate__fadeIn">
    <div class="card-header">
    <h5 class="card-title">Agregar correo electronico
        <div class="float-right">
            <button class="btn btn-secondary" wire:click="$set('tipo_elemento', 0)">Cerrar</button>
        </div>
    </h5>
    </div>
    <div class="card-body">
        <form method="post" wire:submit.prevent="storeElemento(4)">
            <div class="container">
            <div class="row">

                <div class="col-md-3"></div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="correo">Correo Electronico</label>
                    <input class="form-control" type="text" wire:model.defer="correo" id="correo" required placeholder="Correo Electronico">
                    @error('correo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>   
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="text-center my-3">
                    <button class="btn btn-outline-primary">Agregar correo electronico</button>
            </div>
            </div>
            </form>
            </div>
</div>

@elseif($tipo_elemento == 5)
<div class="card my-3 animate__animated animate__fadeIn">
    <div class="card-header">
    <h5 class="card-title">Agregar página web
        <div class="float-right">
            <button class="btn btn-secondary" wire:click="$set('tipo_elemento', 0)">Cerrar</button>
        </div>
    </h5>
    </div>    
    <div class="card-body">
        <form method="post" wire:submit.prevent="storeElemento(5)">
            <div class="container">
            <div class="row">
                
                <div class="col-md-3"></div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="pagina_web">Página Web</label>
                    <input class="form-control" type="text" wire:model.defer="pagina_web" id="pagina_web" required placeholder="URL de Página Web">
                    @error('pagina_web') <span class="text-danger">{{ $message }}</span> @enderror
                </div>   
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="text-center my-3">
                    <button class="btn btn-outline-primary">Agregar página web</button>
            </div>
            </div>
            </form>
            </div>
</div>

@elseif($tipo_elemento == 6)
<div class="card my-3 animate__animated animate__fadeIn">
    <div class="card-header">
    <h5 class="card-title">Agregar red social
        <div class="float-right">
            <button class="btn btn-secondary" wire:click="$set('tipo_elemento', 0)">Cerrar</button>
        </div>
    </h5>
    </div>
    <div class="card-body">
        <form method="post" wire:submit.prevent="storeElemento(6)">
            <div class="container">
            <div class="row">
                
                <div class="col-md-3"></div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="red_social">Red social</label>
                    <input class="form-control" type="text" wire:model.defer="red_social" id="red_social" required placeholder="Red Social">
                    @error('red_social') <span class="text-danger">{{ $message }}</span> @enderror
                </div>   
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="text-center my-3">
                    <button class="btn btn-outline-primary">Agregar red social</button>
            </div>
            </div>
            </form>
            </div>
</div>

@elseif($tipo_elemento == 7)
<div class="card my-3 animate__animated animate__fadeIn">
    <div class="card-header">
    <h5 class="card-title">Agregar imagenes
        <div class="float-right">
            <button class="btn btn-secondary" wire:click="$set('tipo_elemento', 0)">Cerrar</button>
        </div>
    </h5>
    </div>
    <div class="card-body">
        <form method="post" wire:submit.prevent="storeElemento(7)">
            <div class="container">
            <div class="row">
                
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" wire:model.defer="imagen" multiple accept="image/*" >
                        <label class="custom-file-label" for="customFile">@if($imagen)Se subiran {{count($imagen)}} archivos @else Escoger archivos. @endif</label>
                        @error('imagen.{{$index}}')<span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
           
                @if ($imagen)
                <div class="preview p-3 my-2 border">

                    @foreach($imagen as $i)

                        <img src="{{ $i->temporaryUrl() }}" class="img-thumbnail float-left mx-1 border-success" width="100px" height="auto">
                
                    @endforeach
                    <div class="clearfix"></div>
                </div>
                @endif
           
            <div class="text-center my-3">
                    <button type="submit" wire:loading.remove  @if(empty($imagen)) disabled @endif class="btn btn-outline-primary">Subir imagenes @if($imagen)<span class="badge badge-dark">{{count($imagen)}}</span>@endif </button>

                    <button class="btn btn-outline-primary" wire:loading.delay wire:target="imagen" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                      </button>
            </div>
            </div>
            </form>
            </div>
</div>

        @endif

@endif

</div>