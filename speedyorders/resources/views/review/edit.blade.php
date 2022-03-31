@extends('layouts.main')

@section('ext_css')

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="boxed">
            <div class="boxed-wrapper">
            <div class="hpanel">
                <div class="panel-heading">
                    Edit Review
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

                <form method="POST" action="{{ route('.review.update',[$review->id]) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <br>
                        <div class="hr-line-dashed"></div>
                        @include ('Review::form', ['formMode' => 'edit'])

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ext_js')


@endsection
