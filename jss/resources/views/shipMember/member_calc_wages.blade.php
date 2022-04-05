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
            .cost-item-odd {
            }

            .cost-item-even:hover {
                background-color: #ffe3e082;
            }

            .cost-item-odd:hover {
                background-color: #ffe3e082;
            }

            label {
                word-break: break-all;
            }
        </style>
        <div class="page-content">
        <form id="wage-form" action="updateWageCalcInfo" role="form" method="POST" enctype="multipart/form-data">
            <div class="page-header">
                <div class="col-sm-3">
                    <h4><b>工资计算</b></h4>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="col-md-12" style="margin-top:4px;">
                <div id="calc_wage" class="tab-pane active">
                    <div class="space-4"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-7">
                                <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                                <select class="custom-select d-inline-block" name="select-ship" id="select-ship" style="width:80px">
                                    <!--option value="" selected></option-->
                                    <?php $index = 0 ?>
                                    @foreach($shipList as $ship)
                                        <?php $index ++ ?>
                                        <option value="{{ $ship['IMO_No'] }}" @if(isset($shipId) && ($shipId == $ship['IMO_No'])) selected @endif data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                                    @endforeach
                                </select>
                                <select name="select-year" id="select-year" style="font-size:13px">
                                    @for($i=$start_year;$i<=date("Y");$i++)
                                    <option value="{{$i}}" @if(($year==$i)||(($year=='')&&($i==date("Y")))) selected @endif>{{$i}}年</option>
                                    @endfor
                                </select>
                                <select name="select-month" id="select-month" style="font-size:13px">
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
                                @if ($user_pos == STAFF_LEVEL_CAPTAIN || $user_pos == STAFF_LEVEL_SHAREHOLDER)
                                <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="search_info"></span>份工资单</strong>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:10px;{{$user_pos == STAFF_LEVEL_CAPTAIN || $user_pos == STAFF_LEVEL_SHAREHOLDER ? 'display:none' : ''}}">
                            <div class="col-md-7">
                                <label class="custom-label d-inline-block font-bold" style="padding: 6px;">减少天数:</label>
                                <input type="number" name="minus-days" id="minus-days" value="0.5" step="0.5" min="0" autocomplete="off" style="width:60px;margin-right:0px;"/>
                                <label class="custom-label d-inline-block font-bold" style="padding: 6px;">汇率:</label>
                                <input type="number" name="rate" id="rate" value="6.5" min="0" step="0.1" autocomplete="off" style="width:80px;margin-right:0px;"/>
                                @if ($user_pos != STAFF_LEVEL_CAPTAIN && $user_pos != STAFF_LEVEL_SHAREHOLDER)
                                <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="search_info"></span>份工资单</strong>
                                @endif
                            </div>
                            <div class="col-md-5" style="padding:unset!important;{{$user_pos == STAFF_LEVEL_CAPTAIN || $user_pos == STAFF_LEVEL_SHAREHOLDER ? 'display:none' : ''}}">
                                <div class="btn-group f-right">
                                    <!--a onclick="javascript:openAddPage();" class="btn btn-sm btn-primary btn-add" style="width: 80px" data-toggle="modal">
                                        <i class="icon-plus"></i>{{ trans('common.label.add') }}
                                    </a-->
                                    <a class="btn btn-sm btn-danger refresh-btn-over" type="button" onclick="init()">
                                        <img src="{{ cAsset('assets/images/refresh.png') }}" class="report-label-img">初始化
                                    </a>
                                    <a id="btnSave" class="btn btn-sm btn-success" style="width: 80px">
                                        <i class="icon-save"></i>{{ trans('common.label.save') }}
                                    </a>
                                    <a onclick="javascript:fnExcelReport();" class="btn btn-warning btn-sm excel-btn">
                                        <i class="icon-table"></i>{{ trans('common.label.excel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:4px;">
                            <div id="item-manage-dialog" class="hide"></div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="head-fix-div common-list" id="crew-table" style="">
                                    <table id="table-shipmember-list" style="table-layout:fixed;">
                                        <thead class="">
                                            <th class="text-center style-normal-header" style="width: 3%;"><span>No</span></th>
                                            <th class="text-center style-normal-header" style="width: 5%;"><span>姓名</span></th>
                                            <th class="text-center style-normal-header" style="width: 4%;"><span>职务</span></th>
                                            <th class="text-center style-normal-header" style="width: 4%;"><span>币类</span></th>
                                            <th class="text-center style-normal-header" style="width: 6%;"><span>合约薪资</span></th>
                                            <th class="text-center style-normal-header" style="width: 7%;"><span>上船日期</span></th>
                                            <th class="text-center style-normal-header" style="width: 7%;"><span>下船/截止日期</span></th>
                                            <th class="text-center style-normal-header" style="width: 4%;"><span>在船天数</span></th>
                                            <th class="text-center style-normal-header" style="width: 5%;">扣款<br><span style="color:red">(¥)</span></th>
                                            <th class="text-center style-normal-header" style="width: 7%;">家汇款<br><span style="color:red">(¥)</span></th>
                                            <th class="text-center style-normal-header" style="width: 7%;">家汇款<br><span style="color:#1565C0">($)</span></th>
                                            <th class="text-center style-normal-header" style="width: 7%;"><span>支付日期</span></th>
                                            <th class="text-center style-normal-header" style="width: 10%;"><span>备注</span></th>
                                            <th class="text-center style-normal-header" style="width: 21%;"><span>银行账户</span></th>
                                            <th class="text-center" style=""></th>
                                        </thead>
                                        <tbody class="" id="list-body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div id="modal-add-wage" class="modal" aria-hidden="true" style="display: none; margin-top: 15%;">
        <div class="dynamic-modal-dialog">
            <div class="dynamic-modal-content" style="border: 0;width:400px!important;">
                <div class="dynamic-modal-header" data-target="#modal-step-contents">
                    <div class="table-header">
                        <button type="button"  style="margin-top: 8px; margin-right: 12px;" class="close" data-dismiss="modal" aria-hidden="true">
                            <span class="white">&times;</span>
                        </button>
                        <h4 style="padding-top:10px;font-style:italic;">添加海员</h4>
                    </div>
                </div>
                <div id="modal-body-content" class="modal-body step-content">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table" style="table-layout: fixed">
                                <tbody>
                                <tr>
                                    <td class="custom-modal-td-label" style="width:111px!important;">姓名*:</td>
                                    <td><input type="text" name="decTitle" id="add-name" class="form-control" value="缺员" style="width: 100%" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">职员:</td>
                                    <td>
                                        <select id="add-rank" class="form-control" style="padding-left:unset!important;color:#1565C0!important;">
                                            <option value="" selected>&nbsp;</option>
                                            @foreach($posList as $pos)
                                                <option value="{{$pos['Abb']}}" >{{$pos['Duty_En']}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">币类:</td>
                                    <td>
                                        <select id="add-currency" onchange="javascript:selectCurrency()" class="form-control" style="padding-left:unset!important;color:red!important;">
                                            <option value="2"></option>
                                            <option value="0" style="color:red!important;">¥</option>
                                            <option value="1" style="color:#1565C0!important;">$</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">合约薪资*:</td>
                                    <td><input type="text" id="add-wage" class="form-control" style="width: 100%" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">上船日期*:</td>
                                    <td><div class="input-group"><input id="add-signon-date" class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" autocomplete="off"><span class="input-group-addon"><i class="icon-calendar "></i></span></div></td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">下船/截止日期*:</td>
                                    <td><div class="input-group"><input id="add-signoff-date" class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" autocomplete="off"><span class="input-group-addon"><i class="icon-calendar "></i></span></div></td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">扣款:</td>
                                    <td><input type="text" id="add-minus-money" value="" class="form-control" style="width: 100%" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">支付日期:</td>
                                    <td><div class="input-group"><input id="add-purchase-date" class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" autocomplete="off"><span class="input-group-addon"><i class="icon-calendar "></i></span></div></td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">备注:</td>
                                    <td><textarea type="text" id="add-remark" class="form-control" style="resize:none;" rows="2" autocomplete="off"></textarea></td>
                                </tr>
                                <tr>
                                    <td class="custom-modal-td-label">银行账号:</td>
                                    <td><textarea type="text" id="add-bank-info" class="form-control" style="resize:none;" rows="2" autocomplete="off"></textarea></td>
                                    <input type="hidden" id="add-row-index">
                                </tr>
                                </tbody>
                            </table>
                            <div>
                                <div class="btn-group f-right mt-20 d-flex">
                                    <button type="button" class="btn btn-success small-btn ml-0" onclick="addWage();">
                                        <img src="{{ cAsset('assets/images/send_report.png') }}" class="report-label-img">OK
                                    </button>
                                    <div class="between-1"></div>
                                    <a class="btn btn-danger small-btn close-modal" data-dismiss="modal"><i class="icon-remove"></i>Cancel</a>
                                </div>
                            </div>
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
	echo 'var CurrencyLabel = ' . json_encode(g_enum('CurrencyLabel')) . ';';
    echo 'var start_year = ' . $start_year . ';';
    echo 'var start_month = ' . $start_month . ';';
    echo 'var now_year = ' . date("Y") . ';';
    echo 'var now_month = ' . date("m") . ';';
	echo '</script>';
	?>

    <script>
        var HOLDER = '{!! STAFF_LEVEL_SHAREHOLDER !!}';
        var CAPTAIN = '{!! STAFF_LEVEL_CAPTAIN !!}';
        var POS = '{!! $user_pos !!}';
        var token = '{!! csrf_token() !!}';
        var shipName = '';
        var year = '';
        var month = '';
        var minus_days = 0;
        var rate = 1;
        var shipId;
        var original, info;
        $(function () {
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
            $.fn.editableform.buttons = '';
        });
            
        var listTable = null;
        function initTable() {
            listTable = $('#table-shipmember-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/shipMember/wage/list',
                    type: 'POST',
                    data: { 'year':year, 'month':month, 'minus_days':minus_days, 'rate':rate, 'shipId':shipId},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: null, className: "text-center"},
                    {data: 'name', className: "text-center"},
                    {data: 'rank', className: "text-center"},
                    {data: 'WageCurrency', className: "text-center"},
                    {data: 'Salary', className: "text-center"},
                    {data: 'DateOnboard', className: "text-center"},
                    {data: 'DateOffboard', className: "text-center"},
                    {data: 'SignDays', className: "text-center"},
                    {data: 'MinusCash', className: "text-center"},
                    {data: 'TransInR', className: "text-center"},
                    {data: 'TransInD', className: "text-center"},
                    {data: 'TransDate', className: "text-center"},
                    {data: 'Remark', className: "text-center"},
                    {data: 'BankInformation', className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();
                    //$(row).attr('class', 'wage-item disable-tr');
                    ///*
                    if ((index%2) == 0)
                        $(row).attr('class', 'wage-item cost-item-even');
                    else
                        $(row).attr('class', 'wage-item cost-item-odd');
                    //*/
                        
                    $(row).attr('data-index', data['no']);

                    $('td', row).eq(0).attr('style', 'cursor:crosshair;background:linear-gradient(#fff, #d9f8fb);');
                    
                    $('td', row).eq(0).attr('class', 'text-center disable-td add-no');
                    $('td', row).eq(1).attr('class', 'text-center disable-td');
                    $('td', row).eq(2).attr('class', 'text-center disable-td');

                    /*
                    if (data['WageCurrency'] == 0) {
                        $('td', row).eq(3).html('¥');
                        $('td', row).eq(3).attr('style','color:red');    
                    }
                    else {
                        $('td', row).eq(3).html('$');
                        $('td', row).eq(3).attr('style','color:#026fcd!important');
                    }
                    */

                    $('td', row).eq(3).attr('class', 'text-center disable-td add-currency');
                    $('td', row).eq(4).attr('class', 'text-center add-salary');
                    $('td', row).eq(5).attr('class', 'text-center disable-td');
                    $('td', row).eq(6).attr('class', 'text-center disable-td');
                    $('td', row).eq(7).attr('class', 'text-center disable-td add-signondays');
                    $('td', row).eq(9).attr('class', 'text-center disable-td add-transR');
                    $('td', row).eq(10).attr('class', 'text-center disable-td add-transD');
                    $('td', row).eq(13).attr('class', 'text-center disable-td add-bankinfo');
                    $('td', row).eq(13).attr('style', 'word-wrap:break-word');
                    $('td', row).eq(14).html('').append('<div class="action-buttons"><a class="red" onclick="javascript:deleteItem(this)"><i class="icon-trash"></i></a></div>');

                    $('td', row).eq(0).html('').append('' + (pageInfo.page * pageInfo.length + index + 1)+ '<input type="hidden" name="MemberId[]" value="' + data['no'] + '">');
                    $('td', row).eq(1).html('<label>' + data['name'] + '</label><input type="hidden" name="Names[]" value="' + data['name'] + '">');
                    var rank = data['rank'];
                    if (rank == 'null' || rank == null) rank = '';
                    $('td', row).eq(2).html('<label>' + rank + '</label><input type="hidden" name="Rank[]" value="' + __parseStr(rank) + '">');
                    
                    //$('td', row).eq(3).html('<label>' + ((data['WageCurrency'] == 0)?'¥':'$') + '</label><input type="hidden" name="Currency[]" value="' + data['WageCurrency'] + '">');
                    $('td', row).eq(3).html('<select name="Currency[]" class="form-control" style="color:' + ((data['WageCurrency'] == 0)?'red':'#026fcd') + '"><option value="0" style="color:red!important;"' + ((data['WageCurrency'] == 0)?'selected':'') + '>¥</option><option value="1" style="color:#1565C0!important;"' + ((data['WageCurrency'] == 1)?'selected':'') + '>$</option></select>')
                    
                    //$('td', row).eq(4).html('<label>' + data['Salary'] + '</label><input type="hidden" name="Salary[]" value="' + data['Salary'] + '">');
                    $('td', row).eq(4).html('<input type="text" class="form-control" name="Salary[]" value="' + (data['Salary']==''?'':prettyValue(data['Salary'])) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    //$('td', row).eq(4).html('<input type="text" class="form-control" name="Salary[]" value="' + data['Salary'] + '" style="width: 100%;text-align: center" autocomplete="off">');
                    
                    //$('td', row).eq(5).html('<label>' + data['DateOnboard'] + '</label><input type="hidden" name="DateOnboard[]" value="' + data['DateOnboard'] + '">');
                    //$('td', row).eq(6).html('<label>' + data['DateOffboard'] + '</label><input type="hidden" name="DateOffboard[]" value="' + data['DateOffboard'] + '">');
                    $('td', row).eq(5).html('<div class="input-group"><input class="form-control add-trans-date date-picker text-center" name="DateOnboard[]" type="text" data-date-format="yyyy-mm-dd" value="' + data['DateOnboard'] + '"><span class="input-group-addon"><i class="icon-calendar "></i></span></div>');
                    $('td', row).eq(6).html('<div class="input-group"><input class="form-control add-trans-date date-picker text-center" name="DateOffboard[]" type="text" data-date-format="yyyy-mm-dd" value="' + data['DateOffboard'] + '"><span class="input-group-addon"><i class="icon-calendar "></i></span></div>');

                    $('td', row).eq(7).html('<label>' + data['SignDays'] + '</label><input type="hidden" name="SignDays[]" value="' + data['SignDays'] + '">');
                    $('td', row).eq(8).html('<input type="text" class="form-control add-minus" name="MinusCash[]" value="' + prettyValue(data['MinusCash']) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(9).html('<label>' + data['TransInR'] + '</label><input type="hidden" name="TransInR[]" value="' + __parseStr(data['TransInR']) + '">');
                    $('td', row).eq(10).html('<label>' + data['TransInD'] + '</label><input type="hidden" name="TransInD[]" value="' + __parseStr(data['TransInD']) + '">');
                    $('td', row).eq(11).html('<div class="input-group"><input class="form-control add-trans-date date-picker text-center" name="TransDate[]" type="text" data-date-format="yyyy-mm-dd" value="' + data['TransDate'] + '"><span class="input-group-addon"><i class="icon-calendar "></i></span></div>');
                    $('td', row).eq(12).html('<input type="text" class="form-control" name="Remark[]" value="' + __parseStr(data['Remark']) + '" style="width: 100%;text-align: left" autocomplete="off">');
                    var bank_info = data['BankInformation'];
                    if (bank_info == 'null' || bank_info == null) bank_info = '';
                    //$('td', row).eq(13).html('<label>' + __parseStr(bank_info) + '</label><input type="hidden" name="BankInfo[]" value="' + __parseStr(bank_info) + '">');
                    $('td', row).eq(13).html('<input type="text" class="form-control" name="BankInfo[]" value="' + __parseStr(bank_info) + '" style="width: 100%;text-align: left" autocomplete="off">');
                },
                drawCallback: function (response) {
                    original = response.json.original;
                    if (!original) {
                        info = response.json.info;
                        $('#rate').val(info.rate);
                        $('#minus-days').val(info.minus_days);
                    }
                    setEvents();
                    calcReport();
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        year = $("#select-year option:selected").val();
        month = $("#select-month option:selected").val();
        minus_days = $("#minus-days").val();
        rate = $("#rate").val();
        shipId = $("#select-ship").val();
        $('#search_info').html('"' + $("#select-ship option:selected").attr('data-name') + '" ' + year + '年' + month + '月');
        initTable();

        function setValue(e, v, isNumber) {
            if (v == null || v == "NaN") {
                e.closest("td").firstElementChild.innerHTML = '';
                e.value = '';
            }
            else {
                e.closest("td").firstElementChild.innerHTML = isNumber ? prettyValue(v) : v;
                e.value = v;
            }
        }

        function calcReport()
        {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            
            var calc_date;
            if (original)
                calc_date = today;
            else {/*
                calc_date = info.report_date.substr(0, 10);
                if (origForm != "" && origForm != $form.serialize()) {
                    calc_date = today;
                }*/
                calc_date = today;
            }
            
            var TransInR = $('input[name="TransInR[]"]');
            var TransInD = $('input[name="TransInD[]"]');
            var TransDate = $('input[name="TransDate[]"]');

            var salary = $('input[name="Salary[]"]');
            var days = $('input[name="SignDays[]"]');
            var minus = $('input[name="MinusCash[]"]');
            var currency = $('select[name="Currency[]"]');
            var dateon = $('input[name="DateOnboard[]"]');
            var dateoff = $('input[name="DateOffboard[]"]');
            var rate = $('#rate').val();
            var No = $('.add-no');
            
            var sum_R = 0;
            var sum_D = 0;
            var sum_pre = 0;
            var year = $("#select-year option:selected").val();
            var month = $("#select-month option:selected").val();
            minus_days = $("#minus-days").val();
            rate = $("#rate").val();

            var next = "", now = "";
            var next_year=year;
            var next_month=month;
            if (month == 12) {
                next_year ++;
                next_month = 1;
            } else {
                next_month ++;
            }
            now = new Date(year + "-" + month + "-01");
            now.setDate(now.getDate());
            now = now.getFullYear() + "-"  +(now.getMonth() + 1).toString().padStart(2, '0') + "-" + now.getDate().toString().padStart(2, '0');
            next = new Date(next_year + "-" + next_month + "-01");
            next.setDate(next.getDate() - 1);
            next = next.getFullYear() + "-"  +(next.getMonth() + 1).toString().padStart(2, '0') + "-" + next.getDate().toString().padStart(2, '0');

            var td = daysInMonth(month, year);
            for (var i=0;i<TransInR.length;i++) {
                setValue(No[i], i + 1, false);
                $(No[i]).contents()[0].nodeValue=i + 1;
                var m = parseFloat(minus[i].value.replaceAll(',',''));
                //if(m == undefined || m == null) m = 0;
                var s = parseFloat(salary[i].value.replaceAll(',',''));
                //if(s == undefined || s == null) s = 0;
                var don = dateon[i].value;
                var doff = dateoff[i].value;
                if (don < now) don = now;
                var diff = new Date(new Date(doff) - new Date(don));
                var signon_days = diff/1000/60/60/24+1;
                if (signon_days != td) signon_days = signon_days.toFixed(0) - minus_days;
                setValue(days[i], signon_days, false);
                var dd = parseFloat(signon_days);
                var _R = 0;
                var _D = 0;
                if (currency[i].value == 0) {
                    var r = s * dd / td - m;
                    _R = r.toFixed(2);
                    _D = (r / rate).toFixed(2);
                }
                else {
                    var d = s * dd / td - m;
                    _D = d.toFixed(2);
                    _R = (d * rate).toFixed(2);
                }
                setValue(TransInR[i], _R, true);
                setValue(TransInD[i], _D, true);

                sum_R += (_R==''||_R=='NaN')?0:parseFloat(_R.replaceAll(',',''));
                sum_D += (_D==''||_D=='NaN')?0:parseFloat(_D.replaceAll(',',''));
                if (TransDate[i].value != '') {
                    sum_pre += (_R=='')?0:parseFloat(_R.replaceAll(',',''));
                }
            }
            var sum_Real = sum_R - sum_pre;
            if ($('#list-body tr:last').attr('class') == 'tr-report') {
                $('#list-body tr:last').remove();
            }
            $('#list-body').append('<tr class="tr-report" style="height:30px;border:2px solid black;"><td class="sub-small-header style-normal-header text-center">' + ($('.wage-item').length) + '</td><td class="sub-small-header style-normal-header" colspan="3"></td><td colspan="2" class="sub-small-header style-normal-header text-center">计算日期</td><td class="disable-td text-center">' + calc_date + '<input type="hidden" name="report_date" value="' + calc_date + '"></td><td colspan="2" class="sub-small-header style-normal-header text-center">合计</td><td class="style-normal-header disable-td text-right">¥ ' + prettyValue(sum_R) + '</td><td class="style-normal-header text-right disable-td">$ ' + prettyValue(sum_D) + '</td><td class="sub-small-header style-normal-header text-center">实发工资</td><td class="style-normal-header text-right disable-td">¥ ' + prettyValue(sum_Real) + '</td><td class="sub-small-header style-normal-header" colspan="2"></td></tr>');
            setDatePicker();
            checkPos();
            if (origForm == "")
                origForm = $form.serialize();
        }

        function prettyValue(value)
        {
            if(value == undefined || value == null) return '';
            var val = parseFloat(value);
            if (isNaN(val)) val = 0;
            return parseFloat(val).toFixed(2).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
        }

        function setDatePicker() {
            if (POS == HOLDER || POS == CAPTAIN) return;
            $('.date-picker').datepicker({autoclose: true, format: 'yyyy-mm-dd',}).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });
        }

        function selectInfo()
        {
            shipName = $("#select-ship option:selected").text();
            year = $("#select-year option:selected").val();
            month = $("#select-month option:selected").val();
            minus_days = $("#minus-days").val();
            rate = $("#rate").val();
            if (shipName == "") return;
            $('#search_info').html('"' + $("#select-ship option:selected").attr('data-name') + '" ' + year + '年' + month + '月');

            if (listTable == null) {
                initTable();
            }
            else
            {
                listTable.column(2).search(shipId, false, false);
                listTable.column(3).search(year, false, false);
                listTable.column(4).search(month, false, false);
                listTable.column(5).search(minus_days, false, false);
                listTable.column(6).search(rate, false, false).draw();
            }
        }

        function changeShip() {
            shipId = $('#select-ship').val();
            origForm = "";
            selectInfo();
        }
        $('#select-ship').on('change', function() {
            var prevShip = $('#select-ship').val();
            $('#select-ship').val(shipId);
            var newForm = $form.serialize();
            if ((newForm !== origForm) && !submitted) {
                var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
                alertAudio();
                bootbox.confirm(confirmationMessage, function (result) {
                    if (!result) {
                        return;
                    }
                    else {
                        $('#select-ship').val(prevShip);
                        changeShip();
                    }
                });
            }
            else {
                $('#select-ship').val(prevShip);
                changeShip();
            }
        });

        function changeYear() {
            year = $("#select-year option:selected").val();
            var months = "";
            if (year == now_year) {
                for(var i=1;i<=now_month;i++)
                {
                    months += '<option value="' + i + '" ' + ((now_month==i)?'selected>':'>') +  i + '月</option>';
                }
            }
            else if (year == start_year) {
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
            $('#select-month').html(months);
            origForm = "";
            selectInfo();
        }

        $('#select-year').on('change', function() {
            var prevYear = $('#select-year').val();
            $('#select-year').val(year);
            var newForm = $form.serialize();
            if ((newForm !== origForm) && !submitted) {
                var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
                alertAudio();
                bootbox.confirm(confirmationMessage, function (result) {
                    if (!result) {
                        return;
                    }
                    else {
                        $('#select-year').val(prevYear);
                        changeYear();
                    }
                });
            }
            else {
                $('#select-year').val(prevYear);
                changeYear();
            }
        });

        function changeMonth() {
            month = $("#select-month option:selected").val();
            origForm = "";
            selectInfo();
        }

        $('#select-month').on('change', function() {
            var prevMonth = $('#select-month').val();
            $('#select-month').val(month);
            var newForm = $form.serialize();
            if ((newForm !== origForm) && !submitted) {
                var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
                alertAudio();
                bootbox.confirm(confirmationMessage, function (result) {
                    if (!result) {
                        return;
                    }
                    else {
                        $('#select-month').val(prevMonth);
                        changeMonth();
                    }
                });
            }
            else {
                $('#select-month').val(prevMonth);
                changeMonth();
            }
        });

        $('#minus-days').on('change', function() {
            minus_days = $("#minus-days").val();
            calcReport();
        });

        $('#rate').on('change', function() {
            rate = $("#rate").val();
            calcReport();
        });

        $('body').on('keydown', 'input', function(e) {
            //if (e.target.id == "search-name") return;
            if (e.key === "Enter") {
                var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                focusable = form.find('input').filter(':visible');
                next = focusable.eq(focusable.index(this)+1);
                if (next.length) {
                    next.focus();
                    next.select();
                }
                return false;
            }
        });

        $("#rate").on('change', function() {
            calcReport();
        });

        function setEvents()
        {
            $('.add-minus').on('keyup', function() {
                calcReport();
            });

            $('select[name="Currency[]"]').on('change', function(evt) {
                var value = evt.target.value;
                if (value == 0) $(evt.target).attr('style','color:red!important');
                else { $(evt.target).attr('style','color:#026fcd!important'); }
                calcReport();
            });
            

            $('input[name="Salary[]"]').on('change', function(evt) {
                if (evt.target.value == '') return;
                var val = evt.target.value.replaceAll(',','');
                val = parseFloat(val);
                if (isNaN(val)) {
                    val = 0;
                }
                $(evt.target).val(prettyValue(val));

                calcReport();
            });

            /*
            $('input[name="Salary[]"]').on('keyup', function(evt) {
                calcReport();
            });
            */
            $('input[name="MinusCash[]"]').on('change', function(evt) {
                if (evt.target.value == '') return;
                var val = evt.target.value.replaceAll(',','');
                val = parseFloat(val);
                if (isNaN(val)) {
                    val = 0;
                }
                $(evt.target).val(prettyValue(val));
                calcReport();
            });
            
            $('input[name="TransDate[]"]').on('keyup', function(e) {
                calcReport();
            });

            $('.add-trans-date').on('change', function(evt) {
                calcReport();
            });

            $('.add-no').unbind().on('click', function(e) {
                var val = $(e.target.childNodes[1]).text();
                openAddPage(val);
            })
        }

        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

        function deleteItem(e)
        {
            alertAudio();
            bootbox.confirm("Are you sure you want to delete?", function (result) {
                if (result) {
                    $(e).closest("tr").remove();
                    calcReport();
                }
            });
        }

        function init()
        {
            alertAudio();
            bootbox.confirm("Are you sure you want to init?", function (result) {
                if (result) {
                    $.ajax({
                        url: BASE_URL + 'ajax/shipMember/wage/initCalc',
                        type: 'POST',
                        data: {'shipId':shipId,'year':year,'month':month},
                        success: function(result) {
                            listTable.ajax.reload();
                            $.gritter.add({
                                title: '成功',
                                text: '初始化成功!',
                                class_name: 'gritter-success'
                            });
                            return;
                        },
                        error: function(error) {
                        }
                    });
                }
            });
        }

        function openAddPage(row_index)
        {
            if (POS == HOLDER || POS == CAPTAIN) return;

            $("#modal-add-wage").modal("show");
            $('#add-name').val("缺员");
            $('#add-rank').val("");
            $('#add-currency').val(2);
            $('#add-currency').attr('style','padding-left:unset!important;color:red!important');
            $('#add-wage').val('');
            $('#add-signon-date').val('');
            $('#add-signoff-date').val('');
            $('#add-minus-money').val('');
            $('#add-purchase-date').val('');
            $('#add-remark').val('');
            $('#add-bank-info').val('');
            $('#add-row-index').val(row_index);
        }

        function parseValue(value, isNumber=true)
        {
            if (value == ''){
                return (isNumber?0:'');
            }
            return parseFloat(value);
        }

        function addWage()
        {
            var add_name = $('#add-name').val();
            if (add_name == '') { $('#add-name').focus(); return; }
            var add_rank = $('#add-rank').val();
            var add_currency = $('#add-currency').val();
            if (add_currency == 2) { $('#add-currency').focus(); return; }
            var add_wage = parseValue($('#add-wage').val());
            if ($('#add-wage').val() == '') { $('#add-wage').focus(); return; }
            var add_signon_date = $('#add-signon-date').val();
            if (add_signon_date == '') { $('#add-signon-date').focus(); return; }
            var add_signoff_date = $('#add-signoff-date').val();
            if (add_signoff_date == '') { $('#add-signoff-date').focus(); return; }
            var add_minus_money = parseValue($('#add-minus-money').val());
            var add_purchase_date = $('#add-purchase-date').val();
            var add_remark = $('#add-remark').val();
            var add_bank_info = $('#add-bank-info').val();
            
            var year = $("#select-year option:selected").val();
            var month = $("#select-month option:selected").val();
            var minus_days = $("#minus-days").val();

            var rate = $("#rate").val();
            var add_money_R = 0;
            var add_money_D = 0;

            var next = "", now = "";
            var next_year=year;
            var next_month=month;
            if (month == 12) {
                next_year ++;
                next_month = 1;
            } else
            {
                next_month ++;
            }
            
            now = new Date(year + "-" + month + "-01");
            now.setDate(now.getDate());
            now = now.getFullYear() + "-"  +(now.getMonth() + 1).toString().padStart(2, '0') + "-" + now.getDate().toString().padStart(2, '0');
            next = new Date(next_year + "-" + next_month + "-01");
            next.setDate(next.getDate() - 1);
            next = next.getFullYear() + "-"  +(next.getMonth() + 1).toString().padStart(2, '0') + "-" + next.getDate().toString().padStart(2, '0');

            if ((add_signoff_date < add_signon_date) || (add_signon_date > next) || (add_signoff_date < now)) {
                $('#add-signon-date').focus();
                return;
            }

            if (add_signoff_date >= next) {
                add_signoff_date = next;
            }

            var row_index = $('#add-row-index').val() - 1;
            console.log($('#add-row-index').val());
            console.log(row_index);
            $("#modal-add-wage").modal("hide");

            var start_day;
            if (add_signon_date <= now ) start_day = now;
            var diff = new Date(new Date(add_signoff_date) - new Date(start_day));
            var signon_days = diff/1000/60/60/24+1;
            
            if (add_currency == 0) {
                add_money_R = add_wage * daysInMonth(month, year) / signon_days - add_minus_money;
                add_money_D = add_money_R * rate;
            } else {
                add_money_D = add_wage * daysInMonth(month, year) / signon_days - add_minus_money;
                add_money_R = add_money_D / rate;
            }
            var new_row = '<tr class="wage-item disable-tr" role="row"><td class="text-center disable-td add-no new-member" style="height:18.5px;cursor:crosshair;background:linear-gradient(#fff, #d9f8fb);">' + ($('.wage-item').length+1) +
            '<input type="hidden" name="MemberId[]" value="new_' + ($('.new-member').length) + '">' +
            '</td><td class="text-center disable-td"><label>' + add_name + '</label><input type="hidden" name="Names[]" value="' + add_name + '">' + 
            '</td><td class="text-center disable-td"><label>' + add_rank + '</label><input type="hidden" name="Rank[]" value="' + add_rank + '">'+
            
            //'</td><td class="text-center disable-td add-currency" ' + ((add_currency == 0)?'style="color:red"':'style="color:#026fcd!important"') + '><label>' + ((add_currency == 0)?'¥':'$') + '</label><input type="hidden" name="Currency[]" value="' + add_currency + '">' +
              '</td><td class="text-center disable-td add-currency">' + '<select name="Currency[]" class="form-control" style="color:' + ((add_currency == 0)?'red':'#026fcd') + '"><option value="0" style="color:red!important;"' + ((add_currency == 0)?'selected':'') + '>¥</option><option value="1" style="color:#1565C0!important;"' + ((add_currency == 1)?'selected':'') + '>$</option></select>' +
              //$('td', row).eq(3).html('<select name="Currency[]" class="form-control" style="color:' + ((add_currency == 0)?'red':'#026fcd') + '"><option value="0" style="color:red!important;"' + ((data['WageCurrency'] == 0)?'selected':'') + '>¥</option><option value="1" style="color:#1565C0!important;"' + ((add_currency == 1)?'selected':'') + '>$</option></select>')
            
            '</td><td class="text-center add-salary"><input type="text" class="form-control" name="Salary[]" value="' + add_wage.toFixed(2) + '" style="width: 100%;text-align: center" autocomplete="off">'+ 
            //'</td><td class="text-center disable-td"><label>' + add_signon_date + '</label><input type="hidden" name="DateOnboard[]" value="' + add_signon_date + '">'+
            //'</td><td class="text-center disable-td"><label>' + add_signoff_date + '</label><input type="hidden" name="DateOffboard[]" value="' + add_signoff_date + '">'+
            '</td><td class="text-center disable-td"><div class="input-group"><input class="form-control add-trans-date date-picker text-center" name="DateOnboard[]" type="text" data-date-format="yyyy-mm-dd" value="' + add_signon_date + '"><span class="input-group-addon"><i class="icon-calendar "></i></span></div>' +
            '</td><td class="text-center disable-td"><div class="input-group"><input class="form-control add-trans-date date-picker text-center" name="DateOffboard[]" type="text" data-date-format="yyyy-mm-dd" value="' + add_signoff_date + '"><span class="input-group-addon"><i class="icon-calendar "></i></span></div>' +

            '</td><td class="text-center disable-td add-signondays"><label>' + signon_days + '</label><input type="hidden" name="SignDays[]" value="' + signon_days + '">' +
            '</td><td class="text-center add-minus"><input type="text" class="form-control" name="MinusCash[]" value="'+ add_minus_money +
            '" style="width: 100%;text-align: center" autocomplete="off"></td><td class="text-center disable-td add-transR"><label>' + add_money_R.toFixed(2) + '</label><input type="hidden" name="TransInR[]" value="' + add_money_R.toFixed(2) + '">' +
            '</td><td class="text-center disable-td add-transD"><label>' + add_money_D.toFixed(2) + '</label><input type="hidden" name="TransInD[]" value="' + add_money_D.toFixed(2) + '">' +
            '</td><td class=" text-center""><div class="input-group"><input class="form-control add-trans-date date-picker text-center" name="TransDate[]" type="text" data-date-format="yyyy-mm-dd" value="' + add_purchase_date + '"><span class="input-group-addon"><i class="icon-calendar "></i></span></div></td><td class=" text-center"><input type="text" class="form-control" name="Remark[]" value="'+ add_remark + '" style="width: 100%;text-align: left;" autocomplete="off"></td><td class="text-center disable-td add-bankinfo" style="word-wrap:break-word;text-align: left"><label>'+ add_bank_info + '</label><input type="hidden" name="BankInfo[]" value="' + add_bank_info + '">' +
            '</td><td class=" text-center"><div class="action-buttons"><a class="red" onclick="javascript:deleteItem(this)"><i class="icon-trash"></i></a></div></td></tr>';
            
            
            $('.wage-item:eq(' + row_index + ')').last().after(new_row);
            setDatePicker();
            setEvents();
            calcReport();
        }

        var submitted = false;
        $("#btnSave").on('click', function() {
            //origForm = $form.serialize();
            submitted = true;
            if ($('.wage-item').length > 0) {
                $('#wage-form').submit();
                $('td[style*="display: none;"]').remove();
            }
        });

        var $form = $('form');
        var origForm = "";
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
            var newForm = $form.serialize();
            if ((newForm !== origForm) && !submitted) {
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });

        function selectCurrency()
        {
            var value = $('#add-currency').val();
            if (value == 0) $('#add-currency').attr('style','padding-left:unset!important;color:red!important');
            else { $('#add-currency').attr('style','padding-left:unset!important;color:#026fcd!important'); }
        }

        function fnExcelReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-shipmember-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='14' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_info').html() + "份工资单</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[1].style.width = '140px';
                    tab.rows[j].childNodes[2].style.width = '60px';
                    tab.rows[j].childNodes[3].style.width = '40px';
                    tab.rows[j].childNodes[6].style.width = '80px';
                    tab.rows[j].childNodes[13].style.width = '300px';
                    tab.rows[j].childNodes[14].remove();
                }
                else if(j == (tab.rows.length -1))
                {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.height = "30px";
                        tab.rows[j].childNodes[i].style.fontWeight = "bold";
                        tab.rows[j].childNodes[i].style.backgroundColor = '#ebf1de';
                    }
                    tab.rows[j].childNodes[9].colSpan="1";
                }
                else
                {
                    var info = real_tab.rows[j].childNodes[3].childNodes[0].value;
                    tab.rows[j].childNodes[3].innerHTML = info == 0 ? '¥' : '$';
                    info = real_tab.rows[j].childNodes[4].childNodes[0].value;
                    tab.rows[j].childNodes[4].innerHTML = info;
                    info = real_tab.rows[j].childNodes[5].childNodes[0].childNodes[0].value;
                    tab.rows[j].childNodes[5].innerHTML = info;
                    info = real_tab.rows[j].childNodes[6].childNodes[0].childNodes[0].value;
                    tab.rows[j].childNodes[6].innerHTML = info;
                    info = real_tab.rows[j].childNodes[8].childNodes[0].value;
                    tab.rows[j].childNodes[8].innerHTML = info;
                    info = real_tab.rows[j].childNodes[11].childNodes[0].childNodes[0].value;
                    tab.rows[j].childNodes[11].innerHTML = info;
                    info = real_tab.rows[j].childNodes[12].childNodes[0].value;
                    tab.rows[j].childNodes[12].innerHTML = info;
                    info = real_tab.rows[j].childNodes[13].childNodes[0].value;
                    tab.rows[j].childNodes[13].innerHTML = info;
                }
                
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = $("#select-ship option:selected").html() + '_' + year + '_' + month + '_工资单';
            exportExcel(tab_text, filename, year + '_' + month + '_工资单');
            return 0;
        }

        function checkPos()
        {
            if (POS == HOLDER || POS == CAPTAIN) {
                $('input[type="text"], textarea').each(function(){
                    $(this).attr('readonly','readonly');
                });

                $('i[class="icon-calendar"], select[name="Currency[]"]').each(function(){
                    $(this).attr('disabled',true);
                });

                $('div[class="action-buttons"]').each(function(){
                    $(this).hide();
                });
                origForm = $form.serialize();
            }
        }
        checkPos();
    </script>

@endsection
