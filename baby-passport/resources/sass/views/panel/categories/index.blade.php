@extends('layouts.panel')

@section('sectionTitle')
    <h1>Categorías para Blog</h1>

@endsection()



@section('content')

    @include('panel/categories/modal')

    <div class="container">

        <div class="row">
            <div class="col-12">
                <h2 class="text-ce-soir mb-3">
                    Categorías
                    <button class="btn btn-ce-soir  float-right clearfix" id="openCategoryModal">
                        <i class="fas fa-plus"></i> Nueva
                    </button>
                </h2>
            </div>

        </div>
        {!! $dataTable->table(['width' => '100%']) !!}
    </div>

@endsection

@section('custom_scripts')


    {!! $dataTable->scripts() !!}

    <script type="text/javascript" src="{{asset(mix('js/panel/category.js'))}}"></script>
@endsection()