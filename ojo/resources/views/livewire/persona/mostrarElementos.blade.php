    <div class=" my-3">
    
        <h5 clas="h1 my-4"><i class="bi bi-card-checklist"></i> Información vinculada a esta persona</h5>

        <div class="my-3">
            <button class="btn btn-outline-dark" wire:click="showElemento(1)">Telefonos @if($telefonos) <span class="badge badge-dark">{{count($telefonos)}} @endif</button>
            <button class="btn btn-outline-dark" wire:click="showElemento(2)">Cuentas Bancarias @if($cuenta_bancarias) <span class="badge badge-dark">{{count($cuenta_bancarias)}} @endif</button>
            <button class="btn btn-outline-dark" wire:click="showElemento(3)">Tarjeta de debito @if($tarjetas) <span class="badge badge-dark">{{count($tarjetas)}} @endif</button>
            <button class="btn btn-outline-dark" wire:click="showElemento(4)">Correo Electronico @if($correos) <span class="badge badge-dark">{{count($correos)}} @endif</button>
            <button class="btn btn-outline-dark" wire:click="showElemento(5)">Pagina Web @if($paginasWeb) <span class="badge badge-dark">{{count($paginasWeb)}} @endif</button>
            <button class="btn btn-outline-dark" wire:click="showElemento(6)">Red Social @if($redesSociales) <span class="badge badge-dark">{{count($redesSociales)}} @endif</button>
            <button class="btn btn-outline-dark" wire:click="showElemento(7)">Imagenes @if($imagenes) <span class="badge badge-dark">{{count($imagenes)}} @endif</button>
        </div>

        @if($showElemento==1)

            @if($telefonos)

            <table class="table my-5">
                <thead class="thead-dark">
                    <th></th>
                    <th>Telefono</th>
                    <th>Operador</th>
                    <th>Sistema</th>
                </thead>
                <tbody>
                    @foreach($telefonos as $t)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$t->telefono}}</td>
                        <td>{{$t->operador}}</td>
                        <td>{{$t->sistema}}</td>
                    </tr>   
                    @endforeach
                </tbody>
            </table>

            @else 

            <p>No existen datos.</p>

            @endif
            
        @elseif($showElemento==2)

        @if($cuenta_bancarias)

        <table class="table my-5">
            <thead  class="thead-dark">
                <th></th>
                <th class="w-25">Banco</th>
                <th>Cuenta</th>
                <th>Moneda</th>
            </thead>
            <tbody>
                @foreach($cuenta_bancarias as $c)
                <tr>
                    <td>{{$loop->index + 1}}</td>
                    <td>{{$c->banco}}</td>
                    <td>{{$c->cuenta}}</td>
                    <td>{{$c->moneda}}</td>
                </tr>   
                @endforeach
            </tbody>
        </table>

        @else 

        <p>No existen datos.</p>

        @endif

        @elseif($showElemento==7)

        @if($imagenes)

        <div class="row">

                @foreach($imagenes as $i)
                <div class="col-md-2">
                    <div class="card position-relative">
                    <a href="{{ Storage::url($i->image_url) }}">
                        <img src="{{ Storage::url($i->image_url) }}" alt="" class="card-img">
                    </a>
                    <div class="card-footer p-0">
                        <button class="btn btn-ligth btn-sm" wire:click="destroyImage({{$i->image_id}})"><i class="bi bi-x-circle-fill text-danger"></i> Eliminar</button>
                        <button class="btn btn-primery btn-sm" wire:click="changeProfile({{$i->image_id}})"><i class="bi bi-person-bounding-box text-dark"></i> Perfil</button>
                    </div>
                    </div>
                </div>
                @endforeach
        <div class="clearfix"></div>
        </div>

        @else 

        <p>No existen datos.</p>

        @endif

        {{-- TARJETAS --}}

        @elseif($showElemento==3)

        @if($tarjetas)

                <table class="table my-5">
                <thead class="thead-dark">
                    <th></th>
                    <th>Banco</th>
                    <th>Número de tarjeta</th>
                </thead>
                <tbody>
                    @foreach($tarjetas as $t)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$t->banco}}</td>
                        <td>{{$t->numero_tarjeta}}</td>
                    </tr>   
                    @endforeach
                </tbody>
            </table>

        @else 

        <p>No existen datos.</p>

        @endif

        {{--FIN TARJETAS --}}

        {{-- CORREOS --}}

        @elseif($showElemento==4)

        @if($correos)

                <table class="table my-5">
                <thead class="thead-dark">
                    <th></th>
                    <th>Correo electronico</th>
                </thead>
                <tbody>
                    @foreach($correos as $c)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$c->correo}}</td>
                    </tr>   
                    @endforeach
                </tbody>
            </table>

        @else 

        <p>No existen datos.</p>

        @endif

        {{-- FIN CORREOS --}}     

        {{-- PAGINA WEB --}}

        @elseif($showElemento==5)

        @if($paginasWeb)

                <table class="table my-5">
                <thead class="thead-dark">
                    <th></th>
                    <th>Páginas Web</th>
                </thead>
                <tbody>
                    @foreach($paginasWeb as $p)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$p->pagina_web}}</td>
                    </tr>   
                    @endforeach
                </tbody>
            </table>

        @else 

        <p>No existen datos.</p>

        @endif

        {{-- FIN PAGINA WEB --}}       

        {{-- REDES SOCIALES --}}

        @elseif($showElemento==6)

        @if($redesSociales)

                <table class="table my-5">
                <thead class="thead-dark">
                    <th></th>
                    <th>Redes sociales</th>
                </thead>
                <tbody>
                    @foreach($redesSociales as $r)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td>{{$r->red_social}}</td>
                    </tr>   
                    @endforeach
                </tbody>
            </table>

        @else 

        <p>No existen datos.</p>

        @endif

        {{-- FIN REDES SOCIALES --}}   
        @endif

    </div>