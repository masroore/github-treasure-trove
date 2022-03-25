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

@toastr_css

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

            <!-- Language -->
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" title="Language" data-toggle="dropdown">
                <i class="fa fa-flag"></i>
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
                      <span class="flag-icon flag-icon-fr"> </span> French</a>
                    </li>
                    <li><!-- start message -->
                      <a href="{{route('setLocale','cn')}}" title="英语"><span class="flag-icon flag-icon-cn"> </span> Chinese</a>
                    </li>
                    <li><!-- start message -->
                      <a href="{{route('setLocale','ar')}}" title="英语"><span class="flag-icon flag-icon-ar"> </span> Arabic</a>
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
                  @hasanyrole('is_admin|is_superAdmin')
                  <a href="#" class="btn btn-default btn-flat">@lang('site.profile')</a>
                  @else
                  @hasanyrole('Student')
                  <a href="{{ route('students-profile-info-view') }}" class="btn btn-default btn-flat">@lang('site.profile')</a>

                  @else
                  <a href="{{ route('Staffprofile') }}" class="btn btn-default btn-flat">@lang('site.profile')</a>
                  @endhasanyrole
                  
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
      <div class="pull-left ">
        <img src="{{ asset('storage') }}/{{Auth::user()->pro_pic}}" class="img-circle" alt="User Image" height="50px" width="50px" >
      </div>
      <div class="pull-left info">
        <p> {{ Auth::user()->name }} </p>
        <a href="#"><i class="fa fa-circle text-success"></i>@lang('site.online')</a>
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
      <li class="header" >@lang('site.main_nav')</li>

      @hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Human Resource|Accounts|Lecturer|Front_desk_help')
      <li class="active treeview">
        <a href="#">
          <i class="fa fa-dashboard"></i> <span>@lang('site.dashboard')</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('dashboard') }}" ><i class="fa fa-circle"></i> @lang('site.dashboard')</a></li>
          </ul>
        </li>
         @endhasanyrole



         

        {{--  <li class="treeview">
          <a href="#"><i class="fa fa-circle"></i>Branches
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="{{route('school-branch')}}"><i class="fa fa-circle"></i>School Branch</a></li>
           
         </ul>
       </li> --}}

        @hasanyrole('is_superAdmin|is_admin|Front_desk_help')

        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>@lang('site.front-desk') </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('add-enquiry') }}" c ><i class="fa fa-circle"></i>@lang('site.admission-enquiry')</a></li>
              <li><a href="{{ route('add-visitor') }}"  ><i class="fa fa-circle"></i>@lang('site.visitor-book') </a></li>
                <li><a href="{{ route('add-call') }}" ><i class="fa fa-circle"></i>@lang('site.phone-call')</a></li>
                  <li><a href="{{ route('add-postal-dispatch') }}"  ><i class="fa fa-circle"></i>@lang('site.postal-dispatch')</a></li>
                    <li><a href="{{ route('add-postal-receive') }}"  ><i class="fa fa-circle"></i>@lang('site.postal-receive')</a></li>
                      {{-- <li><a href="#"><i class="fa fa-circle"></i>Complains</a></li> --}}
                    </ul>
                  </li>

                  @endhasanyrole


                  @hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service')

                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-edit"></i> <span>@lang('site.academic-year') </span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li class=""><a href="{{route('add-academic-year')}}"><i class="fa fa-circle"></i>@lang('site.add-academic-year')</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                      <i class="fa fa-edit"></i> <span>@lang('site.academic-calendar')</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="{{ route('create-event') }}" ><i class="fa fa-circle"></i>@lang('site.create-event') </a></li>
                        <li><a href="{{ route('create-event-all') }}"><i class="fa fa-circle"></i>@lang('site.all-event')</a></li>
                        </ul>
                      </li>

                      <li class="treeview">
                        <a href="#">
                          <i class="fa fa-edit"></i> <span>@lang('site.Admissions')</span>
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">

                          <li class="treeview">
                            <a href="#">
                              <i class="fa fa-files-o"></i>
                              <span>@lang('site.pre-admissions')</span>
                              <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                              </span>
                            </a>
                            <ul class="treeview-menu">
                              <li class=""><a href="{{route('admissions-home')}}" ><i class="fa fa-circle"></i>@lang('site.online-admissions') </a></li>
                                <li class="treeview">
                                  <a href="#"><i class="fa fa-circle"></i>@lang('site.level-100') 
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <ul class="treeview-menu">
                                    <li class=""><a href="{{route('admissions-home-level-100')}}"><i class="fa fa-circle"></i>@lang('site.all-level-100')</a></li>
                                      <li class=""><a href="{{route('admissions-home-level-100-app')}}" ><i class="fa fa-circle"></i>@lang('site.approved-level-100')</a></li>
                                      </ul>
                                    </li>
                                    <li class="treeview">
                                      <a href="#"><i class="fa fa-circle"></i>@lang('site.level-200') 
                                        <span class="pull-right-container">
                                          <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                      </a>
                                      <ul class="treeview-menu">
                                        <li class=""><a href="{{route('admissions-home-level-200')}}"><i class="fa fa-circle"></i>@lang('site.all-level-200')</a></li>
                                        <li class=""><a href="{{route('admissions-home-level-200-app')}}"><i class="fa fa-circle"></i>@lang('site.approved-level-200')</a></li>
                                      </ul>
                                    </li>
                                    <li class="treeview">
                                      <a href="#"><i class="fa fa-circle"></i>@lang('site.level-300')
                                        <span class="pull-right-container">
                                          <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                      </a>
                                      <ul class="treeview-menu">
                                        <li class=""><a href="{{route('admissions-home-level-300')}}"><i class="fa fa-circle"></i>>@lang('site.all-level-300')</a></li>
                                        <li class=""><a href="{{route('admissions-home-level-300-app')}}"><i class="fa fa-circle"></i>@lang('site.approved-level-300')</a></li>
                                      </ul>
                                    </li>

                                  </ul>
                                </li>

                                <li class="treeview">
                                  <a href="#"><i class="fa fa-files-o"></i>@lang('site.confirm-admission')
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <ul class="treeview-menu">

                                    <li class=""><a href="{{route('admissions-confirm-message')}}"><i class="fa fa-circle"></i>@lang('site.confirm-admission-doc')</a></li>

                                    <li class=""><a href="{{route('admissions-confirm')}}"><i class="fa fa-circle"></i>@lang('site.confirm-admission')</a></li>

                                    <li class=""><a href="{{route('admissions-confirm-all')}}"><i class="fa fa-circle"></i>@lang('site.all-confirm-admission')</a></li>

                                    <li class=""><a href="{{route('admissions-unconfirm-all')}}"><i class="fa fa-circle"></i>@lang('site.revert-admission')</a></li>

                                  </ul>
                                </li>

                                <li class="" ><a href="{{route('add-students')}}"><i class="fa fa-circle"></i>@lang('site.add-student')</a></li>
                              </ul>
                            </li>


                            <li class="treeview">
                              <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>@lang('site.student-info')</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">

                                <li><a href="{{route('all-students')}}"><i class="fa fa-circle"></i>@lang('site.all-student') </a></li>
                                <li><a href="{{route('all-studentsl1')}}"><i class="fa fa-circle"></i>@lang('site.level-100')</a></li>
                                <li><a href="{{route('all-studentsl2')}}"><i class="fa fa-circle"></i>@lang('site.level-200')</a></li>
                                <li><a href="{{route('all-studentsl3')}}"><i class="fa fa-circle"></i>@lang('site.level-300')</a></li>
                                <li><a href="{{route('all-studentsl4')}}"><i class="fa fa-circle"></i>@lang('site.level-400')</a></li>
                                <li><a href="{{route('all-students-graduated')}}"><i class="fa fa-circle"></i>@lang('site.graduated-student')</a></li>
                              </ul>
                            </li>
                            
                            <li class="treeview">
                              <a href="#">
                                <i class="fa fa-table"></i> <span>@lang('site.pro-management')</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                <li><a href="{{route('add-programme')}}"><i class="fa fa-circle"></i>@lang('site.add-pro')</a></li>
                                <li><a href="{{route('add-faculty')}}"><i class="fa fa-circle"></i>@lang('site.add-faculty')</a></li>
                              </ul>
                            </li>

                            <li class="treeview">
                              <a href="#">
                                <i class="fa fa-edit"></i> <span>@lang('site.results-management')</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                <li><a href="{{route('release_results')}}"><i class="fa fa-circle"></i>@lang('site.release-results')</a></li>
                                <li><a href="{{ route('cancel_results') }}"><i class="fa fa-circle"></i>@lang('site.cancel-student-results') </a></li>
                                <li><a href="{{ route('student_cancel_results_session') }}"><i class="fa fa-circle"></i>@lang('site.cancel-result-session')</a></li>
                              </ul>
                            </li>


                            <li class="treeview">
                              <a href="#">
                                <i class="fa fa-table"></i> <span>@lang('site.course-management')</span>
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>
                              <ul class="treeview-menu">
                                <li class="treeview">
                                  <a href="#"><i class="fa fa-circle"></i>@lang('site.add-course') 
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <ul class="treeview-menu">
                                    <li class=""><a href="{{route('add-course-degreel1')}}"><i class="fa fa-circle"></i>@lang('site.degree-level-100')</a></li>

                                    <li class=""><a href="{{route('add-course-degreel2')}}"><i class="fa fa-circle"></i>@lang('site.degree-level-200') </a></li>

                                    <li class=""><a href="{{route('add-course-degreel3')}}"><i class="fa fa-circle"></i>@lang('site.degree-level-300') </a></li>

                                    <li class=""><a href="{{route('add-course-degreel4')}}"><i class="fa fa-circle"></i>@lang('site.degree-level-400') </a></li>

                                    <li class=""><a href="{{route('add-course-diploma1')}}"><i class="fa fa-circle"></i>@lang('site.diploma-level-100') </a></li>

                                    <li class=""><a href="{{route('add-course-diploma2')}}"><i class="fa fa-circle"></i>@lang('site.diploma-level-200')</a></li>

                                  </ul>
                                </li>

                                <li><a href="{{route('all-degree-course-registered-view')}}"><i class="fa fa-circle"></i>@lang('site.all-degree-courses')</a></li>

                                <li><a href="{{route('all-diploma-course-registered-view')}}"><i class="fa fa-circle"></i>@lang('site.all-diploma-courses')</a></li>



                                <li class="treeview">
                                  <a href="#"><i class="fa fa-circle"></i>@lang('site.prog-and-courses')
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <!-- programme stsrt here -->
                                  <ul class="treeview-menu">


                                    @foreach($programmes as $prog)  

                                    @if($prog->type == 'Degree Programme')
                                    <li class="treeview">
                                      <a href="#"><i class="fa fa-circle"></i>{{$prog->code}}
                                        <span class="pull-right-container">
                                          <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                      </a>

                                      <ul class="treeview-menu">
                                        <li class="treeview">
                                          <a href="#"><i class="fa fa-circle"></i>@lang('site.level-100')
                                            <span class="pull-right-container">
                                              <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                          </a>
                                          <ul class="treeview-menu">
                                           <li><a href="{{route('add-course-programme-BPRM-first', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.first-semester')</a></li>
                                           <li><a href="{{route('add-course-programme-BPRM-second', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.second-semester')</a></li>
                                         </ul>
                                       </li>

                                       <li class="treeview">
                                        <a href="#"><i class="fa fa-circle"></i>@lang('site.level-200')
                                          <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                          </span>
                                        </a>
                                        <ul class="treeview-menu">
                                         <li><a href="{{route('add-course-programme-BPRM-first-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.first-semester')</a></li>
                                         <li><a href="{{route('add-course-programme-BPRM-second-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.second-semester')</a></li>
                                       </ul>
                                     </li>


                                     <li class="treeview">
                                      <a href="#"><i class="fa fa-circle"></i>@lang('site.level-300')
                                        <span class="pull-right-container">
                                          <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                      </a>
                                      <ul class="treeview-menu">
                                       <li><a href="{{route('add-course-programme-BPRM-first-l3', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.first-semester')</a></li>
                                       <li><a href="{{route('add-course-programme-BPRM-second-l3', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.second-semester')</a></li>
                                     </ul>
                                   </li>


                                   <li class="treeview">
                                    <a href="#"><i class="fa fa-circle"></i>@lang('site.level-400')
                                      <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                      </span>
                                    </a>
                                    <ul class="treeview-menu">
                                     <li><a href="{{route('add-course-programme-BPRM-first-l4', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.first-semester')</a></li>
                                     <li><a href="{{route('add-course-programme-BPRM-second-l4', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.second-semester')</a></li>
                                   </ul>
                                 </li>



                               </ul>
                             </li>

                             @endif
                             @endforeach

                             <!--  2 -->

                             <!-- diploma programmes loop here -->


                             @foreach($programmes as $prog)  

                             @if($prog->type == 'Diploma Programme')
                             <li class="treeview">
                              <a href="#"><i class="fa fa-circle"></i>{{$prog->code}}
                                <span class="pull-right-container">
                                  <i class="fa fa-angle-left pull-right"></i>
                                </span>
                              </a>

                              <ul class="treeview-menu">
                                <li class="treeview">
                                  <a href="#"><i class="fa fa-circle"></i>@lang('site.level-100')
                                    <span class="pull-right-container">
                                      <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                  </a>
                                  <ul class="treeview-menu">
                                   <li><a href="{{route('add-course-programme-BPRM-first', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.first-semester')</a></li>
                                   <li><a href="{{route('add-course-programme-BPRM-second', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.second-semester')</a></li>
                                 </ul>
                               </li>

                               <li class="treeview">
                                <a href="#"><i class="fa fa-circle"></i>@lang('site.level-200')
                                  <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                  </span>
                                </a>
                                <ul class="treeview-menu">
                                 <li><a href="{{route('add-course-programme-BPRM-first-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.first-semester')</a></li>
                                 <li><a href="{{route('add-course-programme-BPRM-second-l2', ['code'=>$prog->code ])}}"><i class="fa fa-circle"></i>@lang('site.second-semester')</a></li>
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

                 <!----- For admin and super admi  users --->

                 @hasanyrole('is_superAdmin|is_admin|Student')


                 @hasanyrole('is_superAdmin|is_admin')

                  <li class="treeview">
                  <a href="#">
                    <i class="fa fa-edit"></i> <span>@lang('site.student')</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    @can('Student Profile')
                    <li><a href="{{route('student-reg-course')}}"><i class="fa fa-circle"></i>@lang('site.course-reg')</a></li>
                    <li><a href="{{route('student-results')}}"><i class="fa fa-circle"></i>@lang('site.my-results')</a></li>
                    @endcan
                    <li><a href="{{route('student-timetable')}}"><i class="fa fa-circle"></i>@lang('site.timetable')</a></li>
                    {{-- <li><a href="{{route('students-assignment-views')}}"><i class="fa fa-circle"></i>Online Assignment</a></li> --}}

                    {{-- <li><a href="{{route('start-vote')}}"><i class="fa fa-circle"></i>Online Polls</a></li> --}}

                    {{-- <li><a href="{{route('start-exmas')}}"><i class="fa fa-circle"></i>Online Examination</a></li> --}}

                    {{-- <li><a href="{{route('join-meeting')}}"><i class="fa fa-circle"></i>Online Lectures</a></li> --}}

                  </ul>
                </li>

                 @endhasanyrole

                 @hasanyrole('Student')

                 <li><a href="{{route('student-reg-course')}}"><i class="fa fa-circle"></i>@lang('site.course-reg')</a></li>
                 <li><a href="{{route('student-results')}}"><i class="fa fa-circle"></i>@lang('site.my-results')</a></li>
                 <li><a href="{{route('student-timetable')}}"><i class="fa fa-circle"></i>@lang('site.timetable')</a></li>

                 <li><a href="{{ route('all_tickets_student') }}"><i class="fa fa-circle"></i>@lang('site.all-support-ticket') </a></li>
                 <li><a href="{{ route('create_ticket_student') }}"><i class="fa fa-circle"></i>@lang('site.create-new-ticket') </a></li>


                 <li><a href="{{route('start-vote')}}"><i class="fa fa-circle"></i>@lang('site.online-pols') </a></li>
                 <li><a href="{{route('result_polls_others')}}"><i class="fa fa-circle"></i>
                 @lang('site.view-pols-results')</a></li>

                 @endhasanyrole

                 
                @endhasanyrole

                @hasanyrole('is_superAdmin|is_admin')

                <li class="treeview">
                  <a href="#"><i class="fa fa-edit"></i>@lang('site.online-pay') 
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="{{ route('pay_mandatory_fees') }}" @hasanyrole('is_admin|is_superAdmin') style=" pointer-events: none;" @endhasanyrole><i class="fa fa-circle"></i>@lang('site.pay-mandatory') </a></li>
                    <li class="treeview">
                      <a href="#"><i class="fa fa-circle"></i>@lang('site.other-servces') 
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="{{ route('other_services_fees') }}" @hasanyrole('is_admin|is_superAdmin') style=" pointer-events: none;" @endhasanyrole><i class="fa fa-circle"></i>@lang('site.request') </a></li>
                        <li><a href="{{ route('submiited_other_services_fees') }}" @hasanyrole('is_admin|is_superAdmin') style=" pointer-events: none;" @endhasanyrole><i class="fa fa-circle"></i>@lang('site.submission') </a></li>
                        <li><a href="{{ route('pay_other_services_fees') }}" @hasanyrole('is_admin|is_superAdmin') style=" pointer-events: none;" @endhasanyrole><i class="fa fa-circle"></i>@lang('site.pay')</a></li>
                      </ul>
                    </li>
                    <li><a href="{{ route('print_statement') }}" @hasanyrole('is_admin|is_superAdmin') style=" pointer-events: none;" @endhasanyrole><i class="fa fa-circle"></i>@lang('site.print-statement')</a></li>

                    <li><a href="{{ route('ledge-account') }}" @hasanyrole('is_admin|is_superAdmin') style=" pointer-events: none;" @endhasanyrole><i class="fa fa-circle"></i>@lang('site.wallet-ledger-report')</a></li>

                    <li class="treeview">
                      <a href="#"><i class="fa fa-files-o"></i>@lang('site.wallet')
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                        <li><a href="{{ route('top_up_wallet') }}" @hasanyrole('is_admin|is_superAdmin') style=" pointer-events: none;" @endhasanyrole target="_blank"><i class="fa fa-circle"></i>@lang('site.top-up-wallet') </a></li>
                      </ul>
                    </li>


                    <li class="treeview">
                      <a href="#"><i class="fa fa-files-o"></i>@lang('site.transaction')
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                      </a>
                      <ul class="treeview-menu">
                       <li><a href="{{ route('transaction_history_student') }}" @hasanyrole('is_admin|is_superAdmin') style=" pointer-events: none;" @endhasanyrole ><i class="fa fa-circle"></i>@lang('site.transaction-history') </a></li>
                     </ul>
                   </li>
                 </ul>
               </li>

               @endhasanyrole

               @hasanyrole('Student')

               {{-- <li class="treeview">
                <a href="#">
                  <i class="fa fa-edit"></i> <span>@lang('site.support-ticket') </span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="{{ route('all_tickets_student') }}"><i class="fa fa-circle"></i>@lang('site.all-support-ticket') </a></li>
                  <li><a href="{{ route('create_ticket_student') }}"><i class="fa fa-circle"></i>@lang('site.create-new-ticket') </a></li>
                </ul>
              </li> --}}
              @endhasanyrole

              @hasanyrole('Lecturer|is_superAdmin|is_admin')
              <li class="treeview">
                <a href="#">
                  <i class="fa fa-edit"></i> <span>@lang('site.lecturer') </span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  @hasanyrole('is_superAdmin|is_admin')
   {{--  <li><a href="{{route('lecturer-reg-lecturer')}}"><i class="fa fa-circle"></i>Add Lecturer</a></li>
   <li><a href="{{route('lecturer-all')}}"><i class="fa fa-circle"></i>ALL Lecturers</a></li> --}}

   @else
   <li><a href="{{route('Staffprofile')}}"><i class="fa fa-circle"></i>
   @lang('site.profile')</a></li>
   @endhasanyrole
   <li><a href="{{route('lecturer-student-results')}}"><i class="fa fa-circle"></i>@lang('site.enter-results') </a></li>

   {{-- <li><a href="{{route('lecturer-student-results-reenter')}}"><i class="fa fa-circle"></i>ReEnter Results</a></li> --}} 

   <li><a href="{{ route('gen_timetable_lecturer') }}"><i class="fa fa-circle"></i>@lang('site.timetable')</a></li>

   {{-- <li><a href="{{route('lecturer-student-assignment')}}"><i class="fa fa-circle"></i>Post Assignment</a></li> --}}

   {{-- <li><a href="{{route('lecturer-student-assignment-view')}}"><i class="fa fa-circle"></i>View Assignment</a></li> --}}

   {{-- <li><a href="{{route('start-vote')}}"><i class="fa fa-circle"></i>Online Polls</a></li> --}}

   @hasanyrole('Lecturer')
   <li><a href="{{ route('requestleave') }}"><i class="fa fa-circle"></i>
   @lang('site.req-leave')</a></li>
   @endhasanyrole
 </ul>
