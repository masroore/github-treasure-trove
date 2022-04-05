<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/posts') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.post.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.user.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/cities') }}"><i class="nav-icon icon-umbrella"></i> {{ trans('admin.city.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/offices') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.office.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/routes') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.route.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/models') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.model.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/transports') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.transport.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/schedules') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.schedule.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/passengers') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.passenger.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/tickets') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.ticket.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/post-users') }}"><i class="nav-icon icon-plane"></i> {{ trans('admin.post-user.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/office-users') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.office-user.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
