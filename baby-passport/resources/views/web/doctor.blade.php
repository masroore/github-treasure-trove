@extends('layouts.app')

@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('title')
    <title>Baby Passport | Doctores</title>
@endsection

@section('content')

    <section class="pt-250 p-5 pb-lg-5 bg-lola ">
        <div class="container">
            <div class="row shadow flex-column-reverse flex-lg-row align-items-center justify-content-around bg-light rounded">

                <div class="col-12 col-lg-5 text-left p-5 pt-lg-0 pr-lg-0 pb-lg-0 pl-5">
                    <h2 class="text-ce-soir font-weight-bolder text-uppercase">
                        ¿Quieres ser uno de nuestros médicos aliados o referir pacientes?
                    </h2>

                    <p class="text-grey-suit mt-3 mb-5">
                        Déjanos tus datos y nosotros nos pondremos en contacto contigo o mándanos whatsapp.
                    </p>

                    <button class="btn btn-ce-soir btn-full-rounded text-light btn-whats font-medium" data-whatsapp="">
                        <i class="fab fa-whatsapp"></i> Hablar con un asesor
                    </button>
                </div>
                <div class="col-12 col-lg-7 px-0">
                    <img class="img-fluid rounded" src="{{asset('img/doctores/red.jpg')}}" alt="Red doctores"/>
                </div>
            </div>
        </div>


    </section>

@endsection



@section('footer')
    @include('_partials/footer',["background"=>"bg-ce-soir","button"=>"btn-mandys-pink"])
@endsection

