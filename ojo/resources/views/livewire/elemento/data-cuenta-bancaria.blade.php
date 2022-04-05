<div>
    @if($pagina == "index")
    <h4 class="mb-5">Búsqueda de cuentas bancarias</h4>

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
                @if(count($cuentasBancarias) > 0)
                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Cuenta bancaria</th>
                        <th>Banco/moneda</th>
                        <th>Vinculado a</th>
                        <th>Documento</th>
                    </thead>
                    <tbody>
                        @foreach($cuentasBancarias as $c)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $c->cuenta }}</td>
                                <td>
                                   <i class="bi bi-bank2"></i> {{ $c->banco }} <br>
                                  <i class="bi bi-cash-coin"></i> {{ $c->moneda }}
                                </td>
                                <td>
                                <a class="btn btn-light btn-lg" href="{{ route('personas') }}?show={{ base64_encode(Crypt::encryptString($c->person_id)) }}"><i class="bi bi-person-fill"></i>

                                {{ $c->nombres }}, {{ $c->paterno }} {{ $c->materno }}
                            
                                </a>
                                </td>
                                <td>
                                    <span class="badge badge-success"><i class="bi bi-credit-card-2-front"></i>  {{ $c->tipo_documento }}</span> <br>
                                    {{ $c->numero_documento }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $cuentasBancarias->links('livewire.paginate.custom') }}
                </div>
                @else
                <p>No se encuentraron datos.</p>
                @endif
            </div>
        </div>
    </div>

    @endif
</div>
