<!DOCTYPE html>
<html lang="en">

<head>
  <title>@yield('title')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="keywords" content="" />
  <meta name="author" content="ogusesitsolutions" />

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Favicon icon -->
  <link rel="icon" href="{{ URL::to('lms/assets/images/favicon.ico')}}" type="image/x-icon">
  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
  <!-- waves.css -->
  <link rel="stylesheet" href="{{ URL::to('lms/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
  <!-- Required Fremwork -->
  <link rel="stylesheet" type="text/css" href="{{ URL::to('lms/assets/css/bootstrap/css/bootstrap.min.css')}}">
  <!-- waves.css -->
  <link rel="stylesheet" href="{{ URL::to('lms/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
  <!-- themify icon -->
  <link rel="stylesheet" type="text/css" href="{{ URL::to('lms/assets/icon/themify-icons/themify-icons.css')}}">
  <!-- font-awesome-n -->
  <link rel="stylesheet" type="text/css" href="{{ URL::to("lms/assets/css/font-awesome-n.min.css")}}">
  <link rel="stylesheet" type="text/css" href="{{ URL::to("lms/assets/css/font-awesome.min.css")}}">
  <!-- scrollbar.css -->
  <link rel="stylesheet" type="text/css" href="{{ URL::to("lms/assets/css/jquery.mCustomScrollbar.css")}}">
  <!-- Style.css -->
  <link rel="stylesheet" type="text/css" href="{{ URL::to("lms/assets/css/style.css")}}">

  <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap/dist/css/adminlte.min.css')}}">

  <link rel="stylesheet" href="{{ URL::to('bower_components/toastr/toastr.css')}}">
  
  @yield('style')
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search waves-effect waves-light">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            OGUA LMS
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="ti-more"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                            </li>
                            
                        </ul>
                        <ul class="nav-right">
                            <li class="header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <i class="ti-bell"></i>
                                    <span class="badge bg-c-red"></span>
                                </a>
                                <ul class="show-notification">
                                    <li>
                                        <h6>Notifications</h6>
                                        <label class="label label-danger">New</label>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <div class="media">
                                            <img class="d-flex align-self-center img-radius" src="lms/assets/images/avatar-2.jpg" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user">John Doe</h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <div class="media">
                                            <img class="d-flex align-self-center img-radius" src="lms/assets/images/avatar-4.jpg" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user">Joseph William</h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <div class="media">
                                            <img class="d-flex align-self-center img-radius" src="lms/assets/images/avatar-3.jpg" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="notification-user">Sara Soudein</h5>
                                                <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                <span class="notification-time">30 minutes ago</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="user-profile header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <img src="{{asset('storage')}}/{{auth()->user()->pro_pic}}" class="img-radius" alt="User-Profile-Image">
                                    <span>{{auth()->user()->name}}</span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    <li class="waves-effect waves-light">
                                        <a href="#!">
                                            <i class="ti-settings"></i> Settings
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="{{ route('lms-profile') }}">
                                            <i class="ti-user"></i> Profile
                                        </a>
                                    </li>
                                    
                                    {{-- <li class="waves-effect waves-light">
                                        <a href="email-inbox.html">
                                            <i class="ti-email"></i> My Messages
                                        </a>
                                    </li> --}}

                                    <li class="">
                                        <a href="{{ route('lmspassconfirm') }}">
                                            <i class="ti-lock"></i> Lock Screen
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">

                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-forms').submit();" >
                                        <i class="ti-layout-sidebar-left"></i> Logout
                                    </a>

                                    
                                    <form id="logout-forms" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>


                              </li>
                          </ul>
                      </li>
                  </ul>
              </div>
          </div>
      </nav>

      <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <nav class="pcoded-navbar">
                <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                <div class="pcoded-inner-navbar main-menu">
                    <div class="">
                        <div class="main-menu-header">
                            <img class="img-80 img-radius" src="{{asset('storage')}}/{{auth()->user()->pro_pic}}" alt="User-Profile-Image">
                            <div class="user-details">
                                <span id="more-details">{{auth()->user()->name}}<i class="fa fa-caret-down"></i></span>
                            </div>
                        </div>
                        <div class="main-menu-content">
                            <ul>
                                <li class="more-details">

                                    <a href="{{ route('lms-profile') }}"><i class="ti-user"></i>View Profile</a>

                                    <a href="#!"><i class="ti-settings"></i>Settings</a>

                                    <a href="{{ route('lms-profile') }}"><i class="ti-user"></i>View Profile</a>
                                          <a href="#!"><i class="ti-settings"></i>Settings</a>

                                          <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();" >
                                        <i class="ti-layout-sidebar-left"></i> Logout
                                    </a>

                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>
                                    
                                </li>
                            </ul>
                        </div>
                    </div>

                    <ul class="pcoded-item pcoded-left-item">
                        <li class="active">
                            <a href="#" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-home"></i><b>O</b></span>
                                <span class="pcoded-mtext">OSMS LMS</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                    <div class="pcoded-navigation-label"></div>
                    <ul class="pcoded-item pcoded-left-item">
                        <li class="pcoded-hasmenu active pcoded-trigger">
                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                <span class="pcoded-mtext">SITE</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">


                            <li class="@if(Request::segment(3) == 'site-overview')
                                active                  
                                @endif">
                                <a href="{{ route('lms-site-overview') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Site Overview</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                                <li class="@if(Request::segment(3) == 'profile')
                                active                  
                                @endif">
                                <a href="{{ route('lms-profile') }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Profle</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                            
                            <li class="@if(Request::segment(3) == 'calendar')
                            active                  
                            @endif">
                            <a href="{{ route('lms-calendar') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Calendar</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        
                        <li class=" @if(Request::segment(3) == 'Announcement-view')
                        active                  
                        @endif ">
                        <a href="{{ route('lms-Announcement-view') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Announcement</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li class=" @if(Request::segment(3) == 'private-files')
                    active                  
                    @endif ">
                    <a href="{{ route('lms-private-file') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Private Files</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class=" @if(Request::segment(3) == 'my-courses')
                active                  
                @endif ">
                <a href="{{ route('lms-my-courses') }}" class="waves-effect waves-dark">
                  <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                  <span class="pcoded-mtext">Courses</span>
                  <span class="pcoded-mcaret"></span>
              </a>
          </li>

                                {{-- <li class=" ">
                                    <a href="tooltip.html" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Preference</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="pcoded-content">
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Dashboard</h5>
                                    <p class="m-b-0">Welcome to OSMS | LMS</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#"> <i class="fa fa-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">@yield('mtitle')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Page-header end -->
                <div class="pcoded-inner-content">
                    <!-- Main-body start -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- Page-body start -->
                            <div class="page-body">

                                <?php
                                    $courses = App\Coureregistration::where('user_id', auth()->user()->id)
                                                ->where('fvrt','1')->get();
                                ?>
                                <?php
                                if (count($courses) > 0) {
                                    ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-block">
                                                

                                                @foreach ($courses as $row)


                                                <div class="dropdown-default dropdown open" style="margin-top: 10px;">
                                                    <button class="btn btn-outline-info dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-dropup-auto="false" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{{$row->cource_code}} </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">


                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-course-overview',['code' => $row->cource_code]) }}"><i class="fa fa-bars"></i> &nbsp;Overview</a>



                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-lesson-plan',['code' => $row->cource_code]) }}"><i class="fa fa-laptop"></i> &nbsp;Lesson Plan</a>



                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-ourse-materials', ['code' => $row->cource_code]) }}"><i class="fa fa-folder-open"></i> &nbsp;Resources</a>



                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-course-video', ['code' => $row->cource_code]) }}"><i class="fa fa-film"></i> &nbsp;E-Learning</a>



                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-Announcement',['code' => $row->cource_code]) }}"><i class="fa fa-bullhorn"></i> &nbsp;Announcement</a>



                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-tests-quiz',['code' => $row->cource_code]) }}"><i class="fa fa-check-square"></i> &nbsp;Tests & Quiz</a>



                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-assignment',['code' => $row->cource_code]) }}"><i class="fa fa-building"></i> &nbsp;Assignment(s)</a>



                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-zoom-meeting',['code' => $row->cource_code]) }}"><i class="fa fa-video-camera"></i> &nbsp;Meeting</a>



                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-chat-room-public',['code' => $row->cource_code]) }}"><i class="fa fa-comments"></i> &nbsp;Chatroom Public</a>

                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-chat-room-private',['code' => $row->cource_code]) }}"><i class="fa fa-comments"></i> &nbsp;Chatroom Prvate</a>

                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-attendance',['code' => $row->cource_code]) }}"><i class="fa fa-calendar-check-o"></i> &nbsp;Attendance</a>

                                                        <div class="dropdown-divider"></div>

                                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('lms-course-overview',['code' => $row->cource_code]) }}">View All &rarr;</a>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                    <!-- Border button -->
                                </div>
                                <?php
                                }
                                ?>

                                @include('notify_status.notify')
                                @yield('main_content')

                            </div>
                            <!-- Page-body end -->
                        </div>
                        <div id="styleSelector"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Required Jquery -->
