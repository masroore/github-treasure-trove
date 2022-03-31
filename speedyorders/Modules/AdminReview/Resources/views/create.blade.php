@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

    <div class="row">
        <div class="col-md-9">
            <div class="boxed">
                <div class="boxed-wrapper">
                    <div class="hpanel">
                        <form method="POST" action="{{ route('admin.reviews.store') }}" class="form-horizontal"
                            enctype="multipart/form-data" id="createProductForm">
                            @csrf
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-3">
                                        <h5><strong>Create Review</strong> </h5>
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

                                @include ('adminreview::form', ['formMode' => 'create'])

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('ext_js')


@endsection
