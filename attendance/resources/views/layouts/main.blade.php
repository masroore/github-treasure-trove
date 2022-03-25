<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="shortcut icon" href="{{ URL::to('images/logo.png') }}" type="image/png">
  
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">

  {{-- <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap/dist/css/adminlte.min.css')}}">
  --}}
  <!-- Tempusdominus Bootstrap 4 -->

  {{-- <link rel="stylesheet" href="{{ URL::to('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}"> --}}

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

   <link rel="stylesheet" href="{{ URL::to('style.css')}}">


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

<link rel="stylesheet" href="{{ URL::to('bower_components/toastr/toastr.css')}}">

@yield('style')

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
  left: 38px;
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
  left: 38px;
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

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('storage') }}/{{Auth::user()->pro_pic}}" class="user-image" alt="User Image">
                <span class="hidden-xs"> {{ Auth::user()->name }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="{{ asset('storage') }}/{{Auth::user()->pro_pic}}" class="img-circle" alt="User Image">

                  <p>
                    {{ Auth::user()->name }}
                    <small>@lang('site.member') {{ Auth::user()->created_at }}</small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                <!-- <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div> -->
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  
                  @hasanyrole('Student')

                  <a href="{{ route('students-profile-info-view') }}" class="btn btn-default btn-flat">@lang('site.profile')</a>

                  @else

                  <a href="{{ route('Staffprofile') }}" class="btn btn-default btn-flat">@lang('site.profile')</a>

                  @endhasanyrole
                  
                  
                  
                </div>
                <div class="pull-right">
                  <a class="btn btn-default" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  @lang('site.logout')
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
       
      </ul>
    </div>
  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left ">
        <img src="{{ asset('storage') }}/{{Auth::user()->pro_pic}}" class="img-circle" alt="User Image" height="50px" width="50px" >
      </div>
      <div class="pull-left info">
        <p> {{ Auth::user()->name }} </p>
        <a href="#"><i class="fa fa-chevron-right text-success"></i>@lang('site.online')</a>
      </div>
    </div>
    <!-- search form -->

    {{-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form> --}}

    <!-- /.search form -->

    <!---Menu -------------->
    <?php
    $programmes = \App\Programme::all();
    ?>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    


    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
{{--       <li class="header" >@lang('site.main_nav')</li>
--}}
<li class="active treeview">
  <a href="#">
    <i class="fa fa-pie-chart"></i> <span>@lang('site.dashboard')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('dashboard') }}" ><i class="fa fa-chevron-right"></i> @lang('site.dashboard')</a></li>
  </ul>
</li>


        {{--  <li class="treeview">
          <a href="#"><i class="fa fa-chevron-right"></i>Branches
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="{{route('school-branch')}}"><i class="fa fa-chevron-right"></i>School Branch</a></li>
           
         </ul>
       </li> --}}

      @can('view Academics Year')
{{--       <li class="header">@lang('site.Academics')</li>
--}}
<li class="treeview">
  <a href="#">
    <i class="fa fa-calendar"></i> <span>@lang('site.academic-year') </span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    @can('view Add Academic Year')
    <li class=""><a href="{{route('add-academic-year')}}"><i class="fa fa-chevron-right"></i>@lang('site.add-academic-year')</a></li>
    @endcan
  </ul>
</li>
@endcan


@can('view Pre Admission')
<li class="treeview">
  <a href="#">
    <i class="fa fa-graduation-cap"></i><span>Admission</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
{{--       <li class="header">@lang('site.Admissions')</li>
--}}      

@can('view Add Student')
<li class="" ><a href="{{route('add-students')}}"><i class="fa fa-chevron-right"></i>@lang('site.add-student')</a></li>
@endcan

</ul>
</li>
@endcan



@can('view All studentds')
<li class="treeview">
  <a href="#">
    <i class="fa fa-user"></i> <span>Students Information </span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    {{--       <li class="header">@lang('site.student-info')</li>
--}}

@can('view All studentds')
<li><a href="{{route('all-students')}}"><i class="fa fa-chevron-right"></i>@lang('site.all-student') </a></li>
@endcan

@can('view Student Info Level 100')
<li><a href="{{route('all-studentsl1')}}"><i class="fa fa-chevron-right"></i>@lang('site.level-100')</a></li>
@endcan

