<form id="app-settings" method="POST" action="{{ route('admin.settings.system.app') }}">
    @csrf
    <div class="card" id="app-card">
        <div class="card-header bg-white">
            <div class="col-8">
                <h4>{{ __('admin.settings.app') }}</h4>
            </div>
            <div class="col-4 text-right">
                <a class="btn btn-primary collapsed" data-toggle="collapse" href="#appSettings" role="button" aria-expanded="false" aria-controls="collapseExample">
                    Show / Hide Settings
                </a>
            </div>
        </div>
        <div class="collapse" id="appSettings">
            <div class="card-body bg-secondary">
                <p class="text-muted">{{ __('admin.settings.app_sub') }}</p>
                <div class="form-group row align-items-center">
                    <label for="default_membership" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.default_membership') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" class="form-control" name="default_membership" id="default_membership" placeholder="{{ __('admin.settings.default_membership_placeholder') }}" value="{{ Setting::get('default_membership') }}" required />
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="max_vaults" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.max_vaults') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" class="form-control" name="max_vaults" id="max_vaults" value="{{ Setting::get('max_vaults') }}" required />
                        <small id="vaultsHelpBlock" class="form-text text-muted">
                            {{ __('admin.settings.max_vaults_sub') }}
                        </small>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="max_sites" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.max_sites') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" class="form-control" name="max_sites" id="max_sites" value="{{ Setting::get('max_sites') }}" required />

                        <small id="sitesHelpBlock" class="form-text text-muted">
                            {{ __('admin.settings.max_sites_sub') }}
                        </small>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="max_folders" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.max_folders') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" class="form-control" name="max_folders" id="max_folders" value="{{ Setting::get('max_folders') }}" required />

                        <small id="foldersHelpBlock" class="form-text text-muted">
                            {{ __('admin.settings.max_folders_sub') }}
                        </small>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="max_notes" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.max_notes') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" class="form-control" name="max_notes" id="max_notes" value="{{ Setting::get('max_notes') }}" required />

                        <small id="notesHelpBlock" class="form-text text-muted">
                            {{ __('admin.settings.max_notes_sub') }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-md-center">
                <button class="btn btn-primary" id="save-btn-3">{{ __('admin.settings.update_setting') }}</button>
                <button class="btn btn-secondary" type="button" onclick="resetForm()">{{ __('admin.settings.reset') }}</button>
            </div>
        </div>
    </div>
</form>
