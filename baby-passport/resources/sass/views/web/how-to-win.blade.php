@extends('layouts.app')



@section('title')
    <title>Baby Passport | Como ganar con nosotros</title>
@endsection


@section('content')


    <!-- WIN CONTAINER -->
    <section class="win-container text-center">

        <h2 class="h2-responsive text-ce-soir">FINANZAS</h2>

        <h1 class="display-4 mt-3 text-ce-soir">Cómo ganas con Baby Passport</h1>


        <div class="row justify-content-center">
            <div class="col-10 col-lg-6">
                <p class="lead text-dark">
                    Con Baby Passport disfruta de una estrategia integral de atracción
                    de pacientes, software de historial médico y la libertad de recibir
                    pacientes en cualquier lugar.
                </p>
            </div>
        </div>


    </section>

    <!-- END WIN CONTAINER -->


    <!-- DISCOVER HOW MANY YOU CAN WIN -->
    <section class="container mb-5">

        <div class="row justify-content-center">


            <div class="col-12 col-lg-8 win-form p-5 shadow-lg ">

                <h3 class="h3-responsive text-center text-ce-soir">Descubre cuanto podrías ganar.</h3>

                <div class="row align-items-center mt-5">
                    <div class="col-12 col-md-7 px-md-5">

                        <!-- UBICACION -->
                        <div class="form-row">
                            <label for="" class="control-label">Ubicación</label>
                            {{Form::select('',['Tijuana','León','Culiacán','Guadalajara','Edo.Mexico'],null,['class'=>'form-control'])}}
                        </div>

                        <!-- AVG TICKET -->
                        <div class="form-row mt-3">
                            <label for="" class="control-label">Ticket Promedio</label>
                            {{Form::select('',['1-100 pacientes','100-200 pacientes','200-500 pacientes','+500 pacientes'],null,['class'=>'form-control'])}}
                        </div>

                    </div>
                    <div class="col-12 col-md-5 text-center mt-5 mt-lg-0">
                        <h3 class="display-4 font-weight-bold mb-0">$900.00</h3>
                        <p class="lead text-grey-suit">por semana</p>

                        <button class="btn btn-spray btn-lg  white-text btn-whats"> Comienza ahora</button>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <!-- END DISCOVER -->


    <div class="section-divider bg-spray my-5"></div>

    <h1 class="h1-responsive text-center text-ce-soir">
        Recibe pacientes de forma constante y sin complicaciones
    </h1>


    <p class="mt-3 lead text-dark text-center mb-5">
        Recibe nuevos pacientes de forma continua, en la fecha, hora
        y lugar que más te acomode.
    </p>

@endsection
