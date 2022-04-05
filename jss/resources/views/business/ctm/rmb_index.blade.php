
        <div class="row">
            <div class="col-lg-6">
                <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名: </label>
                <select class="custom-select d-inline-block" id="select-ship" style="padding: 4px; max-width: 100px;">
                    @foreach($shipList as $ship)
                        <option value="{{ $ship['IMO_No'] }}"{{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}</option>
                    @endforeach
                </select>
                <select class="text-center ml-1" id="year_list">
                    @foreach($yearList as $key => $item)
                        <option value="{{ $item }}" {{ $activeYear == $item ? 'selected' : '' }}>{{ $item }}年</option>
                    @endforeach
                </select>
                @if(isset($shipName['shipName_En']))
                    <strong class="f-right" style="font-size: 16px; padding-top: 6px;"><span id="ship_name">{{ $shipName['shipName_En'] }}</span>&nbsp;&nbsp;<span class="active-year"></span>年CTM记录(<span class="text-danger">¥</span>)</strong>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="btn-group f-right">
                    <button class="btn btn-primary btn-sm search-btn" onclick="addRow()"><i class="icon-plus"></i>添加</button>
                    <button class="btn btn-sm btn-success" id="submit"><i class="icon-save"></i>保存</button>
                    <button class="btn btn-warning btn-sm excel-btn" onclick="fnExcelRmbReport()"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 4px;" id="rmb_list" v-cloak>
            <div class="head-fix-div common-list" id="rmb-ctm-table">
                <form action="saveCtmList" method="post" id="ctmList-form" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" value="{{ $shipId }}" name="shipId">
                    <input type="hidden" value="{{ CNY_LABEL }}" name="ctm_type">
                    <input type="hidden" v-model="activeYear" name="activeYear">
                    <table class="table-layout-fixed" id="table-rmb-list">
                        <thead class="">
							<th class="d-none"></th>
							<th class="text-center style-header center" style="width: 4%;">NO</th>
							<th class="text-center style-header center" style="width: 7%;">日期</th>
							<th class="text-center style-header" style="width: 6%;">航次</th>
							<th class="text-center style-header" style="width: 6%;">收支<br>种类</th>
							<th class="text-center style-header" style="width: 25%;">摘要</th>
							<th class="text-center style-header" style="width: 7%;">收入</th>
							<th class="text-center style-header" style="width: 7%;">支出</th>
							<th class="text-center style-header" style="width: 8%;">余额</th>
							<th class="text-center style-header" style="width: 7%;">汇率</th>
							<th class="text-center style-header" style="width: 16%;">备注</th>
							<th class="text-center style-header" style="width: 3%;">凭证</th>
							<th style="width: 2%;"></th>
                        </thead>
                        <tbody>
                        <tr class="prev-voy">
                            <td></td>
                            <td class="text-center">@{{ prevData.reg_date }}</td>
                            <td></td>
                            <td></td>
                            <td>@{{ prevData.abstract }}</td>
                            <td></td>
                            <td></td>
                            <td class="text-right font-weight-bold" style="debitClass">
                                ¥ @{{ number_format(prevData.balance) }}
                            </td>
                            <td class="text-center">@{{ number_format(prevData.rate, 4) }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr v-for="(item, array_index) in list">
                            <td class="d-none"><input type="hidden" name="id[]" v-model="item.id"></td>
                            <td class="center no-wrap">
                                <input type="text" class="form-control text-center" name="ctm_no[]" v-model="item.ctm_no" minlength="5" maxlength="5" readonly>
                            </td>
                            <td class="center">
                                <input type="text" class="date-picker form-control text-center" name="reg_date[]" v-model="item.reg_date" @click="dateModify($event, array_index)" data-date-format="yyyy-mm-dd">
                            </td>
                            <td class="center no-wrap">
                                <select class="form-control" v-model="item.voy_no" name="voy_no[]">
                                    <option v-for="voyItem in voyList" :value="voyItem['Voy_No']">@{{ voyItem['Voy_No'] }}</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control" v-model="item.profit_type" name="profit_type[]">
                                    <option v-for="(profitItem, profitIndex) in profitType" :value="profitIndex">@{{ profitItem }}</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control remark" v-model="item.abstract" name="abstract[]">
                            </td>
                            <td class="center">
                                <my-currency-input v-model="item.credit" class="form-control text-right font-weight-bold" :class="creditClass(item.credit)" name="credit[]" v-bind:prefix="'¥'" v-bind:fixednumber="2" v-bind:type="'credit'" v-bind:index="array_index"></my-currency-input>
                            </td>
                            <td class="center">
                                <my-currency-input v-model="item.debit" class="form-control text-right" name="debit[]" :style="debitClass(item.debit)" v-bind:prefix="'¥'" v-bind:fixednumber="2" v-bind:type="'debit'" v-bind:index="array_index"></my-currency-input>
                                <input type="hidden" v-model="item.usd_debit" class="d-none" name="usd_debit[]">
                            </td>
                            <td>
                                <my-currency-input v-model="item.balance" name="balance[]" :readonly="true" class="form-control text-right" :style="debitClass(item.balance)" name="balance[]" v-bind:prefix="'¥'" v-bind:fixednumber="2"></my-currency-input>
                            </td>
                            <td>
                                <my-currency-input v-model="item.rate" class="form-control text-center" name="rate[]" v-bind:prefix="''" v-bind:fixednumber="4"></my-currency-input>
                            </td>
                            <td>
                                <input v-model="item.remark" class="form-control remark" name="remark[]" require>
                            </td>
                            <td class="text-center">
                                <div class="d-flex" :style = "item.attachment_link != '' && item.attachment_link != null ? '' : 'display: none!important;'">
                                    <a :href="item.attachment_link" target="_blank"><img v-bind:src="getImage(item.file_name)" width="15" height="15" style="cursor: pointer;" v-bind:title="item.file_name"></a>
                                    <img src="/assets/images/cancel.png" width="12" height="12" style="cursor: pointer; padding-left: 2px!important;" @click="removeFile(array_index)">
                                </div>
                                <label v-bind:for="array_index + 'rmb'" v-show="item.attachment_link == '' || item.attachment_link == null"><img v-bind:src="getImage(item.file_name)" width="15" height="15" style="cursor: pointer;" v-bind:title="item.file_name"></label>
                                <input type="file" name="attachment[]" v-bind:id="array_index + 'rmb'" class="d-none" @change="onFileChange" v-bind:data-index="array_index">
                                <input type="hidden" name="is_update[]" v-bind:id="array_index + '_id'" class="d-none" v-bind:value="item.is_update">
                            </td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a class="red" @click="deleteItem(item.id, item.is_tmp, array_index)">
                                        <i class="icon-trash" style="color: red!important;"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="dynamic-result-table table-layout-fixed ctm-footer" id="table-rmb-footer">
                        <tbody>
                        <tr class="dynamic-footer">
                            <td class="text-center" style="width: 4%;"></td>
                            <td class="text-center" style="width: 7%;"></td>
                            <td class="text-center" style="width: 6%;"></td>
                            <td class="text-center" style="width: 6%;"></td>
                            <td class="text-center" style="width: 25%;">@{{ activeYear }}年底余额</td>
                            <td class="text-right text-profit font-weight-bold" style="width: 7%;">¥ @{{ number_format(total.credit) }}</td>
                            <td class="text-right font-weight-bold" style="width: 7%">¥ @{{ number_format(total.debit) }}</td>
                            <td class="text-right font-weight-bold" style="width: 8%" :style="debitClass(total.balance)">¥ @{{ number_format(total.balance) }}</td>
                            <td class="text-center" style="width: 7%"></td>
                            <td class="text-center" style="width: 16%"></td>
                            <td class="text-center" style="width: 3%"></td>
                            <td class="text-center" style="width: 2%;"></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div id="test"></div>
        </div>

    <?php
        echo '<script>';
        echo 'var profitTypes = ' . json_encode(g_enum('ProfitTypeData')) . ';';
        echo '</script>';
    ?>
    <script>
        
        var rmbListObj = null;
        var usdListObj = null;
        var ctmListTmp = new Array();
        var IS_FILE_KEEP = '{!! IS_FILE_KEEP !!}';
        var IS_FILE_DELETE = '{!! IS_FILE_DELETE !!}';
        var IS_FILE_UPDATE = '{!! IS_FILE_UPDATE !!}';
        var ship_id = '{!! $shipId !!}';
        var isChangeStatus = false;
        var initLoad = true;
        var _this = null;
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


        function initializeRmb() {
            // Create Vue Obj
            rmbListObj = new Vue({
                el: '#rmb_list',
                data: {
                    prevData: [],
                    list: [],
                    voyList: [],
                    profitType: ProfitTypeData,

                    shipId: ship_id,
                    activeYear: activeYear,
                    ctmType:    'CNY',

                    total: {
                        credit: 0,
                        debit: 0,
                        balance: 0,
                    },

                },
                methods: {
                    dateModify(e, index) {
                        $(e.target).on("change", function() {
                            _this.list[index]['reg_date'] = $(this).val();
                        });
                    },
                    onFileChange(e) {
                        let index = e.target.getAttribute('data-index');
                        _this.list[index]['is_update'] = IS_FILE_UPDATE;
                        _this.list[index]['file_name'] = 'updated';
                        _this.list[index]['attachment_link'] = ' ';
                        this.$forceUpdate();
                    },
                    getImage: function(file_name) {
                        if(file_name != '' && file_name != undefined)
                            return '/assets/images/document.png';
                        else
                            return '/assets/images/paper-clip.png';
                    },
                    removeFile(index) {
                        _this.list[index]['file_name'] = '';
                        _this.list[index]['attachment_link'] = '';
                        _this.list[index]['is_update'] = IS_FILE_DELETE;
                        $('#' + index + 'rmb').val('');
                        this.$forceUpdate();
                        // $('#tc_file_remove').val(1);
                    },
                    calcTotal: function() {
                        let credit = 0;
                        let debit = 0;
                        let balance = 0;
                        _this.list.map(function(data, index) {
                            if(index == 0) {
                                _this.list[index].balance = BigNumber(_this.prevData.balance).plus(_this.list[index].credit).minus(_this.list[index].debit).toFixed(2);
                            } else {
                                _this.list[index].balance = BigNumber(_this.list[index - 1].balance).plus(_this.list[index].credit).minus(_this.list[index].debit).toFixed(2);
                            }
                            _this.list[index].usd_debit = BigNumber(_this.list[index].debit).div(_this.list[index].rate).toFixed(2);
                            credit += isNaN(data['credit']) ? 0 : parseFloat(data['credit']);
                            debit += isNaN(data['debit']) ? 0 : parseFloat(data['debit']);
                        });

                        _this.total.credit = credit;
                        _this.total.debit = debit;
                        _this.total.balance = BigNumber(credit).minus(debit).plus(__parseFloat(_this.prevData.balance));
                    },
                    setDebitCredit: function(type, index) {
                        if(type == 'debit')
                            _this.list[index].credit = 0;
                        else if(type == 'credit') {
                            _this.list[index].debit = 0;
                        }
                    },
                    number_format: function(value, decimal = 2) {
                        return isNaN(value) ? '-' : number_format(value, decimal);
                    },
                    setDefault: function() {
                        let length = _this.list.length;
                        if(length == 0) {
                            _this.list.push([]);
                            _this.list[length].ctm_no  = _this.activeYear[2] + _this.activeYear[3] + '001';
                            _this.list[length]['is_tmp']  = '';
                            _this.list[length].reg_date  = this.getToday();
                            if(this.voyList.length > 0)
                                _this.list[length].voy_no  = this.voyList[0]['Voy_No'];

                            _this.list[length].profit_type  = 1;
                            _this.list[length].rate  = 0;
                            _this.list[length].abstract  = '';
                            _this.list[length].credit  = 0;
                            _this.list[length].debit  = 0;
                            _this.list[length].remark  = '';
                        } else {
                            let prevData = _this.list[length - 1];
                            _this.list.push([]);
                            
                            _this.list[length].ctm_no  = parseInt(prevData.ctm_no) + 1;
                            _this.list[length]['is_tmp']  = 1;
                            _this.list[length].reg_date  = prevData.reg_date;
                            _this.list[length].voy_no  = prevData.voy_no;
                            _this.list[length].profit_type  = '';
                            _this.list[length].rate  = prevData.rate;
                            _this.list[length].abstract  = '';
                            _this.list[length].credit  = 0;
                            _this.list[length].debit  = 0;
                            _this.list[length].remark  = '';
                        }

                        // setTimeout(function() {
                            $($('[name=abstract]')[length]).focus();
                        // }, 1000);

                        _this.calcTotal();
                    },
                    deleteItem(id, is_tmp, array_index) {
                        __alertAudio();
                        bootbox.confirm("Are you sure you want to delete?", function (result) {
                            if (result) {
                                if (is_tmp == 0) {
                                    $.ajax({
                                        url: BASE_URL + 'ajax/business/ctm/delete',
                                        type: 'post',
                                        data: {
                                            id: id,
                                        },
                                        success: function (data, status, xhr) {
                                            _this.list.splice(array_index, 1);
                                            ctmListTmp = JSON.parse(JSON.stringify(_this.list));
                                        }
                                    })
                                } else {
                                    _this.list.splice(array_index, 1);
                                    ctmListTmp = JSON.parse(JSON.stringify(_this.list));
                                }
                            }
                        });
                    },

                    getToday: function(symbol = '-') {
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = yyyy + symbol + mm + symbol + dd;

                        return today;
                    },

                    creditClass: function(value) {
                        return value < 0 ? 'text-danger' : 'text-profit';
                    },
                    debitClass: function(value) {
                        return value < 0 ? 'color: red!important;' : '';
                    },
                },
                computed: {

                },
                updated() {
                    $('.date-picker').datepicker({
                        autoclose: true,
                    }).next().on(ace.click_event, function () {
                        $(this).prev().focus();
                    });

                    offAutoCmplt();
                    $($('[name=abstract]')[_this.list.length - 1]).focus();
                }
            });

            _this = rmbListObj;
            $('.active-year').text(_this.activeYear);
            getRmbInitInfo(ship_id);

        }

        function getRmbInitInfo(ship_id) {
            $.ajax({
                url: BASE_URL + 'ajax/business/ctm/list',
                type: 'post',
                data: {
                    shipId: _this.shipId,
                    year: _this.activeYear,
                    type: _this.ctmType,
                },
                success: function(data, status, xhr) {
                    let record = data['list'];
                    let prevRecord = data['prevList'];
                    let voyList = data['voyList'];
                    
                    _this.list = Object.assign([], [], record);
                    _this.voyList = Object.assign([], [], voyList);

                    _this.list.forEach(function(value, index) {
                        _this.list[index]['is_update'] = IS_FILE_KEEP;
                        _this.list[index]['is_tmp'] = 0;
                    });

                    _this.prevData = Object.assign([], [], prevRecord);

                    _this.calcTotal();

                    ctmListTmp = JSON.parse(JSON.stringify(_this.list));
                }
            })
        }

        function addRow() {
            _this.setDefault();
            $('#rmb-ctm-table').scrollTop($('#rmb-ctm-table table').innerHeight());
        }

        $('#select-ship').on('change', function() {
            isChangeStatus = false;
            location.href = '/business/ctm?shipId=' + $(this).val() + '&type=CNY';;
        });

        $('#year_list').on('change', function() {
            _this.activeYear = $(this).val();
            $('.active-year').text(_this.activeYear);
            getRmbInitInfo($(this).val());
        });
        
        $('#submit').on('click', function() {
            submitted = true;
            let isEmpty = false;
            _this.list.forEach(function(data, key) {
                if(data.reg_date == '0000-00-00' || 
                (data.credit == 0 && data.debit == 0) || 
                data.abstract == '' || 
                data.profit_type == '' || 
                __parseFloat(data.rate) == 0 || 
                data.voy_no == '' || 
                data.voy_no == undefined)
                    isEmpty = true;
            });

            if(isEmpty) {alert('请您必须填数据.'); return false;}
            $('#ctmList-form').submit();
        });
        
        $('body').on('keydown', 'input, select', function(e) {
            if (e.key === "Enter") {
                var self = $(this), form, focusable, next;
                form = $('#ctmList-form');
            
                focusable = form.find('input').filter(':visible');
                next = focusable.eq(focusable.index(this)+1);
                if (next.length) {
                    next.focus();
                }
                return false;
            }
        });
        
        function fnExcelRmbReport()
        {
            var tab_text = "";
            tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            real_tab = document.getElementById('table-rmb-list');
            var tab = real_tab.cloneNode(true);
            
            tab_text=tab_text+"<tr><td colspan='10' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#ship_name').html() + ' ' + $('#year_list option:selected').val() + "年_CTM记录(¥)</td></tr>";

            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                        tab.rows[j].childNodes[i].style.height = '30px';
                        if (i == 10) tab.rows[j].childNodes[i].style.width = '300px';
                    }
                    tab.rows[j].childNodes[24].remove();
                    tab.rows[j].childNodes[22].remove();
                    tab.rows[j].childNodes[0].remove();
                }
                else if (j == 1) {
                    for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                    }
                    tab.rows[j].childNodes[22].remove();
                    tab.rows[j].childNodes[20].remove();
                }
                else {
                    for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                        var info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                        if (i == 20) info = '="' + info + '"';
                        if (i == 8) {
                            info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                            info = profitTypes[info];
                        }
                        tab.rows[j].childNodes[i].innerHTML = info;
                    }
                    tab.rows[j].childNodes[24].remove();
                    tab.rows[j].childNodes[22].remove();
                    tab.rows[j].childNodes[0].remove();
                }

                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";

            tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            real_tab = document.getElementById('table-rmb-footer');
            var tab = real_tab.cloneNode(true);

            for(var j = 0; j < tab.rows.length ; j++)
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                        tab.rows[j].childNodes[i].style.width = '120px';
                        tab.rows[j].childNodes[i].style.height = '30px';
                    }
                    
                    tab.rows[j].childNodes[22].remove();
                    tab.rows[j].childNodes[20].remove();
                }
                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";

            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");
            $('#test').html(tab_text);            
            var filename = $("#select-ship option:selected").text() + '_' + $('#year_list option:selected').val() + '_CTM记录(¥)';
            exportExcel(tab_text, filename, filename);
            
            return 0;
        }
    </script>