</li>

<li class="treeview @if (Request::segment(3) == 'LMSLECTURER') active @endif">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.lms')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">

    @if (Request::segment(3) != 'LMSLECTURER')
    <li><a href="{{ route('lms-site-view') }}"><i class="fa fa-circle"></i>@lang('site.site')</a></li>
    @else
    <li class="treeview active">
      <a href="#"><i class="fa fa-files-o"></i>{{Request::segment(4)}}
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">

        <!-- Course Menu start here -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bars"></i> <span>@lang('site.overview')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-overview',['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i><i class="fa fa-bars"></i>
            @lang('site.course-overview')</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>@lang('site.calendar')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-callendar', ['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i>@lang('site.add-event')</a></li>
            <li><a href="{{ route('lms-lec-callendar-get-all', ['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i>@lang('site.all-events')</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i> <span>@lang('site.Lesson')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-lesson-plan',['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i><i class="fa fa-laptop"></i> @lang('site.lesson-plan')</a></li>
            <li><a href="{{ route('lms-lec-lesson-docs',['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i><i class="fa fa-folder-open"></i> 
            @lang('site.lesson-docs')</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-film"></i> <span>@lang('site.online-videos') </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-online-videos',['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i><i class="fa fa-film"></i>
            @lang('site.upload-videos')</a></li>
          </ul>
        </li>


        <li class="treeview @if (Request::segment(5) == 'announcements') active @endif">
          <a href="#">
            <i class="fa fa-bullhorn"></i> <span>@lang('site.announcement')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-announcements',['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i><i class="fa fa-bullhorn"></i> 
            @lang('site.announcement')</a></li>
          </ul>
        </li>

        <li class="treeview @if (Request::segment(5) == 'test-quiz') active @endif">
          <a href="#">
            <i class="fa fa-check-square"></i> <span>@lang('site.test-&-quiz')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-test-quiz',['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i><i class="fa fa-check-square"></i>@lang('site.test-&-quiz')</a></li>
          </ul>
        </li>

        <li class="treeview @if (Request::segment(5) == 'online-assignments') active @endif">
          <a href="#">
            <i class="fa fa-building"></i> <span>@lang('site.assignments')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-online-assignments',['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i><i class="fa fa-building"></i>@lang('site.assignments')</a></li>
          </ul>
        </li>

        <li class="treeview  @if (Request::segment(5) == 'gradebook') active @endif">
          <a href="#">
            <i class="fa fa-book"></i> <span>@lang('site.course-grading')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-gradebook',['code' => Request::segment(4)]) }}"><i class="fa fa-book"></i>@lang('site.gradebook')</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-video-camera"></i> <span>@lang('site.meeting')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-meetings',['code' => Request::segment(4)]) }}"><i class="fa fa-circle"></i><i class="fa fa-video-camera"></i> 
            @lang('site.meeting')</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-comments"></i> <span>@lang('site.chatroom')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-public-chat',['code' => Request::segment(4)]) }}"><i class="fa fa-comments"></i>@lang('site.public-chat')</a></li>
            <li><a href="{{ route('lms-lec-private-chat',['code' => Request::segment(4)]) }}"><i class="fa fa-comments"></i>@lang('site.private-chat')</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-envelope"></i> <span>@lang('site.email')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-email',['code' => Request::segment(4)]) }}"><i class="fa fa-envelope"></i>@lang('site.send-email')</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar-check-o"></i> <span>@lang('site.attendance')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-attendance',['code' => Request::segment(4)]) }}"><i class="fa fa-calendar-check-o"></i>@lang('site.attendance')</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-question"></i> <span>@lang('site.help')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-lec-help',['code' => Request::segment(4)]) }}"><i class="fa fa-question"></i>@lang('site.help')</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-database"></i> <span>@lang('site.course-assigned')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('lms-site-view') }}"><i class="fa fa-database"></i>
            @lang('site.site')</a></li>
          </ul>
        </li>
        <!-- Course Menu ends start here -->
      </ul>
    </li>
    @endif
    

  </ul>