@can('view Student Info Level 200')
<li><a href="{{route('all-studentsl2')}}"><i class="fa fa-chevron-right"></i>@lang('site.level-200')</a></li>
@endcan

@can('view Student Info Level 300')
<li><a href="{{route('all-studentsl3')}}"><i class="fa fa-chevron-right"></i>@lang('site.level-300')</a></li>
@endcan

@can('view Student Info Level 400')
<li><a href="{{route('all-studentsl4')}}"><i class="fa fa-chevron-right"></i>@lang('site.level-400')</a></li>
@endcan

  </ul>
</li>
@endcan


@can('view Add Programme')
<li class="treeview">
  <a href="#">
    <i class="fa fa-book"></i> <span>Programmes </span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    {{--       <li class="header">@lang('site.progrome&Courses')</li>
--}}

@can('view Add Programme')
<li><a href="{{route('add-programme')}}"><i class="fa fa-chevron-right"></i>@lang('site.add-pro')</a></li>
@endcan

  </ul>
</li>
@endcan


@can('view Add Course')
<li class="treeview">
  <a href="#">
    <i class="fa fa-book"></i> <span>Course Management </span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    {{--       <li class="header">@lang('site.progrome&Courses')</li>
--}}

@can('view Add Course')
<li class="treeview">
  <a href="#"><i class="fa fa-chevron-right"></i>@lang('site.add-course') 
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class=""><a href="{{route('add-course-degreel1')}}"><i class="fa fa-chevron-right"></i>@lang('site.degree-level-100')</a></li>

    <li class=""><a href="{{route('add-course-degreel2')}}"><i class="fa fa-chevron-right"></i>@lang('site.degree-level-200') </a></li>

    <li class=""><a href="{{route('add-course-degreel3')}}"><i class="fa fa-chevron-right"></i>@lang('site.degree-level-300') </a></li>

    <li class=""><a href="{{route('add-course-degreel4')}}"><i class="fa fa-chevron-right"></i>@lang('site.degree-level-400') </a></li>

    <li class=""><a href="{{route('add-course-diploma1')}}"><i class="fa fa-chevron-right"></i>@lang('site.diploma-level-100') </a></li>

    <li class=""><a href="{{route('add-course-diploma2')}}"><i class="fa fa-chevron-right"></i>@lang('site.diploma-level-200')</a></li>
  </ul>
</li>

<li><a href="{{route('all-degree-course-registered-view')}}"><i class="fa fa-chevron-right"></i>@lang('site.all-degree-courses')</a></li>

<li><a href="{{route('all-diploma-course-registered-view')}}"><i class="fa fa-chevron-right"></i>@lang('site.all-diploma-courses')</a></li>


</ul>
</li>
@endcan


@endcan




@can('view Student Portal')
<!----- For admin and super admi  users --->
{{-- <li class="header">@lang('site.student-Portal')</li>
--}}

<li class="treeview">
  <a href="#">
    <i class="fa fa-calendar-check-o"></i> <span>Attendance</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('lms-lec-attendance',['code' => 'BGEC109']) }}"><i class="fa fa-calendar-check-o"></i>Check Attendance</a></li>
  </ul>
</li>

@endcan


@can('view Lecturer')
{{-- <li class="header">@lang('site.lecturer')</li>
--}}
@can('view Profile')
<li><a href="{{route('Staffprofile')}}"><i class="fa fa-chevron-right"></i>
@lang('site.profile')</a></li>
@endcan

@endcan


@hasanyrole('is_admin|Lecturer|is_superAdmin|Human Resource Manager')

<li class="treeview">
  <a href="#">
    <i class="fa fa-calendar-check-o"></i> <span>Attendance</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('lms-lec-attendance') }}"><i class="fa fa-calendar-check-o"></i>Record Attendance</a></li>

     <li><a href="{{ route('attendancereport') }}"><i class="fa fa-calendar-check-o"></i>Generate Report</a></li>

  </ul>
</li>

@endhasanyrole



@can('view Communicate')
{{-- <li class="header">@lang('site.communicate')</li>
--}}
<li class="treeview">
  <a href="#">
    <i class="fa fa-send"></i><span>@lang('site.communicate')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">

    @can('view Send Nail')
    <li><a href="{{ route('send_mail') }}"><i class="fa fa-chevron-right"></i>
    @lang('site.send-email')</a></li>
    @endcan
   
  </ul>
