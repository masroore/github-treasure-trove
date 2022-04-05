<header class="main-header">
    <!-- Logo -->
    <a href="{{ \UrlAliasLocalization::getRoot() }}" class="logo" target="_blank">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="{{--{{ request()->fullUrlWithQuery(['lte_sidebar_collapse' => 0]) }}--}}" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu pull-left">
        <ul class="nav navbar-nav">
          <li class="user user-menu" title="Системное время: {{ \Carbon\Carbon::now() }}">
            <a href="#" class="" data-toggle="">
              <i class="fa fa-clock-o"></i>
            </a>
          </li>
          <li class="user user-menu" title="Курс НБУ: {{ \Currency::getNBURatesStr() }}">
            <a href="#" class="" data-toggle="">
              <i class="fa fa-bar-chart"></i>
            </a>
          </li>
        </ul>

        <ul class="nav navbar-nav filter-languages">
          @foreach(\UrlAliasLocalization::getLocalesOrder() as $key => $properties)
            <li class="dropdown messages-menu">
              @if(in_array($key, session('app_locales', [])))
                <a href="{{ \Illuminate\Support\Facades\Request::fullUrlWithQuery(['app_locale' => $key]) }}" class="act">{{ $key }}</a>
              @else
                <a href="{{ \Illuminate\Support\Facades\Request::fullUrlWithQuery(['app_locale' => $key]) }}" >{{ $key }}</a>
              @endif
            </li>
          @endforeach
        </ul>
      </div>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          {{--
          <li class="messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-shopping-cart"></i>
              <span class="label label-success">4</span>
            </a>
          </li>
          <li class="notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-warning">10</span>
            </a>
          </li>
          <li class="tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-danger">9</span>
            </a>
          </li>
          --}}

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="account-icon"><i class="fa fa-sign-in"></i></span>
              <span class="hidden-xs">{{ \Auth::user()->full_name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('admin.account.edit') }}" class="btn btn-default btn-flat">Аккаунт</a>
                </div>
                <div class="pull-right">
                  <a href="#"
                     class="btn btn-default btn-flat js-action-click"
                     data-url="{{ route('logout') }}"
                     data-confirm="Подтверждаете выход?"
                  >Выйти</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>