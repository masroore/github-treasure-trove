@extends('layouts.dashboard')

@section('page-title', __('Service List'))
@section('page-heading', __('Service List'))

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

    @include('service.partials.table')

@stop

@section('scripts')

    <script>
        (function($) {
            'use strict';
            $(function() {
                $('#service-listing').DataTable({
                    "aLengthMenu": [
                        [5, 10, 15, -1],
                        [5, 10, 15, "All"]
                    ],
                    "iDisplayLength": 10,
                    "language": {
                        search: ""
                    }
                });
                $('#service-listing').each(function() {
                    var datatable = $(this);
                    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                    var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                    search_input.attr('placeholder', 'Search');
                    search_input.removeClass('form-control-sm');
                    // LENGTH - Inline-Form control
                    var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                    length_sel.removeClass('form-control-sm');
                });
            });

        })(jQuery);
    </script>
    <script src="/assets/corona/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="/assets/corona/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>


@stop
