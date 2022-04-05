<div class="col-xl-3">
    <div class="card bg-white card-stats mb-xl-0 pull-up">
        <div class="card-header">
            <div class="col-8">
                <h4 class="text-danger">Uptime</h4>
                <span class="h5 font-weight-bold"><span id="clock"></span> <small></small></span>
            </div>
            <div class="col-4 text-right">
                <button class="btn btn-danger btn-lg btn-icon text-white">
                    <i class="fas fa-clock"></i>
                </button>
            </div>
        </div>
    </div>
    <br />
    <div class="card bg-white card-stats mb-xl-0 pull-up">
        <div class="card-header">
            <div class="col-8">
                <h4 class="text-warning">Last Login IP</h4>
                <a class="h5 font-weight-bold text-decoration-none text-gray" target="_blank" href="http://whatismyipaddress.com/ip/{{ $loginIP }}">{{ $loginIP ?? 'First Login' }}</a>
            </div>
            <div class="col-4 text-right">
                <button class="btn btn-warning btn-lg btn-icon text-white">
                    <i class="fas fa-server"></i>
                </button>
            </div>
        </div>
    </div>
    <br />
    <div class="card bg-white card-stats mb-xl-0 pull-up">
        <div class="card-header">
            <div class="col-8">
                <h4 class="text-info">Last Logged In</h4>
                <a class="h5 font-weight-bold text-decoration-none text-gray" target="_blank" href="{{ route('profile.iplogs') }}">{{ $loginAt ? $loginAt->diffForHumans() : 'First Login' }}</a>
            </div>
            <div class="col-4 text-right">
                <button class="btn btn-info btn-lg btn-icon text-white">
                    <i class="fas fa-calendar"></i>
                </button>
            </div>
        </div>
    </div>
</div>
