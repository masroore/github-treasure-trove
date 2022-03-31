@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<div class="row">
    <div class="col-md-10">
        <div class="hpanel">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Add category</h4>
            </div>
            <div class="panel-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.categories.store') }}" class="form-horizontal" enctype="multipart/form-data" id="createProductForm">
                    @csrf

                    @include ('admincategory::form', ['formMode' => 'create'])

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('ext_js')

<script src="{{asset('/vendor/ckeditor/ckeditor.js')}}"></script>

<script>
    CKEDITOR.replace( 'return_policy' );
    CKEDITOR.replace( 'description' );
</script>
@endsection



