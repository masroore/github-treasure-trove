 <!-- START SECTION HEADINGS -->
 <!-- Header Container
        ================================================== -->
 <header id="header-container">
     <!-- Header -->
     <div id="header">
         <div class="container container-header">
             <!-- Left Side Content -->
             <div class="left-side">
                 <!-- Logo -->
                 <div id="logo">
                     <a href="/"><img src="{{ asset('images/logo-red.svg')}}" alt=""></a>
                 </div>
                 <!-- Mobile Navigation -->
                 <div class="mmenu-trigger">
                     <button class="hamburger hamburger--collapse" type="button">
                         <span class="hamburger-box">
                             <span class="hamburger-inner"></span>
                         </span>
                     </button>
                 </div>
                 <!-- Main Navigation -->
                 <nav id="navigation" class="style-1">
                     <ul id="responsive">
                         <li><a href="/">Home</a>

                         </li>
                         <li><a href="{{ route('all.properties')}}">Properties Listing</a>

                         </li>
                         <li><a href="{{ route('about.us')}}">About Us</a>
                         </li>
                         <li><a href="{{ route('all.blogs')}}">Blogs</a>
                         </li>
                         {{-- <li><a href="{{ route('contact.us')}}">Contact</a></li> --}}
                         <li class="d-none d-xl-none d-block d-lg-block"><a href="login.html">Login</a></li>
                         <li class="d-none d-xl-none d-block d-lg-block"><a href="register.html">Register</a>
                         </li>
                         <li class="d-none d-xl-none d-block d-lg-block mt-5 pb-4 ml-5 border-bottom-0"><a
                                 href="add-property.html" class="button border btn-lg btn-block text-center">Add
                                 Listing<i class="fas fa-laptop-house ml-2"></i></a></li>
                     </ul>
                 </nav>
                 <!-- Main Navigation / End -->
             </div>
             <!-- Left Side Content / End -->

             <!-- Right Side Content / End -->
             <div class="right-side d-none d-none d-lg-none d-xl-flex">
                 <!-- Header Widget -->
                 <div class="header-widget">
                 @if (!Auth::check())
                     <a href="{{ route('login')}}" class="button border">Sign In<i
                             class="fas fa-laptop-house ml-2"></i></a>
                 @endif
                 </div>
                 <!-- Header Widget / End -->
             </div>
             <!-- Right Side Content / End -->

             <!-- Right Side Content / End -->
             {{-- <div class="header-user-menu user-menu add">
                 <div class="header-user-name">
                     <span><img src="{{ asset('images/testimonials/ts-1.jpg')}}" alt=""></span>Hi, Mary!
                 </div>
                 <ul>
                     <li><a href="user-profile.html"> Edit profile</a></li>
                     <li><a href="add-property.html"> Add Property</a></li>
                     <li><a href="payment-method.html"> Payments</a></li>
                     <li><a href="change-password.html"> Change Password</a></li>
                     <li><a href="#">Log Out</a></li>
                 </ul>
             </div>
             <!-- Right Side Content / End --> --}}

             {{-- <div class="right-side d-none d-none d-lg-none d-xl-flex sign ml-0">
                 <!-- Header Widget -->
                 <div class="header-widget sign-in">
                     <div class="show-reg-form modal-open"><a href="#">Sign In</a></div>
                 </div>
                 <!-- Header Widget / End -->
             </div> --}}
             <!-- Right Side Content / End -->

             <!-- lang-wrap-->
             {{-- <div class="header-user-menu user-menu add d-none d-lg-none d-xl-flex">
                 <div class="lang-wrap">
                     <div class="show-lang"><span><i class="fas fa-globe-americas"></i><strong>ENG</strong></span><i
                             class="fa fa-caret-down arrlan"></i></div>
                     <ul class="lang-tooltip lang-action no-list-style">
                         <li><a href="#" class="current-lan" data-lantext="En">English</a></li>
                         <li><a href="#" data-lantext="Fr">Francais</a></li>
                         <li><a href="#" data-lantext="Es">Espanol</a></li>
                         <li><a href="#" data-lantext="De">Deutsch</a></li>
                     </ul>
                 </div>
             </div>
             <!-- lang-wrap end--> --}}

         </div>
     </div>
     <!-- Header / End -->

 </header>
 <div class="clearfix"></div>
 <!-- Header Container / End -->