</li>
@endhasanyrole
@hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service|Lecturer')

<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.pols-managment')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    @hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service')
    <li><a href="{{route('add-polls')}}"><i class="fa fa-circle"></i>
    @lang('site.add-pols')</a></li>
    <li><a href="{{route('manage-candidates')}}"><i class="fa fa-circle"></i>@lang('site.manage-position')</a></li>
    <li><a href="{{route('add-candidates')}}"><i class="fa fa-circle"></i>@lang('site.manage-candidate') </a></li>
    <li><a href="{{route('release_polls')}}"><i class="fa fa-circle"></i>@lang('site.release-pols-result')</a></li>
    <li><a href="{{route('poll-results')}}"><i class="fa fa-circle"></i>
    @lang('site.pol-result')</a></li>
    @endhasanyrole
    @hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service|Lecturer')
    <li><a href="{{route('start-vote')}}"><i class="fa fa-circle"></i>@lang('site.online-pols') </a></li>
    @hasanyrole('Admission committee|Academic Committee|Nabco Trainee|National Service|Lecturer|Student')
    <li><a href="{{route('result_polls_others')}}"><i class="fa fa-circle"></i>
    @lang('site.view-pols-results')</a></li>
    @endhasanyrole
    @endhasanyrole
  </ul>
</li>
@endhasanyrole

