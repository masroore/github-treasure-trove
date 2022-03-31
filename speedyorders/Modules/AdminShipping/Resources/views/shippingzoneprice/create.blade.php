@extends('layouts.main')

@section('ext_css')
    <style>
        ol {
            padding-left: 10px;
        }

        li {
            padding-bottom: 10px;
        }

    </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="boxed">
            <div class="boxed-wrapper">
            <div class="hpanel">
                <form method="POST" action="{{ route('admin.zoneprice.store') }}" class="form-horizontal"
                enctype="multipart/form-data" id="createzonepriceForm">
                @csrf
        <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <h5><strong> Create Zone Price</strong> </h5>
                            </div>
                            <div class="col-md-4 pull-right text-right">
                                <a class="btn btn-danger" href="{{ route('admin.zoneprice.index') }}">Cancel</a>
                                <button class="btn btn-success" type="submit">Create</button>
                            </div>
                        </div>
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
                        @include ('adminshipping::shippingzoneprice.form', ['action' => 'create'])
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ext_js')
@endsection
