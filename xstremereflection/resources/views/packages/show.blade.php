@extends('layouts.dashboard')

@section('page-title', __('Package'))
@section('page-heading', __('Package'))

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Package')
    </li>
@stop

@section('content')
    @include('partials.messages')

    <div class="row">
        <div class="col-cl-12">
            <h1>{{$package->description ?? ''}} Package</h1>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="card-body">
            <h5 class="card-title">Package Description</h5>
            <ul class="list-group">
                <p class="card-text">{!! $package->details ?? '' !!}</p>

            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                @include('packages.partials.availableServices')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="row mb-2">
                <div class="col-xl-12">
                    <div class="card">
                        @include('packages.partials.otherPackages')
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-xl-12">
                    <div class="card">
                        @include('packages.partials.upsale')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                @include('packages.partials.packageServices')
            </div>
        </div>
    </div>

@stop
@include('packages.partials.modalServices')
@include('packages.partials.modalIncludedPackage')
@include('packages.partials.modalUpsale')
@section('scripts')
    @include('partials.messages2')
@stop