@hasanyrole('is_superAdmin|is_admin') 
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.exam-managment')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('add-exams')}}"><i class="fa fa-circle"></i>
    @lang('site.add-exam')</a></li>
    <li><a href="{{route('all-exams')}}"><i class="fa fa-circle"></i>
    @lang('site.add-question')</a></li>
    <li><a href="{{route('view-exams')}}"><i class="fa fa-circle"></i>
    @lang('site.online-exams')</a></li>
  </ul>
</li>
@endhasanyrole


@hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service')
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.timetable')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('add-timetable')}}"><i class="fa fa-circle"></i>
    @lang('site.add-timetable') </a></li>
    <li><a href="{{route('generate-timetable')}}"><i class="fa fa-circle"></i>
    @lang('site.gen-timetable')</a></li>
    <li><a href="{{route('upload-timetable')}}"><i class="fa fa-circle"></i>
    @lang('site.upload-timetable')</a></li>

    <li class="treeview">
      <a href="#">
        <i class="fa fa-edit"></i> <span>@lang('site.student-grouping') </span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{ route('group-student-timetable') }}"><i class="fa fa-circle"></i>@lang('site.group-student')</a></li>

        <li><a href="{{ route('view-grouping') }}"><i class="fa fa-circle"></i>@lang('site.view-grouping')</a></li>

      </ul>
    </li>


  </ul>
