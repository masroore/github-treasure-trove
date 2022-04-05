<div>
@if($pagina == "index")

<h4 class="mb-5">Casos</h4>

    @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
     @endif

    <div class="navbar row">
    
    <div class="form-group">
    <div class="input-group mb-3">
    <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1"> <i class="bi bi-search"></i> </span>
    </div>
    <input type="text" wire:keydown.enter="index" wire:model="search" class="form-control" placeholder="Buscar">
    </div>
    </div>

    <div class="float-right">

    <button class="btn btn-outline-primary" wire:click="create()"><i class="bi bi-plus-circle-fill"></i> Nuevo caso</button>

    </div>

  </div>

     <div class="card">

        <div class="card-body">

        @if(!empty($casos) )

      <table class="table">
            <thead>
                <th></th>
                <th>Entidad</th>
                <th>Documento</th>
                <th>Banda</th>
                <th>Fiscalia</th>
                <th>Carpeta fiscal</th>
                <th>Recepción</th>
                <th>Expiración</th>
                <th>Delito</th>
                <th>Banco/monto</th>
                <th style="width:15%"></th>
            </thead>
            <tbody>
                    @foreach($casos as $key => $value)
                    <tr>
                    <td>
                        <i class="bi bi-person-square px-1" data-toggle="tooltip" data-placement="bottom" title="Detective: {{$value->u_nombres}} {{$value->u_paterno}} {{$value->u_materno}}"></i> <br>
                        @if($value->c_isFlagrancia == 1 )<i class="bi bi-bullseye text-danger px-1" data-toggle="tooltip" data-placement="bottom" title="Flagrancia"></i>@endif
                        @if($value->c_isBanda == 1 )<i class="bi bi-people-fill text-danger px-1" data-toggle="tooltip" data-placement="bottom" title="Banda criminal"></i>@endif
                    </td>

                    <td>{{$value->c_entidad}} <br> {{$value->entidad}}</td>
                    <td>{{$value->c_documento}} <br> {{$value->documento}}</td>
                    <td>{{$value->c_banda}}</td>
                    <td>{{$value->c_fiscalia}}</td>
                    <td>{{$value->c_carpeta_fiscal}}</td>
                    <td>{{date("d/m/Y", strtotime($value->c_fecha_recepcion)) }}</td>
                    <td>{{date("d/m/Y", strtotime($value->c_fecha_expiracion)) }} <br> <span class="badge badge-secondary my-1">{{$value->c_plazo}} dias<span></td>
                    <td class="small">{{$value->delito}} <br> {{$value->modalidad}}</td>
                    <td class="small">{{$value->banco}} <br> {{$value->c_cantidad}} {{$value->moneda}} </td>
                    <td>
                        <button class="btn btn-outline-primary btn-sm" wire:click="show('{{ Crypt::encryptString( $value->c_id) }}')" >Abrir</button>
                        <button class="btn btn-outline-primary btn-sm" wire:click="edit('{{ Crypt::encryptString( $value->c_id) }}')" >Editar</button>
                        <button class="btn btn-outline-danger btn-sm" wire:click="destroy('{{ Crypt::encryptString( $value->c_id) }}')" >Eliminar</button>
                    </td>
                    
                    </tr>
                    @endforeach
            </tbody>
      </table>  
      <div class="pagination">
      {{ $casos->links('livewire.paginate.custom') }}
      </div>
      @endif
        </div>
    </div>


@elseif($pagina == "form_caso")

    @include('livewire.caso.create')

@elseif($pagina == "show")

    @include('livewire.caso.show')

@elseif($pagina == "edit")

    @include('livewire.caso.edit')

@endif

</div>