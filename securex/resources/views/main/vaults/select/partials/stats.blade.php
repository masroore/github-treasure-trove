<div class="row">
    <!-- Sites In Vault -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-primary">
                <i class="fas fa-database"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('dashboard.sites_in_vault') }}</h4>
                </div>
                <div class="card-body">
                    {{ $vault->sites_count }}
                </div>
            </div>
        </div>
    </div>

    <!-- Folders In Vault -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-info">
                <i class="fas fa-folder"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('dashboard.folders_in_vault') }}</h4>
                </div>
                <div class="card-body">
                    {{ $vault->folders_count }}
                </div>
            </div>
        </div>
    </div>

    <!-- Notes In Vault -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-warning">
                <i class="fas fa-address-book"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('dashboard.notes_in_vault') }}</h4>
                </div>
                <div class="card-body">
                    {{ $vault->total_notes() }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Vault Lock Status Widget-->
    @if($vault->password)
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-success">
                <i class="fas fa-lock"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('vault.lock') }}</h4>
                </div>
                <div class="card-body">
                    {{ __('snippets.active') }}
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-danger">
                <i class="fas fa-lock"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('vault.lock') }}</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('vaults.select.settings.password', $vault) }}" class="text-decoration-none text-dark">
                        {{ __('snippets.inactive') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>