</li>
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.lec-hall')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('add-view-lecture-hall')}}"><i class="fa fa-circle"></i>@lang('site.add-hall')</a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.student-promotion')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('promote-student') }}"><i class="fa fa-circle"></i>@lang('site.promote-student')</a></li>
    <li><a href="{{ route('graduating_list') }}"><i class="fa fa-circle"></i>
    @lang('site.grading-list')</a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.student-punishment') </span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('add-fine') }}"><i class="fa fa-circle"></i>
    @lang('site.add-fine')</a></li>
    <li><a href="{{ route('fine-student') }}"><i class="fa fa-circle"></i>
    @lang('site.fine-student')</a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.disable-student')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('dismiss_student') }}"><i class="fa fa-circle"></i>
    @lang('site.student-dismissal') </a></li>
    <li><a href="{{ route('rasticate_student') }}"><i class="fa fa-circle"></i>
    @lang('site.student-rasticate')</a></li>
    <li><a href="{{ route('deferal_student') }}"><i class="fa fa-circle"></i>
    @lang('site.defer-student')</a></li>
  </ul>
</li>


@endhasanyrole

@hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service|Lecturer')
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>
    @lang('site.online-meeting')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    {{-- <li><a href="{{route('create-meeting')}}"><i class="fa fa-circle"></i>Schedule Lecture</a></li> --}}

    @hasanyrole('is_admin|is_superAdmin')

    <li><a href="{{route('create-staff-meeting')}}"><i class="fa fa-circle"></i>
    @lang('site.schedule-meeting')</a></li>

    @endhasanyrole

    <li><a href="{{route('show-staff-meeting')}}"><i class="fa fa-circle"></i>
    @lang('site.staff-meeting')</a></li>

  </ul>
