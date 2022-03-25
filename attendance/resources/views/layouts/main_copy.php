<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ URL::to('bower_components/font-awesome/css/font-awesome.min.css')}}">
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

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="shortcut icon" href="{{ URL::to('images/logo.png')}}" type="image/x-icon"/>
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link href="{{ URL::to('bower_components/bootstrap-toggle/css/bootstrap-toggle.css')}}" rel="stylesheet">

<style type="text/css">
  .rule:last-child{
    display: none;
  }
</style>
   @livewireStyles
</head>
<body class="hold-transition skin-blue sidebar-mini">
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

          <!-- Messages: style can be found in dropdown.less-->


          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              @if(Auth::user()->unreadNotifications->count())
                <span class="label label-warning">
                {{Auth::user()->unreadNotifications->count()}}</span>
              @endif
            </a>
            <ul class="dropdown-menu">
              <li class="header"><a href="#" id="markall" style="color: #3c8dbc">Mark all as Read</a></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">

                  @foreach(Auth::user()->unreadNotifications as $notification)
                  <!-- <li>
                    <a href="#">
                      <i class="fa fa-bell text-aqua"></i>{{$notification->data['name']}}
                    </a>
                  </li> -->
                  <li style="background-color: #ccc;"><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <i class="fa fa-bell text-aqua"></i>
                      </div>
                      <h4>
                        Name
                        <small><i class="fa fa-clock-o"></i>{{$notification->created_at->diffForHumans()}}</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  @endforeach

                   @foreach(Auth::user()->readNotifications as $notification)
                  <!-- <li>
                    <a href="#">
                      <i class="fa fa-bell text-aqua"></i>{{$notification->data['name']}}
                    </a>
                  </li> -->
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <i class="fa fa-bell-slash text-aqua"></i>
                      </div>
                      <h4>
                        Name
                        <small><i class="fa fa-bell-slash"></i>{{$notification->created_at->diffForHumans()}}</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  @endforeach
                </ul>
              </li>
              <li class="footer"><a href="#" id="deleteall">Delete All</a></li>
            </ul>
          </li>


          <!-- Tasks: style can be found in dropdown.less -->


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
                    <a href="{{route('setLocale','en')}}" title="English">English</a>
                  </li>
                   <li><!-- start message -->
                    <a href="{{route('setLocale','fr')}}" title="Anglaise">
                      <span class="flag-icon flag-icon-fr"> </span> Anglaise</a>
                  </li>
                   <li><!-- start message -->
                    <a href="{{route('setLocale','ch')}}" title="英语">英语</a>
                  </li>

                </ul>
              </li>
            </ul>
          </li>


