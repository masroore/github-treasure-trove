<!DOCTYPE html>
<html lang="en">

<head>
  <title>@yield('title')</title>
  <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords" content="" />
    <meta name="author" content="Codedthemes" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{ URL::to('lms/assets/images/favicon.ico')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ URL::to('lms/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('lms/assets/css/bootstrap/css/bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ URL::to('lms/assets/css/bootstrap/css/bootstrap.css')}}">

    <!-- waves.css -->
    <link rel="stylesheet" href="{{ URL::to('lms/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('lms/assets/icon/themify-icons/themify-icons.css')}}">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to("lms/assets/css/font-awesome-n.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to("lms/assets/css/font-awesome.min.css")}}">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to("lms/assets/css/jquery.mCustomScrollbar.css")}}">

    <link rel="stylesheet" href="{{ URL::to('bower_components/bootstrap/dist/css/adminlte.min.css')}}">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::to("lms/assets/css/style.css")}}">

    <link rel="stylesheet" href="{{ URL::to('bower_components/toastr/toastr.css')}}">

    <style type="text/css">

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
      left: 45px;
      bottom: 30px;
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

.has-error .help-block,
.has-error .control-label,
.has-error .radio,
.has-error .checkbox,
.has-error .radio-inline,
.has-error .checkbox-inline,
.has-error.radio label,
.has-error.checkbox label,
.has-error.radio-inline label,
.has-error.checkbox-inline label {
  color: #a94442;
}
.has-error .form-control {
  border-color: #a94442;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}
.has-error .form-control:focus {
  border-color: #843534;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #ce8483;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 6px #ce8483;
}
.has-error .input-group-addon {
  color: #a94442;
  background-color: #f2dede;
  border-color: #a94442;
}
.has-error .form-control-feedback {
  color: #a94442;
}
.has-feedback label ~ .form-control-feedback {
  top: 25px;
}
.has-feedback label.sr-only ~ .form-control-feedback {
  top: 0;
}
.help-block {
  display: block;
  margin-top: 5px;
  margin-bottom: 10px;
  color: #737373;
}

.sticky {
  position: fixed;
  top: 0;
  box-shadow: 5px 10px #888888;
}
.time{
  border-radius: 50px;
  bottom: 30px;
  right: 20px;
  width: 200px;
  color:white;
  background: #3b98ff;
  padding: 12px 20px;
  text-transform: capitalize;
  font-weight: bold;
  font-size: 16px;
  position: fixed;
  -webkit-transition: all 0.5s ease;
  transition: all 0.5s ease;
  -webkit-animation: pulse 2s infinite;
  animation: pulse 2s infinite;
}


@-webkit-keyframes pulse {
  0% {
    -webkit-box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3);
    box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3)
  }
  70% {
    -webkit-box-shadow: 0 0 0 20px rgba(4, 169, 245, 0);
    box-shadow: 0 0 0 20px rgba(4, 169, 245, 0)
  }
  100% {
    -webkit-box-shadow: 0 0 0 0 rgba(4, 169, 245, 0);
    box-shadow: 0 0 0 0 rgba(4, 169, 245, 0)
  }
}

@keyframes pulse {
  0% {
    -webkit-box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3);
    box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3)
  }
  70% {
    -webkit-box-shadow: 0 0 0 20px rgba(4, 169, 245, 0);
    box-shadow: 0 0 0 20px rgba(4, 169, 245, 0)
  }
  100% {
    -webkit-box-shadow: 0 0 0 0 rgba(4, 169, 245, 0);
    box-shadow: 0 0 0 0 rgba(4, 169, 245, 0)
  }
}

