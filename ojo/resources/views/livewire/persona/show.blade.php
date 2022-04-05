
<h4 class="mb-5">Información de persona</h4>

@if (session()->has('message'))
        <div class="alert alert-warning">
            {{ session('message') }}
        </div>
 @endif
 



@include('livewire.persona.elementos')


<div class="card">
    <div class="card-header">
    
    <h2>{{ $denunciante->p_nombres }} {{ $denunciante->p_paterno }}  {{ $denunciante->p_materno }}</h2>
    </div>
    <div class="card-body">
    <div class="row">
        <div class="col-md-2">
            @if($denunciante->p_img)
            <img src="{{ Storage::url($denunciante->p_img) }}" alt="{{ $denunciante->p_nombres }} {{ $denunciante->p_paterno }}  {{ $denunciante->p_materno }}" class="img-fluid rounded">
            @else
            <div class="bg-secondary card-img h-100"></div>
            @endif
        </div>
        <div class="col-md-5">
            <h5 clas="pb-4">Datos personales</h5>

                <table class="table">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">Nombres</td>
                            <td>{{ $denunciante->p_nombres }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Apellido paterno</td>
                            <td>{{ $denunciante->p_paterno }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Apellido materno</td>
                            <td>{{ $denunciante->p_materno }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Documento de identidad</td>
                            <td>
                                <span class="badge badge-secondary"> {{ $denunciante->tipo_documento}}</span> <br>
                                {{ $denunciante->p_numero_documento}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Ubicación</td>
                            <td>
                                {{ $denunciante->p_pais}}  {{ $denunciante->p_region}}  {{ $denunciante->p_provincia}} {{ $denunciante->p_distrito}}
                                <br>
                                {{ $denunciante->p_direccion }}
                            </td>
                        </tr>
                        <tr>
                            <td><span class="font-weight-bold"> Edad :</span> {{ $denunciante->p_edad }} </td>
                            <td><span class="font-weight-bold"> Sexo :</span> @if($denunciante->p_sexo==0) Mujer @else  Hombre @endif</td>
                        </tr>
                    </tbody>
                </table>
        </div>
        <div class="col-md-5">
        <h5 clas="pb-4">Casos</h5>

            <table class="table">
                <thead>
                    <th>Fiscalia</th>
                    <th>Carpeta fiscal</th>
                    <th>Flagrancia</th>
                    <th>Banda</th>
                    <th>Situación</th>
                </thead>
                <tbody>
                        <tr>
                            <td>
                                {{$denunciante->c_fiscalia}}
                            </td>
                            <td>
                                {{$denunciante->c_carpeta_fiscal}}
                            </td>
                            <td>
                                @if($denunciante->c_isFlagrancia == 1)
                                Si
                                @else
                                No
                                @endif
                               
                            </td>
                            <td>
                                @if($denunciante->c_isBanda)

                                    {{$denunciante->c_banda}}
                                @else

                                No 
                                
                                @endif
                            </td>
                            <td>
                                @if($denunciante->c_situacion == 1)

                                <div class="badge badge-success">Denunciante</div>
                                @else 

                                <div class="badge badge-danger">Investigado</div>

                                @endif
                            </td>
                        </tr>
                </tbody>
            </table>

        <h5 clas="pb-4">Co-investigados</h5>

        </div>
    </div>
  
    </div>
</div>   

<div class="card">
    <div class="card-body">
    @include('livewire.persona.mostrarElementos')
    </div>
</div>