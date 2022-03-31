@extends('layouts.frontend')

@section('content')

<section class="container side-menu-page-template">
    <div class="row">
        <div class="col-md-9 col-xl-8 mx-lg-auto pl-md-5 order-2">
            <h1 class="d-none d-md-block page-title">{!! $title !!}</h1>
            
            {!! $content !!}

        </div>

       @include('includes.cms_links')    
    </div>
</section>

@endsection