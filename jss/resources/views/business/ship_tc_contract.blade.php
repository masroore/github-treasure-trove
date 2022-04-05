<form method="post" action="tcContractRegister" enctype="multipart/form-data" id="tcContractForm">
<div class="d-flex" id="tc_input">
    <div class="tab-left contract-input-div"  id="tc_input_div" v-cloak>
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
                        <my-currency-input v-model="input['speed']" name="speed" v-bind:prefix="''" v-bind:type="'tc'" v-bind:fixednumber="1" maxlength="4" minlength="4"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>距离(NM)</label>
                        <my-currency-input v-model="input['distance']" name="distance" v-bind:prefix="''" v-bind:type="'tc'" v-bind:fixednumber="0" maxlength="4" minlength="4" step="1"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>装货天数</label>
                        <my-currency-input v-model="input['up_ship_day']" name="up_ship_day" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                    </div>  
                    <div class="vertical">
                        <label>卸货天数</label>
                        <my-currency-input v-model="input['down_ship_day']" name="down_ship_day" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>等待天数</label>
                        <my-currency-input v-model="input['wait_day']" name="wait_day" v-bind:prefix="''"  v-bind:type="'tc'"></my-currency-input>
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
                        <my-currency-input class="output-text" v-model="input['fo_sailing']" name="fo_sailing" v-bind:prefix="''" v-bind:fixednumber="1" v-bind:type="'tc'"></my-currency-input>
                        <my-currency-input class="output-text" v-model="input['do_sailing']" name="do_sailing" v-bind:prefix="''" v-bind:fixednumber="1" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>装/卸</label>
                        <my-currency-input class="output-text" v-model="input['fo_up_shipping']" name="fo_up_shipping" v-bind:prefix="''" v-bind:fixednumber="1" v-bind:type="'tc'"></my-currency-input>
                        <my-currency-input class="output-text" v-model="input['do_up_shipping']" name="do_up_shipping" v-bind:prefix="''" v-bind:fixednumber="1" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>等待</label>
                        <my-currency-input class="output-text" v-model="input['fo_waiting']" name="fo_waiting" v-bind:prefix="''" v-bind:fixednumber="1" v-bind:type="'tc'"></my-currency-input>
                        <my-currency-input class="output-text" v-model="input['do_waiting']" name="do_waiting" v-bind:prefix="''" v-bind:fixednumber="1" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>价格</label>
                        <my-currency-input v-model="input['fo_price']" name="fo_price" v-bind:fixednumber="0" v-bind:type="'tc'"></my-currency-input>
                        <my-currency-input v-model="input['do_price']" name="do_price" v-bind:fixednumber="0" v-bind:type="'tc'"></my-currency-input>
                    </div>
                </div>
                <hr class="gray-dotted-hr">
                <div class="d-flex  mt-20 attribute-div">
                    <div class="vertical">
                        <label>期租</label>
                        <label>&nbsp;</label>
                    </div>
                    <div class="vertical">
                        <label>日租金</label>
                        <my-currency-input v-model="input['daily_rent']" name="daily_rent" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>ILOHC</label>
                        <my-currency-input v-model="input['ilohc']" name="in_ilohc" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>C/V/E($/d)</label>
                        <my-currency-input v-model="input['c_v_e']" name="in_c_v_e" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label>佣金(%)</label>
                        <my-currency-input v-model="input['fee']" name="fee" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                    </div>
                </div>
                <div class="d-flex  mt-20 attribute-div">
                    <div class="vertical">
                        <label>&nbsp;</label>
                        <label>支出</label>
                    </div>
                    <div class="vertical">
                        <label class="debit-label">装港费</label>
                        <input v-model="input['up_port_price']" name="up_port_price" readonly type="text">
                    </div>
                    <div class="vertical">
                        <label class="debit-label">卸港费</label>
                        <input v-model="input['down_port_price']" name="down_port_price" readonly type="text">
                    </div>
                    <div class="vertical">
                        <label class="debit-label">日成本</label>
                        <my-currency-input v-model="input['cost_per_day']" name="cost_per_day" v-bind:fixednumber="0" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="vertical">
                        <label @click="calcElseCost" class="else-cost">其他（运营）</label>
                        <my-currency-input v-model="input['cost_else']" name="cost_else" v-bind:fixednumber="0" v-bind:type="'tc'"></my-currency-input>
                    </div>
                </div>
            </div>

            <div class="voy-input-right voy-child">
                <h5 class="ml-5 brown font-bold">输出</h5>
                <div class="d-block mt-20">
                    <div class="d-flex horizontal">
                        <label>航次用时</label>
                        <my-currency-input class="text-right" readonly v-model="output['sail_time']" name="sail_time" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                        <span>天</span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>航行</label>
                        <my-currency-input class="text-right" readonly v-model="output['sail_term']" name="sail_term" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                        <span>天</span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>停泊</label>
                        <my-currency-input class="text-right" readonly v-model="output['moor']" name="moor" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                        <span>天</span>
                    </div>
                </div>
                <div class="d-block mt-20">
                    <div class="d-flex horizontal">
                        <label>油款</label>
                        <input class="text-left bigger-input" style="border-top: 1px solid #4c4c4c;" readonly v-model="output['oil_money']" name="oil_money">
                        <span></span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>FO</label>
                        <my-currency-input class="text-right" readonly v-model="output['fo_mt']" name="fo_mt" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                        <span>MT</span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>DO</label>
                        <my-currency-input class="text-right" readonly v-model="output['do_mt']" name="do_mt" v-bind:prefix="''" v-bind:type="'tc'"></my-currency-input>
                        <span>MT</span>
                    </div>
                </div>

                <hr class="gray-dotted-hr">

                <div class="d-block mt-20">
                    <div class="d-flex horizontal">
                        <label>收入</label>
                        <my-currency-input class="text-left bigger-input" readonly v-model="output['credit']" name="credit" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="d-flex horizontal">
                        <label>支出</label>
                        <my-currency-input class="text-left bigger-input" readonly v-model="output['debit']" name="debit" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="d-flex horizontal">
                        <label>净利润</label>
                        <my-currency-input class="text-left bigger-input" readonly v-model="output['net_profit']" name="net_profit" v-bind:type="'tc'"></my-currency-input>
                    </div>
                    <div class="d-flex horizontal">
                        <label>日净利润</label>
                        <my-currency-input class="text-left bigger-input" readonly v-model="output['net_profit_day']" name="net_profit_day" v-bind:fixedNumber="0" v-bind:type="'tc'"></my-currency-input>
                        <span></span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>参考(最高)</label>
                        <my-currency-input class="text-left double-input-left" style="color: #126EB9 !important; font-weight: bold" readonly v-model="output['max_profit']" name="max_profit" v-bind:fixednumber="0" v-bind:type="'tc'"></my-currency-input>
                        <input type="text" class="text-left double-input-right" readonly name="max_voy" v-model="output['max_voy']">
                        <span>航次</span>
                    </div>
                    <div class="d-flex horizontal">
                        <label>(最低)</label>
                        <my-currency-input class="text-left double-input-left" style="color: red!important; font-weight: bold" readonly v-model="output['min_profit']" name="min_profit" v-bind:fixednumber="0" v-bind:type="'tc'"></my-currency-input>
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
    
        <div class="tab-right contract-input-div" id="tc_contract_table" v-cloak @click="resultDiv">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" value="{{ $shipId }}" name="shipId" v-model="shipId">
            <input type="hidden" value="{{ $voy_id }}" name="voy_id" id="voy_id">
            <label>航次: </label>
            <input type="text" name="voy_no" v-model="voy_no" minlength="4" maxlength="4" style="width:80px;" @focus="disableSubmit" @focusout="validateVoyNo" required>
            <span class="text-danger" v-bind:class="getValidClass">Voy No already exits.</span>
            <table class="contract-table mt-2">
                <tr>
                    <td style="width: 80px;">合同日期</td>
                    <td class="font-style-italic">CP_DATE</td>
                    <td><input type="text" class="date-picker form-control" name="cp_date" v-model="cp_date" @click="dateModify($event, 'cp_date')"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>合同种类</td>
                    <td class="font-style-italic">CP TYPE</td>
                    <td><input type="text" class="form-control font-bold" value="TC" name="cp_type" readonly></td>
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
                                            <input type="checkbox" name="cargo_id[]" v-bind:value="index" v-bind:id="index + 'cargo_tc'">
                                            <label :for="index + 'cargo_tc'" class="width-100">@{{ cargoItem.name }}</label>
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
                    <td>期租</td>
                    <td class="font-style-italic">HireDuration</td>
                    <td><input type="text" class="form-control" name="hire_duration" v-model="hire_duration"></td>
                    <td>
                        天
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
                                            <input type="checkbox" name="up_port_id[]" v-bind:value="portItem.id" v-bind:id="index + '_upPort_tc'" @click="selectItem($event, 'up_port')">
                                            <label :for="index + '_upPort_tc'" class="width-100">@{{ portItem.Port_En }}</label>
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
                                            <input type="checkbox" name="down_port_id[]" v-bind:value="portItem.id" v-bind:id="index + '_downPort_tc'" @click="selectItem($event, 'down_port')">
                                            <label :for="index + '_downPort_tc'" class="width-100">@{{ portItem.Port_En }}</label>
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
                    <td>交船地点</td>
                    <td class="font-style-italic">DELY</td>
                    <td colspan="2" style="border-right: 1px solid #4c4c4c"><input type="text" class="form-control" name="dely" v-model="dely"></td>
                </tr>
                <tr>
                    <td>还船地点</td>
                    <td class="font-style-italic">REDELY</td>
                    <td colspan="2" style="border-right: 1px solid #4c4c4c"><input type="text" class="form-control" name="redely" v-model="redely"></td>
                </tr>
                <tr>
                    <td>日租金</td>
                    <td class="font-style-italic">HIRE</td>
                    <td><input type="text" class="form-control" name="hire" readonly v-model="hire"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>首付天数</td>
                    <td class="font-style-italic">1st HIRE days</td>
                    <td><input type="text" class="form-control" name="first_hire" v-model="first_hire"></td>
                    <td>天</td>
                </tr>
                <tr>
                    <td>ILOHC</td>
                    <td class="font-style-italic">ILOHC</td>
                    <td><input type="text" class="form-control" name="ilohc" v-model="ilohc"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>C/V/E</td>
                    <td class="font-style-italic">C/V/E</td>
                    <td><input type="text" class="form-control" name="c_v_e" v-model="c_v_e"></td>
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
                <label for="contract_tc_attach" class="ml-1 blue contract-attach d-flex">
                    <span class="contract-file-name">@{{ fileName }}</span>
                    <button type="button" class="btn btn-danger p-0" style="min-width: 30px;" @click="removeFile"><i class="icon-remove mr-0"></i></button>
                </label>
                <input type="file" id="contract_tc_attach" name="attachment" class="d-none" @change="onFileChange">
            </div>
            <input type="hidden" name="tc_file_remove" id="tc_file_remove" value="0">
            <input type="hidden" name="tc_currency" v-model="currency">
            <input type="hidden" name="tc_rate" v-model="rate">
            </form>
        </div>
