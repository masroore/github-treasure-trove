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
        <style>
            .filter_row {
                background-color: #45f7ef;
            }
            .chosen-drop {
                width : 350px !important;
            }
        </style>
        <div class="page-content">
            <div class="page-header">
                <div class="col-md-3">
                    <h4>
                        <b>船舶证书记录</b>
                    </h4>
                </div>

            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-6">
                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名: </label>
                        <select class="custom-select d-inline-block" id="select-ship" style="padding: 4px; max-width: 100px;">
                            @foreach($shipList as $ship)
                                <option value="{{ $ship['IMO_No'] }}"
                                    {{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}
                                </option>
                            @endforeach
                        </select>
                        @if(isset($shipName['shipName_En']))
                            <strong class="f-right" style="font-size: 16px; padding-top: 6px;">"<span id="ship_name">{{ $shipName['shipName_En'] }}</span>" CERTIFICATES</strong>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <div class="btn-group f-right">
                            <button class="btn btn-primary btn-sm search-btn" onclick="addCertItem()"><i class="icon-plus"></i>添加</button>
                            <button class="btn btn-warning btn-sm excel-btn d-none"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
                            <a href="#modal-wizard" class="only-modal-show d-none" role="button" data-toggle="modal"></a>
                            @if(!$isHolder)
                                <button class="btn btn-sm btn-success" id="submit">
                                    <i class="icon-save"></i>保存
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 4px;">
                    <div class="head-fix-div common-list">
                        <form action="shipCertList" method="post" id="certList-form" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" value="{{ $shipId }}" name="ship_id">
                            <table>
                                <thead class="">
                                <th class="d-none"></th>
                                <th class="text-center style-header" style="width:60px;word-break: break-all;">{!! trans("shipManage.shipCertlist.No") !!}</th>
                                <th class="text-center style-header" style="width:60px;word-break: break-all;">{{ trans("shipManage.shipCertlist.Code") }}</th>
                                <th class="text-center style-header" style="width:280px;word-break: break-all;">{{ trans('shipManage.shipCertlist.name of certificates') }}</th>
                                <th class="text-center style-header" style="width:120px;word-break: break-all;">{{ trans('shipManage.shipCertlist.issue_date') }}</th>
                                <th class="text-center style-header" style="width:120px;word-break: break-all;">{{ trans('shipManage.shipCertlist.expire_date') }}</th>
                                <th class="text-center style-header" style="width:120px;word-break: break-all;">{!! trans('shipManage.shipCertlist.due_endorse') !!}</th>
                                <th class="text-center style-header" style="width:80px;word-break: break-all;">{{ trans('shipManage.shipCertlist.issuer') }}</th>
                                <th class="text-center style-header" style="width:40px;word-break: break-all;"><img src="{{ cAsset('assets/images/paper-clip.png') }}" width="15" height="15"></th>
                                <th class="text-center style-header" style="width:200px;word-break: break-all;">{{ trans('shipManage.shipCertlist.remark') }}</th>
                                <th class="text-center style-header" style="width:20px;word-break: break-all;"></th>
                                </thead>
                                <tbody id="cert_list" v-cloak>
                                <tr v-for="(item, array_index) in cert_array">
                                    <td class="d-none"><input type="hidden" name="id[]" v-model="item.id"></td>
                                    <td class="center no-wrap" v-bind:data-action="array_index">@{{ item.order_no }}</td>
                                    <td class="center no-wrap" v-bind:data-code="array_index">@{{ item.code }}</td>
                                    <td>
                                        <div class="dynamic-select-wrapper" v-bind:data-index="array_index" v-bind:cert-index="item.cert_id" @click="certTypeChange">
                                            <div class="dynamic-select" style="color:#12539b">
                                                <input type="hidden"  name="cert_id[]" v-model="item.cert_id" v-bind:data-main-value="array_index"/>
                                                <div class="dynamic-select__trigger dynamic-arrow">@{{ item.cert_name }}</div>
                                                <div class="dynamic-options" style="margin-top: -17px;">
                                                    <div class="dynamic-options-scroll">
                                                        <span v-for="(certItem, index) in certTypeList" v-bind:class="[item.cert_id == certItem.id ? 'dynamic-option  selected' : 'dynamic-option ']" @click="setCertInfo(array_index, certItem.id)">@{{ certItem.name }}</span>
                                                    </div>
                                                    <div>
                                                    <span class="edit-list-btn" id="edit-list-btn" @click="openshipCertlist(array_index)">
                                                        <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items" style="width: 36px; height: 36px; min-width: 36px; min-height: 36px;">
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-control date-picker text-center" @click="dateModify($event, array_index, 'issue_date')" v-bind:date-issue="array_index" type="text" data-date-format="yyyy-mm-dd" name="issue_date[]" v-model="item.issue_date">
                                    </td>
                                    <td class="center">
                                        <input class="form-control date-picker text-center" @click="dateModify($event, array_index, 'expire_date')" v-bind:date-issue="array_index" type="text" data-date-format="yyyy-mm-dd" name="expire_date[]" v-model="item.expire_date">
                                    </td>
                                    <td class="center">
                                        <input class="form-control date-picker text-center" @click="dateModify($event, array_index, 'due_endorse')" v-bind:date-issue="array_index" type="text" data-date-format="yyyy-mm-dd" name="due_endorse[]" v-model="item.due_endorse">
                                    </td>
                                    <td class="center">
                                        <select class="form-control text-center" v-model="item.issuer" name="issuer[]">
                                            <option v-for="(issuer, index) in issuer_type" v-bind:value="index">@{{ issuer }}</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <label v-bind:for="array_index"><img v-bind:src="getImage(item.file_name)" width="15" height="15" style="cursor: pointer;" v-bind:title="item.file_name"></label>
                                        <input type="file" name="attachment[]" v-bind:id="array_index" class="d-none" @change="onFileChange" v-bind:data-index="array_index" accept=".pdf">
                                        <input type="hidden" name="is_update[]" v-bind:id="array_index" class="d-none" v-bind:value="item.is_update">
                                        <img v-bind:src="getClose()" width="10" height="10" style="cursor: pointer;" v-show="item.file_name != '' && item.file_name != undefined" @click="removeFile(array_index)">
                                    </td>
                                    <td><input class="form-control text-left" type="text" v-model="item.remark" name="remark[]"></td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a class="red" @click="deleteCertItem(item.id, item.is_tmp, array_index)">
                                                <i class="icon-trash" style="color: red!important;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
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
                                        <form action="shipCertType" method="post" id="shipCertForm">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <div class="head-fix-div" style="height:300px;">
                                                <table class="table-bordered rank-table">
                                                    <thead>
                                                    <tr class="rank-tr" style="background-color: #d9f8fb;height:18px;">
                                                        <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:20%">OrderNo</th>
                                                        <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:20%">Code</th>
                                                        <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:50%">Name</th>
                                                        <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="rank-table">
                                                    <tr class="no-padding center" v-for="(typeItem, index) in list">
                                                        <td class="d-none">
                                                            <input type="hidden" name="id[]" v-model="typeItem.id">
                                                        </td>
                                                        <td class="no-padding center">
                                                            <input type="text" @focus="addNewRow(this)" class="form-control" name="order_no[]" v-model="typeItem.order_no" style="width: 100%;text-align: center" autocomplete="off">
                                                        </td>
                                                        <td class="no-padding">
                                                            <input type="text" class="form-control" name="code[]" v-model="typeItem.code" style="width: 100%;text-align: center" autocomplete="off">
                                                        </td>
                                                        <td class="no-padding center">
                                                            <input type="text" class="form-control" name="name[]" v-model="typeItem.name" style="width: 100%;text-align: center" autocomplete="off">
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

	<?php
	echo '<script>';
	echo 'var IssuerTypeData = ' . json_encode(g_enum('IssuerTypeData')) . ';';
	echo '</script>';
	?>
    <script>
        var certListObj = null;
        var certTypeObj = null;
        var shipCertTypeList = [];
        var shipCertlistTmp = new Array();
        var certIdList = [];
        var certIdListTmp = [];
        var IS_FILE_KEEP = '{!! IS_FILE_KEEP !!}';
        var IS_FILE_DELETE = '{!! IS_FILE_DELETE !!}';
        var IS_FILE_UPDATE = '{!! IS_FILE_UPDATE !!}';
        var ship_id = '{!! $shipId !!}';
        var isChangeStatus = false;
        var initLoad = true;
        var activeId = 0;

        var submitted = false;
        if(isChangeStatus == false)
            submitted = false;

        $("form").submit(function() {
            submitted = true;
        });

        var $form = $('form'),
            origForm = $form.serialize();
        window.addEventListener("beforeunload", function (e) {
            var confirmationMessage = 'It looks like you have been editing something. '
                + 'If you leave before saving, your changes will be lost.';
            let currentObj = JSON.parse(JSON.stringify(certListObj.cert_array));
            if(JSON.stringify(currentObj) == JSON.stringify(shipCertlistTmp))
                isChangeStatus = false;
            else
                isChangeStatus = true;

            if ($form.serialize() !== origForm && !submitted && isChangeStatus) {
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });
        $(function () {
            // Initialize
            initialize();

        });


        function initialize() {
            // Create Vue Obj
            certListObj = new Vue({
                el: '#cert_list',
                data() { return {
                    cert_array: [],
                    certListTmp: [],
                    certTypeList: [],
                    zh: vdp_translation_zh.js,
                    issuer_type: IssuerTypeData
                }
                },
                components: {
                    vuejsDatepicker
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

                            let height = $(event.target).siblings(".dynamic-options").height();
                            let windowHeight = $(window).height();

                            let element = event.target;
                            let boundRect = element.getBoundingClientRect();
                            
                            if(windowHeight - boundRect.top <= height) {
                                $(event.target).siblings(".dynamic-options").addClass('dynamic-popup-reverse');
                            } else {
                                $(event.target).siblings(".dynamic-options").removeClass('dynamic-popup-reverse');
                            }
                        }
                    },
                    setCertInfo: function(array_index, cert) {
                        var values = $("input[name='cert_id[]']")
                            .map(function(){return parseInt($(this).val());}).get();

                        if(values.includes(cert)) {alert('Can\'t register duplicate certificate.'); return false;}

                        isChangeStatus = true;
                        setCertInfo(cert, array_index);
                        $(".dynamic-select__trigger").removeClass('open');
                        $(".dynamic-options").removeClass('open');
                    },
                    customFormatter(date) {
                        return moment(date).format('YYYY-MM-DD');
                    },
                    dateModify(e, index, type) {
                        $(e.target).on("change", function() {
                            certListObj.cert_array[index][type] = $(this).val();
                        });
                    },
                    customInput() {
                        return 'form-control';
                    },
                    onFileChange(e) {
                        let index = e.target.getAttribute('data-index');
                        certListObj.cert_array[index]['is_update'] = IS_FILE_UPDATE;
                        certListObj.cert_array[index]['file_name'] = 'updated';
                        isChangeStatus = true;
                        this.$forceUpdate();
                    },
                    openshipCertlist(index) {
                        activeId = index;
                        // Object.assign(certTypeObj.list, shipCertTypeList);
                        // certTypeObj.list.push([]);
                        $('.only-modal-show').click();
                    },
                    getImage: function(file_name) {
                        if(file_name != '' && file_name != undefined)
                            return '/assets/images/document.png';
                        else
                            return '/assets/images/paper-clip.png';
                    },
                    getClose: function() {
                        return '/assets/images/cancel.png';
                    },
                    removeFile(index) {
                        certListObj.cert_array[index]['is_update'] = IS_FILE_DELETE;
                        certListObj.cert_array[index]['file_name'] = '';
                        this.$forceUpdate();
                    },
                    deleteCertItem(cert_id, is_tmp, array_index) {
                        document.getElementById('warning-audio').play();
                        if (is_tmp == 0) {
                            bootbox.confirm("Are you sure you want to delete?", function (result) {
                                if (result) {
                                    $.ajax({
                                        url: BASE_URL + 'ajax/shipManage/shipCert/delete',
                                        type: 'post',
                                        data: {
                                            id: cert_id,
                                        },
                                        success: function (data, status, xhr) {
                                            certListObj.cert_array.splice(array_index, 1);
                                        }
                                    })
                                }
                            });
                        } else {
                            bootbox.confirm("Are you sure you want to delete?", function (result) {
                                if (result) {
                                    certListObj.cert_array.splice(array_index, 1);
                                }
                            });
                        }
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

            certTypeObj = new Vue({
                el: '#modal-cert-type',
                data() {
                    return {
                        list: [],
                    }
                },
                methods: {
                    deleteShipCert(index) {
                        if(index == undefined || index == '')
                            return false;

                        bootbox.confirm("Are you sure you want to delete?", function (result) {
                            if (result) {
                                isChangeStatus = true;
                                $.ajax({
                                    url: BASE_URL + 'ajax/shipManage/cert/delete',
                                    type: 'post',
                                    data: {
                                        id: index
                                    },
                                    success: function(data) {
                                        if (data == 0) {
                                            alert("It cannot be deleted because the related data remains!");
                                        }
                                        else {
                                            certTypeObj.list = Object.assign([], [], data);
                                        }
                                    }
                                })
                            }});
                    },
                    ajaxFormSubmit() {
                        let form = $('#shipCertForm').serialize();
                        $.post('shipCertType', form).done(function (data) {
                            let result = data;
                            let result1 = data;
                            let result2 = data;
                            certTypeObj.list = Object.assign([], [], result);
                            
                            certListObj.certTypeList = Object.assign([], [], result);
                            shipCertTypeList = Object.assign([], [], result);
                            certListObj.$forceUpdate();
                            certTypeObj.list.forEach(function(value) {
                                if(value.id == certListObj.cert_array[activeId].cert_id)
                                    certListObj.cert_array[activeId].cert_name = value.name;
                            })
                            // getShipInfo(ship_id);
                            $('.close').click();
                        });
                    },
                    addNewRow(e) {
                        isChangeStatus = true;
                        certTypeObj.list.push([]);
                    }
                }
            });

            getShipInfo(ship_id);

        }

        function getShipInfo(ship_id) {
            $.ajax({
                url: BASE_URL + 'ajax/shipManage/cert/list',
                type: 'post',
                data: {
                    ship_id: ship_id
                },
                success: function(data, status, xhr) {
                    let ship_id = data['ship_id'];
                    let ship_name = data['ship_name'];
                    let typeList = data['cert_type'];
                    shipCertTypeList = data['cert_type'];

                    $('[name=ship_id]').val(ship_id);
                    $('#ship_name').text(ship_name);
                    certListObj.cert_array = [];
                    Object.assign(certListObj.cert_array, data['ship']);
                    certListObj.certTypeList = typeList;

                    Object.assign(certTypeObj.list, shipCertTypeList);
                    certTypeObj.list.push([]);
                    certIdList = [];
                    certListObj.cert_array.forEach(function(value, index) {
                        certIdList.push(value['cert_id']);
                        certListObj.cert_array[index]['is_update'] = IS_FILE_KEEP;
                        certListObj.cert_array[index]['is_tmp'] = 0;
                        setCertInfo(value['cert_id'], index);
                    });

                    shipCertlistTmp = JSON.parse(JSON.stringify(certListObj.cert_array));
                }
            })
        }

        function addCertItem() {
            let reportLen = certListObj.cert_array.length;
            let newCertId = 0;
            if(reportLen == 0) {
                reportLen = 0;
                newCertId = 0;
            } else {
                newCertId = certListObj.cert_array[reportLen - 1]['cert_id'];
            }

            newCertId = getNearCertId(newCertId);

            if(shipCertTypeList.length <= reportLen && reportLen > 0)
                return false;

            if(newCertId == '') {
                newCertId = getNearCertId(0);
            }

            certListObj.cert_array.push([]);
            certListObj.cert_array[reportLen]['cert_id']  = newCertId;
            certListObj.cert_array[reportLen]['is_tmp']  = 1;
            setCertInfo(newCertId, reportLen);
            certListObj.cert_array[reportLen]['issue_date']  = $($('[name^=issue_date]')[reportLen - 1]).val();
            certListObj.cert_array[reportLen]['expire_date']  = $($('[name^=expire_date]')[reportLen - 1]).val();
            certListObj.cert_array[reportLen]['due_endorse']  = $($('[name^=due_endorse]')[reportLen - 1]).val();
            certListObj.cert_array[reportLen]['issuer']  = 1;
            $($('[name=cert_id]')[reportLen - 1]).focus();
            certIdList.push(certListObj.cert_array[reportLen]['cert_id']);

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
                    certListObj.cert_array[index]['order_no'] = value['order_no'];
                    certListObj.cert_array[index]['cert_id'] = certId;
                    certListObj.cert_array[index]['code'] = value['code'];
                    certListObj.cert_array[index]['cert_name'] = value['name'];
                    certListObj.$forceUpdate();
                    status ++;
                }
            });
        }

        $('#select-ship').on('change', function() {
            location.href = "/shipManage/shipCertList?id=" + $(this).val()
        });

        $('#submit').on('click', function() {
            $('#certList-form').submit();
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
@endsection