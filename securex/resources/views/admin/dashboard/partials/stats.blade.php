<div class="row">
    <!-- Users Registered Total -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-primary">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('admin.dashboard.registered_today') }}</h4>
                </div>
                <div class="card-body">
                    {{ $registered_today }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Users -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-danger">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('admin.dashboard.total_users') }}</h4>
                </div>
                <div class="card-body">
                    {{ $total_users }}
                </div>
            </div>
        </div>
    </div>

    <!-- Total Vaults -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-warning">
                <i class="fas fa-address-book"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('admin.dashboard.total_vaults') }}</h4>
                </div>
                <div class="card-body">
                    {{ $total_vaults }}
                </div>
            </div>
        </div>
    </div>

    <!-- Total Sites -->
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1 pull-up">
            <div class="card-icon bg-success">
                <i class="fas fa-font"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>{{ __('admin.dashboard.total_sites') }}</h4>
                </div>
                <div class="card-body">
                    {{ $total_sites }}
                </div>
            </div>
        </div>
    </div>
</div>