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

@section('scripts')

@endsection

@section('content')
    <link href="{{ cAsset('assets/js/chartjs/chartist.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ cAsset('assets/js/chartjs/c3.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ cAsset('assets/js/chartjs/flot.css') }}">
    
    <script src="{{ cAsset('assets/js/chartjs/chartist.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/chartjs.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/d3.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/c3.js') }}"></script>
    <script src="{{ cAsset('assets/js/chartjs/flot.js') }}"></script>
    
    <div class="main-content">
        <style>
            .filter_row {
                background-color: #45f7ef;
            }
            .chosen-drop {
                width : 350px !important;
            }
            [v-cloak] { display: none; }
            table tbody tr td {
                padding: 0!important;
            }
            .form-control {
                padding: 0!important;
            }
        </style>
        <div class="page-header">
            <div class="col-md-3">
                <h4>
                    <b class="page-title">燃油管理</b>
                </h4>
            </div>
        </div>
        <div class="page-content" id="search-div" v-cloak>
            <div class="row">
                <div class="col-md-12 align-bottom">
                    <div class="col-md-3">
                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                        <select class="custom-select d-inline-block" style="padding: 4px;max-width: 100px;" @change="changeShip" v-model="shipId">
                            @foreach($shipList as $ship)
                                <option value="{{ $ship['IMO_No'] }}"
                                        {{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}
                                </option>
                            @endforeach
                        </select>

                        <select class="text-center" name="year_list" @change="onChangeYear" v-model="activeYear">
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}年</option>
                            @endforeach
                        </select>

                        <label class="font-bold ml-1 text-danger" v-show="record_type == 'all'">航次:</label>
                        <select class="text-center" style="width: 60px;" name="voy_list" @change="onChangeVoy" v-model="activeVoy" v-show="record_type == 'all'">
                            <template v-for="voyItem in voy_list">
                                <option :value="voyItem.Voy_No">@{{ voyItem.Voy_No }}</option>
                            </template>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex f-right">
                            <strong class="f-right" style="font-size: 16px; padding-top: 6px;">
                                <span id="search_info">{{ $shipName }}</span>&nbsp;<span class="font-bold">@{{ activeYear }}年@{{ page_title }}</span>
                            </strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-group f-right">
                            <a class="btn btn-sm btn-purple" @click="openNewPage('soa')"><i class="icon-asterisk"></i> SOA</a>
                            <a class="btn btn-sm btn-dynamic" @click="openNewPage('dynamic')"><i class="icon-bar-chart"></i> 动态分析</a>
                            <button class="btn btn-sm btn-success" id="submit" @click="submitForm"><i class="icon-save"></i>保存</button>
                            <button class="btn btn-warning btn-sm save-btn" @click="fnExcelTableReport"><i class="icon-table"></i> {{ trans('common.label.excel') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Contents Begin -->
            <div class="row" style="margin-top: 4px;">
                <div class="col-md-12">
                    <div class="head-fix-div common-list">
                        <form method="post" action="fuelSave" enctype="multipart/form-data" id="record-form">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="shipId" value="{{ $shipId }}">
                            <input type="hidden" name="year" v-model="activeYear">
                            <table class="dynamic-table table-striped" id="table-fuel-list">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2" style="width: 4%;">航次</th>
                                            <th class="text-center" rowspan="2" style="width: 3%;">平均<br>速度</th>
                                            <th class="text-center" colspan="3" style="padding: 8px;">油槽测量(起)(MT)</th>
                                            <th class="text-center" colspan="3">油槽测量(止)(MT)</th>
                                            <th class="text-center" colspan="2">总消耗(MT)</th>
                                            <th class="text-center" colspan="2" style="border-right: 2px solid #ff9207;">-节约/+超过(MT)</th>
                                            <th class="text-center" colspan="2">加油量(MT)</th>
                                            <th class="text-center" rowspan="2" style="width: 7%;">油款($)</th>
                                            <th class="text-center" colspan="3" style="border-right: 2px solid #ff9207;">油价($/MT)</th>
                                            <th class="text-center" rowspan="2" >备注</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="width: 5%;">FO</th>
                                            <th class="text-center" style="width: 4%;">DO</th>
                                            <th class="text-center" style="min-width: 40px;">报告</th>
                                            <th class="text-center" style="width: 5%;">FO</th>
                                            <th class="text-center" style="width: 4%;">DO</th>
                                            <th class="text-center" style="min-width: 40px;">报告</th>
                                            <th class="text-center" style="width: 4%;">FO</th>
                                            <th class="text-center" style="width: 4%;">DO</th>
                                            <th class="text-center" style="width: 4%;">FO</th>
                                            <th class="text-center" style="border-right: 2px solid #ff9207; width: 4%;">DO</th>
                                            <th class="text-center" style="width: 5%;">FO</th>
                                            <th class="text-center" style="width: 5%;">DO</th>
                                            <th class="text-center" style="width: 5%;">FO</th>
                                            <th class="text-center" style="width: 5%;">DO</th>
                                            <th class="text-center" style="border-right: 2px solid #ff9207;width: 5%;">其他费</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <template v-for="(item, index) in analyze.list" v-cloak>
                                        <tr :class="index % 2 == 0 ? 'even' : 'odd'">
                                            <td class="center d-none">
                                                <input type="hidden" name="id[]" v-model="item.id">
                                                <input type="hidden" name="used_fo[]" v-model="item.used_fo">
                                                <input type="hidden" name="used_do[]" v-model="item.used_do">
                                            </td>
                                            <td class="center">
                                                <input type="text" class="form-control text-center" name="voy_no[]" v-model="item.voy_no" readonly>
                                            </td>
                                            <td class="center">
                                                <my-currency-input v-model="item.avg_speed" class="form-control text-center" :style="debitClass(item.up_rob_fo)" name="avg_speed[]" v-bind:prefix="''" v-bind:fixednumber="1" v-bind:index="index" :readonly="true"></my-currency-input>
                                            </td>
                                            <td class="center">
                                                <my-currency-input v-model="item.up_rob_fo" class="form-control text-center" :style="debitClass(item.up_rob_fo)" name="up_rob_fo[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            <td class="center">
                                                <my-currency-input v-model="item.up_rob_do" class="form-control text-center" :style="debitClass(item.up_rob_do)" name="up_rob_do[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center" style="width: 3%;">
                                                <a :href="item.attachment_link_up" target="_blank"><img src="/assets/images/document.png" v-show="item.attachment_link_up != '' && item.attachment_link_up != null" width="15" height="15" style="cursor: pointer;"></a>
                                                <label v-bind:for="index + 'up'">
                                                    <img src="/assets/images/paper-clip.png" width="15" height="15" v-show="item.attachment_link_up == '' || item.attachment_link_up == null" style="cursor: pointer;" v-bind:title="item.file_name">
                                                </label>
                                                <input type="file" name="attachment_up[]" v-bind:id="index + 'up'" class="d-none" @change="onFileChange($event, 'up')" v-bind:data-index="index">
                                                <input type="hidden" name="is_up_update[]" v-bind:id="index + 'up_status'" class="d-none" v-bind:value="item.is_up_attach">
                                                <img v-bind:src="getClose()" width="10" height="10" style="cursor: pointer;" v-show="item.up_file_name != ''" @click="removeFile(index, 'up')">
                                            </td>

                                            <td class="center">
                                                <my-currency-input v-model="item.down_rob_fo" :style="debitClass(item.down_rob_fo)" class="form-control text-center" name="down_rob_fo[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center">
                                                <my-currency-input v-model="item.down_rob_do" :style="debitClass(item.down_rob_do)" class="form-control text-center" name="down_rob_do[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center" style="width: 3%;">
                                                <a :href="item.attachment_link_down" target="_blank"><img src="/assets/images/document.png" v-show="item.attachment_link_down != '' && item.attachment_link_down != null" width="15" height="15" style="cursor: pointer;"></a>
                                                <label v-bind:for="index + 'down'">
                                                    <img src="/assets/images/paper-clip.png" v-show="item.attachment_link_down == '' || item.attachment_link_down == null" width="15" height="15" style="cursor: pointer;" v-bind:title="item.file_name">
                                                </label>
                                                <input type="file" name="attachment_down[]" v-bind:id="index + 'down'" class="d-none" @change="onFileChange($event, 'down')" v-bind:data-index="index">
                                                <input type="hidden" name="is_down_update[]" v-bind:id="index + 'down_status'" class="d-none" v-bind:value="item.is_down_attach">
                                                <img v-bind:src="getClose()" width="10" height="10" style="cursor: pointer;" v-show="item.down_file_name != ''" @click="removeFile(index, 'down')">
                                            </td>


                                            <td class="center">
                                                <my-currency-input v-model="item.rob_fo" :style="debitClass(item.rob_fo)" class="form-control text-center" name="rob_fo[]" :readonly="true" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center">
                                                <my-currency-input v-model="item.rob_do" :style="debitClass(item.rob_do)" class="form-control text-center" name="rob_do[]" :readonly="true" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>

                                            <td class="center">
                                                <my-currency-input v-model="item.saved_fo" :style="debitClass(item.saved_fo)" class="form-control text-center" name="saved_fo[]" :readonly="true" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center" style="border-right: 2px solid #ff9207;">
                                                <my-currency-input v-model="item.saved_do" :style="debitClass(item.saved_do)" class="form-control text-center" name="saved_do[]" :readonly="true" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>

                                            <td class="center">
                                                <my-currency-input v-model="item.bunk_fo" :style="debitClass(item.bunk_fo, 1)" class="form-control text-center" name="bunk_fo[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center">
                                                <my-currency-input v-model="item.bunk_do" :style="debitClass(item.bunk_do, 1)" class="form-control text-center" name="bunk_do[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>

                                            <td class="center">
                                                <my-currency-input v-model="item.fuelSum" :style="debitClass(item.fuelSum, 1)" class="form-control text-center" name="fuelSum[]" :readonly="true" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center">
                                                <my-currency-input v-model="item.oil_price_fo" :style="debitClass(item.oil_price_fo)" class="form-control text-center" name="oil_price_fo[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center">
                                                <my-currency-input v-model="item.oil_price_do" :style="debitClass(item.oil_price_do)" class="form-control text-center" name="oil_price_do[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center" style="border-right: 2px solid #ff9207;">
                                                <my-currency-input v-model="item.oil_price_else" :style="debitClass(item.oil_price_else)" class="form-control text-center" name="oil_price_else[]" :readonly="true" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                                            </td>
                                            <td class="center">
                                                <textarea class="form-control" name="remark[]" rows="1" style="resize: none; padding: 0 2px!important;" maxlength="50" autocomplete="off" v-model="item.remark"></textarea>
                                            </td>
                                        </tr>
                                    </template>

                                    <tr class="dynamic-footer bt-0">
                                        <td class="center" style="padding: 4px!important;">@{{ number_format(analyze.total.voy_count, 0) }}</td>
                                        <td class="center">@{{ number_format(analyze.total.average_speed) }}</td>
                                        <td class="center"></td>
                                        <td class="center"></td>
                                        <td class="center"></td>
                                        <td class="center"></td>
                                        <td class="center"></td>
                                        <td class="center"></td>
                                        <td class="center">@{{ number_format(analyze.total.total_rob_fo, 2) }}</td>
                                        <td class="center">@{{ number_format(analyze.total.total_rob_do, 2) }}</td>
                                        <td class="center">@{{ number_format(analyze.total.total_saved_fo, 2) }}</td>
                                        <td class="center" style="border-right: 2px solid #ff9207;">@{{ number_format(analyze.total.total_saved_do, 2) }}</td>
                                        <td class="center">@{{ number_format(analyze.total.total_bunk_fo, 2) }}</td>
                                        <td class="center">@{{ number_format(analyze.total.total_bunk_do, 2) }}</td>
                                        <td class="center">@{{ number_format(analyze.total.total_fuelSum, 2) }}</td>
                                        <td class="center">@{{ number_format(analyze.total.total_oil_price_fo, 2) }}</td>
                                        <td class="center">@{{ number_format(analyze.total.total_oil_price_do, 2) }}</td>
                                        <td class="center" style="border-right: 2px solid #ff9207;">@{{ number_format(analyze.total.total_oil_price_else, 2) }}</td>
                                        <td class="center"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>            
            <!-- Main Contents End -->
        </div>
    </div>

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ cAsset('assets/js/bignumber.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue-numeral-filter.min.js') }}"></script>
    <script src="{{ asset('/assets/js/dycombo.js') }}"></script>

	<?php
	echo '<script>';
    echo 'var DynamicStatus = ' . json_encode(g_enum('DynamicStatus')) . ';';
    echo 'var DynamicSub = ' . json_encode(g_enum('DynamicSub')) . ';';
	echo '</script>';
	?>

    <script>
        var searchObj = null;
        var $_this = null;
        var shipId = '{!! $shipId !!}';
        var shipInfo = '{!! $shipInfo !!}';
        shipInfo=shipInfo.replaceAll(/\n/g, "\\n").replaceAll(/\r/g, "\\r").replaceAll(/\t/g, "\\t");
        shipInfo = JSON.parse(shipInfo);
        var DYNAMIC_SUB_SALING = '{!! DYNAMIC_SUB_SALING !!}';
        var DYNAMIC_SUB_LOADING = '{!! DYNAMIC_SUB_LOADING !!}';
        var DYNAMIC_SUB_DISCH = '{!! DYNAMIC_SUB_DISCH !!}';
        var DYNAMIC_SUB_WAITING = '{!! DYNAMIC_SUB_WAITING !!}';
        var DYNAMIC_SUB_WEATHER = '{!! DYNAMIC_SUB_WEATHER !!}';
        var DYNAMIC_SUB_REPAIR = '{!! DYNAMIC_SUB_REPAIR !!}';
        var DYNAMIC_SUB_SUPPLY = '{!! DYNAMIC_SUB_SUPPLY !!}';
        var DYNAMIC_SUB_ELSE = '{!! DYNAMIC_SUB_ELSE !!}';

        var IS_FILE_KEEP = '{!! IS_FILE_KEEP !!}';
        var IS_FILE_DELETE = '{!! IS_FILE_DELETE !!}';
        var IS_FILE_UPDATE = '{!! IS_FILE_UPDATE !!}';

        
        var DYNAMIC_SAILING = '{!! DYNAMIC_SAILING !!}';
        var DYNAMIC_CMPLT_DISCH = '{!! DYNAMIC_CMPLT_DISCH !!}';
        const DAY_UNIT = 1000 * 3600;
        const COMMON_DECIMAL = 2;
        var economic_graph = null;
        var activeYear = '{!! $activeYear !!}';

        var isChangeStatus = false;
        var searchObjTmp = [];
        var submitted = false;
        var tmp;

        $("form").submit(function() {
            submitted = true;
        });

        var $form = '';
        var origForm = "";
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.';
            let newForm = $('#record-form').serialize();

            if (isChangeStatus && !submitted) {
                (e || window.event).returnValue = confirmationMessage;
            }

            return confirmationMessage;
        });

        Vue.component('my-currency-input', {
            props: ["value", "fixednumber", 'prefix', 'type', 'index'],
            template: `
                    <input type="text" v-model="displayValue" @blur="isInputActive = false" @focus="isInputActive = true; $event.target.select()" @change="calcValue" v-on:keyup="keymonitor" />
                `,
            data: function() {
                return {
                    isInputActive: false
                }
            },

            computed: {
                displayValue: {
                    get: function() {
                        if (this.isInputActive) {
                            if(isNaN(this.value))
                                return '';

                            return this.value == 0 ? '' : this.value;
                        } else {
                            let fixedLength = 1;
                            let prefix = '$ ';
                            if(this.fixednumber != undefined)
                                fixedLength = this.fixednumber;

                            if(this.prefix != undefined)
                                prefix = this.prefix + ' ';
                            
                            if(this.value == 0 || this.value == undefined || isNaN(this.value))
                                return '';
                            
                            return prefix + number_format(this.value, fixedLength);
                        }
                    },
                    set: function(modifiedValue) {
                        if (modifiedValue == 0 || modifiedValue == undefined || isNaN(modifiedValue)) {
                            modifiedValue = 0
                        }
                        
                        this.$emit('input', parseFloat(modifiedValue));
                    },
                },
            },
            methods: {
                calcValue: function() {
                    isChangeStatus = true;
                    searchObj.calcValue();
                },
                keymonitor: function(e) {
                    if(e.keyCode == 9 || e.keyCode == 13)
                        $(e.target).select()
                },
                setValue: function() {

                }
            },
            watch: {
                setFocus: function(e) {
                    $(e.target).select();
                }
            }
        });

        $(function() {
            initialize();
        });

        function initialize() {
            searchObj = new Vue({
                el: '#search-div',
                data: {
                    shipId: 0,
                    shipName: '',
                    ship_list: [],
                    voy_list: [],
                    port: {
                        loading: '',
                        discharge: '',
                    },
                    activeVoy: 0,
                    activeYear: activeYear,

                    prevData: [],
                    currentData: {

                    },

                    dynamicStatus: DynamicStatus,

                    sail_term: {
                        min_date: '0000-00-00',
                        max_date: '0000-00-00',
                    },

                    sail_time:              0,
                    total_distance:         0,
                    total_sail_time:        0,
                    total_loading_time:     0,
                    economic_rate:          0,
                    average_speed:          0,

                    rob_fo:                 0,
                    rob_do:                 0,
                    bunker_fo:              0,
                    bunker_do:              0,

                    used_fo:                0,
                    used_do:                0,
                    save_fo:                0,
                    save_do:                0,

                    record_type:            'analyze',
                    page_title:             '燃油分析',

                    analyze: {
                        list: [],
                        total: [],
                        xAxis: [],
                        xAxisLabel: [],
                    }
                },
                init: function() {
                    this.changeShip();
                },
                methods: {
                    changeShip: function(evt) {
                        location.href = '/shipManage/fuelManage?shipId=' + $(evt.target).val();
                    },
                    getShipName: function(shipName, EnName) {
                        return shipName == '' ? EnName : shipName;
                    },
                    getVoyList: function(shipId = '') {
                        $.ajax({
                            url: BASE_URL + 'ajax/business/voy/list',
                            type: 'post',
                            data: {
                                shipId: this.shipId,
                                year: this.activeYear
                            },
                            success: function(result) {
                                searchObj.voy_list = [];
                                searchObj.voy_list = Object.assign([], [], result['cp_list']);
                                if(searchObj.voy_list.length > 0) {
                                    searchObj.activeVoy = searchObj.voy_list[0]['Voy_No'];
                                }

                                $_this.getAnalyzeData();
                            }
                        });
                    },
                    openNewPage: function(type) {
                        if(type == 'soa') {
                            //window.open(BASE_URL + 'business/contract?shipId=' + this.shipId, '_blank');
                            window.localStorage.setItem("soa_shipid",this.shipId);
                            window.open(BASE_URL + 'operation/incomeExpense', '_blank');
                        } else {
                            window.open(BASE_URL + 'shipManage/dynamicList?shipId=' + this.shipId + '&year=' + this.activeYear + '&type=analyze', '_blank');
                        }
                    },
                    number_format: function(value, decimal = 1) {
                        return isNaN(value) || value == 0 || value == null || value == undefined ? '' : number_format(value, decimal);
                    },
                    onChangeVoy: function(evt) {

                    },
                    debitClass: function(value, profit = 0) {
                        if(profit == 0) {
                            color = 'red';
                            return __parseFloat(value) >= 0 ? '' : 'color: '+color+'!important';
                        } else {
                            color = '#026fcd';
                            return __parseFloat(value) < 0 ? 'color: red!important;' : 'color: '+color+'!important';
                        }
                    },
                    onTypeChange(val) {
                        this.page_title = '燃油管理';
                        $('.page-title').text('燃油管理');
                        this.getAnalyzeData();
                    },
                    onChangeYear: function(e) {
                        var newVal = this.activeYear;
                        var confirmationMessage = 'It looks like you have been editing something. '
                                + 'If you leave before saving, your changes will be lost.';

                        if (!submitted && isChangeStatus) {
                            __alertAudio();
                            this.activeYear = tmp;
                            bootbox.confirm(confirmationMessage, function (result) {
                                if (!result) {
                                    return;
                                } else {
                                    searchObj.activeYear = newVal;
                                    searchObj.getVoyList();
                                }
                            });
                        } else {
                            this.getVoyList();
                        }
                    },
                    onVoyDetail(index) {
                        this.activeVoy = index;
                        this.record_type = 'all';
                        this.$forceUpdate();
                        this.setPortName();
                        this.getData();
                    },
                    getImage: function(file_name) {
                        if(file_name != '' && file_name != undefined)
                            return '/assets/images/document.png';
                        else
                            return '/assets/images/paper-clip.png';
                    },
                    getClose: function() {
                        return '/assets/images/cancel.png';
                    },
                    onFileChange(e, type) {
                        let index = e.target.getAttribute('data-index');
                        this.analyze.list[index]['is_attach'] = IS_FILE_UPDATE;
                        this.analyze.list[index][type + '_file_name'] = 'updated';
                        this.analyze.list[index]['attachment_link_' + type] = 1;
                        this.analyze.list[index]['is_' + type + '_attach'] = IS_FILE_UPDATE;
                        isChangeStatus = true;
                        this.$forceUpdate();
                    },
                    removeFile(index, type) {
                        this.analyze.list[index][type + '_file_name'] = '';
                        this.analyze.list[index]['attachment_link_' + type] = '';
                        this.analyze.list[index]['is_' + type + '_attach'] = IS_FILE_DELETE;
                        $('#' + index + 'up').val('');
                        this.$forceUpdate();
                        // $('#tc_file_remove').val(1);
                    },
                    calcValue: function() {
                        
                        // let usedFoTmp1 = BigNumber(total_sail_time).multipliedBy(shipInfo['FOSailCons_S']).toFixed(1);
                        // let usedFoTmp2 = BigNumber(loading_time).multipliedBy(shipInfo['FOL/DCons_S']).toFixed(1);
                        // let usedFoTmp3 = BigNumber(total_waiting_time).multipliedBy(shipInfo['FOIdleCons_S']).toFixed(1);

                        // let usedDoTmp1 = BigNumber(total_sail_time).multipliedBy(shipInfo['DOSailCons_S']).toFixed(1);
                        // let usedDoTmp2 = BigNumber(loading_time).multipliedBy(shipInfo['DOL/DCons_S']).toFixed(1);
                        // let usedDoTmp3 = BigNumber(total_waiting_time).multipliedBy(shipInfo['DOIdleCons_S']).toFixed(1);

                        // realData.used_fo = BigNumber(usedFoTmp1).plus(usedFoTmp2).plus(usedFoTmp3).toFixed(1);
                        // realData.used_do = BigNumber(usedDoTmp1).plus(usedDoTmp2).plus(usedDoTmp3).toFixed(1);
                        let $_this = this.analyze.list;
                        this.analyze.list.forEach(function(realData, key) {
                            searchObj.analyze.list[key].bunk_fo = __parseFloat(searchObj.analyze.list[key].bunk_fo);
                            searchObj.analyze.list[key].bunk_do = __parseFloat(searchObj.analyze.list[key].bunk_do);

                            searchObj.analyze.list[key].rob_fo = __parseFloat(BigNumber(realData.up_rob_fo).plus(realData.bunk_fo).minus(realData.down_rob_fo).toFixed(2));
                            searchObj.analyze.list[key].rob_do = __parseFloat(BigNumber(realData.up_rob_do).plus(realData.bunk_do).minus(realData.down_rob_do).toFixed(2));

                            searchObj.analyze.list[key].saved_fo = __parseFloat(BigNumber($_this[key].rob_fo).minus(realData.used_fo).toFixed(2));
                            searchObj.analyze.list[key].saved_do = __parseFloat(BigNumber($_this[key].rob_do).minus(realData.used_do).toFixed(2));

                            let else_price1 = BigNumber(realData.bunk_fo).multipliedBy(realData.oil_price_fo).toFixed(2);
                            let else_price2 = BigNumber(realData.bunk_do).multipliedBy(realData.oil_price_do).toFixed(2);
                            
                            if(__parseFloat(realData.fuelSum) != 0)
                                searchObj.analyze.list[key].oil_price_else = BigNumber(__parseFloat(realData.fuelSum)).minus(__parseFloat(else_price1)).minus(__parseFloat(else_price2)).toFixed(2);
							else
								searchObj.analyze.list[key].oil_price_else = 0;
                        });

                        this.calculate();

                    },
                    calculate: function() {
                        let length = searchObj.analyze.list.length;
                        let $_this = searchObj.analyze.list;
                        let footerData = [];
                        footerData['average_speed'] = 0;

                        footerData['total_up_rob_fo'] = 0;
                        footerData['total_up_rob_do'] = 0;
                        footerData['total_down_rob_fo'] = 0;
                        footerData['total_down_rob_do'] = 0;

                        footerData['total_rob_fo'] = 0;
                        footerData['total_rob_do'] = 0;
                        footerData['total_saved_fo'] = 0;
                        footerData['total_saved_do'] = 0;

                        footerData['total_bunk_fo'] = 0;
                        footerData['total_bunk_do'] = 0;

                        footerData['total_fuelSum'] = 0;

                        footerData['total_oil_price'] = 0;

                        footerData['total_oil_price_fo'] = 0;
                        footerData['total_oil_price_do'] = 0;
                        footerData['total_oil_price_else'] = 0;
                        footerData['voy_count'] = length;

                        searchObj.analyze.list.forEach(function(data, key) {
                            if($_this[key].is_up_attach == 1 || $_this[key].is_up_attach == null)
                                searchObj.analyze.list[key].up_file_name = '';
                            else
                                searchObj.analyze.list[key].up_file_name = 'exist';

                            if($_this[key].is_down_attach == 1 || $_this[key].is_down_attach == null)
                                searchObj.analyze.list[key].down_file_name = '';
                            else
                                searchObj.analyze.list[key].down_file_name = 'exist';

                            $_this[key].up_rob_fo = __parseFloat(data.up_rob_fo);
                            $_this[key].up_rob_do = __parseFloat(data.up_rob_do);
                            $_this[key].down_rob_fo = __parseFloat(data.down_rob_fo);
                            $_this[key].down_rob_do = __parseFloat(data.down_rob_do);
                            $_this[key].save_fo = __parseFloat(data.save_fo);
                            $_this[key].save_do = __parseFloat(data.save_do);
                            $_this[key].bunk_fo = __parseFloat(data.bunk_fo);
                            $_this[key].bunk_do = __parseFloat(data.bunk_do);
                            $_this[key].fuelSum = __parseFloat(data.fuelSum);

                            $_this[key].oil_price_fo = __parseFloat(data.oil_price_fo);
                            $_this[key].oil_price_do = __parseFloat(data.oil_price_do);
                            $_this[key].oil_price_else = __parseFloat(data.oil_price_else);


                            footerData['average_speed'] += __parseFloat(BigNumber(data.avg_speed).div(length).toFixed(1));

                            footerData['total_up_rob_fo'] += __parseFloat(BigNumber(data.up_rob_fo).toFixed(2));
                            footerData['total_up_rob_do'] += __parseFloat(BigNumber(data.up_rob_do).toFixed(2));
                            footerData['total_down_rob_fo'] += __parseFloat(BigNumber(data.down_rob_fo).toFixed(2));
                            footerData['total_down_rob_do'] += __parseFloat(BigNumber(data.down_rob_do).toFixed(2));

                            footerData['total_rob_fo'] += __parseFloat(BigNumber(data.rob_fo).toFixed(2));
                            footerData['total_rob_do'] += __parseFloat(BigNumber(data.rob_do).toFixed(2));
                            footerData['total_saved_fo'] += __parseFloat(BigNumber(data.saved_fo).toFixed(2));
                            footerData['total_saved_do'] += __parseFloat(BigNumber(data.saved_do).toFixed(2));

                            footerData['total_bunk_fo'] += __parseFloat(BigNumber(data.bunk_fo).toFixed(2));
                            footerData['total_bunk_do'] += __parseFloat(BigNumber(data.bunk_do).toFixed(2));

                            footerData['total_fuelSum'] += __parseFloat(BigNumber(data.fuelSum).toFixed(2));
                            footerData['total_oil_price_fo'] += __parseFloat(BigNumber(data.oil_price_fo).div(length).toFixed(2));
                            footerData['total_oil_price_do'] += __parseFloat(BigNumber(data.oil_price_do).div(length).toFixed(2));
                            footerData['total_oil_price_else'] += __parseFloat(BigNumber(data.oil_price_else).div(length).toFixed(2));
                        });
                        
                        searchObj.analyze.total = footerData;
                    },
                    getAnalyzeData() {
                        let $_this = this.analyze.list;
                        $_this = [];
                        $.ajax({
                            url: BASE_URL + 'ajax/shipManage/dynamic/search',
                            type: 'post', 
                            data: {
                                shipId: searchObj.shipId,
                                voyId: searchObj.activeVoy,
                                type: searchObj.record_type,
                                year: searchObj.activeYear
                            },
                            success: function(result) {
                                let currentData = result['currentData'];
                                let voyData = result['voyData'];
                                let cpData = result['cpData'];

                                searchObj.analyze.list = [];
                                let realData = [];
                                let footerData = [];
                                footerData['voy_count'] = 0;
                                footerData['sail_time'] = 0;
                                footerData['average_speed'] = 0;
                                footerData['total_distance'] = 0;
                                footerData['total_sail_time'] = 0;
                                footerData['total_loading_time'] = 0;
                                footerData['loading_time'] = 0;
                                footerData['disch_time'] = 0;
                                footerData['total_waiting_time'] = 0;
                                footerData['total_weather_time'] = 0;
                                footerData['total_repair_time'] = 0;
                                footerData['total_supply_time'] = 0;
                                footerData['total_else_time'] = 0;

                                footerData['total_up_rob_fo'] = 0;
                                footerData['total_up_rob_do'] = 0;
                                footerData['total_down_rob_fo'] = 0;
                                footerData['total_down_rob_do'] = 0;

                                footerData['total_rob_fo'] = 0;
                                footerData['total_rob_do'] = 0;
                                footerData['total_saved_fo'] = 0;
                                footerData['total_saved_do'] = 0;

                                footerData['total_bunk_fo'] = 0;
                                footerData['total_bunk_do'] = 0;

                                footerData['total_fuelSum'] = 0;

                                footerData['total_oil_price_fo'] = 0;
                                footerData['total_oil_price_do'] = 0;
                                footerData['total_oil_price_else'] = 0;
                                footerData['voy_count'] = voyData.length;

                                voyData.forEach(function(value, key) {
                                    let voyInfo = currentData[value[0]];
                                    let voyId = value[0];
                                    console.log(voyInfo['main']);
                                    if(!value[1] && voyInfo['main'].length > 0) {
                                        let beforeData = voyInfo['before'];
                                        let tmpData = voyInfo['main'];
                                        let fuleSum = voyInfo['fuelSum'];
                                        
                                        let total_sail_time = 0;
                                        let total_loading_time = 0;
                                        let loading_time = 0;
                                        let disch_time = 0;
                                        let total_waiting_time = 0;
                                        let total_weather_time = 0;
                                        let total_repair_time = 0;
                                        let total_supply_time = 0;
                                        let total_else_time = 0;
                                        let total_distance = 0;

                                        let up_rob_fo = 0;
                                        let up_rob_do = 0;
                                        let down_rob_fo = 0;
                                        let down_rob_do = 0;
                                        let bunk_fo = 0;
                                        let bunk_do = 0;
                                        let used_rob_fo = 0;
                                        let used_rob_do = 0;

                                        let fuelSum = 0;
                                        let oil_price_fo = 0;
                                        let oil_price_do = 0;


                                        realData = [];
                                        realData['voy_no'] = value[0];
                                        realData['voy_count'] = tmpData.length;
                                        realData['voy_start'] = beforeData['Voy_Date'];
                                        realData['voy_end'] = tmpData[tmpData.length - 1]['Voy_Date'];

                                        realData.fuelSum = __parseFloat(fuleSum) == 0 ? '-' : __parseFloat(fuleSum);
                                        realData.up_rob_fo = 0;
                                        realData.up_rob_do = 0;
                                        realData.down_rob_fo = 0;
                                        realData.down_rob_do = 0;

                                        tmpData.forEach(function(data_value, data_key) {
                                            total_distance += __parseFloat(data_value["Sail_Distance"]);
                                            bunk_fo += __parseFloat(data_value['BUNK_FO']);
                                            bunk_do += __parseFloat(data_value['BUNK_DO']);
                                            if(data_key > 0) {
                                                if(data_value['Voy_Type'] == DYNAMIC_SUB_SALING) {
                                                    let preKey = data_key - 1;
                                                    let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                                    let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                                    total_sail_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                                }

                                                if(data_value['Voy_Type'] == DYNAMIC_SUB_LOADING) {
                                                    let preKey = data_key - 1;
                                                    let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                                    let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                                    loading_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                                }

                                                if(data_value['Voy_Type'] == DYNAMIC_SUB_DISCH) {
                                                    let preKey = data_key - 1;
                                                    let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                                    let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                                    disch_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                                }

                                                if(data_value['Voy_Type'] == DYNAMIC_SUB_WAITING) {
                                                    let preKey = data_key - 1;
                                                    let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                                    let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                                    total_waiting_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                                }

                                                if(data_value['Voy_Type'] == DYNAMIC_SUB_WEATHER) {
                                                    let preKey = data_key - 1;
                                                    let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                                    let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'] + ':00';
                                                    total_weather_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                                }

                                                if(data_value['Voy_Type'] == DYNAMIC_SUB_REPAIR) {
                                                    let preKey = data_key - 1;
                                                    let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                                    let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                                    total_repair_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                                }

                                                if(data_value['Voy_Type'] == DYNAMIC_SUB_SUPPLY) {
                                                    let preKey = data_key - 1;
                                                    let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                                    let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                                    total_supply_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                                }

                                                if(data_value['Voy_Type'] == DYNAMIC_SUB_ELSE) {
                                                    let preKey = data_key - 1;
                                                    let start_date = tmpData[preKey]['Voy_Date'] + ' ' + tmpData[preKey]['Voy_Hour'] + ':' + tmpData[preKey]['Voy_Minute'] + ':00';
                                                    let end_date = data_value['Voy_Date'] + ' ' + data_value['Voy_Hour'] + ':' + data_value['Voy_Minute'];
                                                    total_else_time += __getTermDay(start_date, end_date, tmpData[preKey]['GMT'], data_value['GMT']);
                                                    //if(value == '2017') console.log(total_else_time)
                                                }
                                            }
                                        });

                                        if(tmpData.length > 0) {
                                            let length = tmpData.length;
                                            up_rob_fo = __parseFloat(beforeData['ROB_FO']);
                                            up_rob_do = __parseFloat(beforeData['ROB_DO']);

                                            down_rob_fo = __parseFloat(tmpData[length-1]['ROB_FO']);
                                            down_rob_do = __parseFloat(tmpData[length-1]['ROB_DO']);
                                        }
                                        
                                        realData.up_rob_fo = up_rob_fo;
                                        realData.up_rob_do = up_rob_do;
                                        realData.down_rob_fo = down_rob_fo;
                                        realData.down_rob_do = down_rob_do;
                                        realData.bunk_fo = bunk_fo;
                                        realData.bunk_do = bunk_do;

                                        let non_economic_date = BigNumber(__parseFloat(total_waiting_time.toFixed(2))).plus(__parseFloat(total_weather_time.toFixed(2))).plus(__parseFloat(total_repair_time.toFixed(2))).plus(__parseFloat(total_supply_time.toFixed(2))).plus(__parseFloat(total_else_time.toFixed(2))).toFixed(2)
                                        realData.sail_time = __parseFloat(realData.non_economic_date) + __parseFloat(realData.total_loading_time);
                                        let usedFoTmp1 = BigNumber(total_sail_time.toFixed(2)).multipliedBy(shipInfo['FOSailCons_S']);
                                        let usedFoTmp2 = BigNumber(loading_time).plus(disch_time).multipliedBy(shipInfo['FOL/DCons_S']);
                                        let usedFoTmp3 = BigNumber(non_economic_date).multipliedBy(shipInfo['FOIdleCons_S']);

                                        let usedDoTmp1 = BigNumber(total_sail_time.toFixed(2)).multipliedBy(shipInfo['DOSailCons_S']);
                                        let usedDoTmp2 = BigNumber(loading_time).plus(disch_time).multipliedBy(shipInfo['DOL/DCons_S']);
                                        let usedDoTmp3 = BigNumber(non_economic_date).multipliedBy(shipInfo['DOIdleCons_S']);

                                        realData.used_fo = BigNumber(usedFoTmp1).plus(usedFoTmp2).plus(usedFoTmp3).toFixed(2);
                                        realData.used_do = BigNumber(usedDoTmp1).plus(usedDoTmp2).plus(usedDoTmp3).toFixed(2);


                                        realData.rob_fo = BigNumber(up_rob_fo).plus(bunk_fo).minus(down_rob_fo).toFixed(2);
                                        realData.rob_do = BigNumber(up_rob_do).plus(bunk_do).minus(down_rob_do).toFixed(2);

                                        realData.saved_fo = BigNumber(realData.rob_fo).minus(realData.used_fo).toFixed(2);
                                        realData.saved_do = BigNumber(realData.rob_do).minus(realData.used_do).toFixed(2);

                                        realData.oil_price_fo = 0;
                                        realData.oil_price_do = 0;

                                        let else_price1 = BigNumber(realData.bunk_fo).multipliedBy(realData.oil_price_fo).toFixed(2);
                                        let else_price2 = BigNumber(realData.bunk_do).multipliedBy(realData.oil_price_do).toFixed(2);
                                        realData.oil_price_else = BigNumber(fuelSum).minus(else_price1).minus(else_price2).toFixed(2);

                                        realData.total_sail_time = total_sail_time.toFixed(2);
                                        realData.total_distance = total_distance;
                                        if(__parseFloat(total_sail_time) != 0) {
                                            realData.avg_speed = BigNumber(realData.total_distance).div(realData.total_sail_time).div(24).toFixed(1);
                                        } else {
                                            realData.avg_speed = 0;
                                        }
                                        
                                        realData.loading_time = loading_time.toFixed(COMMON_DECIMAL);
                                        realData.disch_time = disch_time.toFixed(COMMON_DECIMAL);
                                        realData.total_loading_time = BigNumber(loading_time).plus(disch_time).plus(total_sail_time).toFixed(2);
                                        realData.economic_rate = BigNumber(loading_time).plus(disch_time).plus(realData.total_sail_time).div(realData.sail_time).multipliedBy(100).toFixed(1);
                                        realData.total_waiting_time = total_waiting_time.toFixed(COMMON_DECIMAL);
                                        realData.total_weather_time = total_weather_time.toFixed(COMMON_DECIMAL);
                                        realData.total_repair_time = total_repair_time.toFixed(COMMON_DECIMAL);
                                        realData.total_supply_time = total_supply_time.toFixed(COMMON_DECIMAL);
                                        realData.total_else_time = total_else_time.toFixed(COMMON_DECIMAL);
                                        realData.up_file_name = '';
                                        realData.down_file_name = '';

                                        searchObj.analyze.list.push(realData);
                                    } else  {
                                        searchObj.analyze.list.push(voyInfo);
                                    }

                                    // Calc Footer data
                                    footerData['sail_time'] += parseInt(realData['sail_time']);
                                    footerData['total_distance'] += parseInt(realData['total_distance']);
                                    footerData['total_sail_time'] += parseFloat(realData['total_sail_time']);
                                    footerData['total_loading_time'] += parseFloat(realData['total_loading_time']);
                                    footerData['loading_time'] += parseFloat(realData['loading_time']);
                                    footerData['disch_time'] += parseFloat(realData['disch_time']);
                                    footerData['total_waiting_time'] += parseFloat(realData['total_waiting_time']);
                                    footerData['total_weather_time'] += parseFloat(realData['total_weather_time']);
                                    footerData['total_repair_time'] += parseFloat(realData['total_repair_time']);
                                    footerData['total_supply_time'] += parseFloat(realData['total_supply_time']);
                                    footerData['total_else_time'] += parseFloat(realData['total_else_time']);
                                    footerData['average_speed'] += __parseFloat(BigNumber(realData.avg_speed).div(voyData.length).toFixed(1));

                                    footerData['total_up_rob_fo'] += __parseFloat(BigNumber(realData.up_rob_fo).toFixed(2));
                                    footerData['total_up_rob_do'] += __parseFloat(BigNumber(realData.up_rob_do).toFixed(2));
                                    footerData['total_down_rob_fo'] += __parseFloat(BigNumber(realData.down_rob_fo).toFixed(2));
                                    footerData['total_down_rob_do'] += __parseFloat(BigNumber(realData.down_rob_do).toFixed(2));

                                    footerData['total_rob_fo'] += __parseFloat(BigNumber(realData.rob_fo).toFixed(2));
                                    footerData['total_rob_do'] += __parseFloat(BigNumber(realData.rob_do).toFixed(2));
                                    footerData['total_saved_fo'] += __parseFloat(BigNumber(realData.saved_fo).toFixed(2));
                                    footerData['total_saved_do'] += __parseFloat(BigNumber(realData.saved_do).toFixed(2));

                                    footerData['total_bunk_fo'] += __parseFloat(BigNumber(realData.bunk_fo).toFixed(2));
                                    footerData['total_bunk_do'] += __parseFloat(BigNumber(realData.bunk_do).toFixed(2));

                                    footerData['total_fuelSum'] += __parseFloat(BigNumber(realData.fuelSum).toFixed(2));

                                    footerData['total_oil_price_fo'] += __parseFloat(BigNumber(realData.oil_price_fo).div(voyData.length).toFixed(2));
                                    footerData['total_oil_price_do'] += __parseFloat(BigNumber(realData.oil_price_do).div(voyData.length).toFixed(2));
                                    footerData['total_oil_price_else'] += __parseFloat(BigNumber(realData.oil_price_else).div(voyData.length).toFixed(2));
                                });

                                searchObj.calculate();
                                footerData['voy_count'] = voyData.length;
                                searchObj.analyze.total = footerData;
                                searchObj.calcValue();

                                isChangeStatus = false;

                                tmp = $('[name=year_list]').val();
                            
                            }
                        });
                    },
                    setTotalInfo: function(data) {
                        searchObj.sail_term['min_date'] = data['min_date'] == false ? '' : data['min_date']['Voy_Date'];
                        searchObj.sail_term['max_date'] = data['max_date'] == false ? '' : data['max_date']['Voy_Date'];
                        let start_date = data['min_date']['Voy_Date'] + ' ' + data['min_date']['Voy_Hour'] + ':' + data['min_date']['Voy_Minute'];
                        let end_date = data['max_date']['Voy_Date'] + ' ' + data['max_date']['Voy_Hour'] + ':' + data['max_date']['Voy_Minute'];
                        
                        this.sail_time = __getTermDay(start_date, end_date, data['min_date']['GMT'], data['max_date']['GMT']);
                    },
                    setPortName: function() {
                        searchObj.voy_list.forEach(function(value, index) {
                            if(searchObj.activeVoy == value['Voy_No']) {
                                searchObj.port['loading'] = value['LPort'] == false ? '-' : value['LPort'];
                                searchObj.port['discharge'] = value['DPort'] == false ? '-' : value['DPort'];
                                status = 1;
                            }
                        });
                    },
                    dateModify(e, index) {
                        $(e.target).on("change", function() {
                            searchObj.currentData[index]['Voy_Date'] = $(this).val();
                        });
                    },
                    onChangeStatus: function(e, index) {
                        let voyStatus = $(e.target).val();
                        searchObj.currentData[index]['dynamicSub'] = getSubList(voyStatus);
                        searchObj.currentData[index]['Voy_Type'] = getSubList(voyStatus)[0][0];
                        searchObj.$forceUpdate();
                    },
                    submitForm: function() {
                        submitted = true;
                        $('#record-form').submit();
                    },
                    dateFormat: function(date, format = '-') {
                        return moment(date).format('MM-DD');
                    },
                    validateForm() {
                        let $this = this.currentData;
                        let retVal = true;
                        $this.forEach(function(value, key) {
                            if($this[key]['Voy_Status'] == DYNAMIC_CMPLT_DISCH) {
                                if($this[key]['Cargo_Qtty'] == 0) {
                                    if($this[key]['ROB_FO'] == undefined || $this[key]['ROB_DO'] == undefined) {
                                        retVal = false;
                                    }
                                }
                            }
                        });

                        return retVal;

                    },
                    getToday: function(symbol) {
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = yyyy + symbol + mm + symbol + dd;

                        return today;
                    },
                    addRow: function() {
                        this.setDefaultData();
                    },
                    setDefaultData() {
                        let length = searchObj.currentData.length;
                        searchObj.currentData.push([]);
                        searchObj.currentData[length]['Voy_Status'] = DYNAMIC_SAILING;
                        searchObj.currentData[length]['dynamicSub'] = getSubList(DYNAMIC_SAILING);
                        searchObj.currentData[length]['Voy_Type'] = DYNAMIC_SUB_SALING;
                        searchObj.currentData[length]['GMT'] = 8;
                        searchObj.currentData[length]['Voy_Hour'] = 8;
                        searchObj.currentData[length]['Voy_Minute'] = 0;
                        searchObj.currentData[length]['Voy_Date'] = this.getToday('-');
                        searchObj.$forceUpdate();
                    },
                    fnExcelTableReport() {
                        var tab_text = "";
                        tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                        real_tab = document.getElementById('table-fuel-list');
                        var tab = real_tab.cloneNode(true);
                        tab_text=tab_text+"<tr><td colspan='19' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_info').html() + " " + searchObj._data.activeYear + "年"+ searchObj._data.page_title + "</td></tr>";
                        
                        for(var j = 0; j < tab.rows.length ; j++)
                        {
                            if (j == 0) {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                }
                            }
                            else if (j == 1) {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                }
                            }
                            else if (j == (tab.rows.length - 1))
                            {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.fontWeight = "bold";
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#ebf1de';
                                }
                            }
                            else
                            {
                                var info = real_tab.rows[j].childNodes[2].childNodes[0].value;
                                tab.rows[j].childNodes[2].innerHTML = info;
                                info = real_tab.rows[j].childNodes[4].childNodes[0].value;
                                tab.rows[j].childNodes[4].innerHTML = info;
                                info = real_tab.rows[j].childNodes[6].childNodes[0].value;
                                tab.rows[j].childNodes[6].innerHTML = info;
                                info = real_tab.rows[j].childNodes[7].childNodes[0].value;
                                tab.rows[j].childNodes[7].innerHTML = info;
                                tab.rows[j].childNodes[9].innerHTML = "";
                                info = real_tab.rows[j].childNodes[11].childNodes[0].value;
                                tab.rows[j].childNodes[11].innerHTML = info;
                                info = real_tab.rows[j].childNodes[13].childNodes[0].value;
                                tab.rows[j].childNodes[13].innerHTML = info;
                                tab.rows[j].childNodes[15].innerHTML = "";
                                info = real_tab.rows[j].childNodes[17].childNodes[0].value;
                                tab.rows[j].childNodes[17].innerHTML = info;
                                for (var i=19;i<38;i+=2) {
                                    info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                                    tab.rows[j].childNodes[i].innerHTML = info;
                                }
                                tab.rows[j].childNodes[0].remove();
                            }
                            tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                        }
                        tab_text=tab_text+"</table>";
                        tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
                        tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
                        tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

                        var filename = $('#search_info').html() + '_' + searchObj._data.activeYear + "年"+ searchObj._data.page_title;
                        exportExcel(tab_text, filename, filename);
                        
                        return 0;
                    },
                    fetchData() {
                        console.log('created')
                    }
                },
                created() {
                    this.fetchData();
                },
                mounted() {
                    console.log('mounted')
                },
                watch() {
                    console.log('watched');
                },
                updated() {
                    console.log('updated')
                    $('.date-picker').datepicker({
                        autoclose: true,
                    }).next().on(ace.click_event, function () {
                        $(this).prev().focus();
                    });

                    offAutoCmplt();

                }
            });

            $_this = searchObj;
            searchObj.shipId = shipId;
            getInitInfo();
        }

        function getInitInfo() {
            $.ajax({
                url: BASE_URL + 'ajax/business/voy/list',
                type: 'post',
                data: {
                    shipId: shipId,
                    year: this.activeYear
                },
                success: function(result) {
                    searchObj.voy_list = [];
                    searchObj.voy_list = Object.assign([], [], result['cp_list']);
                    if(searchObj.voy_list.length > 0) {
                        searchObj.activeVoy = searchObj.voy_list[0]['Voy_No'];
                    }

                    searchObj.setPortName();
                    searchObj.getAnalyzeData();
                }
            });
            // $.ajax({
            //     url: BASE_URL + 'ajax/business/dynamic',
            //     type: 'post',
            //     data: {
            //         shipId: searchObj.shipId,
            //         voyNo: searchObj.voyNo,
            //     }
            //     success: function(result) {
            //         let data = result['shipList'];
            //         searchObj.ship_list = data;
            //     }
            // });
        }

        function getSubList(type) {
            let tmp = DynamicStatus[type][1];
            let retVal = [];
            tmp.forEach(function(value) {
                retVal.push([value, DynamicSub[value]]);
            });

            return retVal;
        }

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

    </script>

@endsection