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
        <div class="card bg-lp">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    @foreach ($categories->chunk(3) as $items)
                        <div class="row">
                            @foreach ($items as $grupo)
                            <div class="col-12 col-md-4">
                                <a href="{{route('package.create').'/?category='.$grupo->id}}">
                                    <div class="card">
                                        <div class="card-content">
                                            <img class="card-img-top img-fluid" src="{{asset('media/'.$grupo->img)}}" alt="{{$grupo->name}}">
                                            <div class="card-body">
                                                <h4 class="card-title">{{$grupo->name}}</h4>
                                                <h5>Crea nuevo <br> Paquete Aqui</h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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
