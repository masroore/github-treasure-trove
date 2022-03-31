@if(Auth::user() != '' && Auth::user()->account_type != 'Client')
  @if(Auth::user()->verification == 1)
  <div class="alert alert-warning text-black text-center py-0 mb-0 position-absolute top-0 w-100" role="alert" style="z-index: 1020; font-size: 12px;">Please upload your ID/Passport image to fully verify your account in <strong>24 hours</strong>. click here to verify <a href="{{url('account-setting#verify_account')}}">Account Setting</a></div>
  @endif
@endif
@if(Auth::user() != '' && Auth::user()->account_type == 'Client')
  @if(Auth::user()->verification == 1)
  <div class="alert alert-warning text-black text-center py-0 mb-0 position-absolute top-0 w-100" role="alert" style="z-index: 1020; font-size: 12px;">Please update your payments details to fully verify your account in <strong>24 hours</strong>. click here to verify <a href="{{url('account-setting#verify_account')}}">Account Setting</a></div>
  @endif
@endif
<header>
  <div class="home-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-6 col-md-3 d-flex flex-row">
          <div class="logo">
            <a class="logo-1" href="{{ url('/')}}"><img src="{{ asset('assets/images/logo.png') }}" width="150"></a>
            <a class="home-logo" href="{{ url('/')}}"><img src="{{ asset('assets/images/logo.png') }}" alt="961 Freelancer" width="150"></a>
            
          </div>
        </div>
        <div class="col-6 col-md-9">
          <div class="header-right d-flex align-items-center justify-content-end">
            <div class="menu-inner">
              <ul class="mb-0 d-flex align-items-center">
                <li><a href="{{route('home')}}" class="main-top-menu">Home</a></li>
                <!-- <li><a href="">How it Works</a></li> -->
                <li><a href="{{ route('job.index') }}" class="main-top-menu">Browse Jobs</a></li>
                <li><a href="{{ route('freelancers.index') }}" class="main-top-menu">Browse Freelancers</a></li>
                @if(Auth::user())
                <li>
                  <a href="{{ route('messages') }}" class="position-relative">Messages
                    <span class="badge badge-danger messageCount badge-notification position-absolute top-0 translate-middle p-1 bg-danger border border-light rounded-circle">{{ App\Models\ChatMessages::getUnseenMsg() }}</span>
                  </a> 
                </li>
                <li class="dropdown notification">
                  <a href="javascript:void(0);" class="position-relative" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fal fa-bell"></i>
                    <span class="badge badge-danger notiCount badge-notification position-absolute top-0 translate-middle p-1 bg-danger border border-light rounded-circle">{{ App\Models\Notification::getUnseenNoti() }}</span>
                  </a> 
                  <ul class="dropdown-menu notification-dropdown py-0 notification-list">
                    <li class="head text-white w-100">
                      <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                          <span>Notifications</span>
                          <!-- <a href="" class="float-right text-light">Mark all as read</a> -->
                        </div>
                      </li>

                      @foreach(App\Models\Notification::getAllNoti() as $key => $notif)
                      <li class="notification-box {{$key == 0 ? 'first-notification-box': ''}} {{$notif->status == 'unread' ? 'bg-light': ''}} w-100" onclick="readNoti({{$notif->id}})">
                        <div class="row">
                          <div class="col-lg-12 col-sm-12 col-12">
                            <div class="noti-msg">
                              @if($notif->noti_type == 'proposal' || $notif->noti_type == 'milestone' || $notif->noti_type == 'project')
                              <a href="{{url('proposals')}}" class="pe-0">{{$notif->message}}</a>
                              @endif
                              @if($notif->noti_type == 'hire')
                              <a href="{{url('ongoing-jobs')}}" class="pe-0">{{$notif->message}}</a>
                              @endif
                              @if($notif->noti_type == 'reject')
                              <a href="{{url('proposals')}}" class="pe-0">{{$notif->message}}</a>
                              @endif
                            </div>
                          </div>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                </li>
                <li>
                  <div class="wt-userlogedin wallet d-none p-0 {{ Auth::user()->account_type === "Freelancer" ? "d-sm-block" : "d-sm-flex align-items-center" }}">
                    
                    <div class="wt-username">
                      <span class="mb-0">
                        <i class="far fa-dollar-sign mr-1" aria-hidden="true"></i>
                        @if (App\Models\User::walletAmt())
                        {{ App\Models\User::walletAmt()->amt }}
                        @else
                        0.0
                        @endif
                      </span>
                    </div>
                    <!-- <nav class="wt-usernav">
                      <ul>
                        <li>
                          <a href="{{route('payments.deposit')}}">
                            <span>Deposit in Wallet</span>
                          </a>
                        </li>
                      </ul>
                    </nav> -->
                  </div>
                </li>
                @endif
              </ul>
            </div>
            @if(Auth::user() == '')
            <div class="Login-button">
              <a href="{{ route('login') }}">Login</a>
              <a href="{{ route('register') }}">Join Now</a>
            </div>
            @else

            <div class="wt-userlogedin d-none {{ Auth::user()->account_type === "Freelancer" ? "d-sm-block" : "d-sm-flex align-items-center" }}">
              <figure class="wt-userimg">
                @if(Auth::user()->profile_image != '')
                  @if(!empty(Auth::user()->facebook_id) || !empty(Auth::user()->google_id))
                    <img src="{{Auth::user()->profile_image}}" width="" height="" class="img-fluid rounded-circle mb-3" alt="">
                    @else
                    <img src="{{asset('assets/images/user/profile/'.Auth::user()->profile_image)}}" width="100px" height="100px" class="img-fluid rounded-circle mb-3" alt="">
                    @endif
                @else
                  <img src="{{asset('assets/images/user-login.png')}}" alt="img description">
                @endif
              </figure>
              <div class="wt-username">
                <h3 class="mb-0">{{Auth::user()->username}}</h3>
                @if(Auth::user()->account_type != 'Client')
                <span class="pt-1">{{Auth::user()->tagline}}</span>
                @endif
              </div>
              <nav class="wt-usernav">
                <ul>
                  @if(Auth::user()->account_type == 'Freelancer')
                  <li>
                    <a href="{{route('freelancer-dashboard')}}">
                      <span>Dashboard</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{url('freelancer/'.Auth::user()->username)}}">
                      <span>View Profile</span>
                    </a>
                  </li>
                  @endif
                  @if(Auth::user()->account_type == 'Client')
                  <li>
                    <a href="{{route('client.dashboard')}}">
                      <span>Dashboard</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{url('client/'.Auth::user()->username)}}">
                      <span>View Profile</span>
                    </a>
                  </li>
                  @endif
                  <li>
                    <a href="{{url('profile')}}">
                      <span>My Profile</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('payments.deposit')}}">
                      <span>Deposit in Wallet</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('withdraw')}}">
                      <span>Withdraw</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('logout')}}">
                      <span>Logout</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
            @endif
            <div class="menubar">
              <div class="d-flex flex-row align-items-center">
                <div class="image">
                  <img src="" alt="">
                  <img src="" alt="">
                </div>
                <div class="icon">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- End New Design -->
