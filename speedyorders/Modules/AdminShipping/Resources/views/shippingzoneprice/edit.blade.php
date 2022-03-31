@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="boxed">
            <div class="boxed-wrapper">
            <div class="hpanel">
                <form method="POST" id="updatezonepriceForm" action="{{ route('admin.zoneprice.update', [$zoneprice->id]) }}" accept-charset="UTF-8"
                    class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <h5><strong> Edit Zone Price</strong> </h5>
                            </div>
                            <div class="col-md-4 pull-right text-right">
                                <a class="btn btn-danger" href="{{ route('admin.zoneprice.index') }}">Cancel</a>
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="zoneprice_id" id="zoneprice_id" value="{{$zoneprice->id}}">
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
                        @include ('adminshipping::shippingzoneprice.form', ['action' => 'edit'])
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ext_js')

@endsection
