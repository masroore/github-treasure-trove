@extends('layouts.main')

@section('title')
{!! Lang::get('site.edit_title', ['name' => $site->name]) !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('vault.site.show', [$vault, $site]) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{!! Lang::get('site.edit_title', ['name' => $site->name]) !!}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults') }}">{{ __('nav.my_vaults') }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vaults.select', $vault) }}">{{ $vault->name }}</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('vault.site.show', [$vault,$site]) }}">{{ $site->name }}</a></div>
            <div class="breadcrumb-item">{!! Lang::get('site.edit_title', ['name' => $site->name]) !!}</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-xl-8">
                {!! laraflash()->render() !!}
                @include('partials.errors')
                <div class="card bg-secondary shadow pull-up">
                    <div class="card-header bg-white border-0">
                        <div class="col-8">
                            <h4>{{ __('site.edit_head') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('vault.site.update', [$vault,$site]) }}">
                            @csrf
                            <div class="pl-lg-4 mt-4">
                                <div class="form-group row">
                                    <label for="title" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.site_name') }}</b></label>
                                    <div class="col-md-8 col-sm-4">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('vault.site_name_placeholder') }}" value="{{ $site->name }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="link" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.site_link') }}</b></label>
                                    <div class="col-md-8 col-sm-4">
                                        <input type="text" class="form-control" id="link" name="link" placeholder="{{ __('vault.site_link_placeholder') }}" value="{{ $site->link }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="login_id" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.site_login_id') }}</b></label>
                                    <div class="col-md-8 col-sm-4">
                                        <input type="text" class="form-control" id="login_id" name="login_id" placeholder="{{ __('vault.site_login_id_placeholder') }}" value="{{ $site->login_id }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="login_password" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.site_login_pass') }}</b></label>
                                    <div class="col-md-8 col-sm-4">
                                        <input type="text" class="form-control" id="login_password" name="login_password" placeholder="{{ __('vault.site_login_pass_placeholder') }}" value="{{ $site->login_password }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="additional_info" class="col-md-3 col-sm-3 col-form-label"><b>{{ __('vault.site_add_info') }}</b></label>
                                    <div class="col-md-8 col-sm-4">
                                        <textarea type="text" class="form-control" id="additional_info" name="additional_info" placeholder="{{ __('vault.site_add_info') }}">{{ $site->additional_info }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-lg-4">
                                <div class="row text-center">
                                    <div class="col-lg-12 col-sm-12">
                                        <button type="submit" class="btn btn-warning btn-icon my-4">
                                            <i class="fas fa-edit"></i> {{ __('site.edit_btn') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

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
            }, 2500);
        });
    });
</script>
@endsection