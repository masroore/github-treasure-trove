<div id="equipment-list" v-cloak>
    <div class="row">
        <div class="col-lg-7">
            <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名: </label>
            <select class="custom-select d-inline-block" id="select-ship" style="padding: 4px; max-width: 100px;" @change="onChangeShip" v-model="shipId">
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
            <select class="custom-select" v-model="placeType" @change="onChangeYear">
                <option value="0">全部</option>
                <option v-for="(place, place_index) in placeList" v-bind:value="place_index">@{{ place }}</option>
            </select>
            <select class="custom-select" v-model="activeType" @change="onChangeYear">
                <option value="0">全部</option>
                <option v-for="(variety, variety_index) in varietyList" v-bind:value="variety_index">@{{ variety }}</option>
            </select>
            
            <strong style="font-size: 16px; padding-top: 6px; margin-left: 30px;">
                <span id="search_info">{{ $shipName }}</span>&nbsp;<span class="font-bold">@{{ activeYear }}年备件物料</span>
            </strong>
            
        </div>
        <div class="col-lg-5">
            <select class="custom-select" v-model="activeStatus" @change="onChangeYear">
                <option value="0">全部</option>
                <option value="1">未供应</option>
                <option value="2">已供应</option>
            </select>
            <div class="btn-group f-right">
                <button class="btn btn-primary btn-sm search-btn" @click="addRow"><i class="icon-plus"></i>添加</button>
                <button class="btn btn-sm btn-success" @click="submitForm"><i class="icon-save"></i>保存</button>
                <button class="btn btn-warning btn-sm excel-btn" @click="fnExcelRecord"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 4px;">
        <div class="head-fix-div common-list">
            <form action="shipEquipmentList" method="post" id="certList-form" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" value="{{ $shipId }}" name="shipId">
                <input type="hidden" value="record" name="_type">
                <table class="table-striped" id="table-record">
                    <thead class="">
                        <th class="d-none"></th>
                        <th class="text-center">No</th>
                        <th class="text-center" style="width: 74px;">申请日期</th>
                        <th class="text-center style-header" style="width: 60px;">部门</th>
                        <th class="text-center style-header" style="width: 70px;">品种</th>
                        <th class="text-center style-header" style="width: 300px;">项目</th>
                        <th class="text-center style-header" style="width: 100px;">ISSA/Part No</th>
                        <th class="text-center style-header">库存量</th>
                        <th class="text-center style-header">申请量</th>
                        <th class="text-center style-header" style="width: 60px;">单位</th>
                        <th class="text-center style-header" style="width: 74px;">供应日期</th>
                        <th class="text-center style-header">供应量</th>
                        <th class="text-center style-header" style="width: 200px;">备注</th>
                        <th class="text-center style-header"></th>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in list" :class="index % 2 == 0 ? 'even' : 'odd'">
                            <td class="center no-wrap">@{{ index + 1 }}<input type="hidden" name="id[]" v-model="item.id"></td>
                            <td class="center no-wrap">
                                <input class="form-control date-picker text-center" @click="dateModify($event, index, 'request_date')" type="text" data-date-format="yyyy-mm-dd" name="request_date[]" v-model="item.request_date">
                            </td>
                            <td class="center no-wrap">
                                <select class="form-control text-center" v-model="item.place" name="place[]">
                                    <option v-for="(place, place_index) in placeList" v-bind:value="place_index">@{{ place }}</option>
                                </select>
                            </td>
                            <td class="center no-wrap">
                                <select class="form-control text-center" v-model="item.type" name="type[]">
                                    <option v-for="(variety, variety_index) in varietyList" v-bind:value="variety_index">@{{ variety }}</option>
                                </select>
                            </td>
                            <td>
                                <input class="form-control text-left" type="text" v-model="item.item" name="item[]">
                            </td>

                            <td>
                                <input class="form-control text-left" type="text" v-model="item.issa_no" name="issa_no[]">
                            </td>

                            <td>
                                <my-currency-input v-model="item.inventory_vol" class="form-control text-center" name="inventory_vol[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                            </td>
                            <td>
                                <my-currency-input v-model="item.request_vol" class="form-control text-center" name="request_vol[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                            </td>

                            <td class="center no-wrap">
                                <select class="form-control text-center" v-model="item.unit" name="unit[]">
                                    <option v-for="(unit, unit_index) in unitList" v-bind:value="unit_index">@{{ unit }}</option>
                                </select>
                            </td>

                            <td class="text-center">
                                <input class="form-control date-picker text-center" @click="dateModify($event, index, 'supply_date')" type="text" data-date-format="yyyy-mm-dd" name="supply_date[]" v-model="item.supply_date">
                            </td>

                            <td>
                                <my-currency-input v-model="item.supply_vol" class="form-control text-center" name="supply_vol[]" v-bind:prefix="''" v-bind:fixednumber="2" v-bind:index="index"></my-currency-input>
                            </td>

                            <td><input class="form-control text-left" type="text" v-model="item.remark" name="remark[]"></td>


                            <td class="text-center">
                                <div class="action-buttons">
                                    <a class="red" @click="deleteCertItem(item.id, index)">
                                        <i class="icon-trash" style="color: red!important;"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
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
        var activeYear = '{!! $activeYear !!}';
        var isChangeStatus = false;
        var initLoad = true;
        var activeId = 0;

        var submitted = false;
        if(isChangeStatus == false)
            submitted = false;

        $("form").submit(function() {
            submitted = true;
        });

        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.';
            let currentObj = JSON.parse(JSON.stringify($_this.list));

            let currentObjTmp = JSON.parse(JSON.stringify($__this.list));

            if(JSON.stringify(currentObj) == JSON.stringify(equipObjTmp) && JSON.stringify(currentObjTmp) == JSON.stringify(equipRequireObjTmp))
                isChangeStatus = false;
            else
                isChangeStatus = true;   

            if (!submitted && isChangeStatus) {
                (e || window.event).returnValue = confirmationMessage;
            }

            return confirmationMessage;
        });


        function initRecord() {
            // Create Vue Obj
            equipObj = new Vue({
                el: '#equipment-list',
                data: {
                    list: [],

                    placeList: PlaceType,
                    varietyList: VarietyType,
                    unitList: UnitData,

                    shipId:         shipId,
                    activeYear:     activeYear,
                    placeType:      0,
                    activeType:     0,
                    activeStatus:   0,
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
                    setCertInfo: function(index, cert) {
                        var values = $("input[name='cert_id[]']")
                            .map(function(){return parseInt($(this).val());}).get();

                        if(values.includes(cert)) {alert('Can\'t register duplicate certificate.'); return false;}

                        isChangeStatus = true;
                        setCertInfo(cert, index);
                        $(".dynamic-select__trigger").removeClass('open');
                        $(".dynamic-options").removeClass('open');
                    },
                    customFormatter(date) {
                        return moment(date).format('YYYY-MM-DD');
                    },
                    dateModify(e, index, type) {
                        $(e.target).on("change", function() {
                            equipObj.list[index][type] = $(this).val();
                        });
                    },
                    customInput() {
                        return 'form-control';
                    },
                    onFileChange(e) {
                        let index = e.target.getAttribute('data-index');
                        equipObj.cert_array[index]['is_update'] = IS_FILE_UPDATE;
                        equipObj.cert_array[index]['file_name'] = 'updated';
                        isChangeStatus = true;
                        this.$forceUpdate();
                    },
                    openShipCertList(index) {
                        activeId = index;
                        $('.only-modal-show').click();
                    },
                    onChangeShip: function(e) {
                        location.href = '/shipManage/equipment?id=' + e.target.value + '&type=record';
                    },
                    onChangeYear: function(e) {
                        var confirmationMessage = 'It looks like you have been editing something. '
                                + 'If you leave before saving, your changes will be lost.';
                        let currentObj = JSON.parse(JSON.stringify($_this.list));
                        if(JSON.stringify(equipObjTmp) != JSON.stringify(currentObj))
                            isChangeStatus = true;
                        else
                            isChangeStatus = false;

                        if (!submitted && isChangeStatus) {
                            bootbox.confirm(confirmationMessage, function (result) {
                                if (!result) {
                                    return;
                                }
                                else {
                                    getInitInfo();
                                }
                            });
                        } else {
                            getInitInfo();
                        }
                    },
                    getImage: function(file_name) {
                        if(file_name != '' && file_name != undefined)
                            return '/assets/images/document.png';
                        else
                            return '/assets/images/paper-clip.png';
                    },
                    conditionSearch() {
                        getInitInfo();
                    },
                    getToday: function(symbol = '-') {
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = yyyy + symbol + mm + symbol + dd;

                        return today;
                    },
                    submitForm: function() {
                        submitted = true;
                        $('#certList-form').submit();
                    },
                    addRow: function() {
                        let length = $_this.list.length;
                        if(length == 0) {
                            this.list.push([]);
                            this.list[length].request_date = this.getToday();

                            this.list[length].place = 1;
                            this.list[length].type = 1;
                            this.list[length].item = '';
                            this.list[length].issa_no = '';
                            this.list[length].inventory_vol = '';
                            this.list[length].request_vol = '';
                            this.list[length].supply_vol = '';
                            this.list[length].unit = 0;
                            this.list[length].supply_date = this.getToday();
                            this.list[length].remark = '';
                        } else {
                            this.list.push([]);
                            this.list[length].request_date = this.list[length - 1].request_date;
                            this.list[length].place = this.list[length - 1].place;
                            this.list[length].type = this.list[length - 1].type;
                            this.list[length].item = '';
                            this.list[length].issa_no = '';
                            this.list[length].inventory_vol = 0;
                            this.list[length].request_vol = 0;
                            this.list[length].supply_vol = 0;
                            this.list[length].unit = this.list[length - 1].unit;
                            this.list[length].supply_date = this.list[length - 1].supply_date;
                            this.list[length].remark = '';

                        }
                    },
                    deleteCertItem(id, index) {
                        __alertAudio();
                        bootbox.confirm("Are you sure you want to delete?", function (result) {
                            if (result) {
                                if (id != undefined) {
                                    $.ajax({
                                        url: BASE_URL + 'ajax/shipManage/equipment/delete',
                                        type: 'post',
                                        data: {
                                            id: id,
                                        },
                                        success: function (data, status, xhr) {
                                            $_this.list.splice(index, 1);
                                            equipObjTmp = JSON.parse(JSON.stringify($_this.list))
                                        }
                                    })
                                } else {
                                    this.list.splice(index, 1);
                                }
                            }
                        });
                    },
                    fnExcelRecord() {
                        var tab_text = "";
                        tab_text +="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                        real_tab = document.getElementById('table-record');
                        var tab = real_tab.cloneNode(true);
                        tab_text=tab_text+"<tr><td colspan='12' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#search_info').html() + " " + equipObj._data.activeYear + "年备件物料" + "</td></tr>";
                        
                        for(var j = 0; j < tab.rows.length ; j++)
                        {
                            if (j == 0) {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                }
                                tab.rows[j].childNodes[24].remove();
                                tab.rows[j].childNodes[0].remove();
                            }
                            else
                            {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    if (i == 4) {
                                        info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                                        tab.rows[j].childNodes[i].innerHTML = PlaceType[info];
                                    }
                                    else if (i == 6) {
                                        info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                                        tab.rows[j].childNodes[i].innerHTML = VarietyType[info]
                                    }
                                    else if (i == 16) {
                                        info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                                        tab.rows[j].childNodes[i].innerHTML = UnitData[info];
                                    }
                                    else if (i == 0 || i == 22) {

                                    }
                                    else {
                                        var info = real_tab.rows[j].childNodes[i].childNodes[0].value;
                                        tab.rows[j].childNodes[i].innerHTML = info;
                                    }
                                }
                                tab.rows[j].childNodes[24].remove();
                            }
                            
                            
                            tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                        }
                        tab_text=tab_text+"</table>";
                        tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
                        tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
                        tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

                        var filename = $('#search_info').html() + '_' + equipObj._data.activeYear + "年备件物料";
                        exportExcel(tab_text, filename, filename);
                        
                        return 0;
                    }
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
            getInitInfo();

        }

        function getInitInfo() {
            $.ajax({
                url: BASE_URL + 'ajax/shipManage/equipment/list',
                type: 'post',
                data: {
                    shipId: $_this.shipId,
                    year: $_this.activeYear,
                    placeType: $_this.placeType,
                    activeType: $_this.activeType,
                    activeStatus: $_this.activeStatus,
                },
                success: function(data, status, xhr) {
                    $_this.list = data;
                    equipObjTmp = JSON.parse(JSON.stringify($_this.list));
                }
            })
        }

        function addCertItem() {
            let reportLen = equipObj.cert_array.length;
            let newCertId = 0;
            if(reportLen == 0) {
                reportLen = 0;
                newCertId = 0;
            } else {
                newCertId = equipObj.cert_array[reportLen - 1]['cert_id'];
            }

            newCertId = getNearCertId(newCertId);

            if(shipCertTypeList.length <= reportLen && reportLen > 0)
                return false;

            if(newCertId == '') {
                newCertId = getNearCertId(0);
            }

            equipObj.cert_array.push([]);
            equipObj.cert_array[reportLen]['cert_id']  = newCertId;
            equipObj.cert_array[reportLen]['is_tmp']  = 1;
            setCertInfo(newCertId, reportLen);
            equipObj.cert_array[reportLen]['issue_date']  = $($('[name^=issue_date]')[reportLen - 1]).val();
            equipObj.cert_array[reportLen]['expire_date']  = $($('[name^=expire_date]')[reportLen - 1]).val();
            equipObj.cert_array[reportLen]['due_endorse']  = $($('[name^=due_endorse]')[reportLen - 1]).val();
            equipObj.cert_array[reportLen]['issuer']  = 1;
            $($('[name=cert_id]')[reportLen - 1]).focus();
            certIdList.push(equipObj.cert_array[reportLen]['cert_id']);

            $('[date-issue=' + reportLen + ']').datepicker({
                autoclose: true,
            }).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });

            isChangeStatus = true;
        }

        function getNearCertId(cert_id) {
            var values = $("input[name='cert_id[]']")
                .map(function(){return parseInt($(this).val());}).get();
            let tmp = 0;
            tmp = cert_id;
            shipCertTypeList.forEach(function(value, key) {
                if(value['id'] - tmp > 0 && !values.includes(value['id'])) {
                    if(value['id'] - cert_id <= value['id'] - tmp)
                        tmp = value['id'];
                }
            });

            return tmp == cert_id ? 0 : tmp;
        }

        function setCertInfo(certId, index = 0) {
            let status = 0;
            shipCertTypeList.forEach(function(value, key) {
                if(value['id'] == certId) {
                    equipObj.cert_array[index]['order_no'] = value['order_no'];
                    equipObj.cert_array[index]['cert_id'] = certId;
                    equipObj.cert_array[index]['code'] = value['code'];
                    equipObj.cert_array[index]['cert_name'] = value['name'];
                    equipObj.$forceUpdate();
                    status ++;
                }
            });
        }

        $('#select-ship').on('change', function() {
            location.href = "/shipManage/shipCertList?id=" + $(this).val()
        });

        $(document).mouseup(function(e) {
            var container = $(".dynamic-options-scroll");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                $(".dynamic-options").removeClass('open');
                $(".dynamic-options").siblings('.dynamic-select__trigger').removeClass('open')
            }
        });

        $(".ui-draggable").draggable({
            helper: 'move',
            cursor: 'move',
            tolerance: 'fit',
            revert: "invalid",
            revert: false
        });
    </script>