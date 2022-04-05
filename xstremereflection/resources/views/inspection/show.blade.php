@extends('layouts.dashboard')

@section('page-title', __('Vehicle Inspection'))
@section('page-heading', __('Vehicle Inspection'))

@section('styles')
<style>
    /* Thick red border */
    hr.new4 {
        border: 1px solid red !important;
    }
</style>

@stop

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('Inspection')
    </li>
@stop

@section('content')
    @include('partials.messages')
    <div class="row mb-3">

    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Hood</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Roof</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Trunk / Bed / Rear</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Drivers Quarter Panel</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Drivers Door</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Drivers Rear Door</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Drivers Rear Quarter Panel</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Passenger Quarter Panel</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Passenger Door</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Passenger Rear Door</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-lg-3">
                    <h1>Passenger Rear Quarter Panel</h1>
                </div>
                <div class="col-lg-8">
                    <hr style="border: 1px solid darkblue">
                </div>
                <div class="col-lg-1">
            <span style="font-size: 3em; color: darkblue;">
              <a><i class="fas fa-plus-circle"></i></a>
            </span>
                </div>
            </div>

            <div class="row">
                <ol>
                    <li>No Abnormalities</li>
                </ol>
            </div>
        </div>
    </div>

@stop
@include('estimate.partials.modalStatusUpdate')
@section('scripts')


@stop


