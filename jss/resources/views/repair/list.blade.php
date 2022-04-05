<?php
if(isset($excel)) $header = 'excel-header';
else $header = 'header';
?>

<?php
$isHolder = Session::get('IS_HOLDER');
$ships = Session::get('shipList');
?>

@extends('layout.'.$header)

@section('styles')
    <link href="{{ cAsset('css/pretty.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/vue.css') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css') }}" rel="stylesheet"/>
@endsection


@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="page-header">
                <div class="col-md-3">
                    <h4>
                        <b>维修分析</b>
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs ship-register">
                        <li class="active" id="report-link">
                            <a data-toggle="tab" href="#report-list-div">
                            维修汇报</span>
                            </a>
                        </li>
                        <li class="" id="data-link">
                            <a data-toggle="tab" href="#data-list-div">
                            维修表</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content pt-1">
                        <div id="report-list-div" class="tab-pane active">
                            <div id="report-list" v-cloak>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名: </label>
                                        <select class="custom-select d-inline-block" id="select-ship" style="padding: 4px; max-width: 100px;" @change="onChangeShip" v-model="shipId">
                                            @foreach($shipList as $ship)
                                                <option value="{{ $ship['IMO_No'] }}"
                                                    {{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="year_list" @change="onChangeYear" v-model="activeYear">
                                            @foreach($years as $year)
                                                <option value="{{ $year }}">{{ $year }}年</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="d-flex" style="margin-top: 8px;">
                                            <div class="d-flex">
                                                <input type="radio" name="search-type" value="{{ REPAIR_REPORT_TYPE_DEPART }}" id="search-depart" class="width-auto mt-0" :checked="search_type == 1" @click="onChangeSearchType">
                                                <label for="search-depart" style="margin-left: 6px;">部门</label>
                                            </div>
                                            <div class="d-flex ml-1">
                                                <input type="radio" name="search-type" value="{{ REPAIR_REPORT_TYPE_CHARGE }}" id="search-charge" class="width-auto mt-0" :checked="search_type == 2" @click="onChangeSearchType">
                                                <label for="search-charge" style="margin-left: 6px;">担任</label>
                                            </div>
                                            <div class="d-flex ml-1">
                                                <input type="radio" name="search-type" value="{{ REPAIR_REPORT_TYPE_TYPE }}" id="search-type" class="width-auto mt-0" :checked="search_type == 3" @click="onChangeSearchType">
                                                <label for="search-type" style="margin-left: 6px;">种类</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <strong style="font-size: 16px; padding-top: 6px; margin-left: 30px;">
                                            <span class="font-bold">@{{ tableTitle }}</span>
                                        </strong>
                                        <div class="btn-group f-right">
                                            <button class="btn btn-warning btn-sm excel-btn" @click="fnExcelRecord"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 4px;">
                                    <div class="">
                                        <table class="table-striped dynamic-table table-striped" id="table-record">
                                            <thead class="">
                                                <tr>
                                                    <th class="text-center" rowspan="2" style="min-width: 80px;">@{{ activeLabel }}</th>
                                                    <th class="text-center" colspan="2">@{{ activeYear }}年</th>
                                                    @for($i = 1; $i <= 12; $i ++)
                                                        <th class="text-center style-header" colspan="2">{{ $i }}月</th>
                                                    @endfor
                                                </tr>
                                                <tr>
                                                    @for($i = 1; $i <= 13; $i ++)
                                                        <th class="text-center style-header">规划</th>
                                                        <th class="text-center style-header text-profit">完成</th>
                                                    @endfor
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, index) in list">
                                                    <td class="center no-wrap voy-no" style="background: linear-gradient(rgb(255, 255, 255), rgb(217, 248, 251)) !important;" @click="clickItem(item.id)">
                                                        <span>@{{ item.label }}</span>
                                                    </td>
                                                    <td class="center no-wrap">
                                                        <span>@{{ _vue_number(item.total) }}</span>
                                                    </td>
                                                    <td class="center no-wrap">
                                                        <span>@{{ _vue_number(item.complete) }}</span>
                                                    </td>
                                                    <template v-for="(sub_item, sub_index) in item.list">
                                                        <td class="center no-wrap">
                                                            <span>@{{ _vue_number(sub_item[0]) }}</span>
                                                        </td>
                                                        <td class="center no-wrap">
                                                            <span class="text-profit">@{{ _vue_number(sub_item[1]) }}</span>
                                                        </td>
                                                    </template>
                                                </tr>

                                                <tr class="dynamic-footer bt-0">
                                                    <td class="text-center">
                                                        合计
                                                    </td>
                                                    <template v-for="(item, index) in total">
                                                        <td class="center no-wrap">
                                                            <span>@{{ _vue_number(item[0]) }}</span>
                                                        </td>
                                                        <td class="center no-wrap">
                                                            <span class="text-profit">@{{ _vue_number(item[1]) }}</span>
                                                        </td>
                                                    </template>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="data-list-div" class="tab-pane">
                            <div id="data-list" v-cloak>
                                <div class="row">
                                    <div class="col-lg-7">
                                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名: </label>
                                        <select class="custom-select d-inline-block" id="select-ship" style="padding: 4px; max-width: 100px;" @change="onChangeShip" v-model="shipId">
                                            @foreach($shipList as $ship)
                                                <option value="{{ $ship['IMO_No'] }}"
                                                    {{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="year_list" @change="onChangeYear" v-model="activeYear">
                                            @foreach($years as $year)
                                                <option value="{{ $year }}">{{ $year }}年</option>
                                            @endforeach
                                        </select>
                                        <select class="custom-select" @change="onChangeYear" v-model="activeMonth">
                                            <option value=""></option>
                                            @for($i = 1; $i <= 12; $i ++)
                                                <option value="{{$i}}">{{ $i }}月</option>
                                            @endfor
                                        </select>
                                        <select class="custom-select" @change="onChangeYear" v-model="activeDepart">
                                            <option value="0"></option>
                                            @foreach($departList as $key => $item)
                                                <option value="{{$item->id}}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <select class="custom-select" @change="onChangeYear" v-model="activeCharge">
                                            <option value="0"></option>
                                            @foreach($chargeList as $key => $item)
                                                <option value="{{$item->id}}">{{ $item->Abb }}</option>
                                            @endforeach
                                        </select>
                                        <select class="custom-select" @change="onChangeYear" v-model="activeType">
                                            <option value="0"></option>
                                            @foreach($typeList as $key => $item)
                                                <option value="{{$item->id}}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <strong style="font-size: 16px; padding-top: 6px; margin-left: 30px;" class="f-right">
                                            <span class="font-bold">@{{ tableTitle }}</span>
                                        </strong>
                                        
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="btn-group f-right">
                                            <button class="btn btn-warning btn-sm excel-btn" @click="fnExcelRecord"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
                                        </div>
                                        <select class="custom-select f-right" style="margin-right: 10px;" @change="onChangeYear" v-model="activeStatus">
                                            <option value="0"></option>
                                            <option value="1">未完成</option>
                                            <option value="2">已完成</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 4px;">
                                    <div class="head-fix-div common-list">
                                        <form action="{{ route('repair.update') }}" method="post" enctype="multipart/form-data" id="repair-form">
                                            @csrf
                                            <input type="hidden" value="{{ $shipId }}" name="ship_id">
                                            <table class="table-striped" id="table-record-list">
                                                <thead class="">
                                                    <th class="d-none"></th>
                                                    <th class="text-center" style="width: 4%;">编号</th>
                                                    <th class="text-center" style="width: 6%;">申请日期</th>
                                                    <th class="text-center style-header" style="width: 6%">部门</th>
                                                    <th class="text-center style-header" style="width: 6%;">担任</th>
                                                    <th class="text-center style-header" style="width: 8%;">种类</th>
                                                    <th class="text-center style-header" style="width: 36%;">工作内容</th>
                                                    <th class="text-center style-header text-profit" style="width: 6%;">完成日期</th>
                                                    <th class="text-center style-header" style="width: 28%;">备注</th>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(item, index) in list">
                                                        <td class="center no-wrap">
                                                            <span>@{{ item.serial_no }}</span>
                                                        </td>
                                                        <td class="center no-wrap">
                                                            <span>@{{ item.request_date }}</span>
                                                        </td>
                                                        <td class="center no-wrap">
                                                            <span>@{{ item.department }}</span>
                                                        </td>
                                                        <td class="center no-wrap">
                                                            <span>@{{ item.charge }}</span>
                                                        </td>
                                                        <td class="center no-wrap">
                                                            <span>@{{ item.type }}</span>
                                                        </td>

                                                        <td>
                                                            <span>@{{ item.job_description }}</span>
                                                        </td>

                                                        <td class="text-center">
                                                            <span>@{{ item.completed_at }}</span>
                                                        </td>

                                                        <td>
                                                            <span>@{{ item.remark }}</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>

	<?php
	echo '<script>';
    echo 'var PlaceType = ' . json_encode(g_enum('PlaceType')) . ';';
    echo 'var VarietyType = ' . json_encode(g_enum('VarietyType')) . ';';
    echo 'var UnitData = ' . json_encode(g_enum('UnitData')) . ';';
    echo 'var DepartList = ' . json_encode($departList) . ';';
    echo 'var TypeList = ' . json_encode($typeList) . ';';
    echo 'var ChargeList = ' . json_encode($chargeList) . ';';
	echo '</script>';
	?>
    <script>
        var recordVue = null;
        var reportVue = null;
        var $_this = null;
        var shipId = '{!! $shipId !!}';
        var activeYear = '{!! $activeYear !!}';
        var activeYear = '{!! $activeYear !!}';
        var initLoad = true;
        var isChangeStatus = false;

        $(function () {
            initialize();
        });

        function initialize() {
            initReport();
            initRecord();
        }

        function initReport() {
            reportVue = new Vue({
                el: '#report-list',
                data: {
                    list                : [],
                    total               : [],

                    complete            : 0,
                    search_type         : '{{ REPAIR_REPORT_TYPE_DEPART }}',
                    typeList            : TypeList,
                    departList          : DepartList,
                    chargeList          : ChargeList,

                    shipId              : shipId,
                    shipName            : '{{ $shipName }}',
                    activeYear          : activeYear,
                    activeMonth         : '{{ $activeMonth }}',
                    activeStatus        : '{{ REPAIR_STATUS_ALL }}',
                    activeLabel         : '部门',
                    tableTitle          : '',
                },
                methods: {
                    clickItem: function(id) {
                        recordVue.activeMonth = '';
                        getRecord($_this.activeYear, this.search_type, id, true);
                    },

                    customFormatter(date) {
                        return moment(date).format('YY-MM-DD');
                    },
                    dateModify(e, index, type) {
                        $(e.target).on("change", function() {
                            isChangeStatus = true;
                            // recordVue.list[index][type] = moment($(this).val()).format("YY-MM-DD");
                            recordVue.list[index][type] = $(this).val();
                        });
                    },
                    onChangeShip: function(e) {
                        location.href = '/repair/list?id=' + e.target.value;
                    },
                    onChangeSearchType: function(e) {
                        let val = e.target.value;
                        let prop = $(e.target).prop('checked');

                        if(this.search_type == val) return;
                        this.search_type = val;

                        if(val == 1) this.activeLabel = '部门';
                        else if(val == 2) this.activeLabel = '担任';
                        else this.activeLabel = '种类';

                        getInitInfo();
                    },
                    onChangeYear: function(e) {
                        var confirmationMessage = 'It looks like you have been editing something. '
                                + 'If you leave before saving, your changes will be lost.';

                        if (isChangeStatus) {
                            bootbox.confirm(confirmationMessage, function (result) {
                                if (!result) {
                                    return;
                                }
                                else {
                                    getInitInfo();
                                }
                            });
                        } else {
                            getInitInfo();
                        }
                    },
                    onChangeInput: function() {
                        isChangeStatus = true;
                    },
                    getImage: function(file_name) {
                        if(file_name != '' && file_name != undefined)
                            return '/assets/images/document.png';
                        else
                            return '/assets/images/paper-clip.png';
                    },
                    getToday: function(symbol = '-') {
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = yyyy + symbol + mm + symbol + dd;

                        return this.customFormatter(today);
                    },
                    submitForm: function() {
                        isChangeStatus = false;
                        $('#repair-form').submit();
                    },
                    _vue_number: function(val) {
                        return __parseFloat(val) == 0 ? '' : _number_format(val, 0);
                    },

                    fnExcelRecord() {
                        var tab_text = "";
                        tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                        real_tab = document.getElementById('table-record');
                        var tab = real_tab.cloneNode(true);
                        tab_text=tab_text+"<tr><td colspan='27' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + reportVue.tableTitle + "</td></tr>";
                        
                        tab.rows[0].childNodes[0].style.width = "120px";
                        for(var j = 0; j < tab.rows.length ; j++)
                        {
                            if (j == 0 || j == 1) {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                }
                            }
                            else if (j == tab.rows.length - 1) {
                                for (var i=0; i<=40;i++) {
                                    if (tab.rows[j].childNodes[i].nodeName != "#text")
                                    {
                                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                    }
                                }
                            }

                            tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                        }
                        tab_text=tab_text+"</table>";
                        tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
                        tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
                        tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

                        var filename = reportVue.tableTitle;
                        exportExcel(tab_text, filename, filename);
                        
                        return 0;
                    }
                },
            });

            $_this = reportVue;
            getInitInfo();
        }

        function initRecord() {
            // Create Vue Obj
            recordVue = new Vue({
                el: '#data-list',
                data: {
                    list                : [],
                    typeList            : TypeList,
                    departList          : DepartList,
                    chargeList          : ChargeList,

                    shipId              : shipId,
                    shipName            : '{{ $shipName }}',
                    activeYear          : activeYear,
                    activeMonth         : '{{ $activeMonth }}',
                    activeStatus        : '{{ REPAIR_STATUS_ALL }}',
                    activeDepart        : 0,
                    activeCharge        : 0,
                    activeType          : 0,

                    tableTitle          : '',
                },
                methods: {
                    customFormatter(date) {
                        return moment(date).format('YY-MM-DD');
                    },
                    dateModify(e, index, type) {
                        $(e.target).on("change", function() {
                            isChangeStatus = true;
                            // recordVue.list[index][type] = moment($(this).val()).format("YY-MM-DD");
                            recordVue.list[index][type] = $(this).val();
                        });
                    },
                    onChangeShip: function(e) {
                        location.href = '/repair/list?id=' + e.target.value;
                    },
                    onChangeYear: function(e) {
                        let ship_id = this.shipId;
                        let year = this.activeYear;
                        let month = this.activeMonth;
                        let depart = this.activeDepart;
                        let charge = this.activeCharge;
                        let type = this.activeType;
                        let status = this.activeStatus;

                        $.ajax({
                            url: BASE_URL + 'ajax/repair/search',
                            type: 'post',
                            data: {
                                ship_id: ship_id,
                                year: year,
                                month: month,
                                depart: depart,
                                charge: charge,
                                type: type,
                                status: status,
                            },
                            success: function(data, status, xhr) {
                                let result = data;
                                recordVue.list = result;
                                
                                recordVue.tableTitle = recordVue.shipName + ' ' + recordVue.activeYear + '年' + recordVue.activeMonth + '月维修保养';
                            }
                        });
                    },
                    onChangeInput: function() {
                        isChangeStatus = true;
                    },
                    getImage: function(file_name) {
                        if(file_name != '' && file_name != undefined)
                            return '/assets/images/document.png';
                        else
                            return '/assets/images/paper-clip.png';
                    },
                    getToday: function(symbol = '-') {
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = yyyy + symbol + mm + symbol + dd;

                        return this.customFormatter(today);
                    },
                    submitForm: function() {
                        isChangeStatus = false;
                        $('#repair-form').submit();
                    },

                    fnExcelRecord() {
                        var tab_text = "";
                        tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                        real_tab = document.getElementById('table-record-list');
                        var tab = real_tab.cloneNode(true);
                        tab_text=tab_text+"<tr><td colspan='8' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + recordVue.tableTitle + "</td></tr>";
                        
                        
                        for(var j = 0; j < tab.rows.length ; j++)
                        {
                            if (j == 0) {
                                tab.rows[j].childNodes[0].remove();
                                for (var i=0; i<tab.rows[j].childElementCount*2;i++) {
                                    if (tab.rows[j].childNodes[i].nodeName != "#text")
                                    {
                                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                    }
                                }
                                tab.rows[0].childNodes[1].style.width = "80px";
                                tab.rows[0].childNodes[3].style.width = "100px";
                                tab.rows[0].childNodes[5].style.width = "60px";
                                tab.rows[0].childNodes[7].style.width = "90px";
                                tab.rows[0].childNodes[9].style.width = "100px";
                                tab.rows[0].childNodes[11].style.width = "300px";
                                tab.rows[0].childNodes[13].style.width = "100px";
                                tab.rows[0].childNodes[15].style.width = "400px";
                            }
                            
                            tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                        }
                        tab_text=tab_text+"</table>";
                        tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
                        tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
                        tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");
                        
                        var filename = recordVue.tableTitle;
                        exportExcel(tab_text, filename, filename);
                        
                        return 0;
                    }
                },
                updated() {
                    $('.date-picker').datepicker({
                        autoclose: true,
                    }).next().on(ace.click_event, function () {
                        $(this).prev().focus();
                    });

                    offAutoCmplt();
                }
            });

            $.ajax({
                url: BASE_URL + 'ajax/repair/search',
                type: 'post',
                data: {
                    ship_id: recordVue.shipId,
                    year: recordVue.activeYear,
                    month: recordVue.activeMonth
                },
                success: function(data, status, xhr) {
                    console.log(data);
                    let result = data;
                    recordVue.list = result;

                    recordVue.tableTitle = $_this.shipName + ' ' + $_this.activeYear + '年' + $_this.activeMonth + '月维修保养';
                }
            });
        }

        function getInitInfo() {
            $.ajax({
                url: BASE_URL + 'ajax/repair/report',
                type: 'post',
                data: {
                    ship_id: $_this.shipId,
                    year: $_this.activeYear,
                    type: $_this.search_type,
                },
                success: function(data, status, xhr) {
                    console.log(data);
                    let result = data;
                    $_this.list = data.list;
                    $_this.total = data.total;

                    $_this.tableTitle = $_this.shipName + ' ' + $_this.activeYear + '年' + '维修保养';
                }
            });
        }

        function getRecord(year, type, value, init = false) {
            $.ajax({
                url: BASE_URL + 'ajax/repair/search',
                type: 'post',
                data: {
                    ship_id: $_this.shipId,
                    year: year,
                    type: type, // 1.部门 2.担任 3.种类
                    value: value, // Value of type,
                    init: init
                },
                success: function(data, status, xhr) {
                    let result = data;
                    recordVue.list = result;
                    if(type == '{{ REPAIR_REPORT_TYPE_DEPART }}') {
                        recordVue.activeDepart = value;
                        recordVue.activeCharge = 0;
                        recordVue.activeType = 0;
                    } else if(type == '{{ REPAIR_REPORT_TYPE_CHARGE }}') {
                        recordVue.activeDepart = 0;
                        recordVue.activeCharge = value;
                        recordVue.activeType = 0;
                    } else {
                        recordVue.activeDepart = 0;
                        recordVue.activeCharge = 0;
                        recordVue.activeType = value;
                    }
                    
                    recordVue.tableTitle = $_this.shipName + ' ' + $_this.activeYear + '年' + '维修保养';
                    $('#report-link').removeClass('active');
                    $('#data-link').addClass('active');
                    $('#report-list-div').removeClass('active');
                    $('#data-list-div').addClass('active');
                }
            });
        }

    </script>
@endsection