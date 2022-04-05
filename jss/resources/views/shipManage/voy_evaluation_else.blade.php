<div id="else-list" v-cloak>
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
            <label class="font-bold">年: </label>
            <select class="text-center" style="width: 60px;" @change="onChangeVoy" v-model="year">
                @foreach($yearList as $key => $item)
                    <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>

            <strong style="font-size: 20px; padding-top: 6px; margin-left: 30px;" class="f-right for-pc">
                <span id="search_info">{{ $shipName }}</span>&nbsp;<span class="font-bold">@{{ year }}年航次效率比较</span>
            </strong>
            
        </div>
        <div class="col-lg-5 for-pc">
            <div class="btn-group f-right">
                <a class="btn btn-sm btn-dynamic" @click="openNewPage('dynamic')"><i class="icon-bar-chart"></i> 动态分析</a>
                <button class="btn btn-warning btn-sm excel-btn" @click="fnExcelElse()"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
            </div>
        </div>
    </div>
    
    <div class="row" style="margin-top: 4px;">
        <div class="col-lg-12 full-width">
            <div class="table-responsive">
                <table id="table-else" class="nowrap-table">
                    <tr class="dynamic-footer">
                        <th class="center not-striped-td" rowspan="2" style="width: 3%;">航次</th>
                        <th class="center not-striped-td" rowspan="2" style="width: 3%;">租船<br><br>种类</th>
                        <th class="center not-striped-td" rowspan="2" style="width: 10%;">期间</th>
                        <th class="center not-striped-td" rowspan="2" style="width: 6%;">航次<br><br>用时</th>
                        <th class="center not-striped-td" style="height: 25px;">里程</th>
                        <th class="center not-striped-td" rowspan="2" style="width: 7%;">货量<br>(租期)</th>
                        <th class="center not-striped-td" rowspan="2" style="width: 7%;">运费率<br>(日租金)</th>
                        <th class="center not-striped-td" colspan="3" style="border-right: 2px solid rgb(255, 146, 7);">SOA($)</th>
                        <th class="center not-striped-td" colspan="2" style="border-right: 2px solid rgb(255, 146, 7);">实际($)</th>
                        <th class="center not-striped-td" colspan="5">支出因素占率(%)</th>
                    </tr>

                    <tr class="dynamic-footer">
                        <th class="center not-striped-td" style="width: 6%;">[NM]</th>
                        <th class="center not-striped-td" style="width: 8%;">收入</th>
                        <th class="center not-striped-td" style="width: 4%;">收入/<br>里程</th>
                        <th class="center not-striped-td" style="width: 6%; border-right: 2px solid rgb(255, 146, 7);">利润</th>
                        <th class="center not-striped-td" style="width: 6%;">利润</th>
                        <th class="center not-striped-td" style="border-right: 2px solid rgb(255, 146, 7); width: 5%;">日利润</th>
                        <th class="center not-striped-td" style="width: 7%;">支出</th>
                        <th class="center not-striped-td style-red-header" style="width: 5%;">耗油<br>成本</th>
                        <th class="center not-striped-td style-red-header" style="width: 5%;">港费</th>
                        <th class="center not-striped-td style-red-header" style="width: 5%;">其他</th>
                        <th class="center not-striped-td" style="width: 5%">管理<br>成本</th>
                    </tr>

                    <tbody>
                        <tr v-for="(item, index) in list" class="index % 2 == 0 ? 'odd' : 'even'">
                            <td class="center voy-no" style="height: 22px;cursor:pointer;background:linear-gradient(#fff, #d9f8fb)!important;" @click="onVoyDetail(item[0].Voy_No)">@{{ item[0].Voy_No }}</td>
                            <td class="center">@{{ item[0].CP_kind }}</td>
                            <td class="center">@{{ _sailTime(item[1].start_date, item[1].end_date) }}</td>
                            <td class="text-right">@{{ _number_format(item[1].total_sail_time) }}</td>
                            <td class="text-right">@{{ _number_format(item[1].total_distance, 0) }}</td>
                            <td class="text-right">@{{ _number_format(item[1].cgo_qty, 0) }}</td>
                            <td class="text-right">@{{ getFrtRate(item[0].Freight, item[0].total_Freight) }}</td>
                            <td class="text-right text-profit">@{{ _number_format(item[1].credit, 0) }}</td>
                            <td class="center">@{{ _number_format(item[1].credit_distance, 0) }}</td>
                            <td class="text-right" :style="debitClass(item[1].soa_credit)" style="border-right: 2px solid rgb(255, 146, 7);">@{{ _number_format(item[1].soa_credit, 0) }}</td>
                            <td class="text-right" :style="debitClass(item[1].profit)">@{{ _number_format(item[1].profit, 0) }}</td>
                            <td class="text-right" style="border-right: 2px solid rgb(255, 146, 7);" :style="debitClass(item[1].day_profit)">@{{ _number_format(item[1].day_profit, 0) }}</td>
                            <td class="center">@{{ _number_format(item[1].debit_percent, 1) + (_number_format(item[1].debit_percent, 1) == '' ? '' : '%') }}</td>
                            <td class="center">@{{ _number_format(item[1].fuel_percent, 1) }}</td>
                            <td class="center">@{{ _number_format(item[1].sail_percent, 1) }}</td>
                            <td class="center">@{{ _number_format(item[1].else_percent, 1) }}</td>
                            <td class="center">@{{ _number_format(item[1].manage_percent, 1) }}</td>
                        </tr>

                        <tr class="dynamic-footer bottom-0">
                            <td class="text-center not-striped-td" style="height: 22ppx!important">@{{ _number_format(footer.count, 0) }}</td>
                            <td class="text-center not-striped-td"></td>
                            <td class="text-center not-striped-td"></td>
                            <td class="text-right not-striped-td" style="height: 22ppx!important">@{{ _number_format(footer.sail_time, 2) }}</td>
                            <td class="text-right not-striped-td">@{{ _number_format(footer.distance, 0) }}</td>
                            <td class="text-right not-striped-td"></td>
                            <td class="text-right not-striped-td"></td>
                            <td class="text-right not-striped-td text-profit">@{{ _number_format(footer.credit, 0) }}</td>
                            <td class="text-center not-striped-td">@{{ _number_format(footer.credit_distance, 0) }}</td>
                            <td class="text-right not-striped-td" style="border-right: 2px solid rgb(255, 146, 7); height: 22px;" :style="debitClass(footer.profit_soa)">@{{ _number_format(footer.profit_soa, 0) }}</td>
                            <td class="text-right not-striped-td" :style="debitClass(footer.profit_real)">@{{ _number_format(footer.profit_real, 0) }}</td>
                            <td class="text-right not-striped-td" style="border-right: 2px solid rgb(255, 146, 7);" :style="debitClass(footer.day_profit_real)">@{{ _number_format(footer.day_profit_real, 0) }}</td>
                            <td class="text-center not-striped-td">@{{ _number_format(footer.debit, 1, '%') }}</td>
                            <td class="text-center not-striped-td" style="background: #f2dcdb!important">@{{ _number_format(footer.fuel, 1) }}</td>
                            <td class="text-center not-striped-td" style="background: #f2dcdb!important">@{{ _number_format(footer.sail, 1) }}</td>
                            <td class="text-center not-striped-td" style="background: #f2dcdb!important">@{{ _number_format(footer.else, 1) }}</td>
                            <td class="text-center not-striped-td">@{{ _number_format(footer.manage, 1) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

	<?php
	echo '<script>';
    echo 'var PlaceType = ' . json_encode(g_enum('PlaceType')) . ';';
    echo 'var VarietyType = ' . json_encode(g_enum('VarietyType')) . ';';
    echo 'var UnitData = ' . json_encode(g_enum('UnitData')) . ';';
	echo '</script>';
	?>
    <script>

        var compareObj = null;
        var $__this = null;
        var shipId = '{!! $shipId !!}';
        var voyId = '{!! $voyId !!}';
        var activeYear = '{!! $year !!}';
        function initRequire() {
            compareObj = new Vue({
                el: '#else-list',
                data: {
                    shipId:         shipId,
                    year:           activeYear,

                    list:           [],
                    cpInfo:         [],
                    realInfo:       [],

                    economicGrahp:  [],
                    debitGrahp:     [],

                    footer:         [],

                },
                methods: {
                    dateModify(e, index, type) {
                        $(e.target).on("change", function() {
                            compareObj.list[index][type] = $(this).val();
                        });
                    },
                    onChangeShip: function(e) {
                        location.href = '/shipManage/voy/evaluation?shipId=' + this.shipId + '&type=else';
                    },
                    onChangeVoy: function(e) {
                        location.href = '/shipManage/voy/evaluation?shipId=' + this.shipId + '&year=' + e.target.value + '&type=else';
                    },
                    onVoyDetail: function(voyId) {
                        location.href = '/shipManage/voy/evaluation?shipId=' + this.shipId + '&voyId=' + voyId + '&type=main';
                    },
                    _sailTime: function(start, end) {
                        if(start == undefined && end == undefined)
                            return '';
                        if(start == undefined) start = '';
                        if(end == undefined) end = '';

                        return this.voyDateFormat(start) + ' ~ ' + this.voyDateFormat(end);
                    },
                    _number_format: function(value, decimal = 2, symbol = '') {
                        return __parseFloat(value) == 0 ? '' : number_format(value, decimal) + symbol;
                    },
                    openNewPage: function(type) {
                        if(type == 'soa') {
                            window.open(BASE_URL + 'business/contract?shipId=' + this.shipId, '_blank');
                        } else {
                            window.open(BASE_URL + 'shipManage/dynamicList?shipId=' + this.shipId + '&year=' + this.year + '&type=analyze', '_blank');
                        }
                    },
                    debitClass: function(value) {
                        return value < 0 ? 'color: red!important;' : '';
                    },
                    voyDateFormat: function(date, format = '-') {
                        return moment(date).format('YY-MM-DD');
                    },
                    getFrtRate: function(a, b) {
                        let val = '';
                        if(__parseFloat(a) == 0)
                            val = b;
                        else
                            val = a;

                        return __parseFloat(val) == 0 ? '' : '$ ' + _number_format(val, 2);
                    },
                    fnExcelElse: function() {
                        //table-else
                        var tab_text = "";
                        tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                        real_tab = document.getElementById('table-else');
                        var tab = real_tab.cloneNode(true);
                        tab_text=tab_text+"<tr><td colspan='17' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_info').html() + '_'  + compareObj._data.year + "年航次效率比较" + "</td></tr>";
                        
                        for(j = 0; j < tab.rows.length ; j++)
                        {
                            if (j==0||j==1||j==tab.rows.length-1) {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                }
                            }
                            if (j==0) {
                                tab.rows[j].childNodes[4].style.width = '240px';
                            }
                            tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                        }
                        tab_text=tab_text+"</table>";
                        
                        tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
                        tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
                        tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

                        var filename = $('#search_info').html() + '_'  + compareObj._data.year + "年航次效率比较";
                        exportExcel(tab_text, filename, filename);
                        
                        return 0;
                    }
                }
            });

            $__this = compareObj;
            $__this.year = activeYear;
            getInitInfo();
        }

        function getInitInfo() {
            $.ajax({
                url: BASE_URL + 'ajax/shipManage/evaluation/else',
                type: 'post',
                data: {
                    shipId: $__this.shipId,
                    year:   $__this.year,
                },
                success: function(data, status, xhr) {
                    let list = data;
                    $__this.list = Object.assign([], [], []);

                    let _sail_time = 0;
                    let _distance = 0;
                    let _credit = 0;
                    let _credit_distance = 0;
                    let _profit_soa = 0;
                    let _profit_real = 0;
                    let _profit_day = 0;

                    let _debit = 0;
                    let _fuel = 0;
                    let _sail = 0;
                    let _else = 0;
                    let _manage = 0;
                    console.log(data);



                    list.forEach(function(value, key) {
                        let cpInfo = value['cpInfo'];
                        let realInfo = value['realInfo'];

                        $__this.cpInfo = [];
                        $__this.realInfo = [];

                        $__this.cpInfo = Object.assign([], [], cpInfo);
                        $__this.realInfo = Object.assign([], [], realInfo);

                        let tmp1 = BigNumber($__this.realInfo.used_fo).multipliedBy($__this.cpInfo.fo_price).toFixed(2);
                        let tmp2 = BigNumber($__this.realInfo.used_do).multipliedBy($__this.cpInfo.do_price).toFixed(2);
                        $__this.cpInfo['fuel_consumpt'] = BigNumber(tmp1).plus(tmp2).toFixed(2);

                        tmp1 = BigNumber($__this.realInfo.rob_fo).multipliedBy($__this.realInfo.rob_fo_price).toFixed(2);
                        tmp2 = BigNumber($__this.realInfo.rob_do).multipliedBy($__this.realInfo.rob_do_price).toFixed(2);
                        $__this.realInfo['fuel_consumpt'] = BigNumber(tmp1).plus(tmp2).toFixed(2);

                        let debitTmp1 = BigNumber($__this.cpInfo['up_port_price']).plus($__this.cpInfo['down_port_price']);
                        let debitTmp2 = BigNumber($__this.cpInfo['fuel_consumpt']).plus($__this.cpInfo['cost_else']);
                        $__this.cpInfo['manage_cost_day'] = BigNumber($__this.realInfo['cost_day']).multipliedBy($__this.cpInfo['sail_time']).toFixed(2);
                        $__this.cpInfo['debit'] = debitTmp1.plus(debitTmp2).plus($__this.cpInfo['manage_cost_day']).toFixed(2);

                        debitTmp1 = $__this.realInfo['sail_credit'];
                        debitTmp2 = BigNumber($__this.realInfo['fuel_consumpt']).plus($__this.cpInfo['cost_else']);
                        $__this.realInfo['manage_cost_day'] = BigNumber($__this.realInfo['cost_day']).multipliedBy($__this.realInfo['total_sail_time']).toFixed(2);
                        $__this.realInfo['debit'] = BigNumber(debitTmp1).plus(debitTmp2).plus($__this.realInfo['manage_cost_day']).toFixed(2);

                        $__this.cpInfo['profit'] = BigNumber($__this.cpInfo['credit']).minus($__this.cpInfo['debit']).toFixed(2);
                        $__this.realInfo['profit'] = BigNumber($__this.realInfo['credit']).minus($__this.realInfo['debit']).toFixed(2);

                        $__this.cpInfo['day_profit'] = BigNumber($__this.cpInfo['profit']).div($__this.cpInfo['sail_time']).toFixed(2);
                        $__this.realInfo['day_profit'] = BigNumber($__this.realInfo['profit']).div($__this.realInfo['total_sail_time']).toFixed(2);

                        $__this.cpInfo['year_profit'] = BigNumber($__this.cpInfo['day_profit']).multipliedBy(360).toFixed(2);
                        $__this.realInfo['year_profit'] = BigNumber($__this.realInfo['day_profit']).multipliedBy(360).toFixed(2);

                        $__this.cpInfo['gross_profit'] = BigNumber($__this.cpInfo['profit']).plus($__this.cpInfo['manage_cost_day']).toFixed(2);
                        $__this.realInfo['gross_profit'] = BigNumber($__this.realInfo['profit']).plus($__this.realInfo['manage_cost_day']).toFixed(2);

                        $__this.cpInfo['day_gross_profit'] = BigNumber($__this.cpInfo['gross_profit']).div($__this.cpInfo['sail_time']).toFixed(2);
                        $__this.realInfo['day_gross_profit'] = BigNumber($__this.realInfo['gross_profit']).plus($__this.realInfo['total_sail_time']).toFixed(2);
                        $__this.realInfo['credit_distance'] = BigNumber($__this.realInfo['credit']).div($__this.realInfo['total_distance']).toFixed(0);

                        $__this.realInfo['debit_percent'] = BigNumber($__this.realInfo['debit']).div($__this.realInfo['credit']).multipliedBy(100).toFixed(1);
                        $__this.realInfo['fuel_percent'] = BigNumber($__this.realInfo['fuel_consumpt']).div($__this.realInfo['debit']).multipliedBy(100).toFixed(1);
                        $__this.realInfo['sail_percent'] = BigNumber($__this.realInfo['sail_credit']).div($__this.realInfo['debit']).multipliedBy(100).toFixed(1);
                        $__this.realInfo['else_percent'] = BigNumber($__this.cpInfo['cost_else']).div($__this.realInfo['debit']).multipliedBy(100).toFixed(1);
                        $__this.realInfo['manage_percent'] = BigNumber($__this.realInfo['manage_cost_day']).div($__this.realInfo['debit']).multipliedBy(100).toFixed(1);

                        _sail_time += __parseFloat($__this.realInfo['total_sail_time']);
                        _distance += __parseFloat($__this.realInfo['total_distance']);
                        _credit += __parseFloat($__this.realInfo['credit']);
                        _credit_distance += __parseFloat($__this.realInfo['credit_distance']);
                        _profit_soa += __parseFloat($__this.realInfo['soa_credit']);
                        _profit_real += __parseFloat($__this.realInfo['profit']);
                        _profit_day += __parseFloat($__this.realInfo['day_profit']);
                        _debit += __parseFloat($__this.realInfo['debit_percent']);
                        _fuel += __parseFloat($__this.realInfo['fuel_percent']);
                        _sail += __parseFloat($__this.realInfo['sail_percent']);
                        _else += __parseFloat($__this.realInfo['else_percent']);
                        _manage += __parseFloat($__this.realInfo['manage_percent']);

                        $__this.list.push([$__this.cpInfo, $__this.realInfo]);
                    });

                    let cnt = $__this.list.length;
                    $__this.footer.count = $__this.list.length;
                    $__this.footer.sail_time = _sail_time;
                    $__this.footer.distance = _distance;
                    $__this.footer.credit = BigNumber(_credit).toFixed(0);
                    $__this.footer.credit_distance = BigNumber(_credit_distance).div(cnt).toFixed(0);
                    $__this.footer.profit_soa = BigNumber(_profit_soa).toFixed(0);
                    $__this.footer.profit_real = BigNumber(_profit_real).toFixed(0);
                    $__this.footer.day_profit_real = BigNumber(_profit_day).div(cnt).toFixed(0);
                    $__this.footer.debit = BigNumber(_debit).div(cnt).toFixed(1);
                    $__this.footer.fuel = BigNumber(_fuel).div(cnt).toFixed(1);
                    $__this.footer.sail = BigNumber(_sail).div(cnt).toFixed(1);
                    $__this.footer.else = BigNumber(_else).div(cnt).toFixed(1);
                    $__this.footer.manage = BigNumber(_manage).div(cnt).toFixed(1);

                }
            });
        }

        $('#select-ship').on('change', function() {
            location.href = "/shipManage/shipCertList?id=" + $(this).val()
        });

    </script>