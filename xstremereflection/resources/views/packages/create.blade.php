@extends('layouts.dashboard')

@section('page-title', __('New Package'))
@section('page-heading', __('New Packages'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Package')
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-lg-10">
            @include('packages.partials.form')
        </div>
    </div>


@stop

@section('scripts')




@stop
