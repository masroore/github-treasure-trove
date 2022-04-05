@extends(Auth::user() ? 'layouts.dashboard' : 'layouts.app')

@section('title', trans('home.title'))

@section('content')
    <!-- WELCOME -->
    <section id="welcome" class="p-b-0 body-min-height dark">
        <div class="container">
<!--            <div class="heading-text heading-section text-center m-b-80" data-animate="animate__fadeInUp">
                <h2>{{ trans('home.page_title') }}</h2>
            </div>-->
            <div class="row">
                <div class="col-lg-7 m-b-40 p-0 row text-center" data-animate="animate__fadeInLeft">
                    <div class="col-md-6 p-5">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                {
                                    "symbol": "BINANCE:BTCUSDT",
                                    "width": "100%",
                                    "height": "100%",
                                    "locale": "en",
                                    "dateRange": "3M",
                                    "colorTheme": "dark",
                                    "trendLineColor": "rgba(41, 98, 255, 1)",
                                    "underLineColor": "rgba(41, 98, 255, 0.3)",
                                    "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                    "isTransparent": false,
                                    "autosize": true,
                                    "largeChartUrl": ""
                                }
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                    <div class="col-md-6 p-5">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                {
                                    "symbol": "BINANCE:ETHUSDT",
                                    "width": "100%",
                                    "height": "100%",
                                    "locale": "en",
                                    "dateRange": "3M",
                                    "colorTheme": "dark",
                                    "trendLineColor": "rgba(41, 98, 255, 1)",
                                    "underLineColor": "rgba(41, 98, 255, 0.3)",
                                    "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                    "isTransparent": false,
                                    "autosize": true,
                                    "largeChartUrl": ""
                                }
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                    <div class="col-md-6 p-5">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                {
                                    "symbol": "BINANCE:XRPUSDT",
                                    "width": "100%",
                                    "height": "100%",
                                    "locale": "en",
                                    "dateRange": "3M",
                                    "colorTheme": "dark",
                                    "trendLineColor": "rgba(41, 98, 255, 1)",
                                    "underLineColor": "rgba(41, 98, 255, 0.3)",
                                    "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                    "isTransparent": false,
                                    "autosize": true,
                                    "largeChartUrl": ""
                                }
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                    <div class="col-md-6 p-5">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                {
                                    "symbol": "BINANCE:LTCUSDT",
                                    "width": "100%",
                                    "height": "100%",
                                    "locale": "en",
                                    "dateRange": "3M",
                                    "colorTheme": "dark",
                                    "trendLineColor": "rgba(41, 98, 255, 1)",
                                    "underLineColor": "rgba(41, 98, 255, 0.3)",
                                    "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                    "isTransparent": false,
                                    "autosize": true,
                                    "largeChartUrl": ""
                                }
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                    <div class="col-md-6 p-5">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                {
                                    "symbol": "BINANCE:ADAUSDT",
                                    "width": "100%",
                                    "height": "100%",
                                    "locale": "en",
                                    "dateRange": "3M",
                                    "colorTheme": "dark",
                                    "trendLineColor": "rgba(41, 98, 255, 1)",
                                    "underLineColor": "rgba(41, 98, 255, 0.3)",
                                    "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                    "isTransparent": false,
                                    "autosize": false,
                                    "largeChartUrl": ""
                                }
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                    <div class="col-md-6 p-5">
                        <!-- TradingView Widget BEGIN -->
                        <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                {
                                    "symbol": "BINANCE:DOGEUSDT",
                                    "width": "100%",
                                    "height": "100%",
                                    "locale": "en",
                                    "dateRange": "3M",
                                    "colorTheme": "dark",
                                    "trendLineColor": "rgba(41, 98, 255, 1)",
                                    "underLineColor": "rgba(41, 98, 255, 0.3)",
                                    "underLineBottomColor": "rgba(41, 98, 255, 0)",
                                    "isTransparent": false,
                                    "autosize": true,
                                    "largeChartUrl": ""
                                }
                            </script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
                <div class="col-lg-5 m-b-40 text-right" data-animate="animate__fadeInRight">
                    <img class="m-b-20" src="{{ asset('/images/logo_main.png') }}" style="max-height: 70px">
                    <h1>{{ trans('home.main_desc') }}</h1>
                    <h4>{{ trans('home.desc') }}</h4>
                    <hr class="space">
                    @guest
                        <div>
                            <a href="{{ route('login') }}" class="btn btn-primary"><i class="icon-log-in"></i>&nbsp;{{ trans('buttons.login') }}</a>
                            <a href="{{ route('register') }}" class="btn btn-primary"><i class="icon-user-plus"></i>&nbsp;{{ trans('buttons.register') }}</a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </section>
    <!-- end: WELCOME -->
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $('#top_home').addClass('text-danger');
        });
    </script>
@endsection