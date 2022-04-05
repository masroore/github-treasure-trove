@extends('layouts.dashboard')

@section('title', trans('dashboard.title'))

@section('content')
    <section id="page-content" class="sidebar-both background-dark">
    <div class="mx-3 body-min-height">
        <div class="row">
            <div class="col-lg-3 col-md-6 mx-auto mb-5">
                <div class="widget p-cb background-black-dark border-panel" style="height: 100%;">
                    <div class="text-center m-t-20">
                        <div class="d-block form-group">
                            <img class="avatar avatar-lg" src="{{ auth()->user()->avatar ? auth()->user()->avatar : asset('images/user-avatar.png') }}">
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                        <p class="text-muted">{{ trans('dashboard.id_verification') }}
                            @if(auth()->user()->kyc_status == config('constants.kyc_status.not_verified'))
                                <i class="icon-x-circle text-danger"></i>&nbsp;{{ trans('common.kyc_status.not_verified') }}
                            @elseif(auth()->user()->kyc_status == config('constants.kyc_status.verified'))
                                <i class="icon-check-circle text-success"></i>&nbsp;{{ trans('common.kyc_status.verified') }}
                            @elseif(auth()->user()->kyc_status == config('constants.kyc_status.review'))
                                <i class="icon-airplay text-info">&nbsp;</i>{{ trans('common.kyc_status.review') }}
                            @elseif(auth()->user()->kyc_status == config('constants.kyc_status.failed'))
                                <i class="icon-x-circle text-danger"></i>&nbsp;{{ trans('common.kyc_status.failed') }}
                            @endif
                        </p>
                    </div>
                    <hr>
                    <div class="m-t-30">
                        <div class="form-group row">
                            <div class="col-6"><h5 class="text-light">{{ trans('dashboard.symbol') }}</h5></div>
                            <div class="col-6"><h5 class="text-light text-right">{{ trans('dashboard.balance') }}</h5></div>
                        </div>
                        @foreach($currency_list as $currency_info)
                            @if ($currency_info['use_deposit'] == config('constants.use_deposit.enable'))
                            <div class="form-group row">
                                <div class="col-6"><img src="{{ $currency_info['ico'] }}" width="32px" class="p-r-10"><b>{{ $currency_info['currency'] }}</b></div>
                                <div class="col-6"><h5 id="balance_{{ $currency_info['currency'] }}" class="text-light text-right">0</h5></div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6 content">
                <div class="widget p-cb background-dark no-border no-box-shadow p-0">
                    <section class="no-padding equalize" data-equalize-item=".text-box">
                        <div class="row col-no-margin background-dark">
                            <!--Box 1-->
                            <div class="col-lg-4 col-md-6 background-black-dark border-panel">
                                <a href="{{ route('exchange') }}">
                                    <div class="text-box">
                                        <i class="fa fa-chart-bar"></i>
                                        <h3>{{ trans('dashboard.trade_title') }}</h3>
                                        <p>{{ trans('dashboard.trade_desc') }}</p>
                                    </div>
                                </a>
                            </div>
                            <!--End: Box 1-->
                            <!--Box 2-->
                            <div class="col-lg-4 col-md-6 background-black-dark border-panel">
                                <a href="{{ route('dealer') }}">
                                    <div class="text-box">
                                        <i class="fa fa-money-bill-wave"></i>
                                        <h3>{{ trans('dashboard.dealer_title') }}</h3>
                                        <p>{{ trans('dashboard.dealer_desc') }}</p>
                                    </div>
                                </a>
                            </div>
                            <!--End: Box 2-->
                            <!--Box 3-->
                            <div class="col-lg-4 col-md-6 background-black-dark border-panel">
                                <a href="{{ route('payment') }}">
                                    <div class="text-box">
                                        <i class="fa fa-wallet"></i>
                                        <h3>{{ trans('dashboard.payment_title') }}</h3>
                                        <p>{{ trans('dashboard.payment_desc') }}</p>
                                    </div>
                                </a>
                            </div>
                            <!--End: Box 3-->
                            <!--Box 1-->
                            <div class="col-lg-4 col-md-6 background-black-dark border-panel">
                                <a href="{{ route('report') }}">
                                    <div class="text-box">
                                        <i class="fa fa-file-alt"></i>
                                        <h3>{{ trans('dashboard.report_title') }}</h3>
                                        <p>{{ trans('dashboard.report_desc') }}</p>
                                    </div>
                                </a>
                            </div>
                            <!--End: Box 1-->
                            <!--Box 2-->
                            <div class="col-lg-4 col-md-6 background-black-dark border-panel">
                                <a href="{{ route('setting') }}">
                                    <div class="text-box">
                                        <i class="fa fa-cog"></i>
                                        <h3>{{ trans('dashboard.setting_title') }}</h3>
                                        <p>{{ trans('dashboard.setting_desc') }}</p>
                                    </div>
                                </a>
                            </div>
                            <!--End: Box 2-->
                            <!--Box 3-->
                            <div class="col-lg-4 col-md-6 background-black-dark border-panel">
                                <a href="{{ route('faq') }}">
                                    <div class="text-box">
                                        <i class="fa fa-question-circle"></i></i>
                                        <h3>{{ trans('dashboard.faq_title') }}</h3>
                                        <p>{{ trans('dashboard.faq_desc') }}</p>
                                    </div>
                                </a>
                            </div>
                            <!--End: Box 3-->
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <div class="widget widget-notification p-cb background-black-dark border-panel">
                            <h4 class="widget-title text-primary">{{ trans('dashboard.news_title') }}</h4>
                            <hr>
                            @foreach( $last_news_list as $news_info)
                            <div class="notification-item">
                                <div class="notification-meta">
                                    <a href="{{url('news/detail').'/'.$news_info['id']}}">{{ $news_info['title'] }}</a>
                                    <span>{{ $news_info['updated_at'] }}</span>
                                </div>
                            </div>
                            @endforeach
                            <div class="text-center">
                                <a href="{{ route('news') }}" class="text-theme font-size-sm mx-auto">{{ trans('buttons.all_news') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-6">
                        <div class="widget widget-notification p-cb background-black-dark border-panel">
                            <h4 class="widget-title text-primary">{{ trans('dashboard.notification_title') }}</h4>
                            <hr>
                            @foreach( $last_notifications_list as $notification_info)
                            <div class="notification-item @if($notification_info['status'] == config('constants.notifications_status.unread')) notification-new @endif">
                                <div class="notification-meta">
                                    <a href="{{url('notifications/detail').'/'.$notification_info['id']}}">{{ $notification_info['title'] }}</a>
                                    <span>{{ $notification_info['updated_at'] }}</span>
                                </div>
                            </div>
                            @endforeach
                            <div class="text-center">
                                <a href="{{ route('notifications') }}" class="text-theme font-size-sm mx-auto">{{ trans('buttons.all_notifications') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $('#top_dashboard').addClass('text-danger');
            getBalance();
        });

        function getBalance() {
            var token = $("input[name=_token]").val();

            $.ajax({
                url: '{{ route('exchange.balance') }}',
                type: 'POST',
                data: {_token: token},
                dataType: 'JSON',
                success: function (response) {
                    if (response == undefined || response.length == 0) {
                    } else {
                        for (var i = 0; i < response.length; i++) {
                            $('#balance_' + response[i].currency).html(response[i].balance);
                        }
                    }
                }
            });
        }
    </script>
@endsection