</li>
@endhasanyrole

@hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service|Lecturer')
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i><span>@lang('site.communicate')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('send_mail') }}"><i class="fa fa-circle"></i>
    @lang('site.send-email')</a></li>
    <li><a href="{{ route('send_sms') }}"><i class="fa fa-circle"></i>@lang('site.send-sms')</a></li>
  </ul>
</li>
@endhasanyrole

{{-- <li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i><span>Chat</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
   <li><a href="{{ route('public_chat') }}"><i class="fa fa-circle"></i>Public Chat</a></li>
   <li><a href="{{ route('private_chat') }}"><i class="fa fa-circle"></i>Private Chat</a></li>
  </ul>
</li> --}}


@hasanyrole('is_admin|is_superAdmin|Accounts')
<li class="@if(Route::current()->getName() == 'Accounts') active @endif treeview">
  <a href="#"> 
    <i class="fa fa-edit"></i> <span> @lang('site.accounts')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('add-mandatory-fees') }}"><i class="fa fa-circle"></i>@lang('site.add-mand-fees')</a></li>
    <li><a href="{{ route('add_other_services') }}"><i class="fa fa-circle"></i>@lang('site.add-other-fee')</a></li>
    <li><a href="{{ route('add_fees_master') }}"><i class="fa fa-circle"></i>@lang('site.fee-master')</a></li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-edits"></i> <span>@lang('site.view-fees')</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="{{ route('view_fees_level100') }}"><i class="fa fa-circle"></i>@lang('site.level-100-fees')</a></li>
        <li><a href="{{ route('view_fees_level200') }}"><i class="fa fa-circle"></i>@lang('site.level-200-fees')</a></li>
        <li><a href="{{ route('view_fees_level300') }}"><i class="fa fa-circle"></i>@lang('site.level-300-fees')</a></li>
        <li><a href="{{ route('view_fees_level400') }}"><i class="fa fa-circle"></i>@lang('site.level-400-fees')</a></li>
      </ul>
    </li>
    <li><a href="{{ route('dispatch_fees') }}"><i class="fa fa-circle"></i>@lang('site.dispatch-fees')</a></li>
    <li><a href="{{ route('all_transactions') }}"><i class="fa fa-circle"></i>@lang('site.transaction')</a></li>
    <li><a href="{{ route('search_student') }}"><i class="fa fa-circle"></i>
    @lang('site.student')</a></li>
{{--     <li><a href="{{ route('makepayment') }}"><i class="fa fa-circle"></i>Make Payment</a></li>
--}}  </ul>
</li>
@endhasanyrole

