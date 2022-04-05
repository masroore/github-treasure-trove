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
                        <b>CTM记录</b>
                    </h4>
                </div>

            </div>
            <div class="col-lg-12">
                <div class="col-lg-12">
                    <ul class="nav nav-tabs ship-register">
                        <li class="{{ !isset($type) || $type == 'CNY' ? 'active' : '' }}">
                            <a data-toggle="tab" href="#rmb_cmt_div" onclick="changeTab('CNY')">
                                RMB</span>
                            </a>
                        </li>
                        <li class="{{ isset($type) && $type == 'USD' ? 'active' : '' }}">
                            <a data-toggle="tab" href="#usd_cmt_div" onclick="changeTab('USD')">
                                USD</span>
                            </a>
                        </li>
                        <li>
                            <div class="alert alert-block alert-success center visuallyhidden">
                                <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
                                <strong id="msg-content"> Please register a new ship contract.</strong>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-2">
                        <div id="rmb_cmt_div" class="tab-pane {{ !isset($type) || $type == 'CNY' ? 'active' : '' }}">
                            @include('business.ctm.rmb_index')
                        </div>
                        <div id="usd_cmt_div" class="tab-pane {{ isset($type) && $type == 'USD' ? 'active' : '' }}">
                            @include('business.ctm.usd_index')
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

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="https://unpkg.com/vuejs-datepicker/dist/locale/translations/zh.js"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>
    <script src="https://unpkg.com/vuejs-datepicker"></script>
    <script src="{{ asset('/assets/js/dycombo.js') }}"></script>
    <script src="{{ cAsset('assets/js/bignumber.js') }}"></script>

	<?php
	echo '<script>';
    echo 'var ProfitTypeData = ' . json_encode(g_enum('ProfitTypeData')) . ';';
	echo '</script>';
	?>
    <script>
        var rmbListObj = null;
        var usdListObj = null;
        var ctmListTmp = new Array();
        var ACTIVE_TAB = '{!! $type !!}';
        var IS_FILE_KEEP = '{!! IS_FILE_KEEP !!}';
        var IS_FILE_DELETE = '{!! IS_FILE_DELETE !!}';
        var IS_FILE_UPDATE = '{!! IS_FILE_UPDATE !!}';
        var ship_id = '{!! $shipId !!}';
        var isChangeStatus = false;
        var initLoad = true;
        var activeYear = '{!! $activeYear !!}';

        var submitted = false;

        $("form").submit(function() {
            submitted = true;
        });

        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.';
            let currentObj = JSON.parse(JSON.stringify(_this.list));
            if(JSON.stringify(currentObj) == JSON.stringify(ctmListTmp))
                isChangeStatus = false;
            else
                isChangeStatus = true;

            if (!submitted && isChangeStatus) {
                (e || window.event).returnValue = confirmationMessage;
            }

            return confirmationMessage;
        });

        Vue.component('my-currency-input', {
            props: ["value", "fixednumber", 'prefix', 'type', 'index'],
            template: `
                    <input type="text" v-model="displayValue" @blur="isInputActive = false" @focus="isInputActive = true; $event.target.select()" @change="calcTotal()" v-on:keyup="keymonitor" />
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
                calcTotal: function(e) {
                    if(ACTIVE_TAB == 'USD') {
                        _uThis.setDebitCredit(this.type, this.index);
                        _uThis.calcTotal();
                    } else {
                        _this.setDebitCredit(this.type, this.index);
                        _this.calcTotal();
                    }
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

        $(function () {
            initializeRmb();
            initializeUsd();
        });

        function changeTab(type) {
           ACTIVE_TAB = type;
        }        
    </script>
@endsection