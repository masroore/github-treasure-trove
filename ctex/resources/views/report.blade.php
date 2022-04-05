@extends('layouts.dashboard')

@section('title', trans('report.title'))

@section('content')
<div class="container-fluid body-min-height">
    <!-- Page title -->
    <section id="page-title" class="page-title-left text-light background-dark">
        <div class="container-fluid">
            <div class="page-title">
                <h1>{{ trans('report.page_title') }}</h1>
                <span>{{ trans('report.page_title_desc') }}</span>
            </div>
        </div>
    </section>
    <!-- end: Page title -->
    <hr>
    <!-- Content -->
    <section id="page-content" class="background-dark">
        <div class="container-fluid">
            @csrf

            <div class="tabs tabs-vertical">
                <div class="row">
                    <div class="col-md-2 tab-border-right mb-3">
                        <ul class="nav flex-column nav-tabs border-1" id="myTab4" role="tablist" aria-orientation="vertical">
                            <li class="nav-item">
                                <a class="nav-link no-border active" id="trade-tab" data-bs-toggle="tab" href="#trade" role="tab" aria-controls="trade" aria-selected="true"><b>{{ trans('report.trade') }}</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link no-border" id="deposit-tab" data-bs-toggle="tab" href="#deposit" role="tab" aria-controls="deposit" aria-selected="true"><b>{{ trans('report.deposit') }}</b></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link no-border" id="withdraw-tab" data-bs-toggle="tab" href="#withdraw" role="tab" aria-controls="withdraw" aria-selected="true"><b>{{ trans('report.withdraw') }}</b></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content" id="myTabContent4">
                            <div class="tab-pane fade show active" id="trade" role="tabpanel" aria-labelledby="trade-tab">
                                <div class="form-group row">
                                    <div class="col-lg-3 form-group">
                                        <div class="input-group date" id="trade_from_datepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input input-dark-bg text-light" data-target="#trade_from_datepicker" name="trade_from_date" id="trade_from_date" placeholder="{{ trans('common.date_placeholder') }}" />
                                            <div class="input-group-text btn btn-light input-dark-bg text-light" data-target="#trade_from_datepicker" data-toggle="datetimepicker"><i class="icon-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <div class="input-group date" id="trade_to_datepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input input-dark-bg text-light" data-target="#trade_to_datepicker" name="trade_to_date" id="trade_to_date" placeholder="{{ trans('common.date_placeholder') }}" />
                                            <div class="input-group-text btn btn-light input-dark-bg text-light" data-target="#trade_to_datepicker" data-toggle="datetimepicker"><i class="icon-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <select id="trade_type" class="form-select text-light input-dark-bg">
                                            <option value="" selected>{{ trans('report.type_placeholder') }}</option>
                                            <option value="{{ config('constants.trade_type.exchange') }}">{{ trans('common.trade_type.exchange') }}</option>
                                            <option value="{{ config('constants.trade_type.dealer') }}">{{ trans('common.trade_type.dealer') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" class="btn btn-primary" onclick="getTradeHistory()">{{ trans('buttons.search') }}</button>
                                    </div>
                                </div>
                                <div class="overflow-auto px-3">
                                    <table id="trade_history_tbl" class="table table-dark font-size-sm overflow-auto" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th class="background-black-dark">{{ trans('report.trade_id') }}</th>
                                            <th class="background-black-dark">{{ trans('report.type') }}</th>
                                            <th class="background-black-dark">{{ trans('report.symbol') }}</th>
                                            <th class="background-black-dark">{{ trans('report.order_type') }}</th>
                                            <th class="background-black-dark">{{ trans('report.settle_datetime') }}</th>
                                            <th class="background-black-dark">{{ trans('report.settle_price') }}</th>
                                            <th class="background-black-dark">{{ trans('report.settle_amount') }}</th>
                                            <th class="background-black-dark">{{ trans('report.fee') }}</th>
                                            <th class="background-black-dark">{{ trans('report.status') }}</th>
                                            <th class="background-black-dark">{{ trans('report.remark') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="deposit" role="tabpanel" aria-labelledby="deposit-tab">
                                <div class="form-group row">
                                    <div class="col-lg-3 form-group">
                                        <div class="input-group date" id="deposit_from_datepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input input-dark-bg text-light" data-target="#deposit_from_datepicker" name="deposit_from_date" id="deposit_from_date" placeholder="{{ trans('common.date_placeholder') }}" />
                                            <div class="input-group-text btn btn-light input-dark-bg text-light" data-target="#deposit_from_datepicker" data-toggle="datetimepicker"><i class="icon-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <div class="input-group date" id="deposit_to_datepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input input-dark-bg text-light" data-target="#deposit_to_datepicker" name="deposit_to_date" id="deposit_to_date" placeholder="{{ trans('common.date_placeholder') }}" />
                                            <div class="input-group-text btn btn-light input-dark-bg text-light" data-target="#deposit_to_datepicker" data-toggle="datetimepicker"><i class="icon-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" class="btn btn-primary" onclick="getDepositHistory()">{{ trans('buttons.search') }}</button>
                                    </div>
                                </div>
                                <div class="overflow-auto px-3">
                                    <table id="deposit_history_tbl" class="table table-dark font-size-sm" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th class="background-black-dark">{{ trans('report.date_time') }}</th>
                                            <th class="background-black-dark">{{ trans('report.currency') }}</th>
                                            <th class="background-black-dark">{{ trans('report.amount') }}</th>
                                            <th class="background-black-dark">{{ trans('report.deposit_address') }}</th>
                                            <th class="background-black-dark">{{ trans('report.tx_id') }}</th>
                                            <th class="background-black-dark">{{ trans('report.status') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="withdraw-tab">
                                <div class="form-group row">
                                    <div class="col-lg-3 form-group">
                                        <div class="input-group date" id="withdraw_from_datepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input input-dark-bg text-light" data-target="#withdraw_from_datepicker" name="withdraw_from_date" id="withdraw_from_date" placeholder="{{ trans('common.date_placeholder') }}" />
                                            <div class="input-group-text btn btn-light input-dark-bg text-light" data-target="#withdraw_from_datepicker" data-toggle="datetimepicker"><i class="icon-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 form-group">
                                        <div class="input-group date" id="withdraw_to_datepicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input input-dark-bg text-light" data-target="#withdraw_to_datepicker" name="withdraw_to_date" id="withdraw_to_date" placeholder="{{ trans('common.date_placeholder') }}" />
                                            <div class="input-group-text btn btn-light input-dark-bg text-light" data-target="#withdraw_to_datepicker" data-toggle="datetimepicker"><i class="icon-calendar"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button" class="btn btn-primary" onclick="getWithdrawHistory()">{{ trans('buttons.search') }}</button>
                                    </div>
                                </div>
                                <div class="overflow-auto px-3">
                                    <table id="withdraw_history_tbl" class="table table-dark font-size-sm overflow-auto" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th class="background-black-dark">{{ trans('report.date_time') }}</th>
                                            <th class="background-black-dark">{{ trans('report.currency') }}</th>
                                            <th class="background-black-dark">{{ trans('report.amount') }}</th>
                                            <th class="background-black-dark">{{ trans('report.withdraw_address') }}</th>
                                            <th class="background-black-dark">{{ trans('report.tx_id') }}</th>
                                            <th class="background-black-dark">{{ trans('report.status') }}</th>
                                            <th class="background-black-dark">{{ trans('report.remark') }}</th>
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
            </div>
<!--            <div class="form-group col-lg-12">
                <button type="button" class="btn btn-info"><i class="fa fa-download"></i> Trading Report Download</button>
            </div>-->
        </div>
    </section>
</div>
@endsection

@section('script')
<!--Bootstrap Datetimepicker component-->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-datetimepicker/tempusdominus-bootstrap-4.js') }}"></script>

<script>
    jQuery(document).ready(function() {
        $('#trade_from_datepicker').datetimepicker({
            format: 'L'
        });

        $('#trade_to_datepicker').datetimepicker({
            format: 'L'
        });

        $('#deposit_from_datepicker').datetimepicker({
            format: 'L'
        });

        $('#deposit_to_datepicker').datetimepicker({
            format: 'L'
        });

        $('#withdraw_from_datepicker').datetimepicker({
            format: 'L'
        });

        $('#withdraw_to_datepicker').datetimepicker({
            format: 'L'
        });
    });

    $( document ).ready(function() {
        $('#top_report').addClass('text-danger');

        getTradeHistory();
        getDepositHistory();
        getWithdrawHistory();
    });

    function getTradeHistory() {
        var token = $("input[name=_token]").val();
        var from_date = $('#trade_from_date').val();
        var to_date = $('#trade_to_date').val();
        var type = $('#trade_type').val();

        $.ajax({
            url: '{{ route('report.trade.history') }}',
            type: 'POST',
            data: {_token: token, from_date: from_date, to_date: to_date, type: type},
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

                        datas.push([
                            response[i].trade_id,
                            response[i].type,
                            response[i].currency,
                            response[i].signal,
                            moment(response[i].settled_at).utc().format('YYYY-MM-DD HH:mm:ss'),
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

    function getDepositHistory() {
        var token = $("input[name=_token]").val();
        var from_date = $('#deposit_from_date').val();
        var to_date = $('#deposit_to_date').val();

        $.ajax({
            url: '{{ route('report.deposit.history') }}',
            type: 'POST',
            data: {_token: token, from_date: from_date, to_date:to_date},
            dataType: 'JSON',
            success: function (response) {
                if ( $.fn.DataTable.isDataTable( '#deposit_history_tbl' ) ) {
                    var deposit_history_tbl = $('#deposit_history_tbl').DataTable();
                    deposit_history_tbl.destroy();
                }

                datas = new Array();
                if (response == undefined || response.length == 0) {
                } else {
                    for (var i = 0; i < response.length; i++) {

                        datas.push([
                            moment(response[i].updated_at).utc().format('YYYY-MM-DD HH:mm:ss'),
                            response[i].currency,
                            response[i].amount,
                            response[i].wallet_addr,
                            getTxLink(response[i].currency, response[i].tx_id),
                            response[i].status,
                        ]);
                    }
                }

                $('#deposit_history_tbl').dataTable({
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

    function getWithdrawHistory() {
        var token = $("input[name=_token]").val();
        var from_date = $('#withdraw_from_date').val();
        var to_date = $('#withdraw_to_date').val();

        $.ajax({
            url: '{{ route('report.withdraw.history') }}',
            type: 'POST',
            data: {_token: token, from_date: from_date, to_date:to_date},
            dataType: 'JSON',
            success: function (response) {
                if ( $.fn.DataTable.isDataTable( '#withdraw_history_tbl' ) ) {
                    var withdraw_history_tbl = $('#withdraw_history_tbl').DataTable();
                    withdraw_history_tbl.destroy();
                }

                datas = new Array();
                if (response == undefined || response.length == 0) {
                } else {
                    for (var i = 0; i < response.length; i++) {

                        datas.push([
                            moment(response[i].updated_at).utc().format('YYYY-MM-DD HH:mm:ss'),
                            response[i].currency,
                            response[i].amount,
                            response[i].destination,
                            getTxLink(response[i].currency, response[i].tx_id),
                            response[i].status,
                            response[i].remark,
                        ]);
                    }
                }

                $('#withdraw_history_tbl').dataTable({
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

    function getTxLink(currency, tx_id) {
        if (tx_id == undefined || tx_id == '') return tx_id;
        tx_id = (tx_id == null || tx_id == undefined) ? '' : tx_id;
        let txStr = tx_id;
        if (txStr.length >= 15) {
            txStr = txStr.substring(0, 10) + '...' + txStr.substring(txStr.length - 5, txStr.length);
        }

        let url = '';
        if (currency == 'BTC') {
            url = '{{ BTC_CONFIRM_URL }}';
        }
        else if (currency == 'BCH') {
            url = '{{ BCH_CONFIRM_URL }}';
        }
        else if (currency == 'LTC') {
            url = '{{ LTC_CONFIRM_URL }}';
        }
        else if (currency == 'XRP') {
            url = '{{ XRP_CONFIRM_URL }}';
        }
        else if (currency == 'ETH' || currency == 'USDT' || currency == '8CO' || currency == 'WCP' || currency == 'ADAE' || currency == 'JCC') {
            url = '{{ ETH_CONFIRM_URL }}';
        }
        else if (currency == 'BNB' || currency == 'ADAB') {
            url = '{{ BNB_CONFIRM_URL }}';
        }

        return '<a target="_blank" class="btn-flat-info" href="' + url + tx_id + '">' + txStr + '</a>';
    }
</script>
@endsection