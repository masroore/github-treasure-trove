@extends('layouts.homepage')
@section('content')
    <!-- START SECTION ABOUT -->
    <section class="about-us fh m-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 who-1">
                    <div>
                        <h2 class="text-left mb-4">About <span>Find Houses</span></h2>
                    </div>
                    <div class="pftext">
                        @foreach ($about as $item)
                            <p>{!! $item->description !!}</p>
                        @endforeach

                    </div>
                    <div class="box bg-2">
                        <img src="{{ asset('images/signature.png') }}" class="ml-5" alt="">
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- END SECTION ABOUT -->
@endsection
