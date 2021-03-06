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
    <link href="{{ cAsset('css/pretty.css?v=20211006104500') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/vue.css?v=20211006104500') }}" rel="stylesheet"/>
    <link href="{{ cAsset('css/dycombo.css?v=20211006104500') }}" rel="stylesheet"/>
@endsection


@section('content')
    <style>
        #table-main-2 .text-warning {
            font-weight: bold!important;
        }
    </style>
    <div class="main-content">
        <div class="page-content">
            <div class="page-header">
                <div class="col-md-3">
                    <h4>
                        <b>航次评估</b>
                    </h4>
                </div>
            </div>

            <div class="col-lg-12 full-width">
                <ul class="nav nav-tabs ship-register for-pc">
                    <li class="{{ !isset($type) || $type == 'main' ? 'active' : '' }}">
                        <a data-toggle="tab" href="#equipment_record">
                            航次评估
                        </a>
                    </li>
                    <li class="{{ isset($type) && $type == 'else' ? 'active' : '' }}">
                        <a data-toggle="tab" href="#equipment_require_div">
                        航次比较
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content pt-1">
                    <div id="equipment_record" class="tab-pane {{ !isset($type) || $type == 'main' ? 'active' : '' }} custom-for-pc">
                        @include('shipManage.voy_evaluation_main')
                    </div>
                    <div id="equipment_require_div" class="tab-pane {{ isset($type) && $type == 'else' ? 'active' : '' }} custom-for-sp">
                        @include('shipManage.voy_evaluation_else')
                    </div>
                </div>
            </div>

            <div id="modal-wizard" class="modal modal-draggable" aria-hidden="true" style="display: none; margin-top: 15%;">
                <div class="dynamic-modal-dialog">
                    <div class="dynamic-modal-content" style="border: 0;">
                        <div class="dynamic-modal-header" data-target="#modal-step-contents">
                            <div class="table-header">
                                <button type="button"  style="margin-top: 8px; margin-right: 12px;" class="close" data-dismiss="modal" aria-hidden="true">
                                    <span class="white">&times;</span>
                                </button>
                                船舶证书种类登记
                            </div>
                        </div>
                        <div id="modal-cert-type" class="dynamic-modal-body step-content">
                            <div class="row">
                                <form action="saveShipReqEquipmentType" method="post" id="shipEquipForm">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="head-fix-div col-md-12" style="height:300px;">
                                        <table class="table-bordered rank-table">
                                            <thead>
                                            <tr class="rank-tr" style="background-color: #d9f8fb;height: 5%">
                                                <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:30%">OrderNo</th>
                                                <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:50%">Name</th>
                                                <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width: 15%;"></th>
                                            </tr>
                                            </thead>
                                            <tbody id="rank-table">
                                            <tr class="no-padding center" v-for="(typeItem, index) in list">
                                                <td class="d-none">
                                                    <input type="hidden" name="id[]" v-model="typeItem.id">
                                                </td>
                                                <td class="no-padding center">
                                                    <input type="text" @focus="addNewRow(this)" class="form-control" name="order_no[]" v-model="typeItem.order_no" style="width: 100%;text-align: center">
                                                </td>
                                                <td class="no-padding center">
                                                    <input type="text" @focus="addNewRow(this)" class="form-control" name="name[]" v-model="typeItem.name" style="width: 100%;text-align: center">
                                                </td>
                                                <td class="no-padding center">
                                                    <div class="action-buttons">
                                                        <a class="red" @click="deleteShipCert(typeItem.id)"><i class="icon-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="btn-group f-right mt-20 d-flex">
                                        <button type="button" class="btn btn-success small-btn ml-0" @click="ajaxFormSubmit">
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
        </div>
    </div>

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>
    <script src="https://unpkg.com/vuejs-datepicker"></script>
    <!--script src="{{ asset('/assets/js/dycombo.js') }}"></script-->
    <script src="{{ cAsset('assets/js/bignumber.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

	<?php
	echo '<script>';
    echo 'var PlaceType = ' . json_encode(g_enum('PlaceType')) . ';';
    echo 'var VarietyType = ' . json_encode(g_enum('VarietyType')) . ';';
    echo 'var UnitData = ' . json_encode(g_enum('UnitData')) . ';';
	echo '</script>';
	?>
    <script>



        var equipObj = null;
        var certTypeObj = null;
        var $_this = null;
        var shipCertTypeList = [];
        var equipObjTmp = [];
        var certIdList = [];
        var certIdListTmp = [];
        var IS_FILE_KEEP = '{!! IS_FILE_KEEP !!}';
        var IS_FILE_DELETE = '{!! IS_FILE_DELETE !!}';
        var IS_FILE_UPDATE = '{!! IS_FILE_UPDATE !!}';
        var shipId = '{!! $shipId !!}';
        var initLoad = true;


        $(function () {
            // Initialize
            initialize();

        });

        Vue.component('my-currency-input', {
            props: ["value", "fixednumber", 'prefix', 'type', 'index'],
            template: `
                    <input type="text" v-model="displayValue" @blur="isInputActive = false" @change="setValue" @focus="isInputActive = true; $event.target.select()" v-on:keyup="keymonitor" />
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
                            let fixedLength = 2;
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
                setValue: function() {
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

        function initialize() {
            initRecord();
            initRequire();
        }
    </script>
@endsection