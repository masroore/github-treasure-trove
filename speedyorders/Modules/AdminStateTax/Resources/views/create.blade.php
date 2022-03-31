@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<div class="row">
    <div class="col-md-10">
        <div class="hpanel">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Add State Tax</h4>
            </div>
            <div class="panel-body">
            
            <form method="POST" action="{{ route('admin.reports.tax.store') }}" class="form-horizontal" enctype="multipart/form-data" id="createProductForm">
                    @csrf

                    @include ('adminstatetax::form', ['formMode' => 'create'])

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



