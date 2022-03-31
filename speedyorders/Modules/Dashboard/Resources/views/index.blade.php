@extends('layouts.main')
@section('ext_css')
    <link href="{{asset('/assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('content')

   <style>
       .project-list table tr td {
           padding: 5px 10px;
       }
   </style>

   <div class="row">
       <div class="col-md-9">
           <div class="hpanel">
               <div class="panel-heading">
                   <div class="panel-tools">
                       <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                       <a class="closebox"><i class="fa fa-times"></i></a>
                   </div>
                   Weeks Sales Summary
               </div>
               <div class="panel-body">
                   <div class="clearfix"></div>
                   <div id="stats-container" style="margin-top: 10px;"></div>
               </div>
           </div>
       </div>
       <div class="col-md-3">
           <div class="hpanel">
               <div class="panel-heading">
                   <div class="panel-tools">
                       <a class="showhide"><i class="fa fa-chevron-up"></i></a>
                       <a class="closebox"><i class="fa fa-times"></i></a>
                   </div>
                   Todays Summary
               </div>
               <div class="panel-body list">

                   <div class="pull-right">
                       <a href="#" class="btn btn-xs btn-default">{{ \Carbon\Carbon::parse()->format('Y-m-d H:i') }}</a>
                   </div>
                   <div class="panel-title">Today's Activity</div>
                   <div class="list-item-container">
                       <div class="list-item">
                           <h3 class="no-margins font-extra-bold text-info" id="totalFlightSearch"></h3>
                           <small>Total Flight Search</small>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>

@endsection
@section('ext_js')
    <script src="{{asset('/assets/vendor/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

@endsection
