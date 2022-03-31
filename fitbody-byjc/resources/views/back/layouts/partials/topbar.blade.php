<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <!-- END Toggle Sidebar -->

            <!-- Open Search Section -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->

            <!-- END Open Search Section -->

            <!-- Layout Options (used just for demonstration) -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->

            <!-- END Layout Options -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">

            @if (app()->isDownForMaintenance())
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i style="color: red;" class="fa fa-power-off"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right min-width-300" aria-labelledby="page-header-notifications">
                        <div class="text-center mt-15">
                            <i style="color: red;" class="si si-power font-size-h3"></i>
                            <h5 class="h6 text-center py-10 mb-5 text-uppercase font-w300">Stranica je offline..!</h5>
                            <a href="{{ route('maintenance.off') }}" class="btn btn-rounded btn-outline-primary min-width-125 mb-10">Uključite je!</a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- User Dropdown -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block">{{ auth()->user()->name }}</span>
                    <i class="fa fa-angle-down ml-5"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                    {{--<h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">User</h5>--}}
                    <a class="dropdown-item text-info" href="{{ route('index') }}" target="_blank">
                        <i class="si si-layers mr-5"></i> Početna stranica
                    </a>

                    @if (Bouncer::is(auth()->user())->an('admin'))
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-primary" href="{{ route('cache') }}">
                            <i class="si si-layers mr-5"></i> Očisti Cache
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('config.clear') }}">
                            <i class="si si-anchor mr-5"></i> Očisti Config Cache
                        </a>
                        <a class="dropdown-item" href="{{ route('views.clear') }}">
                            <i class="si si-camcorder mr-5"></i> Očisti Views Cache
                        </a>
                        <a class="dropdown-item" href="{{ route('routes.clear') }}">
                            <i class="si si-compass mr-5"></i> Očisti Routes Cache
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-warning" href="{{ route('maintenance.on') }}">
                            <i class="si si-ban mr-5"></i> Održavanje Mode ON
                        </a>
                        <a class="dropdown-item text-primary" href="{{ route('maintenance.off') }}">
                            <i class="si si-control-play mr-5"></i> Održavanje Mode OFF
                        </a>
                    @endif

                    @if (Bouncer::is(auth()->user())->an('editor'))
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-primary" href="{{ route('profile') }}">
                            <i class="si si-user mr-5"></i> Moj Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('messages') }}">
                            <i class="si si-envelope mr-5"></i> Poruke
                        </a>
                    @endif

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="si si-logout mr-5"></i> Odjava
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Notifications -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-danger badge-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @else
                        <i class="fa fa-bell-o"></i>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-300" aria-labelledby="page-header-notifications">
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Notifikacije</h5>
                        <ul class="list-unstyled mt-10">
                            @foreach(auth()->user()->unreadNotifications as $notifications)
                                <li>
                                    <a class="text-body-color-dark media mb-10" href="#">
                                        <div class="ml-5 mr-15">
                                            <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                                        </div>
                                        <div class="media-body pr-10">
                                            <p class="mb-0">{{ $notifications->data['message'] }}</p>
                                            <div class="text-muted font-size-sm font-italic mb-0">{{ date_format(date_create($notifications->created_at), 'd.m.Y. h:i:s') }}</div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center mb-0" href="javascript:void(0)">
                            <i class="fa fa-flag mr-5"></i> Pročitaj sve
                        </a>
                    @else
                        <div class="text-center mt-15">
                            <i class="si si-cup font-size-h3"></i>
                        </div>
                        <h5 class="h6 text-center py-10 mb-5 text-uppercase font-w300">Nemate novih notifikacija!</h5>
                    @endif
                </div>
            </div>

        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    <div id="page-header-search" class="overlay-header">
        <div class="content-header content-header-fullrow">
            <form action="/dashboard" method="POST">
                @csrf
                <div class="input-group">
                    <div class="input-group-prepend">
                        <!-- Close Search Section -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-secondary" data-toggle="layout" data-action="header_search_off">
                            <i class="fa fa-times"></i>
                        </button>
                        <!-- END Close Search Section -->
                    </div>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Header Search -->

    <!-- Header Loader -->
    <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
<!-- END Header -->
