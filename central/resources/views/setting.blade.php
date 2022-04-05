@extends('layouts.dashboard')

@section('title', trans('setting.title'))

@section('content')
    <div class="container body-min-height">
        <!-- Page title -->
        <section id="page-title" class="page-title-left text-light background-dark">
            <div class="container">
                <div class="page-title">
                    <h1>{{ trans('setting.page_title') }}</h1>
                    <span>{{ trans('setting.page_title_desc') }}</span>
                </div>
            </div>
        </section>
        <!-- end: Page title -->
        <hr>
        <!-- Content -->
        @if ($errors->has('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $errors->first('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <section id="page-content" class="background-dark">
            <div class="container">
                <div class="tabs tabs-vertical">
                    <div class="row">
                        <div class="col-md-3 tab-border-right mb-3">
                            <ul class="nav flex-column nav-tabs border-1" id="setting_tab" role="tablist" aria-orientation="vertical">
                                <li class="nav-item">
                                    <a class="nav-link no-border active" id="account_info-tab" data-bs-toggle="tab" href="#account_info" role="tab" aria-controls="account_info" aria-selected="true"><b>{{ trans('setting.account_info') }}</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link no-border" id="change_password-tab" data-bs-toggle="tab" href="#change_password" role="tab" aria-controls="change_password" aria-selected="false"><b>{{ trans('setting.change_pwd') }}</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link no-border" id="id_verify-tab" data-bs-toggle="tab" href="#id_verify" role="tab" aria-controls="id_verify" aria-selected="false"><b>{{ trans('setting.id_verify') }}</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link no-border" id="step_auth-tab" data-bs-toggle="tab" href="#step_auth" role="tab" aria-controls="step_auth" aria-selected="false"><b>{{ trans('setting.step_auth') }}</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link no-border" id="download-tab" data-bs-toggle="tab" href="#download" role="tab" aria-controls="download" aria-selected="false"><b>{{ trans('setting.data_download') }}</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link no-border" id="login_history-tab" data-bs-toggle="tab" href="#login_history" role="tab" aria-controls="login_history" aria-selected="false"><b>{{ trans('setting.login_history') }}</b></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link no-border" id="language-tab" data-bs-toggle="tab" href="#language" role="tab" aria-controls="language" aria-selected="false"><b>{{ trans('setting.language') }}</b></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content" id="setting_tab_content">
                                <div class="tab-pane fade show active" id="account_info" role="tabpanel" aria-labelledby="account_info-tab">
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.account_info') }}</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-3 text-center mb-3">
                                                    <img src="{{ auth()->user()->avatar ? auth()->user()->avatar : asset('images/user-avatar.png') }}" class="avatar avatar-xl" id="avatar_preview">
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="form-group row">
                                                        <div class="col-lg-4 col-6">{{ trans('setting.login_id')  }}</div>
                                                        <div class="col-lg-8 col-6">{{ auth()->user()->login_id }}</div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-4 col-6">{{ trans('setting.email')  }}</div>
                                                        <div class="col-lg-8 col-6">{{ auth()->user()->email }}</div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-4 col-6">{{ trans('setting.id_verify')  }}</div>
                                                        <div class="col-lg-8 col-6">
                                                            @if(auth()->user()->kyc_status == config('constants.kyc_status.not_verified'))
                                                                <i class="icon-x-circle text-danger"></i>&nbsp;{{ trans('common.kyc_status.not_verified') }}
                                                            @elseif(auth()->user()->kyc_status == config('constants.kyc_status.verified'))
                                                                <i class="icon-check-circle text-success"></i>&nbsp;{{ trans('common.kyc_status.verified') }}
                                                            @elseif(auth()->user()->kyc_status == config('constants.kyc_status.review'))
                                                                <i class="icon-airplay text-info">&nbsp;</i>{{ trans('common.kyc_status.review') }}
                                                            @elseif(auth()->user()->kyc_status == config('constants.kyc_status.failed'))
                                                                <i class="icon-x-circle text-danger"></i>&nbsp;{{ trans('common.kyc_status.failed') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-4 col-6">{{ trans('setting.step_auth')  }}</div>
                                                        <div class="col-lg-8 col-6">
                                                            @if(auth()->user()->use_google_auth == config('constants.step_auth_status.no_use'))
                                                                <i class="icon-x-circle text-danger"></i>&nbsp;{{ trans('common.step_auth_status.no_use') }}
                                                            @elseif(auth()->user()->use_google_auth == config('constants.step_auth_status.use'))
                                                                <i class="icon-check-circle text-success"></i>&nbsp;{{ trans('common.step_auth_status.use') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.account_info_update') }}</span>
                                        </div>
                                        <div class="card-body">
                                            <form method="Post" class="form-validate mt-5" action="{{ route('setting.updateprofile') }}" enctype="multipart/form-data">
                                                @csrf

                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="" class="text-light">{{ trans('setting.avatar') }}</label>
                                                        <input type="file" class="form-control-file d-none" name="avatar" id="avatar" onchange="previewFile()">
                                                        <label for="avatar" class="btn btn-primary">{{ trans('buttons.browse') }}</label>
                                                        @error('avatar')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="name" class="text-light">{{ trans('setting.name') }}</label>
                                                        <input type="text" class="form-control text-light input-dark-bg @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : auth()->user()->name}}" placeholder="{{ trans('setting.name') }}" autofocus>
                                                        @error('name')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="gender" class="text-light">{{ trans('setting.gender') }}</label>
                                                        <select class="form-select text-light input-dark-bg" name="gender">
                                                            <option>{{ trans('setting.gender_placeholder') }}</option>
                                                            @foreach($gender_list as $gender_info)
                                                                <option value="{{ $gender_info['id'] }}" @if( (old('gender') ? old('gender') : auth()->user()->gender) == $gender_info['id']) selected @endif>{{ trans('common.gender.'.$gender_info['gender']) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="birthday" class="text-light">{{ trans('setting.birthday') }}</label>
                                                        <div class="input-group date" id="datepicker" data-target-input="nearest">
                                                            <input type="text" class="form-control datetimepicker-input input-dark-bg text-light" data-target="#datepicker" name="birthday" value="{{ old('birthday') ? old('birthday') : date('m/d/Y', strtotime(auth()->user()->birthday))}}"  placeholder="{{ trans('common.date_placeholder') }}" />
                                                            <div class="input-group-text btn btn-light input-dark-bg text-light" data-target="#datepicker" data-toggle="datetimepicker"><i class="icon-calendar"></i></div>
                                                        </div>
                                                        @error('birthday')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="mobile" class="text-light">{{ trans('setting.mobile') }}</label>
                                                        <input class="form-control text-light input-dark-bg @error('mobile') is-invalid @enderror" type="tel" name="mobile" placeholder="{{ trans('register.mobile') }}" value="{{ old('mobile') ? old('mobile') : auth()->user()->mobile}}">
                                                        @error('mobile')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="country" class="text-light">{{ trans('setting.country') }}</label>
                                                        <select name="country" class="form-select text-light input-dark-bg @error('country') is-invalid @enderror">
                                                            <option value="">{{ trans('setting.country_placeholder') }}</option>
                                                            @foreach($country_list as $code => $country_info)
                                                                <option value="{{ $country_info['name'] }}" @if( (old('country') ? old('country') : auth()->user()->country) == $country_info['name']) selected @endif>{{ $country_info['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('country')
                                                        <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
<!--                                                    <div class="form-group col-md-6">
                                                        <label for="state" class="text-light">{{ trans('register.lang') }}</label>
                                                        <select name="lang" class="form-select text-light input-dark-bg @error('lang') is-invalid @enderror">
                                                            <option value="">{{ trans('register.lang_placeholder') }}</option>
                                                            @foreach($language_list as $language_info)
                                                                <option value="{{ $language_info['code'] }}" @if( (old('lang') ? old('lang') : auth()->user()->lang) == $language_info['code']) selected @endif>{{ $language_info['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('lang')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>-->
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="address" class="text-light">{{ trans('setting.address') }}</label>
                                                        <input type="text" class="form-control text-light input-dark-bg @error('address') is-invalid @enderror" name="address" placeholder="{{ trans('setting.address') }}" value="{{ old('address') ? old('address') : auth()->user()->address }}">
                                                        @error('address')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="postal_code" class="text-light">{{ trans('setting.postal_code') }}</label>
                                                        <input type="text" class="form-control text-light input-dark-bg @error('postal_code') is-invalid @enderror" name="postal_code" placeholder="{{ trans('setting.postal_code') }}" value="{{ old('postal_code') ? old('postal_code') : auth()->user()->postal_code }}">
                                                        @error('postal_code')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn m-t-30 mt-3">{{ trans('buttons.save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="change_password" role="tabpanel" aria-labelledby="change_password-tab">
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.change_pwd') }}</span>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('setting.updatepassword') }}">
                                                @csrf

                                                <div class="form-group row">
                                                    <label for="current_password" class="col-lg-4 col-form-label text-light">{{ trans('setting.current_pwd') }}</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control input-dark-bg text-light @error('current_password') is-invalid @enderror" type="password" value="{{ old('current_password') }}" name="current_password" placeholder="{{ trans('setting.current_pwd') }}">
                                                        @error('current_password')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password" class="col-lg-4 col-form-label text-light">{{ trans('setting.new_pwd') }}</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control input-dark-bg text-light @error('password') is-invalid @enderror" type="password" value="{{ old('password') }}" name="password" placeholder="{{ trans('setting.new_pwd') }}">
                                                        @error('password')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password_confirmation" class="col-lg-4 col-form-label text-light">{{ trans('setting.new_pwd_confirm') }}</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control input-dark-bg text-light @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="{{ trans('setting.new_pwd_confirm') }}">
                                                        @error('password_confirmation')
                                                            <div class="is-invalid">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn m-t-30 mt-3 mx-auto">{{ trans('buttons.save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="id_verify" role="tabpanel" aria-labelledby="id_verify-tab">
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.id_verify') }}</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group row">
                                                    <div class="col-lg-4 col-6">{{ trans('setting.id_verify') }}</div>
                                                    <div class="col-lg-8 col-6">
                                                        @if(auth()->user()->kyc_status == config('constants.kyc_status.not_verified'))
                                                            <i class="icon-x-circle text-danger"></i>&nbsp;{{ trans('common.kyc_status.not_verified') }}
                                                        @elseif(auth()->user()->kyc_status == config('constants.kyc_status.verified'))
                                                            <i class="icon-check-circle text-success"></i>&nbsp;{{ trans('common.kyc_status.verified') }}
                                                        @elseif(auth()->user()->kyc_status == config('constants.kyc_status.review'))
                                                            <i class="icon-airplay text-info">&nbsp;</i>{{ trans('common.kyc_status.review') }}
                                                        @elseif(auth()->user()->kyc_status == config('constants.kyc_status.failed'))
                                                            <i class="icon-x-circle text-danger"></i>&nbsp;{{ trans('common.kyc_status.failed') }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.upload_id_title') }}</span>
                                        </div>
                                        <div class="card-body">
                                            <p>{{ trans('setting.upload_id_desc') }}<p>
                                            <p>{{ trans('setting.upload_id_warning1') }}<br>
                                                {{ trans('setting.upload_id_warning2') }}
                                            </p>
                                            <form id="id_verify_form" class="form-validate mt-3" method="POST" enctype="multipart/form-data" action="{{ route('setting.idverify') }}">
                                                @csrf

                                                <div id="id_upload_div">
                                                    @for($i = 0; $i < count($kyc_list); $i++)
                                                        <div class="form-group row">
                                                            <label for="Doc" class="col-lg-2 col-form-label text-light">{{ trans('setting.id_doc') }}</label>
                                                            @if(auth()->user()->kyc_status != config('constants.kyc_status.verified'))
                                                                <div class="col-lg-4">
                                                                    <input type="hidden" class="form-control-file" name="id_doc_id[]" id="id{{ $i }}" value="{{ $kyc_list[$i]['id'] }}">
                                                                    <input type="file" class="form-control-file" name="id_doc[]" id="id_doc{{ $i }}" value="{{ $kyc_list[$i]['photo_url'] }}" onchange="previewID('id_doc{{ $i }}', 'id_doc_preview{{ $i }}', 'id_doc_preview_detail{{ $i }}', '{{$i}}')">
                                                                    @error('id_doc')
                                                                        <div class="is-invalid">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            @endif
                                                            <div class="col-lg-4 col-md-8">
                                                                <div class="portfolio-item img-zoom ct-photography ct-media ct-branding ct-Media">
                                                                    <div class="portfolio-item-wrap">
                                                                        <div class="portfolio-image">
                                                                            <a href="#"><img id="id_doc_preview{{ $i }}" src="{{ $kyc_list[$i]['photo_url'] }}" alt=""></a>
                                                                        </div>
                                                                        <div class="portfolio-description">
                                                                            <a data-lightbox="gallery-image" target="_blank" id="id_doc_preview_detail{{ $i }}" href="{{ $kyc_list[$i]['photo_url'] }}" class="btn btn-light btn-roundeded">{{ trans('setting.show') }}</a>
                                                                            @if(auth()->user()->kyc_status != config('constants.kyc_status.verified'))
                                                                                <a data-lightbox="gallery-image" target="_blank" class="btn btn-light btn-roundeded" onclick="onDeleteIDDoc('{{ $kyc_list[$i]['id'] }}', '{{ $i }}')">{{ trans('setting.delete') }}</a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                </div>
                                                @if(auth()->user()->kyc_status != config('constants.kyc_status.verified'))
                                                    <div class="form-group text-center">
                                                        <button type="submit" class="btn mx-auto">{{ trans('buttons.upload') }}</button>
                                                    </div>
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="step_auth" role="tabpanel" aria-labelledby="step_auth-tab">
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.step_auth') }}</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <label for="step_switch" class="col-6 col-form-label"><span class="text-light m-r-10">{{ trans('setting.google_auth') }}</span>
                                                    @if(auth()->user()->use_google_auth == config('constants.step_auth_status.no_use'))
                                                        <i class="icon-x-circle text-danger"></i>&nbsp;<span class="text-light">{{ trans('common.step_auth_status.no_use') }}</span>
                                                    @elseif(auth()->user()->use_google_auth == config('constants.step_auth_status.use'))
                                                        <i class="icon-check-circle text-success"></i>&nbsp;<span class="text-light">{{ trans('common.step_auth_status.use') }}</span>
                                                    @endif
                                                </label>
                                                <div class="col-6">
                                                    @if(auth()->user()->use_google_auth == config('constants.step_auth_status.no_use'))
                                                        <button type="button" class="btn btn-primary" onclick="onShowAuthSetting()">{{ trans('buttons.enable') }}</button>
                                                    @elseif(auth()->user()->use_google_auth == config('constants.step_auth_status.use'))
                                                        <form method="post" action="{{ route('setting.2fa_auth.disable') }}">
                                                            @csrf

                                                            <button type="submit" class="btn btn-danger">{{ trans('buttons.disable') }}</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-8 mt-5 mx-auto text-center d-none" id="google_auth_div">
                                                <form method="post" action="{{ route('setting.2fa_auth.enable') }}">
                                                    @csrf

                                                    <p>{{ trans('setting.google_auth_desc') }}<span class="text-primary"><b>{{ $google2fa_secret }}</b></span></p>
                                                    <input type="hidden" name="google2fa_secret" value="{{ $google2fa_secret }}">
                                                    <div class="form-group">
                                                        <?php echo($google2fa_qr_img) ?>
                                                        <div class="row mt-5">
                                                            <div class="form-group col-lg-8">
                                                                <input type="text" class="form-control text-light input-dark-bg" name="verification_code" placeholder="{{ trans('setting.verification_code') }}">
                                                            </div>
                                                            <div class="form-group col-lg-4 text-center">
                                                                <button type="submit" class="btn">{{ trans('buttons.save') }}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="download" role="tabpanel" aria-labelledby="download-tab">
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.data_download') }}</span>
                                        </div>
                                        <div class="card-body text-light">
                                            <h5>{{ trans('setting.data_download_desc') }}</h5>
                                            <div class="overflow-auto p-15">
                                                <table id="data_list_tbl" class="table table-dark font-size-sm" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="background-black-dark">{{ trans('setting.data_title') }}</th>
                                                        <th class="background-black-dark">{{ trans('setting.file_name') }}</th>
                                                        <th class="background-black-dark">{{ trans('setting.register_datetime') }}</th>
                                                        <th class="background-black-dark">{{ trans('setting.download') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="login_history" role="tabpanel" aria-labelledby="login_history-tab">
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.login_history') }}</span>
                                        </div>
                                        <div class="card-body text-light">
                                            <h5>{{ trans('setting.login_history_desc') }}</h5>
                                            <div class="overflow-auto p-15">
                                                <table id="login_history_tbl" class="table table-dark font-size-sm" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="background-black-dark">{{ trans('setting.ip') }}</th>
                                                        <th class="background-black-dark">{{ trans('setting.device') }}</th>
                                                        <th class="background-black-dark">{{ trans('setting.platform') }}</th>
                                                        <th class="background-black-dark">{{ trans('setting.region') }}</th>
                                                        <th class="background-black-dark">{{ trans('setting.datetime') }}</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="language" role="tabpanel" aria-labelledby="language-tab">
                                    <div class="card background-dark">
                                        <div class="card-header background-black-dark">
                                            <span class="h4 mx-auto text-primary">{{ trans('setting.language_title') }}</span>
                                        </div>
                                        <div class="card-body text-light">
                                            <form method="POST" action="{{ route('setting.language') }}">
                                                @csrf

                                                <div class="form-group row">
                                                    <label for="password_confirmation" class="col-lg-4 col-6 col-form-label">{{ trans('setting.language') }}</label>
                                                    <div class="col-lg-8 col-6">
                                                        <select class="form-select text-light input-dark-bg" name="lang">
                                                            @foreach(config('constants.language_list') as $language_info)
                                                                <option value="{{ $language_info['code'] }}" @if($language_info['code'] == auth()->user()->lang) selected @endif>{{ $language_info['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn mt-3 mx-auto">{{ trans('buttons.save') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datetimepicker/tempusdominus-bootstrap-4.js') }}"></script>
    <script>
        var g_id_doc_cnt = 0;
        jQuery(document).ready(function() {
            $('#datepicker').datetimepicker({
                format: 'L'
            });
        });

        $( document ).ready(function() {
            $('#top_setting').addClass('text-danger');

            $('#account_info-tab').removeClass('active');
            $('#account_info').removeClass('show active');
            $('#change_password-tab').removeClass('active');
            $('#change_password').removeClass('show active');
            $('#id_verify-tab').removeClass('active');
            $('#id_verify').removeClass('show active');
            $('#step_auth-tab').removeClass('active');
            $('#step_auth').removeClass('show active');
            $('#download-tab').removeClass('active');
            $('#download').removeClass('show active');
            $('#login_history-tab').removeClass('active');
            $('#login_history').removeClass('show active');
            $('#language-tab').removeClass('active');
            $('#language').removeClass('show active');

            @if($errors->has('language') || session('language'))
                $('#language-tab').addClass('active');
                $('#language').addClass('show active');
            @elseif($errors->has('id_doc') || $errors->has('id_failed') || session('id_success'))
                $('#id_verify-tab').addClass('active');
                $('#id_verify').addClass('show active');
            @elseif($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation') || $errors->has('pwd_failed') || session('pwd_success'))
                $('#change_password-tab').addClass('active');
                $('#change_password').addClass('show active');
            @elseif($errors->has('2fa_failed') || session('2fa_success'))
                $('#step_auth-tab').addClass('active');
                $('#step_auth').addClass('show active');
            @else
                $('#account_info-tab').addClass('active');
                $('#account_info').addClass('show active');
            @endif

            g_id_doc_cnt = '{{ count($kyc_list) }}';
            @if(auth()->user()->kyc_status != config('constants.kyc_status.verified'))
                addNewKYCUploadForm();
            @endif

            getDataList();
            getLoginHistory();
        });

        function getDataList() {
            var token = $("input[name=_token]").val();

            $.ajax({
                url: '{{ route('setting.datalist') }}',
                type: 'POST',
                data: {_token: token},
                dataType: 'JSON',
                success: function (response) {
                    if ( $.fn.DataTable.isDataTable( '#data_list_tbl' ) ) {
                        var data_list_tbl = $('#data_list_tbl').DataTable();
                        data_list_tbl.destroy();
                    }

                    datas = new Array();
                    if (response == undefined || response.length == 0) {
                    } else {
                        for (var i = 0; i < response.length; i++) {

                            var download = '<a target="_blank" href="' + response[i].url + '"><i class="fa fa-download"></i></a>';

                            datas.push([
                                response[i].title,
                                response[i].file_name,
                                moment(response[i].updated_at).utc().format('YYYY-MM-DD HH:mm:ss'),
                                download
                            ]);
                        }
                    }

                    $('#data_list_tbl').dataTable({
                        data: datas,
                        searching: false,
                        viewCount: false,
                        bLengthChange: false,
                        language: {
                            "paginate": {
                                "first":      "<<",
                                "last":       ">>",
                                "next":       ">",
                                "previous":   "<"
                            },
                        }
                    });
                }
            });
        }

        function getLoginHistory() {
            var token = $("input[name=_token]").val();

            $.ajax({
                url: '{{ route('setting.loginhistory') }}',
                type: 'POST',
                data: {_token: token},
                dataType: 'JSON',
                success: function (response) {
                    if ( $.fn.DataTable.isDataTable( '#login_history_tbl' ) ) {
                        var login_history_tbl = $('#login_history_tbl').DataTable();
                        login_history_tbl.destroy();
                    }

                    datas = new Array();
                    if (response == undefined || response.length == 0) {
                    } else {
                        for (var i = 0; i < response.length; i++) {

                            var device = '{{ trans('common.device.Unknown') }}';
                            if(response[i].device == '{{ config('constants.device.Mobile') }}')
                                device = '{{ trans('common.device.Mobile') }}';
                            else if(response[i].device == '{{ config('constants.device.Tablet') }}')
                                device = '{{ trans('common.device.Tablet') }}';
                            else if(response[i].device == '{{ config('constants.device.Desktop') }}')
                                device = '{{ trans('common.device.Desktop') }}';

                            datas.push([
                                response[i].ip_addr,
                                device,
                                response[i].platform,
                                response[i].region,
                                moment(response[i].updated_at).utc().format('YYYY-MM-DD HH:mm:ss'),
                            ]);
                        }
                    }

                    $('#login_history_tbl').dataTable({
                        data: datas,
                        searching: false,
                        viewCount: false,
                        bLengthChange: false,
                        language: {
                            "paginate": {
                                "first":      "<<",
                                "last":       ">>",
                                "next":       ">",
                                "previous":   "<"
                            },
                        }
                    });
                }
            });
        }

        function onShowAuthSetting() {
            $('#google_auth_div').removeClass('d-none');
        }

        function previewFile(){
            var file = $("#avatar").get(0).files[0];

            if(file){
                var reader = new FileReader();

                reader.onload = function(){
                    $("#avatar_preview").attr("src", reader.result);
                }

                reader.readAsDataURL(file);
            }
        }

        function previewID(img_id, preview_id, img_detail_id, key){
            var file = $("#"+img_id).get(0).files[0];

            if(file){
                var reader = new FileReader();

                reader.onload = function(){
                    $("#"+preview_id).attr("src", reader.result);
                    $("#"+img_detail_id).attr("href", reader.result);
                }

                reader.readAsDataURL(file);
            }

            if (key == (g_id_doc_cnt-1))
                addNewKYCUploadForm();
        }

        function addNewKYCUploadForm() {
            $('#id_upload_div').append('<div class="form-group row">\n' +
                '                                                            <label for="Doc" class="col-lg-2 col-form-label text-light">{{ trans('setting.id_doc') }}</label>\n' +
                '                                                            <div class="col-lg-4">\n' +
                '                                                                <input type="file" class="form-control-file" name="id_doc[]" id="id_doc'+g_id_doc_cnt+'" onchange="previewID(\'id_doc'+g_id_doc_cnt+'\',\'id_doc_preview'+g_id_doc_cnt+'\',\'id_doc_preview_detail'+g_id_doc_cnt+'\', '+g_id_doc_cnt+')">\n' +
                '                                                                @error("id_doc")\n' +
                '                                                                    <div class="is-invalid">{{ $message }}</div>\n' +
                '                                                                @enderror\n' +
                '                                                            </div>\n' +
                '                                                            <div class="col-lg-4 col-md-8">\n' +
                '                                                                <div class="portfolio-item img-zoom ct-photography ct-media ct-branding ct-Media">\n' +
                '                                                                    <div class="portfolio-item-wrap">\n' +
                '                                                                        <div class="portfolio-image">\n' +
                '                                                                            <a href="#"><img id="id_doc_preview'+g_id_doc_cnt+'" src="" alt=""></a>\n' +
                '                                                                        </div>\n' +
                '                                                                    </div>\n' +
                '                                                                </div>\n' +
                '                                                            </div>\n' +
                '                                                        </div>');

            g_id_doc_cnt = parseInt(g_id_doc_cnt) + 1;
        }

        function onDeleteIDDoc(id, key) {
            var token = $("input[name=_token]").val();

            $.ajax({
                url: '{{ route('setting.idverify.delete') }}',
                type: 'POST',
                data: {_token: token, id: id},
                dataType: 'JSON',
                success: function (response) {
                    if (response == undefined || response == 0) {
                        toastr.error("{{ trans('setting.id_delete_failed_msg') }}");
                    } else {
                        toastr.success("{{ trans('setting.id_delete_success_msg') }}");
                        $('#id_doc_preview'+key).attr('src', '');
                        $('#id_doc_preview_detail'+key).remove();
                        $('#id'+key).remove();
                    }
                }
            });
        }
    </script>

@endsection