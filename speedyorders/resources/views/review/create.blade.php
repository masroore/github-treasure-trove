@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<div class="row">

    <div class="col-md-9">
        <div class="boxed">
            <div class="boxed-wrapper">
        <div class="hpanel">
            <div class="panel-heading">
                <h4 class="panel-title">Add Review</h4>
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

            <form method="POST" action="{{ route('.review.store') }}" class="form-horizontal" enctype="multipart/form-data" id="createProductForm">
                    @csrf

                    @include ('Review::form', ['formMode' => 'create'])

                </form>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

@section('ext_js')


@endsection


