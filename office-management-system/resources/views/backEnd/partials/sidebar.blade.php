<!-- sidebar part here -->
<nav id="sidebar" class="sidebar">


    <div class="sidebar-header update_sidebar">
        <a class="large_logo" href="{{url('/login')}}">
            <img src="{{ asset($setting->logo) }}" alt="">
        </a>
        <a class="mini_logo" href="{{url('/login')}}">
             <img src="{{ asset($setting->logo) }}" alt="">
        </a>
        <a id="close_sidebar" class="d-lg-none">
            <i class="ti-close"></i>
        </a>
    </div>

    <ul id="sidebar_menu">
        @if (auth()->user()->role->type != "normal_user")
            <li class="{{request()->is('home') ? 'mm-active' :''}}  " >
                <a href="{{ route('home') }}" aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-th"></span>
                    </div>
                    <div class="nav_title">
                        <span>{{__('common.Dashboard')}}</span>
                    </div>
                </a>
            </li>
        @endif

        @include('project::menu')
        @include('sale::menu')
        @include('contact::menu')
        @include('product::menu')
        @include('inventory::menu')
        @include('purchase::menu')
        @include('quotation::menu')
        @include('account::menu')
        @include('backEnd.menu')
        @include('leave::menu')
        @include('setting::menu')
        @include('backup::menu')
        @include('useractivitylog::menu')

    </ul>

</nav>
<!-- sidebar part end -->
