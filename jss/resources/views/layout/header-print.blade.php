<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from 192.69.216.111/themes/preview/ace/ by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 10 Dec 2013 00:48:04 GMT -->
    <head>
        <meta charset="utf-8"/>
        <title>{{ t('Title') }}</title>

        <meta name="description" content="overview &amp; stats"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <!-- STYLES -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/bootstrap-overrides.css') }}" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ asset('/assets/css/font-awesome.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/assets/css/font-awesome-ie7.min.css') }}"/>
        <link href="{{ asset('/assets/css/chosen.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('/assets/css/colorbox.css') }}" />
        <link rel="stylesheet" href="{{ asset('/assets/css/theme.css?v=20211004104500') }}"/>
        <link rel="stylesheet" href="{{ asset('/assets/css/ace.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/assets/css/ace-rtl.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/assets/css/ace-skins.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/assets/css/jquery.gritter.css') }}" />
        <link rel="stylesheet" href="{{ asset('/assets/css/ace-ie.min.css') }}"/>
        <link href="{{ asset('/assets/css/datepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('/assets/css/bootstrap-timepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('/assets/css/daterangepicker.css') }}" rel="stylesheet">
        <link href="{{ asset('/assets/css/colorpicker.css') }}" rel="stylesheet">
        <link href="{{ asset('/assets/css/jquery-ui-1.10.3.full.min.css')}}" rel="stylesheet">
        <link href="{{ asset('/assets/css/jquery.treeview.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

        <!-- SCRIPTS -->
        <script src="{{ asset('/assets/js/ace-extra.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery-2.0.3.min.js') }}"></script>
        <script src="{{ asset('/assets/js/ace-elements.min.js') }}"></script>
        <script src="{{ asset('/assets/js/fuelux/fuelux.tree.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.treeview.js') }}"></script>
        <script src="{{ asset('/assets/js/bootbox.min.js') }}"></script>
        <script src="{{ asset('/assets/js/html5shiv.js') }}"></script>
        <script src="{{ asset('/assets/js/respond.min.js') }}"></script>
        <script src="{{ asset('/assets/js/excanvas.min.js') }}"></script>
        <script src="{{ asset('/assets/js/ace.min.js') }}"></script>
        <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/js/typeahead-bs2.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery-ui-1.10.3.full.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.ui.touch-punch.min.js') }}"></script>
        <script src="{{ asset('/assets/js/date-time/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('/assets/js/chosen.jquery.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.gritter.min.js')}}"></script>

        <style>
            .main-content {
                margin-left: 0px;
            }
            input[type="text"], select {
                border: none !important;
                background: transparent !important;
                -webkit-appearance: none;
            }
            .main-container{
                margin-top: -30px!important;
            }
            td{
                font-size: 12px !important;
                line-height: 1.0 !important;
                height: 20px !important;
            }
            table>tbody>tr>td{
                padding: 0px !important;
            }
            h5{
                margin-top: 0px !important;
                margin-bottom: 0px !important;
            }
        </style>
    </head>

    <body>
        <div class="main-container" id="main-container">
            <div class="main-container-inner">
                @yield('content')
            </div>
        </div>

        <script type="text/javascript">
            window.jQuery || document.write("<script src='/assets/js/jquery-1.10.2.min.js'>" + "<" + "/script>");
        </script>
        <script src="{{ asset('/assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('/assets/js/ship_process.js') }}"></script>
    </body>
</html>
