<div class="card" id="maintenance-card">
    <div class="card-header bg-white">
        <div class="col-8">
            <h4>{{ __('admin.settings.optimization') }}</h4>

        </div>
        <div class="col-4 text-right">
            <a class="btn btn-primary collapsed" data-toggle="collapse" href="#optimizationCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                Show / Hide Settings
            </a>
        </div>
    </div>
    <div class="collapse" id="optimizationCollapse">
        <div class="card-body bg-secondary">
            <p class="text-muted">{{ __('admin.settings.optimization_sub') }}</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row align-items-center">
                        <label for="status" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.cache') }}</label>
                        <div class="col-sm-6 col-md-9">
                            <a href="{{ route('admin.settings.clear-cache') }}" class="btn btn-info">
                                {{ __('admin.settings.cache_clear') }} <span class="badge badge-transparent"><i class="fas fa-eraser"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row align-items-center">
                        <label for="status" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.view_cache') }}</label>
                        <div class="col-sm-6 col-md-9">
                            <a href="{{ route('admin.settings.clear-view') }}" class="btn btn-info">
                                {{ __('admin.settings.view_clear') }} <span class="badge badge-transparent"><i class="fas fa-eye"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row align-items-center">
                        <label for="status" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.route_cache') }}</label>
                        <div class="col-sm-6 col-md-9">
                            <a href="{{ route('admin.settings.clear-route') }}" class="btn btn-info">
                                {{ __('admin.settings.route_clear') }} <span class="badge badge-transparent"><i class="fas fa-route"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row align-items-center">
                        <label for="status" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.config_cache') }}</label>
                        <div class="col-sm-6 col-md-9">
                            <a href="{{ route('admin.settings.clear-config') }}" class="btn btn-info">
                                {{ __('admin.settings.config_clear') }} <span class="badge badge-transparent"><i class="fas fa-clipboard-check"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row align-items-center">
                        <label for="status" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.compiled') }}</label>
                        <div class="col-sm-6 col-md-9">
                            <a href="{{ route('admin.settings.clear-compiled') }}" class="btn btn-info">
                                {{ __('admin.settings.compiled_clear') }} <span class="badge badge-transparent"><i class="fas fa-file-code"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row align-items-center">
                        <label for="status" class="form-control-label col-sm-2 text-md-left">{{ __('admin.settings.symlink') }}</label>
                        <div class="col-sm-9 col-md-9">
                            <a href="{{ route('admin.settings.symlink') }}" class="btn btn-info">
                                {{ __('admin.settings.symlink_create') }} <span class="badge badge-transparent"><i class="fas fa-file-code"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>