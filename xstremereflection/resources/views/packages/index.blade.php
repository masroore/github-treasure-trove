@extends('layouts.dashboard')

@section('page-title', __('Packages'))
@section('page-heading', __('My Packages'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Dashboard')
</li>
@stop

@section('content')
@include('partials.messages')

<div class="row mb-4">
    <div class="col-xl-4">
        <a href=";javascript" data-toggle="modal" data-target="#newPackageModal"><button class="btn btn-primary btn-block">Create New Package</button></a>
    </div>
</div>
<div class="row">
    @include('packages.partials.package')
</div>

@stop
@include('packages.partials.modalNewPackage')
@section('scripts')

    <script>
        $('#newPackageModal').on('shown.bs.modal', function (){

            $('#summernote').summernote({
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
                tabsize: 2,
                height: 50
            });

                $('.select').select2({
                    dropdownParent: $('#newPackageModal .modal-content'),
                    theme: "bootstrap"
                });

        });
    </script>
@stop
