@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<div class="row">

    <div class="col-md-12">
        <div class="hpanel">
            <div class="panel-heading">
                Edit State Tax
            </div>
            <div class="panel-body">
            
            <form method="POST" action="{{ route('admin.reports.tax.update',[$tax->id]) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    @include ('adminstatetax::form', ['formMode' => 'edit'])

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

