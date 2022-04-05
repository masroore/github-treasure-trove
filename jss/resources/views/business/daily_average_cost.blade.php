@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
$ships = Session::get('shipList');
?>
@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
@endsection

@section('scripts')
    <link href="{{ cAsset('assets/js/chartjs/chartist.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cAsset('assets/js/chartjs/c3.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ cAsset('assets/js/chartjs/flot.css') }}">
    
    
    <script src="{{ cAsset('assets/js/chartjs/chartist.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/chartjs.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/d3.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/c3.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/flot.js') }}"></script>
@endsection

@section('content')
<style>
    #table-income-expense-body tr td {    
        background:#ececec!important;
    }
</style>
    <div class="main-content">
        <div class="page-content">
            <div class="page-header">
                <div class="col-sm-3">
                    <h4><b>成本预计</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-7">
                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                        <select class="custom-select d-inline-block" id="select-table-ship" style="width:80px">
                            <!--option value="" selected></option-->
                            <?php $index = 0 ?>
                            @foreach($shipList as $ship)
                                <?php $index ++ ?>
                                <option value="{{ $ship['IMO_No'] }}" @if(isset($shipId) && ($shipId == $ship['IMO_No'])) selected @endif data-name="{{$ship['shipName_En']}}">{{$ship['NickName']}}</option>
                            @endforeach
                        </select>
                        <strong class="f-right" style="font-size: 20px; padding-top: 6px;"><span id="table_info"></span>年份数据</strong>
                    </div>
                    <div class="col-md-5" style="padding:unset!important">
                        <div class="btn-group f-right">
                            <a id="btnSave" class="btn btn-sm btn-success" style="width: 80px">
                                <i class="icon-save"></i>{{ trans('common.label.save') }}
                            </a>
                            <a onclick="javascript:fnExcelTableReport();" class="btn btn-warning btn-sm excel-btn">
                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top:4px;">
                    <div id="item-manage-dialog" class="hide"></div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="row">
                        <div class="table-head-fix-div" id="div-income-expense" style="height: 700px">
                            <table id="table-income-expense-list" style="max-width:unset!important;table-layout:fixed;" class="not-striped">
                                <thead class="">
                                <tr>
                                    <th class="text-center style-normal-header" rowspan="2" style="width: 3%;"><span>年</span></th>
                                    <th class="text-center style-normal-header" rowspan="2" style="width: 3.5%;"><span>航次用时</span></th>
                                    <th class="text-center style-normal-header" rowspan="2" style="width: 3%;"><span>VOY</span></th>
                                    <th class="text-center style-normal-header" rowspan="2" style="width: 3%;"><span>TC</span></th>
                                    <th class="text-center style-normal-header" rowspan="2" style="width: 3%;"><span>NON</span></th>
                                    <th class="text-center style-normal-header" rowspan="2" style="width: 5.5%;"><span>收入 ($)</span></th>
                                    <th class="text-center style-normal-header" rowspan="2" style="width: 5.5%;"><span>支出 ($)</span></th>
                                    <th class="text-center style-normal-header" colspan="13"><span>支出分类 ($)</span></th>
                                </tr>
                                <tr>
                                    <th class="text-center style-red-header" style="width: 4%;"><span>油款</span></th>
                                    <th class="text-center style-red-header" style="width: 4%;"><span>港费</span></th>
                                    <th class="text-center style-red-header" style="width: 4%;"><span>劳务费</span></th>
                                    <th class="text-center style-red-header" style="width: 4%;"><span>CTM</span></th>
                                    <th class="text-center style-red-header" style="width: 4%;"><span>其他</span></th>
                                    <th class="text-center style-normal-header" style="width: 4%;"><span>工资</span></th>
                                    <th class="text-center style-normal-header" style="width: 4%;"><span>伙食费</span></th>
                                    <th class="text-center style-normal-header" style="width: 4%;"><span>物料费</span></th>
                                    <th class="text-center style-normal-header" style="width: 4%;"><span>修理费</span></th>
                                    <th class="text-center style-normal-header" style="width: 4%;"><span>管理费</span></th>
                                    <th class="text-center style-normal-header" style="width: 4%;"><span>保险费</span></th>
                                    <th class="text-center style-normal-header" style="width: 4%;"><span>检验费</span></th>
                                    <th class="text-center style-normal-header" style="width: 4%;"><span>证书费</span></th>
                                </tr>
                                </thead>
                                <tbody class="" id="table-income-expense-body">
                                </tbody>
                            </table>
                            <div class="space-12"></div>
                            <div class="col-md-6">
                                <select name="select-year" id="select-year" style="font-size:13px">
                                    @for($i=$start_year;$i<=date("Y");$i++)
                                    <option value="{{$i}}" @if(($year==$i)||(($year=='')&&($i==date("Y")))) selected @endif>{{$i}}年</option>
                                    @endfor
                                </select>
                                <strong class="f-right" style="font-size: 20px; padding-top: 6px; padding-bottom:8px;"><span id="costs_info"></span>成本预计</strong>
                            </div>
                            <form id="form-costs-list" action="updateCostInfo" role="form" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <table id="table-expect-cost" style="table-layout:fixed;width:900px!important;" class="not-striped">
                                <thead class="">
                                <tr>
                                    <th class="text-center style-normal-header" rowspan="2"><span></span></th>
                                    <th class="text-center style-red-header" colspan="3"><span>运营成本 ($)</span></th>
                                    <th class="text-center style-normal-header" colspan="8"><span>管理成本 ($)</span></th>
                                </tr>
                                <tr>
                                    <th class="text-center style-red-header"><span>劳务费</span></th>
                                    <th class="text-center style-red-header"><span>CTM</span></th>
                                    <th class="text-center style-red-header"><span>其他</span></th>
                                    <th class="text-center style-normal-header"><span>工资</span></th>
                                    <th class="text-center style-normal-header"><span>伙食费</span></th>
                                    <th class="text-center style-normal-header"><span>物料费</span></th>
                                    <th class="text-center style-normal-header"><span>修理费</span></th>
                                    <th class="text-center style-normal-header"><span>管理费</span></th>
                                    <th class="text-center style-normal-header"><span>保险费</span></th>
                                    <th class="text-center style-normal-header"><span>检验费</span></th>
                                    <th class="text-center style-normal-header"><span>证书费</span></th>
                                </tr>
                                </thead>
                                <tbody class="" id="">
                                <tr>
                                    <td class="text-center style-normal-header" style="background:#d9f8fb!important;"><span>年成本</span></td>
                                    <td class="disable-td"><input type="text" name="output[]" class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]" class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]" class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]" class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]" class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]" class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]" class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]" class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="white-bg"><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input1'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td class="white-bg"><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input2'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td class="white-bg"><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input3'] }}" style="width: 100%" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <td class="text-center style-normal-header" style="background:#d9f8fb!important;"><span>月成本</span></td>
                                    <td><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input4'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input5'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input6'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input7'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input8'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input9'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input10'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td><input type="text" name="input[]"  class="form-control disabled-td text-center" value="{{ $costs['input11'] }}" style="width: 100%" autocomplete="off"></td>
                                    <td class="disable-td"><input type="text" name="output[]"  class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]"  class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                    <td class="disable-td"><input type="text" name="output[]"  class="form-control disabled-td text-center" value="" style="background:#ececec;width: 100%" readonly></td>
                                </tr>
                                <tr style="height:30px;border:2px solid black;">
                                    <td class="text-center style-normal-header" style="background:#d9f8fb!important;"><span>日成本</span></td>
                                    <td colspan="3" class="sub-small-header style-red-header text-center" id="total-extra-sum"></td>
                                    <td colspan="8" class="sub-small-header style-normal-header text-center" id="total-sum"></td>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="keep_list" name="keep_list"></input>
        </div>
        <audio controls="controls" class="d-none" id="warning-audio">
            <source src="{{ cAsset('assets/sound/delete.wav') }}">
            <embed src="{{ cAsset('assets/sound/delete.wav') }}" type="audio/wav">
        </audio>
    </div>

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/bootstrap-editable.min.js') }}"></script>
    <script src="{{ asset('/assets/js/x-editable/ace-editable.min.js') }}"></script>
    <script src="{{ cAsset('assets/js/jsquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/js/dataTables.rowsGroup.js') }}"></script>
    <script src="{{ cAsset('assets/js/bignumber.js') }}"></script>
    
    <?php
	echo '<script>';
    echo 'var now_year = ' . date("Y") . ';';
    echo 'var FeeTypeData = ' . json_encode(g_enum('FeeTypeData')) . ';';
	echo '</script>';
	?>

    <script>
        var submitted = false;
        $("#btnSave").on('click', function() {
            var input = $("<input>").attr("type", "hidden").attr("name", "select-ship").val(shipid_table);
            $('#form-costs-list').append(input);
            input2 = $("<input>").attr("type", "hidden").attr("name", "select-year").val(year);
            $('#form-costs-list').append(input2);

            submitted = true;
            $('#form-costs-list').submit();
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

        function setValues()
        {
            var inputs = $('input[name="input[]"]');
            var outputs = $('input[name="output[]"]');
            var total_sum = 0;
            var total_extra_sum = 0;
            for (var i=0;i<inputs.length;i++) {
                var value = inputs[i].value;
                value = value.replaceAll("$","").replaceAll(",","");
                value = parseFloat(value);
                if (isNaN(value)) inputs[i].value = '';
                else inputs[i].value = prettyValue2(value);
                if (i < 3) {
                    if (!isNaN(value)) total_sum += value;
                    value = value / 12;
                }
                else if (i < 6)
                {
                    value = value * 12;
                    if (!isNaN(value)) total_extra_sum += value;
                }
                else {
                    value = value * 12;
                    if (!isNaN(value)) total_sum += value;
                }
                if (!isNaN(value) && value != "" && value != null) {
                    outputs[(i+8)%11].value = '' + prettyValue2(value);
                }
            }
            if (!isNaN(total_sum) && total_sum != "" && total_sum != null) {
                total_sum = total_sum / 365;
                total_sum = total_sum.toFixed(0);
                $('#total-sum').html('' + prettyValue2(total_sum));
            }
            else {
                $('#total-sum').html('-');
            }

            if (!isNaN(total_extra_sum) && total_extra_sum != "" && total_extra_sum != null) {
                total_extra_sum = total_extra_sum / 365;
                total_extra_sum = total_extra_sum.toFixed(0);
                $('#total-extra-sum').html('' + prettyValue2(total_extra_sum));
            }
            else {
                $('#total-extra-sum').html('-');
            }

            if (origForm == "")
                origForm = $form.serialize();
        }
        $('input[name="input[]"]').on('keyup', function(evt) {
            setValues();
        });

        $('input[name="input[]"]').on('keydown', function(evt) {
            if (evt.key == "Enter" || evt.key == "Tab") {
                if (evt.target.value == '') return;
                var val = evt.target.value.replaceAll(',','').replaceAll('$','');
                $(evt.target).val('' + prettyValue2(val));
            }
        });
        $('input[name="input[]"]').on('focusout', function(evt) {
            if (evt.target.value == '') return;
            var val = evt.target.value.replaceAll(',','').replaceAll('$','');
            $(evt.target).val('' + prettyValue2(val));
        });
        //setValues();

        $('body').on('keydown', 'input', function(e) {
            if (e.key === "Enter") {
                var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                focusable = form.find('input[name="input[]"]').filter(':visible');
                next = focusable.eq(focusable.index(this)+1);
                if (next.length) {
                    next.focus();
                    next.select();
                }
                return false;
            }
        });
/*
        $('input[name="input[]"]').on('change', function(evt) {
            if (evt.target.value == '') return;
            var val = evt.target.value.replaceAll(',','').replaceAll('$','');
            $(evt.target).val('$' + prettyValue(val));
        });
*/
        $('input[name="input[]"]').on('focus', function(evt) {
            $(evt.target).val($(evt.target).val().replaceAll(',','').replaceAll('$',''));
        });

        $('#table_info').html('' + $("#select-table-ship option:selected").attr('data-name') + ' ');
        $('#costs_info').html('' + $("#select-table-ship option:selected").attr('data-name') + ' ');

        var token = '{!! csrf_token() !!}';
        var shipid_table;
        var listTable = null;
        var table_sums = [];
        var dest_obj;
        var year;

        shipid_table = $("#select-table-ship").val();
        year = $("#select-year option:selected").val();
        initTable();

        function initTable() {
            listTable = $('#table-income-expense-list').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                bAutoWidth: false, 
                ajax: {
                    url: BASE_URL + 'ajax/operation/listByShipForPast',
                    type: 'POST',
                    data: {'shipId':shipid_table, 'year':year},
                },
                "ordering": false,
                "pageLength": 500,
                columnDefs: [
                ],
                columns: [
                    {data: 'year', className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                    {data: null, className: "text-center"},
                ],
                createdRow: function (row, data, index) {
                    if ((index%2) == 0)
                        $(row).attr('class', 'cost-item-even');
                    else
                        $(row).attr('class', 'cost-item-odd');
                        
                    $('td', row).eq(1).html(data['voy_time']);

                    if (data['VOY_count'] != null) {
                        $('td', row).eq(2).html(data['VOY_count']);
                    } else {
                        $('td', row).eq(2).html('-');
                    }

                    if (data['TC_count'] != null) {
                        $('td', row).eq(3).html(data['TC_count']);
                    } else {
                        $('td', row).eq(3).html('-');
                    }

                    if (data['NON_count'] != null) {
                        $('td', row).eq(4).attr('style', 'color:darkred;font-weight:bold;');
                        $('td', row).eq(4).html(data['NON_count']);
                    } else {
                        $('td', row).eq(4).html('-');
                    }
                    

                    $('td', row).eq(5).attr('class', 'style-blue-input text-right');
                    $('td', row).eq(5).attr('style', 'padding-right:5px!important;');
                    $('td', row).eq(5).html(data['credit_sum']==0?'':prettyValue2(data['credit_sum']));

                    $('td', row).eq(6).attr('class', 'text-right');
                    $('td', row).eq(6).attr('style', 'padding-right:5px!important;')
                    $('td', row).eq(6).html(data['debit_sum']==0?'':prettyValue2(data['debit_sum']));
                    //$('td', row).eq(6).attr('class', 'text-right right-border');
                    for (var i=1;i<16;i++)
                    {
                        if (i == 2) {
                            dest_obj = $('td', row).eq(7);
                        }
                        else if (i == 1) {
                            dest_obj = $('td', row).eq(8);
                        }
                        else if (i == 6) {
                            dest_obj = $('td', row).eq(9);
                        }
                        else if (i == 4) {
                            dest_obj = $('td', row).eq(10);
                        }
                        else if (i == 15) {
                            dest_obj = $('td', row).eq(11);
                        }
                        else if (i == 3) {
                            dest_obj = $('td', row).eq(12);
                        }
                        else if (i == 5) {
                            dest_obj = $('td', row).eq(13);
                        }
                        else if (i == 7) {
                            dest_obj = $('td', row).eq(14);
                        }
                        else if (i == 8) {
                            dest_obj = $('td', row).eq(15);
                        }
                        else if (i == 9) {
                            dest_obj = $('td', row).eq(16);
                        }
                        else if (i == 10) {
                            dest_obj = $('td', row).eq(17);
                        }
                        else if (i == 11) {
                            dest_obj = $('td', row).eq(18);
                        }
                        else if (i == 12) {
                            dest_obj = $('td', row).eq(19);
                        }
                        else {
                            dest_obj = null;
                        }

                        if (i == 15) {
                            //$(dest_obj).attr('class', 'text-right right-border');
                        }

                        if (data['debit_list'][i] != undefined)
                        {
                            if (i == 15) {
                                //$(dest_obj).attr('class', 'text-right right-border');
                            } else {
                                $(dest_obj).attr('class', 'text-right');
                            }
                            
                            if ((i==7)||(i==8)) {
                                if (data['NON_count'] != null) {
                                    $(dest_obj).attr('style', 'color:darkred;font-weight:bold;padding-right:5px!important;')
                                }
                            } else {
                                $(dest_obj).attr('style', 'padding-right:5px!important;')
                            }
                            
                            $(dest_obj).html(prettyValue2(data['debit_list'][i]));
                        }
                        else {
                            if (dest_obj != null) $(dest_obj).html('');
                        }
                    }
                },
                drawCallback: function (response) {
                    if (response.json.data.length <= 0) return;
                    var tab = document.getElementById('table-income-expense-body');
                    var i,j;
                    for (i=0;i<15;i++) table_sums[i] = 0;
                    var time_average = 0;
                    for(var j=0; j<tab.rows.length; j++)
                    {
                        var value_str = tab.rows[j].childNodes[1].innerHTML;
                        if ((value_str != "") && (value_str != "-"))
                        {
                            time_average += parseFloat(value_str.replaceAll(",",""));
                        }

                        for (var i=0;i<15;i++)
                        {
                            var value_str = tab.rows[j].childNodes[5+i].innerHTML;
                            if ((value_str != "") && (value_str != "-"))
                            {
                                table_sums[i] += parseFloat(value_str.replaceAll(",",""));
                            }
                        }
                    }

                    var inputs = $('input[name="input[]"]');
                    var outputs = $('input[name="output[]"]');
                    for (var i=0;i<11;i++) { inputs[i].value = ""; outputs[i].value = "";}
                    if (response.json.costs != null) {
                        inputs[0].value = response.json.costs['input1'];
                        inputs[1].value = response.json.costs['input2'];
                        inputs[2].value = response.json.costs['input3'];
                        inputs[3].value = response.json.costs['input4'];
                        inputs[4].value = response.json.costs['input5'];
                        inputs[5].value = response.json.costs['input6'];
                        inputs[6].value = response.json.costs['input7'];
                        inputs[7].value = response.json.costs['input8'];
                        inputs[8].value = response.json.costs['input9'];
                        inputs[9].value = response.json.costs['input10'];
                        inputs[10].value = response.json.costs['input11'];

                    }

                    setValues();
                }
            });

            $('.paginate_button').hide();
            $('.dataTables_length').hide();
            $('.paging_simple_numbers').hide();
            $('.dataTables_info').hide();
            $('.dataTables_processing').attr('style', 'position:absolute;display:none;visibility:hidden;');
        }

        $('#select-table-ship').on('change', function() {
            var prevShip = $('#select-table-ship').val();
            $('#select-table-ship').val(shipid_table);
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
                        $('#select-table-ship').val(prevShip);
                        selectTableInfo();
                    }
                });
            }
            else {
                $('#select-table-ship').val(prevShip);
                selectTableInfo();
            }
        });

        $('#select-year').on('change', function() {
            var prevYear = $('#select-year').val();
            $('#select-year').val(year);
            var newForm = $form.serialize();
            //newForm = newForm.replaceAll(/select-year\=|[0-9]/gi,'');
            if ((newForm !== origForm) && !submitted) {
                console.log(newForm);
                console.log(origForm);
                var confirmationMessage = 'It looks like you have been editing something. '
                                    + 'If you leave before saving, your changes will be lost.';
                alertAudio();
                bootbox.confirm(confirmationMessage, function (result) {
                    if (!result) {
                        return;
                    }
                    else {
                        $('#select-year').val(prevYear);
                        selectTableInfo();
                    }
                });
            }
            else {
                $('#select-year').val(prevYear);
                selectTableInfo();
            }
        });

        function selectTableInfo()
        {
            origForm = "";
            shipid_table = $("#select-table-ship").val();
            year = $("#select-year").val();
            $('#table_info').html('"' + $("#select-table-ship option:selected").attr('data-name') + '"');
            $('#costs_info').html('"' + $("#select-table-ship option:selected").attr('data-name') + '"');

            if (listTable == null) {
                initTable();
            }
            else
            {
                listTable.column(1).search(shipid_table, false, false);
                listTable.column(2).search(year, false, false).draw();
            }
        }

        function prettyValue(value)
        {
            if(value == undefined || value == null) return '';
            return parseFloat(value).toFixed(2).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
        }

        function prettyValue2(value)
        {
            if(value == undefined || value == null) return '';
            return parseFloat(value).toFixed(0).replaceAll(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
        }

        const DAY_UNIT = 1000 * 3600;
        const COMMON_DECIMAL = 2;

        function __getTermDay(start_date, end_date, start_gmt = 8, end_gmt = 8) {
            let currentDate = moment(end_date).valueOf();
            let currentGMT = DAY_UNIT * end_gmt;
            let prevDate = moment(start_date).valueOf();
            let prevGMT = DAY_UNIT * start_gmt;
            let diffDay = 0;
            currentDate = BigNumber(currentDate).minus(currentGMT).div(DAY_UNIT);
            prevDate = BigNumber(prevDate).minus(prevGMT).div(DAY_UNIT);
            diffDay = currentDate.minus(prevDate);
            return parseFloat(diffDay.div(24).toFixed(4));
        }

        function alertAudio() {
            document.getElementById('warning-audio').play();
        }

        function fnExcelTableReport()
        {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-income-expense-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='20' style='font-size:20px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#table_info').html() + "年份数据</td></tr>";
            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        if (i == 7)
                            tab.rows[j].childNodes[i].style.width = '1500px';
                        else
                            tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[0].style.width = '80px';
                    tab.rows[j].childNodes[1].style.width = '80px';
                }
                else if (j == 1) {
                    for (var i=0; i<tab.rows[j].childElementCount;i++) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                }
                else if (j >= (tab.rows.length - 3))
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

            real_tab = document.getElementById('table-expect-cost');
            tab_text+="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            tab = real_tab.cloneNode(true);
            tab_text+="<tr><td colspan='12' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#table_info').html() + "成本预计</td></tr>";
            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j == 0) {
                    for (var i=1; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                }
                else if (j == 1) {
                    for (var i=1; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                }
                else if (j == (tab.rows.length - 1))
                {
                    for (var i=1; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.height = "30px";
                        tab.rows[j].childNodes[i].style.fontWeight = "bold";
                        tab.rows[j].childNodes[i].style.backgroundColor = '#ebf1de';
                    }
                }
                else
                {
                    for (var i=3;i<19;i+=2)
                    {
                        var info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                        tab.rows[j].childNodes[i].innerHTML = info;
                    }
                }
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            
            tab_text=tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text=tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text=tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = $('#select-table-ship option:selected').text() + '_成本预计';
            exportExcel(tab_text, filename, filename);
            
            return 0;
        }

    </script>

@endsection
