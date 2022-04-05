@extends('layouts.panel')

@section('sectionTitle')
    <h1>Perfil de Usuario</h1>

@endsection()



@section('content')

    <div class="container">
        <h2 class="h2-responsive text-ce-soir mb-5">  {{$user->name}}</h2>

        <ul class="nav nav-tabs profile-tab" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                   aria-selected="true">Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                   aria-controls="profile"
                   aria-selected="false">Paquete de Maternidad</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                   aria-controls="contact"
                   aria-selected="false">Plan de Pagos</a>
            </li>
        </ul>

    </div>



    {{--
        <div class="container user-profile">

            <h2 class="text-center my-3 text-ce-soir">
                <i class="fa user"></i> {{$user->name}}
            </h2>

            <div class="row justify-content-center mb-3">
                <div class="col-12 col-md-10">
                    @include("panel.users.profile_cards.info")
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-md-10">

                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    @include("panel.users.profile_cards.preregister")
                </div>
            </div>


        </div>
    --}}
@endsection

