@extends('layouts.panel')
@section('navbar')
    @include("_partials/navbar",["color"=>"ce-soir","logo"=>"9a7aa0"])
@endsection


@section('title')
    {!! SEO::generate() !!}
@endsection

@section('content')


    @include("_partials/hospital_profile/confirm_appointment")


    <div class="container py-5">


        @include("_partials/error_handling",["variable"=>"error","color"=>"danger"])

        <div class="row flex justify-content-center">
            <div class="col-12 col-lg-4">
                <img
                        src="{{asset('storage/hospitals/'.$hospital->photo)}}"
                        alt="Baby Passport hospital {{$hospital->name}}"
                        class="img-fluid d-block mx-auto rounded shadow">


            </div>
            <div class="col-12 col-lg-8 pl-0 pl-lg-5">

                <h2 class="text-center text-lg-left text-ce-soir font-weight-bold mb-0">{{$hospital->name}}</h2>

                <div class="d-block mt-2">
                    @for($i=0;$i<$hospital->rating->star_number;++$i)
                        <i class="fas fa-star text-selective-yellow"></i>
                    @endfor
                </div>


                <p class="text-muted text-grey-suit text-justify mt-3">{{$hospital->about}}</p>

                <table class="table mt-5">
                    <tbody>
                    <tr class="border-ce-soir">
                        <th scope="row" class="align-middle">Especialidades</th>
                        <td class="text-muted">
                            @foreach ($hospital->hospitalProfile->where('type','speciality') as $speciality)
                                <p>
                                    <i class="fas fa-angle-double-right text-lola mr-2"></i>
                                    {{$speciality->detail}}
                                </p>
                            @endforeach
                        </td>
                    </tr>


                    <tr>
                        <th scope="row" class="align-middle">Experiencia</th>
                        <td class="text-muted">
                            @foreach ($hospital->hospitalProfile->where('type','experience') as $experience)
                                <p>
                                    <i class="fas fa-angle-double-right text-lola mr-2"></i>
                                    {{$experience->detail}}
                                </p>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>


        {!! $calendar->calendar() !!}

    </div>
@endsection




@section('footer')
    @include('_partials/footer',["background"=>"bg-ce-soir","button"=>"btn-mandys-pink"])
@endsection

@section('custom_styles')

@endsection

@section("custom_scripts")
    {!! $calendar->script() !!}
    <script src="{{asset(mix('js/web/hospital.profile.js'))}}"></script>

@endsection
