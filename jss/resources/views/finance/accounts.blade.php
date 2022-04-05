@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
?>

@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="main-content">
        <style>
            .list-body {
                background-color: #ffffff;
            }
            .list-body:hover {
                background-color: #e0edff;
                cursor: pointer;
            }

            .cost-item-odd {
                background-color: #f5f5f5;
            }

            .cost-item-even:hover {
                background-color: #ffe3e082;
            }

            .cost-item-odd:hover {
                background-color: #ffe3e082;
            }
        </style>
        <div class="page-content">
            <div class="space-4"></div>
            <div class="col-md-12">
                <div class="row">
                    <div class="tabbable">
                        <ul class="nav nav-tabs ship-register" id="memberTab">
                            <li class="active">
                                <a data-toggle="tab" href="#tab_report">
                                    账户汇报
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_analysis" id="analysis">
                                    账户分析
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_setting">
                                    账户设置
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_info">
                                    个体信息
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="tab_report" class="tab-pane active">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>账户汇报</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <select name="select-report-year" id="select-report-year" style="font-size:13px">
                                            @for($i=date("Y");$i>=$start_year;$i--)
                                            <option value="{{$i}}" @if(($year==$i)||(($year=='')&&($i==date("Y")))) selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                        <select name="select-report-month" id="select-report-month" style="font-size:13px;width:60px;">
                                            <option value="0">全部</option>
                                            @if($year==date("Y"))
                                                @for($i=1;$i<=date("m");$i++)
                                                <option value="{{$i}}" @if(($month==$i)||(($month=='')&&($i==date("m")))) selected @endif>{{$i}}月</option>
                                                @endfor
                                            @else
                                                @for($i=1;$i<=12;$i++)
                                                <option value="{{$i}}" @if(($month==$i)||(($month=='')&&($i==date("m")))) selected @endif>{{$i}}月</option>
                                                @endfor
                                            @endif
                                        </select>
                                        <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="account_report_title"></span>账户汇报</strong>
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
                                            <a onclick="javascript:fnExcelAccountReport();" class="btn btn-warning btn-sm excel-btn">
                                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;">
                                    <div id="item-manage-dialog" class="hide"></div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="head-fix-div" id="crew-table" style="height: 600px;">
                                            <table id="table-accounts-report" style="table-layout:fixed;">
                                                <thead class="">
                                                    <th class="text-center style-normal-header" style="width: 10%;height:35px;"><span>账户</span></th>
                                                    <th class="text-center style-normal-header" style="width: 9%;"><span>最后日期</span></th>
                                                    <th class="text-center style-normal-header" style="width: 6%;"><span>币类</span></th>
                                                    <th class="text-center style-normal-header" style="width: 25%;"><span>借方</span></th>
                                                    <th class="text-center style-normal-header" style="width: 25%;"><span>贷方</span></th>
                                                    <th class="text-center style-normal-header" style="width: 25%;"><span>余额</span></th>
                                                </thead>
                                                <tbody class="" id="table-accounts-report-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab_analysis" class="tab-pane">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>账户分析</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <select name="select-analysis-year" id="select-analysis-year" style="font-size:13px">
                                            @for($i=date("Y");$i>=$start_year;$i--)
                                            <option value="{{$i}}" @if(($year==$i)||(($year=='')&&($i==date("Y")))) selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                        <select name="select-analysis-month" id="select-analysis-month" style="font-size:13px;width:60px;">
                                            <option value="0">全部</option>
                                            @if($year==date("Y"))
                                                @for($i=1;$i<=date("m");$i++)
                                                <option value="{{$i}}" @if(($month==$i)||(($month=='')&&($i==date("m")))) selected @endif>{{$i}}月</option>
                                                @endfor
                                            @else
                                                @for($i=1;$i<=12;$i++)
                                                <option value="{{$i}}" @if(($month==$i)||(($month=='')&&($i==date("m")))) selected @endif>{{$i}}月</option>
                                                @endfor
                                            @endif
                                        </select>
                                        <select class="" name="account_type" id="account_type">
                                        @if(isset($accounts) && count($accounts) > 0)
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->account_type }}">{{ $account->account_name }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                        <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="account_analysis_title"></span>账户分析</strong>
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
                                            <a onclick="javascript:fnExcelAnalysisReport();" class="btn btn-warning btn-sm excel-btn">
                                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;">
                                    <div id="item-manage-dialog" class="hide"></div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="head-fix-div" id="crew-table" style="height: 600px;">
                                            <table id="table-accounts-analysis" style="table-layout:fixed;">
                                                <thead class="">
                                                    <th class="text-center style-normal-header" style="width: 4%;height:35px;"><span>对象</span></th>
                                                    <th class="text-center style-normal-header" style="width: 6%;"><span>记账编号</span></th>
                                                    <th class="text-center style-normal-header" style="width: 7%;"><span>日期</span></th>
                                                    <th class="text-left style-normal-header" style="width: 50%;"><span>摘要</span></th>
                                                    <th class="text-center style-normal-header" style="width: 3%;"><span>币类</span></th>
                                                    <th class="text-center style-normal-header" style="width: 10%;"><span>借方</span></th>
                                                    <th class="text-center style-normal-header" style="width: 10%;"><span>贷方</span></th>
                                                    <th class="text-center style-normal-header" style="width: 10%;"><span>收支方式</span></th>
                                                </thead>
                                                <tbody class="" id="accounts-analysis-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tab_setting" class="tab-pane">
                        <form id="form_setting" action="accounts/setting/save" role="form" method="POST" enctype="multipart/form-data">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>账户设置</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
                                            <a onclick="javascript:addSetting();" class="btn btn-sm btn-primary btn-add" style="width: 80px" data-toggle="modal">
                                                <i class="icon-plus"></i>{{ trans('common.label.add') }}
                                            </a>
                                            <a id="btnSaveSetting" class="btn btn-sm btn-success" style="width: 80px">
                                                <i class="icon-save"></i>{{ trans('common.label.save') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;">
                                    <div id="item-manage-dialog" class="hide"></div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="head-fix-div" id="crew-table" style="height: 600px;">
                                            <table id="table-accounts-setting" style="table-layout:fixed;">
                                                <thead class="">
                                                    <th class="text-center style-normal-header" style="width: 5%;height:35px;"><span>No</span></th>
                                                    <th class="text-center style-normal-header" style="width: 15%;"><span>账户</span></th>
                                                    <th class="text-center style-normal-header" style="width: 60%;"><span>账户信息</span></th>
                                                    <th class="text-center style-normal-header" style="width: 16%;"><span>备注</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"></th>
                                                </thead>
                                                <tbody class="" id="table-accounts-setting-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                        <div id="tab_info" class="tab-pane">
                        <form id="form_info" action="accounts/info/save" role="form" method="POST" enctype="multipart/form-data">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>个体信息</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
                                            <a onclick="javascript:addPersonalInfo();" class="btn btn-sm btn-primary btn-add" style="width: 80px" data-toggle="modal">
                                                <i class="icon-plus"></i>{{ trans('common.label.add') }}
                                            </a>
                                            <a id="btnSavePersonalInfo" class="btn btn-sm btn-success" style="width: 80px">
                                                <i class="icon-save"></i>{{ trans('common.label.save') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;">
                                    <div id="item-manage-dialog" class="hide"></div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="head-fix-div" id="crew-table" style="height: 600px;">
                                            <table id="table-personal-info" style="table-layout:fixed;">
                                                <thead class="">
                                                    <th class="text-center style-normal-header" style="width: 5%;height:35px;"><span>No</span></th>
                                                    <th class="text-center style-normal-header" style="width: 15%;"><span>个体</span></th>
                                                    <th class="text-center style-normal-header" style="width: 60%;"><span>个体信息</span></th>
                                                    <th class="text-center style-normal-header" style="width: 16%;"><span>备注</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"></th>
                                                </thead>
                                                <tbody class="" id="table-personal-info-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <audio controls="controls" class="d-none" id="warning-audio">
            <source src="{{ cAsset('assets/sound/delete.wav') }}">
            <embed src="{{ cAsset('assets/sound/delete.wav') }}" type="audio/wav">
        </audio>
    </div>

    <script src="{{ asset('/assets/js/x-editable/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/ace-editable.min.js') }}"></script>
    <script src="{{ cAsset('assets/js/jsquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/js/dataTables.rowsGroup.js') }}"></script>
    
    <?php
	echo '<script>';
    echo 'var start_year = ' . $start_year . ';';
    echo 'var start_month = ' . $start_month . ';';
    echo 'var now_year = ' . date("Y") . ';';
    echo 'var now_month = ' . date("m") . ';';
    echo 'var book_no = ' . $book_no . ';';
    echo 'var book_no_start = ' . $book_no . ';';
    echo 'var ReportTypeData = ' . json_encode(g_enum('ReportTypeData')) . ';';
	echo 'var ReportStatusData = ' . json_encode(g_enum('ReportStatusData')) . ';';
    echo 'var CurrencyLabel = ' . json_encode(g_enum('CurrencyLabel')) . ';';
    echo 'var FeeTypeData = ' . json_encode(g_enum('FeeTypeData')) . ';';
    echo 'var PayTypeData = ' . json_encode(g_enum('PayTypeData')) . ';';
	echo '</script>';
	?>

    <script>
        var token = '{!! csrf_token() !!}';

        // Account Report
        var year_report = '';
        var month_report = '';
        var year_analysis = '';
        var analysis_account = 0;
        var month_analysis = '';
        var listReportTable = null;
        var report_credit_sum_R = 0;
        var report_debit_sum_R = 0;
        var report_balance_sum_R = 0;
        var report_credit_sum_D = 0;
        var report_debit_sum_D = 0;
        var report_balance_sum_D = 0;
        function initReportTable() {
            listReportTable = $('#table-accounts-report').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/finance/accounts/report/list',
                    type: 'POST',
                    data: {'year':year_report, 'month':month_report},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'account_name', className: "text-center"},
                    {data: 'update_date', className: "text-center"},
                    {data: 'currency', className: "text-center"},
                    {data: 'credit', className: "text-center"},
                    {data: 'debit', className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    if ((index%2) == 0)
                        $(row).attr('class', 'backup-member-item cost-item-even');
                    else
                        $(row).attr('class', 'backup-member-item cost-item-odd');

                    $('td', row).eq(0).append('<input type="hidden" value="' + data['account_type'] + '">');
                    $('td', row).eq(0).attr('style', 'cursor:pointer;background:linear-gradient(#fff, #d9f8fb);');
                    $('td', row).eq(0).attr('class', 'select-account');

                    $('td', row).eq(3).attr('style', 'padding: 5px!important');
                    $('td', row).eq(4).attr('style', 'padding: 5px!important');
                    $('td', row).eq(5).attr('style', 'padding: 5px!important');

                    $('td', row).eq(2).attr('style',data['currency'] == 0?'color:red':'color:#026fcd!important')
                    $('td', row).eq(2).html('').append(data['currency'] == 0?'¥':'$');
                    if (data['credit'] >= 0) {
                        $('td', row).eq(3).attr('class', 'text-right style-blue-input');
                    }
                    else {
                        $('td', row).eq(3).attr('class', 'text-right style-red-input');
                    }
                    if (data['credit'] == 0) $('td', row).eq(3).html('');
                    else $('td', row).eq(3).html(data['credit']==null?'':prettyValue(data['credit']));

                    if (data['debit'] >= 0) {
                        $('td', row).eq(4).attr('class', 'text-right');
                    }
                    else {
                        $('td', row).eq(4).attr('class', 'text-right style-red-input');
                    }
                    $('td', row).eq(4).html(data['debit']==null?'':prettyValue(data['debit']));

                    var balance = data['credit'] - data['debit'];
                    if (balance >= 0) {
                        $('td', row).eq(5).attr('class', 'text-right');
                    }
                    else {
                        $('td', row).eq(5).attr('class', 'text-right style-red-input');
                    }
                    $('td', row).eq(5).html(balance==null?'':prettyValue(balance));

                    if (data['currency'] == 0) {
                        report_credit_sum_R += data['credit'];
                        report_debit_sum_R += data['debit'];
                        report_balance_sum_R += balance;
                    }
                    else
                    {
                        report_credit_sum_D += data['credit'];
                        report_debit_sum_D += data['debit'];
                        report_balance_sum_D += balance;
                    }
                },
                drawCallback: function (response) {
                    setEvents();
                    if (response.json.data.length == 0) {
                        //$('#table-accounts-report-body').html('');
                        report_credit_sum_R = 0;
                        report_debit_sum_R = 0;
                        report_balance_sum_R = 0;
                        report_credit_sum_D = 0;
                        report_debit_sum_D = 0;
                        report_balance_sum_D = 0;
                    }
                    var report_row = '<tr class="tr-report" style="height:20px;border:1px solid black;">';
                    report_row += '<td class="sub-small-header style-normal-header text-center" colspan="2">总计 (RMB)</td><td class="sub-small-header style-normal-header"></td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (report_credit_sum_R >= 0 ? 'style-blue-input':'style-red-input') + '">¥ ' + prettyValue(report_credit_sum_R) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (report_debit_sum_R >= 0 ? 'style-black-input':'style-red-input') + '">¥ ' + prettyValue(report_debit_sum_R) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (report_balance_sum_R >= 0 ? 'style-black-input':'style-red-input') + '">¥ ' + prettyValue(report_balance_sum_R) + '</td>';
                    report_row += '</tr>';

                    report_row += '<tr class="tr-report" style="height:20px;border:1px solid black;">';
                    report_row += '<td class="sub-small-header style-normal-header text-center" colspan="2">总计 (USD)</td><td class="sub-small-header style-normal-header"></td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (report_credit_sum_D >= 0 ? 'style-blue-input':'style-red-input') + '">$ ' + prettyValue(report_credit_sum_D) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (report_debit_sum_D >= 0 ? 'style-black-input':'style-red-input') + '">$ ' + prettyValue(report_debit_sum_D) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (report_balance_sum_D >= 0 ? 'style-black-input':'style-red-input') + '">$ ' + prettyValue(report_balance_sum_D) + '</td>';
                    report_row += '</tr>';

                    $('#table-accounts-report-body').append(report_row);
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        year_report = $("#select-report-year option:selected").val();
        month_report = $("#select-report-month option:selected").val();
        if (month_report == 0)
            $('#account_report_title').html(year_report + '年' + '全部');
        else
            $('#account_report_title').html(year_report + '年' + month_report + '月份');
        
        initReportTable();
        function prettyValue(value)
        {
            if(value == undefined || value == null) return '';
            return parseFloat(value).toFixed(2).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
        }
        $('#select-report-year').on('change', function() {
            changeYear(0);
        });
        $('#select-analysis-year').on('change', function() {
            changeYear(1);
        });
        $('#select-report-month').on('change', function() {
            changeMonth(0);
        });
        $('#select-analysis-month').on('change', function() {
            changeMonth(1);
        });
        function changeMonth(type) {
            if (type == 0)
            {
                month_report = $("#select-report-month option:selected").val();
                selectReportInfo();
            }
            else {
                month_analysis = $("#select-analysis-month option:selected").val();
                selectAnalysisInfo();
            }
        }
        function changeYear(type) {
            if (type == 0)
            {
                year_report = $("#select-report-year option:selected").val();
                check_year = year_report;
            }
            else {
                year_analysis = $("#select-analysis-year option:selected").val();
                check_year = year_analysis;
            }
            
            var months = "";
            months += '<option value="0">全部</option>';
            if (check_year == now_year) {
                for(var i=1;i<=now_month;i++)
                {
                    months += '<option value="' + i + '" ' + ((now_month==i)?'selected>':'>') +  i + '月</option>';
                }
            }
            else if (check_year == start_year) {
                for(var i=start_month;i<=12;i++)
                {
                    months += '<option value="' + i + '" ' + ((start_year==now_year && now_month==i)?'selected>':'>') +  i + '月</option>';
                }
            }
            else
            {
                for(var i=1;i<=12;i++) {
                    months += '<option value="' + i + '" >' + i + '月</option>';
                }
            }
            if (type == 0) {
                $('#select-report-month').html(months);
                selectReportInfo();
            }
            else {
                $('#select-analysis-month').html(months);
                selectAnalysisInfo();
            }
        }
        function selectReportInfo()
        {
            year_report = $("#select-report-year option:selected").val();
            month_report = $("#select-report-month option:selected").val();
            if (month_report == 0)
                $('#account_report_title').html(year_report + '年' + '全部');
            else
                $('#account_report_title').html(year_report + '年' + month_report + '月份');

            if (listReportTable == null) {
                initTable();
            }
            else
            {
                report_credit_sum_R = 0;
                report_debit_sum_R = 0;
                report_balance_sum_R = 0;
                report_credit_sum_D = 0;
                report_debit_sum_D = 0;
                report_balance_sum_D = 0;
                listReportTable.column(1).search(year_report, false, false);
                listReportTable.column(2).search(month_report, false, false).draw();
            }
        }
        function selectAnalysisInfo()
        {
            year_analysis = $("#select-analysis-year option:selected").val();
            month_analysis = $("#select-analysis-month option:selected").val();
            analysis_account = $("#account_type").val();
            if (month_analysis == 0)
                $('#account_analysis_title').html(year_analysis + '年' + '全部');
            else
                $('#account_analysis_title').html(year_analysis + '年' + month_analysis + '月份');

            if (listAnalysisTable == null) {
                initAnalysisTable();
            }
            else
            {
                sum_credit_R = 0;
                sum_debit_R = 0;
                sum_credit_D = 0;
                sum_debit_D = 0;

                listAnalysisTable.column(1).search(year_analysis, false, false);
                listAnalysisTable.column(2).search(month_analysis, false, false);
                listAnalysisTable.column(3).search(analysis_account, false, false).draw();
            }
        }

        // Account Analysis
        var listAnalysisTable = null;
        var sum_credit_R = 0;
        var sum_debit_R = 0;
        var sum_credit_D = 0;
        var sum_debit_D = 0;
        function initAnalysisTable() {
            listAnalysisTable = $('#table-accounts-analysis').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/finance/accounts/analysis/list',
                    type: 'POST',
                    data: {'year':year_analysis, 'month':month_analysis, 'account':analysis_account},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'ship_name', className: "text-center"},
                    {data: 'book_no', className: "text-center"},
                    {data: 'datetime', className: "text-center"},
                    {data: 'content', className: "text-center"},
                    {data: 'currency', className: "text-center"},
                    {data: 'credit', className: "text-center"},
                    {data: 'debit', className: "text-center"},
                    {data: 'pay_type', className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();
                    if ((index%2) == 0)
                        $(row).attr('class', 'backup-member-item cost-item-even');
                    else
                        $(row).attr('class', 'backup-member-item cost-item-odd');

                    $('td', row).eq(0).attr('class', 'text-center');
                    $('td', row).eq(1).attr('style', 'height:20px;');
                    $('td', row).eq(1).attr('class', 'text-center');
                    $('td', row).eq(2).attr('class', 'text-center');
                    $('td', row).eq(3).attr('class', 'text-left');
                    $('td', row).eq(3).attr('style', 'padding-left:2px!important;');
                    $('td', row).eq(4).attr('class', 'text-center');
                    $('td', row).eq(5).attr('class', 'text-center');
                    $('td', row).eq(6).attr('class', 'text-center');
                    $('td', row).eq(7).attr('class', 'text-center');

                    
                    $('td', row).eq(1).html('').append("J-" + data['book_no']);
                    if (data['currency']== 0)
                    {
                        $('td', row).eq(4).attr('style','color:red');
                        $('td', row).eq(4).html('').append('¥');
                        sum_credit_R += data['credit'];
                        sum_debit_R += data['debit'];
                    }
                    else
                    {
                        $('td', row).eq(4).attr('style','color:#026fcd!important');
                        $('td', row).eq(4).html('').append('$');
                        sum_credit_D += data['credit'];
                        sum_debit_D += data['debit'];
                    }
                    if (data['credit'] > 0)
                        $('td', row).eq(5).html('<input type="text" class="form-control style-noncolor-input style-blue-input" readonly value="' + (data['credit']==null?'':prettyValue(data['credit'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                    else if (data['credit'] < 0)
                        $('td', row).eq(5).html('<input type="text" class="form-control style-noncolor-input style-red-input" readonly value="' + (data['credit']==null?'':prettyValue(data['credit'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                    else
                        $('td', row).eq(5).html('<input type="text" class="form-control style-noncolor-input style-gray-input" readonly value="" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');

                    if (data['debit'] > 0)
                        $('td', row).eq(6).html('<input type="text" class="form-control style-noncolor-input" readonly value="' + (data['debit']==null?'':prettyValue(data['debit'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                    else if (data['debit'] < 0)
                        $('td', row).eq(6).html('<input type="text" class="form-control style-noncolor-input style-red-input" readonly value="' + (data['debit']==null?'':prettyValue(data['debit'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                    else
                        $('td', row).eq(6).html('<input type="text" class="form-control style-noncolor-input style-gray-input" readonly value="" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                    
                    $('td', row).eq(7).html('').append(PayTypeData[data['pay_type']]);
                },
                drawCallback: function (response) {
                    if (response.json.data.length == 0) {
                        sum_credit_R = 0;
                        sum_debit_R = 0;
                        sum_credit_D = 0;
                        sum_debit_D = 0;
                    }
                    var report_row = '<tr class="tr-report" style="height:20px;border:1px solid black;">';
                    report_row += '<td class="sub-small-header"></td><td class="sub-small-header"></td><td class="sub-small-header style-normal-header"></td><td class="sub-small-header style-normal-header text-center">合计 (RMB)</td><td class="sub-small-header style-normal-header"></td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (sum_credit_R >= 0 ? 'style-blue-input':'style-red-input') + '">¥ ' + prettyValue(sum_credit_R) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (sum_debit_R >= 0 ? '':'style-red-input') + '">¥ ' + prettyValue(sum_debit_R) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + ((sum_credit_R - sum_debit_R) >= 0 ? '':'style-red-input') + '">¥ ' + prettyValue(sum_credit_R - sum_debit_R) + '</td>';
                    report_row += '</tr>';
                    report_row += '<tr class="tr-report" style="height:20px;border:1px solid black;">';
                    report_row += '<td class="sub-small-header"></td><td class="sub-small-header"></td><td class="sub-small-header style-normal-header"></td><td class="sub-small-header style-normal-header text-center">合计 (USD)</td><td class="sub-small-header style-normal-header"></td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (sum_credit_D >= 0 ? 'style-blue-input':'style-red-input') + '">$ ' + prettyValue(sum_credit_D) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + (sum_debit_D >= 0 ? '':'style-red-input') + '">$ ' + prettyValue(sum_debit_D) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right ' + ((sum_credit_D - sum_debit_D) >= 0 ? '':'style-red-input') + '">$ ' + prettyValue(sum_credit_D - sum_debit_D) + '</td>';

                    report_row += '</tr>';
                    $('#accounts-analysis-body').append(report_row);
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        year_analysis = $("#select-analysis-year option:selected").val();
        month_analysis = $("#select-analysis-month option:selected").val();
        analysis_account = $("#account_type").val();

        $('#account_type').on('change', function() {
            selectAnalysisInfo();
        });

        if (month_analysis == 0)
            $('#account_analysis_title').html(year_analysis + '年' + '全部');
        else
            $('#account_analysis_title').html(year_analysis + '年' + month_analysis + '月份');

        initAnalysisTable();
        
        function setEvents() {
            $('.select-account').on('click', function(e) {
                var val = e.target.childNodes[1].value;
                $('#select-analysis-year').val(year_report);
                $('#select-analysis-year').trigger('change');
                $('#select-analysis-month').val(month_report);
                $('#account_type').val(val);
                $('#account_type').trigger('change');
                $('#analysis').click();
            })
        }


        // Personal Information
        var list_info = null;
        var orig_form_info = "";
        function initInfoTable() {
            listTable = $('#table-personal-info').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/finance/accounts/info/list',
                    type: 'POST',
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: null, className: "text-center"},
                    {data: 'person', className: "text-center"},
                    {data: 'info', className: "text-center"},
                    {data: 'remark', className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();
                    
                    $('td', row).eq(0).html('').append(index + 1);
                    $('td', row).eq(0).attr('style', 'height:20px;')
                    $('td', row).eq(0).append('<input type="hidden" name="info_id[]" value="' + data['id'] + '">');
                    $('td', row).eq(1).html('<input type="text" class="form-control style-noncolor-input" name="info_name[]" value="' + __parseStr(data['person']) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(2).html('<input type="text" class="form-control style-noncolor-input" name="info_content[]" value="' + __parseStr(data['info']) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(3).html('<input type="text" class="form-control style-noncolor-input" name="info_remark[]" value="' + __parseStr(data['remark']) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(4).html('').append('<div class="action-buttons"><a class="red" onclick="javascript:deletePersonalInfo(this)"><i class="icon-trash"></i></a></div>');
                },
                drawCallback: function (response) {
                    if (response.json.data.length == 0) {
                        $('#table-personal-info-body').html('');
                    }
                    orig_form_info = $('#form_info').serialize();
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        initInfoTable();
        function addPersonalInfo() {
            var count = $('#table-personal-info-body').children().length + 1;
            var row_html = '<tr>';
            row_html += '<td style="height:20px;">' + count + '<input type="hidden" name="info_id[]" value="0"></td>';
            row_html += '<td><input type="text" class="form-control" name="info_name[]" value="" style="width: 100%;text-align: center" autocomplete="off"></td>';
            row_html += '<td><input type="text" class="form-control" name="info_content[]" value="" style="width: 100%;text-align: center" autocomplete="off"></td>';
            row_html += '<td><input type="text" class="form-control" name="info_remark[]" value="" style="width: 100%;text-align: center" autocomplete="off"></td>';
            row_html += '<td><div class="action-buttons text-center"><a class="red" onclick="javascript:deletePersonalInfo(this)"><i class="icon-trash"></i></a></div></td>';
            row_html += "</tr>"
            $('#table-personal-info-body').append(row_html)
        }
        function deletePersonalInfo(e) {
            alertAudio();
            bootbox.confirm("Are you sure you want to delete?", function (result) {
                if (result) {
                    $(e).closest("tr").remove();
                }
            });
        }
        var submitted_info = false;
        $('#btnSavePersonalInfo').on('click', function() {
            submitted_info = true;
            $('#form_info').submit();
        })

        // Account Settings
        var list_info = null;
        var orig_form_info = "";
        function initSettingTable() {
            listTable = $('#table-accounts-setting').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/finance/accounts/setting/list',
                    type: 'POST',
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: null, className: "text-center"},
                    {data: 'account', className: "text-center"},
                    {data: 'info', className: "text-center"},
                    {data: 'remark', className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();
                    $('td', row).eq(0).html('').append(index + 1);
                    $('td', row).eq(0).attr('style', 'height:20px;')
                    $('td', row).eq(0).append('<input type="hidden" name="setting_id[]" value="' + data['id'] + '">');
                    $('td', row).eq(1).html('<input type="text" class="form-control" name="setting_name[]" value="' + __parseStr(data['account']) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(2).html('<input type="text" class="form-control" name="setting_content[]" value="' + __parseStr(data['info']) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(3).html('<input type="text" class="form-control" name="setting_remark[]" value="' + __parseStr(data['remark']) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(4).html('').append('<div class="action-buttons"><a class="red" onclick="javascript:deleteSetting(this)"><i class="icon-trash"></i></a></div>');
                },
                drawCallback: function (response) {
                    if (response.json.data.length == 0) {
                        $('#table-accounts-setting-body').html('');
                    }
                    orig_form_setting = $('#form_setting').serialize();
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        initSettingTable();
        function addSetting() {
            var count = $('#table-accounts-setting-body').children().length + 1;
            var row_html = '<tr>';
            row_html += '<td style="height:20px;">' + count + '<input type="hidden" name="setting_id[]" value="0"></td>';
            row_html += '<td><input type="text" class="form-control" name="setting_name[]" value="" style="width: 100%;text-align: center" autocomplete="off"></td>';
            row_html += '<td><input type="text" class="form-control" name="setting_content[]" value="" style="width: 100%;text-align: center" autocomplete="off"></td>';
            row_html += '<td><input type="text" class="form-control" name="setting_remark[]" value="" style="width: 100%;text-align: center" autocomplete="off"></td>';
            row_html += '<td><div class="action-buttons text-center"><a class="red" onclick="javascript:deleteSetting(this)"><i class="icon-trash"></i></a></div></td>';
            row_html += "</tr>"
            $('#table-accounts-setting-body').append(row_html)
        }
        function deleteSetting(e) {
            alertAudio();
            bootbox.confirm("Are you sure you want to delete?", function (result) {
                if (result) {
                    var account = parseInt($(e).closest("tr").children().eq(0).children().eq(0).val());
                    $.ajax({
                        url: BASE_URL + 'ajax/check/account',
                        type: 'post',
                        data: {
                            account: account,
                        },
                        success: function(data, status, xhr) {
                            if (data == true) {
                                $(e).closest("tr").remove();
                            } else {
                                alert("It cannot be deleted because the related data remains!")
                            }
                        },
                        error: function(error, status) {
                            //alert("Failed!");
                        }
                    })
                }
            });
        }
        var submitted_setting = false;
        $('#btnSaveSetting').on('click', function() {
            submitted_setting = true;
            $('#form_setting').submit();
        })
        
        function alertAudio() {
            document.getElementById('warning-audio').play();
        }
        $('body').on('keydown', 'input', function(e) {
            if (e.key === "Enter") {
                var self = $(this), form, focusable, next;
                if(ACTIVE_TAB == '#tab_report') {
                    form = $('#form_report');
                }
                else if(ACTIVE_TAB == '#tab_analysis') {
                    form = $('#form_analysis');
                }
                else if(ACTIVE_TAB == '#tab_setting') {
                    form = $('#form_setting');
                }
                else if(ACTIVE_TAB == '#tab_info') {
                    form = $('#form_info');
                }
                else {
                    return;
                }
                focusable = form.find('input').filter(':visible');
                next = focusable.eq(focusable.index(this)+1);
                if (next.length) {
                    next.focus();
                }
                return false;
            }
        });

        var ACTIVE_TAB = "tab_report";
        $(function () {
            $('ul li a[data-toggle=tab]').click(function(){
                $nowTab = $(this).attr("href");
                ACTIVE_TAB = $nowTab;
                window.localStorage.setItem("accountsTab",$nowTab);
            });

            $initTab = window.localStorage.getItem("accountsTab");
            if ($initTab != null) {
                $('ul li a[data-toggle=tab]').each(function(){
                    $href = $(this).attr("href");
                    $(this).parent("li").prop("class","");
                    $($href).prop("class", "tab-pane");
                    if($initTab == $href) {
                        $($initTab).prop("class", "tab-pane active");
                        $(this).parent("li").prop("class","active");
                    }
                });
                ACTIVE_TAB = $initTab;
            }
        });

        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';

            var origForm = "";
            var form;
            var submitted;
            if(ACTIVE_TAB == '#tab_report') {
                return;
                form = $('#form_report');
                origForm = orig_form_report;
                submitted = submitted_report;
            }
            else if(ACTIVE_TAB == '#tab_analysis') {
                return;
                form = $('#form_analysis');
                origForm = orig_form_analysis;
                submitted = submitted_analysis;
            }
            else if(ACTIVE_TAB == '#tab_setting') {
                form = $('#form_setting');
                origForm = orig_form_setting;
                submitted = submitted_setting;
            }
            else if(ACTIVE_TAB == '#tab_info') {
                form = $('#form_info');
                origForm = orig_form_info;
                submitted = submitted_info;
            }
            else {
                return;
            }

            var newForm = form.serialize();
            if ((newForm !== origForm) && !submitted) {
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });

        function fnExcelAccountReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-accounts-report');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='6' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#account_report_title').html() + "账户汇报</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[2].style.width = '60px';
                    tab.rows[j].childNodes[3].style.width = '300px';
                    tab.rows[j].childNodes[4].style.width = '300px';
                    tab.rows[j].childNodes[5].style.width = '300px';
                }
                else if(j >= (tab.rows.length - 2))
                {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.height = "30px";
                        tab.rows[j].childNodes[i].style.fontWeight = "bold";
                        tab.rows[j].childNodes[i].style.backgroundColor = '#ebf1de';
                    }
                }
                
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = year_report + '年_' + (month_report==0?'全部':month_report) + '_账户汇报';
            exportExcel(tab_text, filename, filename);
            //exportExcel(tab_text, filename, year_report + '_' + (month_report==0?'全部':month_report) + '_流水账');
            
            return 0;
        }

        function fnExcelAnalysisReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-accounts-analysis');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='8' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#account_analysis_title').html() + "账户分析</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[4].style.width = '60px';
                    tab.rows[j].childNodes[5].style.width = '300px';
                    tab.rows[j].childNodes[6].style.width = '300px';
                    tab.rows[j].childNodes[7].style.width = '300px';
                }
                else if(j >= (tab.rows.length - 2))
                {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.height = "30px";
                        tab.rows[j].childNodes[i].style.fontWeight = "bold";
                        tab.rows[j].childNodes[i].style.backgroundColor = '#ebf1de';
                    }
                }
                else {
                    for (var i=5;i<7;i++)
                    {
                        var info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                        tab.rows[j].childNodes[i].innerHTML = info;
                    }
                }
                console.log(tab.rows[j].innerHTML);
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = year_analysis + '年_' + (month_analysis==0?'全部':month_analysis) + '(' + $("#account_type option:selected").text() + ')_账户汇报';
            exportExcel(tab_text, filename, $("#account_type option:selected").text());
            
            return 0;
        }

    </script>

@endsection
