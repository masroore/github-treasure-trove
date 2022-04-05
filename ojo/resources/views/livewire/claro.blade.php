<div>

  
  <h4>Empresa America Movil - Claro Perú</h4>
    <div class="mt-5 row">
    <div class="col md 4">

    <div class="form-group">
        <input id="dni" type="text" autocomplete="off" wire:keydown.enter="dni"  wire:model.defer="dni" class="form-control form-control-lg" placeholder="Buscar por DNI">
          <div class="mt-1 small text-muted">Presione Enter</div>
      </div>

    </div>
    <div class="col md 4">

    <div class="form-group">
        <input id="name" type="text" autocomplete="off" wire:keydown.enter="name" wire:model.defer="name" class="form-control form-control-lg" placeholder="Buscar por Nombres y apellidos">
        <div class="mt-1 small text-muted">Presione Enter</div>
    </div>

    </div>
    <div class="col md 4">

    <div class="form-group">
        <input id="telefono" autocomplete="off" wire:keydown.enter="telefono" type="text"wire:model.defer="telefono" class="form-control form-control-lg" placeholder="Buscar por Telefono">
        <div class="mt-1 small text-muted">Presione Enter</div>
      </div>
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
        <th>Nombre completo</th>
        <th>Fecha de activación</th>
        <th>Número</th>
        <th>Plan</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($data as $d)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$d->dni}}</td>
          <td>{{$d->nombre}}</td>
          <td>{{$d->fecha}}</td>
          <td>{{$d->numero}}</td>
          <td>{{$d->plan}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  
   {{ $data->links('livewire.paginate.custom') }}
   @endif


</div>