<script type="text/javascript" src="{{ URL::to('lms/assets/js/jquery/jquery.min.js')}} "></script>
<script type="text/javascript" src="{{ URL::to('lms/assets/js/jquery-ui/jquery-ui.min.js')}} "></script>
<script type="text/javascript" src="{{ URL::to('lms/assets/js/popper.js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::to('lms/assets/js/bootstrap/js/bootstrap.min.js')}} "></script>
<!-- waves js -->
<script src="{{ URL::to('lms/assets/pages/waves/js/waves.min.js')}}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ URL::to('lms/assets/js/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

<!-- slimscroll js -->
<script src="{{ URL::to('lms/assets/js/jquery.mCustomScrollbar.concat.min.js')}} "></script>

<!-- menu js -->
<script src="{{ URL::to('lms/assets/js/pcoded.min.js')}}"></script>
<script src="{{ URL::to('lms/assets/js/vertical/vertical-layout.min.js')}} "></script>

<script type="text/javascript" src="{{ URL::to('lms/assets/js/script.js')}} "></script>

<!-- Print Js -->
<script type="text/javascript" src="{{ URL::to('js/jquery.PrintArea.js')}}"></script>

<!-- Sweet Alert Js -->
<script src="{{ URL::to('bower_components/sweetalert/sweertalert.js')}}"></script>

<!-- Loading Overlay Js -->
<script src="{{ URL::to('bower_components/loading_overlay/loading_overlay.js')}}"></script>

<script src="{{ URL::to('bower_components/socket_io/socket.io.js')}}"></script>


<script src="{{ URL::to('bower_components/toastr/toastr.js')}}"></script>
@toastr_render

@yield('script')

</body>

</html>
