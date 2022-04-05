<div class="card" id="maintenance-card">
    <div class="card-header bg-white">
        <div class="col-8">
            <h4>{{ __('admin.settings.maintenance') }}</h4>

        </div>
        <div class="col-4 text-right">
            <a class="btn btn-primary collapsed" data-toggle="collapse" href="#maintenaceCollapse" role="button" aria-expanded="false" aria-controls="collapseExample">
                Show / Hide Settings
            </a>
        </div>
    </div>
    <div class="collapse show" id="maintenaceCollapse">
        @if(! app()->isDownForMaintenance())
            <!-- Maintenance Form Livewired -->
            @livewire('admin.settings.system.maintenance-mode')
        @else
        <form method="POST" action="{{ route('admin.settings.system.maintenance.up') }}">
            @csrf
            <div class="card-body bg-secondary">
                <p class="text-muted">{{ __('admin.settings.maintenance_sub') }}</p>
                <div class="form-group row align-items-center">
                    <label for="status" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.status') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <button type="button" class="btn btn-danger">
                            {{ __('admin.settings.down') }} <span class="badge badge-transparent"><i class="fas fa-power-off"></i></span>
                        </button>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="maintenance_msg" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.maintenance_msg') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" class="form-control" value="{{ json_decode(file_get_contents(storage_path('framework/down')), true)['message'] }}" readonly>
                        <small id="vaultsMsgBlock" class="form-text text-muted">
                            {{ __('snippets.parses_html') }}
                        </small>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="maintenance_msg" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.maintenance_url') }}</label>
                    <div class="col-sm-6 col-md-7">
                        <input type="text" id="access_url" class="form-control" value="{{ Setting::get('app_url') }}/{{ json_decode(file_get_contents(storage_path('framework/down')), true)['secret'] }}" readonly>
                    </div>
                    <div class="col-md-1">
                        <button type="button" name="btn" id="btn" data-clipboard-target="#access_url" class="btn btn-dark"><i class='fas fa-copy'></i> {{ __('snippets.copy') }}</button>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="maintenance_started" class="form-control-label col-sm-3 text-md-right">{{ __('admin.settings.maintenance_started') }}</label>
                    <div class="col-sm-6 col-md-9">
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse(json_decode(file_get_contents(storage_path('framework/down')), true)['time'])->diffForHumans() }}" readonly>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-md-center">
                <button class="btn btn-success" id="save-btn-2">{{ __('admin.settings.maintenance_deactivate') }}</button>
            </div>
            @endif
        </form>
    </div>
</div>

@section('js')
<script src="{{ asset('assets/js/modules/clipboard.min.js') }}"></script>
<script type="text/javascript">
    // Clipboard
    var clipboard = new ClipboardJS('.btn');

    $(document).ready(function() {
        clipboard.on('success', function(e) {
            $(e.trigger).text("Copied!");
            e.clearSelection();
            setTimeout(function() {
                $(e.trigger).text("Copy");
                $(e.trigger).html("<i class='fas fa-copy'></i> Copy");
            }, 2500);
        });
    });
</script>
@endsection