<!-- Offcanvas-menu -->
<div class="ofcanvas-menu pre-login">
  <div class="close-icon">
    <i class="fal fa-times"></i>
  </div>
  @if(Auth::user() != '')
  <div class="profile-inner text-center">

    @if(!empty(Auth::user()->profile_image))
      @if(!empty(Auth::user()->facebook_id) || !empty(Auth::user()->google_id))
      <img src="{{Auth::user()->profile_image}}" width="100px" height="100px" class="img-fluid rounded-circle mb-3" alt="">
      @else
      <img src="{{asset('assets/images/user/profile/'.Auth::user()->profile_image)}}" width="100px" height="100px" class="img-fluid rounded-circle mb-3" alt="">
      @endif
    @else
    <img src="{{asset('assets/images/user-login.png')}}"  class="img-fluid rounded-circle mb-3" width="100px" height="100px">
    @endif
    <h4>Welcome back, <span>{{Auth::user()->username}}</span></h4>
  </div>
  @endif
  <div class="canvs-menu">
    <ul class="d-flex flex-column mb-0">
      <li>
        <a href="{{ route('freelancers.index') }}">Browse Freelancers</a>
      </li>
      <li>
        <a href="{{ route('about-us') }}">About Us</a>
      </li>
      @if(Auth::user() != '')
      <li>
        <a href="{{ route('job.index') }}">Browse Jobs</a>
      </li>
      <li>
        <a href="{{url('profile')}}">Profile</a>
      </li>
      <li>
        <a href="{{route('logout')}}">Logout</a>
      </li>
      @endif
      @if(Auth::user() == '')
      <li class="mb-4">
        <a class="button login-button" href="{{ route('login') }}">Login</a>
      </li>
      <li>
        <a class="button join-button" href="{{ route('register') }}">Join Now</a>
      </li>
      @endif
    </ul>
  </div>
</div>
<!-- Close-overlay -->
<div class="overlay-bg"></div>
<!-- Offcanvas-menu END-->