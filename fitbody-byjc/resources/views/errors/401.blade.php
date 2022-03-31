@extends('errors.container')

@section('content')
    <div id="page-container" class="main-content-boxed">
        <main id="main-container">
            <div class="hero bg-white bg-pattern" style="background-image: url({{ asset('media/various/bg-pattern-inverse.png') }});">
                <div class="hero-inner">
                    <div class="content content-full">
                        <div class="py-30 text-center">
                            <i class="si si-ban text-danger display-3"></i>
                            <h1 class="h2 font-w700 mt-30 mb-10">Unauthorized for this!</h1>
                            <h2 class="h3 font-w400 text-muted mb-50">Please go back or we will review your status on this site!</h2>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
