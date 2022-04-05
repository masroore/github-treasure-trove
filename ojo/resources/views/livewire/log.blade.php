<div>
@if($event=="index") 
  
  <h4>Logs de acciones</h4>
    <div class="navbar row">
      <div class="form-group">
        <input type="text" wire:keydown.enter="index" wire:model.lazy="s" class="form-control" placeholder="Buscar">
      </div>
      
    </div>

    <div wire:loading>
       <div class="text-dark py-2"> Cargando información...</div>
    </div>

    <table class="table table-light table-bordered">
      <thead>
        <th>#</th>
        <th>Usuario</th>
        <th>IP</th>
        <th>Codigo</th>
        <th>Log</th>
        <th>Fecha</th>
      </thead>
      <tbody>
        @foreach($data as $d)
        <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$d->name}} {{$d->lastname}}</td>
          <td>{{$d->user_ip}}</td>
          <td>{{$d->codigo}}</td>
          <td>{{$d->log}}</td>
          <td>{{ date('d/m/Y', strtotime($d->created_at))  }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  
   {{ $data->links('livewire.paginate.custom') }}
 @endif

</div>

