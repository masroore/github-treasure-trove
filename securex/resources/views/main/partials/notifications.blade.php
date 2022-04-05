@if(auth()->user()->unreadNotifications->count())
<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
  <div class="dropdown-menu dropdown-list dropdown-menu-right">
    <div class="dropdown-header">{{ __('profile.notifications') }} ({{ auth()->user()->notifications->count()}})
      <div class="float-right">
        <a href="{{ route('profile.notifications.mark') }}"><i class="fas fa-eye-slash"></i> {{ __('profile.mark_read') }}</a>
      </div>
    </div>
    <div class="dropdown-list-content dropdown-list-icons">
      @foreach(auth()->user()->unreadNotifications as $notification)
      <a href="{{ $notification->data['url']. '?read=' .$notification->id }}" class="dropdown-item dropdown-item-unread">
        <div class="dropdown-item-icon bg-{{ $notification->data['type'] }} text-white">
          <i class="fas fa-bell"></i>
        </div>
        <div class="dropdown-item-desc">
          {{ $notification->data['message'] }}
          <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
        </div>
      </a>
      @endforeach
    </div>
    <div class="dropdown-footer text-center">
      <a href="{{ route('profile.notifications') }}"><i class="fas fa-eye"></i> {{ __('profile.view_all') }} <i class="fas fa-chevron-right"></i></a>
    </div>
  </div>
</li>
@else
<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i></a>
  <div class="dropdown-menu dropdown-list dropdown-menu-right">
    <div class="dropdown-header">{{ __('profile.notifications') }} ({{ auth()->user()->notifications->count()}})
    </div>
    <div class="dropdown-list-content dropdown-list-icons">
      <a href="#" class="dropdown-item dropdown-item-unread">
        <div class="dropdown-item-desc">
          {{ __('profile.no_notifications') }}
        </div>
      </a>
    </div>
    <div class="dropdown-footer text-center">
      <a href="{{ route('profile.notifications') }}"><i class="fas fa-eye"></i> {{ __('profile.view_all') }} <i class="fas fa-chevron-right"></i></a>
    </div>
  </div>
</li>
@endif