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
                        <b>维修保养</b>
                    </h4>
                </div>
            </div>
            <div class="col-lg-12">
                <div id="data-list" v-cloak>
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
                            <select name="year_list" @change="onChangeYear" v-model="activeYear">
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}年</option>
                                @endforeach
                            </select>
                            <select class="custom-select" @change="onChangeYear" v-model="activeMonth">
                                @for($i = 1; $i <= 12; $i ++)
                                    <option value="{{$i}}">{{ $i }}月</option>
                                @endfor
                            </select>
                            <strong style="font-size: 16px; padding-top: 6px; margin-left: 30px;" class="f-right">
                                <span class="font-bold">@{{ tableTitle }}</span>
                            </strong>
                            
                        </div>
                        <div class="col-lg-5">

                            <div class="btn-group f-right">
                                <button class="btn btn-primary btn-sm search-btn" @click="addRow"><i class="icon-plus"></i>添加</button>
                                <button class="btn btn-sm btn-success" @click="submitForm"><i class="icon-save"></i>保存</button>
                                <button class="btn btn-warning btn-sm excel-btn d-none" @click="fnExcelRecord"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
                            </div>
                            <select class="custom-select f-right" style="margin-right: 10px;" @change="onChangeYear" v-model="activeStatus">
                                <option value="0"></option>
                                <option value="1">未完成</option>
                                <option value="2">已完成</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 4px;">
                        <div class="head-fix-div common-list">
                            <form action="{{ route('repair.update') }}" method="post" enctype="multipart/form-data" id="repair-form">
                                @csrf
                                <input type="hidden" value="{{ $shipId }}" name="ship_id">
                                <input type="hidden" v-model="activeYear" name="year">
                                <input type="hidden" v-model="activeMonth" name="month">
                                <table class="table-striped" id="table-record">
                                    <thead class="">
                                        <th class="d-none"></th>
                                        <th class="text-center" style="width: 4%;">编号</th>
                                        <th class="text-center" style="width: 6%;">申请日期</th>
                                        <th class="text-center style-header" style="width: 6%">部门</th>
                                        <th class="text-center style-header" style="width: 6%;">担任</th>
                                        <th class="text-center style-header" style="width: 8%;">种类</th>
                                        <th class="text-center style-header" style="width: 38%;">工作内容</th>
                                        <th class="text-center style-header text-profit" style="width: 6%;">完成日期</th>
                                        <th class="text-center style-header" style="width: 24%;">备注</th>
                                        <th class="text-center style-header" style="width: 2%;"></th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in list">
                                            <input type="hidden" name="id[]" v-model="item.id">
                                            <td class="center no-wrap">
                                                <input type="text" v-model="item.serial_no" class="form-control" readonly name="serial_no[]">
                                            </td>
                                            <td class="center no-wrap">
                                                <input class="form-control date-picker text-center" @click="dateModify($event, index, 'request_date')" type="text" data-date-format="yyyy-mm-dd" name="request_date[]" v-model="item.request_date">
                                            </td>
                                            <td class="center no-wrap">
                                                <select class="form-control" name="department[]" v-model="item.department">
                                                    <option v-for="(depart, depart_index) in departList" v-bind:value="depart.id">@{{ depart.name }}</option>
                                                </select>
                                            </td>
                                            <td class="center no-wrap">
                                                <select class="form-control" name="charge[]" v-model="item.charge">
                                                    <option v-for="(charge, charge_index) in chargeList" v-bind:value="charge.id">@{{ charge.Abb }}</option>
                                                </select>
                                            </td>
                                            <td class="center no-wrap">
                                                <select class="form-control" name="type[]" v-model="item.type">
                                                    <option v-for="(type, type_index) in typeList" v-bind:value="type.id">@{{ type.name }}</option>
                                                </select>
                                            </td>

                                            <td>
                                                <input class="form-control text-left" type="text" v-model="item.job_description" name="job_description[]" @change="onChangeInput">
                                            </td>

                                            <td class="text-center">
                                                <input class="form-control date-picker text-center text-profit" @click="dateModify($event, index, 'completed_at')" type="text" data-date-format="yyyy-mm-dd" name="completed_at[]" v-model="item.completed_at">
                                            </td>

                                            <td>
                                                <input class="form-control text-left" type="text" v-model="item.remark" name="remark[]" @change="onChangeInput">
                                            </td>

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
            </div>
        </div>
    </div>

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>
    <script src="{{ cAsset('assets/js/sprintf.min.js') }}"></script>

	<?php
	echo '<script>';
    echo 'var PlaceType = ' . json_encode(g_enum('PlaceType')) . ';';
    echo 'var VarietyType = ' . json_encode(g_enum('VarietyType')) . ';';
    echo 'var UnitData = ' . json_encode(g_enum('UnitData')) . ';';
    echo 'var DepartList = ' . json_encode($departList) . ';';
    echo 'var TypeList = ' . json_encode($typeList) . ';';
    echo 'var ChargeList = ' . json_encode($chargeList) . ';';
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
        var activeYear = '{!! $activeYear !!}';
        var initLoad = true;
        var isChangeStatus = false;

        $(function () {
            initialize();
        });


        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.';

            if (isChangeStatus) {
                (e || window.event).returnValue = confirmationMessage;
            }

            return confirmationMessage;
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

        function initialize() {
            initRecord();
        }

        function initRecord() {
            // Create Vue Obj
            equipObj = new Vue({
                el: '#data-list',
                data: {
                    list                : [],
                    typeList            : TypeList,
                    departList          : DepartList,
                    chargeList          : ChargeList,

                    shipId              : shipId,
                    shipName            : '{{ $shipName }}',
                    activeYear          : activeYear,
                    activeMonth         : '{{ $activeMonth }}',
                    activeStatus        : '{{ REPAIR_STATUS_ALL }}',
                    tableTitle          : '',
                },
                methods: {
                    customFormatter(date) {
                        return moment(date).format('YYYY-MM-DD');
                    },
                    dateModify(e, index, type) {
                        $(e.target).on("change", function() {
                            isChangeStatus = true;
                            // equipObj.list[index][type] = moment($(this).val()).format("YY-MM-DD");
                            equipObj.list[index][type] = $(this).val();
                        });
                    },
                    onChangeShip: function(e) {
                        location.href = '/repair/register?id=' + e.target.value;
                    },
                    onChangeYear: function(e) {
                        var confirmationMessage = 'It looks like you have been editing something. '
                                + 'If you leave before saving, your changes will be lost.';

                        if (isChangeStatus) {
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
                    onChangeInput: function() {
                        isChangeStatus = true;
                    },
                    getImage: function(file_name) {
                        if(file_name != '' && file_name != undefined)
                            return '/assets/images/document.png';
                        else
                            return '/assets/images/paper-clip.png';
                    },
                    getToday: function(symbol = '-') {
                        var today = new Date();
                        var dd = String(today.getDate()).padStart(2, '0');
                        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                        var yyyy = today.getFullYear();
                        today = yyyy + symbol + mm + symbol + dd;

                        return this.customFormatter(today);
                    },
                    submitForm: function() {
                        isChangeStatus = false;
                        let validate = this.validateForm();
                        if(validate == false) {
                            alert('请您必须填数据.');
                            return false;
                        }

                        $('#repair-form').submit();
                    },
                    validateForm: function() {
                        let retVal = true;
                        this.list.forEach(function(value, key) {
                            if(value['request_date'] == '' ||
                                value['department'] == 0 ||
                                value['charge'] == 0 ||
                                value['type'] == 0||
                                value['job_description'] == '')
                                retVal = false;
                        });

                        return retVal;
                    },
                    addRow: function() {
                        let length = $_this.list.length;
                        isChangeStatus = true;
                        if(length == 0) {
                            this.list.push([]);
                            this.list[length].request_date = this.getToday('-');
                            this.list[length].department = 1;
                            this.list[length].charge = 1;
                            this.list[length].type = 1;
                            this.list[length].job_description = '';
                            this.list[length].completed_at = '';
                            this.list[length].remark = '';
                        } else {
                            this.list.push([]);
                            this.list[length].request_date = this.list[length - 1].request_date;
                            this.list[length].department = this.list[length - 1].department;
                            this.list[length].charge = this.list[length - 1].charge;
                            this.list[length].type = this.list[length - 1].type;
                            this.list[length].job_description = '';
                            this.list[length].completed_at = this.list[length - 1].completed_at;
                            this.list[length].remark = '';
                        }

                        this.processSN();
                    },
                    deleteCertItem(id, index) {
                        __alertAudio();
                        bootbox.confirm("Are you sure you want to delete?", function (result) {
                            if (result) {
                                if (id != undefined) {
                                    $.ajax({
                                        url: BASE_URL + 'ajax/repair/delete',
                                        type: 'post',
                                        data: {
                                            id: id,
                                        },
                                        success: function (data, status, xhr) {
                                            $_this.list.splice(index, 1);
                                            $_this.processSN();
                                        }
                                    })
                                } else {
                                    $_this.list.splice(index, 1);
                                    $_this.processSN();
                                }
                            }
                        });
                    },
                    processSN() {
                        $_this.list.forEach(function(value, key) {
                            $_this.list[key]['serial_no'] = sprintf('%02d', $_this.activeMonth) + sprintf('%03d', key + 1)
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

                    offAutoCmplt();
                }
            });

            $_this = equipObj;
            getInitInfo();

        }

        function getInitInfo() {
            $.ajax({
                url: BASE_URL + 'ajax/repair/list',
                type: 'post',
                data: {
                    ship_id: $_this.shipId,
                    year: $_this.activeYear,
                    month: $_this.activeMonth,
                    status: $_this.activeStatus,
                },
                success: function(data, status, xhr) {
                    $_this.list = data;
                    $_this.list.forEach(function(value, key) {
                        // $_this.list[key]['request_date'] = $_this.customFormatter(value['request_date']);
                        // $_this.list[key]['completed_at'] = $_this.customFormatter(value['completed_at']);
                    })
                    $_this.tableTitle = $_this.shipName + ' ' + $_this.activeYear + '年' + $_this.activeMonth + '月维修保养';
                }
            })
        }

    </script>
@endsection