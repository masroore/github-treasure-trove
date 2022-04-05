@extends('layouts.dashboard')

@push('vendor_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('assets/app-assets/vendors/js/extensions/polyfill.min.js')}}"></script>
@endpush


@section('content')
<div id="adminServices">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <div class="m-2">
                        <a href="{{route('shop')}}" class="btn btn-primary"> Volver a los Grupos</a>
                    </div>
                    @foreach ($package->chunk(3) as $items)
                        <div class="row">
                            @foreach ($items as $product)
                            <div class="col-12 col-md-4">
                                <div class="card border-success text-center bg-transparent">
                                    <div class="card-content d-flex">
                                        <div class="card-body">
                                            <h4 class="card-title">{{$product->name}}</h4>
                                            <p class="card-text">{{$product->description}}</p>
                                            <p class="card-text">Fecha Vencimiento: <br> {{date('d-m-Y', strtotime($product->expired))}}</p>
                                            <form action="{{route('shop.procces')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="idproduct" value="{{$product->id}}">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Comprar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
