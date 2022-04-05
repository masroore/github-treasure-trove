<div class="card" id="access-card">
    <div class="card-header bg-white">
        <div class="col-8">
            <h4>{{ __('admin.settings.access') }}</h4>

        </div>
        <div class="col-4 text-right">
            <a class="btn btn-primary collapsed" data-toggle="collapse" href="#accessCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                Show / Hide Settings
            </a>
        </div>
    </div>
    <div class="collapse" id="accessCollapse">
        @if(Setting::get('app_mode') === 'PUBLIC')
        <form method="POST" action="{{ route('admin.settings.system.access.private') }}">
            @csrf
            <div class="card-body bg-secondary">
                <div class="form-group row align-items-center">
                    <label for="access" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.mode') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <button type="button" class="btn btn-primary">
                            {{ __('admin.settings.public') }} <span class="badge badge-transparent"><i class="fas fa-globe-asia"></i></span>
                        </button>
                    </div>
                </div>
                <hr>
                <p class="text-muted">{{ __('admin.settings.access_sub') }}</p>
            </div>
            <div class="card-footer bg-white text-md-center">
                <button class="btn btn-primary btn-icon" id="save-btn"><i class="fas fa-random"></i> {{ __('admin.settings.public_switch') }}</button>
            </div>
        </form>
        @else
        <form method="POST" action="{{ route('admin.settings.system.access.public') }}">
            @csrf
            <div class="card-body bg-secondary">
                <div class="form-group row align-items-center">
                    <label for="access" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.mode') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <button type="button" class="btn btn-danger">
                            {{ __('admin.settings.private')}} <span class="badge badge-transparent"><i class="fas fa-key"></i></span>
                        </button>
                    </div>
                </div>
                <hr>
                <p class="text-muted">{{ __('admin.settings.access_sub') }}</p>
            </div>
            <div class="card-footer bg-white text-md-center">
                <button class="btn btn-danger btn-icon" id="save-btn-5"><i class="fas fa-random"></i> {{ __('admin.settings.private_switch') }}</button>
            </div>
            @endif
        </form>
    </div>
</div>