</div>
</form>
<script>

    var tcInputObj = null;
    var tcContractObj = null;

    var DEFAULT_CURRENCY = '{!! USD_LABEL !!}';
    var DECIMAL_SIZE = 2;
    function disabledTc(type = true) {
        $('#tc_contract_table [name=voy_no]').attr('disabled', type);
        if(type)
            $('#submit').attr('disabled', true);
    }
    function initializeTc() {
        disabledTc();
        tcInputObj = new Vue({
            el: "#tc_input_div",
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

                    daily_rent:         0,
                    ilohc:              0,
                    fee:                0,
                    c_v_e:              0,
                    up_port_price:      '',
                    down_port_price:    '',
                    cost_per_day:       0,
                    cost_else:          0
                },
                output: {
                    sail_time:          0,
                    sail_term:          0,
                    moor:               0,
                    oil_money:          '',
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
            },
            methods: {
                onEditFinish: function() {
                    this.is_finish = true;
                    disabledTc(false);
                    tcContractObj.checkVoyNo($('#tcContractForm [name=voy_no]').val());
                    if(tcContractObj.pre_cp_date == '')
                        tcContractObj.cp_date = this.getToday('-');
                    else
                        tcContractObj.cp_date = tcContractObj.pre_cp_date;

                    tcContractObj.hire = __parseFloat(this.input['daily_rent']) == 0 ? '' : '$ ' + __parseFloat(this.input['daily_rent']);
                    tcContractObj.ilohc = __parseFloat(this.input['ilohc']) == 0 ? '' : '$ ' + __parseFloat(this.input['ilohc']);
                    tcContractObj.c_v_e = __parseFloat(this.input['c_v_e']) == 0 ? '' : '$ ' + __parseFloat(this.input['c_v_e']);
                    tcContractObj.com_fee = this.input['fee'];
                    tcContractObj.net_profit_day = this.output['net_profit_day']
                    tcContractObj.currency = this.input['currency'];
                    tcContractObj.rate = this.input['rate'];

                    $('#tc_input_div input').attr('readonly', '');
                    $('[name=currency]').attr('readonly', '');

                    tcContractObjTmp = JSON.parse(JSON.stringify(tcContractObj._data));
                },
                onEditContinue: function() {
                    this.is_finish = false;
                    disabledTc(true)
                    $('#tc_input_div input').removeAttr('readonly');
                    $('[name=currency]').removeAttr('readonly');
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
                    this.input['cost_else'] = BigNumber(this.output['sail_time']).multipliedBy(elseCost).toFixed(0);
                    this.calcContractPreview();
                },
                calcContractPreview: function() {
                    if(parseInt(this.input['speed']) != 0) {
                        let tmp = BigNumber(this.input['distance']).div(this.input['speed']);
                        this.output['sail_term'] = __parseFloat(BigNumber(tmp).div(24).toFixed(DECIMAL_SIZE));
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

                    moorTmp = BigNumber(moorTmp).plus(this.input['wait_day']).toFixed(DECIMAL_SIZE);
                    this.output['moor'] = __parseFloat(BigNumber(moorTmp).toFixed(DECIMAL_SIZE));
                    this.output['sail_time'] = __parseFloat(BigNumber(this.output['moor']).plus(this.output['sail_term']).toFixed(DECIMAL_SIZE));

                    // if(voy_id <= 0) {
                    //     this.input['cost_else'] = BigNumber(this.output['sail_time']).multipliedBy(elseCost).toFixed(0);
                    // }

                    // FO_MT
                    fo_sailTmp1 = fo_sailTmp1.multipliedBy(this.input['fo_up_shipping']);
                    fo_sailTmp2 = BigNumber(this.input['fo_sailing']).multipliedBy(this.output['sail_term']);
                    fo_sailTmp3 = BigNumber(this.input['fo_waiting']).multipliedBy(this.input['wait_day']);
                    this.output['fo_mt'] = __parseFloat(BigNumber(fo_sailTmp1).plus(fo_sailTmp2).plus(fo_sailTmp3).toFixed(DECIMAL_SIZE));

                    // DO_MT
                    do_sailTmp1 = do_sailTmp1.multipliedBy(this.input['do_up_shipping']);
                    do_sailTmp2 = BigNumber(this.input['do_sailing']).multipliedBy(this.output['sail_term']);
                    do_sailTmp3 = BigNumber(this.input['do_waiting']).multipliedBy(this.input['wait_day']);
                    this.output['do_mt'] = __parseFloat(BigNumber(do_sailTmp1).plus(do_sailTmp2).plus(do_sailTmp3).toFixed(DECIMAL_SIZE));

                    // Oil Price
                    let fo_oil_price = BigNumber(this.output['fo_mt']).multipliedBy(this.input['fo_price']);
                    let do_oil_price = BigNumber(this.output['do_mt']).multipliedBy(this.input['do_price']);
                    // this.output['oil_money'] = BigNumber(fo_oil_price).plus(do_oil_price);

                    // Credit
                    if(this.batchStatus) {
                        this.input['ilohc'] = 0;
                    }
                    let creditTmp = BigNumber(this.input['daily_rent']).multipliedBy(this.output['sail_time']);
                    let percent = BigNumber(1).minus(BigNumber(this.input['fee']).div(100).toFixed(4));
                    let creditTmp2 = BigNumber(this.input['c_v_e']).multipliedBy(this.output['sail_time']).toFixed(DECIMAL_SIZE);
                    creditTmp = BigNumber(creditTmp).multipliedBy(percent);
                    creditTmp = BigNumber(creditTmp).plus(this.input['ilohc']).plus(creditTmp2).toFixed(DECIMAL_SIZE);
                    this.output['credit'] = creditTmp;

                    // Debit
                    let debitTmp1 = BigNumber(this.input['cost_per_day']).multipliedBy(this.output['sail_time']);
                    let debitTmp2 = BigNumber(debitTmp1).plus(this.input['cost_else']).toFixed(DECIMAL_SIZE);
                    this.output['debit'] = __parseFloat(debitTmp2);

                    // Net Profit
                    let netProfit = BigNumber(this.output['credit']).minus(this.output['debit']).toFixed(DECIMAL_SIZE);
                    this.output['net_profit'] = netProfit;
                    
                    // Profit per day
                    if(this.output['sail_time'] != 0)
                        this.output['net_profit_day'] = BigNumber(netProfit).div(this.output['sail_time']).toFixed(0);
                    else 
                        this.output['net_profit_day'] = 0;

                }
            }
        });

        tcInputObj.output['max_profit'] = __parseFloat('{!! $maxFreight !!}');
        tcInputObj.output['max_voy'] = __parseFloat('{!! $maxVoyNo !!}');
        tcInputObj.output['min_profit'] =   __parseFloat('{!! $minFreight !!}');
        tcInputObj.output['min_voy'] = __parseFloat('{!! $minVoyNo !!}');

        tcContractObj = new Vue({
            el: '#tc_contract_table',
            data: {
                id:                 '',
                is_update:          false,
                shipId:             ship_id,
                voy_no:             '',
                validate_voy_no:    true,
                currency:           'CNY',
                rate:               1,
                
                cp_date:            '',
                pre_cp_date:        '',
                cp_type:            'TC',
                cargo:              'SODIUM',
                hire_duration:         0,
                net_profit_day:         0,
                qty_type:           'MOLOO',    
                up_port:        '',
                down_port:      '',
                lay_date:       '',
                can_date:       '',
                dely:      '',
                redely:     '',
                hire:   '',
                first_hire:     '',
                ilohc:          '',
                c_v_e:          '',
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
                closeDialog: function(index) {
                    $(".dynamic-select__trigger").removeClass('open');
                    $(".dynamic-options").removeClass('open');
                },
                onFileChange(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    let fileName = files[0].name;
                    this.fileName = fileName;
                    $('#tc_file_remove').val(0);
                },
                resultDiv: function() {
                    if(!tcInputObj.is_finish)
                        __alertAudio();
                },
                removeFile() {
                    this.fileName = '添加附件';
                    $('#contract_tc_attach').val('');
                    $('#tc_file_remove').val(1);
                },
                confirmItem: function(activeId) {
                    let nameTmp = '';
                    if(activeId == 'cargo') {
                        tcContractObj.cargoNames = '';
                        tcContractObj.cargoIDList = [];
                        var values = $("input[name='cargo_id[]']").map(function() {
                            if($(this).prop('checked')) {
                                nameTmp += tcContractObj.cargoList[$(this).val()]['name'] + ', ';
                                tcContractObj.cargoIDList.push(tcContractObj.cargoList[$(this).val()]['id']);
                            }
                        }).get();

                        tcContractObj.cargoNames = nameTmp.slice(0,-2);
                    } else if(activeId == 'up_port') {
                        nameTmp = '';
                        tcContractObj.upPortNames = '';
                        tcContractObj.upPortIDList = tcContractObj.upPortTmpIDList;
                        tcContractObj.upPortIDList.forEach(function(value, key) {
                            nameTmp += value;
                            if(tcContractObj.upPortIDList.length != key + 1)
                                nameTmp += ',';
                        });

                        tcContractObj.upPortNames = voyListObj.getPortName(nameTmp);
                    } else if(activeId == 'down_port') {
                        nameTmp = '';
                        tcContractObj.downPortNames = '';
                        tcContractObj.downPortIDList = tcContractObj.downPortTmpIDList;
                        tcContractObj.downPortIDList.forEach(function(value, key) {
                            nameTmp += value;
                            if(tcContractObj.downPortIDList.length != key + 1)
                                nameTmp += ',';
                        });

                        tcContractObj.downPortNames = voyListObj.getPortName(nameTmp);
                    } else return false;

                    this.closeDialog();
                },

                selectItem: function(e, type) {
                    let id = parseInt(e.target.value);
                    let checked = $(e.target).prop('checked');

                    if(type == 'up_port') {
                        if(typeof(tcContractObj.upPortTmpIDList) != 'object') {
                            tcContractObj.upPortTmpIDList = [];
                        }

                        if(checked == false) {
                            tcContractObj.upPortTmpIDList = this.removeValue(tcContractObj.upPortTmpIDList, id);
                        } else {
                            tcContractObj.upPortTmpIDList.push(id);
                        }
                    } else {
                        if(typeof(tcContractObj.downPortTmpIDList) != 'object') {
                            tcContractObj.downPortTmpIDList = [];
                        }

                        if(checked == false) {
                            tcContractObj.downPortTmpIDList = this.removeValue(tcContractObj.downPortTmpIDList, id);
                        } else {
                            tcContractObj.downPortTmpIDList.push(id);
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
                        tcContractObj['' + type +''] = $(this).val();
                    });
                },
                validateVoyNo(e) {
                    $('#submit').attr('disabled', 'disabled');
                    if($('#tcContractForm [name=voy_no]').val() == '')  return;
                    if(!tcInputObj.is_finish) return ;
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
                            tcContractObj.validate_voy_no = data;
                            if(data)
                                $('#submit').removeAttr('disabled');

                        }
                    });
                },
                checkVoyNo(id) {
                    if($('#tcContractForm [name=voy_no]').val() == '')  return;
                    $.ajax({
                        url: BASE_URL + 'ajax/business/voyNo/validate',
                        type: 'post',
                        data: {
                            shipId: this.shipId,
                            voyNo: id,
                            id: this.id,
                        },
                        success: function(data, status, xhr) {
                            tcContractObj.validate_voy_no = data;
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