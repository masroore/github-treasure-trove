<div>

<h4>Correos</h4>
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
        <input id="correo" autocomplete="off" wire:keydown.enter="correo" type="text"wire:model.defer="correo" class="form-control form-control-lg" placeholder="Buscar por Correo">
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
        <th>Correo 1</th>
        <th>Correo 2</th>
        <th>Correo 3</th>
        <th></th>
      </thead>
      <tbody>
        @foreach($data as $d)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$d->nro_doc}}</td>
          <td>{{$d->nombre_completo}}</td>
          <td>{{$d->correo1}}</td>
          <td>{{$d->correo2}}</td>
          <td>{{$d->correo3}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  
   {{ $data->links('livewire.paginate.custom') }}
   @endif


</div>
