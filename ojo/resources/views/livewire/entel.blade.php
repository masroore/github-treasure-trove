<div>
  <h4>Empresa Entel</h4>
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
        <th>DNI/RUC</th>
        <th>Nombre completo</th>
        <th>Telf 1</th>
        <th>Telf 2</th>
        <th>Telf 3</th>
        <th>Telf 4</th>
        <th>Telf 5</th>
      </thead>
      <tbody>
        @foreach($data as $d)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$d->nro_doc}}</td>
          <td>{{$d->nombre_completo}}</td>
          <td>{{$d->Tel1}}</td>
          <td>{{$d->Tel2}}</td>
          <td>{{$d->Tel3}}</td>
          <td>{{$d->Tel4}}</td>
          <td>{{$d->Tel5}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  
   {{ $data->links('livewire.paginate.custom') }}
   
 @endif

</div>


