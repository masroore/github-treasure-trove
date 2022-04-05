@extends('layouts.dashboard')

@section('title', trans('payment.title'))

@section('content')
<div class="container body-min-height m-b-60">
<!-- Page title -->
<section id="page-title" class="page-title-left text-light background-dark">
    <div class="container">
        <div class="page-title">
            <h1>{{ trans('payment.page_title') }}</h1>
            <span>{{ trans('payment.page_title_desc') }}</span>
        </div>
    </div>
</section>
<!-- end: Page title -->
<hr>
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
<!-- Content -->
<section id="page-content" class="dark">
    <div class="container">
        <div class="tabs tabs-vertical">
            <div class="row">
                <div class="col-md-3 tab-border-right mb-3">
                    <ul class="nav flex-column nav-tabs border-1" id="cryptoTab" role="tablist" aria-orientation="vertical">
                        @foreach($cryptocurrency_list as $cryptocurrency_info)
                            @if ($cryptocurrency_info['use_deposit'] == config('constants.use_deposit.enable') || $cryptocurrency_info['use_withdraw'] == config('constants.use_withdraw.enable'))
                                <li class="nav-item">
                                    <a class="nav-link no-border" id="{{ $cryptocurrency_info['currency_url'] }}-tab" data-bs-toggle="tab" href="#{{ $cryptocurrency_info['currency_url'] }}" role="tab" aria-controls="{{ $cryptocurrency_info['currency_url'] }}" aria-selected="false"><img src="{{ $cryptocurrency_info['ico'] }}" width="32px" class="p-r-10"><b>{{ $cryptocurrency_info['currency'] }}</b></a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="paymentTabContent">
                        @foreach($cryptocurrency_list as $cryptocurrency_info)
                        <div class="tab-pane fade" id="{{ $cryptocurrency_info['currency_url'] }}" role="tabpanel" aria-labelledby="{{ $cryptocurrency_info['currency_url'] }}-tab">
                            <div class="tabs tabs-folder">
                                <ul class="nav nav-tabs" id="{{ $cryptocurrency_info['currency_url'] }}_payment_tab" role="tablist">
                                    @if ($cryptocurrency_info['use_deposit'] == config('constants.use_deposit.enable'))
                                        <li class="nav-item">
                                            <a class="nav-link active" id="{{ $cryptocurrency_info['currency_url'] }}-deposit-tab" data-bs-toggle="tab" href="#{{ $cryptocurrency_info['currency_url'] }}-deposit" role="tab" aria-controls="{{ $cryptocurrency_info['currency_url'] }}-deposit" aria-selected="true"><b>{{ trans('payment.deposit') }}</b></a>
                                        </li>
                                    @endif
                                    @if ($cryptocurrency_info['use_withdraw'] == config('constants.use_withdraw.enable'))
                                        <li class="nav-item">
                                            <a class="nav-link @if ($cryptocurrency_info['use_deposit'] == config('constants.use_deposit.disable')) active @endif" id="{{ $cryptocurrency_info['currency_url'] }}-withdraw-tab" data-bs-toggle="tab" href="#{{ $cryptocurrency_info['currency_url'] }}-withdraw" role="tab" aria-controls="{{ $cryptocurrency_info['currency_url'] }}-withdraw" aria-selected="false">{{ trans('payment.withdraw') }}</a>
                                        </li>
                                    @endif
                                </ul>
                                <div class="tab-content" id="{{ $cryptocurrency_info['currency_url'] }}_payment_content">
                                    @if ($cryptocurrency_info['use_deposit'] == config('constants.use_deposit.enable'))
                                        <div class="tab-pane fade show active" id="{{ $cryptocurrency_info['currency_url'] }}-deposit" role="tabpanel" aria-labelledby="{{ $cryptocurrency_info['currency_url'] }}-deposit-tab">
                                        <h5>
                                            {{ trans('payment.deposit_desc1', ['currency' => $cryptocurrency_info['name']]) }}<br>
                                            {{ trans('payment.deposit_desc2') }}
                                        </h5>
                                        <br>
                                        <h4>{{ trans('payment.balance') }} <span class="text-primary">{{ $cryptocurrency_info['balance'] . ' ' . $cryptocurrency_info['currency'] }}</span></h4>
                                        <h5>{{ trans('payment.min_deposit_title') }} <span class="text-danger">{{ $cryptocurrency_info['min_deposit'] . ' ' . $cryptocurrency_info['currency'] }}</span> <p>{{ trans('payment.min_deposit_desc') }}</p></h5>
                                        <hr>
                                        <div class="card background-dark">
                                            <div class="card-header background-black-dark">
                                                <span class="h4 mx-auto text-primary">{{ trans('payment.deposit_addr_title', ['currency' => $cryptocurrency_info['name']]) }} </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="col-lg-8 mx-auto mt-5">
                                                    <div class="form-group mb-5 text-center">
                                                        <img class="mx-auto img-thumbnail" src="{{ QR_GENERATE_URL.$cryptocurrency_info['deposit_addr'] }}" width="300px">
                                                    </div>
                                                    <div class="form-inline">
                                                        <div class="input-group">
                                                            <input id="addr" type="text" readonly class="form-control widget-search-form text-light input-dark-bg" value="{{ $cryptocurrency_info['deposit_addr'] }}">
                                                            <span class="input-group-text input-dark-bg"><button class="no-border input-dark-bg text-light" data-clipboard="true" data-clipboard-target="#addr"><i class="icon-copy"></i></button></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4>{{ trans('payment.deposit_warning_title') }}</h4>
                                        <p class="text-light">{{ trans('payment.deposit_warning_desc', ['currency' => $cryptocurrency_info['name']]) }}</p>
                                    </div>
                                    @endif
                                    @if ($cryptocurrency_info['use_withdraw'] == config('constants.use_withdraw.enable'))
                                        <div class="tab-pane fade @if ($cryptocurrency_info['use_deposit'] == config('constants.use_deposit.disable')) show active @endif" id="{{ $cryptocurrency_info['currency_url'] }}-withdraw" role="tabpanel" aria-labelledby="{{ $cryptocurrency_info['currency_url'] }}-withdraw-tab">
                                        <h5>
                                            {{ trans('payment.withdraw_desc', ['currency' => $cryptocurrency_info['name']]) }}
                                        </h5>
                                        <br>
                                        <h4>{{ trans('payment.balance') }} <span class="text-primary">{{ $cryptocurrency_info['balance'] . ' ' . $cryptocurrency_info['currency'] }}</span></h4>
                                        <h5>{{ trans('payment.available_balance') }} <span class="text-primary">{{ $cryptocurrency_info['available_balance'] . ' ' . $cryptocurrency_info['currency'] }}</span></h5>
                                        <p>{{ trans('payment.available_balance_desc') }}</p>
                                        <h5>{{ trans('payment.min_withdraw_title') }} <span class="text-danger">{{ $cryptocurrency_info['min_withdraw'] . ' ' . $cryptocurrency_info['currency'] }}</span> <p>{{ trans('payment.min_withdraw_desc') }}</p></h5>
                                        <hr>
                                        @if (auth()->user()->kyc_status == config('constants.kyc_status.verified'))
                                        <div class="card background-dark">
                                            <div class="card-header background-black-dark">
                                                <span class="h4 mx-auto text-primary">{{ trans('payment.withdraw_addr_title', ['currency' => $cryptocurrency_info['name']]) }}</span>
                                            </div>
                                            <form method="POST" action="{{ route('payment.withdraw') }}">
                                                @csrf

                                                <input type="hidden" name="currency" value="{{ $cryptocurrency_info['currency'] }}">
                                                <input type="hidden" name="currency_url" value="{{ $cryptocurrency_info['currency_url'] }}">

                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-lg-3 col-form-label text-light">{{ trans('payment.withdraw_address') }}</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control text-light input-dark-bg @error($cryptocurrency_info['currency_url'] . '_destination') is-invalid @enderror" type="text" value="{{ old($cryptocurrency_info['currency_url'].'_destination') }}" id="{{ $cryptocurrency_info['currency_url'] }}_destination" name="{{ $cryptocurrency_info['currency_url'] }}_destination">
                                                            @error($cryptocurrency_info['currency_url'] . '_destination')
                                                                <div class="is-invalid">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="example-text-input" class="col-lg-3 col-form-label text-light">{{ trans('payment.withdraw_amount') }}</label>
                                                        <div class="col-lg-9">
                                                            <input class="form-control text-light input-dark-bg @error($cryptocurrency_info['currency_url'] . '_amount') is-invalid @enderror" type="text" value="{{ old($cryptocurrency_info['currency_url'].'_amount') }}" id="{{ $cryptocurrency_info['currency'] }}_amount" name="{{ $cryptocurrency_info['currency_url'] }}_amount">
                                                            @error($cryptocurrency_info['currency_url'] . '_amount')
                                                                <div class="is-invalid">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn m-t-30 mt-3">{{ trans('buttons.withdraw') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                            <h5 class="text-primary"><b>{{ trans('payment.withdraw_after_kyc') }}</b></h5>
                                        @endif
                                        <h4>{{ trans('payment.withdraw_warning_title') }}</h4>
                                        <p class="text-light">{{ trans('payment.withdraw_warning_desc', ['currency' => $cryptocurrency_info['name']]) }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $('#top_payment').addClass('text-danger');

            @if ($errors->any())
                $('#{{ old('currency_url') }}-tab').addClass('active');
                $('#{{ old('currency_url') }}').addClass('show active');
                $('#{{ old('currency_url') }}-deposit-tab').removeClass('active');
                $('#{{ old('currency_url') }}-deposit').removeClass('show active')
                $('#{{ old('currency_url') }}-withdraw-tab').addClass('active');
                $('#{{ old('currency_url') }}-withdraw').addClass('show active');
            @else
                $('#{{ $cryptocurrency_list[0]['currency_url'] }}-tab').addClass('active');
                $('#{{ $cryptocurrency_list[0]['currency_url'] }}').addClass('show active');
                $('#{{ $cryptocurrency_list[0]['currency_url'] }}-deposit-tab').addClass('active');
                $('#{{ $cryptocurrency_list[0]['currency_url'] }}-deposit').addClass('show active');
            @endif

            @if (session('success'))
                toastr.success('{{ session('success') }}', '', {"closeButton": true});
            @endif
        });
    </script>
@endsection