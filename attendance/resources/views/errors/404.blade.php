<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap/dist/css/bootstrap.css')}}">

  {{-- <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap/dist/css/adminlte.min.css')}}">
 --}}
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ URL::to('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::to('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Font Awesome fas -->
  <link rel="stylesheet" href="{{ URL::to('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ URL::to('plugins/summernote/summernote-bs4.min.css')}}">

  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ URL::to('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ URL::to('dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
   <link rel="stylesheet" href="{{ URL::to('dist/css/skins/_all-skins.min.css')}}">
   <!-- Morris chart -->
   <link rel="stylesheet" href="{{ URL::to('bower_components/morris.js/morris.css')}}">
   <!-- jvectormap -->
   <link rel="stylesheet" href="{{ URL::to('bower_components/jvectormap/jquery-jvectormap.css')}}">
   <!-- Date Picker -->
   <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
   <!-- Daterange picker -->
   <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
   <!-- bootstrap wysihtml5 - text editor -->
   <link rel="stylesheet" href="{{ URL::to('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
   <!-- DataTables -->
   <link rel="stylesheet" href="{{ URL::to('bower_components/DataTables/datatables.min.css')}}">


   <link href="//cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">


   <!-- Bootstrap time Picker -->
   <link rel="stylesheet" href="{{ URL::to('plugins/timepicker/bootstrap-timepicker.min.css')}}">
   <!-- Select2 -->
   <link rel="stylesheet" href="{{ URL::to('bower_components/select2/dist/css/select2.min.css')}}">


   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->

<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<link href="{{ URL::to('bower_components/bootstrap-toggle/css/bootstrap-toggle.css')}}" rel="stylesheet">

<!-- DataTables -->
<link rel="stylesheet" href="{{ URL::to('bower_components/shadow/shadow.css')}}">


<!-- Support Ticket -->
<link rel="stylesheet" href="{{ URL::to('supportticket/supportticket.css')}}">

<!-- timer css -->
<link rel="stylesheet" href="{{ URL::to('css/timer.css')}}">

<style>

   /* width */
        ::-webkit-scrollbar {
            width: 7px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #a7a7a7;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #929292;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            list-style: none;
        }

        .user-wrapper, .message-wrapper {
            border: 1px solid #dddddd;
            overflow-y: auto;
        }

        .user-wrapper {
            height: 600px;
        }

        .user {
            cursor: pointer;
            padding: 5px 0;
            position: relative;
        }

        .addhover{
          background: #eeeeee;
        }

        .user:hover {
            background: #eeeeee;
        }

        .user:last-child {
            margin-bottom: 0;
        }

        .useractive {
            position: absolute;
            left: 48px;
            bottom: 9px;
            background: #008d4c;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }

        .pending {
            position: absolute;
            left: 10px;
            top: 12px;
            background: #dd4b39;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }

        .userinactive {
            position: absolute;
            left: 48px;
            bottom: 9px;
            background: #abc;
            margin: 0;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            line-height: 18px;
            padding-left: 5px;
            color: #ffffff;
            font-size: 12px;
        }

        .media-left {
            margin: 0 10px;
        }

        .media-left img {
            width: 64px;
            border-radius: 64px;
        }

        .media-body p {
            margin: 6px 0;
        }

        .message-wrapper {
            padding: 10px;
            height: 536px;
            background: #eeeeee;
        }

    

  .sticky {
    position: fixed;
    top: 0;
    box-shadow: 5px 10px #888888;
  }
  .cardbg{
   background-color: #ccc;
 }
 .rotateText{
  text-transform: uppercase;
  -moz-transform: rotate(-90.0deg);
  -o-transform: rotate(-90.0deg);
  -webkit-transform: rotate(-90.0deg);
  padding: 4px 3px 3px 4px;
  border-bottom: 1px solid #dadada;
}
.control-label{
 font-size: 15px;
 text-align: right;
 margin-top: 6px;
}

.form-border{
 border-top: 0px;
 border-right: 0px;
 border-left:  0px;
 box-shadow: none;
}

.box-height{
  border: 1px solid #ccc;
  height: 250px;
}
.example-modal .modal {
  position: relative;
  top: auto;
  bottom: auto;
  right: auto;
  left: auto;
  display: block;
  z-index: 1;
}

.example-modal .modal {
  background: transparent !important;
}

.sweetalert{
  background-color: #abc;
  font-size: 20px;
}

</style>
@livewireStyles
</head>
<body class="hold-transition skin-blue sidebar-mini" oncontextmenu="return true;">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>OS</b>MS</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>OSMS</b></span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <!-- Language -->
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" title="Language" data-toggle="dropdown">
                <i class="fa fa-language"></i>
              </a>
              <ul class="dropdown-menu">
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">

                   <li><!-- start message -->
                    <a href="{{route('setLocale','en')}}" title="English"><span class="flag-icon flag-icon-us"> </span> English</a>
                  </li>
                  <li><!-- start message -->
                    <a href="{{route('setLocale','fr')}}" title="Anglaise">
                      <span class="flag-icon flag-icon-fr"> </span> Anglaise</a>
                    </li>
                    <li><!-- start message -->
                      <a href="{{route('setLocale','ch')}}" title="英语"><span class="flag-icon flag-icon-cn"> </span> 英语</a>
                    </li>

                  </ul>
                </li>
              </ul>
            </li>


            <!-- end Language --->

            <!-- User Account: style can be found in dropdown.less -->
            
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->

</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      @yield('mtitle')
      <small> @yield('mtitlesub') </small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> @yield('mtitle')</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    
    @include('notify_status.notify')

   <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="../../index.html">return to dashboard</a> or try using the search form.
          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->



    @yield('content')
    
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.4.0
  </div>
  <strong>Copyright &copy; 2014- @php echo date('Y'); @endphp <a href="#">OSMS</a>.</strong> All rights
  reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <!-- Home tab content -->
    <div class="tab-pane" id="control-sidebar-home-tab">
      <h3 class="control-sidebar-heading">Recent Activity</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

              <p>Will be 23 on April 24th</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-user bg-yellow"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

              <p>New phone +1(800)555-1234</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

              <p>nora@example.com</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-file-code-o bg-green"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

              <p>Execution time 5 seconds</p>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

      <h3 class="control-sidebar-heading">Tasks Progress</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Custom Template Design
              <span class="label label-danger pull-right">70%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Update Resume
              <span class="label label-success pull-right">95%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-success" style="width: 95%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Laravel Integration
              <span class="label label-warning pull-right">50%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Back End Framework
              <span class="label label-primary pull-right">68%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

    </div>
    <!-- /.tab-pane -->
    <!-- Stats tab content -->
    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
    <!-- /.tab-pane -->
    <!-- Settings tab content -->
    <div class="tab-pane" id="control-sidebar-settings-tab">
      <form method="post">
        <h3 class="control-sidebar-heading">General Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Report panel usage
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Some information about this general settings option
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Allow mail redirect
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Other sets of options are available
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Expose author name in posts
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Allow the user to show his name in blog posts
          </p>
        </div>
        <!-- /.form-group -->

        <h3 class="control-sidebar-heading">Chat Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Show me as online
            <input type="checkbox" class="pull-right" checked>
          </label>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Turn off notifications
            <input type="checkbox" class="pull-right">
          </label>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Delete chat history
            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
          </label>
        </div>
        <!-- /.form-group -->
      </form>
    </div>
    <!-- /.tab-pane -->
  </div>
</aside>
<!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
   immediately after the control sidebar -->
   <div class="control-sidebar-bg"></div>
 </div>
 <!-- ./wrapper -->


 <!-- jQuery 3 -->
 <script src="{{ URL::to('bower_components/jquery/dist/jquery.min.js')}}"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{ URL::to('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
 <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
 <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::to('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ URL::to('bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{ URL::to('bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ URL::to('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{ URL::to('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{ URL::to('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ URL::to('bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ URL::to('bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ URL::to('bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ URL::to('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ URL::to('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ URL::to('bower_components/jquery-slimscroll/jquery.slimscroll.min.j')}}s"></script>
<!-- FastClick -->
<script src="{{ URL::to('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::to('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ URL::to('dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ URL::to('dist/js/demo.js')}}"></script>
<!-- DataTables -->
<script src="{{ URL::to('bower_components/DataTables/datatables.min.js')}}"></script>
<script src="{{ URL::to('bower_components/bootstrap-toggle/js/bootstrap-toggle.js')}}"></script>

<!-- Select2 -->
<script src="{{ URL::to('bower_components/select2/dist/js/select2.full.min.js')}}"></script>


<!-- Jquery Overlay -->
{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js
"></script>
--}}

<!-- Print Js -->
<script type="text/javascript" src="{{ URL::to('js/jquery.PrintArea.js')}}"></script>


{{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
--}}


<!-- Loading Overlay Js -->
<script src="{{ URL::to('bower_components/loading_overlay/loading_overlay.js')}}"></script>


<!-- Sweet Alert Js -->
<script src="{{ URL::to('bower_components/sweetalert/sweertalert.js')}}"></script>

<!-- Bootstrap 4 -->
{{-- <script src="{{ URL::to('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
--}}

<!-- Summernote -->
<script src="{{ URL::to('plugins/summernote/summernote-bs4.min.js')}}"></script>


<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ URL::to('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>


<!-- Timer js -->
<script src="{{ URL::to('js/moment.js')}}"></script>
<script src="{{ URL::to('js/moment-timezone-with-data.js')}}"></script>
<script src="{{ URL::to('js/timer.js')}}"></script>
<!-- //Timer js -->


<!-- bootstrap datepicker -->
<script src="{{ URL::to('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>


<!-- //Socket io js -->


{{-- <script src="{{ URL::to('bower_components/socket_io/socket.io.js')}}"></script>

 --}}{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.0.1/socket.io.js"></script> --}}

<script src="{{ URL::to('js/app.js')}}"></script>


<!-- //Js files -->

@livewireScripts

<script>
  $(function () {


    $('.select2').select2()


    $('#example1').DataTable({
     dom: 'lBfrtip',
     "bDestroy": true,
     buttons: [
     'copy',
     'csv',
     'excel',
     'pdf',
     'print'
     ]
   });

    $('.customt').DataTable({
     dom: 'lBfrtip',
     "bDestroy": true,
     buttons: [
     'copy',
     'csv',
     'excel',
     'pdf',
     'print'
     ]
   });
    
    $('#example3').DataTable({
     dom: 'lBfrtip',
     "bDestroy": true,
     buttons: [
     'copy',
     'csv',
     'excel',
     'pdf',
     'print'
     ]
   });

    $('#example4').DataTable({
     dom: 'lBfrtip',
     "bDestroy": true,
     buttons: [
     'copy',
     'csv',
     'excel',
     'pdf',
     'print'
     ]
   });

    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })


    $(document).on("click","#delete_booking", function(e){
      e.preventDefault();
      alert("working..");
    });

    $(document).on("click","#markall", function(e){
      var _token = $('meta[name=csrf-token]').attr('content');
      if (confirm("Mark all As Read")) {
        $.ajax({
          url: '{{route('mark-all-as-read')}}',
          type: 'POST',
          data: {_token : _token},
          success: function(data){
            alert(data);
            
          },
          error: function (data) {
            console.log('Error:', data);

          }
        });

      }

    });


    $(document).on("click","#deleteall", function(e){
      var _token = $('meta[name=csrf-token]').attr('content');
      if (confirm("Delete All Notifications")) {
        $.ajax({
          url: '{{route('delete-all-notification')}}',
          type: 'POST',
          data: {_token : _token},
          success: function(data){
            alert(data);
            
          },
          error: function (data) {
            console.log('Error:', data);

          }
        });

      }

    });


    
    function loadmenu(){
      $.ajax({
        url: '{{route('menu')}}',
        success: function(data){
          $("#menudiplay").html(data);
        }
      });
    }





  });
</script>

<script type="text/javascript">
  var url = window.location;
  //console.log(url);
// for sidebar menu but not for treeview submenu
$('ul.sidebar-menu a').filter(function() {
  return this.href == url;
}).parent().siblings().removeClass('active').end().addClass('active');
// for treeview which is like a submenu
$('ul.treeview-menu a').filter(function() {
  return this.href == url;
}).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');
</script>

@yield('script')
</body>
</html>





@extends('layouts.main')


@section('title')
  OSMS | 404 Error Page
@endsection

@section('mtitle')
  404 Error Page
@endsection


@section('mtitlesub')

@endsection





@section('script')


</script>


@endsection
