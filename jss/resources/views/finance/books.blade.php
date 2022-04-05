@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
?>

@section('styles')
    <link href="{{ cAsset('css/style.css?v=20211006104500') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/pretty.css?v=20211006104500') }}" rel="stylesheet"/>
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

            .disable-td {
                background-color:unset!important;
            }

            .dynamic-first-footer td {
                position: sticky!important;
                bottom: 0px;
                box-shadow: inset 0 1px #000, 1px -1px #000;
                border-top: unset!important;
                background-color: #beffcd!important;
            }

            .dynamic-second-footer td {
                position: sticky!important;
                bottom: 24px;
                box-shadow: inset 0 1px #000, 1px -1px #000;
                border-top: unset!important;
                background-color: #beffcd!important;
            }

            .dynamic-third-footer td {
                position: sticky!important;
                bottom: 48px;
                box-shadow: inset 0 1px #000, 1px -1px #000;
                border-top: unset!important;
            }

            .dynamic-fourth-footer td {
                position: sticky!important;
                bottom: 72px;
                box-shadow: inset 0 1px #000, 1px -1px #000;
                border-top: unset!important;
            }


        </style>
        <div class="page-content">
            <div class="space-4"></div>
            <div class="col-md-12">
                <div class="row">
                    <div class="tabbable">
                        <ul class="nav nav-tabs ship-register" id="memberTab">
                            <li class="active">
                                <a data-toggle="tab" href="#tab_book">
                                    记账簿
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_water">
                                    流水账
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="tab_book" class="tab-pane active">
                        <form id="books-form" action="books/save" role="form" method="POST" enctype="multipart/form-data">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>记账簿管理</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <select name="select-year" id="select-year" style="font-size:13px">
                                            @for($i=date("Y");$i>=$start_year;$i--)
                                            <option value="{{$i}}" @if(($year==$i)||(($year=='')&&($i==date("Y")))) selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                        <select name="select-month" id="select-month" style="font-size:13px;width:60px;">
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
                                        <!--a class="btn btn-sm btn-danger refresh-btn-over" id="btnInit" type="button" onclick="init()" style="width: 80px;height: 26px!important;margin-bottom: 1px;padding: 5px!important;">
                                            <img src="{{ cAsset('assets/images/refresh.png') }}" class="report-label-img">初始化
                                        </a-->
                                        <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="search_info"></span>记账簿</strong>
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
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
                                        <div class="head-fix-div" id="crew-table" style="height: 300px;">
                                            <table id="table-books-list" style="table-layout:fixed;">
                                                <thead class="">
                                                    <th class="text-center style-normal-header" style="width: 4%;height:35px;"><span style="cursor:pointer" onclick="javascript:clearSelection();">记账绑定</span></th>
                                                    <th class="text-center style-normal-header" style="width: 6%;"><span>审核<br/>编号</span></th>
                                                    <th class="text-center style-normal-header" style="width: 7%;"><span>记账编号</span></th>
                                                    <th class="text-center style-normal-header" style="width: 7%;"><span>日期</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>对象</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>航次</span></th>
                                                    <th class="text-center style-normal-header" style="width: 8%;"><span>收支种类</span></th>
                                                    <th class="text-center style-normal-header" style="width: 30%;"><span>摘要</span></th>
                                                    <th class="text-center style-normal-header" style="width: 3%;"><span>币类</span></th>
                                                    <th class="text-center style-normal-header" style="width: 9%;"><span>收入</span></th>
                                                    <th class="text-center style-normal-header" style="width: 9%;"><span>支出</span></th>
                                                    <th class="text-center style-normal-header" style="width: 5%;"><span>汇率</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>原始凭证</span></th>
                                                </thead>
                                                <tbody class="" id="list-book-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="tabbable">
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary" id="btnKeep" style="margin-top:10px;width:100px;height:30px;">记账凭证</button>
                                            </div>
                                            <div class="col-sm-10 f-right" style="margin-top:12px;padding-right: 0px!important;">
                                                <input type="text" id="remark-box" name="remark-box" style="color:red;width:100%;display:none;" readonly="">
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div id="general" class="tab-pane active">
                                                <div class="space-4"></div>
                                                <div class="col-md-12" style="margin-bottom:6px;">
                                                    <div class="row">
                                                        <div class="col-lg-2">
                                                            <label class="custom-label d-inline-block font-bold" style="padding: 6px;">记账编号:</label>
                                                            <input type="text" name="keep-list-bookno" id="keep-list-bookno" style="width:80px;margin-right:0px;" readonly/>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label class="search-label font-bold" style="float:left;padding-top:7px;">日期:</label>
                                                            <input class="search-input date-picker" id="keep-list-datetime" name="keep-list-datetime" type="text" data-date-format="yyyy-mm-dd" style="height:24px;width:70px;">
                                                            <i class="icon-calendar bigger-110 search-calendar"></i>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label class="custom-label d-inline-block font-bold" style="padding: 6px;">汇率:</label>
                                                            <input type="number" name="keep_rate" id="keep_rate" value="6.5000" min="4" step="0.01" autocomplete="off" style="width:80px;margin-right:0px;"/>
                                                        </div> 
                                                        <div class="col-lg-2">
                                                            <label class="custom-label d-inline-block font-bold" style="padding: 6px;">收支方式:</label>
                                                            <select class="" name="pay_type" id="pay_type">
                                                                <option value="0">汇款</option>
                                                                <option value="1">现钞</option>
                                                                <option value="2">扣除</option>
                                                                <option value="3">转账</option>
                                                            </select>
                                                        </div>                                                             
                                                        <div class="col-lg-2">
                                                            <label class="custom-label d-inline-block font-bold" style="padding: 6px;">账户:</label>
                                                            <select class="" name="account_type" id="account_type">
                                                                <option value="0"></option>
                                                            @if(isset($accounts) && count($accounts) > 0)
                                                            @foreach ($accounts as $account)
                                                                <option value="{{ $account->id }}">{{ $account->account }}</option>
                                                            @endforeach
                                                            @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin:8px;">
                                                    <div class="space-4"></div>
                                                    <table id="table-keep-list" class="table table-bordered">
                                                        <thead>
                                                            <th class="center sub-header font-bold" style="width:6%">审核编号</td>
                                                            <th class="center sub-header font-bold" style="width:10%">对象</td>
                                                            <th class="center sub-header font-bold" style="width:6%">航次</td>
                                                            <th class="center sub-header font-bold" style="width:10%">收支种类</td>
                                                            <th class="center sub-header font-bold" style="width:34%">摘要</td>
                                                            <th class="center sub-header font-bold" style="width:4%">币类</td>
                                                            <th class="center sub-header font-bold" style="width:15%">借方</td>
                                                            <th class="center sub-header font-bold" style="width:15%">贷方</td>
                                                        </thead>
                                                        <tbody id="table-keep-body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row" style="margin:8px;">
                                                    <div class="btn-group f-right mt-20">
                                                        <a class="btn btn-sm btn-danger refresh-btn-over" id="btnInit" type="button" onclick="init()" style="width: 80px;height: 26px!important;margin-bottom: 1px;padding: 5px!important;" disabled>
                                                            <img src="{{ cAsset('assets/images/refresh.png') }}" class="report-label-img">初始化
                                                        </a>
                                                        <a class="btn btn-primary btn-sm" id="btnOK" disabled>OK</a>
                                                        <a class="btn btn-danger btn-sm" id="btnCancel" disabled>Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="keep_list" name="keep_list"></input>
                        </form>
                        </div>
                        <div id="tab_water" class="tab-pane">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>流水账管理</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7">
                                        <select name="select-water-year" id="select-water-year" style="font-size:13px">
                                            @for($i=date("Y");$i>=$start_year;$i--)
                                            <option value="{{$i}}" @if(($year==$i)||(($year=='')&&($i==date("Y")))) selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                        <select name="select-water-month" id="select-water-month" style="font-size:13px;width:60px;">
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
                                        <label style="margin-left: 8px;">对象</label>
                                        <select type="text" class="custom-select d-inline-block" id="ship_name" style="width:80px">
                                            <option value=""></option>
                                            @if(isset($shipList))
                                                @foreach($shipList as $key => $item)
                                                    <option value="{{ $item->IMO_No }}" {{ isset($shipId) && $shipId == $item->IMO_No ?  "selected" : "" }}>{{$item->NickName == '' ? $item->shipName_En : $item->NickName }}</option>
                                                @endforeach
                                            @endif
                                            @if(isset($infos))
                                                @foreach($infos as $key => $item)
                                                    <option value="{{ $item->id }}">{{$item->person }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="search_water_info"></span>流水账</strong>
                                    </div>
                                    <div class="col-md-5" style="padding:unset!important">
                                        <div class="btn-group f-right">
                                            <a onclick="javascript:fnExcelWaterReport();" class="btn btn-warning btn-sm excel-btn">
                                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:4px;">
                                    <div id="item-manage-dialog" class="hide"></div>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="row">
                                        <div class="head-fix-div" id="water-table" style="height: 600px;">
                                            <table id="table-water-list" style="table-layout:fixed;">
                                                <thead class="">
                                                    <th class="text-center style-normal-header" style="width: 7%;height:35px;"><span>记账编号</span></th>
                                                    <th class="text-center style-normal-header" style="width: 7%;"><span>日期</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>对象</span></th>
                                                    <th class="text-center style-normal-header" style="width: 27%;"><span>摘要</span></th>
                                                    <th class="text-center style-normal-header" style="width: 3%;"><span>币类</span></th>
                                                    <th class="text-center style-normal-header" style="width: 12%;"><span>借方</span></th>
                                                    <th class="text-center style-normal-header" style="width: 12%;"><span>贷方</span></th>
                                                    <th class="text-center style-normal-header" style="width: 5%;"><span>汇率</span></th>
                                                    <th class="text-center style-normal-header" style="width: 9%;"><span>收支方式</span></th>
                                                    <th class="text-center style-normal-header" style="width: 6%;"><span>账户</span></th>
                                                    <th class="text-center style-normal-header" style="width: 4%;"><span>原始凭证</span></th>
                                                </thead>
                                                <tbody class="" id="list-water-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    echo 'var start_year = ' . $start_year . ';';
    echo 'var start_month = ' . $start_month . ';';
    echo 'var now_year = ' . date("Y") . ';';
    echo 'var now_month = ' . date("m") . ';';
    echo 'var book_no = ' . $book_no . ';';
    echo 'var ReportTypeData = ' . json_encode(g_enum('ReportTypeData')) . ';';
	echo 'var ReportStatusData = ' . json_encode(g_enum('ReportStatusData')) . ';';
    echo 'var CurrencyLabel = ' . json_encode(g_enum('CurrencyLabel')) . ';';
    echo 'var FeeTypeData = ' . json_encode(g_enum('FeeTypeData')) . ';';
    echo 'var PayTypeData = ' . json_encode(g_enum('PayTypeData')) . ';';
	echo '</script>';
	?>

    <script>
        var token = '{!! csrf_token() !!}';
        var isAdmin = '{!! Auth::user()->isAdmin !!}';
        
        var year = '';
        var month = '';

        var year_water = '';
        var month_water = '';
        var ship_name;

        var listTable = null;
        var listBook = null;
        var listWaterTable = null;
        function initTable() {
            listTable = $('#table-books-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/finance/books/list',
                    type: 'POST',
                    data: {'year':year, 'month':month},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: null, className: "text-center"},
                    {data: 'report_no', className: "text-center"},
                    {data: 'book_no', className: "text-center"},
                    {data: 'datetime', className: "text-center"},
                    {data: 'obj', className: "text-center"},
                    {data: 'voyNo', className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: 'content', className: ""},
                    {data: 'currency', className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: 'rate', className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();
                    $(row).attr('title', data['user']);

                    $('td', row).eq(1).attr('class', 'text-center disable-td');
                    $('td', row).eq(2).attr('class', 'text-center');
                    $('td', row).eq(3).attr('class', 'text-center disable-td');
                    $('td', row).eq(4).attr('class', 'text-center disable-td');
                    $('td', row).eq(5).attr('class', 'text-center disable-td');
                    $('td', row).eq(6).attr('class', 'text-center disable-td');
                    $('td', row).eq(7).attr('class', '');
                    $('td', row).eq(8).attr('class', 'text-center disable-td');
                    $('td', row).eq(9).attr('class', 'text-center');
                    $('td', row).eq(10).attr('class', 'text-center');
                    $('td', row).eq(11).attr('class', 'text-center');

                    if (data['book_no'] != '')
                        $('td', row).eq(0).html('').append('<input type="checkbox" checked disabled></input>');
                    else
                        $('td', row).eq(0).html('').append('<input class="need_chk" type="checkbox"></input>');
                    
                    $('td', row).eq(0).append('<input type="hidden" name="report_id[]" value="' + data['id'] + '">');
                    $('td', row).eq(0).append('<input type="hidden" name="ship_no[]" value="' + data['ship_no'] + '">');

                    $('td', row).eq(3).html('').append(data['datetime'].substr(0,10));
                    $('td', row).eq(6).html('').append(FeeTypeData[data['flowid']][data['profit_type']]);

                    if (data['currency'] == '$') {
                        $('td', row).eq(8).attr('style','color:#026fcd!important');
                    } else {
                        $('td', row).eq(8).attr('style','color:red');
                    }
                    if (data['book_no'] == '')
                        $('td', row).eq(2).html('<input type="text" class="form-control style-blue-input" readonly name="book_no[]" value="" style="cursor:pointer;width: 100%;text-align: center" autocomplete="off">');
                    else
                        $('td', row).eq(2).html('<input type="text" class="form-control style-blue-input" readonly name="book_no[]" value="' + ('J-'+data['book_no']) + '" style="cursor:pointer;width: 100%;text-align: center" autocomplete="off">');
                    if (data['flowid'] == "Credit") {
                        if (data['amount'] >= 0)
                            $('td', row).eq(9).html('<input type="text" class="form-control style-blue-input" name="credit[]" readonly value="' + (data['amount']==null?'':prettyValue(data['amount'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                        else
                            $('td', row).eq(9).html('<input type="text" class="form-control style-red-input" name="credit[]" readonly value="' + (data['amount']==null?'':prettyValue(data['amount'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                        //$('td', row).eq(10).html('<input type="text" class="form-control style-blue-input" name="debit[]" readonly value="" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                        $('td', row).eq(10).html('<input type="text" class="form-control" name="debit[]" readonly value="" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                    } else if(data['flowid'] == "Debit") {
                        if (data['amount'] >= 0)
                            //$('td', row).eq(10).html('<input type="text" class="form-control style-blue-input" name="debit[]" readonly value="' + (data['amount']==null?'':prettyValue(data['amount'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                            $('td', row).eq(10).html('<input type="text" class="form-control" name="debit[]" readonly value="' + (data['amount']==null?'':prettyValue(data['amount'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                        else
                            //$('td', row).eq(10).html('<input type="text" class="form-control style-red-input" name="debit[]" readonly value="' + (data['amount']==null?'':prettyValue(data['amount'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                            $('td', row).eq(10).html('<input type="text" class="form-control" name="debit[]" readonly value="' + (data['amount']==null?'':prettyValue(data['amount'])) + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                        $('td', row).eq(9).html('<input type="text" class="form-control style-blue-input" name="credit[]" readonly value="" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                    } else {
                        $('td', row).eq(9).html('<input type="text" class="form-control style-blue-input" name="credit[]" readonly value="" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                        $('td', row).eq(10).html('<input type="text" class="form-control style-blue-input" name="debit[]" readonly value="" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">');
                    }
                    var link_html = '<label><a href="' + data['attachment'] + '" target="_blank" class="' + (data['attachment']==null ? 'visible-hidden':'') + '"><img src="' + "{{ cAsset('assets/images/document.png') }}" + '"' + ' width="15" height="15" style="cursor: pointer;"></a></label>';
                    $('td', row).eq(11).html('<input type="text" class="form-control" readonly name="rate[]" value="' + formatRate(data['rate']) + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(12).html('').append(link_html);

                    var remark = data['remark'];
                    if ((remark != 'null') && (remark != '') && (remark != null)) {
                        remark = remark.replaceAll("\n","");
                        $('td', row).eq(7).attr('style', 'padding: 1em 3em;border: 1px solid grey;background-image: linear-gradient(225deg, red, red 6px, transparent 6px, transparent);');
                        $('td', row).eq(7).attr('remark', remark);
                        //$('td', row).eq(7).html('<input type="text" class="form-control content" readonly name="report_remark[]" value="' + data['content'] + '" style="cursor:pointer;width: 100%;background-color:transparent!important;" autocomplete="off" onclick="showRemark(' + "'" + remark + "'" + ')">');
                        $('td', row).eq(7).html('<input type="text" class="form-control content" readonly name="report_remark[]" value="' + data['content'] + '" style="padding-left:0px!important;cursor:pointer;width: 100%;background-color:transparent!important;" autocomplete="off" onclick="showRemark(this)">');
                    }
                    else {
                        $('td', row).eq(7).html('<input type="text" class="form-control content" readonly name="report_remark[]" value="' + data['content'] + '" style="padding-left:0px!important;cursor:pointer;width: 100%;background-color:transparent!important;" autocomplete="off" onclick="showRemark(this)">');
                    }
                    
                },
                drawCallback: function (response) {
                    listBook = response.json.data;
                    setEvents();
                    origForm = $form.serialize();
                    origForm = origForm.replaceAll(/select-year\=|[0-9]/gi,'');
                    origForm = origForm.replaceAll(/select-month\=|[0-9]/gi,'');

                    book_no = response.json.book_no;
                    //console.log("BOOK_NO:", response.json.book_no);
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
        $('#search_info').html(year + '年' + month + '月份');
        initTable();

        var sum_credit_R = 0;
        var sum_debit_R = 0;
        var sum_credit_D = 0;
        var sum_debit_D = 0;
        function initWaterTable() {
            listWaterTable = $('#table-water-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/finance/waters/list',
                    type: 'POST',
                    data: {'year':year_water, 'month':month_water, 'ship_name':ship_name},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'book_no', className: "text-center"},
                    {data: 'datetime', className: "text-center"},
                    {data: 'ship_name', className: "text-center"},
                    {data: 'content', className: ""},
                    {data: 'currency', className: "text-center"},
                    {data: 'credit', className: "text-center"},
                    {data: 'debit', className: "text-center"},
                    {data: 'rate', className: "text-center"},
                    {data: 'pay_type', className: "text-center"},
                    {data: 'account_name', className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();

                    if ((index%2) == 0)
                        $(row).attr('class', 'cost-item-even');
                    else
                        $(row).attr('class', 'cost-item-odd');
                    
                    $('td', row).eq(0).attr('class', 'text-center');
                    $('td', row).eq(1).attr('class', 'text-center');
                    $('td', row).eq(2).attr('class', 'text-center');
                    $('td', row).eq(3).attr('class', '');
                    $('td', row).eq(3).attr('style', 'padding-left:2px!important;');
                    $('td', row).eq(4).attr('class', 'text-center');
                    $('td', row).eq(5).attr('class', 'text-center');
                    $('td', row).eq(6).attr('class', 'text-center');
                    $('td', row).eq(7).attr('class', 'text-center');
                    $('td', row).eq(8).attr('class', 'text-center');
                    $('td', row).eq(9).attr('class', 'text-center');
                    $('td', row).eq(10).attr('class', 'text-center');

                    $('td', row).eq(7).html('').append(formatRate(data['rate']));
                    $('td', row).eq(8).html('').append(PayTypeData[data['pay_type']]);
                    $('td', row).eq(9).html('').append(data['account_name']);

                    $('td', row).eq(0).html('').append("J-" + data['book_no']);
                    if (data['currency']== 0)
                    {
                        $('td', row).eq(4).html('').append('¥');
                        $('td', row).eq(4).attr('style','color:red');
                        sum_credit_R += data['credit'];
                        sum_debit_R += data['debit'];
                    }
                    else
                    {
                        $('td', row).eq(4).html('').append('$');
                        $('td', row).eq(4).attr('style','color:#026fcd!important');
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

                    var link_html = '<label><a href="' + data['attachment'] + '" target="_blank" class="' + (data['attachment']==null ? 'visible-hidden':'') + '"><img src="' + "{{ cAsset('assets/images/document.png') }}" + '"' + ' width="15" height="15" style="cursor: pointer;"></a></label>';
                    $('td', row).eq(10).html('').append(link_html);
                },
                drawCallback: function (response) {
                    if (response.json.data.length == 0) {
                        sum_credit_R = 0;
                        sum_debit_R = 0;
                        sum_credit_D = 0;
                        sum_debit_D = 0;
                    }
                    var report_row = '<tr class="tr-report dynamic-footer dynamic-fourth-footer" style="height:20px;border:1px solid black;">';
                    report_row += '<td class="sub-small-header"></td><td class="sub-small-header"></td><td class="sub-small-header style-normal-header"></td><td class="sub-small-header style-normal-header text-center"><span style="color:red">合计 (RMB)</span></td><td class="sub-small-header style-normal-header"></td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right style-blue-input">¥ ' + prettyValue(sum_credit_R) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right">¥ ' + prettyValue(sum_debit_R) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" colspan="2" class="style-normal-header sub-small-header text-right ' + ((sum_credit_R - sum_debit_R) >= 0 ? 'style-black-input':'style-red-input') + '">¥ ' + prettyValue(sum_credit_R - sum_debit_R) + '</td>';
                    report_row += '<td class="sub-small-header" colspan="1"></td>';
                    report_row += '<td class="sub-small-header"></td>';
                    report_row += '</tr>';
                    report_row += '<tr class="tr-report dynamic-footer dynamic-third-footer" style="height:20px;border:1px solid black;">';
                    report_row += '<td class="sub-small-header"></td><td class="sub-small-header"></td><td class="sub-small-header style-normal-header"></td><td class="sub-small-header style-normal-header text-center"><span style="color:#026fcd">合计 (USD)</span></td><td class="sub-small-header style-normal-header"></td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right style-blue-input">$ ' + prettyValue(sum_credit_D) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header text-right">$ ' + prettyValue(sum_debit_D) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" colspan="2" class="style-normal-header sub-small-header text-right ' + ((sum_credit_D - sum_debit_D) >= 0 ? 'style-black-input':'style-red-input') + '">$ ' + prettyValue(sum_credit_D - sum_debit_D) + '</td>';
                    report_row += '<td class="sub-small-header" colspan="1"></td>';
                    report_row += '<td class="sub-small-header"></td>';
                    report_row += '</tr>';

                    var total_sum = response.json.totalSum;
                    report_row += '<tr class="tr-report dynamic-footer dynamic-second-footer" style="height:20px;border:1px solid black;">';
                    report_row += '<td class="sub-small-header2"></td><td class="sub-small-header2"></td><td class="sub-small-header2 style-normal-header"></td><td class="sub-small-header2 style-normal-header text-center"><span style="color:red">累计 (RMB)</span></td><td class="sub-small-header2 style-normal-header"></td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header2 text-right style-blue-input">¥ ' + prettyValue(total_sum[0].credit_sum) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header2 text-right">¥ ' + prettyValue(total_sum[0].debit_sum) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" colspan="2" class="style-normal-header sub-small-header2 text-right ' + ((total_sum[0].credit_sum - total_sum[0].debit_sum) >= 0 ? 'style-black-input':'style-red-input') + '">¥ ' + prettyValue(total_sum[0].credit_sum - total_sum[0].debit_sum) + '</td>';
                    report_row += '<td class="sub-small-header2" colspan="1"></td>';
                    report_row += '<td class="sub-small-header2"></td>';
                    report_row += '</tr>';
                    report_row += '<tr class="tr-report dynamic-footer dynamic-first-footer" style="height:20px;border:1px solid black;">';
                    report_row += '<td class="sub-small-header2"></td><td class="sub-small-header2"></td><td class="sub-small-header2 style-normal-header"></td><td class="sub-small-header2 style-normal-header text-center"><span style="color:#026fcd">累计 (USD)</span></td><td class="sub-small-header2 style-normal-header"></td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header2 text-right style-blue-input">$ ' + prettyValue(total_sum[1].credit_sum) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" class="style-normal-header sub-small-header2 text-right">$ ' + prettyValue(total_sum[1].debit_sum) + '</td>';
                    report_row += '<td style="padding-right:5px!important;" colspan="2" class="style-normal-header sub-small-header2 text-right ' + ((total_sum[1].credit_sum - total_sum[1].debit_sum) >= 0 ? 'style-black-input':'style-red-input') + '">$ ' + prettyValue(total_sum[1].credit_sum - total_sum[1].debit_sum) + '</td>';
                    report_row += '<td class="sub-small-header2" colspan="1"></td>';
                    report_row += '<td class="sub-small-header2"></td>';
                    report_row += '</tr>';
                    $('#list-water-body').append(report_row);
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }

        year_water = $("#select-water-year option:selected").val();
        month_water = $("#select-water-month option:selected").val();
        ship_name = $("#ship_name option:selected").val();
        $('#search_water_info').html(year_water + '年' + month_water + '月份');
        initWaterTable();

        function selectWaterInfo()
        {
            year_water = $("#select-water-year option:selected").val();
            month_water = $("#select-water-month option:selected").val();
            ship_name = $("#ship_name option:selected").val();
            ship_text = $("#ship_name option:selected").text();
            if (ship_text == '')
                $('#search_water_info').html(year_water + '年' + month_water + '月份');
            else
                $('#search_water_info').html(year_water + '年' + month_water + '月份(' + ship_text + ')');

            sum_credit_R = 0;
            sum_debit_R = 0;
            sum_credit_D = 0;
            sum_debit_D = 0;

            if (listWaterTable == null) {
                initWaterTable();
            }
            else
            {
                listWaterTable.column(1).search(year_water, false, false);
                listWaterTable.column(2).search(month_water, false, false);
                listWaterTable.column(3).search(ship_name, false, false).draw();
            }
        }

        function prettyValue(value)
        {
            if(value == undefined || value == null) return '';
            return parseFloat(value).toFixed(2).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
        }

        function selectInfo()
        {
            year = $("#select-year option:selected").val();
            month = $("#select-month option:selected").val();
            $('#search_info').html(year + '年' + month + '月份');
            clearList();
            books = [];
            
            if (listTable == null) {
                initTable();
            }
            else
            {
                listTable.column(1).search(year, false, false);
                listTable.column(2).search(month, false, false).draw();
            }
        }

        function setState(f) {
            if (f) {
                $('#btnKeep').prop('disabled', true);
                $('#btnOK').attr('disabled', false);
                $('#btnCancel').attr('disabled', false);
                $('#btnInit').attr('disabled',true);
            } else {
                $('#btnKeep').prop('disabled', false);
                $('#btnOK').attr('disabled', true);
                $('#btnCancel').attr('disabled', true);
            }
        }

        function clearList() {
            $('#keep-list-bookno').val('');
            //$('#keep-list-datetime').val('');
            //$('#pay_type').val(0);
            //$("#account_type").val($("#account_type option:first").val());
            
            $('#table-keep-body').html('');
            setState(false);
        }
        function changeYear(type) {
            
            clearList();
            books = [];

            if (type == 0)
            {
                year = $("#select-year option:selected").val();
                check_year = year;
            }
            else {
                year_water = $("#select-water-year option:selected").val();
                check_year = year_water;
            }

            
            var months = "";
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
                $('#select-month').html(months);
                selectInfo();
            }
            else {
                $('#select-water-month').html(months);
                selectWaterInfo();
            }
        }

        var currency = "";
        var datetime = "";

        var rate = window.localStorage.getItem("rate");
        if (rate == null || rate == undefined) rate = 6.5;
        else $('#keep_rate').val(formatRate(rate));

        var pay_type = window.localStorage.getItem("pay_type");
        if (pay_type == null || pay_type == undefined) pay_type = 0;
        else $('#pay_type').val(pay_type);

        /*
        var account_type = window.localStorage.getItem("account_type");
        if (account_type == null || account_type == undefined) account_type = 0;
        else $('#account_type').val(account_type);
        */
        var account_type = 0;

        var account_name = "";
        var keepContent = "";
        $('#btnKeep').on('click', function() {
            setKeepTable();
        })

        function setKeepTable()
        {
            $('#account_type').val(0);
            var count = $('input.need_chk:checked').length;
            if (count <= 0) return;
            
            var book_list = document.getElementById('list-book-body');
            $('#table-keep-body').html('');

            currency = "";
            var old_book_no = "";
            for(var i = 0 ; i < book_list.rows.length ; i++) 
            {
                if (book_list.rows[i].childNodes[0].childNodes[0].checked && !book_list.rows[i].childNodes[0].childNodes[0].disabled) {
                    if (currency == "") {
                        currency = listBook[i].currency;
                        datetime = listBook[i].datetime.substr(0,10);
                    }
                    if (currency != listBook[i].currency){
                        alert("You can't choose different kind of currency.");
                        return;
                    }

                    if (old_book_no == "") {
                        old_book_no = book_list.rows[i].childNodes[2].childNodes[0].value;
                    }
                    else if ((book_list.rows[i].childNodes[2].childNodes[0].value != "") && (old_book_no != book_list.rows[i].childNodes[2].childNodes[0].value))
                    {
                        alert("Items assigned with different numbers cannot be selected!");
                        return;
                    }
                }
            }

            setState(true);
            count = 0;
            
            for(var i = 0 ; i < book_list.rows.length ; i++)
            {
                if (book_list.rows[i].childNodes[0].childNodes[0].checked && !book_list.rows[i].childNodes[0].childNodes[0].disabled) {
                    var row_html = '';
                    var credit_text = book_list.rows[i].childNodes[9].childNodes[0].value;
                    var credit = credit_text.replaceAll(",","");
                    var debit_text = book_list.rows[i].childNodes[10].childNodes[0].value;
                    var debit = debit_text.replaceAll(",","");
                    
                    row_html = "<tr data-ref='" + i + "' ship-no='" + book_list.rows[i].childNodes[0].childNodes[2].value + "'";
                    row_html += " report-id='" + book_list.rows[i].childNodes[0].childNodes[1].value + "'><td class='text-center disable-td no-padding'>" + book_list.rows[i].childNodes[1].innerText + "</td><td class='text-center disable-td no-padding'>"+ listBook[i].obj + "</td><td class='text-center disable-td no-padding'>" + book_list.rows[i].childNodes[5].innerText + "</td><td class='text-center disable-td no-padding'>" + book_list.rows[i].childNodes[6].innerText + "</td><td>";
                    row_html += '<input type="text" class="form-control" name="Keep_Remark[]" value="' + book_list.rows[i].childNodes[7].childNodes[0].value + '" style="width: 100%;" autocomplete="off">';
                    row_html += "</td><td class='text-center disable-td no-padding' style='color:" + (listBook[i].currency=="$"?"#026fcd":"red") + "'>" + listBook[i].currency + "</td><td>";
                    if (credit >= 0)
                        row_html += '<input type="text" class="form-control style-blue-input keep_credit" name="Keep_credit[]" value="' + credit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td><td>";
                    else
                        row_html += '<input type="text" class="form-control style-red-input keep_credit" name="Keep_credit[]" value="' + credit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td><td>";

                    if (debit >= 0)
                        row_html += '<input type="text" class="form-control style-normal-input keep_debit" name="Keep_debit[]" value="' + debit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td>";
                    else
                        row_html += '<input type="text" class="form-control style-red-input keep_debit" name="Keep_debit[]" value="' + debit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td>";
                    row_html += "</tr>";
                    
                    $('#table-keep-body').append(row_html);
                    count ++;
                }
            }
            if (count == 0) return;
            if (old_book_no == "") $('#keep-list-bookno').val("J-" + (book_no + 1));
            else $('#keep-list-bookno').val(old_book_no);

            
            var rows_to_remove = $('.style-red-input').parent().parent();
            for (var i=0;i<rows_to_remove.length;i++) {
                if (rows_to_remove[i].firstElementChild.firstElementChild.checked == false)
                {
                    if (rows_to_remove[i].childNodes[2].firstElementChild.value == $('#keep-list-bookno').val())
                    {
                        rows_to_remove[i].childNodes[2].firstElementChild.value = "";
                    }
                }
            }
            //$('.style-red-input').parent().parent().find('[type="checkbox"]').attr("disabled", "true");
            //style-red-input
            
            calcKeepReport(true);
            setEvents();
            keepContent = $('#general').html();
        }

        function formatRate(rate) {
            if (rate==null||rate==undefined||rate=='') return '';
            return parseFloat(rate).toFixed(4);
        }

        var sum_credit = 0;
        var sum_debit = 0;
        function calcKeepReport(first)
        {
            if (!first) {
                $('#table-keep-body tr:last').remove();
                $('#table-keep-body tr:last').remove();
            }

            var credit = $('input[name="Keep_credit[]"]');
            var debit = $('input[name="Keep_debit[]"]');

            sum_credit = 0;
            sum_debit = 0;
            for (var i=0;i<credit.length;i++) {
                if (credit[i] != "") sum_credit += credit[i].value==""?0:parseFloat(credit[i].value.replaceAll(",",""));
                if (debit[i] != "") sum_debit += debit[i].value==""?0:parseFloat(debit[i].value.replaceAll(",",""));
            }
            
            var report_html = "";
            report_html = "<tr><td class='sub-small-header disable-td'></td><td class='sub-small-header disable-td'></td><td class='sub-small-header disable-td'></td><td class='sub-small-header disable-td'></td><td class='sub-small-header style-normal-header text-center'>合计</td><td class='style-normal-header sub-small-header text-center disable-td' style='color:" + (currency=="$"?"#026fcd":"red") + "'>" + currency + "</td><td class='style-normal-header sub-small-header text-right disable-td' style='padding:5px!important;'>" + (sum_credit==0?"":prettyValue(sum_credit)) + "</td><td class='style-normal-header sub-small-header text-right disable-td' style='padding:5px!important;'>" + (sum_debit==0?"":prettyValue(sum_debit)) + "</td></tr>";
            $('#table-keep-body').append(report_html);
            report_html = "<tr><td class='sub-small-header disable-td'></td><td class='sub-small-header disable-td'></td><td class='sub-small-header disable-td'></td><td class='sub-small-header disable-td'></td><td class='sub-small-header style-normal-header text-center'>记账金额</td><td class='style-normal-header sub-small-header text-center disable-td' style='color:" + (currency=="$"?"#026fcd":"red") + "'>" + currency + "</td>";
            report_html += '<td><input type="text" class="form-control ' + (sum_credit>=0?'style-blue-input':'style-red-input') + '" name="sum_credit" value="' + "" + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off"></td>';
            report_html += '<td><input type="text" class="form-control style-black-input style-normal-input" name="sum_debit" value="' + "" + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off"></td>';
            report_html += "</tr>";
            $('#table-keep-body').append(report_html);
            $('#keep-list-datetime').val(datetime);
            setEvents();
        }

        var books = [];
        
        $('#btnOK').on('click', function() {
            rate = $('#keep_rate').val();
            if (rate == "" || (parseFloat(rate) <= 0)) {
                $('#keep_rate').focus();
                return;
            }
            pay_type = $('#pay_type').val();
            account_type = $('#account_type').val();
            if (account_type == 0) {
                //alert("There are no account informations.");
                alert("Please select account information.");
                return;
            }
            //else console.log(account_type);
            account_name = $('#account_type option:selected').text();

            datetime = $("#keep-list-datetime").val();

            if (datetime == "") {
                $("#keep-list-datetime").focus();
                return;
            }

            if ($('[name="sum_debit"]').val() == "" && $('[name="sum_credit"]').val() == "") {
                $('[name="sum_credit"]').focus();
                return;
            }

            var confirmationMessage = 'Are you sure you to apply?';
            alertAudio();
            bootbox.confirm(confirmationMessage, function (result) {
                if (!result) {
                    return;
                }
                else {
                    window.localStorage.setItem("rate",rate);
                    window.localStorage.setItem("pay_type",pay_type);
                    //window.localStorage.setItem("account_type",account_type);

                    var book_list = document.getElementById('list-book-body');
                    var keep_list = document.getElementById('table-keep-body');
                    
                    var new_book_no = parseInt($('#keep-list-bookno').val().replaceAll("J-",""));
                    if (new_book_no == (book_no+1)) {
                        book_no = book_no + 1;
                        new_book_no = book_no;
                    }
                    else {
                    }

                    for (var i=books.length-1;i>=0;i--)
                    {
                        if (books[i].no == new_book_no) {
                            books.splice(i,1);
                            //break;
                        }
                    }

                    var ship_no = "";
                    var content = "";
                    var report_id = "";
                    var obj = "";
                    var report_ids = [];
                    for(var i = 0 ; i < keep_list.rows.length ; i++) 
                    {
                        var book_id = keep_list.rows[i].getAttribute('data-ref');
                        
                        if (book_id != null)
                        {
                            if (ship_no == "") ship_no = keep_list.rows[i].getAttribute('ship-no');
                            if (content == "") content = keep_list.rows[i].childNodes[4].childNodes[0].value;
                            if (report_id == "") report_id = keep_list.rows[i].getAttribute('report-id');
                            report_ids.push(report_id = keep_list.rows[i].getAttribute('report-id'));

                            if (obj == "") obj = keep_list.rows[i].childNodes[1].innerText;
                            book_list.rows[book_id].childNodes[2].childNodes[0].value = "J-" + new_book_no;
                            book_list.rows[book_id].childNodes[2].childNodes[0].className = "form-control style-red-input";
                            
                            book_list.rows[book_id].childNodes[7].childNodes[0].value = keep_list.rows[i].childNodes[4].childNodes[0].value;
                            book_list.rows[book_id].childNodes[9].childNodes[0].value = keep_list.rows[i].childNodes[6].childNodes[0].value;
                            book_list.rows[book_id].childNodes[10].childNodes[0].value = keep_list.rows[i].childNodes[7].childNodes[0].value;
                            book_list.rows[book_id].childNodes[11].childNodes[0].value = formatRate(rate);
                            $(book_list.rows[book_id].childNodes[9].childNodes[0]).trigger('change');
                            $(book_list.rows[book_id].childNodes[10].childNodes[0]).trigger('change');
                            //$('#table-keep-body').html('');
                        }
                    }
                    setState(false);
                    $('#btnInit').attr('disabled', true);

                    var input_sum_credit = $('[name="sum_credit"]').val().replaceAll(",","");
                    var input_sum_debit = $('[name="sum_debit"]').val().replaceAll(",","");
                    if (input_sum_credit == "") input_sum_credit = 0;
                    if (input_sum_debit == "") input_sum_debit = 0;

                    //console.log(input_sum_credit, ",", input_sum_debit);
                    //var new_item = {no:new_book_no, ship_no:ship_no, ship_name:obj, report_id:report_ids, content:content, datetime:datetime, rate:rate, pay_type:pay_type, account_type:account_type, account_name:account_name, currency:(currency=="$"?1:0), credit:sum_credit, debit:sum_debit };
                    var new_item = {no:new_book_no, ship_no:ship_no, ship_name:obj, report_id:report_ids, content:content, datetime:datetime, rate:rate, pay_type:pay_type, account_type:account_type, account_name:account_name, currency:(currency=="$"?1:0), credit:input_sum_credit, debit:input_sum_debit };

                    // ?
                    for (var i=books.length-1;i>=0;i--)
                    {
                        if (books[i].no == new_book_no) {
                            books.splice(i,1);
                            //break;
                        }
                    }
                    //

                    books.push(new_item);
                    $('#keep_list').val(JSON.stringify(books));
                    setEvents();
                }
            });
        })

        $('#btnCancel').on('click', function() {
            var confirmationMessage = 'Are you sure you to cancel?';
            alertAudio();
            bootbox.confirm(confirmationMessage, function (result) {
                if (!result) {
                    return;
                }
                else {
                    clearList();
                }
            });
        })

        $('#select-year').on('change', function() {
            var prevYear = $('#select-year').val();
            $('#select-year').val(year);
            var newForm = $form.serialize();
            newForm = newForm.replaceAll(/select-year\=|[0-9]/gi,'');
            newForm = newForm.replaceAll(/select-month\=|[0-9]/gi,'');
            if ((newForm !== origForm) && (origForm != "") && !submitted) {
                var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
                alertAudio();
                bootbox.confirm(confirmationMessage, function (result) {
                    if (!result) {
                        return;
                    }
                    else {
                        $('#select-year').val(prevYear);
                        changeYear(0);
                    }
                });
            }
            else {
                $('#select-year').val(prevYear);
                changeYear(0);
            }
        });

        $('#select-water-year').on('change', function() {
            changeYear(1);
        });
        
        $('#keep_rate').on('keyup', function(evt) {
            $(evt.target).val(evt.target.value.replaceAll(/(\.\d{4})\d+/g, '$1'));
        });

        $('#keepTab').on('click', function() {
            alert("input Enabled");
        });

        function changeMonth() {
            month = $("#select-month option:selected").val();
            selectInfo();
        }

        function changeWaterMonth() {
            month_water = $("#select-water-month option:selected").val();
            selectWaterInfo();
        }

        function changeWaterShip() {
            ship_name = $("#ship_name option:selected").val();
            selectWaterInfo();
        }

        function setEvents() {
            $('.style-blue-input,.style-red-input').on('change', function(evt) {
                if (evt.target.value == '') return;
                var val = evt.target.value.replaceAll(',','');
                if (val >= 0)
                {
                    $(evt.target).removeClass("style-red-input");
                    $(evt.target).addClass("style-blue-input");
                }
                else
                {
                    $(evt.target).removeClass("style-blue-input");
                    $(evt.target).addClass("style-red-input");
                }
                $(evt.target).val(prettyValue(val));
            })
            $('.style-normal-input').on('change', function(evt) {
                if (evt.target.value == '') return;
                var val = evt.target.value.replaceAll(',','');
                if (val >= 0)
                {
                    $(evt.target).removeClass("style-red-input");
                    $(evt.target).addClass("style-normal-input");
                }
                else
                {
                    $(evt.target).removeClass("style-normal-input");
                    $(evt.target).addClass("style-red-input");
                }
                $(evt.target).val(prettyValue(val));
            })
            $('.style-blue-input,.style-red-input').on('keypress', function(e) {
                if (e.which != 46 && e.which != 45 && e.which != 46 && !(e.which >= 48 && e.which <= 57)) {
                    return false;
                }
            })

            $('.keep_credit').on('change', function(evt) {
                var parent = $(evt.target).parent().parent();
                parent.find('[name="Keep_debit[]"]').val("");
                calcKeepReport(false);
            })

            $('.keep_debit').on('change', function(evt) {
                var parent = $(evt.target).parent().parent();
                parent.find('[name="Keep_credit[]"]').val("");
                calcKeepReport(false);
            })

            $('[name="sum_credit"').on('change', function(evt) {
                $('[name="sum_debit"]').val("");
            })

            $('[name="sum_debit"').on('change', function(evt) {
                $('[name="sum_credit"]').val("");
            })

            $('.style-red-input[name="book_no[]"]').unbind().click(function(evt) {
                var selected_bookno = evt.target.value.replaceAll("J-","");
                if (selected_bookno != '') {
                    for (var k=books.length-1;k>=0;k--)
                    {
                        if (books[k].no == selected_bookno)
                        {
                            var rows_to_remove = $('.style-red-input').parent().parent();
                            var count = 0;
                            $('#table-keep-body').html('');
                            clearSelection();

                            for (var i=0;i<rows_to_remove.length;i++)
                            {
                                if (rows_to_remove[i].childNodes[2].firstElementChild.value == evt.target.value)
                                {
                                    rows_to_remove[i].childNodes[0].childNodes[0].checked = true;

                                    var row_html = '';
                                    var credit_text = rows_to_remove[i].childNodes[9].childNodes[0].value;
                                    var credit = credit_text.replaceAll(",","");
                                    var debit_text = rows_to_remove[i].childNodes[10].childNodes[0].value;
                                    var debit = debit_text.replaceAll(",","");
                                    var index = $('#list-book-body tr').index($(rows_to_remove[i]).closest("tr"));

                                    row_html = "<tr data-ref='" + index + "' ship-no='" + rows_to_remove[i].childNodes[0].childNodes[2].value + "'";
                                    row_html += " report-id='" + rows_to_remove[i].childNodes[0].childNodes[1].value + "'><td class='text-center disable-td no-padding'>" + rows_to_remove[i].childNodes[1].innerText + "</td><td class='text-center disable-td no-padding'>"+ rows_to_remove[i].childNodes[4].innerText + "</td><td class='text-center disable-td no-padding'>" + rows_to_remove[i].childNodes[5].innerText + "</td><td class='text-center disable-td no-padding'>" + rows_to_remove[i].childNodes[6].innerText + "</td><td>";
                                    row_html += '<input type="text" class="form-control" name="Keep_Remark[]" value="' + rows_to_remove[i].childNodes[7].childNodes[0].value + '" style="width: 100%;" autocomplete="off">';
                                    row_html += "</td><td class='text-center disable-td no-padding' style='color:" + (rows_to_remove[i].childNodes[8].innerText=="$"?"#026fcd":"red") + "'>" + rows_to_remove[i].childNodes[8].innerText + "</td><td>";
                                    if (credit >= 0)
                                        row_html += '<input type="text" class="form-control style-blue-input keep_credit" name="Keep_credit[]" value="' + credit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td><td>";
                                    else
                                        row_html += '<input type="text" class="form-control style-red-input keep_credit" name="Keep_credit[]" value="' + credit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td><td>";

                                    if (debit >= 0)
                                        row_html += '<input type="text" class="form-control style-normal-input keep_debit" name="Keep_debit[]" value="' + debit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td>";
                                    else
                                        row_html += '<input type="text" class="form-control style-red-input keep_debit" name="Keep_debit[]" value="' + debit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td>";
                                    row_html += "</tr>";
                                    
                                    $('#table-keep-body').append(row_html);
                                    count ++;
                                }
                            }
                            if (count != 0)
                            {
                                calcKeepReport(true);
                                setState(false);
                                $('#keep-list-bookno').val(evt.target.value);
                                $('#keep-list-datetime').val(books[k].datetime);
                                $('#keep_rate').val(books[k].rate);
                                $('#pay_type').val(books[k].pay_type);
                                $('#account_type').val(books[k].account_type);

                                $('[name="sum_credit"]').val(books[k].credit==0?"":prettyValue(books[k].credit));
                                $('[name="sum_debit"]').val(books[k].debit==0?"":prettyValue(books[k].debit));
                            }
                        }
                    }
                    origForm = $form.serialize();
                    origForm = origForm.replaceAll(/select-year\=|[0-9]/gi,'');
                    origForm = origForm.replaceAll(/select-month\=|[0-9]/gi,'');
                }
            })

            $('.style-blue-input[name="book_no[]"]').unbind().click(function(evt) {
                var selected_bookno = evt.target.value.replaceAll("J-","");
                if (selected_bookno != '') {
                    $.ajax({
                        url: BASE_URL + 'ajax/finance/waters/find',
                        type: 'POST',
                        data: {'book_no':selected_bookno},
                        success: function(books) {
                            if (books == 0) return;
                            var rows_to_remove = $('.style-blue-input[name="book_no[]"]').parent().parent();
                            var count = 0;
                            $('#table-keep-body').html('');
                            clearSelection();

                            for (var i=0;i<rows_to_remove.length;i++)
                            {
                                if (rows_to_remove[i].childNodes[2].firstElementChild.value == evt.target.value)
                                {
                                    rows_to_remove[i].childNodes[0].childNodes[0].checked = true;

                                    var row_html = '';
                                    var credit_text = rows_to_remove[i].childNodes[9].childNodes[0].value;
                                    var credit = credit_text.replaceAll(",","");
                                    var debit_text = rows_to_remove[i].childNodes[10].childNodes[0].value;
                                    var debit = debit_text.replaceAll(",","");
                                    var index = $('#list-book-body tr').index($(rows_to_remove[i]).closest("tr"));

                                    row_html = "<tr data-ref='" + index + "' ship-no='" + rows_to_remove[i].childNodes[0].childNodes[2].value + "'";
                                    row_html += " report-id='" + rows_to_remove[i].childNodes[0].childNodes[1].value + "'><td class='text-center disable-td no-padding'>" + rows_to_remove[i].childNodes[1].innerText + "</td><td class='text-center disable-td no-padding'>"+ rows_to_remove[i].childNodes[4].innerText + "</td><td class='text-center disable-td no-padding'>" + rows_to_remove[i].childNodes[5].innerText + "</td><td class='text-center disable-td no-padding'>" + rows_to_remove[i].childNodes[6].innerText + "</td><td>";
                                    row_html += '<input type="text" class="form-control" name="Keep_Remark[]" value="' + rows_to_remove[i].childNodes[7].childNodes[0].value + '" style="width: 100%;" autocomplete="off">';
                                    row_html += "</td><td class='text-center disable-td no-padding' style='color:" + (rows_to_remove[i].childNodes[8].innerText=="$"?"#026fcd":"red") + "'>" + rows_to_remove[i].childNodes[8].innerText + "</td><td>";
                                    if (credit >= 0)
                                        row_html += '<input type="text" class="form-control style-blue-input keep_credit" name="Keep_credit[]" value="' + credit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td><td>";
                                    else
                                        row_html += '<input type="text" class="form-control style-red-input keep_credit" name="Keep_credit[]" value="' + credit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td><td>";

                                    if (debit >= 0)
                                        row_html += '<input type="text" class="form-control style-normal-input keep_debit" name="Keep_debit[]" value="' + debit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td>";
                                    else
                                        row_html += '<input type="text" class="form-control style-red-input keep_debit" name="Keep_debit[]" value="' + debit_text + '" style="width: 100%;text-align:right;margin-right:5px;" autocomplete="off">' + "</td>";
                                    row_html += "</tr>";
                                    
                                    $('#table-keep-body').append(row_html);
                                    count ++;
                                }
                            }
                            if (count != 0)
                            {
                                calcKeepReport(true);
                                setState(true);
                                $('#btnInit').attr('disabled', false);
                                $('#keep-list-bookno').val(evt.target.value);
                                $('#keep-list-datetime').val(books.register_time);
                                $('#keep_rate').val(books.rate.toFixed(4));
                                $('#pay_type').val(books.pay_type);
                                $('#account_type').val(books.account_type);

                                $('[name="sum_credit"]').val(books.credit==0?"":prettyValue(books.credit));
                                $('[name="sum_debit"]').val(books.debit==0?"":prettyValue(books.debit));
                            }
                            origForm = $form.serialize();
                            origForm = origForm.replaceAll(/select-year\=|[0-9]/gi,'');
                            origForm = origForm.replaceAll(/select-month\=|[0-9]/gi,'');
                            return;
                        },
                        error: function(error) {
                        }
                    });
                }
            })

            $('body').on('keydown', 'input', function(e) {
                if (e.key === "Enter") {
                    var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                    focusable = form.find('input').filter(':visible');
                    next = focusable.eq(focusable.index(this)+1);
                    if (next.length) {
                        next.focus();
                        next.select();
                    }
                    //return false;
                    $('#btn_OK').focus();
                }
            });

            $('body').on('click', function(e) {
                if (($(e.target).attr('class') != 'form-control content') && (e.target.id != "remark-box")) {
                    $('#remark-box').val('');
                    $('#remark-box').hide();
                }
            });

            if (isAdmin != 1) {
                $('.keep_credit').attr('readonly', 'true');
                $('.keep_debit').attr('readonly', 'true');
                //$('[name="sum_credit"]').attr('readonly', 'true');
                //$('[name="sum_debit"]').attr('readonly', 'true');
            }
        }

        $('#select-month').on('change', function() {
            var prevMonth = $('#select-month').val();
            $('#select-month').val(month);
            var newForm = $form.serialize();
            newForm = newForm.replaceAll(/select-year\=|[0-9]/gi,'');
            newForm = newForm.replaceAll(/select-month\=|[0-9]/gi,'');

            if ((newForm !== origForm) && (origForm != "") && !submitted && ACTIVE_TAB != "#tab_water") {
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

        $('#select-water-month').on('change', function() {
            changeWaterMonth();
        });

        $('#ship_name').on('change', function() {
            changeWaterShip();
        });

        var submitted = false;
        $("#btnSave").on('click', function() {
            //origForm = $form.serialize();
            submitted = true;
            var rows_to_send = document.getElementById('list-book-body').rows;
            if (rows_to_send.length > 0) {
                if (rows_to_send.length == 1) {
                    if (rows_to_send[0].innerHTML.indexOf('No matching records found') >= 0) return;
                }
                
                //$('#books-form').submit();
                let form = $('#books-form').serialize();
                $('#btnKeep').attr('disabled', true);
                $('#btnOK').attr('disabled', true);
                $('#btnCancel').attr('disabled', true);
                $('#btnSave').attr('disabled', true);
                $('#btnInit').attr('disabled', true);
                
                setUpdateRows();
                clearSelection();
                $.post('books/save', form).done(function (data) {
                    let result = data;
                    if (result == 1) {
                        $('#keep_list').val('');
                        $('#btnSave').attr('disabled', false);
                        
                        clearList();
                        
                        books = [];
                    }
                    else {
                        alert('保存失败了。');
                        //location.reload();
                        return;
                    }
                });
                
                $('td[style*="display: none;"]').remove();
            }
        });

        function setUpdateRows()
        {
            $('#list-book-body .style-red-input').parent().parent().find('[type="checkbox"]').attr("disabled", "true");
            $('#list-book-body .style-red-input').parent().parent().find('[type="checkbox"]').attr("class", "");
            $('#list-book-body .style-red-input').parent().parent().find('[type="checkbox"]').prop("checked", true);
            $('#list-book-body .style-red-input').attr("class","form-control style-blue-input");
            setEvents();
        }

        function clearSelection()
        {
            $('input.need_chk:checked').prop("checked", false);
        }

        var $form = $('form');
        var origForm = "";
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
            var newForm = $form.serialize();
            newForm = newForm.replaceAll(/select-year\=|[0-9]/gi,'');
            newForm = newForm.replaceAll(/select-month\=|[0-9]/gi,'');

            if ((newForm !== origForm) && !submitted && ACTIVE_TAB != "#tab_water") {
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });

        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

        function init()
        {
            var init_book_no = parseInt($('#keep-list-bookno').val().replaceAll("J-",""))
            var msg = "Are you sure you want to initialize all data(" + $('#keep-list-bookno').val() + ")?";
            alertAudio();
            bootbox.confirm(msg, function (result) {
                if (result) {
                    $.ajax({
                        url: BASE_URL + 'ajax/finance/books/init',
                        type: 'POST',
                        data: {'book_no':init_book_no},
                        success: function(result) {
                            $.gritter.add({
                                title: '成功',
                                text: '初始化成功!',
                                class_name: 'gritter-success'
                            });
                            location.reload();
                            return;
                        },
                        error: function(error) {
                        }
                    });
                }
            });
        }

        function fnExcelReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-books-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='11' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_info').html() + "记账簿</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[4].style.width = '60px';
                    tab.rows[j].childNodes[5].style.width = '60px';
                    tab.rows[j].childNodes[7].style.width = '300px';
                    tab.rows[j].childNodes[8].style.width = '40px';
                    
                }
                else
                {
                    var info = real_tab.rows[j].childNodes[2].childNodes[0].value;
                    tab.rows[j].childNodes[2].innerHTML = info;
                    info = real_tab.rows[j].childNodes[7].childNodes[0].value;
                    tab.rows[j].childNodes[7].innerHTML = info;
                    info = real_tab.rows[j].childNodes[9].childNodes[0].value;
                    tab.rows[j].childNodes[9].innerHTML = info;
                    info = real_tab.rows[j].childNodes[10].childNodes[0].value;
                    tab.rows[j].childNodes[10].innerHTML = info;
                    info = real_tab.rows[j].childNodes[11].childNodes[0].value;
                    tab.rows[j].childNodes[11].innerHTML = info;
                }
                tab.rows[j].childNodes[0].remove();
                tab.rows[j].childNodes[11].remove();
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = year + '_' + month.padStart(2,'0') + '_记账簿';
            exportExcel(tab_text, filename, year + '_' + month + '_记账簿');
            
            return 0;
        }

        /*
        function showRemark(remark) {
            alert(remark);
            if ((remark != 'null') && (remark != '') && (remark != null)) {
                $('#remark-box').val(remark);
                $('#remark-box').show();
            } else {
                $('#remark-box').val('');
                $('#remark-box').hide();
            }
        }
        */
        function showRemark(evt) {
            var tr_ = $(evt).closest("td");
            var remark = $(tr_).attr('remark');
            if ((remark != 'null') && (remark != '') && (remark != null)) {
                $('#remark-box').val(remark);
                $('#remark-box').show();
            } else {
                $('#remark-box').val('');
                $('#remark-box').hide();
            }
        }

        function fnExcelWaterReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-water-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='10' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_water_info').html() + "流水账</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[2].style.width = '60px';
                    tab.rows[j].childNodes[3].style.width = '300px';
                    tab.rows[j].childNodes[4].style.width = '40px';
                    tab.rows[j].childNodes[5].style.width = '150px';
                    tab.rows[j].childNodes[6].style.width = '150px';
                    tab.rows[j].childNodes[10].remove();
                }
                else if(j >= (tab.rows.length - 4))
                {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.height = "30px";
                        tab.rows[j].childNodes[i].style.fontWeight = "bold";
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[9].remove();
                    //tab.rows[j].childNodes[9].colSpan="1";
                }
                else
                {
                    info = real_tab.rows[j].childNodes[5].childNodes[0].value;
                    tab.rows[j].childNodes[5].innerHTML = info;
                    info = real_tab.rows[j].childNodes[6].childNodes[0].value;
                    tab.rows[j].childNodes[6].innerHTML = info;
                    tab.rows[j].childNodes[10].remove();
                }
                
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = year_water + '_' + month_water.padStart(2,'0') + '_流水账';
            exportExcel(tab_text, filename, year_water + '_' + month_water + '_流水账');
            
            return 0;
        }

        var ACTIVE_TAB = "tab_book";
        $(function () {
            $('ul li a[data-toggle=tab]').click(function(){
                $nowTab = $(this).attr("href");
                ACTIVE_TAB = $nowTab;
                //window.localStorage.setItem("accountsTab",$nowTab);
            });
        });
        
    </script>

@endsection
