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
    <style>
        .form-control[readonly] {
            background: #efefef;
        }
        .form-control[readonly]:focus {
            background: #efefef;
        }
    </style>
    <div class="main-content">
        <div class="page-content" id="search-div">
            <div class="row pt-2">
                <div class="col-sm-12 full-width">
                    <select class="custom-select d-inline-block" style="padding: 4px;max-width: 100px;" @change="changeShip" v-model="shipId">
                        @foreach($shipList as $ship)
                            <option value="{{ $ship['IMO_No'] }}"
                                    {{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}
                            </option>
                        @endforeach
                    </select>
                    <select class="text-center" style="width: 60px;" name="voy_list" @change="onChangeVoy" v-model="activeVoy">
                        <template v-for="voyItem in voy_list">
                            <option :value="voyItem.Voy_No">@{{ voyItem.Voy_No }}</option>
                        </template>
                    </select>
                    <strong style="font-size: 10px; padding: 6px 0 0 16px;">
                        <span class="font-bold">动态记录</span>
                    </strong>
                    <div class="btn-group f-right">
                        <a class="btn btn-primary btn-sm search-btn" role="button" data-toggle="modal" @click="addItem"><i class="icon-plus"></i>添加</a>
                    </div>
                </div>
            </div>

            <!-- Main Contents Begin -->
            <div class="row col-lg-12" style="margin-top: 4px; width: 100%;">
                <div class="head-fix-div" style="padding-bottom: 12px;">
                    <input type="hidden" name="_CP_ID" v-model="activeVoy">
                    <table class="table-bordered dynamic-table table-striped">
                        <thead>
                        <tr>
                            <th class="text-center font-style-italic" style="width: 40px; height: 25px;">VOY</th>
                            <th class="text-center font-style-italic">DATE</th>
                            <th class="text-center font-style-italic">LT</th>
                            <th class="text-center font-style-italic" style="width: 150px;">STATUS</th>
                            <th class="text-center font-style-italic" style="width: 160px;">POSITION</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="prev-voy">
                            <td class="text-center">@{{ prevData['CP_ID'] }}</td>
                            <td class="text-center">@{{ prevData['Voy_Date'] }}</td>
                            <td class="text-center">@{{ prevData['GMT'] }}</td>
                            <td style="padding-left: 8px!important;">@{{ prevData['Voy_Status'] }}</td>
                            <td style="padding-left: 4px!important">@{{ prevData['Ship_Position'] }}</td>
                        </tr>
                        <template v-for="(currentItem, index) in currentData">
                            <tr class="dynamic-item">
                                <td class="text-center voy-no" style="background:linear-gradient(#fff, #d9f8fb)!important;" @click="addItem($event, currentItem.id)">@{{ activeVoy }}</td>
                                <td class="text-center date-width">@{{ currentItem.Voy_Date }}</td>
                                <td class="time-width text-center">@{{ currentItem.GMT }}</td>
                                <td> @{{ getVoyStatusLabel(currentItem.Voy_Status) }}</td>
                                <td class="position-width"><input type="text" maxlength="25" class="form-control" name="Ship_Position[]" v-model="currentItem.Ship_Position" autocomplete="off"></td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Main Contents End -->

            <!-- Register Modal Show -->
            <div id="modal-wizard" class="modal modal-draggable" aria-hidden="true">
                <div class="dynamic-modal-dialog">
                    <div class="dynamic-modal-content" style="border: 0;width:100%!important;">
                        <div class="dynamic-modal-header" data-target="#modal-step-contents">
                            <div class="table-header">
                                <button type="button"  style="margin-top: 8px; margin-right: 12px;" class="close" @click="closeModal" aria-hidden="true">
                                    <span class="white">&times;</span>
                                </button>
                                <h4 style="padding-top:10px;">动态记录 (VOY @{{ activeVoy }})</h4>
                            </div>
                        </div>
                        <div id="modal-body-content" class="modal-body step-content">
                            <div class="row">
                                <form action="{{ route('voy.update') }}" method="post" id="dynamic-form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="shipId" value="{{ $shipId }}">
                                    <input type="hidden" name="id" v-model="currentItem.id">
                                    <input type="hidden" name="CP_ID" v-model="activeVoy">
                                    <table class="register-voy">
                                        <tbody>
                                        <tr>
                                            <td class="text-left">DATE</td>
                                            <td colspan="3">
                                                <input type="text" class="date-picker form-control text-center" name="Voy_Date" v-model="currentItem.Voy_Date" @click="dateModify($event)" data-date-format="yyyy-mm-dd" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">TIME(LT)<span class="text-danger">*</span></td>
                                            <td class="time-width">
                                                <input type="text" class="form-control text-center hour-input" name="Voy_Hour" v-model="currentItem.Voy_Hour" @blur="limitHour($event)" @keyup="limitHour($event)" @change="changeVal" required>
                                            </td>
                                            <td class="time-width">
                                                <input type="text" class="form-control text-center minute-input" name="Voy_Minute" v-model="currentItem.Voy_Minute" @blur="limitMinute($event)" @keyup="limitMinute($event)" @change="changeVal" required>
                                            </td>
                                            <td class="time-width">(hh:mm)</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">GMT<span class="text-danger">*</span></td>
                                            <td class="time-width">
                                                <input type="text" class="form-control text-center gmt-input" name="GMT" v-model="currentItem.GMT" @blur="limitGMT($event)" @keyup="limitGMT($event)" @change="changeVal" required>
                                            </td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">STATUS<span class="text-danger">*</span></td>
                                            <td colspan="3">
                                                <select type="text" class="form-control" name="Voy_Status" v-model="currentItem.Voy_Status" @change="onChangeStatus($event)" required>
                                                    <option v-for="(item, index) in currentItem.dynamicStatus" v-bind:value="index">@{{ item[0] }}</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-style-normal text-left">种类</td>
                                            <td colspan="3">
                                                <select type="text" class="form-control" name="Voy_Type" v-model="currentItem.Voy_Type" @change="changeVal" required>
                                                    <option v-for="(item, index) in currentItem.dynamicSub" v-bind:value="item[0]">@{{ item[1] }}</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">POSITION</td>
                                            <td colspan="3">
                                                <input type="text" maxlength="25" class="form-control" name="Ship_Position" v-model="currentItem.Ship_Position" autocomplete="off" @change="changeVal" :required="validateItem.position">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="text-left">DTG</td>
                                            <td colspan="2">
                                                <input type="text" max="100000" class="form-control"  :readonly="currentItem.Voy_Status != DYNAMIC_DEPARTURE"  name="Sail_Distance" v-model="currentItem.Sail_Distance" @change="changeVal" :required="validateItem.distance">
                                            </td>
                                            <td>N.Mile</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">SPEED</td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" name="Speed" v-model="currentItem.Speed" @change="changeVal">
                                            </td>
                                            <td>Kn</td>
                                        </tr>

                                        <tr>
                                            <td class="text-left">RPM</td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" name="RPM" v-model="currentItem.RPM" @change="changeVal">
                                            </td>
                                            <td>rpm</td>
                                        </tr>

                                        <tr>
                                            <td class="text-left">CGO QTY(MT)</td>
                                            <td colspan="3">
                                                <input type="text" class="form-control font-weight-bold" :style="currentItem.Voy_Status == '13' ? 'color: red!important' : ''" name="Cargo_Qtty" v-model="currentItem.Cargo_Qtty" @change="changeVal" :required="validateItem.cargo">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="text-left">ROB(FO)</td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" style="padding: 0!important" :style="currentItem.Voy_Status == '13' ? 'color: red!important' : ''" name="ROB_FO" v-model="currentItem.ROB_FO" @change="changeVal" :required="validateItem.rob_fo">
                                            </td>
                                            <td>MT</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">ROB(DO)</td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" style="padding: 0!important" :style="currentItem.Voy_Status == '13' ? 'color: red!important' : ''" name="ROB_DO" v-model="currentItem.ROB_DO" @change="changeVal" :required="validateItem.rob_do">
                                            </td>
                                            <td>MT</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">BUNKERING(FO)</td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" name="BUNK_FO"  style="color: blue!important; padding: 0!important;" v-model="currentItem.BUNK_FO" @change="changeVal">
                                            </td>
                                            <td>MT</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">BUNKERING(DO)</td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" name="BUNK_DO"  style="color: blue!important; padding: 0!important;" v-model="currentItem.BUNK_DO" @change="changeVal">
                                            </td>
                                            <td>MT</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">REMARK</td>
                                            <td class="position-width" colspan="3">
                                                <textarea class="form-control" name="Remark" rows="2" style="resize: none" maxlength="50" autocomplete="off" v-model="currentItem.Remark" @change="changeVal">></textarea>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="btn-group f-right mt-20 d-flex">
                                        <button type="button" class="btn btn-success small-btn ml-0" @click="submitForm">
                                            <i class="icon-save"></i>保存
                                        </button>
                                        <button type="submit" class="d-none submit-btn"></button>
                                        <a class="btn btn-danger small-btn close-modal" @click="deleteItem($event, currentItem.id)"><i class="icon-remove"></i>删除</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ cAsset('assets/js/bignumber.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>
    <script src="{{ cAsset('assets/js/sprintf.min.js') }}"></script>
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
        var shipId = '{!! $shipId !!}';
        var voyId = '{!! $voyId !!}';
        var DYNAMIC_SUB_SALING = '{!! DYNAMIC_SUB_SALING !!}';
        var DYNAMIC_SUB_LOADING = '{!! DYNAMIC_SUB_LOADING !!}';
        var DYNAMIC_SUB_DISCH = '{!! DYNAMIC_SUB_DISCH !!}';
        var DYNAMIC_SUB_WAITING = '{!! DYNAMIC_SUB_WAITING !!}';
        var DYNAMIC_SUB_WEATHER = '{!! DYNAMIC_SUB_WEATHER !!}';
        var DYNAMIC_SUB_REPAIR = '{!! DYNAMIC_SUB_REPAIR !!}';
        var DYNAMIC_SUB_SUPPLY = '{!! DYNAMIC_SUB_SUPPLY !!}';
        var DYNAMIC_SUB_ELSE = '{!! DYNAMIC_SUB_ELSE !!}';

        var DYNAMIC_DEPARTURE = '{!! DYNAMIC_DEPARTURE !!}';
        var DYNAMIC_SAILING = '{!! DYNAMIC_SAILING !!}';
        var DYNAMIC_CMPLT_DISCH = '{!! DYNAMIC_CMPLT_DISCH !!}';
        var DYNAMIC_CMPLT_LOADING = '{!! DYNAMIC_CMPLT_LOADING !!}';
        var DYNAMIC_VOYAGE = '{!! DYNAMIC_VOYAGE !!}';

        const DAY_UNIT = 1000 * 3600;
        var isChangeStatus = false;
        var searchObjTmp = new Array();
        var submitted = false;
        var tmp;

        $("form").submit(function() {
            submitted = true;
        });

        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.';

            if (isChangeStatus) {
                (e || window.event).returnValue = confirmationMessage;
            }

            return confirmationMessage;
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
                    total_count:            0,

                    empty:                  true,

                    currentItem: {
                        dynamicStatus: DynamicStatus,
                        dynamicSub: [],
                    },
                    validateItem: {
                        distance: false,
                        cargo: false,
                        position: false,
                        rob_fo: false,
                        rob_do: false,
                    }
                },
                init: function() {
                    this.changeShip();
                },
                methods: {
                    changeShip: function(evt) {
                        location.href = '/voy/register?shipId=' + $(evt.target).val();
                    },
                    getShipName: function(shipName, EnName) {
                        return shipName == '' ? EnName : shipName;
                    },
                    getVoyList: function(shipId) {
                        $.ajax({
                            url: BASE_URL + 'ajax/business/voy/list',
                            type: 'post',
                            data: {
                                shipId: shipId,
                            },
                            success: function(result) {
                                searchObj.voy_list = [];
                                searchObj.voy_list = Object.assign([], [], result['cp_list']);
                            }
                        });
                    },
                    number_format: function(value, decimal = 1) {
                        return __parseFloat(value) == 0 ? '-' : number_format(value, decimal);
                    },
                    dangerClass: function(value) {
                        return isNaN(value) || value < 0 ? 'text-danger' : '';
                    },
                    onChangeVoy(evt) {
                        this.setPortName();
                        this.getData();
                    },
                    getData: function() {
                        $.ajax({
                            url: BASE_URL + 'ajax/business/dynamic/list',
                            type: 'post',
                            data: {
                                shipId: searchObj.shipId,
                                voyId: searchObj.activeVoy
                            },
                            success: function(result) {
                                let data = result;
                                searchObj.currentData = [];
                                searchObj.prevData = [];
                                if(data['prevData'] != undefined && data['prevData'] != null) {
                                    searchObj.prevData = Object.assign([], [], data['prevData']);
                                    searchObj.prevData['Voy_Type'] = DynamicSub[searchObj.prevData['Voy_Type']];
                                    searchObj.prevData['Voy_Status'] = DynamicStatus[searchObj.prevData['Voy_Status']][0];
                                    if(searchObj.prevData['Voy_Hour'] < 10)
                                        searchObj.prevData['Voy_Hour'] = "0" + searchObj.prevData['Voy_Hour'];

                                    if(searchObj.prevData['Voy_Minute'] < 10)
                                        searchObj.prevData['Voy_Minute'] = "0" + searchObj.prevData['Voy_Minute'];

                                    searchObj.prevData['Cargo_Qtty'] = __parseFloat(searchObj.prevData['Cargo_Qtty']).toFixed(0);
                                }

                                if(data['currentData'] != undefined && data['currentData'] != null && data['currentData'].length > 0) {
                                    searchObj.currentData = Object.assign([], [], data['currentData']);
                                    searchObj.sail_term['min_date']= searchObj.currentData[0]['Voy_Date'];
                                    let tmpData = searchObj.currentData;
                                    searchObj.sail_term['max_date'] = tmpData[tmpData.length - 1]['Voy_Date'];


                                    searchObj.rob_fo = 0;
                                    searchObj.rob_do = 0;
                                    searchObj.bunker_fo = 0;
                                    searchObj.bunker_do = 0;
                                    searchObj.used_fo = 0;
                                    searchObj.used_fo = 0;
                                    searchObj.save_fo = 0;
                                    searchObj.save_do = 0;
                                    searchObj.total_distance = 0;
                                    searchObj.average_speed = 0;

                                    var start_date = searchObj.prevData['Voy_Date'] + ' ' + searchObj.prevData['Voy_Hour'] + ':' + searchObj.prevData['Voy_Minute'] + ':00';
                                    var start_gmt = searchObj.prevData['GMT'];
                                    searchObj.currentData.forEach(function(value, key) {
                                        searchObj.currentData[key]['dynamicSub'] = getSubList(value['Voy_Status']);
                                        searchObj.currentData[key]['Voy_Status_Name'] = DynamicStatus[value['Voy_Status']][0];
                                        searchObj.currentData[key]['Voy_Type_Name'] = DynamicSub[value['Voy_Type']];
                                    });

                                }
                            }
                        })
                    },
                    setTotalDefault: function() {
                        this.sail_time = 0;
                        this.total_distance = 0;
                        this.total_sail_time = 0;
                        this.total_loading_time = 0;
                        this.economic_rate = 0;
                        this.average_speed = 0;

                        this.rob_fo = 0;
                        this.rob_do = 0;
                        this.bunker_fo = 0;
                        this.bunker_do = 0;

                        this.used_fo = 0;
                        this.used_do = 0;
                        this.save_fo = 0;
                        this.save_do = 0;
                        this.total_count = 0;
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
                    addItem(e, id = 0) {
                        this.currentItem.id = id;
                        if(id == 0) {
                            this.currentItem.Voy_Date = this.getToday('-');
                            this.currentItem.Voy_Hour = '';
                            this.currentItem.Voy_Minute = '';
                            this.currentItem.GMT = '';
                            this.currentItem.Voy_Status = '';
                            this.currentItem.Voy_Type = '';
                            this.currentItem.Ship_Position = '';
                            this.currentItem.Sail_Distance = '';
                            this.currentItem.Speed = '';
                            this.currentItem.RPM = '';
                            this.currentItem.Cargo_Qtty = '';
                            this.currentItem.ROB_FO = '';
                            this.currentItem.ROB_DO = '';
                            this.currentItem.BUNK_FO = '';
                            this.currentItem.BUNK_DO = '';
                            this.currentItem.Remark = '';

                            this.$forceUpdate();
                            $('#modal-wizard').modal('show');
                        } else {
                            $.ajax({
                                url: BASE_URL + 'ajax/voy/detail',
                                type: 'post',
                                data: {
                                    id: id,
                                },
                                success: function(data) {
                                    let result = data;
                                    if(result != false) {
                                        searchObj.currentItem.Voy_Date = result.Voy_Date;
                                        searchObj.currentItem.Voy_Hour = sprintf('%02d', __parseFloat(result.Voy_Hour));
                                        searchObj.currentItem.Voy_Minute = sprintf('%02d', __parseFloat(result.Voy_Minute));
                                        searchObj.currentItem.GMT = __parseFloat(result.GMT);
                                        searchObj.currentItem.Voy_Status = __parseFloat(result.Voy_Status);
                                        searchObj.currentItem.dynamicSub = getSubList(result.Voy_Status);
                                        searchObj.currentItem.Voy_Type = __parseFloat(result.Voy_Type);
                                        searchObj.currentItem.Ship_Position = result.Ship_Position;
                                        searchObj.currentItem.Sail_Distance = __parseStr(result.Sail_Distance);
                                        searchObj.currentItem.Speed = __parseStr(result.Speed);
                                        searchObj.currentItem.RPM = __parseStr(result.RPM);
                                        searchObj.currentItem.Cargo_Qtty = result.Cargo_Qtty;
                                        searchObj.currentItem.ROB_FO = __parseStr(result.ROB_FO);
                                        searchObj.currentItem.ROB_DO = __parseStr(result.ROB_DO);
                                        searchObj.currentItem.BUNK_FO = __parseStr(result.BUNK_FO);
                                        searchObj.currentItem.BUNK_DO = __parseStr(result.BUNK_DO);
                                        searchObj.currentItem.Remark = result.Remark;
                                    }
                                    searchObj.$forceUpdate();
                                    $('#modal-wizard').modal('show');
                                }
                            });
                        }
                    },
                    dateModify(e, index) {
                        $(e.target).on("change", function() {
                            searchObj.currentItem['Voy_Date'] = $(this).val();
                            isChangeStatus = true;
                        });
                    },
                    changeVal: function() {
                        isChangeStatus = true;
                        this.validateForm();
                    },
                    onChangeStatus: function(e, index) {
                        isChangeStatus = true;
                        let voyStatus = $(e.target).val();

                        searchObj.currentItem['dynamicSub'] = getSubList(voyStatus);
                        searchObj.currentItem['Voy_Type'] = getSubList(voyStatus)[0][0];

                        this.validateForm();
                        
                    },
                    submitForm: function() {
                        isChangeStatus = false;
                        $('.submit-btn').click();
                    },
                    validateForm() {
                        let CargoQty = this.currentItem.Cargo_Qtty;
                        let voyStatus = this.currentItem.Voy_Status;

                        if(voyStatus == DYNAMIC_DEPARTURE) {
                            this.validateItem.distance = true;
                        } else if(voyStatus == DYNAMIC_CMPLT_LOADING) {
                            this.validateItem.cargo = true;
                        } else if(voyStatus == DYNAMIC_CMPLT_DISCH) {
                            this.validateItem.cargo = true;
                            if(CargoQty == 0) {
                                this.validateItem.rob_fo = true;
                                this.validateItem.rob_do = true;
                            }
                        } else if(voyStatus == DYNAMIC_VOYAGE) {
                            this.validateItem.position = true;
                            this.validateItem.cargo = true;
                            this.validateItem.rob_fo = true;
                            this.validateItem.rob_do = true;
                        } else {
                            this.validateItem.distance = false;
				            this.validateItem.position = false;
                            this.validateItem.cargo = false;
                            this.validateItem.rob_fo = false;
                            this.validateItem.rob_do = false;
                        }

                        this.$forceUpdate();
                    },
                    getToday: function(symbol) {
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = yyyy + symbol + mm + symbol + dd;

                        return today;
                    },
                    // addRow: function(index) {
                    //     let length = this.currentData.length;
                    //     if(length != 0 && length - 1 != index)
                    //         return;

                    //     this.setDefaultData();
                    // },
                    addRow: function() {
                        // let length = this.currentData.length;
                        // if(length != 0 && length - 1 != index)
                        //     return;

                        this.setDefaultData();
                    },
                    setDefaultData() {
                        let length = searchObj.currentData.length;
                        searchObj.currentData.push([]);
                        if(length > 1) {
                            let tmp = {
                                Voy_Status: DYNAMIC_SAILING,
                                dynamicSub: getSubList(DYNAMIC_SAILING),
                                Voy_Type: DYNAMIC_SUB_SALING,
                                Voy_Hour: "08",
                                Voy_Minute: "00",
                                Voy_Date: searchObj.currentData[length - 1]['Voy_Date'],
                                GMT: searchObj.currentData[length - 1]['GMT']
                            }
                            searchObj.currentData[length] = tmp;
                        } else {
                            let tmp1 = {
                                Voy_Status: DYNAMIC_SAILING,
                                dynamicSub: getSubList(DYNAMIC_SAILING),
                                Voy_Type: DYNAMIC_SUB_SALING,
                                Voy_Hour: "08",
                                Voy_Minute: "00",
                                Voy_Date: this.getToday('-'),
                                GMT: 8
                            }

                            searchObj.currentData[length] = tmp1;
                            searchObjTmp = JSON.parse(JSON.stringify(searchObj.currentData));
                        }

                        // searchObj.$forceUpdate();
                    },
                    limitHour: function(e) {
                        let val = parseInt(e.target.value);
                        if(val > 25)
                            this.currentItem['Voy_Hour'] = 23;
                        else if(val <= 0)
                            this.currentItem['Voy_Hour'] = 0;
                        else if(val < 10 && val > 0)
                            this.currentItem['Voy_Hour'] = sprintf('%02d', val);
                        else
                            this.currentItem['Voy_Hour'] = val;
                    },
                    limitMinute: function(e) {
                        let val = parseInt(e.target.value);
						console.log(val);
                        if(val > 60)
                            this.currentItem['Voy_Minute'] = 59;
                        else if(val <= 0)
                            this.currentItem['Voy_Minute'] = 0;
                        else if(val < 10 && val > 0)
                            this.currentItem['Voy_Minute'] = sprintf('%02d', val);
                        else
                            this.currentItem['Voy_Minute'] = val;
                    },
                    limitGMT: function(e) {
                        let val = parseInt(e.target.value);
                        if(val > 24)
                            this.currentItem['GMT'] = 24;
                        if(val <= 0)
                            this.currentItem['GMT'] = 0;
                    },
                    getVoyStatusLabel: function(index) {
                        return DynamicStatus[index][0];
                    },
                    closeModal: function() {
                        if(isChangeStatus) {
                            var confirmationMessage = 'It looks like you have been editing something. '
                                + 'If you leave before saving, your changes will be lost.';
                            bootbox.confirm(confirmationMessage, function (result) {
                                if(result) {
                                    isChangeStatus = false;
                                    $("#modal-wizard").modal('hide');
                                }
                            });
                        } else {
                            isChangeStatus = false;
                            $('#modal-wizard').modal('hide');
                        }
                    },
                    deleteItem: function(e, id) {
                        __alertAudio();

                        bootbox.confirm("Are you sure you want to delete?", function (result) {
                            if (result) {
                                if (id > 0) {
                                    $.ajax({
                                        url: BASE_URL + 'ajax/business/dynrecord/delete',
                                        type: 'post',
                                        data: {
                                            id: id,
                                        },
                                        success: function (data, status, xhr) {
                                            searchObj.getData();
                                            isChangeStatus = false;
                                            $('#modal-wizard').modal('hide');
                                        }
                                    });
                                } else {
                                    isChangeStatus = false;
                                    $('#modal-wizard').modal('hide');
                                }
                            } else {
                                isChangeStatus = false;
                                $('#modal-wizard').modal('hide');
                            }
                        });
                    }
                },
                computed: {
                    deleteClass: function() {
                        let length = this.currentData.length;
                        let _this = this;
                        this.currentData.map(function(data) {
                            if(data.id != undefined)
                                _this.empty = false;
                        });

                        return _this.empty && length == 1 ? 'd-none' : '';
                    }
                },
                updated() {
                    $('.date-picker').datepicker({
                        autoclose: true,
                    }).next().on(ace.click_event, function () {
                        $(this).prev().focus();
                    });

                    $('.hour-input').on('blur keyup', function() {
                        let val = $(this).val();
                        if(val > 25)
                            $(this).val(23);
                        if(val < 0)
                            $(this).val(0);
                    });

                    $('.minute-input').on('blur keyup', function() {
                        let val = $(this).val();
                        if(val > 60)
                            $(this).val(59);
                        if(val < 0)
                            $(this).val(0);
                    });

                    $('.gmt-input').on('blur keyup', function() {
                        let val = $(this).val();
                        if(val > 24)
                            $(this).val(24);
                        if(val < 0)
                            $(this).val(0);
                    });

                    offAutoCmplt();
                }
            });


            if(voyId != '')
                searchObj.activeVoy = voyId;

            searchObj.shipId = shipId;

            getInitInfo();
        }

        function getInitInfo() {
            $.ajax({
                url: BASE_URL + 'ajax/business/voy/list',
                type: 'post',
                data: {
                    shipId: shipId,
                },
                success: function(result) {
                    searchObj.voy_list = [];
                    searchObj.voy_list = Object.assign([], [], result['cp_list']);
                    if(searchObj.voy_list.length > 0) {
                        searchObj.activeVoy = voyId != '' ? voyId : searchObj.voy_list[0]['Voy_No'];
                    }

                    searchObj.setPortName();
                    searchObj.getData();
                }
            });
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

        $('body').on('keydown', 'input, select', function(e) {
            if (e.key === "Enter") {
                var self = $(this), form, focusable, next;
                form = $('#dynamic-form');

                focusable = form.find('input,a,select,textarea').filter(':visible');
                next = focusable.eq(focusable.index(this)+1);
                if (next.length) {
                    next.focus();
                }
                return false;
            }
        });
    </script>

@endsection