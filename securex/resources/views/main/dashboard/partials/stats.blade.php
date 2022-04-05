<div class="row">
    <!-- Total Vaults -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-primary">
                <i class="fas fa-piggy-bank"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('dashboard.total_vaults') }}</h4>
                </div>
                <div class="card-body">
                    {{ auth()->user()->vaults->count() }} / {{ Setting::get('max_vaults') }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Sites -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-danger">
                <i class="fas fa-database"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('dashboard.total_sites') }}</h4>
                </div>
                <div class="card-body">
                    {{ auth()->user()->total_sites() }} / {{ Setting::get('max_sites') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Total -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-warning">
                <i class="fas fa-folder"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('dashboard.total_folders') }}</h4>
                </div>
                <div class="card-body">
                    {{ auth()->user()->total_folders() }} / {{ Setting::get('max_folders') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Default Membership -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-success">
                <i class="fas fa-font"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('dashboard.membership_plan') }}</h4>
                </div>
                <div class="card-body">
                    {{ Setting::get('default_membership') }}
                </div>
            </div>
        </div>
    </div>
</div>