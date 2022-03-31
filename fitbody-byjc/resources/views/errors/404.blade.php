@extends('errors.container')

@section('content')
    <div id="page-container" class="main-content-boxed">
        <main id="main-container">
            <div class="hero bg-white bg-pattern" style="background-image: url({{ asset('media/various/bg-pattern-inverse.png') }});">
                <div class="hero-inner">
                    <div class="content content-full">
                        <div class="py-30 text-center">
                            <i class="si si-magnifier text-danger display-3"></i>
                            <h1 class="h2 font-w700 mt-30 mb-10">Your request has not been found!</h1>
                            <h2 class="h3 font-w400 text-muted mb-50">Please review your request or cope with the fact it's simply not there!..</h2>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
