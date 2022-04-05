@extends('layouts.panel')

@section('sectionTitle')
    <h1>Publicidad</h1>

@endsection()



@section('content')



    <div class="container">

        <div class="row">
            <div class="col-12">
                <h2 class="text-ce-soir mb-3">
                    Posts Publicitarios
                    <a href="{{route('ads.create')}}"
                       class="btn btn-ce-soir  float-right clearfix">
                        <i class="fas fa-plus"></i> Nuevo Ad
                    </a>
                </h2>
            </div>
        </div>


        {!! $dataTable->table(['width' => '100%']) !!}
    </div>

@endsection

@section('custom_scripts')


    {!! $dataTable->scripts() !!}

    <script type="text/javascript" src="{{asset(mix('js/panel/ads.js'))}}"></script>
@endsection()
