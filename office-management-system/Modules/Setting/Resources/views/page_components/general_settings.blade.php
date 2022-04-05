<div class="main-title mb-25">
    <h3 class="mb-0">{{ __('setting.General') }}</h3>
</div>
<form action="{{ route('company_information_update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="g_set" value="1">
    <div class="General_system_wrap_area">
        <div class="single_system_wrap">
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('setting.System Logo') }}</span>
                </div>
                <div class="logo_img">
                    <img src="{{asset(app('general_setting')->logo) }}" alt="">
                </div>
                <div class="update_logo_btn">
                    <button class="primary-btn small fix-gr-bg " type="button">
                        <input placeholder="Upload Logo" type="file" name="site_logo" id="site_logo" type="button">
                        {{ __('setting.Upload Logo') }}
                    </button>
                </div>
                <a href="{{ route('setting.remove', 'logo') }}" class="remove_logo">{{ __('setting.Remove') }}</a>
            </div>
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('setting.Fav Icon') }}</span>
                </div>

                <div class="logo_img">
                    <img src="{{asset(app('general_setting')->favicon) }}" alt="">
                </div>

                <div class="update_logo_btn">
                    <button class="primary-btn small fix-gr-bg" type="button">
                        <input placeholder="Upload Logo" type="file" name="favicon_logo" id="favicon_logo">
                        {{ __('setting.Upload Fav Icon') }}
                    </button>
                </div>
                <a href="{{ route('setting.remove', 'favicon') }}" class="remove_logo">{{ __('setting.Remove') }}</a>
            </div>
        </div>

        <div class="single_system_wrap">
            <div class="row">
                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.System Title') }}</label>
                        <input class="primary_input_field" placeholder="Infix CRM" type="text" id="site_title"
                               name="site_title" value="{{ $setting->site_title }}">
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.File Supported') }}
                            ({{__('setting.Include Comma with each word')}})</label>
                        <div class="tagInput_field">
                            <input class="sr-only" type="text" id="file_supported" name="file_supported"
                                   value="{{ $setting->file_supported }}" data-role="tagsinput" class="sr-only">
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.System Default Language') }}</label>
                        <select class="primary_select mb-25" name="language_id" id="language_id">
                            @foreach (\Modules\Localization\Entities\Language::where('status',1)->get() as $key => $language)
                                <option value="{{ $language->id }}"
                                        @if (app('general_setting')->language->code == $language->code) selected @endif>{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.Date Format') }}</label>
                        <select class="primary_select mb-25" name="date_format_id" id="date_format_id">
                            @foreach (Illuminate\Support\Facades\Cache::get('date_format') as $key => $dateFormat)
                                <option value="{{ $dateFormat->id }}"
                                        @if (app('general_setting')->dateFormat->id == $dateFormat->id) selected @endif>{{ $dateFormat->normal_view }}

                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.System Default Currency') }}</label>
                        <select class="primary_select mb-25" name="currency_id" id="currency">
                            @foreach (\Modules\Setting\Model\Currency::all() as $key => $currency)
                                <option value="{{ $currency->id }}"
                                        @if ($setting->currency == $currency->id) selected @endif>{{ $currency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.Time Zone') }}</label>
                        <select class="primary_select mb-25" name="time_zone_id" id="time_zone_id">
                            @foreach (\Modules\Setting\Model\TimeZone::all() as $key => $timeZone)
                                <option value="{{ $timeZone->id }}"
                                        @if ($setting->time_zone_id == $timeZone->id) selected @endif>{{ $timeZone->time_zone }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_inpu mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.Currency Symbol') }}</label>
                        <input class="primary_input_field" placeholder="-" type="text" id="currency_symbol"
                               name="currency_symbol" value="{{ $setting->currency_symbol }}" readonly>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.Currency Code') }}</label>
                        <input class="primary_input_field" placeholder="-" type="text" id="currency_code"
                               name="currency_code" value="{{ $setting->currency_code }}" readonly>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.Preloader') }}</label>
                        <input class="primary_input_field" placeholder="-" type="text" id="preloader" name="preloader"
                               value="{{ $setting->preloader }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.Default Payment') }}</label>
                        <select class="primary_select mb-25" name="payment_gateway" id="time_zone_id">
                            <option value="1"
                                    @if ($setting->payment_gateway == 1) selected @endif>{{__('sale.Cash')}}</option>
                            <option value="2"
                                    @if ($setting->payment_gateway == 2) selected @endif>{{__('sale.Bank')}}</option>
                        </select>
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('setting.Copywrite Text') }}</label>
                        <input class="primary_input_field" placeholder="-" type="text" id="copyright_text"
                               name="copyright_text" value="{{ $setting->copyright_text }}">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="submit_btn text-center mt-4">
        <button class="primary_btn_large" type="submit"><i class="ti-check"></i> {{ __('common.Save') }}</button>
    </div>
</form>