@hasanyrole('is_admin|is_superAdmin|Human Resource')

<li class="@if(Route::current()->getName() == 'HumanResource') active @endif treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.human-resource')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('addstaff')}}"><i class="fa fa-circle"></i>@lang('site.add-staff') </a></li>
    <li><a href="{{route('allStaff')}}"><i class="fa fa-circle"></i>@lang('site.all-staff')</a></li>
    <li><a href="{{ route('recordattendance') }}"><i class="fa fa-circle"></i>@lang('site.staff-attendance')</a></li>
    <li><a href="{{ route('add_payroll') }}"><i class="fa fa-circle"></i>@lang('site.payroll')</a></li>
    <li><a href="{{ route('requestleave') }}"><i class="fa fa-circle"></i>@lang('site.req-leave')</a></li>
    <li><a href="{{ route('staffleave') }}"><i class="fa fa-circle"></i>
    @lang('site.app-leave')</a></li>
    <li><a href="#"><i class="fa fa-circle"></i>@lang('site.lec-rating')</a></li>
    <li><a href="{{ route('disable_staff') }}"><i class="fa fa-circle"></i>
    @lang('site.disable-staff')</a></li>
  </ul>
</li>

@endhasanyrole


{{-- <li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>Empty</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="#"><i class="fa fa-circle"></i>Empty</a></li>
  </ul>
</li> --}}


