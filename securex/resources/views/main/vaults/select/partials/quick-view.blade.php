@foreach($vault->sites as $site)
<div class="modal fade" id="quick-view-{{ $site->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <span>
                    <h5>{{ $site->name }}</h5>
                    <hr class="hr-border-solid pb-10 text-secondary mb-4">
                </span>
                <div class="form-group row align-items-center mt-2">
                    <h6 for="link" class="col-md-4 col-sm-4 col-form-label text-right"><b>{{ __('vault.site_link') }}</b></h6>
                    <div class="col-md-8 col-sm-4"> 
                        <div class="input-group align-items-center">
                            <span class="form-control bg-secondary" id="link_{{ $site->id }}">
                                <a href="https://{{ $site->getLinkWithoutProtocol() }}" target="_blank" class="text-decoration-none text-dark"><b>{{ $site->link }}</b></a>
                            </span>
                            <span class="input-group-button">
                                <button class="btn btn-clippy" name="btn" id="btn" type="button" data-clipboard-target="#link_{{ $site->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                                    <img class="clippy" src="{{ asset('assets/img/clippy.svg') }}" width="13" alt="Copy to clipboard">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <hr class="hr-border-dotted text-secondary">
                <div class="form-group row align-items-center">
                    <h6 for="login_id" class="col-md-4 col-sm-4 col-form-label text-right"><b>{{ __('vault.login_id') }}</b></h6>
                    <div class="col-md-8 col-sm-4">
                        <div class="input-group align-items-center">
                            <span class="form-control bg-secondary" id="login_id_{{ $site->id }}">{{ $site->login_id }}</span>
                            <span class="input-group-button">
                                <button class="btn btn-clippy" name="btn" id="btn" type="button" data-clipboard-target="#login_id_{{ $site->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                                    <img class="clippy" src="{{ asset('assets/img/clippy.svg') }}" width="13" alt="Copy to clipboard">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <hr class="hr-border-dotted text-secondary">
                <div class="form-group row align-items-center">
                    <h6 for="login_password" class="col-md-4 col-sm-4 col-form-label text-right"><b>{{ __('vault.login_pass') }}</b></h6>
                    <div class="col-md-8 col-sm-4">
                        <div class="input-group align-items-center">
                            <span class="form-control bg-secondary" id="login_password_{{ $site->id }}">{{ $site->login_password }}</span>
                            <span class="input-group-button">
                                <button class="btn btn-clippy" name="btn" id="btn" type="button" data-clipboard-target="#login_password_{{ $site->id }}" data-toggle="tooltip" data-placement="top" title="{{ __('snippets.copy') }}">
                                    <img class="clippy" src="{{ asset('assets/img/clippy.svg') }}" width="13" alt="Copy to clipboard">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <a href="{{ route('vault.site.show', [$vault,$site]) }}" class="btn btn-warning btn-shadow"><i class="fas fa-door-open"></i> {{ __('vault.open_site') }}</a>
            </div>
        </div>
    </div>
</div>
@endforeach