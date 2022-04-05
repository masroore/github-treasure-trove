<div class="card" id="maintenance-card">
    <div class="card-header bg-white">
        <div class="col-8">
            <h4>{{ __('admin.settings.backup_manager') }}</h4>

        </div>
        <div class="col-4 text-right">
            <a class="btn btn-primary collapsed" data-toggle="collapse" href="#dbbackupsCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                Show / Hide Settings
            </a>
        </div>
    </div>
    <div class="collapse" id="dbbackupsCollapse">
        <form id="database-backup-settings" method="POST" action="{{ route('admin.settings.automation.add-mysql-path') }}">
            @csrf
                    <div class="col-md-12">
                        <div class="form-group row align-items-center">
                            <label for="db_mysql_dump_path" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.mysql_dump_path') }}</label>
                            <div class="col-sm-6 col-md-6">
                                <input type="text" class="form-control" name="db_mysql_dump_path" id="db_mysql_dump_path" value="{{ Setting::get('db_mysql_dump_path') }}" />
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <small>{!! Lang::get('admin.settings.mysql_dump_path_hints') !!}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-md-center">
                <button class="btn btn-primary" id="save-btn">{{ __('admin.settings.update_setting') }}</button>
                <button class="btn btn-secondary" type="button" onclick="resetForm()">{{ __('admin.settings.reset') }}</button>
            </div>
        </form>
    </div>
</div>