@hasanyrole('is_admin|is_superAdmin|Admission committee|Academic Committee|Nabco Trainee|National Service|Lecturer')

<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.support-ticket')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('all_tickets') }}"><i class="fa fa-circle"></i>@lang('site.all-support-ticket')</a></li>
    <li><a href="{{ route('create_ticket') }}"><i class="fa fa-circle"></i>@lang('site.create-new-ticket')</a></li>
  </ul>
</li>

@endhasanyrole

@hasanyrole('is_superAdmin|is_admin')
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.user-managment')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{route('add-user-role')}}"><i class="fa fa-circle"></i>
    @lang('site.add-role')</a></li>
    <li><a href="{{route('users-roles-display')}}"><i class="fa fa-circle"></i>
    @lang('site.user-roles')</a></li>
    <li><a href="{{route('logout-user-force')}}"><i class="fa fa-circle"></i>
    @lang('site.force-logout')</a></li>
  </ul>
</li>

<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.backup')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="/backup"><i class="fa fa-circle"></i>@lang('site.db-backup')</a></li>
  </ul>
</li>


<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i><span>@lang('site.seo')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="#"><i class="fa fa-circle"></i>@lang('site.seo')</a></li>
  </ul>
</li>

@endhasanyrole

@hasanyrole('is_admin|is_superAdmin')
<li class="treeview">
  <a href="#">
    <i class="fa fa-edit"></i> <span>@lang('site.syetem-log')</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ route('view-system-logs') }}"><i class="fa fa-circle"></i>
    @lang('site.log')</a></li>
    <li><a href="/laravel-websockets" target="_blank"><i class="fa fa-circle"></i>
    @lang('site.web-socket')</a></li>
  </ul>
</li>
@endhasanyrole

<li class="header">@lang('site.user')</li>
<li><a href="{{route('passconfirm')}}"><i class="fa fa-circle text-red"></i> <span>
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
      <li><a href="{{route('home') }}"><i class="fa fa-dashboard"></i>Home</a></li>
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
  <strong>Copyright &copy; 2014- @php echo date('Y'); @endphp <a href="#">OSMS</a>.</strong> All rights
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

@toastr_js
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

@yield('script')
</body>
</html>
