<div class="col-xl-4 mb-xl-0">
    <div class="card shadow pull-up">
        <div class="card-header border-0">
            <div class="col-8">
                <h4>{{ __('dashboard.announcements.latest') }}</h4>
            </div>
            <div class="col-4 text-right">
                <a href="{{ route('dashboard.announcements') }}">
                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('dashboard.announcements.view_all') }}"><i class="fas fa-eye text-primary"></i></span>
                </a>
            </div>
        </div>
        @if($announcement)
        <div class="card-body bg-secondary">
            <blockquote class="blockquote bg-secondary text-left">
                <h5>{{ $announcement->body }}</h5>
            </blockquote>
        </div>
        <div class="card-footer">
            <footer class="blockquote-footer"><small>{{ $announcement->created_at->diffForHumans() }}</small></footer>
        </div>
        @else
        <div class="card-footer bg-secondary">
            <footer class="blockquote-footer">{{ __('dashboard.announcements.none') }}</footer>
        </div>
        @endif
    </div>
</div>