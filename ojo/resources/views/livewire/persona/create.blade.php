
<h4 class="mb-5">Agregar persona a caso</h4>

@if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
 @endif
 
 <div class="navbar row">

<div class="form-group">
</div>

<div class="float-right">

<button class="btn btn-secondary" wire:click="index()"><i class="bi bi-arrow-return-left"></i> Retornar</button>

</div>
</div>

@if($form_vincular==TRUE)
<div class="card shadow-sm">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <i class="bi bi-lightning-charge-fill text-warning"></i> Esta persona ya se encuentra registrada. 
                <p class="my-3">
                <span class="font-weight-bold">{{ $paterno }} {{ $materno }}, {{ $nombres }}</span> identificado con 
                <span class="font-weight-bold">{{ $numero_documento }}</span></p>
            </div>
            <div class="col-md-6">
                <p>Vincular al presenta caso como: </p>
                <form method="post" class="mb-0" wire:submit.prevent="storeVinculacion()">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="situacion_id" wire:model.defer="situacion_id" id="inlineRadio1" value="1" required>
                    <label class="form-check-label" for="inlineRadio1">Denunciante</label>
                </div>
        
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="situacion_id" wire:model.defer="situacion_id" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">Investigado</label>
                </div>

                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-plus-circle"></i> Vincular a caso</button>
                </form>
            </div>
        </div>
       

    </div>
</div>

@else

<div class="card shadow">
    <div class="card-header bg-light">
    <h2 class="h4 my-3">Situación de persona</h2>  
    <form method="post" wire:submit.prevent="store()">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="situacion_id" wire:model.defer="situacion_id" id="inlineRadio1" value="1" required>
            <label class="form-check-label" for="inlineRadio1">Denunciante</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="situacion_id" wire:model.defer="situacion_id" id="inlineRadio2" value="2">
            <label class="form-check-label" for="inlineRadio2">Investigado</label>
        </div>
        <span class="text-danger">¡Importante!</span>
    </div>
    <div class="card-body">
    <div class="row">
        <div class="col-md-6">

                <h2 class="h4 my-3">Documento de identidad</h2>  
                <div class="row">
                    <div class="col-md-6">
                    <label for="tipo_documento">Tipo documento</label>
                    <select name="tipo_documento" id="tipo_documento" wire:model.defer="tipo_documento"  class="custom-select">
                        <option value="" selected>- Escoger Documento -</option>
    
                        @foreach($tipo_documento_identidad as $key => $value)
                                <option value="{{ $value->id}}">{{ $value->name}}</option>
                        @endforeach
    
                    </select>
                    @error('tipo_documento') <span class="text-danger">{{ $message }}</span> @enderror
    
                    </div>
                    <div class="col-md-6">
                    <label for="numero_documento">Número de documento</label>
                    <div class="input-group mb-1">
                        <input type="text" class="form-control border-dark" wire:keydown="checkPersona" wire:model.lazy="numero_documento" name="numero_documento" placeholder="Número de documento">
                        <div class="input-group-append">
                        @if($noExistPerson==TRUE)
                        <span class="input-group-text bg-success border-success text-light" id="basic-addon2"><i class="bi bi-check2"></i>
                        @else
                          <span class="input-group-text bg-dark border-dark text-light" id="basic-addon2"><i class="bi bi-command"></i></span>
                        @endif
                        </div>
                    </div>
                    <span class="muted">Presionar <code>ENTER</code> para  procesar.</span>
                    @error('numero_documento') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

             <h2 class="h4 my-3">Datos personales</h2> 

            <div class="form-group my-3">
                <label for="nombres">Nombres</label>
                <input type="text" name="nombres" wire:model.defer="nombres" class="form-control" required placeholder="Nombres">
                @error('nombres') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group my-3">
                <label for="nombres">Apellido paterno</label>
                <input type="text" name="paterno" wire:model.defer="paterno" class="form-control" required placeholder="Paterno">
                @error('paterno') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group my-3">
                <label for="nombres">Apellido materno</label>
                <input type="text" name="materno" wire:model.defer="materno" class="form-control" required placeholder="Materno">
                @error('materno') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="row">
                <div class="col-md-6">
                <label for="tipo_documento">Edad</label>
                <input type="number" wire:model="edad" class="form-control" required>
                @error('edad') <span class="text-danger">{{ $message }}</span> @enderror

                </div>
                <div class="col-md-6">
                <label for="nombres">Sexo</label>
                <select name="sexo" id="sexo" class="custom-select"  wire:model.defer="sexo">
                    <option value="0" selected>- Femenino -</option>
                    <option value="1">Masculino</option>
                </select>
                 @error('sexo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="col-md-6">
        <h2 class="h4 my-3">Ubicación</h2>  
                <div class="row">
                    <div class="col-md-3">

                    <div class="form-group my-3">
                        <label for="selectedPais">Pais</label>
                      
                        <select wire:model="selectedPais" id="selectedPais" wire:change="updatePais" class="custom-select" required>
                            <option >- Escoger pais -</option>
                        
                            @foreach($this->paises as $pais )

                            <option value="{{ !empty($pais->id) ? $pais->id : $pais['id']  }}">{{ !empty($pais->pais) ? $pais->pais : $pais['pais']  }}</option>

                            @endforeach

                        </select>    

                        @error('selectedPais') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    </div>

                    @if($this->hide_peru === FALSE)
                    <div class="col-md-3">
                    <div class="form-group my-3">
                        <label for="selectedRegion">Regiones</label>
                      
                        <select wire:model="selectedRegion" id="selectedRegion" wire:change="updateRegion" class="custom-select" required>
                            <option >- Escoger Region -</option>
                        
                            @foreach($this->regiones as $region )

                            <option value="{{ !empty($region->id) ? $region->id : $region['id']  }}">{{ !empty($region->name) ? $region->name : $region['name']  }}</option>

                            @endforeach

                        </select>    
                    </div>
                    </div>

                    <div class="col-md-3">
                    <div class="form-group my-3">
                        <label for="selectedProvincia">Provincia</label>
                      
                        <select wire:model="selectedProvincia" id="selectedProvincia" wire:change="updateProvincia" class="custom-select" required>
                            <option >- Escoger Provincia -</option>
                            @if($this->provincias)
                            @foreach($this->provincias as $provincia )

                            <option value="{{ !empty($provincia->id) ? $provincia->id : $provincia['id']  }}">{{ !empty($provincia->name) ? $provincia->name : $provincia['name']  }}</option>

                            @endforeach
                            @endif
                        </select>    
                    </div>
                    </div>


                    <div class="col-md-3">
                    <div class="form-group my-3">
                        <label for="selectedDistrito">Distrito</label>
                      
                        <select wire:model="selectedDistrito" id="selectedDistrito" class="custom-select" required>
                            <option >- Escoger Distrito -</option>
                            @if($this->distritos)

                            @foreach($this->distritos as $distrito )

                            <option value="{{ !empty($distrito->id) ? $distrito->id : $distrito['id']  }}">{{ !empty($distrito->name) ? $distrito->name : $distrito['name']  }}</option>

                            @endforeach

                            @endif
                        </select>    
                    </div>
                    </div>

                    @endif


                </div>

            <div class="form-group my-3">
                    <div class="form-group mb-1">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" wire:model.lazy="direccion" class="form-control" required placeholder="Direccion">
                    </div>
                @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

        </div>
       
        </div> 
        
        
            <div class="mt-5 text-center">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar y continuar</button>
            
                </form>
            
            </div>

</div>    
@endif