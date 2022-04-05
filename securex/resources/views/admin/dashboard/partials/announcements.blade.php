<div class="card">
    <div class="card-header bg-white">
        <div class="col-8">
            <h4>{{ __('dashboard.announcements.title') }}</h4>
        </div>
        <div class="col-4 text-right">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-announcement">{{ __('admin.dashboard.add_new_announcement') }}</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                @if(! $announcements->count())
                <p>No Announcements Available. Add a new announcement to get started.</p>
                @else
                <tr>
                    <th>#</th>
                    <th>{{ __('dashboard.announcements.title') }}</th>
                    <th>{{ __('snippets.date') }}</th>
                    <td>{{ __('snippets.action') }}
                </tr>
                @foreach($announcements as $announcement)
                <tr>
                    <td>1</td>
                    <td class="text-capitalize">
                        {{ $announcement->body }}
                    </td>
                    <td>
                        {{ $announcement->created_at->diffForHumans() }}
                    </td>
                    <td>
                        <button data-toggle="modal" data-target="#delete-announcement-{{ $announcement->id }}" class="btn btn-danger btn-icon"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
                @endif
            </table>
        </div>
    </div>
</div>