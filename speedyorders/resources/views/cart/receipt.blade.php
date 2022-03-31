@extends('layouts.frontend')

@section('content')

<div class="container">
    @include('includes.cart_links')
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="mb-4">Thank you for your order!</h1>
             @if ($sucess)
                <div class="alert alert-success text-center">                   
                    <p>{{ $sucess }}</p>
                </div>
                
            @endif
        </div>
        <div class="col-md-10 col-lg-3 mx-auto">
            <a href="{{route('store')}}" target="_self"><button type="button" class="btn btn-warning  btn-lg btn-block">Continue Shopping</button></a>
        </div>
    </div>
</div>

@endsection