</style>
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
                      <img class="d-flex align-self-center img-radius" src="{{URL::to('lms/assets/images/avatar-2.jpg')}}" alt="Generic placeholder image">
                      <div class="media-body">
                        <h5 class="notification-user">John Doe</h5>
                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                        <span class="notification-time">30 minutes ago</span>
                      </div>
                    </div>
                  </li>
                  <li class="waves-effect waves-light">
                    <div class="media">
                      <img class="d-flex align-self-center img-radius" src="{{URL::to('lms/assets/images/avatar-4.jpg')}}" alt="Generic placeholder image">
                      <div class="media-body">
                        <h5 class="notification-user">Joseph William</h5>
                        <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                        <span class="notification-time">30 minutes ago</span>
                      </div>
                    </div>
                  </li>
                  <li class="waves-effect waves-light">
                    <div class="media">
                      <img class="d-flex align-self-center img-radius" src="{{URL::to('lms/assets/images/avatar-3.jpg')}}" alt="Generic placeholder image">
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
                                        <a href="{{ route('passconfirm') }}">
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
                                    <span class="pcoded-mtext">Overview</span>
                                    <span class="pcoded-mcaret"></span>
                                  </a>
                                  <ul class="pcoded-submenu">

                                    <li class="@if(Request::segment(3) == 'course-overview')
                                    active                  
                                    @endif">
                                    <a href="{{ route('lms-course-overview',['code' => $code]) }}" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                      <span class="pcoded-mtext">Overview</span>
                                      <span class="pcoded-mcaret"></span>
                                    </a>
                                  </li>


                                  <li class="@if(Request::segment(3) == 'lesson-plan')
                                    active                  
                                    @endif">
                                    <a href="{{ route('lms-lesson-plan',['code' => $code]) }}" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                      <span class="pcoded-mtext">Lesson Plan</span>
                                      <span class="pcoded-mcaret"></span>
                                    </a>
                                  </li>

                                  <li class="@if(Request::segment(3) == 'course-materials')
                                  active                  
                                  @endif">
                                  <a href="{{ route('lms-ourse-materials',['code' => $code]) }}" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Resources</span>
                                    <span class="pcoded-mcaret"></span>
                                  </a>
                                </li>
                                <li class="@if(Request::segment(3) == 'course-video')
                                active                  
                                @endif ">
                                <a href="{{ route('lms-course-video',['code' => $code]) }}" class="waves-effect waves-dark">
                                  <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                  <span class="pcoded-mtext">E-Learning</span>
                                  <span class="pcoded-mcaret"></span>
                                </a>
                              </li>
                              <li class="@if(Request::segment(3) == 'Announcement')
                              active                  
                              @endif">
                              <a href="{{ route('lms-Announcement',['code' => $code]) }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Announcement</span>
                                <span class="pcoded-mcaret"></span>
                              </a>
                            </li>
                            <li class=" @if(Request::segment(3) == 'tests-quiz')
                            active                  
                            @endif">
                            <a href="{{ route('lms-tests-quiz',['code' => $code]) }}" class="waves-effect waves-dark">
                              <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                              <span class="pcoded-mtext">Tests & Quiz</span>
                              <span class="pcoded-mcaret"></span>
                            </a>
                          </li>
                          <li class="@if(Request::segment(3) == 'assignment')
                          active                  
                          @endif ">
                          <a href="{{ route('lms-assignment',['code' => $code]) }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Assignment</span>
                            <span class="pcoded-mcaret"></span>
                          </a>
                        </li>
                        <li class=" @if(Request::segment(3) == 'meeting-zoom')
                        active                  
                        @endif">
                        <a href="{{ route('lms-zoom-meeting',['code' => $code]) }}" class="waves-effect waves-dark">
                          <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                          <span class="pcoded-mtext">Meetings</span>
                          <span class="pcoded-mcaret"></span>
                        </a>
                      </li>
                      <li class=" @if(Request::segment(3) == 'chat-room-public')
                      active                  
                      @endif">
                      <a href="{{ route('lms-chat-room-public',['code' => $code]) }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Public Chat</span>
                        <span class="pcoded-mcaret"></span>
                      </a>
                    </li>

                    <li class="@if(Request::segment(3) == 'chat-room-private')
                    active                  
                    @endif ">
                    <a href="{{ route('lms-chat-room-private',['code' => $code]) }}" class="waves-effect waves-dark">
                      <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                      <span class="pcoded-mtext">Private Chat</span>
                      <span class="pcoded-mcaret"></span>
                    </a>
                  </li>

                  

                  <li class=" @if(Request::segment(3) == 'attendance')
                  active                  
                  @endif">
                  <a href="{{ route('lms-attendance',['code' => $code]) }}" class="waves-effect waves-dark">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Attendance</span>
                    <span class="pcoded-mcaret"></span>
                  </a>
                </li>

                <li class=" @if(Request::segment(3) == 'tests')
                active                  
                @endif">
                <a href="{{ route('lms-tests-quiz',['code' => $code]) }}" class="waves-effect waves-dark">
                  <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                  <span class="pcoded-mtext">Help</span>
                  <span class="pcoded-mcaret"></span>
                </a>
              </li>

            </ul>
          </li>

        </ul>

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
          $courses = App\Coureregistration::where('user_id', auth()->user()->id)->where('fvrt','1')->get();
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
                      <button class="btn <?php
                      if($code == $row->cource_code){
                        ?>
                        btn-outline-info
                        <?php
                        }else{
                          ?>
                          btn-outline-success
                          <?php
                        }
                        ?>  dropdown-toggle waves-effect waves-light " type="button" id="dropdown-2" data-dropup-auto="false" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{{$row->cource_code}} </button>
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

@yield('script');
</body>

</html>
