<div>
    
@if($pagina == "index")

<h4 class="mb-5">Personas</h4>
    @if (session()->has('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>
     @endif

    <div class="navbar row">
    
    <div class="form-group">
    <div class="input-group mb-3">
    <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1"> <i class="bi bi-search"></i> </span>
    </div>
    <input type="text" wire:keydown.enter="index" wire:model.lazy="search" class="form-control" placeholder="Buscar">
    </div>
    </div>

    <div class="float-right">
    <button class="btn btn-outline-primary" wire:click="create()"><i class="bi bi-plus-circle-fill"></i> Agregar persona a caso</button>
    </div>

  </div>
     <div class="card">
        <div class="card-body">
    @if( !empty($personas) )
      <table class="table">
            <thead>
                <th></th>
                <th>Nombres</th>
                <th>Paterno</th>
                <th>Materno</th>
                <th>Documento</th>
                <th>Ubicación</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($personas as $p)
                <tr>
                <td><i class="bi bi-person-circle"></i></td>
                <td>{{$p->p_nombres}}</td>
                <td>{{$p->p_paterno}}
                <td>{{$p->p_materno}}</td>
                <td>
                    <span class="badge badge-secondary">{{$p->tipo_documento}}</span>  {{$p->p_numero_documento}}</td>
                <td>
                    {{$p->pais}}  {{$p->region}}  {{$p->provincia}}  {{$p->distrito}} <br> {{$p->p_direccion}}
                </td>
                <td>
                    <button class="btn btn-outline-primary btn-sm" wire:click="show({{ $p->p_id }})" >Abrir</button>
                    <button class="btn btn-outline-primary btn-sm" wire:click="edit({{ $p->p_id }})" >Editar</button>
                    <button class="btn btn-outline-danger btn-sm" wire:click="edit({{ $p->p_id }})" >Eliminar</button>
                </td>
                
                </tr>
                @endforeach
            </tbody>
      </table>  

      <div class="pagination">
        {{ $personas->links('livewire.paginate.custom') }}
      </div>

      @endif

    </div>
</div>

@elseif($pagina == "form_persona")

    @include('livewire.persona.create')

@elseif($pagina == "show")

    @include('livewire.persona.show')

@endif



</div>
