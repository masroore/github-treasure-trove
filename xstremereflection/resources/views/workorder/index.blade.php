@extends('layouts.dashboard')

@section('page-title', __('Work Orders Active'))
@section('page-heading', __('Work Orders Active'))

@section('styles')
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/corona/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/corona/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
@stop

@section('breadcrumbs')
    <li class="breadcrumb-item active">
        @lang('New Invoice')
    </li>
@stop

@section('content')
    @include('partials.messages')

    @include('workorder.partials.table')

@stop

@section('scripts')

    <script src="/assets/corona/js/data-table.js"></script>
    <script src="/assets/corona/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="/assets/corona/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>

    <script>
        $('#statusUpdateModal').on('show.bs.modal', function (e){
            var id = $(e.relatedTarget).data('id');

            $('#statusUpdateForm').attr('action', "/estimate/"+ id +"/update");

        });
    </script>
@stop
