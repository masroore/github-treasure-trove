@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
?>

@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    <div class="main-content">
        <style>
            .member-item-odd {
                background-color: #f5f5f5!important;
                height:20px;
            }

            .member-item-even {
                background-color: white!important;
                height:20px;
            }
            
            .member-item-even:hover {
                background-color: #ffe3e082!important;
                height:20px;
            }

            .member-item-odd:hover {
                background-color: #ffe3e082!important;
                height:20px;
            }
        </style>
        <div class="page-content">
            <div class="space-4"></div>
                <div class="col-md-12 full-width sp-p0">
                    <div class="row">
                        <div class="tabbable">
                            <ul class="nav nav-tabs ship-register for-pc" id="memberTab">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab_crew_list">
                                        CREW LIST
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab_all_list">
                                        船员名单
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content full-width">
                            <div id="tab_crew_list" class="tab-pane active">
                                <div class="page-header">
                                    <div class="col-sm-3">
                                        <h4><b>CREW LIST</b></h4>
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:40px">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="custom-label d-inline-block font-bold for-pc" style="padding: 6px;">船名:</label>
                                            <select class="custom-select d-inline-block" id="select-ship" style="width:80px">
                                                @foreach($shipList as $ship)
                                                    <option value="{{ $ship['IMO_No'] }}" data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                                                @endforeach
                                            </select>
                                            <strong class="f-right for-pc" style="font-size: 16px; padding-top: 6px;"><span id="ship_name"></span> CREW LIST</strong>
                                        </div>
                                        <div class="col-md-6 for-pc">
                                            <div class="btn-group f-right">
                                                <button class="btn btn-warning btn-sm excel-btn" id="btn_export_list"><i class="icon-table"></i>{{ trans('common.label.excel') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 full-width" style="margin-top:4px;">
                                        <div id="item-manage-dialog" class="hide"></div>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="row">
                                            <div class="head-fix-div common-list" id="crew-table" style="">
                                                <div class="">
                                                    <table id="table-shipmember-list" class="not-striped" style="width:100%;">
                                                        <thead class="">
                                                            <th class="text-center style-header" style="width: 3%;"><span>No</span></th>
                                                            <th class="text-center style-header" style="width: 12%;"><span>Family Name, Given Name</span></th>
                                                            <th class="text-center style-header" style="width: 4%;"><span>Rank</span></th>
                                                            <th class="text-center style-header" style="width: 9%;"><span>Nationality</span></th>
                                                            <th class="text-center style-header" style="width: 12%;"><span>Chinese ID No.</span></th>
                                                            <th class="text-center style-header" style="width: 15%;"><span>Date and place of birth</span></th>
                                                            <th class="text-center style-header" style="width: 15%;"><span>Date and place of embarkation</span></th>
                                                            <th class="text-center style-header" style="width: 15%;"><span>Seaman's Book No and Expire Date</span></th>
                                                            <th class="text-center style-header" style="width: 15%"><span>Passport's No and Expire Date</span></th>
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
                            <div id="tab_all_list" class="tab-pane">
                                <div class="page-header">
                                    <div class="col-sm-3">
                                        <h4><b>船员名单</b></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label class="custom-label d-inline-block font-bold for-pc" style="padding: 6px;">船名:</label>
                                            <select class="custom-select d-inline-block" id="select-ship-total" style="width:80px">
                                                @foreach($shipList as $ship)
                                                    <option value="{{ $ship['IMO_No'] }}" data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                                                @endforeach
                                            </select>
                                            <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="ship_name_total"></span> 船员名单</strong>
                                        </div>
                                        <div class="col-md-6" style="padding:unset!important">
                                            <div class="btn-group f-right">
                                                <button class="btn btn-warning btn-sm excel-btn" id="btn_export_total"><i class="icon-table"></i>{{ trans('common.label.excel') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top:4px;">
                                        <div id="item-manage-dialog-total" class="hide"></div>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="row" style="margin-bottom:40px">
                                            <div class="head-fix-div common-list" id="total-table" style="">
                                                <table id="table-shipmember-list-total" style="table-layout:fixed;">
                                                    <thead class="">
                                                        <th class="text-center style-header" style="width: 2%;"><span>No</span></th>
                                                        <th class="text-center style-header" style="width: 6%;"><span>姓名</span></th>
                                                        <th class="text-center style-header" style="width: 3%;"><span>职务</span></th>
                                                        <th class="text-center style-header" style="width: 7%;"><span>电话号码</span></th>
                                                        <th class="text-center style-header" style="width: 5%;"><span>国籍</span></th>
                                                        <th class="text-center style-header" style="width: 10%;"><span>身份证号</span></th>
                                                        <th class="text-center style-header" style="width: 5%;"><span>出生日期</span></th>
                                                        <th class="text-center style-header" style="width: 7%;"><span>籍贯</span></th>
                                                        <th class="text-center style-header" style="width: 5%;"><span>上船日期</span></th>
                                                        <th class="text-center style-header" style="width: 10%;"><span>上船港</span></th>
                                                        <th class="text-center style-header" style="width: 5%;"><span>下船日期</span></th>
                                                        <th class="text-center style-header" style="width: 5%;"><span>海员证号</span></th>
                                                        <th class="text-center style-header" style="width: 5%;"><span>海员证到期</span></th>
                                                        <th class="text-center style-header" style="width: 5%;"><span>护照号</span></th>
                                                        <th class="text-center style-header" style="width: 5%;"><span>护照到期</span></th>
                                                        <th class="text-center style-header" style=""><span>地址</span></th>
                                                    </thead>
                                                    <tbody class="" id="total-list-body">
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
        </div>
    </div>

    <script src="{{ asset('/assets/js/x-editable/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/ace-editable.min.js') }}"></script>
    <script src="{{ cAsset('assets/js/jsquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/js/dataTables.rowsGroup.js') }}"></script>
    <?php
	echo '<script>';
	echo 'var CurrencyLabel = ' . json_encode(g_enum('CurrencyLabel')) . ';';
	echo '</script>';
	?>
    <script>
        var token = '{!! csrf_token() !!}';
        var shipName = '';
        var shipName_total = '';
        $(function () {
            $.fn.editable.defaults.mode = 'inline';
            $.fn.editableform.loading = "<div class='editableform-loading'><i class='light-blue icon-2x icon-spinner icon-spin'></i></div>";
            $.fn.editableform.buttons = '';


            shipName_total = $("#select-ship-total").text();
            if (shipName_total == "") return;
            if (listTotalTable == null) initTotalTable();
            $('#ship_name_total').html('"' + $("#select-ship-total option:selected").attr('data-name') + '"');
            listTotalTable.column(1).search($("#select-ship-total" ).val(), false, false).draw();

            shipName = $("#select-ship option:selected").text();
            if (shipName == "") return;
            if (listTable == null) initTable();
            $('#ship_name').html('"' + $("#select-ship option:selected").attr('data-name') + '"');
            listTable.column(2).search($("#select-ship" ).val(), false, false);
            listTable.column(3).search('off', false, false).draw();

        });
            
        function setDatePicker() {
            $('.date-picker').datepicker({autoclose: true}).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });
        }

        var listTable = null;
        function initTable() {
            listTable = $('#table-shipmember-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: BASE_URL + 'ajax/shipMember/search',
                    type: 'POST',
                    data: {'type' : 'crew'},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'no', className: "text-center"},
                    {data: 'name', className: "text-center"},
                    {data: 'rank', className: "text-center"},
                    {data: 'nationality', className: "text-center"},
                    {data: 'cert-id', className: "text-center"},
                    {data: 'birth-and-place', className: "text-center"},
                    {data: 'date-and-embarkation', className: "text-center"},
                    {data: 'bookno-expire', className: "text-center"},
                    {data: 'passport-expire', className: "text-center"},
                ],
                rowsGroup: [0, 2, 3, 4],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();
                    
                    if((index%4)==2 || (index%4)==3)
                        $(row).attr('class', 'member-item-odd');
                    else
                    $(row).attr('class', 'member-item-even');
                    
                    //$('td', row).eq(0).html('').append((pageInfo.page * pageInfo.length + index + 1));
                    $('td', row).eq(0).html(index/2+1);
                },
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }
        $('#select-ship').on('change', function() {
            shipName = $("#select-ship option:selected").text();
            if (shipName == "") return;
            if (listTable == null) initTable();
            $('#ship_name').html('"' + $("#select-ship option:selected").attr('data-name') + '"');
            listTable.column(2).search($("#select-ship" ).val(), false, false);
            listTable.column(3).search('off', false, false).draw();

            //setRowSpanCls();
        });

        var listTotalTable = null;
        function initTotalTable() {
            listTotalTable = $('#table-shipmember-list-total').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                bAutoWidth: false, 
                ajax: {
                    url: BASE_URL + 'ajax/shipMember/listAll',
                    type: 'POST',
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: null, className: "text-center"},
                    {data: 'name', className: "text-center"},
                    {data: 'rank', className: "text-center"},
                    {data: 'phone', className: "text-center"},
                    {data: 'nationality', className: "text-center"},
                    {data: 'cert-id', className: "text-center"},
                    {data: 'birthday', className: "text-center"},
                    {data: 'birthplace', className: "text-center"},
                    {data: 'signon-date', className: "text-center"},
                    {data: 'signon-port', className: "text-center"},
                    {data: 'signoff-date', className: "text-center"},
                    {data: 'bookno', className: "text-center"},
                    {data: 'bookno-expire', className: "text-center"},
                    {data: 'passport-no', className: "text-center"},
                    {data: 'passport-expire', className: "text-center"},
                    {data: 'address', className: ""}
                ],
                createdRow: function (row, data, index) {
                    var pageInfo = listTotalTable.page.info();
                    $(row).attr('class', 'member-item');
                    $('td', row).eq(0).html('').append((pageInfo.page * pageInfo.length + index + 1));
                    if ((index%2) == 0)
                        $(row).attr('class', 'member-item-even');
                    else
                        $(row).attr('class', 'member-item-odd');
                    $('td', row).eq(11).attr('style','word-wrap:break-word');
                    $('td', row).eq(9).attr('style','padding:2px!important');
                    $('td', row).eq(15).attr('style','padding:2px!important');

                },
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }

        
        $('#select-ship-total').on('change', function() {
            shipName_total = $("#select-ship-total option:selected").text();
            if (shipName_total == "") return;
            if (listTotalTable == null) initTotalTable();
            $('#ship_name_total').html('"' + $("#select-ship-total option:selected").attr('data-name') + '"');
            listTotalTable.column(1).search($("#select-ship-total" ).val(), false, false).draw();
        });
        
        $('#btn_export_list').on('click', function() {
            $('td[style*="display: none;"]').remove();
           fnExcelReport();
        })

        function fnExcelReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-shipmember-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='9' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>CREW LIST</td></tr>";
            tab_text=tab_text+"<tr><td colspan='4' style='font-size:18px;border-bottom:hidden;'>1.Name of Ship</td><td colspan='2'style='font-size:18px;border-bottom:hidden;text-align:center;'>2.Port of Arrival</td><td colspan='3' style='font-size:18px;border-bottom:hidden;text-align:center;'>3.Date of arrival</td></tr>";
            tab_text=tab_text+"<tr><td colspan='4' style='font-size:18px;'>&nbsp;&nbsp;" + shipName + "</td><td colspan='2'style='font-size:18px;text-align:center;'>&nbsp;&nbsp;ZHENJIANG</td><td colspan='3' style='font-size:18px;text-align:center;'>&nbsp;&nbsp;2020-12-</td></tr>";
            tab_text=tab_text+"<tr><td colspan='4' style='font-size:18px;border-bottom:hidden;'>4.Nationality of Ship</td><td colspan='2'style='font-size:18px;border-bottom:hidden;text-align:center;'>5.LAST Port of Call</td><td colspan='3' style='font-size:18px;border-bottom:hidden;'></td></tr>";
            tab_text=tab_text+"<tr><td colspan='4' style='font-size:18px;'>&nbsp;&nbsp;CHINA</td><td colspan='2'style='font-size:18px;text-align:center;'>&nbsp;&nbsp;DONGHAE</td><td colspan='3' style='font-size:18px;'></td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        if (i == 0) {
                        }
                        else if (i == 1) {
                            tab.rows[j].childNodes[i].style.width = '140px';
                        }
                        else if (i == 2) {
                            tab.rows[j].childNodes[i].style.width = '60px';
                        }
                        else if (i == 4) {
                            tab.rows[j].childNodes[i].style.width = '160px';
                        }
                        else if (i == 5) {
                            tab.rows[j].childNodes[i].style.width = '200px';
                        }
                        else if (i == 6) {
                            tab.rows[j].childNodes[i].style.width = '200px';
                        }
                        else
                        {
                            tab.rows[j].childNodes[i].style.width = '100px';
                        }
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                }
                else
                {
                    tab.rows[j].childNodes[4].innerHTML = '="' + tab.rows[j].childNodes[4].innerHTML + '"';
                    if (j%2 == 1) tab.rows[j].childNodes[7].innerHTML = '="' + tab.rows[j].childNodes[7].innerHTML + '"';
                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                }
            }

            tab_text=tab_text+"</table>";
            //tab_text='<table border="2px" style="text-align:center;vertical-align:middle;"><tr><th class="text-center sorting_disabled" style="width: 78px;text-align:center;vertical-align:center;" rowspan="1" colspan="1"><span>No</span></th></tr><tr style="width: 78px;text-align:center;vertical-align:middle;"><td class="text-center sorting_disabled" rowspan="2" style="">你好</td></tr></table>';
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,""); // remove if u want images in your table
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

            //document.getElementById('test').innerHTML = tab_text;
            var filename = 'CREW LIST(' + shipName + ')';
            exportExcel(tab_text, filename, 'CREW LIST');
            return 0;
        }

        $('#btn_export_total').on('click', function() {
            $('td[style*="display: none;"]').remove();
            fnExcelTotalReport();
        })

        function fnExcelTotalReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-shipmember-list-total');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='16' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>船员名单</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        if (i == 0) {
                        }
                        else if (i == 1) {
                            tab.rows[j].childNodes[i].style.width = '140px';
                        }
                        else if (i == 2) {
                            tab.rows[j].childNodes[i].style.width = '60px';
                        }
                        else if (i == 4) {
                            tab.rows[j].childNodes[i].style.width = '160px';
                        }
                        else if (i == 5) {
                            tab.rows[j].childNodes[i].style.width = '200px';
                        }
                        else if (i == 6) {
                            tab.rows[j].childNodes[i].style.width = '200px';
                        }
                        else if (i == 15) {
                            tab.rows[j].childNodes[i].style.width = '500px';
                        }
                        else
                        {
                            tab.rows[j].childNodes[i].style.width = '100px';
                        }
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                }
                else
                {
                    tab.rows[j].childNodes[5].innerHTML = '="' + tab.rows[j].childNodes[5].innerHTML + '"';
                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                }
            }

            tab_text=tab_text+"</table>";
            //tab_text='<table border="2px" style="text-align:center;vertical-align:middle;"><tr><th class="text-center sorting_disabled" style="width: 78px;text-align:center;vertical-align:center;" rowspan="1" colspan="1"><span>No</span></th></tr><tr style="width: 78px;text-align:center;vertical-align:middle;"><td class="text-center sorting_disabled" rowspan="2" style="">你好</td></tr></table>';
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,""); // remove if u want images in your table
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

            //document.getElementById('test').innerHTML = tab_text;
            var filename = '船员名单(' + shipName_total + ')';
            exportExcel(tab_text, filename, '船员名单');
            return 0;
        }
    </script>

@endsection
