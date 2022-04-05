<div>
    @if($pagina == "index")
    <h4 class="mb-5">Búsqueda de números teléfonicos</h4>

    @if (session()->has('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>
     @endif

    <div class="container">
        <div class="card">
            <div class="card-header bg-secondary">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"> <i class="bi bi-search"></i> </span>
                    </div>
                <input type="number" wire:keydown.enter="index" wire:model="search" class="form-control form-control-lg text-center" placeholder="Buscar" required>
                <div class="input-group-append">
                   <button class="btn btn-dark " wire:click="$set('search', '')">Limpiar</button>
                 </div>
                </div>
            </div>
            <div class="card-body">
                @if(count($telefonos) > 0)
                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Número de Telefono</th>
                        <th>Operador/Sistema</th>
                        <th>Vinculado a</th>
                        <th>Documento</th>
                    </thead>
                    <tbody>
                        @foreach($telefonos as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->telefono }}</td>
                                <td>
                                   {{ $t->operadora }}<br>
                                   {{ $t->sistema }}
                                </td>
                                <td>
                                <a class="btn btn-light btn-lg" href="{{ route('personas') }}?show={{ base64_encode(Crypt::encryptString($t->person_id)) }}"><i class="bi bi-person-fill"></i>

                                {{ $t->nombres }}, {{ $t->paterno }} {{ $t->materno }}
                            
                                </a>
                                </td>
                                <td>
                                    <span class="badge badge-success"><i class="bi bi-credit-card-2-front"></i>  {{ $t->tipo_documento }}</span> <br>
                                    {{ $t->numero_documento }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $telefonos->links('livewire.paginate.custom') }}
                </div>
                @else
                <p>No se encuentraron datos.</p>
                @endif
            </div>
        </div>
    </div>

    @endif
</div>
