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
        <div class="page-header">
            <div class="col-md-3">
                <h4>
                    <b>航次结算</b>
                </h4>
            </div>
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-md-12 align-bottom" style="width: 88%;" v-cloak>
                    <div class="col-md-5">
                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                        <select class="custom-select d-inline-block" style="padding: 4px;max-width: 100px;" id="ship_list">
                            @foreach($shipList as $ship)
                                <option value="{{ $ship['IMO_No'] }}"
                                        {{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}
                                </option>
                            @endforeach
                        </select>
                        <label class="font-bold">航次:</label>
                        <select class="text-center" style="width: 60px;" id="voy_list">
                            @foreach($cpList as $key => $item)
                                <option value="{{ $item->Voy_No }}" {{ $item->Voy_No == $voyId ? 'selected' : '' }}>{{ $item->Voy_No }}</option>
                            @endforeach
                        </select>
                        <a class="btn btn-sm btn-danger refresh-btn-over" type="button" onclick="clearData()" style="width: 80px;height: 26px!important;margin-bottom: 1px;padding: 5px!important;">
                            <img src="{{ cAsset('assets/images/refresh.png') }}" class="report-label-img">初始化
                        </a>
                    </div>
                    <div class="col-md-7">
                        <div class="btn-group f-right">
                            <a class="btn btn-sm btn-purple" onclick="openNewPage('soa')"><i class="icon-asterisk"></i> SOA</a>
                            <a class="btn btn-sm btn-dynamic" onclick="openNewPage('dynamic')"><i class="icon-bar-chart"></i> 船舶动态</a>
                            <button class="btn btn-report-search btn-sm search-btn d-none" click="doSearch()"><i class="icon-search"></i>搜索</button>
                            <button class="btn btn-success btn-sm save-btn" onclick="submitForm()"><i class="icon-save"></i> {{ trans('common.label.save') }}</button>
                            <button class="btn btn-warning btn-sm save-btn" onclick="fnExcelRecord()"><i class="icon-table"></i> {{ trans('common.label.excel') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Contents Begin -->
            <div class="row" id="settle-info-div" style="margin-top: 4px;" v-cloak>
                <div class="col-md-12">
                <form action="saveVoySettle" method="post" id="voy-settle-form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="shipId" value="{{ $shipId }}">
                    <input type="hidden" name="voyId" v-model="voyId">

                    <table class="table-bordered dynamic-table not-striped" id="table-settlement" style="width: 76%!important; margin: 0 auto; background: #f2f2f2;">
                        <thead>
                            <tr class="sub-head-tr">
                                <td class="text-center" colspan="9">
                                    <strong class="" style="font-size: 16px; padding-top: 6px;">
                                        <span id="search_info">{{ $shipName }}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="font-bold">航次结算表</span>
                                    </strong>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="gray-tr">
                                <td class="no-border-td" colspan="9">&nbsp;</td>
                            </tr>
                            <!-- Main Dynami Info Begin -->
                            <tr class="gray-tr">
                                <td class="no-border-td text-left first-td" style="width: 11%;">航次期间(起)</td>
                                <td class="text-center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                    <label class="date-label">
                                        <input class="form-control text-center date-picker" name="load_date" v-model="mainInfo.start_date" @click="dateModify($event, '', 'main', 'start')">
                                    </label>
                                    <label class="time-width hour-label">
                                        <input class="form-control text-center hour-input" name="load_hour" v-model="mainInfo.start_hour" onchange="dateChange()">
                                    </label>
                                    <label class="time-width minute-label">
                                        <input class="form-control text-center minute-input" name="load_minute" v-model="mainInfo.start_minute" onchange="dateChange()">
                                    </label>
                                    </div>
                                    <input type="hidden" name="main_id" v-model="mainInfo.id">
                                </td>

                                <td class="text-center" style="width: 100px;">(至)</td>
                                <td class="text-center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <label class="date-label">
                                            <input class="form-control text-center date-picker" name="dis_date" v-model="mainInfo.end_date" @click="dateModify($event, '', 'main', 'end')">
                                        </label>
                                        <label class="time-width hour-label">
                                            <input class="form-control text-center hour-input" name="dis_hour" v-model="mainInfo.end_hour" onchange="dateChange()">
                                        </label>
                                        <label class="time-width minute-label">
                                            <input class="form-control text-center minute-input" name="dis_minute" v-model="mainInfo.end_minute" onchange="dateChange()">
                                        </label>
                                    </div>
                                </td>
                                <td class="text-left no-border-td first-td" style="width: 100px;">航次用时</td>
                                <td class="text-center" style="width: 100px;">
                                    <input v-model="mainInfo.total_sail_time" class="form-control text-center" name="total_sail_time" readonly>
                                </td>
                                <td class="no-border"></td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="no-border-td text-left first-td">货名</td>
                                <td class="text-center" colspan="2">
                                    <input class="form-control" v-model="mainInfo.cargo_name" class="form-control" name="cargo_name" @change="inputChange">
                                </td>
                                <td class="text-center">
                                    <input v-model="mainInfo.voy_type" class="form-control text-center" name="voy_type" readonly>
                                </td>
                                <td class="text-left" style="padding-left: 8px!important; width: 120px;">货量（租期）</td>
                                <td class="text-center" style="width: 120px;">
                                    <my-currency-input name="cgo_qty" class="form-control text-center" v-model="mainInfo.cgo_qty" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="text-left no-border-td first-td">航行天数</td>
                                <td class="text-center">
                                    <my-currency-input name="sail_time" class="form-control text-center" v-model="mainInfo.sail_time" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="no-border"></td>
                            </tr>

                            <tr class="gray-tr">
                                <td class="no-border-td text-left first-td">运费(租金)</td>
                                <td class="text-center">
                                    <my-currency-input name="freight_price" class="form-control" v-model="mainInfo.freight_price" v-bind:prefix="'$'" v-bind:fixednumber="2" :readonly="true"></my-currency-input>
                                </td>
                                <td class="text-left" style="padding-left: 8px!important; width: 140px;">运费率(日租金)</td>
                                <td class="text-center">
                                    <my-currency-input name="freight" class="form-control text-center" v-model="mainInfo.freight" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="text-left" style="padding-left: 8px!important;">里程(NM)</td>
                                <td class="text-center">
                                    <my-currency-input name="total_distance" class="form-control text-center" v-model="mainInfo.total_distance" v-bind:prefix="''" v-bind:fixednumber="0"></my-currency-input>
                                </td>
                                <td class="text-left no-border-td first-td">装卸天数</td>
                                <td class="text-center">
                                    <my-currency-input name="load_time" class="form-control text-center" v-model="mainInfo.load_time" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="no-border"></td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="no-border-td text-left first-td">装港</td>
                                <td class="text-center" colspan="3"><input class="form-control" v-model="mainInfo.lport" name="lport"></td>
                                <td class="text-left" style="padding-left: 8px!important;">平均速度</td>
                                <td class="text-center">
                                    <my-currency-input name="avg_speed" class="form-control text-center" v-model="mainInfo.avg_speed" v-bind:prefix="''" v-bind:fixednumber="1"></my-currency-input>
                                </td>
                                <td class="text-left no-border-td first-td">其他天数</td>
                                <td class="text-center">
                                    <my-currency-input name="else_time" class="form-control text-center" v-model="mainInfo.else_time" v-bind:prefix="''" v-bind:fixednumber="2" :readonly="true"></my-currency-input>
                                </td>
                                <td class="no-border"></td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="no-border-td text-left first-td">卸港</td>
                                <td class="text-center" colspan="3"><input class="form-control" v-model="mainInfo.dport" name="dport" @change="inputChange"></td>
                                <td class="text-left" style="padding-left: 8px!important;">佣金(%)</td>
                                <td class="text-center">
                                    <my-currency-input name="com_fee" class="form-control text-center" v-model="mainInfo.com_fee" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="no-border"></td>
                                <td class="no-border"></td>
                                <td class="no-border"></td>
                            </tr>
                            <!-- Main Dynami Info End -->
                            
                            <!-- Else Dynami Info Begin -->
                            <tr class="gray-tr">
                                <td class="no-border-td" colspan="9">&nbsp;</td>
                            </tr>

                            <tr class="sub-head-tr">
                                <td class="center" style="background: #d9f8fb!important;"></td>
                                <td class="center" style="background: #d9f8fb!important;">港口名称</td>
                                <td class="center" colspan="2" style="background: #d9f8fb!important;">抵港时间</td>
                                <td class="center" colspan="2" style="background: #d9f8fb!important;">离港时间</td>
                                <td class="center" style="background: #d9f8fb!important;">重油(MT)</td>
                                <td class="center" style="background: #d9f8fb!important;">轻油(MT)</td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="text-left first-td">起始港</td>
                                <td class="center">
                                    <input class="form-control" v-model="elseInfo.position" name="origin_position" @change="inputChange">
                                    <input type="hidden" v-model="elseInfo.id" name="origin_id">
                                </td>
                                <td class="center" colspan="2"></td>
                                <td class="center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <label class="date-label">
                                            <input class="form-control date-picker text-center" v-model="elseInfo.date" name="origin_date" @click="dateModify($event, '', 'origin', '')">
                                        </label>
                                        <label class="time-width hour-label">
                                            <input class="form-control hour-input" v-model="elseInfo.hour" name="origin_hour" @change="inputChange">
                                        </label>
                                        <label class="time-width minute-label">
                                            <input class="form-control minute-input" v-model="elseInfo.minute" name="origin_minute" @change="inputChange">
                                        </label>
                                    </div>
                                    
                                </td>
                                <td class="center">
                                    <my-currency-input name="origin_fo" v-model="elseInfo.rob_fo" class="form-control text-center" :style="debitClass(elseInfo.rob_fo)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center">
                                    <my-currency-input name="origin_do" v-model="elseInfo.rob_do" class="form-control text-center" :style="debitClass(elseInfo.rob_do)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                            </tr>
                            <tr class="gray-tr" v-for="(item, index) in elseInfo.load">
                                <td class="text-left first-td text-warning">装货港<img :src="index == 0 ? '/assets/images/add.png' : '/assets/images/minus.png'" @click="addRow('load', index, item.id)" class="add-img" width="16" height="16"></td>
                                <td class="center">
                                    <input class="form-control" name="load_position[]" v-model="item.position">
                                    <input type="hidden" v-model="item.id" name="load_id[]">
                                </td>
                                <td class="center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <label class="date-label">
                                            <input class="form-control date-picker text-center" name="load_arrival_date[]" v-model="item.arrival_date" @click="dateModify($event, index, 'load', 'arrival')">
                                        </label>
                                        <label class="time-width hour-label">
                                            <input class="form-control hour-input" name="load_arrival_hour[]" v-model="item.arrival_hour" @change="inputChange">
                                        </label>
                                        <label class="time-width minute-label">
                                            <input class="form-control minute-input" name="load_arrival_minute[]" v-model="item.arrival_minute" @change="inputChange">
                                        </label>
                                    </div>
                                </td>
                                <td class="center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <label class="date-label">
                                            <input class="form-control date-picker text-center" name="load_depart_date[]" v-model="item.load_date" @click="dateModify($event, index, 'load', 'load')">
                                        </label>
                                        <label class="time-width hour-label">
                                            <input class="form-control hour-input" name="load_depart_hour[]" v-model="item.load_hour" @change="inputChange">
                                        </label>
                                        <label class="time-width minute-label">
                                            <input class="form-control minute-input" name="load_depart_minute[]" v-model="item.load_minute" @change="inputChange">
                                        </label>
                                    </div>
                                </td>
                                <td class="center">
                                    <my-currency-input name="load_fo[]" v-model="item.rob_fo" class="form-control text-center" :style="debitClass(item.rob_fo)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center">
                                    <my-currency-input name="load_do[]" v-model="item.rob_do" class="form-control text-center" :style="debitClass(item.rob_do)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                            </tr>

                            <tr class="gray-tr" v-for="(item, index) in elseInfo.discharge">
                                <td class="text-left first-td text-danger">卸货港<img :src="index == 0 ? '/assets/images/add.png' : '/assets/images/minus.png'" @click="addRow('disch', index, item.id)" class="add-img" width="16" height="16"></td>
                                <td class="center">
                                    <input class="form-control" name="dis_position[]" v-model="item.position">
                                    <input type="hidden" v-model="item.id" name="dis_id[]">
                                </td>
                                <td class="center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <label class="date-label">
                                            <input class="form-control date-picker text-center" name="dis_arrival_date[]" v-model="item.arrival_date" @click="dateModify($event, index, 'discharge', 'arrival')">
                                        </label>
                                        <label class="time-width hour-label">
                                            <input class="form-control hour-input" name="dis_arrival_hour[]" v-model="item.arrival_hour" @change="inputChange">
                                        </label>
                                        <label class="time-width minute-label">
                                            <input class="form-control minute-input" name="dis_arrival_minute[]" v-model="item.arrival_minute" @change="inputChange">
                                        </label>
                                    </div>
                                </td>
                                <td class="center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <label class="date-label">
                                            <input class="form-control date-picker text-center" name="dis_depart_date[]" v-model="item.load_date" @click="dateModify($event, index, 'discharge', 'load')">
                                        </label>
                                        <label class="time-width hour-label">
                                            <input class="form-control hour-input" name="dis_depart_hour[]" v-model="item.load_hour" @change="inputChange">
                                        </label>
                                        <label class="time-width minute-label">
                                            <input class="form-control minute-input" name="dis_depart_minute[]" v-model="item.load_minute" @change="inputChange">
                                        </label>
                                    </div>
                                </td>
                                <td class="center">
                                    <my-currency-input name="dis_fo[]" v-model="item.rob_fo" class="form-control text-center" :style="debitClass(item.rob_fo)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center">
                                    <my-currency-input name="dis_do[]" v-model="item.rob_do" class="form-control text-center" :style="debitClass(item.rob_do)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                            </tr>
                            <tr class="gray-tr" v-for="(item, index) in elseInfo.fuel">
                                <td class="text-left first-td">加油港<img :src="index == 0 ? '/assets/images/add.png' : '/assets/images/minus.png'" @click="addRow('fuel', index, item.id)" class="add-img" width="16" height="16"></td>
                                <td class="center">
                                    <input class="form-control" name="fuel_position[]" v-model="item.position">
                                    <input type="hidden" v-model="item.id" name="fuel_id[]">
                                </td>
                                <td class="center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <label class="date-label">
                                            <input class="form-control date-picker text-center" name="fuel_arrival_date[]" v-model="item.arrival_date" @click="dateModify($event, index, 'fuel', 'arrival')">
                                        </label>
                                        <label class="time-width hour-label">
                                            <input class="form-control hour-input" name="fuel_arrival_hour[]" v-model="item.arrival_hour" @change="inputChange">
                                        </label>
                                        <label class="time-width minute-label">
                                            <input class="form-control minute-input" name="fuel_arrival_minute[]" v-model="item.arrival_minute" @change="inputChange">
                                        </label>
                                    </div>
                                </td>
                                <td class="center" colspan="2">
                                    <div class="d-flex justify-content-center">
                                        <label class="date-label">
                                            <input class="form-control date-picker text-center" name="fuel_depart_date[]" v-model="item.load_date" @click="dateModify($event, index, 'fuel', 'load')">
                                        </label>
                                        <label class="time-width hour-label">
                                            <input class="form-control hour-input" name="fuel_depart_hour[]" v-model="item.load_hour" @change="inputChange">
                                        </label>
                                        <label class="time-width minute-label">
                                            <input class="form-control minute-input" name="fuel_depart_minute[]" v-model="item.load_minute" @change="inputChange">
                                        </label>
                                    </div>
                                </td>
                                <td class="center">
                                    <my-currency-input name="fuel_fo[]" v-model="item.rob_fo" class="form-control text-center" :style="debitClass(item.rob_fo, 1)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center">
                                    <my-currency-input name="fuel_do[]" v-model="item.rob_do" class="form-control text-center" :style="debitClass(item.rob_do, 1)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                            </tr>

                            <!-- Else Dynami Info Begin -->

                            <!-- Fuel Dynami Info Begin -->
                            <tr class="gray-tr">
                                <td class="no-border-td" colspan="8">&nbsp;</td>
                            </tr>
                            <tr class="sub-head-tr">
                                <td class="center" style="background: #d9f8fb!important;"></td>
                                <td class="center" style="background: #d9f8fb!important;">实际耗油(MT)</td>
                                <td class="center" style="background: #d9f8fb!important;">理论耗油(MT)</td>
                                <td class="center" style="background: #d9f8fb!important;">油价</td>
                                <td class="center" style="background: #d9f8fb!important;">总油量(MT)</td>
                                <td class="center" style="background: #d9f8fb!important;">总油价</td>
                                <td class="center" style="background: #d9f8fb!important;">总差量(MT)</td>
                                <td class="center" style="background: #d9f8fb!important;">总差价</td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="text-left dot first-td">重油-1</td>
                                <td class="center dot">
                                    <my-currency-input name="rob_fo_1"  v-model="fuelInfo.rob_fo_1" :style="debitClass(fuelInfo.rob_fo_1)" class="form-control text-right" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                    <input type="hidden" name="fuelCalcId" v-model="fuelInfo.id">
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="used_fo" readonly v-model="fuelInfo.used_fo" :style="debitClass(fuelInfo.used_fo)" class="form-control  text-right" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center dot">
                                    <my-currency-input name="rob_fo_price_1"  v-model="fuelInfo.rob_fo_price_1" :style="debitClass(fuelInfo.rob_fo_price_1)" class="form-control text-right" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="total_fo" readonly v-model="fuelInfo.total_fo" :style="debitClass(fuelInfo.total_fo)" class="form-control text-right" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="total_fo_price" readonly v-model="fuelInfo.total_fo_price" :style="debitClass(fuelInfo.total_fo_price)" class="form-control text-center" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="total_fo_diff" readonly v-model="fuelInfo.total_fo_diff" :style="debitClass(fuelInfo.total_fo_diff)" class="form-control text-center" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="total_fo_price_diff" readonly v-model="fuelInfo.total_fo_price_diff" :style="debitClass(fuelInfo.total_fo_price_diff)" class="form-control text-center" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="text-left no-top first-td">重油-2</td>
                                <td class="center no-top">
                                    <my-currency-input name="rob_fo_2" v-model="fuelInfo.rob_fo_2" class="form-control text-right" :style="debitClass(fuelInfo.rob_fo_2)" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center no-top">
                                    <my-currency-input name="rob_fo_price_2" v-model="fuelInfo.rob_fo_price_2" :style="debitClass(fuelInfo.rob_fo_price_2)" class="form-control text-right" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                            </tr>

                            <tr class="gray-tr">
                                <td class="text-left dot first-td">轻油-1</td>
                                <td class="center dot">
                                    <my-currency-input name="rob_do_1"  v-model="fuelInfo.rob_do_1" :style="debitClass(fuelInfo.rob_do_1)" class="form-control text-right" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="used_do" readonly v-model="fuelInfo.used_do" :style="debitClass(fuelInfo.used_do)" class="form-control text-right" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center dot">
                                    <my-currency-input name="rob_do_price_1"  v-model="fuelInfo.rob_do_price_1" :style="debitClass(fuelInfo.rob_do_price_1)" class="form-control text-right" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="total_do" readonly v-model="fuelInfo.total_do" :style="debitClass(fuelInfo.total_do)" class="form-control text-right" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="total_do_price" readonly v-model="fuelInfo.total_do_price" :style="debitClass(fuelInfo.total_do_price)" class="form-control text-center" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="total_do_diff" readonly v-model="fuelInfo.total_do_diff" :style="debitClass(fuelInfo.total_do_diff)" class="form-control text-center" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" rowspan="2">
                                    <my-currency-input name="total_do_price_diff" readonly v-model="fuelInfo.total_do_price_diff" :style="debitClass(fuelInfo.total_do_price_diff)" class="form-control text-center" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="text-left no-top first-td">轻油-2</td>
                                <td class="center no-top">
                                    <my-currency-input name="rob_do_2" v-model="fuelInfo.rob_do_2" :style="debitClass(fuelInfo.rob_do_2)" class="form-control text-right" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center no-top">
                                    <my-currency-input name="rob_do_price_2" v-model="fuelInfo.rob_do_price_2" :style="debitClass(fuelInfo.rob_do_price_2)" class="form-control text-right" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                            </tr>
                            <!-- Fuel Dynami Info End -->

                            <!-- Credit Dynami Info Begin -->
                            <tr class="sub-head-tr">
                                <td class="center" rowspan="6" style="background: #d9f8fb!important;">运<br>营<br><br>收<br>入</td>
                                <td class="center" colspan="5" style="background: #d9f8fb!important;">运费信息</td>
                                <td class="center" colspan="2" style="background: #d9f8fb!important;">收入状态</td>
                                <td class="no-border" style="background: transparent!important;"></td>
                            </tr>
                            <!--tr class="gray-tr">
                                <td class="center" colspan="3">运费(租金)</td>
                                <td class="center" colspan="4">
                                    <my-currency-input name="freight_price" v-model="creditInfo.rent_total" class="form-control text-center" v-bind:prefix="''" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" colspan="2">
                                    <input class="form-control" name="rent_status" v-model="creditInfo.rent_status">
                                </td>
                            </tr-->
                            <tr class="gray-tr" v-for="(item, index) in creditInfo.else">
                                <td class="center" colspan="2">
                                    <input name="credit_name[]" v-model="item.name" class="form-control text-center" :readonly="index < 1" @change="inputChange">
                                    <input type="hidden" name="credit_id[]" v-model="item.id">
                                </td>
                                <td class="center" colspan="3">
                                    <my-currency-input name="credit_amount[]" v-model="item.amount" :style="debitClass(item.amount)" class="form-control text-center" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" colspan="2">
                                    <input name="credit_remark[]" v-model="item.remark" class="form-control" @change="inputChange">
                                </td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="center total-td" colspan="2">收入总计</td>
                                <td class="center" colspan="3">@{{ number_format(creditInfo.total) == '' ? '' : '$' }} @{{ number_format(creditInfo.total) }}</td>
                                <td class="center" colspan="2"></td>
                            </tr>
                            <!-- Credit Dynami Info End -->

                            <!-- Debit Dynami Info Begin -->
                            <tr class="sub-head-tr">
                                <td class="center" rowspan="13" style="background: #d9f8fb!important;">运<br>营<br><br>支<br>出</td>
                                <td class="center" colspan="5" style="background: #d9f8fb!important;">支出信息</td>
                                <td class="center" colspan="2" style="background: #d9f8fb!important;">支出状态</td>
                            </tr>
                            <tr class="gray-tr" v-for="(item, index) in debitInfo.else">
                                <td class="center" colspan="2">
                                    <input class="form-control text-center" name="debit_name[]" v-model="item.name" :readonly="index < 4" @change="inputChange">
                                    <input type="hidden" name="debit_id[]" v-model="item.id">
                                </td>
                                <td class="center" colspan="3">
                                    <my-currency-input name="debit_amount[]" v-model="item.amount" :readonly="index == 0 || index == 3" :style="debitClass(item.amount)" class="form-control text-center" v-bind:prefix="'$'" v-bind:fixednumber="2"></my-currency-input>
                                </td>
                                <td class="center" colspan="2">
                                    <input class="form-control" name="debit_remark[]" v-model="item.remark" @change="inputChange">
                                </td>
                            </tr>
                            <tr class="gray-tr">
                                <td class="center" colspan="2">
                                    支出总计
                                </td>
                                <td class="center" colspan="3">@{{ number_format(debitInfo.total) == '' ? '' : '$' }} @{{ number_format(debitInfo.total) }}</td>
                                <td class="center" colspan="2">
                                    
                                </td>
                            </tr>

                            <tr class="gray-tr">
                                <td class="center font-weight-bold total-td" colspan="2" style="background: #d9f8fb!important">总毛利润</td>
                                <td class="center font-weight-bold" colspan="2"><span :class="profitCls(total_profit)">@{{ (number_format(total_profit) == '' ? '' : '$ ') + number_format(total_profit) }}</span></td>
                                <td class="center font-weight-bold" colspan="2" style="background: #d9f8fb!important">日毛利润</td>
                                <td class="center font-weight-bold" colspan="2"><span :class="profitCls(total_profit)">@{{ (number_format(total_profit_day) == '' ? '' : '$ ') + number_format(total_profit_day) }}</span></td>
                            </tr>
                            <!-- Debit Dynami Info End -->
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
            <!-- Main Contents End -->
        </div>
    </div>

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ cAsset('assets/js/bignumber.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>

	<?php
	echo '<script>';
    echo 'var DynamicStatus = ' . json_encode(g_enum('DynamicStatus')) . ';';
    echo 'var DynamicSub = ' . json_encode(g_enum('DynamicSub')) . ';';
	echo '</script>';
	?>

    <script>
        var vSettleObj = null;
        var $_this = null;

        var shipId = '{!! $shipId !!}';
        var voyId = '{!! $voyId !!}';
        var shipInfo = '{!! $shipInfo !!}';
        shipInfo=shipInfo.replaceAll(/\n/g, "\\n").replaceAll(/\r/g, "\\r").replaceAll(/\t/g, "\\t");
        shipInfo = JSON.parse(shipInfo);
        var DYNAMIC_SUB_SALING = '{!! DYNAMIC_SUB_SALING !!}';
        var DYNAMIC_SUB_LOADING = '{!! DYNAMIC_SUB_LOADING !!}';
        var DYNAMIC_SUB_DISCH = '{!! DYNAMIC_SUB_DISCH !!}';
        var DYNAMIC_SUB_WAITING = '{!! DYNAMIC_SUB_WAITING !!}';
        var DYNAMIC_SAILING = '{!! DYNAMIC_SAILING !!}';
        var DYNAMIC_CMPLT_DISCH = '{!! DYNAMIC_CMPLT_DISCH !!}';
        const DAY_UNIT = 1000 * 3600;
        var isChangeStatus = false;
        var searchObjTmp = new Array();
        var tmp;


        var submitted = false;
        if(isChangeStatus == false)
            submitted = false;


        var $form = '';
        var origForm = "";
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.';

            if (isChangeStatus && !submitted) {
                (e || window.event).returnValue = confirmationMessage;
                origForm = '';
            }

            return confirmationMessage;
        });

        Vue.component('my-currency-input', {
            props: ["value", "fixednumber", 'prefix', 'type'],
            template: `
                    <input v-model="displayValue" @blur="isInputActive = false" @focus="isInputActive = true; $event.target.select()" @change="setValue" v-on:keyup="keymonitor" />
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
                }
            },
            methods: {
                setValue: function() {
                    $_this.calcInfo();
                    isChangeStatus = true;
                    $_this.$forceUpdate();
                },
                keymonitor: function(e) {
                    if(e.keyCode == 9 || e.keyCode == 13)
                        $(e.target).select()
                },
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
            vSettleObj = new Vue({
                el: '#settle-info-div',
                data: {
                    shipId: shipId,
                    voyId: voyId,

                    mainInfo: [],
                    elseInfo: [],
                    fuelInfo: [],
                    creditInfo: [],
                    debitInfo: [],
                    totalInfo: [],

                    total_profit:       0,
                    total_profit_day:   0,
                },
                methods: {
                    calcInfo: function() {
                        if(__parseFloat(this.mainInfo.freight) != 0)
                            this.mainInfo.freight_price = BigNumber(this.mainInfo.freight).multipliedBy(this.mainInfo.cgo_qty).toFixed(2);
                        // else
                        

                        // this.mainInfo.freight_price = BigNumber
                        this.mainInfo.else_time = BigNumber(this.mainInfo.total_sail_time).minus(this.mainInfo.sail_time).minus(this.mainInfo.load_time).toFixed(2);
                        this.fuelInfo.total_fo = BigNumber(this.fuelInfo.rob_fo_1).plus(this.fuelInfo.rob_fo_2).toFixed(2);
                        this.fuelInfo.total_do = BigNumber(this.fuelInfo.rob_do_1).plus(this.fuelInfo.rob_do_2).toFixed(2);

                        let foTmp1 = BigNumber(this.fuelInfo.rob_fo_1).multipliedBy(this.fuelInfo.rob_fo_price_1);
                        let foTmp2 = BigNumber(this.fuelInfo.rob_fo_2).multipliedBy(this.fuelInfo.rob_fo_price_2);
                        this.fuelInfo.total_fo_price = BigNumber(foTmp1).plus(foTmp2).toFixed(2);

                        let doTmp1 = BigNumber(this.fuelInfo.rob_do_1).multipliedBy(this.fuelInfo.rob_do_price_1);
                        let doTmp2 = BigNumber(this.fuelInfo.rob_do_2).multipliedBy(this.fuelInfo.rob_do_price_2);
                        this.fuelInfo.total_do_price = BigNumber(doTmp1).plus(doTmp2).toFixed(2);

                        this.fuelInfo.total_fo_diff = BigNumber(this.fuelInfo.total_fo).minus(this.fuelInfo.used_fo).toFixed(2);
                        this.fuelInfo.total_do_diff = BigNumber(this.fuelInfo.total_do).minus(this.fuelInfo.used_do).toFixed(2);

                        foTmp1 = BigNumber(this.fuelInfo.used_fo).multipliedBy(this.fuelInfo.rob_fo_price_1).toFixed(2);
                        doTmp1 = BigNumber(this.fuelInfo.used_do).multipliedBy(this.fuelInfo.rob_do_price_1).toFixed(2);
                        this.fuelInfo.total_fo_price_diff = BigNumber(this.fuelInfo.total_fo_price).minus(foTmp1).toFixed(2);
                        this.fuelInfo.total_do_price_diff = BigNumber(this.fuelInfo.total_do_price).minus(doTmp1).toFixed(2);

                        this.debitInfo.else[0].amount = BigNumber(this.creditInfo.else[0].amount).multipliedBy(this.mainInfo.com_fee).div(100).toFixed(2);
                        this.debitInfo.else[3].amount = BigNumber(this.fuelInfo.total_fo_price).plus(this.fuelInfo.total_do_price).toFixed(2);

                        this.creditInfo.total = 0;
                        // this.creditInfo.else[0] = this.mainInfo.freight_price;
                        this.creditInfo.else.forEach(function(value, key) {
                            $_this.creditInfo.total += __parseFloat(value['amount']);
                        });

                        this.debitInfo.total = 0;
                        this.debitInfo.else.forEach(function(value, key) {
                            $_this.debitInfo.total += __parseFloat(value['amount']);
                        });

                        $_this.debitInfo.total = $_this.debitInfo.total.toFixed(2);
                        $_this.total_profit = BigNumber($_this.creditInfo.total).minus($_this.debitInfo.total).toFixed(2);
                        if($_this.mainInfo.total_sail_time > 0)
                            $_this.total_profit_day = BigNumber($_this.total_profit).div($_this.mainInfo.total_sail_time).toFixed(2);
                        else
                            $_this.total_profit_day = 0;

                        this.$forceUpdate();
                        tmp = $('#voy_list').val();
                        isChangeStatus = false;
                    },
                    deleteElseInfo: function(type, index, id) {
                        __alertAudio();
                        bootbox.confirm("Are you sure you want to delete?", function (result) {
                            if (result) {
                                if (id != undefined) {
                                    $.ajax({
                                        url: BASE_URL + 'ajax/business/voySettle/elseInfo/delete',
                                        type: 'post',
                                        data: {
                                            id: id,
                                        },
                                        success: function (data, status, xhr) {
                                            if(type == 'load')
                                                $_this.elseInfo.load.splice(index, 1);
                                            else if(type == 'disch')
                                                $_this.elseInfo.discharge.splice(index, 1);
                                            else
                                                $_this.elseInfo.fuel.splice(index, 1);
                                            $_this.$forceUpdate();

                                            // equipObjTmp = JSON.parse(JSON.stringify($_this.list))
                                        }
                                    })
                                } else {
                                    if(type == 'load')
                                        $_this.elseInfo.load.splice(index, 1);
                                    else if(type == 'disch')
                                        $_this.elseInfo.discharge.splice(index, 1);
                                    else
                                        $_this.elseInfo.fuel.splice(index, 1);

                                    $_this.$forceUpdate();
                                }
                            }
                        });
                    },
                    addRow: function(type, index, id) {
                        if(type == 'load') {
                            if(index == 0)
                                this.elseInfo.load.push([]);
                            else {
                                this.deleteElseInfo(type, index, id);
                            }
                        } else if(type == 'disch') {
                            if(index == 0)
                                this.elseInfo.discharge.push([]);
                            else
                                this.deleteElseInfo(type, index, id);
                                
                        } else {
                            if(index == 0)
                                this.elseInfo.fuel.push([]);
                            else
                                this.deleteElseInfo(type, index, id);
                        }

                        this.$forceUpdate();
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
                    inputChange: function() {
                        isChangeStatus = true;
                    },

                    dateModify(e, index, where, type) {
                        $(e.target).on("change", function() {
                            isChangeStatus = true;
                            if(where == 'main') {
                                $_this.mainInfo[type + '_date'] = $(this).val();
                                let load_date = $("[name=load_date]").val();
                                let load_hour = $("[name=load_hour]").val();
                                let load_minute = $("[name=load_minute]").val();

                                let dis_date = $("[name=dis_date]").val();
                                let dis_hour = $("[name=dis_hour]").val();
                                let dis_minute = $("[name=dis_minute]").val();
                                
                                $_this.mainInfo.total_sail_time = __getTermDay(load_date + ' ' + load_hour + ':' + load_minute + ':00', dis_date + ' ' + dis_hour + ':' + dis_minute + ':00');
                                $_this.calcInfo();
                                isChangeStatus = true;
                                $_this.$forceUpdate();
                            } else if(where == 'origin') {
                                $_this.elseInfo.date = $(this).val();
                            } else {
                                $_this.elseInfo[where][index][type + '_date'] = $(this).val();
                            }
                        });
                        
                        $_this.$forceUpdate();
                    },
                    number_format: function(value, decimal = 2) {
                        return __parseFloat(value) == 0 ? '' : number_format(value, decimal);
                    },
                    profitCls: function(value) {
                        return value < 0 ? 'text-danger' : 'text-profit';
                    }
                },
                updated() {
                    $('.date-picker').datepicker({
                        autoclose: true,
                        format: 'yyyy-mm-dd',
                    }).next().on(ace.click_event, function () {
                        $(this).prev().focus();
                    });
                    offAutoCmplt();
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
                }
            });

            $_this = vSettleObj;
            $_this.shipId = shipId;
            $_this.voyId = voyId;

            getInitInfo();
        }

        function getInitInfo() {
            $.ajax({
                url: BASE_URL + 'ajax/business/voySettle/index',
                type: 'post',
                data: {
                    shipId: $_this.shipId,
                    voyId: $_this.voyId,
                },
                success: function(data, status, xhr) {
                    let result = data;
                    $_this.mainInfo = Object.assign([], [], result['main']);
                    $_this.elseInfo = Object.assign([], [], result['else']);
                    $_this.fuelInfo = Object.assign([], [], result['fuel']);
                    $_this.creditInfo = Object.assign([], [], result['credit']);
                    $_this.debitInfo = Object.assign([], [], result['debit']);

                    $_this.calcInfo();
                }
            })
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

            return parseFloat(diffDay.div(24).toFixed(2));
        }

        function submitForm() {
            submitted = true;
            $('#voy-settle-form').submit();
        }

        function openNewPage(type) {
            if(type == 'soa') {
                //window.open(BASE_URL + 'business/contract?shipId=' + this.shipId, '_blank');
                window.localStorage.setItem("soa_shipid",this.shipId);
                window.localStorage.setItem("soa_voyNo",$_this.voyId);
                window.open(BASE_URL + 'operation/incomeExpense', '_blank');
            } else {
                window.open(BASE_URL + 'shipManage/dynamicList?shipId=' + this.shipId + '&voyNo=' + $_this.voyId, '_blank');
            }
        }

        function clearData() {
            let confirmationMessage = '确定要初始化吗？';
            bootbox.confirm(confirmationMessage, function (result) {
                if(result) {
                    $.ajax({
                        url: BASE_URL + 'ajax/business/setttlement/clear',
                        type: 'post',
                        data: {
                            shipId: $_this.shipId,
                            voyId: $_this.voyId
                        },
                        success: function(data) {
                            location.href = '/business/settleMent?shipId=' + $_this.shipId + '&voyId=' + $_this.voyId;
                        }
                        
                    });
                }
            });
        }

        $('#ship_list').on('change', function() {
            let val = $(this).val();

            location.href = "/business/settleMent?shipId=" + val;
        });

        $('#voy_list').on('change', function () {
            var newVal = $(this).val();
            var confirmationMessage = 'It looks like you have been editing something. '
                    + 'If you leave before saving, your changes will be lost.';

            if (!submitted && isChangeStatus) {
                __alertAudio();
                $_this.voyId = tmp;
                $(this).val(tmp)
                bootbox.confirm(confirmationMessage, function (result) {
                    if (!result) {
                        return;
                    } else {
                        $_this.voyId = newVal;
                        $('#voy_list').val(newVal);
                        getInitInfo();
                    }
                });
            } else {
                $_this.voyId = newVal;
                getInitInfo();
            }
        })

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

        function fnExcelRecord() {
            var tab_text = "";
            tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            real_tab = document.getElementById('table-settlement');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='8' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_info').html() + '_'  + $('#voy_list').val() + "_航次结算表" + "</td></tr>";
            
            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j==0 || j==8 || j==14 || j==19 || j==25 || j==38) {
                    for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                }
                else
                {
                    for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                        var node = tab.rows[j].childNodes[i].childNodes[0];
                        if ( node != undefined)
                        {
                            var type = node.nodeType;
                            var value;
                            if (type == 3) continue;
                            if (node.tagName=='DIV') {
                                value = node.childNodes[0].childNodes[0].value + " " + node.childNodes[2].childNodes[0].value + " " + node.childNodes[4].childNodes[0].value;
                                tab.rows[j].childNodes[i].innerHTML = value;
                            }
                            else if(node.tagName=='INPUT'){
                                value = node.value;
                                tab.rows[j].childNodes[i].innerHTML = value;
                            }
                        }
                    }
                }
                if (tab.rows[j].lastChild.className.indexOf('no-border') >= 0) {
                    tab.rows[j].lastChild.remove();
                }
                tab.rows[0].childNodes[0].colSpan = 8;
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = $('#search_info').html() + '_'  + $('#voy_list').val() + "_航次结算表";
            exportExcel(tab_text, filename, filename);
            
            return 0;
        }

        $('body').on('keydown', 'input', function(e) {
            //if (e.target.id == "search-name") return;
            if (e.key === "Enter") {
                var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                focusable = form.find('input:not([readonly="readonly"])').filter(':visible');
                next = focusable.eq(focusable.index(this)+1);
                if (next.length) {
                    next.focus();
                    next.select();
                }
                return false;
            }
        });

        function dateChange() {
            let load_date = $("[name=load_date]").val();
            let load_hour = $("[name=load_hour]").val();
            let load_minute = $("[name=load_minute]").val();

            let dis_date = $("[name=dis_date]").val();
            let dis_hour = $("[name=dis_hour]").val();
            let dis_minute = $("[name=dis_minute]").val();
            
            $_this.mainInfo.total_sail_time = __getTermDay(load_date + ' ' + load_hour + ':' + load_minute + ':00', dis_date + ' ' + dis_hour + ':' + dis_minute + ':00');
            $_this.calcInfo(); 
            isChangeStatus = true;
        }

    </script>

@endsection