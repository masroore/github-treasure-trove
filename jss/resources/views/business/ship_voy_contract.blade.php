<form method="post" action="voyContractRegister" enctype="multipart/form-data" id="voyContractForm">
<div class="d-flex" id="voy_input">
    
    <div class="tab-left contract-input-div"  id="voy_input_div" v-cloak>
        <div class="d-flex">
            <label class="font-bold ml-3">预计</label>
            <label class="ml-3">货币</label>
            <select class="ml-1" name="currency" v-model="input['currency']">
                <option value="USD">$</option>
                <option value="CNY">¥</option>
            </select>

            <div class="label-input ml-1" style="width: 120px;">
                <label>{!! trans('common.label.curr_rate') !!}</label>
                <input type="text" name="rate" v-model="input['rate']">
            </div>
        </div>
        <div class="d-flex mt-2">
            <div class="voy-input-left voy-child">
                <h5 class="ml-5 brown font-bold">输入</h5>
                <div class="d-flex mt-20 attribute-div">
                    <div class="vertical">
                        <label>速度</label>
                        <my-currency-input v-model="input['speed']" name="speed" v-bind:prefix="''" v-bind:fixednumber="1" maxlength="4" minlength="4"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>距离(NM)</label>
                        <my-currency-input v-model="input['distance']" name="distance" v-bind:prefix="''" v-bind:fixednumber="0" maxlength="4" minlength="4" step="1"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>装货天数</label>
                        <my-currency-input v-model="input['up_ship_day']" name="up_ship_day" v-bind:prefix="''"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>卸货天数</label>
                        <my-currency-input v-model="input['down_ship_day']" name="down_ship_day" v-bind:prefix="''"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>等待天数</label>
                        <my-currency-input v-model="input['wait_day']" name="wait_day" v-bind:prefix="''"></my-currency-input>
                    </div>
                </div>

                <h5 class="mt-20">日消耗&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(MT)</h5>
                <div class="d-flex daily-use">
                    <div class="vertical">
                        <label>&nbsp;</label>
                        <label>FO</label>
                        <label>DO</label>
                    </div>
                    <div class="vertical">
                        <label>航行</label>
                        <my-currency-input class="output-text" v-model="input['fo_sailing']" name="fo_sailing" v-bind:prefix="''" v-bind:fixednumber="1"></my-currency-input>
                        <my-currency-input class="output-text" v-model="input['do_sailing']" name="do_sailing" v-bind:prefix="''" v-bind:fixednumber="1"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>装/卸</label>
                        <my-currency-input class="output-text" v-model="input['fo_up_shipping']" name="fo_up_shipping" v-bind:prefix="''" v-bind:fixednumber="1"></my-currency-input>
                        <my-currency-input class="output-text" v-model="input['do_up_shipping']" name="do_up_shipping" v-bind:prefix="''" v-bind:fixednumber="1"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>等待</label>
                        <my-currency-input class="output-text" v-model="input['fo_waiting']" name="fo_waiting" v-bind:prefix="''" v-bind:fixednumber="1"></my-currency-input>
                        <my-currency-input class="output-text" v-model="input['do_waiting']" name="do_waiting" v-bind:prefix="''" v-bind:fixednumber="1"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>价格</label>
                        <my-currency-input v-model="input['fo_price']" name="fo_price" v-bind:fixednumber="0"></my-currency-input>
                        <my-currency-input v-model="input['do_price']" name="do_price" v-bind:fixednumber="0"></my-currency-input>
                    </div>
                </div>
                <hr class="gray-dotted-hr">
                <div class="d-flex  mt-20 attribute-div">
                    <div class="vertical">
                        <label>程租</label>
                        <label>&nbsp;</label>
                    </div>
                    <div class="vertical">
                        <label>货量(MT)</label>
                        <my-currency-input v-model="input['cargo_amount']" name="cargo_amount" v-bind:prefix="''"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>运费率</label>
                        <my-currency-input v-model="input['freight_price']" :readonly="batchStatus == true" name="freight_price"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label for="batch-manage" class="batch-manage"><input type="checkbox" v-model="batchStatus" name="batch_manage" id="batch-manage" @change="calcContractPreview">包船</label>
                        <my-currency-input type="text" v-bind:class="batchStatus == true ? '' : 'output-text'" name="batch_price" :readonly="batchStatus == false"  v-bind:fixednumber="0" v-model="input['batch_price']" @change="calcContractPreview"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>佣金(%)</label>
                        <my-currency-input v-model="input['fee']" name="fee" v-bind:prefix="''"></my-currency-input>
                    </div>
                </div>
                <div class="d-flex  mt-20 attribute-div">
                    <div class="vertical">
                        <label>&nbsp;</label>
                        <label>支出</label>
                    </div>
                    <div class="vertical">
                        <label class="debit-label">装港费</label>
                        <my-currency-input v-model="input['up_port_price']" name="up_port_price" v-bind:fixednumber="0"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label class="debit-label">卸港费</label>
                        <my-currency-input v-model="input['down_port_price']" name="down_port_price" v-bind:fixednumber="0"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label class="debit-label">日成本</label>
                        <my-currency-input v-model="input['cost_per_day']" name="cost_per_day" v-bind:fixednumber="0"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label @click="calcElseCost" class="else-cost">其他（运营）</label>
                        <my-currency-input v-model="input['cost_else']" name="cost_else" v-bind:fixednumber="0"></my-currency-input>
                    </div>
                </div>
            </div>

            <div class="voy-input-right voy-child">
                <h5 class="ml-5 brown font-bold">输出</h5>
                <div class="d-block mt-20">
                    <div class="d-flex horizontal">
                        <label>航次用时</label>
                        <my-currency-input class="text-right" readonly v-model="output['sail_time']" name="sail_time" v-bind:prefix="''"></my-currency-input>
                        <span>天</span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>航行</label>
                        <my-currency-input class="text-right" readonly v-model="output['sail_term']" name="sail_term" v-bind:prefix="''"></my-currency-input>
                        <span>天</span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>停泊</label>
                        <my-currency-input class="text-right" readonly v-model="output['moor']" name="moor" v-bind:prefix="''"></my-currency-input>
                        <span>天</span>
                    </div>
                </div>
                <div class="d-block mt-20">
                    <div class="d-flex horizontal">
                        <label>油款</label>
                        <my-currency-input class="text-left bigger-input" readonly v-model="output['oil_money']" name="oil_money"></my-currency-input>
                        <span></span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>FO</label>
                        <my-currency-input class="text-right" readonly v-model="output['fo_mt']" name="fo_mt" v-bind:prefix="''"></my-currency-input>
                        <span>MT</span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>DO</label>
                        <my-currency-input class="text-right" readonly v-model="output['do_mt']" name="do_mt" v-bind:prefix="''"></my-currency-input>
                        <span>MT</span>
                    </div>
                </div>

                <hr class="gray-dotted-hr">

                <div class="d-block mt-20">
                    <div class="d-flex horizontal">
                        <label>收入</label>
                        <my-currency-input class="text-left bigger-input" readonly v-model="output['credit']" name="credit"></my-currency-input>
                    </div>
                    <div class="d-flex horizontal">
                        <label>支出</label>
                        <my-currency-input class="text-left bigger-input" readonly v-model="output['debit']" name="debit"></my-currency-input>
                    </div>
                    <div class="d-flex horizontal">
                        <label>净利润</label>
                        <my-currency-input class="text-left bigger-input" :class="profitClass(output['net_profit'])" readonly v-model="output['net_profit']" name="net_profit"></my-currency-input>
                    </div>
                    <div class="d-flex horizontal">
                        <label>日净利润</label>
                        <my-currency-input class="text-left bigger-input" :class="profitClass(output['net_profit_day'])" readonly v-model="output['net_profit_day']" name="net_profit_day" v-bind:fixedNumber="0" maxlength="5"></my-currency-input>
                        <span></span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>参考(最高)</label>
                        <my-currency-input class="text-left double-input-left" style="color: #126EB9 !important; font-weight: bold" readonly v-model="output['max_profit']" v-bind:fixedNumber="0" name="max_profit" v-bind:fixednumber="2"></my-currency-input>
                        <input type="text" class="text-left double-input-right" readonly name="max_voy" v-model="output['max_voy']">
                        <span>航次</span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>(最低)</label>
                        <my-currency-input class="text-left double-input-left" style="color: red!important; font-weight: bold" readonly v-model="output['min_profit']" v-bind:fixedNumber="0" name="min_profit" v-bind:fixednumber="0"></my-currency-input>
                        <input type="text" class="text-left double-input-right" readonly name="min_voy" v-model="output['min_voy']">
                        <span>航次</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-group f-right mt-20">
            <a class="btn btn-primary btn-sm" :disabled="is_finish" @click="onEditFinish">OK</a>
            <a class="btn btn-danger btn-sm" :disabled="!is_finish" @click="onEditContinue">Cancel</a>
        </div>
    </div>
    
    <div class="tab-right contract-input-div" id="voy_contract_table" @click="resultDiv" v-cloak>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" value="{{ $shipId }}" name="shipId" v-model="shipId">
        <input type="hidden" value="{{ $voy_id }}" name="voy_id" id="voy_id">
        <label>航次: </label>
        <input type="text" name="voy_no" v-model="voy_no" minlength="4" maxlength="4" style="width:80px;" @focus="disableSubmit" @focusout="validateVoyNo" require>
        <span class="text-danger" v-bind:class="getValidClass">Voy No already exits.</span>
        <table class="contract-table mt-2">
            <tr>
                <td style="width: 80px;">合同日期</td>
                <td class="font-style-italic">CP_DATE</td>
                <td><input type="text" class="date-picker form-control" name="cp_date" v-model="cp_date" @click="dateModify($event, 'cp_date')"></td>
                <td></td>
            </tr>
            <tr>
                <td>租船种类</td>
                <td class="font-style-italic">CP TYPE</td>
                <td><input type="text" class="form-control font-bold" value="VOY" name="cp_type" readonly></td>
                <td></td>
            </tr>
            <tr>
                <td>货名</td>
                <td class="font-style-italic">CARGO</td>
                <td colspan="2" style="border-right: 1px solid #4c4c4c">
                    <div class="dynamic-select-wrapper" @click="certTypeChange">
                        <div class="dynamic-select" style="color:#12539b">
                            <input type="hidden"  name="cargo" v-model="cargoIDList"/>
                            <div class="dynamic-select__trigger dynamic-arrow multi-dynamic-select">
                                @{{ cargoNames }}
                            </div>
                            <div class="dynamic-options multi-select" style="margin-top: -17px;">
                                <div class="dynamic-options-scroll">
                                    <div v-for="(cargoItem, index) in cargoList" class="d-flex dynamic-option" v-bind:class="getOptionCls(cargoItem.is_selected)">
                                        <input type="checkbox" name="cargo_id[]" v-bind:value="index" v-bind:id="index">
                                        <label :for="index" class="width-100">@{{ cargoItem.name }}</label>
                                    </div>
                                </div>
                                <hr class="gray-dotted" style="margin: 8px 0;">
                                <div class="btn-group f-right" style="margin: 0 0 8px 0;">
                                    <button type="button" class="btn btn-primary btn-sm" @click="confirmItem('cargo')">OK</button>
                                    <button type="button" class="btn btn-danger btn-sm" @click="closeDialog">Cancel</button>
                                </div>
                                <div class="multi-edit-div">
                                    <span class="edit-list-btn" id="edit-list-btn" @click="openDialog('cargo')">
                                        <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items" style="width: 36px; height: 36px; min-width: 36px; min-height: 36px;">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>货量</td>
                <td class="font-style-italic">QTTY</td>
                <td><input type="text" class="form-control" name="qty_amount" v-model="qty_amount"></td>
                <td>
                    <select class="form-control" name="qty_type" v-model="qty_type">
                        <option>MOLOO</option>
                        <option>MOLCO</option>
                    </selec>
                </td>
            </tr>
            <tr>
                <td>装港</td>
                <td class="font-style-italic">LOADING PORT</td>
                <td colspan="2" style="border-right: 1px solid #4c4c4c">
                    <div class="dynamic-select-wrapper" @click="certTypeChange">
                        <div class="dynamic-select" style="color:#12539b">
                            <input type="hidden" name="up_port" v-model="upPortIDList"/>
                            <div class="dynamic-select__trigger dynamic-arrow multi-dynamic-select">
                                @{{ upPortNames }}
                            </div>
                            <div class="dynamic-options multi-select" style="margin-top: -17px;">
                                <div class="dynamic-options-scroll">
                                    <div v-for="(portItem, index) in portList" class="d-flex dynamic-option">
                                        <input type="checkbox" name="up_port_id[]" v-bind:value="portItem.id" v-bind:id="index + '_upPort'" @click="selectItem($event, 'up_port')">
                                        <label :for="index + '_upPort'" class="width-100">@{{ portItem.Port_En }}</label>
                                    </div>
                                </div>
                                <hr class="gray-dotted" style="margin: 8px 0;">
                                <div class="btn-group f-right" style="margin: 0 0 8px 0;">
                                    <button type="button" class="btn btn-primary btn-sm" @click="confirmItem('up_port')">OK</button>
                                    <button type="button" class="btn btn-danger btn-sm" @click="closeDialog">Cancel</button>
                                </div>
                                <div class="multi-edit-div">
                                    <span class="edit-list-btn" id="edit-list-btn" @click="openDialog('port')">
                                        <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items" style="width: 36px; height: 36px; min-width: 36px; min-height: 36px;">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>卸港</td>
                <td class="font-style-italic">DISCHARGING PORT</td>
                <td colspan="2" style="border-right: 1px solid #4c4c4c">
                    <div class="dynamic-select-wrapper" @click="certTypeChange">
                        <div class="dynamic-select" style="color:#12539b">
                            <input type="hidden" name="down_port" v-model="downPortIDList"/>
                            <div class="dynamic-select__trigger dynamic-arrow multi-dynamic-select">
                                @{{ downPortNames }}
                            </div>
                            <div class="dynamic-options multi-select" style="margin-top: -17px;">
                                <div class="dynamic-options-scroll">
                                    <div v-for="(portItem, index) in portList" class="d-flex dynamic-option">
                                        <input type="checkbox" name="down_port_id[]" v-bind:value="portItem.id" v-bind:id="index + '_downPort'" @click="selectItem($event, 'down_port')">
                                        <label :for="index + '_downPort'" class="width-100">@{{ portItem.Port_En }}</label>
                                    </div>
                                </div>
                                <hr class="gray-dotted" style="margin: 8px 0;">
                                <div class="btn-group f-right" style="margin: 0 0 8px 0;">
                                    <button type="button" class="btn btn-primary btn-sm" @click="confirmItem('down_port')">OK</button>
                                    <button type="button" class="btn btn-danger btn-sm" @click="closeDialog">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>受载期</td>
                <td class="font-style-italic">LAY/CAN</td>
                <td><input type="text" class="date-picker form-control" name="lay_date" v-model="lay_date" @click="dateModify($event, 'lay_date')"></td>
                <td><input type="text" class="date-picker form-control" name="can_date" v-model="can_date" @click="dateModify($event, 'can_date')"></td>
            </tr>
            <tr>
                <td>装率</td>
                <td class="font-style-italic">LOAD RATE</td>
                <td colspan="2" style="border-right: 1px solid #4c4c4c"><input type="text" class="form-control" name="load_rate" v-model="load_rate"></td>
            </tr>
            <tr>
                <td>卸率</td>
                <td class="font-style-italic">DISCH RATE</td>
                <td colspan="2" style="border-right: 1px solid #4c4c4c"><input type="text" class="form-control" name="disch_rate" v-model="disch_rate"></td>
            </tr>
            <tr>
                <td>运费率</td>
                <td class="font-style-italic">FREGITH RATE</td>
                <td><input type="text" class="form-control" name="freight_rate" readonly v-model="freight_rate"></td>
                <td></td>
            </tr>
            <tr>
                <td>包船</td>
                <td class="font-style-italic">LUMPSUM</td>
                <td><input type="text" class="form-control" name="lumpsum" readonly v-model="lumpsum"></td>
                <td></td>
            </tr>
            <tr>
                <td>滞期费</td>
                <td class="font-style-italic">DEMURR/DETEN FEE</td>
                <td><input type="text" class="form-control" name="deten_fee" v-model="deten_fee"></td>
                <td></td>
            </tr>
            <tr>
                <td>速遣费</td>
                <td class="font-style-italic">DISPATCH FEE</td>
                <td><input type="text" class="form-control" name="dispatch_fee" v-model="dispatch_fee"></td>
                <td></td>
            </tr>
            <tr>
                <td>佣金</td>
                <td class="font-style-italic">COM</td>
                <td><input type="text" class="form-control" name="com_fee" readonly v-model="com_fee"></td>
                <td>%</td>
            </tr>
            <tr>
                <td>租家</td>
                <td class="font-style-italic">CHARTERER</td>
                <td colspan="2" style="border-right: 1px solid #4c4c4c;">
                    <textarea name="charterer" class="form-control" rows="2" v-model="charterer"></textarea>
                </td>
            </tr>
            <tr>
                <td>电话</td>
                <td class="font-style-italic">TEL</td>
                <td colspan="2" style="border-right: 1px solid #4c4c4c;">
                    <input type="text" class="form-control" name="tel_number" v-model="tel_number">
                </td>
            </tr>
            <tr>
                <td>备注</td>
                <td class="font-style-italic">REMARK</td>
                <td colspan="2" style="border-right: 1px solid #4c4c4c;">
                    <textarea name="remark" class="form-control" rows="2" v-model="remark"></textarea>
                </td>
            </tr>
        </table>

        <div class="attachment-div d-flex mt-20">
            <img src="{{ cAsset('/assets/images/paper-clip.png') }}" width="15" height="15">
            <span class="ml-1">附&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;件: </span>
            <label for="contract_attach" class="ml-1 blue contract-attach d-flex">
                <span class="contract-file-name">@{{ fileName }}</span>
                <button type="button" class="btn btn-danger p-0" style="min-width: 30px;" @click="removeFile"><i class="icon-remove mr-0"></i></button>
            </label>
            <input type="file" id="contract_attach" name="attachment" class="d-none" @change="onFileChange">
            <input type="hidden" name="file_remove" id="file_remove" value="0">
            <input type="hidden" name="voy_currency" v-model="currency">
            <input type="hidden" name="voy_rate" v-model="rate">
        </div>
    </div>
