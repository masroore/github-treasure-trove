@extends('layouts.panel')

@section('sectionTitle')
    <h1>Productos</h1>

@endsection()



@section('content')

    @include('panel/products/modal')

    <div class="container">

        <div class="row">
            <div class="col-12">
                <h2 class="text-ce-soir mb-3">
                    Productos
                    <button class="btn btn-ce-soir text-white  float-right clearfix" id="openProductModal">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </h2>
            </div>

        </div>




        {!! $dataTable->table(['width' => '100%']) !!}
    </div>

@endsection

@section('custom_scripts')


    {!! $dataTable->scripts() !!}

    <script type="text/javascript" src="{{asset(mix('js/panel/product.js'))}}"></script>
@endsection()