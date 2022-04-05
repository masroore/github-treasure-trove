<div>

  
  <h4>RENIEC - ESSALUD</h4>
    <div class="mt-5 row">
    <div class="col md 4">

    <div class="form-group">
        <input id="dni" type="text" wire:keydown.enter="dni"  wire:model.defer="dni" class="form-control form-control-lg" placeholder="Buscar por DNI">
        <div class="mt-1 small text-muted">Presione Enter</div>
      </div>

    </div>
    <div class="col md 8 border-left">
    <form wire:submit.prevent="buscar">
    <div class="form-group">
        <input id="nombres" type="text" wire:model.defer="nombres" class="form-control form-control-lg" placeholder="Buscar por Nombres">
    </div>
    <div class="form-group">
        <input id="paterno"  type="text" wire:model.defer="paterno" class="form-control form-control-lg" placeholder="Buscar por Apellido Paterno">
      </div>
      
      <div class="form-group">
        <input id="materno"  type="text"wire:model.defer="materno" class="form-control form-control-lg" placeholder="Buscar por Apellido Materno">
      </div>
      <button type="submit" class="btn btn-primary"><i class="cil-search"></i>  Buscar</button>
      </form>
    </div>
    </div>
<hr>

    <div wire:loading class="text-center">
    <div class="text-center">
    <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>
    </div>
  @if(!empty($data) )
    <table class="table table-light table-bordered">
      <thead>
        <th>#</th>
        <th>DNI</th>
        <th>Paterno</th>
        <th>Materno</th>
        <th>Nombres</th>
        <th>Nacimiento</th>
        <th>Direccion</th>
        <th>Ubigeo</th>
      </thead>
      <tbody>
        @foreach($data as $d)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$d->DOCUMENTO}}</td>
          <td>{{$d->PATERNO}}</td>
          <td>{{$d->MATERNO}}</td>
          <td>{{$d->NOMBRES}}</td>
          <td>{{$d->NACIMIENTO}}</td>
          <td>{{$d->DIRECCION}}</td>
          <td>{{$d->UBIGEO}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  
   {{ $data->links('livewire.paginate.custom') }}
   @endif


</div>
