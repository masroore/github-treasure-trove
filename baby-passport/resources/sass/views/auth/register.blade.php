@extends('layouts.app')


@section('title')
    <title>BabyPassport | Regístrate con nosotros </title>
@endsection

@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('content')



    <section class="register view" style="background-image: url({{asset('/img/miscellaneous/bg_register.jpg')}})">

        <div class="mask rgba-pink-strong"></div>

        <div class="row justify-content-center px-3 px-md-0">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card rgba-white-strong ">
                    <div class="card-body p-5">
                        @include('auth._partials.register_fields',[
                                    'userType'              => 'pacient',
                                    'userTypeDescription'   => 'Bienvenida mamá'
                                ])
                    </div>
                </div>
            </div>
        </div>


    </section>



@endsection


@section('custom_scripts')
    <script src="{{asset(mix('/js/web/register.js'))}}"></script>
@endsection()

@section('footer')
    @include('_partials/footer',["background"=>"bg-ce-soir","button"=>"mandys-pink"])
@endsection
