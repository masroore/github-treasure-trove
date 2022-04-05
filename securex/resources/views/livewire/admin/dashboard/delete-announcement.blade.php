<form wire:submit.prevent="deleteAnnouncement">
    @csrf
    <div class="card card-danger mb-0">
        <div class="card-header">
            <h4 class="text-danger">{{ __('admin.dashboard.delete_announcement') }}</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <p>{!! Lang::get('admin.dashboard.delete_announcement_msg', ['body' => $announcement->body]) !!}</p>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-whitesmoke">
        <button type="submit" class="btn btn-danger btn-shadow"><i class="fas fa-trash"></i> {{ __('admin.dashboard.delete_announcement') }}</button>
    </div>
</form>