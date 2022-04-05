@extends('layouts.app')

@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection

@section('title')
    <title>Baby Passport | Contratación</title>
@endsection


@section('content')

    <div class="container py-5">

        <img class="img-fluid shadow" src="{{asset('img/miscellaneous/checklist-fisica.jpeg')}}" alt="">
    </div>

@endsection



@section('footer')
    @include('_partials/footer',["background"=>"bg-ce-soir","button"=>"btn-mandys-pink"])
@endsection