<!-- end Language --->




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
                  <small>Member since {{ Auth::user()->created_at }}</small>
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
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a class="btn btn-default" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </div>
              </li>
            </ul>
          </li>
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
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('storage') }}/{{Auth::user()->pro_pic}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p> {{ Auth::user()->name }} </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->

    <!---Menu -------------->

      <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">@lang('site.main_nav')</li>
        <li class="@if(Route::current()->getName() == 'dashboard' )
                    active
                  @endif treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>@lang('site.dashboard')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@if(Route::current()->getName() == 'dashboard' )
                    active
                  @endif"><a href="{{ route('dashboard') }}"><i class="fa fa-circle-o"></i> @lang('site.dashboard')</a></li>
          </ul>
        </li>
        @hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service')
        <li class="@if(Request::segment(1) == 'LatestAdmission')
                    active
                  @endif treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>@lang('site.Admissions')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@if(Route::current()->getName() == 'add-students' )
                    active
                  @endif" ><a href="{{route('add-students')}}"><i class="fa fa-circle-o"></i>Add Student</a></li>
            <li class="@if(Route::current()->getName() == 'admissions-home' )
                    active
                  @endif"><a href="{{route('admissions-home')}}"><i class="fa fa-circle-o"></i>Online Admissions Received</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level 100
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'admissions-home-level-100' )
                    active
                  @endif"><a href="{{route('admissions-home-level-100')}}"><i class="fa fa-circle-o"></i>All Level 100</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-home-level-100-app' )
                    active
                  @endif"><a href="{{route('admissions-home-level-100-app')}}"><i class="fa fa-circle-o"></i>Approved level 100</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level 200
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'admissions-home-level-200' )
                    active
                  @endif"><a href="{{route('admissions-home-level-200')}}"><i class="fa fa-circle-o"></i>All Level 200</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-home-level-200-app' )
                    active
                  @endif"><a href="{{route('admissions-home-level-200-app')}}"><i class="fa fa-circle-o"></i>Approved level 200</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level 300
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'dmissions-home-level-300' )
                    active
                  @endif"><a href="{{route('admissions-home-level-300')}}"><i class="fa fa-circle-o"></i>All Level 300</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-home-level-300-app' )
                    active
                  @endif"><a href="{{route('admissions-home-level-300-app')}}"><i class="fa fa-circle-o"></i>Approved level 300</a></li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i>Student Admission
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'admissions-confirm' )
                    active
                  @endif"><a href="{{route('admissions-confirm')}}"><i class="fa fa-circle-o"></i>Confirm Admission</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-confirm-all' )
                    active
                  @endif"><a href="{{route('admissions-confirm-all')}}"><i class="fa fa-circle-o"></i>All Confirmed Admission</a></li>
                <li class="@if(Route::current()->getName() == 'admissions-unconfirm-all' )
                    active
                  @endif"><a href="{{route('admissions-unconfirm-all')}}"><i class="fa fa-circle-o"></i>UnConfirm Admission</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="@if(Request::segment(1) == 'Allstudents')
                    active
                  @endif treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Student Info</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="{{route('all-students')}}"><i class="fa fa-circle-o"></i>All Students</a></li>
            <li><a href="{{route('all-studentsl1')}}"><i class="fa fa-circle-o"></i>Level 1oo</a></li>
            <li><a href="{{route('all-studentsl2')}}"><i class="fa fa-circle-o"></i>Level 200</a></li>
            <li><a href="{{route('all-studentsl3')}}"><i class="fa fa-circle-o"></i>Level 300</a></li>
            <li><a href="{{route('all-studentsl4')}}"><i class="fa fa-circle-o"></i>Level 400</a></li>
            <li><a href="{{route('all-studentsl1')}}"><i class="fa fa-circle-o"></i>Graduated Students</a></li>
          </ul>
        </li>
        <li class="@if(Request::segment(1) == 'AcademicYear')
                    active
                  @endif treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Academic Year</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@if(Route::current()->getName() == 'add-academic-year' )
                    active
                  @endif"><a href="{{route('add-academic-year')}}"><i class="fa fa-circle-o"></i>Add Academic year</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Programme Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('add-programme')}}"><i class="fa fa-circle-o"></i>Add Programme</a></li>
            <li><a href="{{route('add-faculty')}}"><i class="fa fa-circle-o"></i>Add Faculty</a></li>
          </ul>
        </li>

        <li class="@if(Request::segment(1) == 'CourseManagement')
                    active
                  @endif treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Course Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i>Add Courses
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="@if(Route::current()->getName() == 'add-course-degreel1' )
                    active
                  @endif"><a href="{{route('add-course-degreel1')}}"><i class="fa fa-circle-o"></i>Degree Level 100</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-degreel2' )
                    active
                  @endif"><a href="{{route('add-course-degreel2')}}"><i class="fa fa-circle-o"></i>Degree Level 200</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-degreel3' )
                    active
                  @endif"><a href="{{route('add-course-degreel3')}}"><i class="fa fa-circle-o"></i>Degree Level 300</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-degreel4' )
                    active
                  @endif"><a href="{{route('add-course-degreel4')}}"><i class="fa fa-circle-o"></i>Degree Level 400</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-diploma1' )
                    active
                  @endif"><a href="{{route('add-course-diploma1')}}"><i class="fa fa-circle-o"></i>Diploma Level 100</a></li>

                  <li class="@if(Route::current()->getName() == 'add-course-diploma2' )
                    active
                  @endif"><a href="{{route('add-course-diploma2')}}"><i class="fa fa-circle-o"></i>Diploma Level 200</a></li>

              </ul>
            </li>

            <li><a href="{{route('all-degree-course-registered-view')}}"><i class="fa fa-circle-o"></i>All Degree Courses</a></li>

             <li><a href="{{route('all-diploma-course-registered-view')}}"><i class="fa fa-circle-o"></i>All Diploma Courses</a></li>



            <li class="@if(Request::segment(1) == 'CourseManagement')
                    active
                  @endif treeview">
              <a href="#"><i class="fa fa-circle-o"></i>Programme & Courses
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <!-- programme stsrt here -->
              <ul class="treeview-menu">


            @foreach(\App\Programme::all() as $prog)

              @if($prog->type == 'Degree Programme')
                <li class="@if(Request::segment(7) == '{{$prog->code}}')
                    active
                  @endif treeview">
                    <a href="#"><i class="fa fa-circle-o"></i>{{$prog->code}}
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>

                    <ul class="treeview-menu">
                        <li class="@if(Request::segment(7) == '{{$prog->code}}')
                        active
                      @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 100
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                        </li>

                         <li class="@if(Request::segment(7) == '{{$prog->code}}')
                        active
                      @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 200
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                         </li>


                         <li class="@if(Request::segment(7) == '{{$prog->code}}')
                              active
                              @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 300
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l3', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l3', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                         </li>


                         <li class="@if(Request::segment(7) == '{{$prog->code}}')
                              active
                              @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 400
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l4', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l4', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                         </li>



                    </ul>
                  </li>

                  @endif
              @endforeach

                 <!--  2 -->

                <!-- diploma programmes loop here -->


            @foreach(\App\Programme::all() as $prog)

              @if($prog->type == 'Diploma Programme')
                <li class="@if(Request::segment(7) == '{{$prog->code}}')
                    active
                  @endif treeview">
                    <a href="#"><i class="fa fa-circle-o"></i>{{$prog->code}}
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>

                    <ul class="treeview-menu">
                        <li class="@if(Request::segment(7) == '{{$prog->code}}')
                        active
                      @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 100
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                        </li>

                         <li class="@if(Request::segment(7) == '{{$prog->code}}')
                        active
                      @endif treeview">
                            <a href="#"><i class="fa fa-circle-o"></i>Level 200
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>First Semester</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle-o"></i>Second Semester</a></li>
                            </ul>
                         </li>
                    </ul>
                  </li>

                  @endif
              @endforeach

               <!-- diploend -->
              </ul>
              <!--programme end -->
            </li>


          </ul>
        </li>
        @endhasanyrole

        @hasanyrole('Student|is_superAdmin|is_admin')
        <li class="@if(Request::segment(1) == 'Allstudents')
                    active
                  @endif treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Student</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('Student Profile')
            <li><a href="{{route('students-profile-info-view')}}"><i class="fa fa-circle-o"></i>Profile</a></li>
            <li><a href="{{route('student-reg-course')}}"><i class="fa fa-circle-o"></i>Course Registration</a></li>
            <li><a href="{{route('student-results')}}"><i class="fa fa-circle-o"></i>My results</a></li>
            @endcan
            <li><a href="#"><i class="fa fa-circle-o"></i>TimeTable</a></li>
            <li><a href="{{route('students-assignment-views')}}"><i class="fa fa-circle-o"></i>Online Assignment</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Online Polls</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Online Examination</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Report a Problem</a></li>
          </ul>
        </li>
        @endhasanyrole


         @hasanyrole('Lecturer|is_superAdmin|is_admin')
         <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Lecturer</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('lecturer-reg-lecturer')}}"><i class="fa fa-circle-o"></i>Add Lecturer</a></li>
            <li><a href="{{route('lecturer-all')}}"><i class="fa fa-circle-o"></i>ALL Lecturers</a></li>
            <li><a href="{{route('lecturer-student-results')}}"><i class="fa fa-circle-o"></i>Enter Students Results</a></li>
            <li><a href="{{route('lecturer-student-results-reenter')}}"><i class="fa fa-circle-o"></i>ReEnter Results</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>TimeTable</a></li>
            <li><a href="{{route('lecturer-student-assignment')}}"><i class="fa fa-circle-o"></i>Post Assignment</a></li>
            <li><a href="{{route('lecturer-student-assignment-view')}}"><i class="fa fa-circle-o"></i>View Assignment</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Online Polls</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Online Examination</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Report a Problem</a></li>
             <li><a href="#"><i class="fa fa-circle-o"></i></a></li>


          </ul>
        </li>

         @endhasanyrole

         <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Polls Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('add-polls')}}"><i class="fa fa-circle-o"></i>Add Polls</a></li>
            <li><a href="{{route('manage-candidates')}}"><i class="fa fa-circle-o"></i>Manage Positions</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Manage Candidates</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Poll Results</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i>Online Polls</a></li>

          </ul>
        </li>
         <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Empty Menu</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i>Empty</a></li>
          </ul>
        </li>

      @hasanyrole('is_superAdmin|is_admin')
        <li class="@if(Request::segment(1) == 'UserManagement')
                        active
                      @endif treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('add-user-role')}}"><i class="fa fa-circle-o"></i>Add User Role / Perm</a></li>
            <li><a href="{{route('users-roles-display')}}"><i class="fa fa-circle-o"></i>Users and Their Roles</a></li>
            <li><a href="{{route('logout-user-force')}}"><i class="fa fa-circle-o"></i>Force Logout User</a></li>

          </ul>
        </li>

      @endhasanyrole

      @hasanyrole('is_superAdmin|is_admin')
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Log</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{route('add-user-role')}}"><i class="fa fa-circle-o"></i>Logs</a></li>


          </ul>
        </li>

      @endhasanyrole

        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">User</li>
        <li><a href="{{route('passconfirm')}}"><i class="fa fa-circle-o text-red"></i> <span>Lock Screen</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->




    <!--- End Menu --------->


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
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
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
<script>
  $(function () {

    $('#example1').DataTable({
       dom: 'lBfrtip',
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




  });
</script>

@yield('script')
@livewireScripts
</body>
</html>
