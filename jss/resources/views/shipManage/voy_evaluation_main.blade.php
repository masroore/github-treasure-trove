<div id="main-list" v-cloak>
    <div class="row">
        <div class="col-lg-7">
            <label class="custom-label d-inline-block font-bold for-pc" style="padding: 6px;">船名: </label>
            <select class="custom-select d-inline-block" id="select-ship" style="padding: 4px; max-width: 100px;" @change="onChangeShip" v-model="shipId">
                @foreach($shipList as $ship)
                    <option value="{{ $ship['IMO_No'] }}"
                        {{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}
                    </option>
                @endforeach
            </select>
            <label class="font-bold">航次:</label>
            <select class="text-center" style="width: 60px;" id="voy_list" @change="onChangeVoy" v-model="voyId">
                @foreach($cpList as $key => $item)
                    <option value="{{ $item->Voy_No }}">{{ $item->Voy_No }}</option>
                @endforeach
            </select>

            <strong style="font-size: 20px; padding-top: 6px; margin-left: 30px;" class="f-right">
                <span id="search_info">{{ $shipName }}</span>&nbsp;&nbsp;&nbsp;<span class="font-bold">@{{ voyId }}次评估</span>
            </strong>
        </div>
        <div class="col-lg-5">
            <div class="btn-group f-right">
                <a class="btn btn-sm btn-purple" @click="openNewPage('soa')"><i class="icon-asterisk"></i> SOA</a>
                <a class="btn btn-sm btn-dynamic" @click="openNewPage('dynamic')"><i class="icon-bar-chart"></i> 船舶动态</a>
                <button class="btn btn-warning btn-sm excel-btn" @click="fnExcelMain()"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
            </div>
        </div>
    </div>
    
    <div class="row" style="margin-top: 4px;">
        <div class="col-lg-12 head-fix-div common-list">
            <table class="evaluation-table mt-2 evalution" id="table-main">
                <tr>
                    <td style="width: 20%;" class="not-striped-td">航次</td>
                    <td colspan="2" style="width: 30%;">@{{ cpInfo.Voy_No }}</td>
                    <td style="width: 20%;" class="not-striped-td">装率（交船地点）</td>
                    <td style="width: 30%;">@{{ cpInfo.L_Rate }}</td>
                </tr>
                <tr>
                    <td class="not-striped-td">合同日期</td>
                    <td colspan="2">@{{ cpInfo.CP_Date }}</td>
                    <td class="not-striped-td">卸率（还船地点）</td>
                    <td>@{{ cpInfo.D_Rate }}</td>
                </tr>
                <tr>
                    <td class="not-striped-td">租船种类</td>
                    <td colspan="2">@{{ cpInfo.CP_kind }}</td>
                    <td class="not-striped-td">运费率（日租金）</td>
                    <td>@{{ number_format(cpInfo.Freight) == '' ? '' : '$ ' + number_format(cpInfo.Freight) }}</td>
                </tr>
                <tr>
                    <td class="not-striped-td">货名</td>
                    <td colspan="2">@{{ cpInfo.Cargo_Name }}</td>
                    <td class="not-striped-td">包船（首付天数）</td>
                    <td>@{{ downPayment(cpInfo) }}</td>
                </tr>
                <tr>
                    <td class="not-striped-td">货量（租期）</td>
                    <td colspan="2">@{{ number_format(cpInfo.Cgo_Qtty) }}</td>
                    <td class="not-striped-td">滞期费（ILOHC）</td>
                    <td>@{{ customValue1(cpInfo) }}</td>
                </tr>
                <tr>
                    <td class="not-striped-td">装港</td>
                    <td colspan="2">@{{ cpInfo.lport }}</td>
                    <td class="not-striped-td">速遣费（C/V/E）</td>
                    <td>@{{ customValue2(cpInfo) }}</td>
                </tr>
                <tr>
                    <td class="not-striped-td">卸港</td>
                    <td colspan="2">@{{ cpInfo.dport }}</td>
                    <td class="not-striped-td">佣金(%)</td>
                    <td>@{{ number_format(cpInfo.com_fee) }}</td>
                </tr>
                <tr>
                    <td class="not-striped-td">受载期</td>
                    <td>@{{ cpInfo.LayCan_Date1 }}</td>
                    <td style="background: white!important;">@{{ cpInfo.LayCan_Date2 }}</td>
                    <td style="background: #d9f8fb!important">租家</td>
                    <td style="background: white!important;">@{{ cpInfo.charterer }}</td>
                </tr>
            </table>
            <table class="mt-2 main-info-table evalution" id="table-main-2">
                <thead>
                    <tr class="dynamic-footer">
                        <td class="center not-striped-td" style="width: 5%">No.</td>
                        <td class="center not-striped-td" colspan="2" style="width: 20%">项目</td>
                        <td class="center not-striped-td" style="width: 10%">预计</td>
                        <td class="center not-striped-td" style="width: 10%">实际</td>
                        <td class="center not-striped-td" style="width: 10%">方差</td>
                        <td class="center not-striped-td" style="width: 45%"></td>
                    </tr>
                </thead>

                <tbody>
                    <tr class="even">
                        <td class="center">1</td>
                        <td colspan="2">期间</td>
                        <td colspan="3" class="center">@{{ realInfo.start_date == 'undefined' ? '' : realInfo.start_date }} ~ @{{ realInfo.end_date == 'undefined' ? '' : realInfo.end_date }}</td>
                        <td rowspan="12">
                            <div id="economic_graph" style="height: 250px;"></div>
                        </td>
                    </tr>
                    <tr class="odd">
                        <td class="center">2</td>
                        <td colspan="2">速度 (Kn)</td>
                        <td class="text-right">@{{ number_format(cpInfo.speed) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.avg_speed) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.avg_speed) - __parseFloat(cpInfo.speed)) }}</td>
                    </tr>

                    <tr class="even">
                        <td class="center">3</td>
                        <td colspan="2">里程 (NM)</td>
                        <td class="text-right">@{{ number_format(cpInfo.distance) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.total_distance) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.total_distance) - __parseFloat(cpInfo.distance)) }}</td>
                    </tr>
                    <tr class="odd">
                        <td class="center" rowspan="5">4</td>
                        <td colspan="2">航次用时</td>
                        <td class="text-right">@{{ number_format(cpInfo.sail_time) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.total_sail_time) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.total_sail_time) - __parseFloat(cpInfo.sail_time)) }}</td>
                    </tr>

                    <tr class="even">
                        <td rowspan="4" class="center">其中</td>
                        <td class="text-left">装货天数</td>
                        <td class="text-right">@{{ number_format(cpInfo.up_ship_day) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.load_time) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.load_time) - __parseFloat(cpInfo.up_ship_day)) }}</td>
                    </tr>

                    <tr class="odd">
                        <td class="text-left">卸货天数</td>
                        <td class="text-right">@{{ number_format(cpInfo.down_ship_day) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.disch_time) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.disch_time) - __parseFloat(cpInfo.down_ship_day)) }}</td>
                    </tr>
                    <tr class="even">
                        <td class="text-left">等待天数</td>
                        <td class="text-right">@{{ number_format(cpInfo.wait_day) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.wait_time) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.wait_time) - __parseFloat(cpInfo.wait_day)) }}</td>
                    </tr>
                    <tr class="odd">
                        <td class="text-left">航行天数</td>
                        <td class="text-right">@{{ number_format(cpInfo.sail_term) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.sail_time) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.sail_time) - __parseFloat(cpInfo.sail_term)) }}</td>
                    </tr>

                    <tr class="odd">
                        <td class="text-center" rowspan="2">5</td>
                        <td rowspan="2">耗油</td>
                        <td>FO (MT)</td>
                        <td class="text-right">@{{ number_format(realInfo.fo_mt) }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.rob_fo)">@{{ number_format(realInfo.rob_fo) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.rob_fo) - __parseFloat(realInfo.fo_mt)) }}</td>
                    </tr>
                    <tr class="even">
                        <td>DO (MT)</td>
                        <td class="text-right">@{{ number_format(realInfo.do_mt) }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.rob_do)">@{{ number_format(realInfo.rob_do) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.rob_do) - __parseFloat(realInfo.do_mt)) }}</td>
                    </tr>

                    <tr class="even">
                        <td class="text-center" rowspan="2">6</td>
                        <td rowspan="2">油价</td>
                        <td>FO ($/MT)</td>
                        <td class="text-right">@{{ number_format(cpInfo.fo_price) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.rob_fo_price) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(cpInfo.fo_price) - __parseFloat(realInfo.rob_fo_price)) }}</td>
                    </tr>
                    <tr class="odd">
                        <td>DO ($/MT)</td>
                        <td class="text-right">@{{ number_format(cpInfo.do_price) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.rob_do_price) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(cpInfo.do_price) - __parseFloat(realInfo.rob_do_price)) }}</td>
                    </tr>

                    <tr class="even">
                        <td class="center">7</td>
                        <td colspan="2">货量（租期）</td>
                        <td class="text-right">@{{ number_format(cpInfo.Cgo_Qtty) }}</td>
                        <td class="text-right text-warning">@{{ number_format(realInfo.cgo_qty) }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(cpInfo.Cgo_Qtty) - __parseFloat(realInfo.cgo_qty)) }}</td>
                        <td  rowspan="13">
                            <div id="debit_graph" style="height: 265px;"></div>
                        </td>
                    </tr>

                    <tr class="odd">
                        <td class="center">8</td>
                        <td colspan="2" class="text-profit font-weight-bold">收入</td>
                        <td class="text-right text-profit">@{{ number_format(cpInfo.credit, 0, '$ ') }}</td>
                        <td class="text-right text-profit">@{{ number_format(realInfo.credit, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.credit) - __parseFloat(cpInfo.credit), 0, '$ ') }}</td>
                    </tr>


                    <tr class="even">
                        <td class="center" rowspan="5">9</td>
                        <td colspan="2" class="font-weight-bold">支出</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.debit)">@{{ number_format(cpInfo.debit, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.debit)">@{{ number_format(realInfo.debit, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.debit) - __parseFloat(cpInfo.debit), 0, '$ ') }}</td>
                    </tr>

                    <tr class="odd">
                        <td rowspan="4" class="center">其中</td>
                        <td class="text-left">装卸港费</td>
                        <td class="text-right">@{{ number_format(__parseFloat(cpInfo.up_port_price) + __parseFloat(cpInfo.down_port_price), 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.sail_credit)">@{{ number_format(__parseFloat(realInfo.sail_credit), 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.sail_credit) - __parseFloat(cpInfo.up_port_price) - __parseFloat(cpInfo.down_port_price), 0, '$ ') }}</td>
                    </tr>

                    <tr class="even">
                        <td class="text-left">耗油成本</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.fuel_consumpt)">@{{ number_format(cpInfo.fuel_consumpt, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.fuel_consumpt)">@{{ number_format(realInfo.fuel_consumpt, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.fuel_consumpt) - __parseFloat(cpInfo.fuel_consumpt), 0, '$ ') }}</td>
                    </tr>
                    <tr class="odd">
                        <td class="text-left">其他(运营)</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.cost_else)">@{{ number_format(cpInfo.cost_else, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.cost_else)">@{{ number_format(realInfo.cost_else, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(realInfo.cost_else - cpInfo.cost_else, 0, '$ ') }}</td>
                    </tr>
                    <tr class="even">
                        <td class="text-left">管理成本</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.manage_cost_day)">@{{ number_format(cpInfo.manage_cost_day, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.manage_cost_day)">@{{ number_format(realInfo.manage_cost_day, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.manage_cost_day) - __parseFloat(cpInfo.manage_cost_day), 0, '$ ') }}</td>
                    </tr>


                    <tr class="odd">
                        <td class="center">10</td>
                        <td colspan="2">毛利润</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.gross_profit)">@{{ number_format(cpInfo.gross_profit, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.gross_profit)">@{{ number_format(realInfo.gross_profit, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.gross_profit) - __parseFloat(cpInfo.gross_profit), 0, '$ ') }}</td>
                    </tr>

                    <tr class="even">
                        <td class="center">11</td>
                        <td colspan="2">日毛利润</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.day_gross_profit)">@{{ number_format(cpInfo.day_gross_profit, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.day_gross_profit)">@{{ number_format(realInfo.day_gross_profit, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.day_gross_profit) - __parseFloat(cpInfo.day_gross_profit), 0, '$ ') }}</td>
                    </tr>
                    <tr class="odd">
                        <td class="center">12</td>
                        <td colspan="2">日成本(管理)</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.cost_per_day)">@{{ number_format(cpInfo.cost_per_day, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.cost_day)">@{{ number_format(realInfo.cost_day, 0, '$ ') }}</td>
                        <td class="text-right"></td>
                    </tr>
                    <tr class="even">
                        <td class="center">13</td>
                        <td colspan="2">净利润</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.profit)">@{{ number_format(cpInfo.profit, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.profit)">@{{ number_format(realInfo.profit, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.profit) - __parseFloat(cpInfo.profit), 0, '$ ') }}</td>
                    </tr>
                    <tr class="odd">
                        <td class="center">14</td>
                        <td colspan="2">日净利润</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.day_profit)">@{{ number_format(cpInfo.day_profit, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.day_profit)">@{{ number_format(realInfo.day_profit, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.day_profit) - __parseFloat(cpInfo.day_profit), 0, '$ ') }}</td>
                    </tr>
                    <tr class="even">
                        <td class="center">15</td>
                        <td colspan="2">预计利润(1年)</td>
                        <td class="text-right" :style="dangerStyle(cpInfo.year_profit)">@{{ number_format(cpInfo.year_profit, 0, '$ ') }}</td>
                        <td class="text-right text-warning" :style="dangerStyle(realInfo.year_profit)">@{{ number_format(realInfo.year_profit, 0, '$ ') }}</td>
                        <td class="text-right">@{{ number_format(__parseFloat(realInfo.year_profit) - __parseFloat(cpInfo.year_profit), 0, '$ ') }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

    <script src="{{ cAsset('/assets/js/highcharts.js') }}"></script>
    <script src="{{ cAsset('/assets/js/highcharts-3d.js') }}"></script>

	<?php
	echo '<script>';
    echo 'var PlaceType = ' . json_encode(g_enum('PlaceType')) . ';';
    echo 'var VarietyType = ' . json_encode(g_enum('VarietyType')) . ';';
    echo 'var UnitData = ' . json_encode(g_enum('UnitData')) . ';';
	echo '</script>';
	?>
    <script>
        var equipObj = null;
        var $_this = null;
        var shipCertTypeList = [];
        var equipObjTmp = [];
        var certIdList = [];
        var shipId = '{!! $shipId !!}';
        var voyId = '{!! $voyId !!}';
        var activeVoy = $('#voy_list').val();
        var isChangeStatus = false;

        var economicGraph = null;
        var debitGraph = null;
        var initLoad = true;
        var activeId = 0;
        var type = '{!! $type !!}';

        function initRecord() {
            $('.year-title').text(activeVoy);
            getInitRecInfo(shipId, voyId);
        }

        function getInitRecInfo(shipId, voyId) {
            $.ajax({
                url: BASE_URL + 'ajax/shipManage/evaluation/list',
                type: 'post',
                data: {
                    shipId: shipId,
                    voyId: voyId,
                },
                success: function(data, status, xhr) {
                    let cpInfo = data['cpInfo'];
                    let realInfo = data['realInfo'];

                    equipObj = new Vue({
                        el: '#main-list',
                        data: {
                            shipId:         shipId,
                            voyId:          voyId,

                            cpInfo:         [],
                            realInfo:       [],

                            economicGrahp:  [],
                            debitGrahp:     [],
                        },
                        methods: {
                            dateModify(e, index, type) {
                                $(e.target).on("change", function() {
                                    equipObj.list[index][type] = $(this).val();
                                });
                            },
                            onChangeShip: function(e) {
                                location.href = '/shipManage/voy/evaluation?shipId=' + $_this.shipId + '&type=main';
                            },
                            onChangeVoy: function(e) {
                                location.href = '/shipManage/voy/evaluation?shipId=' + $_this.shipId + '&voyId=' + this.voyId + '&type=main';
                            },
                            number_format: function(value, decimal = 2, symbol = '') {
                                return __parseFloat(value) == 0 ? '' : symbol + number_format(value, decimal);
                            },
                            downPayment: function(cpInfo) {
                                let retVal = 0;
                                if(cpInfo['CP_kind'] == 'TC') {
                                    retVal = cpInfo['total_Freight'];
                                    // return this.number_format(retVal) == '' ? '' : this.number_format(retVal) + '天';
                                    return this.number_format(retVal)
                                } else {
                                    retVal = cpInfo['total_Freight'];
                                    return this.number_format(retVal, 2, '$ ');
                                }
                            },
                            customValue1: function(cpInfo) {
                                let retVal = 0;
                                if(cpInfo['CP_kind'] == 'TC') {
                                    retVal = cpInfo['ilohc'];
                                } else {
                                    retVal = cpInfo['deten_fee'];
                                }

                                return this.number_format(retVal, 2, '$ ');
                            },
                            customValue2: function(cpInfo) {
                                let retVal = 0;
                                if(cpInfo['CP_kind'] == 'TC') {
                                    retVal = cpInfo['c_v_e'];
                                } else {
                                    retVal = cpInfo['dispatch_fee'];
                                }

                                return this.number_format(retVal, 2, '$ ');
                            },
                            dangerStyle: function(value) {
                                return value < 0 ? 'color: red!important;' : '';
                            },
                            openNewPage: function(type) {
                                if(type == 'soa') {
                                    window.localStorage.setItem("soa_shipid",this.shipId);
                                    window.localStorage.setItem("soa_voyNo",voyId);
                                    window.open(BASE_URL + 'operation/incomeExpense', '_blank');
                                } else {
                                    window.open(BASE_URL + 'shipManage/dynamicList?shipId=' + this.shipId + '&voyNo=' + voyId, '_blank');
                                }
                            },
                            warningAlert: function() {
                                
                                // console.log('alertAudio')

                                let confirmationMessage = '信息输入不齐全会导致输出结果不正确。';
                                if($_this.cpInfo['CP_kind'] == 'VOY' && type == 'main') {
                                    if(__parseFloat($_this.cpInfo['fo_price']) == 0 || __parseFloat($_this.realInfo['rob_fo_price']) == 0 || __parseFloat($_this.cpInfo['do_price']) == 0 || __parseFloat($_this.realInfo['rob_do_price']) == 0) {
                                        // document.getElementById('warning-audio1').play();
                                        bootbox.alert(confirmationMessage);
                                        setTimeout(function() {
                                            bootbox.hideAll();
                                        }, 5000);
                                    }
                                }
                            },
                            fnExcelMain: function() {
                                var tab_text = "";
                                tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                                real_tab = document.getElementById('table-main');
                                var tab = real_tab.cloneNode(true);
                                tab_text=tab_text+"<tr><td colspan='5' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_info').html() + '_'  + $('#voy_list').val() + "次评估" + "</td></tr>";
                                
                                var j;
                                for(j=0;j<tab.rows.length-1;j++)
                                {
                                    tab.rows[j].childNodes[0].style.backgroundColor = '#d9f8fb';
                                    tab.rows[j].childNodes[4].style.backgroundColor = '#d9f8fb';
                                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                                }
                                tab.rows[j].childNodes[0].style.backgroundColor = '#d9f8fb';
                                tab.rows[j].childNodes[6].style.backgroundColor = '#d9f8fb';
                                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                                tab_text=tab_text+"</table>";

                                tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                                tab_text +="<tr colspan='6'><td style='height:20px;'></td></tr>"
                                real_tab = document.getElementById('table-main-2');
                                tab = real_tab.cloneNode(true);
                                for(j = 0; j < tab.rows.length ; j++)
                                {
                                    if (j==0) {
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
                                                    tab.rows[j].childNodes[i].innerHTML = "";
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
                                    tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                                }
                                tab_text=tab_text+"</table>";
                                
                                tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
                                tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
                                tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

                                var filename = $('#search_info').html() + '_'  + $('#voy_list').val() + "次评估";
                                exportExcel(tab_text, filename, filename);
                                
                                return 0;
                            }
                        },
                        mounted: function() {             // dengdai   //hangci   //zhuanghuo  //xiehuo
                            Highcharts.setOptions({
                                colors: ['#ffc000', '#a1c9f9', '#3eb373', '#b19fc5']
                            });
                                economicGraph = Highcharts.chart('economic_graph', {
                                    chart: {
                                        type: 'pie',
                                        options3d: {
                                            enabled: true,
                                            alpha: 45
                                        }
                                    },
                                    title: {
                                        text: '天数占率',
                                        style: {
                                            fontWeight: 'bold'
                                        }
                                    },
                                    tooltip: {
                                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                    },
                                    exporting: { enabled: false },
                                    credits: {
                                        enabled: false
                                    },
                                    accessibility: {
                                        point: {
                                        valueSuffix: '%'
                                        }
                                    },
                                    plotOptions: {
                                        pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                            connectorColor: 'silver'
                                        },
                                            innerSize: 40,
                                            depth: 30
                                        }
                                    },
                                    series: [{
                                        name: '天数占率',
                                        data: [
                                        { name: '等待天数', y: __parseFloat(realInfo.wait_time) },
                                        { name: '航行天数', y: __parseFloat(realInfo.sail_time) },
                                        { name: '装货天数', y: __parseFloat(realInfo.load_time) },
                                        { name: '卸货天数', y: __parseFloat(realInfo.disch_time) },
                                        ],
                                        dataLabels: {
                                            style: {
                                                fontSize: 14
                                            }
                                        }
                                    }]
                                });                    

                            Highcharts.setOptions({
                                colors: ['#ffc000', '#e86f6f', '#3eb373', '#b19fc5']
                            });

                            debitGraph = Highcharts.chart('debit_graph', {
                                chart: {
                                    type: 'pie',
                                    options3d: {
                                        enabled: true,
                                        alpha: 45
                                    }
                                },
                                title: {
                                    text: '支出占率',
                                    style: {
                                        fontWeight: 'bold'
                                    }
                                },
                                tooltip: {
                                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                                },
                                accessibility: {
                                    point: {
                                        valueSuffix: '%'
                                    }
                                },
                                credits: {
                                    enabled: false
                                },
                                exporting: { enabled: false },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                            connectorColor: 'silver'
                                        },
                                        innerSize: 40,
                                        depth: 30
                                    }
                                },
                                series: [{
                                    name: '支出占率',
                                    data: [
                                        { name: '装卸港费', y: __parseFloat(realInfo.sail_credit) },
                                        { name: '耗油成本', y: __parseFloat(realInfo.fuel_consumpt) },
                                        { name: '其他(运营)', y: __parseFloat(cpInfo.cost_else) },
                                        { name: '管理成本', y: __parseFloat(realInfo.manage_cost_day) },
                                    ],
                                    dataLabels: {
                                        style: {
                                            fontSize: 14
                                        }
                                    }
                                }]
                            });
                        },
                        updated() {
                            $('.date-picker').datepicker({
                                autoclose: true,
                            }).next().on(ace.click_event, function () {
                                $(this).prev().focus();
                            });
                        }
                    });

                    $_this = equipObj;
                    $_this.voyId = voyId;

                    $_this.cpInfo = Object.assign([], [], cpInfo);
                    $_this.realInfo = Object.assign([], [], realInfo);

                    let tmp1 = BigNumber($_this.realInfo.fo_mt).multipliedBy($_this.cpInfo.fo_price).toFixed(2);
                    let tmp2 = BigNumber($_this.realInfo.do_mt).multipliedBy($_this.cpInfo.do_price).toFixed(2);
                    $_this.cpInfo['fuel_consumpt'] = BigNumber(tmp1).plus(tmp2).toFixed(2);

                    // tmp1 = BigNumber($_this.realInfo.rob_fo).multipliedBy($_this.realInfo.rob_fo_price).toFixed(2);
                    // tmp2 = BigNumber($_this.realInfo.rob_do).multipliedBy($_this.realInfo.rob_do_price).toFixed(2);
                    // $_this.realInfo['fuel_consumpt'] = BigNumber(tmp1).plus(tmp2).toFixed(2);

                    let debitTmp1 = BigNumber($_this.cpInfo['up_port_price']).plus($_this.cpInfo['down_port_price']);
                    let debitTmp2 = BigNumber($_this.cpInfo['fuel_consumpt']).plus($_this.cpInfo['cost_else']);
                    $_this.cpInfo['manage_cost_day'] = BigNumber($_this.realInfo['cost_day']).multipliedBy($_this.cpInfo['sail_time']).toFixed(0);
                    $_this.cpInfo['debit'] = debitTmp1.plus(debitTmp2).plus($_this.cpInfo['manage_cost_day']).toFixed(0);

                    debitTmp1 = $_this.realInfo['sail_credit'];
                    debitTmp2 = BigNumber($_this.realInfo['fuel_consumpt']).plus($_this.cpInfo['cost_else']);
                    // $_this.realInfo['manage_cost_day'] = BigNumber($_this.realInfo['cost_day']).multipliedBy($_this.realInfo['total_sail_time']).toFixed(2);
                    $_this.realInfo['debit'] = BigNumber(debitTmp1).plus(debitTmp2).plus($_this.realInfo['manage_cost_day']).toFixed(0);

                    $_this.cpInfo['profit'] = BigNumber($_this.cpInfo['credit']).minus($_this.cpInfo['debit']).toFixed(0);
                    $_this.realInfo['profit'] = BigNumber($_this.realInfo['credit']).minus($_this.realInfo['debit']).toFixed(0);

                    $_this.cpInfo['day_profit'] = BigNumber($_this.cpInfo['profit']).div($_this.cpInfo['sail_time']).toFixed(0);
                    $_this.realInfo['day_profit'] = BigNumber($_this.realInfo['profit']).div($_this.realInfo['total_sail_time']).toFixed(0);

                    $_this.cpInfo['year_profit'] = BigNumber($_this.cpInfo['day_profit']).multipliedBy(360).toFixed(0);
                    $_this.realInfo['year_profit'] = BigNumber($_this.realInfo['day_profit']).multipliedBy(360).toFixed(0);

                    $_this.cpInfo['gross_profit'] = BigNumber($_this.cpInfo['profit']).plus($_this.cpInfo['manage_cost_day']).toFixed(0);
                    $_this.realInfo['gross_profit'] = BigNumber($_this.realInfo['profit']).plus($_this.realInfo['manage_cost_day']).toFixed(0);

                    $_this.cpInfo['day_gross_profit'] = BigNumber($_this.cpInfo['gross_profit']).div($_this.cpInfo['sail_time']).toFixed(0);
                    $_this.realInfo['day_gross_profit'] = BigNumber($_this.realInfo['gross_profit']).div($_this.realInfo['total_sail_time']).toFixed(0);

                    $_this.warningAlert();

                    

                }
            });
        }

        $('#select-ship').on('change', function() {
            let val = $(this).val();
            $_this.shipId = val;
            location.href = "/shipManage/voy/evaluation?shipId=" + $(this).val();
        });

        $('#voy_list').on('change', function() {
            $('.year-title').text($(this).val());
            $_this.voyId = $(this).val();
            location.href = "/shipManage/voy/evaluation?shipId=" + $_this.shipId + '&voyId=' + $(this).val();
        });

    </script>