@extends('layouts.trading')

@section('title', trans('dealer.title'))

@section('content')
    <section class="p-0 h-100" style="min-height: 500px;">
        <div class="row col-12 h-100 p-0 m-0">
            <div class="col-lg-2 border-panel p-0">
                <div class="tabs">
                    <div class="tab-pane fade active show" id="order" role="tabpanel" aria-labelledby="order-tab">
                        <h5 class="mt-2 text-primary text-center"><b>{{ trans('dealer.page_title') }}</b></h5>
                        <hr class="my-2">
                        <div class="row">
                            @csrf

                            <div class="mt-3 col-lg-12 col-md-6">
                                <div class="form-group">
                                    <div class="row m-0">
                                        <div class="col-6 p-r-0"><button type="button" class="btn btn-info btn-block buy-b-r" id="buy_opt" onclick="onSelBuy()">{{ trans('dealer.buy_opt') }}</button></div>
                                        <div class="col-6 p-l-0"><button type="button" class="btn btn-light btn-light-hover btn-block sell-b-r" id="sell_opt" onclick="onSelSell()">{{ trans('dealer.sell_opt') }}</button></div>
                                    </div>
                                </div>
                                @auth
                                <div class="form-group row">
                                    <div class="col-4">{{ trans('dealer.available') }}:</div>
                                    <div class="col-8 text-right"><h5><span id="available_balance"></span><span id="trade_currency"></span></h5></div>
                                </div>
                                @endauth
                                <div class="form-group row">
                                    <div class="col-4">{{ trans('dealer.price') }}:</div>
                                    <div class="col-8 text-right"><h5><span id="price">0</span>&nbsp;<span class="text-info font-size-sm"></span></h5></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group text-light">
                                        <span class="input-group-text font-size-xs input-dark-bg">{{ trans('dealer.amount') }}</span>
                                        <input type="text" class="form-control form-control-sm text-light input-dark-bg text-right" id="amount" onchange="onCalcAmount()">
                                        <span class="input-group-text font-size-xs input-dark-bg" id="first_currency"></span>
                                    </div>
                                    <div class="is-invalid text-right" id="amount_error"></div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="input-group text-light">
                                        <span class="input-group-text font-size-xs input-dark-bg">{{ trans('dealer.total') }}</span>
                                        <input type="text" class="form-control form-control-sm text-light input-dark-bg text-right" id="total" readonly>
                                        <span class="input-group-text font-size-xs input-dark-bg" id="second_currency"></span>
                                    </div>
                                    <div class="is-invalid text-right" id="total_error"></div>
                                </div>
                                @auth
                                    <button type="button" class="btn btn-info btn-block" id="order_btn" onclick="onOrder()">{{ trans('common.order.buy') }}</button>
                                    <hr class="my-4">
                                @endauth
                            </div>
                            @guest
                                <div class="col-lg-12 col-md-6">
                                    <hr class="space">
                                    <div class="text-center">
                                        <a href="{{ route('login') }}" class="btn btn-primary"><i class="icon-log-in"></i>&nbsp;{{ trans('buttons.login') }}</a>
                                        <a href="{{ route('register') }}" class="btn btn-primary"><i class="icon-user-plus"></i>&nbsp;{{ trans('buttons.register') }}</a>
                                    </div>
                                    <hr class="space">
                                </div>
                            @else
                                <div class="col-lg-12 col-md-6" id="balance_panel">
                                    <div class="form-group row">
                                        <div class="col-6"><h5 class="text-light">{{ trans('dealer.currency') }}</h5></div>
                                        <div class="col-6 text-right"><h5 class="text-light">{{ trans('dealer.balance') }}</h5></div>
                                    </div>
                                    @foreach ($currency_list as $currency_info)
                                        @if ($currency_info['use_deposit'] == config('constants.use_deposit.enable'))
                                            <div class="row mb-1">
                                                <div class="col-6"><img src="{{ $currency_info['ico'] }}" width="24px" class="p-r-10"><b>{{ $currency_info['currency'] }}</b></div>
                                                <div class="col-6 text-right"><h5 id="balance_{{ $currency_info['currency'] }}" class="text-light">0</h5></div>
                                                <input type="hidden" id="{{ $currency_info['currency'] }}_balance" value="0">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="row mh-100">
                    <div class="col-lg-4 border-panel p-0">
                        <table id="tbl_trade_list" class="table table-dark font-size-sm">
                            <thead class="text-center">
                            <tr>
                                <th scope="col" class="p-10 no-border">{{ trans('dealer.symbol') }}</th>
                                <th scope="col" class="p-10 no-border">{{ trans('dealer.buy_sell') }}</th>
                                <th scope="col" class="p-10 no-border">{{ trans('dealer.amount') }}</th>
                                <th scope="col" class="p-10 no-border">{{ trans('dealer.datetime') }}</th>
                            </tr>
                            </thead>
                            <tbody id="trade_list_body">
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-8 border-panel p-0">
                        <!-- TradingView Widget BEGIN -->
                        <div id="crypto_chart" class=""></div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
                <div class="font-size-sm text-light row overflow-auto" id="list_tab">
                    <table id="trade_history_tbl" class="table table-dark trading-list text-center" style="width:100%">
                        <thead>
                        <tr>
                            <th class="background-dark">{{ trans('dealer.trade_id') }}</th>
                            <th class="background-dark">{{ trans('dealer.trade_datetime') }}</th>
                            <th class="background-dark">{{ trans('dealer.type') }}</th>
                            <th class="background-dark">{{ trans('dealer.symbol') }}</th>
                            <th class="background-dark">{{ trans('dealer.order_type') }}</th>
                            <th class="background-dark">{{ trans('dealer.price') }}</th>
                            <th class="background-dark">{{ trans('dealer.amount') }}</th>
                            <th class="background-dark">{{ trans('dealer.fee') }}</th>
                            <th class="background-dark">{{ trans('dealer.status') }}</th>
                            <th class="background-dark">{{ trans('dealer.remark') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script>
        $( document ).ready(function() {
            $('#top_dealer').addClass('text-danger');

            onSelectCurrency('{{ $id }}', '{{ $currency }}', '{{ $price_decimals }}');
            @auth
                getBalance();
            @endauth
        });

        var g_first_currency;
        var g_second_currency;
        var g_ask_price = 0;
        var g_bid_price = 0;
        var g_price = 0;
        var g_price_decimals = 0;
        var g_signal = '{{ config('constants.order_type.buy') }}';

        function onSelectCurrency(id, symbol, price_decimals) {
            $('#symbol').html(symbol);

            var currencies = symbol.split("/");
            $('#first_currency').html(currencies[0]);
            $('#second_currency').html(currencies[1]);
            g_first_currency = currencies[0];
            g_second_currency = currencies[1];
            g_currencyId = id;
            g_currencyName = symbol;
            g_price_decimals = price_decimals;

            $('#symbol_id').val(id);
            $('#symbol_dropdown').removeClass('dropdown-active');

            refreshChart();
            getTradeList();
            @auth
                getTradeHistory();
            @endauth
        }

        function onSelSell() {
            $('#buy_opt').removeClass('btn-info');
            $('#buy_opt').addClass('btn-light btn-light-hover');
            $('#sell_opt').removeClass('btn-light btn-light-hover');
            $('#sell_opt').addClass('btn-danger');
            $('#order_btn').removeClass('btn-info');
            $('#order_btn').addClass('btn-danger');
            $('#order_btn').html('{{ trans('common.order.sell') }}');
            g_signal = '{{ config('constants.order_type.sell') }}';

            g_price = g_bid_price;
            $('#price').html(g_price);
            $('#top_price').html(g_price);

            var available_balance = $('#' + g_first_currency + '_balance').val();
            $('#available_balance').html(available_balance);
            $('#trade_currency').html(g_first_currency);

            onCalcAmount();
        }

        function onSelBuy() {
            $('#sell_opt').removeClass('btn-danger');
            $('#sell_opt').addClass('btn-light btn-light-hover');
            $('#buy_opt').removeClass('btn-light btn-light-hover');
            $('#buy_opt').addClass('btn-info');
            $('#order_btn').removeClass('btn-danger');
            $('#order_btn').addClass('btn-info');
            $('#order_btn').html('{{ trans('common.order.buy') }}');
            g_signal = '{{ config('constants.order_type.buy') }}';

            g_price = g_ask_price;
            $('#price').html(g_price);
            $('#top_price').html(g_price);

            var available_balance = $('#' + g_second_currency + '_balance').val();
            $('#available_balance').html(available_balance);
            $('#trade_currency').html(g_second_currency);

            onCalcAmount();
        }

        function getBalance() {
            var token = $("input[name=_token]").val();

            $.ajax({
                url: '{{ route('exchange.balance') }}',
                type: 'POST',
                data: {_token: token},
                dataType: 'JSON',
                success: function (response) {

                    balance_list = '<div class="form-group row">\n' +
                        '                            <div class="col-6"><h5 class="text-light">{{ trans('dealer.currency') }}</h5></div>\n' +
                        '                            <div class="col-6 text-right"><h5 class="text-light">{{ trans('dealer.balance') }}</h5></div>\n' +
                        '                        </div>';
                    if (response == undefined || response.length == 0) {
                    } else {
                        for (var i = 0; i < response.length; i++) {
                            $('#balance_' + response[i].currency).html(response[i].balance);
                            $('#' + response[i].currency + '_balance').val(response[i].available_balance);
                        }
                    }

                    if (g_signal == '{{ config('constants.order_type.sell') }}') {
                        var available_balance = $('#' + g_first_currency + '_balance').val();
                        $('#available_balance').html(available_balance);
                        $('#trade_currency').html(g_first_currency);
                    } else {
                        var available_balance = $('#' + g_second_currency + '_balance').val();
                        $('#available_balance').html(available_balance);
                        $('#trade_currency').html(g_second_currency);
                    }
                }
            });
        }

        function getTradeHistory() {
            var token = $("input[name=_token]").val();
            var symbol = $('#symbol_id').val();

            $.ajax({
                url: '{{ route('exchange.trade.history') }}',
                type: 'POST',
                data: {_token: token, symbol: symbol},
                dataType: 'JSON',
                success: function (response) {
                    if ( $.fn.DataTable.isDataTable( '#trade_history_tbl' ) ) {
                        var trade_history_tbl = $('#trade_history_tbl').DataTable();
                        trade_history_tbl.destroy();
                    }

                    datas = new Array();
                    if (response == undefined || response.length == 0) {
                    } else {
                        for (var i = 0; i < response.length; i++) {

                            var cancel = '<a class="ms-2 text-reset" href="#" data-bs-toggle="tooltip" data-bs-original-title="Cancel"><i class="icon-x"></i></a>';

                            datas.push([
                                response[i].trade_id,
                                moment(response[i].settled_at).utc().format('YYYY-MM-DD HH:mm:ss'),
                                response[i].type,
                                response[i].symbol,
                                response[i].signal,
                                response[i].settle_price,
                                response[i].settle_amount,
                                response[i].fee,
                                response[i].status,
                                response[i].remark,
                            ]);
                        }
                    }

                    $('#trade_history_tbl').dataTable({
                        data: datas,
                        searching: false,
                        viewCount: false,
                        bLengthChange: false,
                        order: [[ 1, "desc" ]],
                        columnDefs: [
                            {
                                targets: [5, 6, 7],
                                className: 'text-right'
                            }
                        ],
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

        function getTradeList() {
            var token = $("input[name=_token]").val();
            var symbol = $('#symbol_id').val();

            $.ajax({
                url: '{{ route('dealer.trade.list') }}',
                type: 'POST',
                data: {_token: token, symbol: symbol},
                dataType: 'JSON',
                success: function (response) {
                    datas = new Array();
                    if (response == undefined || response.length == 0) {
                    } else {
                        var trade_list = '';
                        var length = response.length;
                        if (length > '{{ config('constants.trade_list_count') }}')
                            length = '{{ config('constants.trade_list_count') }}';

                        for (var i = 0; i < length; i++) {
                            var content = '<tr class="text-center">\n' +
                                '                                <td class="p-0 no-border">' + response[i].symbol + '</td>\n' +
                                '                                <td class="p-0 no-border ' + (response[i].signal == '{{ config('constants.order_type.sell') }}' ? "text-danger" : "text-info") + '">' + response[i].signal_str + '</td>\n' +
                                '                                <td class="p-0 no-border">' + response[i].settle_amount + '</td>\n' +
                                '                                <td class="p-0 no-border">' + moment(response[i].settled_at).utc().format('YYYY-MM-DD HH:mm:ss') + '</td>\n' +
                                '                            </tr>';
                            trade_list = trade_list + content;
                        }

                        $('#trade_list_body').html(trade_list);
                    }
                }
            });
        }

        function onCalcAmount() {
            var amount = $('#amount').val();

            if (g_signal == '{{ config('constants.order_type.buy') }}') {
                g_price = g_ask_price;
                $('#price').html(g_price);
                $('#top_price').html(g_price);

                var total = amount * g_price;
                var balance = $('#' + g_second_currency + '_balance').val();

                $('#amount').removeClass('text-danger');
                $('#amount').addClass('text-light');
                $('#total_error').html('');
                $('#amount_error').html('');

                if (parseFloat(balance) < parseFloat(total)) {
                    $('#total').removeClass('text-light');
                    $('#total').addClass('text-danger');
                    $('#total_error').html('{{ trans('dealer.balance_error_msg') }}');
                } else {
                    $('#total').removeClass('text-danger');
                    $('#total').addClass('text-light');
                    $('#total_error').html('');
                }
            } else {
                g_price = g_bid_price;
                $('#price').html(g_price);
                $('#top_price').html(g_price);

                var total = amount * g_price;
                var balance = $('#' + g_first_currency + '_balance').val();

                $('#total').removeClass('text-danger');
                $('#total').addClass('text-light');
                $('#total_error').html('');
                $('#amount_error').html('');

                if (parseFloat(balance) < parseFloat(amount)) {
                    $('#amount').removeClass('text-light');
                    $('#amount').addClass('text-danger');
                    $('#amount_error').html('{{ trans('dealer.balance_error_msg') }}');
                } else {
                    $('#amount').removeClass('text-danger');
                    $('#amount').addClass('text-light');
                    $('#amount_error').html('');
                }
            }

            total = _number_format(total, g_price_decimals);
            $('#total').val(total);
        }

        function onOrder() {
            var token = $("input[name=_token]").val();
            var currency = $('#symbol_id').val();
            var symbol = $('#symbol').html();

            var order_price = g_price;
            var order_amount = $('#amount').val();
            var signal = g_signal;

            if (signal == '{{ config('constants.order_type.sell') }}') {
                var balance = $('#' + g_first_currency + '_balance').val();
                if (parseFloat(balance) < parseFloat(order_amount)) {
                    toastr.error("{{ trans('dealer.balance_error_msg') }}");
                    return;
                }
            } else if(signal == '{{ config('constants.order_type.buy') }}') {
                var balance = $('#' + g_second_currency + '_balance').val();
                if (parseFloat(balance) < parseFloat(order_amount * order_price)) {
                    toastr.error("{{ trans('dealer.balance_error_msg') }}");
                    return;
                }
            }

            var type1 = '{{ config('constants.trade_type.dealer') }}';
            var type2 = '{{ config('constants.order_type2.limit') }}'

            $.ajax({
                url: '{{ route('exchange.order') }}',
                type: 'POST',
                data: {_token: token, currency: currency, order_price: order_price, order_amount: order_amount, signal: signal, type1: type1, type2:type2},
                dataType: 'JSON',
                success: function (response) {
                    if (response == undefined || response.status == 0) {
                        toastr.error("{{ trans('dealer.order_failed_msg') }}");
                        if(response.errors !== undefined && response.errors.order_amount != undefined)
                            $('#amount_error').html(response.errors.order_amount[0]);
                    } else {
                        toastr.success("{{ trans('dealer.order_success_msg') }}");
                        getTradeHistory();
                        getBalance();
                    }
                }
            });
        }

        setInterval(function(){
            getTradeList();
            if(g_signal == '{{ config('constants.order_type.sell') }}')
                g_price = g_bid_price;
            else
                g_price = g_ask_price;
            $('#price').html(g_price);
            $('#top_price').html(g_price);
            @auth
                getBalance();
            @endauth
        }, 1000);

        const g_masterData = '';
        var isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';
        var g_currencyId = "", g_currencyName = "", g_basicCoin = "", g_curCoin = "";
        var g_intervalOrderBook = null;
        var g_lastPrice = '{{ $lastPrice }}';
        var isAuth = "{{ Auth::check() ? 1 : 0 }}";

        var g_chart, g_interval = '1'; //1min : Resolution
        var history = {};
        var g_rateUrl = "{{ route('dealer.rate.interval') }}";

        var supportedResolutions = ["1", "5", "15", "30", "60", "240", "D"];
        var config = {
            supported_resolutions: supportedResolutions,
        };

        var widgetConfig = {
            interval: g_interval, //default: 1min
            locale: "{{ app()->getLocale() }}",
            autosize: true,
            style: 1,
            container_id: 'crypto_chart',//容器id
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            disabled_features: [
                'save_chart_properties_to_local_storage',
                'volume_force_overlay',
                'study_templates',
                'header_undo_redo',
                'header_symbol_search',
                'symbol_search_hot_key',
                'adaptive_logo',
                'go_to_date',
                'header_compare',
                'use_localstorage_for_settings'
            ],
            //enabled_features: ["study_templates"],
            enabled_features: [
                'hide_last_na_study_output', 'side_toolbar_in_fullscreen_mode', 'disable_resolution_rebuild', 'move_logo_to_main_pane'
            ],
            overrides: {
                //蜡烛样式
                'mainSeriesProperties.candleStyle.upColor': '#117a8b',
                'mainSeriesProperties.candleStyle.downColor': '#bd2130',
                //烛心
                'mainSeriesProperties.candleStyle.drawWick': true,
                //烛心颜色
                'mainSeriesProperties.candleStyle.wickUpColor:': '#117a8b',
                'mainSeriesProperties.candleStyle.wickDownColor': '#bd2130',
                //边框
                'mainSeriesProperties.candleStyle.drawBorder': true,
                'mainSeriesProperties.candleStyle.borderUpColor': '#117a8b',
                'mainSeriesProperties.candleStyle.borderDownColor': '#bd2130',
                //面积图《分时图》 styles
                'mainSeriesProperties.areaStyle.color1': '#88c0ff',
                'mainSeriesProperties.areaStyle.color2': '#1e2022',
                'mainSeriesProperties.areaStyle.linecolor': '#117a8b',
                'mainSeriesProperties.areaStyle.linewidth': 1,
                //背景
                'paneProperties.background': '#1e2022',
                //网格线
                'paneProperties.vertGridProperties.color': '#252525',
                'paneProperties.vertGridProperties.style': 0,
                'paneProperties.horzGridProperties.color': '#252525',
                'paneProperties.horzGridProperties.style': 0,
                //坐标轴和刻度标签颜色
                'scalesProperties.lineColor': '#686d80',
                'scalesProperties.textColor': '#959595',
                'scalesProperties.showLeftScale': false,
                //隐藏图例
//            'paneProperties.legendProperties.showLegend': true,
//            'paneProperties.legendProperties.showSeriesTitle': false,
//            'paneProperties.legendProperties.showStudyTitle': false,
//            'paneProperties.legendProperties.showStudyArgument': false,
//            'scalesProperties.showButtomScale': false,
                //成交量高度
                'volumePaneSize': 'medium',
                // "MACDPaneSize":"tiny"
                /* 边距 */
                'paneProperties.topMargin': 15,
//            'timeScale.rightOffent': 2,
                'symbolWatermarkProperties.color': 'rgba(0, 0, 0, 0)'
            },
            studies_overrides: {
                //销量颜色
                'volume.volume.color.0': '#bd2130',
                'volume.volume.color.1': '#117a8b'
            },
            time_frames: [],
            drawings_access: { type: 'black', tools: [{ name: "Regression Trend" }] },
            //timezone: 'Asia/Tokyo', //地区时间
            datafeed: new UniexchangeDatafeed({ debug: true}),
            library_path: "{{ asset('plugins/charting_library') . '/' }}", //调用本js图表地库和样式
            //charts_storage_url: 'http://saveload.tradingview.com',
            //charts_storage_api_version: "1.1",
            toolbar_bg: '#1e2022',
            client_id : '{{ config('app.name', 'ADAM Bit') }}',
            user_id: "public_user", //"public_user_id", //"public_user",
            customFormatters: {
                timeFormatter: {
                    format: function (date) {
                        var _format_str = '%h:%m'
                        return _format_str.replace('%h', date.getUTCHours(), 2).replace('%m', date.getUTCMinutes(), 2).replace('%s', date.getUTCSeconds(), 2)
                    }
                },
                dateFormatter: {
                    format: function (date) { return date.getUTCFullYear() + '/' + (date.getUTCMonth() + 1) + '/' + (date.getUTCDate()) }
                }
            },
        }

        function refreshChart() {
            widgetConfig.symbol = g_currencyName;
            widgetConfig.interval = g_interval; //m1, m5, m15, m30, m60, m240, m1440
            //$("#chartContainer").LoadingOverlay('show');
            g_chart = new TradingView.widget(widgetConfig)
        }
    </script>
@endsection