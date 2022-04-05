@extends('layouts.trading')

@section('title', trans('exchange.title'))

@section('content')
    <section class="p-0 h-100" style="min-height: 500px;">
        <div class="row col-12 h-100 p-0 m-0 direction-right">
            <div class="col-lg-2 border-panel p-0 direction-left">
                <h5 class="mt-2 text-primary text-center"><b>{{ trans('exchange.page_title') }}</b></h5>
                <hr class="my-2">
                @csrf

                <div class="row">
                    <div class="tabs col-lg-12 col-md-6">
                        <nav class="nav nav-tabs nav-justified">
                            <a class="nav-item nav-link active" id="limit-tab" data-bs-toggle="tab" href="#limit" role="tab" aria-controls="order" aria-selected="true">{{ trans('exchange.limit') }}</a>
                            <a class="nav-item nav-link" id="market-tab" data-bs-toggle="tab" href="#market" role="tab" aria-controls="step" aria-selected="false">{{ trans('exchange.market') }}</a>
                        </nav>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="limit" role="tabpanel" aria-labelledby="step-tab">
                                <div class="form-group">
                                    <div class="row m-0">
                                        <div class="col-6 p-r-0"><button type="button" class="btn btn-info btn-block buy-b-r" id="buy_opt" onclick="onSelBuy()">{{ trans('exchange.buy_opt') }}</button></div>
                                        <div class="col-6 p-l-0"><button type="button" class="btn btn-light btn-light-hover btn-block sell-b-r" id="sell_opt" onclick="onSelSell()">{{ trans('exchange.sell_opt') }}</button></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group text-light ">
                                        <span class="input-group-text font-size-xs input-dark-bg">{{ trans('exchange.price') }}</span>
                                        <input type="text" class="form-control form-control-sm text-light input-dark-bg text-right" id="limit_price" name="limit_price" onchange="onCalcLimitAmount()">
                                        <span class="input-group-text font-size-xs input-dark-bg currency-span" id="limit_symbol"></span>
                                    </div>
                                    <div class="is-invalid text-right" id="limit_price_error"></div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group text-light ">
                                        <span class="input-group-text font-size-xs input-dark-bg">{{ trans('exchange.amount') }}</span>
                                        <input type="text" class="form-control form-control-sm text-light input-dark-bg text-right" id="limit_amount" name="limit_amount" onchange="onCalcLimitAmount()">
                                        <span class="input-group-text font-size-xs input-dark-bg currency-span" id="limit_first_currency"></span>
                                    </div>
                                    <div class="is-invalid text-right" id="limit_amount_error"></div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="input-group text-light ">
                                        <span class="input-group-text font-size-xs input-dark-bg">{{ trans('exchange.total') }}</span>
                                        <input type="text" class="form-control form-control-sm text-light input-dark-bg text-right" id="limit_total" name="limit_total" readonly>
                                        <span class="input-group-text font-size-xs input-dark-bg currency-span" id="limit_second_currency"></span>
                                    </div>
                                    <div class="is-invalid text-right" id="limit_total_error"></div>
                                </div>
                                @auth
                                <div class="form-group range-color-info" id="limit_range">
                                    <input type="hidden" id="range_slider_limit"/>
                                </div>

                                <input type="hidden" id="limit_signal" value="{{ config('constants.order_type.buy') }}">
                                <button type="button" class="btn btn-block btn-info" id="limit_order_btn" onclick="onOrder('{{ config('constants.order_type2.limit') }}')">{{ trans('common.order.buy') }}</button>
                                @endauth
                            </div>
                            <div class="tab-pane fade" id="market" role="tabpanel" aria-labelledby="step-tab">
                                <div class="form-group text-light">
                                    <div class="row m-0">
                                        <div class="col-6 p-r-0"><button type="button" class="btn btn-info btn-block buy-b-r" id="buy_market_opt" onclick="onSelMarketBuy()">{{ trans('exchange.buy_opt') }}</button></div>
                                        <div class="col-6 p-l-0"><button type="button" class="btn btn-light btn-light-hover btn-block sell-b-r" id="sell_market_opt" onclick="onSelMarketSell()">{{ trans('exchange.sell_opt') }}</button></div>
                                    </div>
                                </div>

                                <input type="hidden" id="market_buy_price">
                                <input type="hidden" id="market_sell_price">

                                <div class="form-group">
                                    <div class="input-group text-light">
                                        <span class="input-group-text font-size-xs input-dark-bg">{{ trans('exchange.amount') }}</span>
                                        <input type="text" class="form-control form-control-sm text-light input-dark-bg text-right" id="market_amount" name="market_amount" onchange="onCalcMarketAmount()">
                                        <span class="input-group-text font-size-xs input-dark-bg currency-span" id="market_first_currency"></span>
                                    </div>
                                    <div class="is-invalid text-right" id="market_amount_error"></div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="input-group text-light">
                                        <span class="input-group-text font-size-xs input-dark-bg">{{ trans('exchange.total') }}</span>
                                        <input type="text" class="form-control form-control-sm text-light input-dark-bg text-right" id="market_total" name="market_total" readonly>
                                        <span class="input-group-text font-size-xs input-dark-bg currency-span" id="market_second_currency"></span>
                                    </div>
                                    <div class="is-invalid text-right" id="market_total_error"></div>
                                </div>
                                @auth
                                    <div class="form-group range-color-info" id="market_range">
                                        <input type="hidden" id="range_slider_market"/>
                                    </div>

                                    <input type="hidden" id="market_signal" value="{{ config('constants.order_type.buy') }}">
                                    <button type="button" class="btn btn-info btn-block" id="market_order_btn" onclick="onOrder('{{ config('constants.order_type2.market') }}')">{{ trans('common.order.buy') }}</button>
                                @endauth
                            </div>
                        </div>
                        @auth
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
                            <div class="col-6"><h5 class="text-light">{{ trans('exchange.currency') }}</h5></div>
                            <div class="col-6 text-right"><h5 class="text-light">{{ trans('exchange.balance') }}</h5></div>
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
            <div class="col-lg-10 direction-left">
                <div class="row mh-100 direction-right">
                    <div class="col-lg-3 border-panel p-0 direction-left">
                        <table id="order_book" class="table table-dark font-size-sm">
                            <thead class="text-center">
                            <tr>
                                <th scope="col" class="p-10 no-border">{{ trans('exchange.ask') }}</th>
                                <th scope="col" class="p-10 no-border">{{ trans('exchange.price') }}</th>
                                <th scope="col" class="p-10 no-border">{{ trans('exchange.bid') }}</th>
                            </tr>
                            </thead>
                            <tbody id="ask_order_list">
                            </tbody>
                            <tbody id="order_price">
                            </tbody>
                            <tbody id="bid_order_list">
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-9 border-panel p-0 direction-left">
                        <!-- TradingView Widget BEGIN -->
                        <div id="crypto_chart" class=""></div>
                        <!-- TradingView Widget END -->
                    </div>
                </div>
                <div class="tabs text-light row" id="list_tab">
                    <ul class="nav nav-tabs no-border m-0" id="list_tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active px-4 py-2 font-size-sm" id="order-tab" data-bs-toggle="tab" href="#order" role="tab" aria-controls="order" aria-selected="true">{{ trans('exchange.order_history') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-4 py-2 font-size-sm" id="trade-tab" data-bs-toggle="tab" href="#trade" role="tab" aria-controls="trade" aria-selected="false">{{ trans('exchange.trade_history') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content font-size-sm overflow-auto mt-1" id="historyTab">
                        <div class="tab-pane fade active show" id="order" role="tabpanel" aria-labelledby="order-tab">
                            <table id="order_history_tbl" class="table table-dark trading-list text-center" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="background-dark">{{ trans('exchange.order_id') }}</th>
                                    <th class="background-dark">{{ trans('exchange.order_datetime') }}</th>
                                    <th class="background-dark">{{ trans('exchange.type') }}</th>
                                    <th class="background-dark">{{ trans('exchange.symbol') }}</th>
                                    <th class="background-dark">{{ trans('exchange.order_type') }}</th>
                                    <th class="background-dark">{{ trans('exchange.price') }}</th>
                                    <th class="background-dark">{{ trans('exchange.amount') }}</th>
                                    <th class="background-dark">{{ trans('exchange.status') }}</th>
                                    <th class="background-dark">{{ trans('exchange.remark') }}</th>
                                    <th class="background-dark">{{ trans('exchange.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="trade" role="tabpanel" aria-labelledby="trade-tab">
                            <table id="trade_history_tbl" class="table table-dark trading-list text-center" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="background-dark">{{ trans('exchange.order_id') }}</th>
                                    <th class="background-dark">{{ trans('exchange.trade_id') }}</th>
                                    <th class="background-dark">{{ trans('exchange.settle_datetime') }}</th>
                                    <th class="background-dark">{{ trans('exchange.type') }}</th>
                                    <th class="background-dark">{{ trans('exchange.symbol') }}</th>
                                    <th class="background-dark">{{ trans('exchange.order_type') }}</th>
                                    <th class="background-dark">{{ trans('exchange.price') }}</th>
                                    <th class="background-dark">{{ trans('exchange.amount') }}</th>
                                    <th class="background-dark">{{ trans('exchange.fee') }}</th>
                                    <th class="background-dark">{{ trans('exchange.status') }}</th>
                                    <th class="background-dark">{{ trans('exchange.remark') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script>
        $( document ).ready(function() {
            $('#top_exchange').addClass('text-danger');

            onSelectCurrency('{{ $id }}', '{{ $currency }}', '{{ $price_decimals }}');
            @auth
                getBalance();
            @endauth

            $('#range_slider_limit').ionRangeSlider({
                type: "single",
                grid: true,
                min: 0,
                max: 100,
                from: 1,
                postfix: "%"
            });

            $('#range_slider_market').ionRangeSlider({
                type: "single",
                grid: true,
                min: 0,
                max: 100,
                from: 1,
                postfix: "%"
            });
        });

        function onSelectCurrency(id, symbol, price_decimals) {
            $('#symbol').html(symbol);
            $('#limit_symbol').html(symbol);
            $('#market_symbol').html(symbol);

            var currencies = symbol.split("/");
            $('#limit_first_currency').html(currencies[0]);
            $('#limit_second_currency').html(currencies[1]);
            $('#market_first_currency').html(currencies[0]);
            $('#market_second_currency').html(currencies[1]);

            $('#symbol_id').val(id);
            $('#symbol_dropdown').removeClass('dropdown-active');
            $('#order_price').html('');
            $('#ask_order_list').html('');
            $('#bid_order_list').html('');

            g_currencyId = id;
            g_currencyName = symbol;
            g_price_decimals = price_decimals;
            refreshChart();
            @auth
            getOrderHistory();
            getTradeHistory();
            @endauth
        }

        function onSelSell() {
            $('#buy_opt').removeClass('btn-info');
            $('#buy_opt').addClass('btn-light btn-light-hover');
            $('#sell_opt').removeClass('btn-light btn-light-hover');
            $('#sell_opt').addClass('btn-danger');
            $('#limit_range').removeClass('range-color-info');
            $('#limit_range').addClass('range-color-danger');
            $('#limit_order_btn').removeClass('btn-info');
            $('#limit_order_btn').addClass('btn-danger');
            $('#limit_order_btn').html('{{ trans('common.order.sell') }}');
            $('#limit_signal').val('{{ config('constants.order_type.sell') }}');
            onCalcLimitAmount();
        }

        function onSelBuy() {
            $('#sell_opt').removeClass('btn-danger');
            $('#sell_opt').addClass('btn-light btn-light-hover');
            $('#buy_opt').removeClass('btn-light btn-light-hover');
            $('#buy_opt').addClass('btn-info');
            $('#limit_range').removeClass('range-color-danger');
            $('#limit_range').addClass('range-color-info');
            $('#limit_order_btn').removeClass('btn-danger');
            $('#limit_order_btn').addClass('btn-info');
            $('#limit_order_btn').html('{{ trans('common.order.buy') }}');
            $('#limit_signal').val('{{ config('constants.order_type.buy') }}');
            onCalcLimitAmount();
        }

        function onSelMarketSell() {
            $('#buy_market_opt').removeClass('btn-info');
            $('#buy_market_opt').addClass('btn-light btn-light-hover');
            $('#sell_market_opt').removeClass('btn-light btn-light-hover');
            $('#sell_market_opt').addClass('btn-danger');
            $('#market_range').removeClass('range-color-info');
            $('#market_range').addClass('range-color-danger');
            $('#market_order_btn').removeClass('btn-info');
            $('#market_order_btn').addClass('btn-danger');
            $('#market_order_btn').html('{{ trans('common.order.sell') }}');
            $('#market_signal').val('{{ config('constants.order_type.sell') }}');
        }

        function onSelMarketBuy() {
            $('#sell_market_opt').removeClass('btn-danger');
            $('#sell_market_opt').addClass('btn-light btn-light-hover');
            $('#buy_market_opt').removeClass('btn-light btn-light-hover');
            $('#buy_market_opt').addClass('btn-info');
            $('#market_range').removeClass('range-color-danger');
            $('#market_range').addClass('range-color-info');
            $('#market_order_btn').removeClass('btn-danger');
            $('#market_order_btn').addClass('btn-info');
            $('#market_order_btn').html('{{ trans('common.order.buy') }}');
            $('#market_signal').val('{{ config('constants.order_type.buy') }}');
        }

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
                            $('#' + response[i].currency + '_balance').val(response[i].available_balance);
                        }
                    }
                }
            });
        }

        function onCalcLimitAmount() {
            var price = $('#limit_price').val();
            var amount = $('#limit_amount').val();
            var total = price * amount;

            var symbol = $('#symbol').html();
            var currencies = symbol.split("/");
            var signal = $('#limit_signal').val();
            var percent = 0;
            if (signal == '{{ config('constants.order_type.sell') }}') {
                var balance = $('#' + currencies[0] + '_balance').val();
                percent = (amount / balance) * 100;

                $('#limit_total').removeClass('text-danger');
                $('#limit_total').addClass('text-light');
                $('#limit_total_error').html('');
                $('#limit_price_error').html('');

                if (parseFloat(balance) < parseFloat(amount)) {
                    $('#limit_amount').removeClass('text-light');
                    $('#limit_amount').addClass('text-danger');
                    $('#limit_amount_error').html('{{ trans('exchange.balance_error_msg') }}');
                } else {
                    $('#limit_amount').removeClass('text-danger');
                    $('#limit_amount').addClass('text-light');
                    $('#limit_amount_error').html('');
                }
            } else {
                var balance = $('#' + currencies[1] + '_balance').val();
                percent = (total / balance) * 100;

                $('#limit_amount').removeClass('text-danger');
                $('#limit_amount').addClass('text-light');
                $('#limit_amount_error').html('');
                $('#limit_price_error').html('');

                if (parseFloat(balance) < parseFloat(total)) {
                    $('#limit_total').removeClass('text-light');
                    $('#limit_total').addClass('text-danger');
                    $('#limit_total_error').html('{{ trans('exchange.balance_error_msg') }}');
                } else {
                    $('#limit_total').removeClass('text-danger');
                    $('#limit_total').addClass('text-light');
                    $('#limit_total_error').html('');
                }
            }

            total = _number_format(total, g_price_decimals);
            $('#limit_total').val(total);

            @auth
            var instance = $('#range_slider_limit').data("ionRangeSlider");
            instance.update({
                from: percent,
            });
            @endauth
        }

        function onCalcMarketAmount() {
            var amount = $('#market_amount').val();

            var symbol = $('#symbol').html();
            var currencies = symbol.split("/");
            var signal = $('#market_signal').val();
            var percent = 0;
            if (signal == '{{ config('constants.order_type.sell') }}') {
                var price = $('#market_sell_price').val();

                var balance = $('#' + currencies[0] + '_balance').val();
                percent = (amount / balance) * 100;

                $('#market_total').removeClass('text-danger');
                $('#market_total').addClass('text-light');
                $('#market_total_error').html('');

                if (parseFloat(balance) < parseFloat(amount)) {
                    $('#market_amount').removeClass('text-light');
                    $('#market_amount').addClass('text-danger');
                    $('#market_amount_error').html('{{ trans('exchange.balance_error_msg') }}');
                } else {
                    $('#market_amount').removeClass('text-danger');
                    $('#market_amount').addClass('text-light');
                    $('#market_amount_error').html('');
                }
            } else {
                var price = $('#market_buy_price').val();
                var total = price * amount;

                var balance = $('#' + currencies[1] + '_balance').val();
                percent = (total / balance) * 100;

                $('#market_amount').removeClass('text-danger');
                $('#market_amount').addClass('text-light');
                $('#market_amount_error').html('');

                if (parseFloat(balance) < parseFloat(total)) {
                    $('#market_total').removeClass('text-light');
                    $('#market_total').addClass('text-danger');
                    $('#market_total_error').html('{{ trans('exchange.balance_error_msg') }}');
                } else {
                    $('#market_total').removeClass('text-danger');
                    $('#market_total').addClass('text-light');
                    $('#market_total_error').html('');
                }
            }

            var total = price * amount;
            total = _number_format(total, g_price_decimals);
            $('#market_total').val(total);

            @auth
            var instance = $('#range_slider_market').data("ionRangeSlider");
            instance.update({
                from: percent,
            });
            @endauth
        }

        function getOrderHistory() {
            var token = $("input[name=_token]").val();
            var symbol = $('#symbol_id').val();

            $.ajax({
                url: '{{ route('exchange.order.history') }}',
                type: 'POST',
                data: {_token: token, symbol: symbol},
                dataType: 'JSON',
                success: function (response) {
                    if ( $.fn.DataTable.isDataTable( '#order_history_tbl' ) ) {
                        var order_history_tbl = $('#order_history_tbl').DataTable();
                        order_history_tbl.destroy();
                    }

                    datas = new Array();
                    if (response == undefined || response.length == 0) {
                    } else {
                        for (var i = 0; i < response.length; i++) {

                            if (response[i].status == '{{ config('constants.order_status.pending') }}')
                                var cancel = '<a class="ms-2 text-reset" href="#" onclick="onOrderCancel('+ response[i].order_id +', '+ response[i].order_amount +')" data-bs-toggle="tooltip" data-bs-original-title="Cancel"><i class="icon-x"></i></a>';
                            else
                                var cancel = '';

                            datas.push([
                                response[i].order_id,
                                moment(response[i].ordered_at).utc().format('YYYY-MM-DD HH:mm:ss'),
                                response[i].type1,
                                response[i].symbol,
                                response[i].signal,
                                response[i].order_price,
                                response[i].order_amount,
                                response[i].status_str,
                                response[i].remark,
                                cancel
                            ]);
                        }
                    }

                    $('#order_history_tbl').dataTable({
                        data: datas,
                        searching: false,
                        viewCount: false,
                        bLengthChange: false,
                        order: [[ 1, "desc" ]],
                        columnDefs: [
                            {
                                targets: [5, 6],
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
                                response[i].order_id,
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
                        order: [[ 2, "desc" ]],
                        columnDefs: [
                            {
                                targets: [6, 7, 8],
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

        function onOrder(type2) {
            var token = $("input[name=_token]").val();
            var currency = $('#symbol_id').val();
            var symbol = $('#symbol').html();
            var currencies = symbol.split("/");
            if (type2 == '{{ config('constants.order_type2.limit') }}') {
                var order_price = $('#limit_price').val();
                var order_amount = $('#limit_amount').val();
                var signal = $('#limit_signal').val();

                if (signal == '{{ config('constants.order_type.sell') }}') {
                    var balance = $('#' + currencies[0] + '_balance').val();
                    if (parseFloat(balance) < parseFloat(order_amount)) {
                        toastr.error("{{ trans('exchange.balance_error_msg') }}");
                        return;
                    }
                } else if(signal == '{{ config('constants.order_type.buy') }}') {
                    var balance = $('#' + currencies[1] + '_balance').val();
                    if (parseFloat(balance) < parseFloat(order_amount * order_price)) {
                        toastr.error("{{ trans('exchange.balance_error_msg') }}");
                        return;
                    }
                }
            } else if(type2 == '{{ config('constants.order_type2.market') }}') {
                var order_amount = $('#market_amount').val();
                var signal = $('#market_signal').val();
                var balance = $('#' + currencies[0] + '_balance').val();

                if (signal == '{{ config('constants.order_type.sell') }}') {
                    var order_price = $('#market_sell_price').val();
                    var balance = $('#' + currencies[0] + '_balance').val();
                    if (parseFloat(balance) < parseFloat(order_amount)) {
                        toastr.error("{{ trans('exchange.balance_error_msg') }}");
                        return;
                    }
                } else if(signal == '{{ config('constants.order_type.buy') }}') {
                    var order_price = $('#market_buy_price').val();
                    var balance = $('#' + currencies[1] + '_balance').val();
                    if (parseFloat(balance) < parseFloat(order_amount * order_price)) {
                        toastr.error("{{ trans('exchange.balance_error_msg') }}");
                        return;
                    }
                }
            }

            var type1 = '{{ config('constants.trade_type.exchange') }}'

            $.ajax({
                url: '{{ route('exchange.order') }}',
                type: 'POST',
                data: {_token: token, currency: currency, order_price: order_price, order_amount: order_amount, signal: signal, type1: type1, type2:type2},
                dataType: 'JSON',
                success: function (response) {
                    if (response == undefined || response.status == 0) {
                        toastr.error("{{ trans('exchange.order_failed_msg') }}");
                        if (response.errors != undefined && type2 == '{{ config('constants.order_type2.limit') }}') {
                            if (response.errors.order_price != undefined)
                                $('#limit_price_error').html(response.errors.order_price[0]);
                            if (response.errors.order_amount != undefined)
                                $('#limit_amount_error').html(response.errors.order_amount[0]);
                        } else if(response.errors !== undefined && type2 == '{{ config('constants.order_type2.market') }}') {
                            if (response.errors.order_amount != undefined)
                                $('#market_amount_error').html(response.errors.order_amount[0]);
                        }
                    } else {
                        toastr.success("{{ trans('exchange.order_success_msg') }}");
                        getOrderHistory();
                        getTradeHistory();
                        getBalance();
                    }
                }
            });
        }

        function onOrderCancel(order_id, amount) {
            var token = $("input[name=_token]").val();

            $.ajax({
                url: '{{ route('exchange.order.cancel') }}',
                type: 'POST',
                data: {_token: token, order_id: order_id, amount: amount},
                dataType: 'JSON',
                success: function (response) {
                    if (response == undefined || response.status == 0) {
                        toastr.error("{{ trans('exchange.cancel_failed_msg') }}");
                    } else {
                        toastr.success("{{ trans('exchange.cancel_success_msg') }}");
                        getOrderHistory();
                        getBalance();
                    }
                }
            });
        }

        var socket = io('https://backoffice.adam-bit.net', {path: '/ctex_1.0.0'});

        socket.on('Ctex:Response:Login', function(data) {
            console.log('Connect BackOfficeServer has succeeded!', data);
        });

        socket.on('Ctex:Response:OrderBook', function(data) {
            var _data = JSON.parse(data);

            var sell_order = _data.DETAIL.sell;
            var buy_order = _data.DETAIL.buy;

            var sell_order_cnt = sell_order.length;
            var buy_order_cnt = buy_order.length;

            if (sell_order_cnt > 0) {
                $('#market_buy_price').val(sell_order[sell_order_cnt - 1].price);
            } else {
                $('#market_buy_price').val(0);
            }

            if (buy_order_cnt > 0) {
                $('#market_sell_price').val(buy_order[buy_order_cnt - 1].price);
            } else {
                $('#market_sell_price').val(0);
            }

            var sell_space_cnt = 0;
            if (sell_order_cnt > '{{ config('constants.order_book_count') }}')
                sell_order_cnt = '{{ config('constants.order_book_count') }}';
            else
                sell_space_cnt = '{{ config('constants.order_book_count') }}' - sell_order_cnt;

            var sell_order_list = '';
            var zero = 0;

            for (var i = 0; i < sell_space_cnt; i++) {
                var order_info = '<tr class="text-center">\n' +
                    '                                <td class="p-0 no-border text-muted">'+zero.toFixed(g_price_decimals)+'</td>\n' +
                    '                                <td class="p-0 no-border text-danger-disable">'+zero.toFixed(g_price_decimals)+'</td>\n' +
                    '                                <td class="p-0 no-border"></td>\n' +
                    '                            </tr>';
                sell_order_list = sell_order_list + order_info;
            }

            for (var i = sell_order_cnt - 1; i >= 0; i--) {
                var order_info = '<tr class="text-center">\n' +
                    '                                <td class="p-0 no-border">' + sell_order[i].amount + '</td>\n' +
                    '                                <td class="p-0 no-border text-danger">' + sell_order[i].price + '</td>\n' +
                    '                                <td class="p-0 no-border"></td>\n' +
                    '                            </tr>';
                sell_order_list = sell_order_list + order_info;
            }

            var buy_space_cnt = 0;
            if (buy_order_cnt > '{{ config('constants.order_book_count') }}')
                buy_order_cnt = '{{ config('constants.order_book_count') }}';
            else
                buy_space_cnt = '{{ config('constants.order_book_count') }}' - buy_order_cnt;

            var buy_order_list = '';
            for (var i = 0; i < buy_order_cnt; i++) {
                var order_info = '<tr class="text-center">\n' +
                    '                                <td class="p-0 no-border"></td>\n' +
                    '                                <td class="p-0 no-border text-info">' + buy_order[i].price + '</td>\n' +
                    '                                <td class="p-0 no-border">' + buy_order[i].amount + '</td>\n' +
                    '                            </tr>';
                buy_order_list = buy_order_list + order_info;
            }

            for (var i = 0; i < buy_space_cnt; i++) {
                var order_info = '<tr class="text-center">\n' +
                    '                                <td class="p-0 no-border"></td>\n' +
                    '                                <td class="p-0 no-border text-info-disable">'+zero.toFixed(g_price_decimals)+'</td>\n' +
                    '                                <td class="p-0 no-border text-muted">'+zero.toFixed(g_price_decimals)+'</td>\n' +
                    '                            </tr>';
                buy_order_list = buy_order_list + order_info;
            }

            if (buy_order[0] != undefined) {
                var order_price = '<tr class="text-center font-size-lg">\n' +
                    '                                <td colspan="3" class="p-1 no-border text-info">' + buy_order[0].price + '</td>\n' +
                    '                            </tr>';
                $('#top_price').html(buy_order[0].price);
            } else {
                var order_price = '<tr class="text-center font-size-lg">\n' +
                    '                                <td colspan="3" class="p-1 no-border text-info">'+zero.toFixed(g_price_decimals)+'</td>\n' +
                    '                            </tr>';
                $('#top_price').html(0);
            }

            $('#order_price').html(order_price);

            $('#ask_order_list').html(sell_order_list);
            $('#bid_order_list').html(buy_order_list);
            onCalcMarketAmount();
        });

        function doRequestOrderBook() {
            var symbol = $('#symbol_id').val();;
            socket.emit('Ctex:Request:OrderBook', symbol);
        }

        setInterval(function(){
            doRequestOrderBook();
            @auth
                getBalance();
            @endauth
        }, 1000);

        const g_masterData = '';
        var isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';
        var g_currencyId = "", g_currencyName = "", g_basicCoin = "", g_curCoin = "";
        var g_price_decimals = 0;
        var g_ask_price = 0;
        var g_bid_price = 0;
        var g_intervalOrderBook = null;
        var g_lastPrice = '{{ $lastPrice }}';
        var isAuth = "{{ Auth::check() ? 1 : 0 }}";

        var g_chart, g_interval = '1'; //1min : Resolution
        var history = {};
        var g_rateUrl = "{{ route('rate.interval') }}";

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