</li>

@endcan

@can('view Human Resource')
{{-- <li class="header">@lang('site.human-resource')</li>
--}}
<li class="@if(Route::current()->getName() == 'HumanResource') active @endif treeview">
  <a href="#">
    <i class="fa fa-user-plus"></i> <span>@lang('site.human-resource')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">

    @can('view Add Staff')
    <li><a href="{{route('addstaff')}}"><i class="fa fa-chevron-right"></i>@lang('site.add-staff') </a></li>
    @endcan

    @can('view All Staff')
    <li><a href="{{route('allStaff')}}"><i class="fa fa-chevron-right"></i>@lang('site.all-staff')</a></li>
    @endcan
  </ul>
</li>

@endcan


@can('view User Management')
{{-- <li class="header">@lang('site.user-managment')</li>
--}}<li class="treeview">
  <a href="#">
    <i class="fa fa-user"></i> <span>@lang('site.user-managment')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">

    @can('view Add Role')
    <li><a href="{{route('add-user-role')}}"><i class="fa fa-chevron-right"></i>
    @lang('site.add-role')</a></li>
    @endcan
    {{-- <li><a href="{{route('users-roles-display')}}"><i class="fa fa-chevron-right"></i>
    @lang('site.user-roles')</a></li> --}}

  </ul>
</li>
@endcan


@hasanyrole('Developer')
<li class="treeview">
  <a href="#">
    <i class="fa fa-bars"></i> <span>Menu</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('add-menu') }}"><i class="fa fa-bars"></i>
    Add Menu</a></li>
    <li><a href="{{ route('add-permission') }}"><i class="fa fa-lock"></i>
    Add Permissions</a></li>
  </ul>
</li>

<li class="treeview">
  <a href="#">
    <i class="fa fa-chevron-right"></i> <span>@lang('site.syetem-log')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('view-system-logs') }}"><i class="fa fa-chevron-right"></i>
    @lang('site.log')</a></li>
    <li><a href="/laravel-websockets" target="_blank"><i class="fa fa-chevron-right"></i>
    @lang('site.web-socket')</a></li>
  </ul>
</li>
@endhasanyrole

{{-- <li class="header">@lang('site.user')</li>
--}}<li><a href="{{route('passconfirm')}}"><i class="fa fa-chevron-right text-red"></i> <span>
@lang('site.lock-screen')</span></a></li>
</ul>
<!-- /.sidebar -->





<!-- /.sidebar -->

<!--- End Menu --------->
</section>

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
      <li><a href="/"><i class="fa fa-pie-chart"></i>Home</a></li>
      <li class="active"> @yield('mtitle')</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    {{-- @include('sweetalert::alert') --}}
    
    @include('notify_status.notify')

    @yield('main_content')



    @yield('content')
    
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.4.0
  </div>
  <strong>Copyright &copy; 2014- @php echo date('Y'); @endphp <a href="http://ogusesitsolutions.com/">OguSes IT Solutions</a>.</strong> All rights
  reserved.
</footer>

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
{{-- <script src="{{ URL::to('js/moment.js')}}"></script>
<script src="{{ URL::to('js/moment-timezone-with-data.js')}}"></script>
<script src="{{ URL::to('js/timer.js')}}"></script> --}}
<!-- //Timer js -->


<!-- bootstrap datepicker -->
<script src="{{ URL::to('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<!-- CK Editor -->
<script src="{{ URL::to('bower_components/ckeditor/ckeditor.js')}}"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{ URL::to('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>

<script src="{{ URL::to('bower_components/socket_io/socket.io.js')}}"></script>


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.0.1/socket.io.js"></script> --}}

{{--  <script src="{{ URL::to('js/app.js')}}"></script>
--}}

<!-- //Js files -->

@livewireScripts

<script src="{{ URL::to('bower_components/toastr/toastr.js')}}"></script>
@toastr_render

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


<script>

  Livewire.on('cantdelete', postId => {
    toastr.error('Course Can not Be Deleted ?');
  })

  Livewire.on('deleted', postId => {
    toastr.success('Course deleted Successfully!');
    window.location.reload();
  })

  Livewire.on('Added', postId => {
    toastr.success('Item Added Successfully!');
    window.location.reload();
  })

</script>

@yield('script')
</body>
</html>
