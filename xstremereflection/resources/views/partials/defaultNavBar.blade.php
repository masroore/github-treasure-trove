<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top" >
        <a class="sidebar-brand brand-logo" href="index.html"><img src="{{ url('assets/img/logo1.png') }}" alt="logo" /></a>
        <a class="sidebar-brand brand-logo-mini" href="index.html"><img src="{{ url('assets/img/logo1.png') }}" alt="logo" /></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{auth()->user()->first_name ?? ''}} {{auth()->user()->last_name ?? ''}}</h5>
                        <span></span>
                    </div>
                </div>
                <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-primary"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-onepassword  text-info"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-calendar-today text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/dashboard">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/mycalendar">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
                <span class="menu-title">My Calendar</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/bidding" disabled>
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
                <span class="menu-title">Biddable Jobs</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#my-estimates" aria-expanded="false" aria-controls="my-estimates">
              <span class="menu-icon">
                <i class="fal fa-file-invoice"></i>
              </span>
                <span class="menu-title">My Estimates</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="my-estimates">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/estimate">Pending Estimates</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/estimate/canceled">Canceled Estimates</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/estimate/completed">Completed Estimates</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#my-work-orders" aria-expanded="false" aria-controls="my-work-orders">
              <span class="menu-icon">
                <i class="fad fa-car-wash"></i>
              </span>
                <span class="menu-title">My Work Orders</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="my-work-orders">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/workorder">Active Work Orders</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/workorder/canceled">Canceled Work Orders</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/workorder/completed">Completed Work Orders</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" href="/invoice">
              <span class="menu-icon">
                <i class="fas fa-file-invoice-dollar"></i>
              </span>
                <span class="menu-title">Invoices</span>
            </a>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="/completed">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
                <span class="menu-title">Completed Work Orders</span>
            </a>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#my-services" aria-expanded="false" aria-controls="my-services">
              <span class="menu-icon">
                <i class="mdi mdi-view-list"></i>
              </span>
                <span class="menu-title">My Services</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="my-services">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/services">Service List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/layout/rtl-layout.html">Add New Service</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#my-packages" aria-expanded="false" aria-controls="my-packages">
              <span class="menu-icon">
                <i class="mdi mdi-view-list"></i>
              </span>
                <span class="menu-title">My Packages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="my-packages">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="/packages">Package List</a></li>
                    <li class="nav-item"> <a class="nav-link" href="/package/create">Add New Package</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
