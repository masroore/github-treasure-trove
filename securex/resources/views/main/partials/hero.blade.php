@if(Auth::user()->profile_incomplete())
<div class="row">
    <div class="col-12 mb-4 mt-2">
        <div class="hero text-white hero-bg-image" data-background="{{ asset('assets/img/bg/bg-1.jpg') }}" style="background-image: url(&quot;assets/img/bg/bg-1.jpg&quot;);">
            <div class="hero-inner">
                <h2>{{ __('dashboard.welcome', [ 'first_name' => Auth::user()->first_name ] )}}!</h2>
                <p class="lead">{{ __('dashboard.complete_profile_alert') }}</p>
                <div class="mt-4">
                    <a href="{{ route('profile.index') }}" class="btn btn-outline-white btn-lg btn-icon icon-left"><i class="far fa-user"></i> {{ __('dashboard.complete_profile_link') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif