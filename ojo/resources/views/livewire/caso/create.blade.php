    <div>
    <h4 class="mb-5">Registrar Caso</h4>
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

    <div class="card">
        <div class="card-body">
        <form method="post" wire:submit.prevent="store">
            <div class="row my-3"> 
                <div class="col-md-6">
                
            <div class="row">
            <div class="col-md-6">

                <h2 class="h4 my-3">Flagrancia delictiva</h3>
                <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="isFlagrancia" wire:model="isFlagrancia" value="1">
                <label class="custom-control-label" for="isFlagrancia">Flagrancia delictiva</label>
                </div>

                @error('isFlagrancia') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="col-md-6">

            <h2 class="h4 my-3">Banda u organización criminal</h3>

                <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="isBanda" wire:model="isBanda" value="1">
                <label class="custom-control-label" for="isBanda">Banda u organización criminal</label>
                </div>
                @error('isBanda') <span class="text-danger">{{ $message }}</span> @enderror

                @if($isBanda == 1)
                    <div class="form-group my-3">
                    <label class="form-label">Nombre de Banda u organización criminal</label>
                    <input type="text" class="form-control" wire:model="banda" placeholder="Nombre de banda u organizacion criminal">
                    </div>
                    @error('banda') <span class="text-danger">{{ $message }}</span> @enderror
                @endif
            </div>
        </div>

                <h2 class="h4 my-3">Carpeta fiscal</h2>
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group my-3">
                            <label for="carpeta_fiscal">Carpeta fiscal</label>
                            <input type="text" name="carpeta_fiscal" wire:model.defer="carpeta_fiscal" class="form-control" required placeholder="Carperta fiscal">
                            @error('carpeta_fiscal') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>   
                        <div class="col-md-6">
                            <div class="form-group my-3">
                            <label for="carpeta_fiscal">Fiscalia a cargo</label>
                            <input type="text" name="fiscalia" wire:model.defer="fiscalia" class="form-control" required placeholder="Fiscalia">
                            @error('fiscalia') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>   
                    </div>
                    <h2 class="h4 my-3">Procedencia de investigación</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group my-3">
                            <label for="carpeta_fiscal">Entidad</label>
                            <select wire:model.defer="entidad_id" wire:change="change_entidad"  class="custom-select" required>
                            <option selected="true">- Escoger entidad -</option>
                            @foreach($entidades as $key)
                            <option value="{{ $key->id}}">{{ $key->entidad}}</option>
                            @endforeach
                            </select>
                            @error('entidad_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>   
                        <div class="col-md-6">
                            @if($this->hide_entidad == FALSE)
                            <div class="form-group my-3">
                            <label for="carpeta_fiscal">Nombre</label>
                            <input type="text" name="entidad" wire:model.defer="entidad" class="form-control" required placeholder="Entidad">
                            @error('entidad') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>   
                    </div>
                   
                    <h2 class="h4 my-3">Documento</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group my-3">
                            <label for="carpeta_fiscal">Tipo Documento</label>
                            <select wire:model.defer="documento_id"  class="custom-select" required>
                            <option value="" selected>- Escoger tipo de documento -</option>
                            @foreach($documentos as $key)
                            <option value="{{ $key->id}}">{{ $key->documento}}</option>
                            @endforeach
                            </select>
                            @error('documento_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>   
                        <div class="col-md-4">
                            <div class="form-group my-3">
                            <label for="carpeta_fiscal">Número de documento</label>
                            <input type="text" name="documento" wire:model.defer="documento" class="form-control" required placeholder="Documento Nº">
                            @error('documento') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>   
                        <div class="col-md-4">
                            <div class="form-group my-3">
                            <label for="carpeta_fiscal">Fecha de recepción</label>
                            <input type="date" name="fecha_recepcion" wire:model.defer="fecha_recepcion" class="form-control" required placeholder="Fecha Recepcion">
                            @error('fecha_recepcion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>   
 
                    </div>
                    <h2 class="h4 my-3">Plazo de investigación</h2>
                    <div class="input-group my-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                    </div>
                    <input type="number" wire:model.defer="plazo" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text">Dias</span>
                    </div>
                    </div>
                    @error('plazo') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

            <div class="col-md-3"><!--DOS-->
                <h2 class="h4 my-3">Delitos y modalidades</h2>  

                    <div class="form-group my-3">
                    <label for="delito_id">Delito</label>
                    <select wire:model="delito_id"  wire:change="change_modalidades" class="custom-select" required>
                            <option value="" selected>- Escoger Delito -</option>
                            @foreach($delitos as $key => $value)
                            <option value="{{ $value->id}}">{{ $value->delito}}</option>
                            @endforeach
                            </select>
                    @error('delito_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group my-3">
                    <label for="modalidad_id">Modalidad</label>
                    <select wire:model="modalidad_id"  class="custom-select" required>
                            <option value="" selected>- Escoger modalidad -</option>
                            @if($this->delito_id_active > 0)
                            @foreach($modalidades as $key => $value)
                            <option value="{{ $value->id}}">{{ $value->modalidad}}</option>
                            @endforeach
                            @endif
                    </select>
                    @error('modalidad_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

            </div>

            <div class="col-md-3"><!--TRES-->
                <h2 class="h4 my-3">Banco y moneda</h2>  

                    <div class="form-group my-3">
                    <label for="banco_id">Banco</label>
                    <select wire:model="banco_id" class="custom-select" required>
                            <option value="" selected>- Escoger Banco -</option>
                            @foreach($bancos as $key => $value)
                            <option value="{{ $value->id}}">{{ $value->banco}}</option>
                            @endforeach
                    </select>
                    @error('banco_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group my-3">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" wire:model.defer="cantidad" class="form-control" required placeholder="Cantidad">
                            @error('cantidad') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group my-3">
                            <label for="moneda">Moneda</label>
                            <select wire:model.defer="moneda_id" class="custom-select" required>
                                <option value="" selected>- Escoger Moneda -</option>
                                    @foreach($monedas as $m)
                                    <option value="{{ $m->id }}">{{ $m->moneda }}</option>
                                    @endforeach
                            </select>
                            @error('moneda') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        </div>
                    </div>
            </div>

            </div>

            <div class="mt-5 text-center">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar y continuar</button>
            </div>
        </form>
        </div>
    </div>
 
    </div>