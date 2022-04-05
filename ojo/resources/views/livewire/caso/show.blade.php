<div>
<h4 class="mb-5">Detalle de caso</h4>

@if (session()->has('message'))

<div class="alert alert-warning">

    {{ session('message') }}

</div>

 @endif

<div class="navbar row">
    <div class="form-group">
    <a class="btn btn-outline-primary" href="{{ route('personas') }}?create={{ base64_encode($selected_id) }}"><i class="bi bi-plus-circle"></i> Agregar persona a caso</A>
    </div>

    <div class="float-right">
      
        <button class="btn btn-secondary" wire:click="index()"><i class="bi bi-arrow-return-left"></i> Retornar</button>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{$caso->c_carpeta_fiscal}}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
            <h3 class="h5 my-3">Caracteristica de caso</h3>
                <table class="table">
                    <tr>
                        <td> Flagrancia delictiva :</td>
                        <td>
                        @if($caso->c_isFlagrancia)
                             <span class="badge badge-lg badge-success">Si</span>     
                         @else 
                             <span class="badge badge-lg badge-secondary">No</span> 
                         @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                        Banda u organización criminal :
                        </td>
                        <td>
                        @if($caso->c_isBanda)
                                <span class="badge badge-lg badge-success">Si</span>    
                        @else 
                                <span class="badge badge-lg badge-secondary">No</span> 
                        @endif
                        </td>
                    </tr>
                    @if($caso->c_isBanda)
                    <tr>
                        <td>Nombre de banda</td>
                        <td><span class="pt-3 text-capitalize">{{$caso->c_banda}}</span></td>
                    </tr>
                    @endif
                </table>

                <h3 class="h5 my-3">Datos de detective</h3>
                <table class="table">
                    <tr>
                        <td>Detective a cargo :</td>
                        <td> {{$caso->u_nombres}} {{$caso->u_paterno}} {{$caso->u_materno}}</td>
                    </tr>
                    <tr>
                        <td>Telefono de detective</td>
                        <td>{{$caso->u_telefono}} </td>
                    </tr>
                </table>

            </div>
            <div class="col-md-3">
            <h3 class="h5 my-3">Fiscalia a cargo</h3>
                <table class="table">
                    <tbody>
                        @foreach($fiscalias as $f)
                        <tr>
                            <td>{{$loop->iteration }} </td>
                            <td>{{$f->fiscalia}}</td>
                            <td class="small">{{ \Carbon\Carbon::parse($f->fecha_creacion)->format('d/m/Y')  }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3 class="h5 my-3">Datos de carpeta fiscal</h3>
                <table class="table">
                <tbody>
                    <tr>
                        <td>Carpeta fiscal:</td>
                        <td>{{$caso->c_carpeta_fiscal}}</td>
                    </tr>
                    <tr>
                        <td>Entidad:</td>
                        <td>{{$caso->c_entidad}}</td>
                    </tr>
                    <tr>
                        <td>Documento:</td>
                        <td>{{$caso->documento}} {{$caso->c_documento}}</td>
                    </tr>
                    <tr>
                        <td>Fecha recepción:</td>
                        <td>{{\Carbon\Carbon::parse($caso->c_fecha_recepcion)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Fecha expiración:</td>
                        <td>{{\Carbon\Carbon::parse($caso->c_fecha_expiracion)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td>Plazo:</td>
                        <td>{{$caso->c_plazo}} días</td>
                    </tr>
                </tbody>
            </table>
            <h3 class="h5 my-3">Banco y moneda</h3>
            <table class="table">
                    <tbody>
                        <tr>
                            <td>Entidad financiera:</td>
                            <td>{{$caso->banco}} | Cantidad:  {{$caso->c_cantidad}}  {{ $caso->moneda }}</td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="h5 my-3">Delito y modalidad</h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Delito y modalidad:</td>
                            <td>{{$caso->delito}} / {{ $caso->modalidad }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
            <h3 class="h5 my-3">Personas involucradas</h3>
            @if(count($personas) > 0)
            <table class="table">
                <tbody>
                        @foreach($personas as $p)
                        <tr>
                            <td>
                            @if($p->situacion == 1)
                                <span class="badge badge-success">Denunciante</span>
                            @else
                                <span class="badge badge-danger">Investigado</span>
                            @endif
                            </td>
                            <td>
                            <a href="{{ route('personas') }}?show={{ base64_encode(Crypt::encryptString($p->p_person_id)) }}" class="btn btn-light"><i class="bi bi-person-fill"></i> {{$p->p_nombres}} {{$p->p_paterno}}  {{ $p->p_materno }}</a>
                            </td>
                            <td>
                            <span class="badge badge-light">{{ $p->p_tipo_documento }}</span> {{ $p->p_documento }}
                            </td>
                        </tr>
                        @endforeach
                
                    </tbody>   
                </table>
                @else   

                <p>No existen personas vinculadas a este caso.</p>
                        
                @endif  
            </div>
        </div>
    </div>

</div>


</div>

