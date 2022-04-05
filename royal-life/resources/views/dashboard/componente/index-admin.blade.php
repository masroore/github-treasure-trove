<div class="row mt-1">
    <div class="col-12">

    @include('dashboard.componente.partials.tranding-view')

        <div class="row" id="dashboard-analytics">
            <div class="col-sm-6 col-12 mt-1">
                <div class="card h-80 p-2 art-2">

                    <div class="float-right d-flex">
                        <img class="float-right" src="{{ asset('assets/img/icon/money.svg') }}" alt="">
                    </div>

                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <h2 class="mt-1 mb-0 text-white" style="text-shadow: black 0.1em 0.1em 0.2em;"><b>Saldo disponible</b></h2>
                    </div>
                    <div class="card-sub d-flex align-items-center">
                        <h1 class="text-white mb-0"><b style="text-shadow: black 0.1em 0.1em 0.2em;">$ {{Auth::user()->saldoDisponible()}}</b></h1>
                    </div>

                    <div class="card-header d-flex align-items-center mt-3">
                        <button class="btn btn-dark rounded-0" data-toggle="modal" data-target="#modalSaldoDisponible"><b>RETIRAR</b></button>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-12 mt-1">
                <div class="card h-80 p-2" style="background: #173138; height: 90%;">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <h2 class="mt-1 mb-0 text-white"><b>Ganacia Actual</b></h2>
                    </div>

                    <div class="card-sub d-flex align-items-center ">
                        <h1 class="gold text-bold-700 mb-0"><b>$ {{Auth::user()->gananciaActual()}}</b></h1>
                    </div>

                    <div class="d-flex align-items-center">

                        <div class="progress ml-2 mt-5" style="height: 25px;width: 100%;">
                            <div id="bar" class="progress-bar active" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100" style="width: {{Auth::user()->progreso()}}%">
                            </div>
                        </div>

                        <div class="card-sub d-flex align-items-center ">
                            <p class="text-bold-700 mb-0 text-white">{{number_format(Auth::user()->progreso() * 2,2)}}% </p>
                        </div>

                    </div>

                    <div class="card-sub align-items-center mt-0 ">
                        <h6 class="text-bold-700 mb-0 text-white"><b>Activo {{Auth::user()->fechaActivo()}}</b></h6>
                    </div>

                </div>
            </div>



            <div class="col-sm-6 col-md-4 col-12 mt-1">
                <div class="card py-2" style="background: #173138; height: 230px;">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <h5 class="mt-1 mb-0 text-white"><b>Link de referido</b></h5>
                    </div>

                    <div class="card-sub d-flex align-items-center ">
                        <h2 class="gold text-bold-700 mb-0">INVITA A<br>PERSONAS<br></h2>
                    </div>
                    <div class="card-header d-flex align-items-center white mt-2">
                        <button class="btn-darks btn-block" style="boder-color=#66FFCC; position: //" onclick="getlink('{{Auth::user()->binary_side_register}}')"><b>LINK DE
                                REFERIDO <i class="fa fa-copy"></i></b></button>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-4 col-12 mt-1">
                <div class="card pt-2 h-80" style="background: #173138; height: 230px;">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <h5 class="mt-1 mb-0 text-white"><b>Lado Binario</b></h5>
                    </div>

                    <div class="card-sub d-flex align-items-center ">
                        <h1 class="gold text-bold-700 mb-0">
                            @if (Auth::user()->binary_side_register == 'I')
                            IZQUIERDA
                            @else
                            DERECHA
                            @endif
                        </h1>
                    </div>
                    <div class="row no-gutters card-header align-items-center h-100">

                        @if (Auth::user()->binary_side_register == 'I')
                            <div class="col">     
                                <a href="#"
                                    class="btn btn-primary btn-block padding-button-short mt-1 waves-effect waves-light text-white"
                                    v-on:click="updateBinarySide('I')">
                                    IZQUIERDA
                                </a>
                            </div>
                            <div class="col">
                                <a href="#"
                                    class="btn btn-block btn-outline-warning padding-button-short mt-1 waves-effect waves-light text-white"
                                    v-on:click="updateBinarySide('D')" style="height: 44.78px">
                                    DERECHA
                                </a>
                            </div>
                        @else
                                <div class="col">
                                    <a href="#"
                                        class="btn btn-block btn-outline-warning padding-button-short mt-1 waves-effect waves-light text-white"
                                        v-on:click="updateBinarySide('I')">
                                        IZQUIERDA
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="#"
                                        class="btn btn-block btn-primary padding-button-short mt-1 waves-effect waves-light text-white"
                                        v-on:click="updateBinarySide('D')" style="height: 44.78px">
                                        DERECHA
                                    </a>
                                </div>
                            
                        @endif


                    </div>
                </div>
            </div>

            
            <div class="col-sm-6 col-md-4 col-12 mt-1">
                <div class="card p-2" style="background: #173138; height: 230px;">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <h5 class="mt-1 mb-0 text-white"><b>Paquete de inversión</b></h5>
                    </div>

                    <div class="card-header d-flex align-items-center mb-2 justify-content-center">
                        <img class="text-center" src="{{Auth::user()->inversionMasAlta() != null ?Auth::user()->inversionMasAlta()->getPackageOrden->img() : asset('assets/img/royal_green/logos/logo.svg')}}" alt=""
                            style="width: @if(Auth::user()->inversionMasAlta() == null)70% @else 62% @endif; margin-top: -15px;">
                    </div>

                </div>
            </div>
        </div>
    </div>

            <div class="col-sm-6 col-12 mt-1">
                <div class="card h-100 p-2" style="background: #173138;">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <h5 class="mt-1 mb-0 text-white"><b>Total de ventas</b></h5>
                    </div>
                        @include('dashboard.componente.partials.grafig-1')
                </div>
            </div>


            <div class="col-sm-6 col-12 mt-1">
                <div class="card h-100" style="background: #173138;">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <p class="mt-1 mb-0">Proximo rango -> {{$data['rangos']['name_rank_sig']}}</p>
                    </div>

                    <input type="hidden" id="idrango"
                    value="{{(Auth::user()->rank_id == null) ? 0 : Auth::user()->rank_id}}">
                    <div class="card-header d-flex align-items-center mb-2 carrusel_rango">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/royal_green/rangos/sin_rango.svg') }}" alt="" height="200" class="m-auto">
                            <h3 class="text-white mb-0">
                                <strong>Sin Rango</strong>
                            </h3>
                        </div>
                        @foreach ($data['rangos']['ranks'] as $rango)
                        <div class="text-center">
                            <img src="{{$rango->img}}" alt="" height="200" class="m-auto">
                            <h3 class="text-white mb-0">
                                <strong>{{$rango->name}}</strong>
                            </h3>
                        </div>
                        @endforeach
                    </div>

                    <div class="card-header d-flex align-items-center mb-2 ">
                        <img src="{{asset('assets/img/Line28.svg')}}" alt="" style="width: 100%;" height="1">
                    </div>

                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <p class="mt-1 mb-0">total de puntos:</p>
                    </div>

                    <div class="card-sub d-flex align-items-center ">
                        <h2 class="gold text-bold-700 mb-0">{{$data['rangos']['puntos']}}</h2>
                    </div>

                    <div class="d-flex align-items-center">
                        <div class="progress ml-2" style="height: 25px;width: 80%;">
                            <div id="bar" class="progress-bar active" role="progressbar" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100" style="width: {{$data['rangos']['porcentage']}}%">
                                <span class="sr-only">{{$data['rangos']['porcentage']}}% Complete</span>
                            </div>
                        </div>
                        <div class="card-sub d-flex align-items-center ">
                            <p class="white text-bold-700" style="margin-top: -30px;">{{$data['rangos']['porcentage']}}% </p>
                        </div>
                    </div>
                    <div class="card-sub">
                        <p class="white text-bold-700" style="margin-top: -50px;">proximo rango = {{$data['rangos']['puntos_sig']}} </p>
                    </div>
                </div>
            </div>

            {{----}}

            <div class="col-12 mt-1 mb-3">
                <div class="card h-100 p-2" style="background: #173138;">
                    <div class="card-header d-flex align-items-center text-right pb-0 pt-0 white">
                        <h5 class="mt-1 mb-0 text-white mb-2"><b>Precio de las acciones</b></h5>
                    </div>

                    @include('dashboard.componente.partials.tranding-view-btc')

                </div>
            </div>
        </div>
    </div>
</div>


