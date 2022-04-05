@extends('layouts.panel')

@section('sectionTitle')
    <h1>Artículos Blog</h1>

@endsection()



@section('content')

    @include('panel/categories/modal')

    <div class="container">

        <div class="row">
            <div class="col-12">
                <h2 class="text-ce-soir mb-3">
                    Blogs
                    <a href="{{route('blogs.create')}}"
                       class="btn btn-ce-soir  float-right clearfix"
                       id="openBlogModal">
                        <i class="fas fa-plus"></i> Nuevo
                    </a>
                </h2>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
                <label for="">Categoría</label>
                {{Form::select('',$categorySelect,null,["class"=>"form-control",'id'=>"categorySelect",'placeholder'=>"Ver todas"])}}

            </div>
        </div>

        {!! $dataTable->table(['width' => '100%']) !!}
    </div>

@endsection

@section('custom_scripts')


    {!! $dataTable->scripts() !!}

    <script type="text/javascript" src="{{asset(mix('js/panel/blog.js'))}}"></script>
@endsection()