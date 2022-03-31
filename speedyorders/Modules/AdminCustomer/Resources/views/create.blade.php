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
                <form method="POST" action="{{ route('admin.customers.store') }}" class="form-horizontal"
                enctype="multipart/form-data" id="createCustomerForm">
                @csrf
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <h5><strong> Create Customer</strong> </h5>
                            </div>
                            <div class="col-md-4 pull-right text-right">
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
                        @include ('admincustomer::form', ['action' => 'create'])
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('ext_js')

@endsection
