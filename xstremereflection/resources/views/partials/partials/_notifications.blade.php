
<li class="nav-item dropdown border-left">
    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
        <i class="mdi mdi-bell @if(auth()->user()->unreadNotifications->count()) @else text-success  @endif"></i>
        @if(auth()->user()->unreadNotifications->count()) <span class="count bg-danger"> {{ auth()->user()->unreadNotifications->count() }} </span> @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" style="width: 50rem;">
        <h6 class="p-3 mb-0">Notifications</h6>
        <div class="dropdown-divider"></div>
        <div style="overflow: auto">
            @if(auth()->user()->unreadNotifications->count())
                <a class="dropdown-item preview-item" href="{{ route('markAllRead') }}">
                    <div class="preview-thumbnail">
                        <div class="preview-icon bg-dark rounded-circle">
                            <i class="mdi mdi-delete-forever text-danger"></i>
                        </div>
                    </div>
                    <div class="preview-item-content">
                        <p class="preview-subject mb-1">Read</p>
                        <p class="text-muted ellipsis mb-0"> Mark all notifications as read. </p>
                    </div>
                </a>
                @foreach(auth()->user()->unreadNotifications as $notification)
                    <a class="dropdown-item preview-item" @if(empty($notification->data['link'])) @else <a href='{{$notification->data['link']}}' @endif>
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                @if(empty($notification->data['img']))	<i class="mdi mdi-bell-ring text-warning"></i> @else <img src="{{ asset($notification->data['img']) }} " alt="Notification" height="42" width="42"> @endif
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Notification</p>
                            <p class="text-muted text-wrap mb-0"> {!! $notification->data['data'] !!} </p>
                        </div>
                        <div class="preview-item-content">

                            <p class="text-muted ellipsis mb-0"> {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }} </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    @endforeach
                    @else
                        <a class="dropdown-item preview-item" href="{{ route('markAllRead') }}">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-emoticon-happy text-success"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject mb-1">No Notifications</p>
                                <p class="text-muted ellipsis mb-0"> Have a good day!!! </p>
                            </div>
                        </a>
                    @endif
        </div>


        <p class="p-3 mb-0 text-center">See all notifications</p>
    </div>
</li>
