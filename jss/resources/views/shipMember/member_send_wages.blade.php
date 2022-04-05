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
        </style>
        <div class="page-content">
        <form id="wage-form" action="updateWageSendInfo" role="form" method="POST" enctype="multipart/form-data">
            <div class="page-header">
                <div class="col-sm-3">
                    <h4><b>工资汇款</b></h4>
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
                                    @foreach($shipList as $ship)
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
                                <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="search_info"></span>份工资汇款单</strong>
                            </div>
                            <div class="col-md-5" style="padding:unset!important">
                                <div class="btn-group f-right" style="{{$user_pos == STAFF_LEVEL_CAPTAIN || $user_pos == STAFF_LEVEL_SHAREHOLDER ? 'display:none' : ''}}">
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
                                            <th class="text-center style-normal-header" style="width: 10%;"><span>姓名</span></th>
                                            <th class="text-center style-normal-header" style="width: 4%;"><span>职务</span></th>
                                            <th class="text-center style-normal-header" style="width: 6%;">家汇款<br><span style="color:red">(¥)</span></th>
                                            <th class="text-center style-normal-header" style="width: 6%;">实发款<br><span style="color:red">(¥)</span></th>
                                            <th class="text-center style-normal-header" style="width: 6%;">实发款<br><span style="color:#1565C0">($)</span></th>
                                            <th class="text-center style-normal-header" style="width: 7%;"><span>支付日期</span></th>
                                            <th class="text-center style-normal-header" style="width: 8%;"><span>出款银行</span></th>
                                            <th class="text-center style-normal-header" style="width: 32%;"><span>银行账户</span></th>
                                            <th class="text-center style-normal-header" style="width: 21%;"><span>备注</span></th>
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
    //echo 'var BankInfo = ' . json_encode(g_enum('BankData')) . ';';
    echo 'var BankInfo = [];';
    for($i=0;$i<count($accounts);$i++) {
        echo 'BankInfo[' . $i . ']="' . $accounts[$i]['account'] . '";';
    }
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
                    url: BASE_URL + 'ajax/shipMember/wage/send',
                    type: 'POST',
                    data: {'year':year, 'month':month, 'shipId':shipId},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: null, className: "text-center"},
                    {data: 'name', className: "text-center"},
                    {data: 'rank', className: "text-center"},
                    {data: 'cashR', className: "text-center"},
                    {data: 'sendR', className: "text-center"},
                    {data: 'sendD', className: "text-center"},
                    {data: 'purchdate', className: "text-center"},
                    {data: 'sendbank', className: "text-center"},
                    {data: 'remark', className: "text-center"},
                    {data: 'bankinfo', className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    var pageInfo = listTable.page.info();
                    //$(row).attr('class', 'wage-item disable-tr');
                    if ((index%2) == 0)
                        $(row).attr('class', 'wage-item cost-item-even');
                    else
                        $(row).attr('class', 'wage-item cost-item-odd');
                    $(row).attr('data-index', data['no']);
                    $('td', row).eq(0).attr('class', 'text-center disable-td add-no');
                    $('td', row).eq(1).attr('class', 'text-center disable-td');
                    $('td', row).eq(2).attr('class', 'text-center disable-td');
                    $('td', row).eq(3).attr('class', 'text-center disable-td');
                    $('td', row).eq(8).attr('class', 'text-center disable-td');
                    $('td', row).eq(8).attr('style', 'text-align:left;word-wrap:break-word');

                    $('td', row).eq(0).html('').append('<label>' + (pageInfo.page * pageInfo.length + index + 1)+ '</label><input type="hidden" name="MemberId[]" value="' + data['no'] + '">');
                    $('td', row).eq(1).html('<label>' + data['name'] + '</label><input type="hidden" name="Names[]" value="' + data['name'] + '">');
                    var rank = data['rank'];
                    if (rank == 'null' || rank == null) rank = '';
                    $('td', row).eq(2).html('<label>' + __parseStr(rank) + '</label><input type="hidden" name="Rank[]" value="' + rank + '">');
                    $('td', row).eq(3).html('<label>' + __parseStr(data['cashR']) + '</label><input type="hidden" name="CashR[]" value="' + data['cashR'] + '">');
                    $('td', row).eq(4).html('<input type="text" autocomplete="off" class="form-control style-noncolor-input add-sendR" name="SendR[]" value="' + data['sendR'] + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(5).html('<input type="text" autocomplete="off" class="form-control style-noncolor-input add-sendD" name="SendD[]" value="' + data['sendD'] + '" style="width: 100%;text-align: center" autocomplete="off">');
                    $('td', row).eq(6).html('<div class="input-group"><input autocomplete="off" class="form-control style-noncolor-input add-trans-date date-picker text-center" name="PurchDate[]" type="text" data-date-format="yyyy-mm-dd" value="' + (data['purchdate'] == null ? "": data['purchdate'].substring(0,10)) + '"><span class="input-group-addon"><i class="icon-calendar "></i></span></div>');
                    var bank_info = '<select class="form-control" name="SendBank[]">';
                    bank_info += '<option value="100"' + ((100==data['sendbank'])?'selected':'') + '></option>';
                    for (var i=0;i<BankInfo.length;i++)
                        bank_info += '<option value="'+i+'"' + ((i==data['sendbank'])?'selected':'') + '>'+BankInfo[i]+'</option>';
                    bank_info += '</select>';
                    $('td', row).eq(7).html(bank_info);

                    var bank_name = data['bankinfo'];
                    if (bank_name == 'null' || bank_name == null) bank_name = '';
                    $('td', row).eq(8).html('<label style="padding-left:2px;">' + __parseStr(bank_name) + '</label><input type="hidden" name="BankInfo[]" value="' + __parseStr(bank_name) + '">');
                    $('td', row).eq(9).html('<input type="text" autocomplete="off" class="form-control style-noncolor-input" name="Remark[]" value="' + __parseStr(data['remark']) + '" style="width: 100%;text-align: left" autocomplete="off">');
                },
                drawCallback: function (response) {
                    original = response.json.original;
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
        shipId = $("#select-ship").val();
        $('#search_info').html('"' + $("#select-ship option:selected").attr('data-name') + '" ' + year + '年' + month + '月');
        initTable();
        function setValue(e, v, isNumber) {
            if (v == null || isNaN(v) || v == '') {
                e.closest("td").firstElementChild.innerHTML = '';
                e.value = '';
            }
            else {
                e.closest("td").firstElementChild.innerHTML = isNumber ? prettyValue(v) : v;
                e.value = prettyValue(v);
            }
        }

        function parseValue(value, isNumber=true)
        {
            if (value == ''){
                return (isNumber?0:'');
            }
            return parseFloat(value);
        }

        function calcReport()
        {
            var CashR = $('input[name="CashR[]"]');
            var SendR = $('input[name="SendR[]"]');
            var SendD = $('input[name="SendD[]"]');
            var No = $('.add-no');
            
            var sum_R = 0;
            var sum_D = 0;
            var sum_P = 0;
            for (var i=0;i<CashR.length;i++) {
                setValue(No[i], i + 1, false);
                var _R = CashR[i].value.replaceAll(',','');
                var _D = SendR[i].value.replaceAll(',','');
                var _P = SendD[i].value.replaceAll(',','');

                setValue(CashR[i], _R, true);
                setValue(SendR[i], _D, true);
                setValue(SendD[i], _P, true);

                sum_R += parseValue(_R.replaceAll(',',''));
                sum_D += parseValue(_D.replaceAll(',',''));
                sum_P += (_P==''||_P=='NaN')?0:parseValue(_P.replaceAll(',',''));
            }
            if ($('#list-body tr:last').attr('class') == 'tr-report') {
                $('#list-body tr:last').remove();
            }
            $('#list-body').append('<tr class="tr-report" style="height:30px;border:2px solid black;"><td class="sub-small-header style-normal-header text-center">' + ($('.wage-item').length) + '</td><td class="sub-small-header style-normal-header" colspan="2"></td><td class="style-normal-header disable-td text-right">¥ ' + prettyValue(sum_R) + '</td><td class="style-normal-header text-right disable-td">¥ ' + prettyValue(sum_D) + '</td><td class="style-normal-header text-right disable-td">$ ' + prettyValue(sum_P)+ '</td><td class="sub-small-header style-normal-header" colspan="4"></td></tr>');
            setDatePicker();
            checkPos();

            if (origForm == "")
                origForm = $form.serialize();
        }

        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

        function init()
        {
            alertAudio();
            bootbox.confirm("Are you sure you want to init?", function (result) {
                if (result) {
                    $.ajax({
                        url: BASE_URL + 'ajax/shipMember/wage/initSend',
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

        function prettyValue(value)
        {
            if(value == undefined || value == null) return '';
            return parseFloat(value).toFixed(2).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
        }

        function setDatePicker() {
            if (POS == HOLDER || POS == CAPTAIN) return;
            $('.date-picker').datepicker({autoclose: true}).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });
        }

        function selectInfo()
        {
            shipName = $("#select-ship option:selected").text();
            year = $("#select-year option:selected").val();
            month = $("#select-month option:selected").val();
            if (shipName == "") return;
            $('#search_info').html('"' + $("#select-ship option:selected").attr('data-name') + '" ' + year + '年' + month + '月');

            if (listTable == null) {
                initTable();
            }
            else
            {
                listTable.column(3).search(year, false, false);
                listTable.column(4).search(month, false, false);
                listTable.column(2).search($("#select-ship").val(), false, false).draw();
            }
        }
        $('#select-ship').on('change', function() {
            shipId = $('#select-ship').val();
            origForm = "";
            selectInfo();
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

        function setEvents()
        {
            $('.add-sendR').on('change', function(evt) {
                var val = evt.target.value.replaceAll(',','');
                val = parseFloat(val);
                if (isNaN(val)) {
                    val = 0;
                }
                $(evt.target).val(prettyValue(val));
                calcReport();
            });

            $('.add-sendD').on('change', function(evt) {
                var val = evt.target.value.replaceAll(',','');
                val = parseFloat(val);
                if (isNaN(val)) {
                    val = 0;
                }
                $(evt.target).val(prettyValue(val));
                calcReport();
            });
        }
        
        function fnExcelReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-shipmember-list');
            var tab = real_tab.cloneNode(true);
            //var tab = document.getElementById('table-shipmember-list');
            tab_text=tab_text+"<tr><td colspan='10' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_info').html() + "份工资汇款单</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[1].style.width = '140px';
                    tab.rows[j].childNodes[2].style.width = '60px';
                    tab.rows[j].childNodes[6].style.width = '80px';
                    tab.rows[j].childNodes[8].style.width = '300px';
                }
                else if(j == (tab.rows.length -1))
                {
                    var i;
                    for (i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.height = "30px";
                        tab.rows[j].childNodes[i].style.fontWeight = "bold";
                        tab.rows[j].childNodes[i].style.backgroundColor = '#ebf1de';
                    }
                }
                else
                {
                    var bank_info = BankInfo[real_tab.rows[j].childNodes[7].childNodes[0].selectedIndex];
                    tab.rows[j].childNodes[7].innerHTML = bank_info;

                    var info = real_tab.rows[j].childNodes[4].childNodes[0].value;
                    tab.rows[j].childNodes[4].innerHTML = info;
                    info = real_tab.rows[j].childNodes[5].childNodes[0].value;
                    tab.rows[j].childNodes[5].innerHTML = info;
                    info = real_tab.rows[j].childNodes[6].childNodes[0].childNodes[0].value;
                    tab.rows[j].childNodes[6].innerHTML = info;
                    info = real_tab.rows[j].childNodes[9].childNodes[0].value;
                    tab.rows[j].childNodes[9].innerHTML = info;
                }
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = $("#select-ship option:selected").html() + '_' + year + '_' + month + '_工资汇款单';

            //$('#test').html(tab_text);
            exportExcel(tab_text, filename, year + '_' + month + '_工资汇款单');
            return 0;
        }

        var submitted = false;
        $("#btnSave").on('click', function() {
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
            newForm = newForm.replaceAll("editable-image-input-hidden=&", "");
            if ((newForm !== origForm) && !submitted) {
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });

        function checkPos()
        {
            if (POS == HOLDER || POS == CAPTAIN) {
                $('input[type="text"], textarea').each(function(){
                    $(this).attr('readonly','readonly');
                });

                $('i[class="icon-calendar"], select[name="SendBank[]"]').each(function(){
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
