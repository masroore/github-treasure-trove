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
                background-color: #f5f5f5;
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
        <form id="wage-form" action="updateWageSendInfo" role="form" method="POST" enctype="multipart/form-data">
            <div class="space-4"></div>
            <div class="col-md-12">
                <div class="row">
                    <div class="tabbable">
                        <ul class="nav nav-tabs ship-register for-pc" id="memberTab">
                            <li class="active">
                                <a data-toggle="tab" href="#wage_ship">
                                    工资(船舶)
                                </a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#wage_member">
                                    工资(海员)
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="wage_ship" class="tab-pane active">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>船舶工资</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-7" style="align-content: flex-end;display: flex;">
                                        <label class="custom-label d-inline-block for-pc" style="padding: 6px;"><b>船名:</b></label>
                                        <select class="custom-select d-inline-block" name="select-ship" id="select-ship" style="width:80px">
                                            @foreach($shipList as $ship)
                                                <option value="{{ $ship['IMO_No'] }}" @if(isset($shipId) && ($shipId == $ship['IMO_No'])) selected @endif>{{$ship['NickName']}}</option>
                                            @endforeach
                                        </select>
                                        <select name="select-year" id="select-year" style="font-size:13px">
                                            @for($i=$start_year;$i<=date("Y");$i++)
                                            <option value="{{$i}}" @if((isset($year) && ($year == $i)) || (date("Y")==$i))selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6" style="margin-top:4px;">
                                        <div id="item-manage-dialog" class="hide"></div>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="head-fix-div common-list" id="crew-table" style="">
                                            <table id="table-shipwage-list" style="table-layout:fixed;">
                                                <thead class="">
                                                    <th class="text-center style-normal-header" style="width: 10%;height:35px;"><span>月份</span></th>
                                                    <th class="text-center style-normal-header" style="width: 40%;">家汇款<br><span style="color:red">(¥)</span></th>
                                                    <th class="text-center style-normal-header" style="width: 40%;">家汇款<br><span style="color:#1565C0">($)</span></th>
                                                    <th class="text-center style-normal-header for-pc" style="width: 10%;"><span>详细</span></th>
                                                </thead>
                                                <tbody class="" id="list-ship-wage">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="wage_member" class="tab-pane">
                            <div class="page-header">
                                <div class="col-sm-3">
                                    <h4><b>海员工资</b></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-7" style="align-content: flex-end;display: flex;">
                                        <label class="custom-label d-inline-block" style="padding: 6px;"><b>姓名: </b></label><input type="text" class="typeahead" id="search-name" autocomplete="off"/>
                                        <select class="custom-select d-inline-block" name="select-member-year" id="select-member-year" style="font-size:13px;margin-left:2px;">
                                            @for($i=$start_year;$i<=date("Y");$i++)
                                            <option value="{{$i}}" @if((isset($year) && ($year == $i)) || (date("Y")==$i))selected @endif>{{$i}}年</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7" style="margin-top:4px;margin-left:18px;">
                                    <div class="" style="height:80px!important;" id="crew-table">
                                        <table id="table-shipmember-list" style="table-layout:fixed;">
                                            <thead class="">
                                                <th class="text-center style-normal-header" style="width: 10%;height:35px;"><span>姓名</span></th>
                                                <th class="text-center style-normal-header" style="width: 10%;"><span>船名</span></th>
                                                <th class="text-center style-normal-header" style="width: 10%;"><span>职务</span></th>
                                                <th class="text-center style-normal-header" style="width: 10%;"><span>币类</span></th>
                                                <th class="text-center style-normal-header" style="width: 10%;"><span>合约薪资</span></th>
                                                <th class="text-center style-normal-header" style="width: 10%;"><span>上船日期</span></th>
                                                <th class="text-center style-normal-header" style="width: 10%;"><span>下船日期</span></th>
                                            </thead>
                                            <tbody class="list-body">
                                                <tr class="member-item odd" role="row">
                                                    <td class="text-center style-search-header"">&nbsp;</td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-10" style="margin-left:10px;">
                                    <div class="head-fix-div common-list" id="crew-table" style="">
                                        <table id="table-memberwage-list" style="table-layout:fixed;">
                                            <thead class="">
                                                <th class="text-center style-normal-header" style="width: 5%;height:35px;"><span>月份</span></th>
                                                <th class="text-center style-normal-header" style="width: 10%;"><span>支付日期</span></th>
                                                <th class="text-center style-normal-header" style="width: 16%;">家汇款<span style="color:red">(¥)</span></th>
                                                <th class="text-center style-normal-header" style="width: 16%;">家汇款<span style="color:#1565C0">($)</span></th>
                                                <th class="text-center style-normal-header" style=""><span>银行账号</span></th>
                                                <th class="text-center style-normal-header" style="width: 7%;"><span>详细</span></th>
                                            </thead>
                                            <tbody class="" id="list-ship-wage">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>

    <script src="{{ asset('/assets/js/x-editable/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/ace-editable.min.js') }}"></script>
    <script src="{{ cAsset('assets/js/jsquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/js/dataTables.rowsGroup.js') }}"></script>
    
    <script>
        var token = '{!! csrf_token() !!}';
        var shipName = '';
        var year = '';
        var shipId;
            
        var listTable = null;
        var listTable2 = null;
        var listTable3 = null;
        function initTable() {
            listTable = $('#table-shipwage-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/shipMember/wage/shiplist',
                    type: 'POST',
                    data: { 'year':year, 'shipId':shipId},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'no', className: "text-center disable-tr"},
                    {data: 'totalR', className: "text-center"},
                    {data: 'totalD', className: "text-center"},
                    {data: null, className: "text-center for-pc"},
                ],
                createdRow: function (row, data, index) {
                    if ((index%2) == 0)
                        $(row).attr('class', 'cost-item-even');
                    else
                        $(row).attr('class', 'cost-item-odd');
                    $('td', row).eq(1).html(prettyValue(data['totalR']));
                    $('td', row).eq(2).html(prettyValue(data['totalD']));
                    if (index == 12) {
                        $('td', row).eq(0).attr('class', 'sub-small-header style-normal-header text-center');
                        $('td', row).eq(1).attr('class', 'style-normal-header style-blue-header text-center');
                        $('td', row).eq(2).attr('class', 'style-normal-header text-center');
                        $('td', row).eq(3).attr('class', 'sub-small-header style-normal-header text-center for-pc');
                        $('td', row).eq(1).html('¥ ' + prettyValue(data['totalR']));
                        $('td', row).eq(2).html('$ ' + prettyValue(data['totalD']));
                        $('td', row).eq(3).html('');
                    }
                    else
                        $('td', row).eq(3).html('').append('<div class="action-buttons"><a class="blue" onclick="javascript:showCalcWage(this)"><i class="icon-file"></i></a></div>');
                },
                drawCallback: function (response) {
                }
            });
            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        year = $("#select-year option:selected").val();
        shipId = $("#select-ship").val();
        initTable();

        function prettyValue(value)
        {
            if(value == undefined || value == null) return '';
            //return parseFloat(value).toFixed(2).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
            return _number_format(value, 2);
        }

        function selectInfo()
        {
            shipName = $("#select-ship option:selected").text();
            year = $("#select-year option:selected").val();
            if (shipName == "") return;
            if (listTable == null) {
                initTable();
            }
            else
            {
                listTable.column(3).search(year, false, false);
                listTable.column(2).search($("#select-ship").val(), false, false).draw();
            }
        }
        $('#select-ship').on('change', function() {
            shipId = $('#select-ship').val();
            selectInfo();
        });

        $('#select-year').on('change', function() {
            year = $("#select-year option:selected").val();
            selectInfo();
        });

        // 海员工资
        var name = "";
        function doSearch() {
            name = $('#search-name').val();
            if (name == '') return;
            if (listTable2 == null) initTable2();
            else listTable2.column(1).search(name, false, false).draw();
        }

        function initTable2() {
            listTable2 = $('#table-shipmember-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/shipMember/searchAll',
                    type: 'POST',
                    data: { 'name':name},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'name', className: "text-center"},
                    {data: 'ship', className: "text-center"},
                    {data: 'rank', className: "text-center"},
                    {data: 'currency', className: "text-center"},
                    {data: 'salary', className: "text-center"},
                    {data: 'dateonboard', className: "text-center"},
                    {data: 'dateoffboard', className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    $(row).attr('data-index', data['no']);
                    $('td', row).eq(0).attr('class', 'style-search-header text-center');
                    if (data['currency'] == 0) {
                        $('td', row).eq(3).html('¥');
                        $('td', row).eq(3).attr('style','color:red');    
                    }
                    else {
                        $('td', row).eq(3).html('$');
                        $('td', row).eq(3).attr('style','color:#026fcd!important');
                    }
                    $('td', row).eq(4).html(prettyValue(data['salary']));
                },
            });
            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        $('#search-name').on('keyup', function(e) {
            if (e.which == 13) {
                doSearch();
            }
        })

        $('#search-name').on('change', function(e) {
            doSearch();
        })

        var member_id = "";
        var ship_year;
        function doSearchWage() {
            if (listTable3 == null ) initTable3();
            listTable3.column(1).search(member_id, false, false);
            listTable3.column(2).search(ship_year, false, false).draw();
        }
        $('.list-body').on('click', function(evt) {
            let cell = $(evt.target).closest('td');
            if(cell.index() < 9) {
                member_id = this.firstElementChild.getAttribute('data-index');
                ship_year = $("#select-member-year option:selected").val();
                if (member_id != "" && member_id != null) {
                    doSearchWage();
                }
            }
        });

        $('#select-member-year').on('change', function() {
            ship_year = $("#select-member-year option:selected").val();
            doSearchWage();
        });

        var member_shipId;
        function initTable3() {
            listTable3 = $('#table-memberwage-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/shipMember/searchWageById',
                    type: 'POST',
                    data: { 'member_id':member_id, 'year':ship_year},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'no', className: "text-center"},
                    {data: 'purchdate', className: "text-center"},
                    {data: 'sendR', className: "text-center"},
                    {data: 'sendD', className: "text-center"},
                    {data: 'bankinfo', className: ""},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    //$(row).attr('data-index', data['no']);
                    if (index == 12) {
                        $('td', row).eq(0).attr('class', 'sub-small-header style-normal-header text-center');
                        $('td', row).eq(0).attr('colspan', '2');
                        $('td', row).eq(1).html(data['sendR']==0?'-':'¥ ' + prettyValue(data['sendR']));
                        $('td', row).eq(1).attr('class', 'style-normal-header style-blue-header text-center');
                        $('td', row).eq(2).attr('class', 'style-normal-header text-center');
                        $('td', row).eq(2).html(data['sendD']==0?'-':'$ ' + prettyValue(data['sendD']));
                        $('td', row).eq(3).attr('class', 'sub-small-header style-normal-header text-center');
                        $('td', row).eq(3).html('');
                        $('td', row).eq(4).attr('class', 'sub-small-header style-normal-header');
                        $('td', row).eq(4).html('');
                        $('td', row).eq(5).remove();
                    }
                    else {
                        if (data['purchdate'] == null || data['purchdate'] == '') {
                            $('td', row).eq(1).html('');
                        } else {
                            $('td', row).eq(1).html(data['purchdate'].substr(0,10));
                        }
                        $('td', row).eq(2).html(prettyValue(data['sendR']));
                        $('td', row).eq(2).attr('class', 'style-blue-header text-center');
                        $('td', row).eq(2).html(data['sendR']==0?'':prettyValue(data['sendR']));
                        $('td', row).eq(3).html(data['sendD']==0?'':prettyValue(data['sendD']));
                        $('td', row).eq(5).html('').append('<div class="action-buttons"><a class="blue" onclick="javascript:showSendWage(this)"><i class="icon-file"></i></a></div>');
                    }
                },
                drawCallback: function (response) {
                    member_shipId = response.json.member_shipid;
                }
            });
            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }

        function showCalcWage(evt) {
            var _tr = evt.closest('tr');
            var _shipid = $("#select-ship").val();
            var _year = $('#select-year').val();
            var _month = _tr.firstElementChild.innerHTML;
            window.open(BASE_URL + 'shipMember/wagesCalcReport?shipId=' + _shipid + '&year=' + _year + '&month=' + _month, '_blank');
        }

        function showSendWage(evt) {
            var _tr = evt.closest('tr');
            var _shipid = member_shipId;
            var _year = $('#select-member-year').val();
            var _month = _tr.firstElementChild.innerHTML;
            window.open(BASE_URL + 'shipMember/wagesSendReport?shipId=' + member_shipId + '&year=' + _year + '&month=' + _month, '_blank');
        }
    </script>

    <script type="text/javascript">
        var path=BASE_URL + 'ajax/shipMember/autocompleteAll';
        $('input.typeahead').typeahead({
            source:function(terms,process){
                return $.get(path,{terms:terms},function(data){
                    return process(data);
                })
            }
        });
    </script>

@endsection
