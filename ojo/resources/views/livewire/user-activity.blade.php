<div>
@if($pagina=="index") 
  <h4>Actividades de usuarios</h4>
    <div class="navbar row">
      <div class="form-group"> 
        <input type="text" placeholder="Buscar" class="form-control" wire:model="search" wire:keypress.enter="index">
      </div>
    </div>
    <div class="container">

      <div class="row">
      <table class="table">
            <thead>
                <th>#</th>
                <th>Evento</th>
                <th>Descripción</th>
                <th>Modelo</th>
                <th>Usuario</th>
                <th>IP address</th>
                <th>Brownser</th>
                <th>System</th>
                <th>Fecha/Hora</th>
            </thead>
            <tbody>
        @foreach($useractivities as $u)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>
                    @if($u->event == "Search")
                    <span class="badge badge-secondary">
                    @elseif($u->event == "Create")
                    <span class="badge badge-primary">
                    @elseif($u->event == "Update")
                    <span class="badge badge-warning">
                    @elseif($u->event == "Destroy")
                    <span class="badge badge-danger">
                    @elseif($u->event == "Logout")
                    <span class="badge badge-secondary">
                    @elseif($u->event == "Login")
                    <span class="badge badge-success">
                    @endif
                    
                        {{$u->event}}

                    </span>
                </td>
                <td>{{$u->description}}</td>
                <td class="small">{{$u->subject_type}}</td>
                <td>{{$u->nombres}}, {{$u->paterno}} {{$u->materno}}</td>
                @foreach( json_decode($u->properties) as $a )
                <td>
                    {{$a}}
                </td>
                @endforeach
                <td>
                    {{ \Carbon\Carbon::parse($u->created_at)->format('d/m/Y H:i') }}
                </td>
            </tr>
        @endforeach
        </tbody>
        </table>

        {{ $useractivities->links('livewire.paginate.custom') }}

        </div>

    </div>
@endif
</div>