</div>
</form>
<script src="{{ cAsset('assets/js/moment.js') }}"></script>
<script src="{{ cAsset('assets/js/bignumber.js') }}"></script>
<script src="{{ cAsset('assets/js/vue.js') }}"></script>
<script src="{{ cAsset('assets/js/vue-numeral-filter.min.js') }}"></script>
<script src="{{ asset('/assets/js/dycombo.js') }}"></script>
<script>
    var voyInputObj = null;
    var voyContractObj = null;

    var isChangeStatus = false;
    var DEFAULT_CURRENCY = '{!! USD_LABEL !!}';
    var DECIMAL_SIZE = 2;

    function disabledVoy(type = true) {
        $('#voy_contract_table [name=voy_no]').attr('disabled', type);
        if(type)
            $('#submit').attr('disabled', true);
    }
    function initializeVoy() {
        disabledVoy();
        voyInputObj = new Vue({
            el: "#voy_input_div",
            data: {
                batchStatus: false,
                is_finish: false,
                input: {
                    currency:           DEFAULT_CURRENCY,
                    rate:               0,
                    speed:              0,
                    distance:           0,
                    up_ship_day:        0,
                    down_ship_day:      0,
                    wait_day:           0,

                    fo_sailing:         0,
                    fo_up_shipping:     0,
                    fo_waiting:         0,
                    fo_price:           0,
                    do_sailing:         0,
                    do_up_shipping:     0,
                    do_waiting:         0,
                    do_price:           0,

                    cargo_amount:       0,
                    freight_price:      0,
                    fee:                0,
                    batch_price:        0,
                    up_port_price:      0,
                    down_port_price:    0,
                    cost_per_day:       0,
                    cost_else:          0
                },
                output: {
                    sail_time:          0,
                    sail_term:          0,
                    moor:               0,
                    oil_money:          0,
                    fo_mt:              0,
                    do_mt:              0,
                    credit:             0,
                    debit:              0,
                    net_profit:         0,
                    net_profit_day:     0,
                    max_profit:         0,
                    max_voy:            0,
                    min_profit:         0,
                    min_voy:            0,
                }
            },
            ready: function() {
                calcContractPreview();
                console.log('aaaaaaa')
            },
            methods: {
                onEditFinish: function() {
                    this.is_finish = true;
                    disabledVoy(false);
                    voyContractObj.checkVoyNo($('#voyContractForm [name=voy_no]').val());
                    if(voyContractObj.pre_cp_date == '')
                        voyContractObj.cp_date = this.getToday('-');
                    else 
                        voyContractObj.cp_date = voyContractObj.pre_cp_date;

                    voyContractObj.qty_amount = this.input['cargo_amount'];
                    // voyContractObj.freight_rate = '$ ' + this.input['freight_price'];
                    voyContractObj.net_profit_day = this.output['net_profit_day'];
                    voyContractObj.currency = this.input['currency'];
                    voyContractObj.rate = this.input['rate'];

                    if(this.batchStatus == true) {
                        voyContractObj.lumpsum = '$ ' + this.input['batch_price'];
                        voyContractObj.freight_rate = '';
                    } else {
                        voyContractObj.freight_rate = __parseFloat(this.input['freight_price']) == 0 ? '' : '$ ' + __parseFloat(this.input['freight_price']);
                        voyContractObj.lumpsum = '';
                    }
                    
                    voyContractObj.com_fee = this.input['fee'];
                    $('#voy_input_div input').attr('readonly', '');
                    $('[name=currency]').attr('readonly', '');

                    voyContractObjTmp = JSON.parse(JSON.stringify(voyContractObj._data));
                },
                onEditContinue: function() {
                    this.is_finish = false;
                    disabledVoy(true)
                    $('#voy_input_div input').removeAttr('readonly');
                    $('[name=currency]').removeAttr('readonly');
                    if(voyInputObj.batchStatus) {
                        $('[name=batch_price]').removeAttr('readonly');
                        $('[name=freight_price]').attr('readonly', '');

                    } else {
                        $('[name=batch_price]').attr('readonly','');
                        $('[name=freight_price]').removeAttr('readonly');
                    }
                },
                getToday: function(symbol) {
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();
                    today = yyyy + symbol + mm + symbol + dd;

                    return today;
                },
                calcElseCost: function() {
                    this.input['cost_else'] = BigNumber(voyInputObj.output['sail_time']).multipliedBy(elseCost).toFixed(0);
                    voyInputObj.calcContractPreview();
                },
                calcContractPreview: function() {
                    if(parseInt(this.input['speed']) != 0) {
                        let tmp = BigNumber(this.input['distance']).div(this.input['speed']);
                        this.output['sail_term'] = parseFloat(tmp.div(24).toFixed(DECIMAL_SIZE));
                    } else {
                        this.output['sail_term'] = 0;
                    }
                    
                    let moorTmp = BigNumber(this.input['up_ship_day']).plus(this.input['down_ship_day']);
                    let fo_sailTmp1 = moorTmp;
                    let fo_sailTmp2 = 0;
                    let fo_sailTmp3 = 0;
                    let do_sailTmp1 = moorTmp;
                    let do_sailTmp2 = 0;
                    let do_sailTmp3 = 0;

                    moorTmp = BigNumber(moorTmp).plus(this.input['wait_day']);
                    this.output['moor'] = parseFloat(BigNumber(moorTmp).toFixed(DECIMAL_SIZE));
                    this.output['sail_time'] = parseFloat(BigNumber(this.output['moor']).plus(this.output['sail_term']).toFixed(DECIMAL_SIZE));

                    if(voy_id <= 0) {
                        // this.input['cost_else'] = BigNumber(this.output['sail_time']).multipliedBy(elseCost).toFixed(0);
                    }

                    // FO_MT
                    fo_sailTmp1 = fo_sailTmp1.multipliedBy(this.input['fo_up_shipping']);
                    fo_sailTmp2 = BigNumber(this.input['fo_sailing']).multipliedBy(this.output['sail_term']);
                    fo_sailTmp3 = BigNumber(this.input['fo_waiting']).multipliedBy(this.input['wait_day']);
                    this.output['fo_mt'] = parseFloat(BigNumber(fo_sailTmp1).plus(fo_sailTmp2).plus(fo_sailTmp3).toFixed(DECIMAL_SIZE));

                    console.log(do_sailTmp1.toFixed(2), this.input['do_up_shipping'])
                    // DO_MT
                    do_sailTmp1 = do_sailTmp1.multipliedBy(this.input['do_up_shipping']);
                    do_sailTmp2 = BigNumber(this.input['do_sailing']).multipliedBy(this.output['sail_term']);
                    do_sailTmp3 = BigNumber(this.input['do_waiting']).multipliedBy(this.input['wait_day']);
                    
                    console.log(this.input['do_sailing'], this.output['sail_term']);
                    console.log(this.input['do_waiting'], this.input['wait_day']);
                    this.output['do_mt'] = parseFloat(BigNumber(do_sailTmp1).plus(do_sailTmp2).plus(do_sailTmp3).toFixed(DECIMAL_SIZE));

                    // Oil Price
                    let fo_oil_price = BigNumber(this.output['fo_mt']).multipliedBy(this.input['fo_price']);
                    let do_oil_price = BigNumber(this.output['do_mt']).multipliedBy(this.input['do_price']);
                    this.output['oil_money'] = BigNumber(fo_oil_price).plus(do_oil_price).toFixed(DECIMAL_SIZE);

                    // Credit
                    if(this.batchStatus) {
                        this.input['freight_price'] = 0;
                    }
                    let creditTmp = BigNumber(this.input['cargo_amount']).multipliedBy(this.input['freight_price']).plus(this.input['batch_price']);
                    let percent = BigNumber(1).minus(BigNumber(this.input['fee']).div(100));
                    creditTmp = BigNumber(creditTmp).multipliedBy(percent);
                    this.output['credit'] = creditTmp.toFixed(DECIMAL_SIZE);

                    // Debit
                    let debitTmp1 = BigNumber(this.input['cost_per_day']).multipliedBy(this.output['sail_time']);
                    let debitTmp2 = BigNumber(this.input['up_port_price']).plus(this.input['down_port_price']).plus(this.output['oil_money']).plus(this.input['cost_else']);
                    this.output['debit'] = parseFloat(BigNumber(debitTmp1).plus(debitTmp2));

                    // Net Profit
                    let netProfit = BigNumber(this.output['credit']).minus(this.output['debit']);
                    this.output['net_profit'] = netProfit.toFixed(DECIMAL_SIZE);
                    
                    // Profit per day
                    if(this.output['sail_time'] != 0)
                        this.output['net_profit_day'] = BigNumber(netProfit).div(this.output['sail_time']).toFixed(0);
                    else 
                        this.output['net_profit_day'] = 0;

                    this.$forceUpdate();
                },
                profitClass: function(param) {
                    let value = parseFloat(param);
                    return value <= 0 ? 'text-danger' : '';
                }
            },
        });

        voyInputObj.output['max_profit'] = parseFloat('{!! $maxFreight !!}');
        voyInputObj.output['max_voy'] = parseFloat('{!! $maxVoyNo !!}');
        voyInputObj.output['min_profit'] =   parseFloat('{!! $minFreight !!}');
        voyInputObj.output['min_voy'] = parseFloat('{!! $minVoyNo !!}');

        voyContractObj = new Vue({
            el: '#voy_contract_table',
            data: {
                id:                 '',
                is_update:          false,
                shipId:             ship_id,
                voy_no:             '',
                validate_voy_no:    true,
                currency:           'CNY',
                rate:               1,
                cp_date:            '',
                pre_cp_date:            '',
                cp_type:            'VOY',
                cargo:              'SODIUM',
                qty_amount:         0,
                qty_type:           'MOLOO',
                net_profit_day:     0,
                up_port:        '',
                down_port:      '',
                lay_date:       '',
                can_date:       '',
                load_rate:      '',
                disch_rate:     '',
                freight_rate:   '',
                lumpsum:        '',
                deten_fee:      '',
                dispatch_fee:   '',
                com_fee:        '0.00',
                charterer:      '',
                tel_number:     '',
                remark:         '',

                cargoList:      [],
                cargoNames:     '',
                cargoIDList:    [],

                portList:       [],

                upPortIDList:   [],
                upPortTmpIDList:   [],
                upPortNames:    '',
                downPortIDList: [],
                downPortTmpIDList: [],
                downPortNames:  '',
                fileName: '添加附件',
            },

            computed: {
                getValidClass: function() {
                    return this.validate_voy_no == true ? 'd-none' : '';
                },
            },
            methods: {
                certTypeChange: function(event) {
                    let hasClass = $(event.target).hasClass('open');
                    if($(event.target).hasClass('open')) {
                        $(event.target).removeClass('open');
                        $(event.target).siblings(".dynamic-options").removeClass('open');
                    } else {
                        $(event.target).addClass('open');
                        $(event.target).siblings(".dynamic-options").addClass('open');
                    }
                },
                resultDiv: function() {
                    if(!voyInputObj.is_finish)
                        __alertAudio();
                },
                closeDialog: function(index) {
                    $(".dynamic-select__trigger").removeClass('open');
                    $(".dynamic-options").removeClass('open');
                },
                onFileChange(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    let fileName = files[0].name;
                    this.fileName = fileName;
                    $('#file_remove').val(0);
                },
                removeFile() {
                    this.fileName = '添加附件';
                    $('#contract_attach').val('');
                    $('#file_remove').val(1);
                },
                confirmItem: function(activeId) {
                    let nameTmp = '';
                    if(activeId == 'cargo') {
                        voyContractObj.cargoNames = '';
                        voyContractObj.cargoIDList = [];
                        var values = $("input[name='cargo_id[]']").map(function() {
                            if($(this).prop('checked')) {
                                nameTmp += voyContractObj.cargoList[$(this).val()]['name'] + ', ';
                                voyContractObj.cargoIDList.push(voyContractObj.cargoList[$(this).val()]['id']);
                            }
                        }).get();

                        voyContractObj.cargoNames = nameTmp.slice(0,-2);
                    } else if(activeId == 'up_port') {
                        nameTmp = '';
                        voyContractObj.upPortNames = '';
                        voyContractObj.upPortIDList = voyContractObj.upPortTmpIDList;
                        voyContractObj.upPortIDList.forEach(function(value, key) {
                            nameTmp += value;
                            if(voyContractObj.upPortIDList.length != key + 1)
                                nameTmp += ',';
                        });

                        voyContractObj.upPortNames = voyListObj.getPortName(nameTmp);
                    } else if(activeId == 'down_port') {
                        nameTmp = '';
                        voyContractObj.downPortNames = '';
                        voyContractObj.downPortIDList = voyContractObj.downPortTmpIDList;
                        voyContractObj.downPortIDList.forEach(function(value, key) {
                            nameTmp += value;
                            if(voyContractObj.downPortIDList.length != key + 1)
                                nameTmp += ',';
                        });

                        voyContractObj.downPortNames = voyListObj.getPortName(nameTmp);
                    } else return false;
                    
                    this.closeDialog();
                },
                selectItem: function(e, type) {
                    let id = parseInt(e.target.value);
                    let checked = $(e.target).prop('checked');

                    if(type == 'up_port') {
                        if(typeof(voyContractObj.upPortTmpIDList) != 'object') {
                            voyContractObj.upPortTmpIDList = [];
                        }

                        if(checked == false) {
                            voyContractObj.upPortTmpIDList = this.removeValue(voyContractObj.upPortTmpIDList, id);
                        } else {
                            voyContractObj.upPortTmpIDList.push(id);
                        }
                    } else {
                        if(typeof(voyContractObj.downPortTmpIDList) != 'object') {
                            voyContractObj.downPortTmpIDList = [];
                        }

                        if(checked == false) {
                            voyContractObj.downPortTmpIDList = this.removeValue(voyContractObj.downPortTmpIDList, id);
                        } else {
                            voyContractObj.downPortTmpIDList.push(id);
                        }
                    }
                },

                removeValue: function(array, value) {
                    const index = array.indexOf(value);
                    if (index > -1) {
                        array.splice(index, 1);
                    }

                    return array;
                },
                openDialog: function(type) {
                    if(type == 'cargo')
                        $('.only-cargo-modal-show').click();
                    else
                        $('.only-port-modal-show').click();
                },
                dateModify(e, type) {
                    $(e.target).on("change", function() {
                        voyContractObj['' + type +''] = $(this).val();
                    });
                },
                validateVoyNo(e) {
                    $('#submit').attr('disabled', 'disabled');
                    if($('#voyContractForm [name=voy_no]').val() == '')  return;
                    if(!voyInputObj.is_finish) return ;
                    if($('[name=voy_no]').val() == '')  return;
                    let value = $(e.target).val();
                    $.ajax({
                        url: BASE_URL + 'ajax/business/voyNo/validate',
                        type: 'post',
                        data: {
                            shipId: this.shipId,
                            voyNo: value,
                            id: this.id,
                        },
                        success: function(data, status, xhr) {
                            voyContractObj.validate_voy_no = data;
                            if(data)
                                $('#submit').removeAttr('disabled');
                        }
                    });
                },
                checkVoyNo(id) {
                    if($('#voyContractForm [name=voy_no]').val() == '')  return;
                    $.ajax({
                        url: BASE_URL + 'ajax/business/voyNo/validate',
                        type: 'post',
                        data: {
                            shipId: this.shipId,
                            voyNo: id,
                            id: this.id,
                        },
                        success: function(data, status, xhr) {
                            voyContractObj.validate_voy_no = data;
                            if(data)
                                $('#submit').removeAttr('disabled');
                            
                        }
                    });
                },
                disableSubmit() {
                    $('#submit').attr('disabled', true);
                },
                getOptionCls: function(status) {
                    return status == 1 ? 'disable' : '';
                }
            }
        })
    }

    $(document).mouseup(function(e) {
        var container = $(".dynamic-options-scroll");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".dynamic-options").removeClass('open');
            $(".dynamic-options").siblings('.dynamic-select__trigger').removeClass('open')
        }
    });

</script>