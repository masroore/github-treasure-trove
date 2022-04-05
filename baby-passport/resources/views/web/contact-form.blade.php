@extends('layouts.app')

@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('title')
    <title>Baby Passport | Compártenos tus dudas sobre como tener a tu bebé en Estados Unidos de forma legal</title>
@endsection

@section('content')

    <div class="pt-250 pt-250 p-5 pb-lg-5 bg-lola">

        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">


                @include('_partials/error_handling',["variable"=>'success',"color"=>"success"])
                @include('_partials/error_handling',["variable"=>'error',"color"=>"danger"])

                <div class="card btn-full-rounded mt-4">
                    <div class="card-body">
                        <h2 class="text-ce-soir card-title text-center">Contáctate con nosotros</h2>

                        <form action="{{route('web.postContactForm')}}" method="POST">


                        @csrf
                        <!--NAME -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control btn-full-rounded" name="name">
                                @include('_partials/field_error_handling',["fieldName"=>"name"])
                            </div>
                            <!-- END NAME -->

                            <!--PHONE -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Teléfono</label>
                                <input type="text" class="form-control btn-full-rounded" name="phone">
                                @include('_partials/field_error_handling',["fieldName"=>"phone"])

                            </div>
                            <!-- END PHONE -->

                            <!--EMAIL -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Correo electrónico</label>
                                <input type="email" class="form-control btn-full-rounded" name="email">
                                @include('_partials/field_error_handling',["fieldName"=>"email"])

                            </div>
                            <!-- END EMAIL -->

                            <!--PREGNANCY WEEK -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Semana de Embarazo</label>
                                <select class="form-control btn-full-rounded" name="pregnancy_week">
                                    @for ($i = 1; $i <= 37; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>


                                @include('_partials/field_error_handling',["fieldName"=>"pregnancy_week"])

                            </div>
                            <!-- END PREGNANCY WEEK -->

                            <!--PREGNANCY WEEK -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tema</label>
                                <select class="form-control btn-full-rounded" name="theme">
                                    <option value="Legal">Legal</option>
                                    <option value="Logistico">Logístico</option>
                                </select>


                                @include('_partials/field_error_handling',["fieldName"=>"pregnancy_week"])

                            </div>
                            <!-- END PREGNANCY WEEK -->

                            <!--QUESTION -->
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pregunta</label>
                                <textarea class="form-control btn-full-rounded" name="question"></textarea>
                                @include('_partials/field_error_handling',["fieldName"=>"question"])

                            </div>
                            <!-- END QUESITON -->


                            <div class="form-row text-center">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-ce-soir btn-full-rounded p-3 ">
                                        <i class="fas fa-envelope"></i> Enviar
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('footer')
    @include('_partials/footer',["background"=>"bg-mandys-pink","button"=>"btn-ce-soir"])
@endsection
