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
            .auto-area {
                resize: none;
                height: 20px!important;
            }

            table tbody tr td {
                padding:0px!important;
            }
        </style>
        <div class="page-content">
            <div class="page-header">
                <div class="col-md-3">
                    <h4>
                        <b>设备清单</b>
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
                        <select name="select-year" id="select-year" style="font-size:13px">
                            @for($i=date("Y");$i>=$start_year;$i--)
                            <option value="{{$i}}" @if($year==$i) selected @endif>{{$i}}年</option>
                            @endfor
                        </select>
                        @if(isset($shipName['shipName_En']))
                            <strong class="f-right" style="font-size: 16px; padding-top: 6px;">"<span id="ship_name">{{ $shipName['shipName_En'] }}</span>" <span id="title_year"></span>设备清单</strong>
                        @endif
                    </div>
                    <div class="col-lg-6">
                        <div class="btn-group f-right">
                            <button class="btn btn-primary btn-sm search-btn" onclick="addMaterialItem()"><i class="icon-plus"></i>添加</button>
                            <button class="btn btn-warning btn-sm excel-btn d-none"><i class="icon-table"></i><b>{{ trans('common.label.excel') }}</b></button>
                            <a href="#modal-wizard-category" class="only-modal-category-show d-none" role="button" data-toggle="modal"></a>
                            <a href="#modal-wizard" class="only-modal-show d-none" role="button" data-toggle="modal"></a>
                            @if(!$isHolder)
                                <button class="btn btn-sm btn-success" id="submit">
                                    <i class="icon-save"></i>保存
                                </button>
                            @endif
                            <button class="btn btn-purple btn-sm search-btn" onclick="importPastYearData()" title="导入去年的设备资料"><i class="icon-pencil"></i>导入</button>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 4px;">
                    <div class="head-fix-div common-list">
                        <form action="shipMaterialList" method="post" id="materialList-form" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" value="{{ $shipId }}" name="ship_id">
                            <input type="hidden" value="{{ $year }}" name="select_year">
                            <table>
                                <thead class="">
                                <th class="d-none"></th>
                                <th class="text-center style-header" style="width:3%;word-break: break-all;">No</th>
                                <th class="text-center style-header" style="width:5%;word-break: break-all;">部门<br /><span style="display: block;margin: 3px 0px -3px 0px;"> DPT</span></th>
                                <th class="text-center style-header" style="width:8%;word-break: break-all;">种类<br /><span style="display: block;margin: 3px 0px -3px 0px;"> Kinds</span></th>
                                <th class="text-center style-header" style="width:15%;word-break: break-all;">设备名称<br /><span style="display: block;margin: 3px 0px -3px 0px;"> Equip.Name</span></th>
                                <th class="text-center style-header" style="width:4%;word-break: break-all;">台数<br /><span style="display: block;margin: 3px 0px -3px 0px;"> Qty</span></th>
                                <th class="text-center style-header" style="width:10%;word-break: break-all;">型号<br /><span style="display: block;margin: 3px 0px -3px 0px;"> Model & Mark</span></th>
                                <th class="text-center style-header" style="width:6%;word-break: break-all;">编号<br /><span style="display: block;margin: 3px 0px -3px 0px;"> S/N</span></th>
                                <th class="text-center style-header" style="width:15%;word-break: break-all;">技术参数<br /><span style="display: block;margin: 3px 0px -3px 0px;"> Particular</span></th>
                                <th class="text-center style-header" style="width:10%;word-break: break-all;">制造厂<br /><span style="display: block;margin: 3px 0px -3px 0px;"> Manufacturer</span></th>
                                <th class="text-center style-header" style="width:6%;word-break: break-all;">生产年月<br /><span style="display: block;margin: 3px 0px -3px 0px;"> Blt Year</span></th>
                                <th class="text-center style-header" style="word-break: break-all;">备注<br /><span style="display: block;margin: 3px 0px -3px 0px;"> Remark</span></th>
                                <th class="text-center style-header" style="width:2%;word-break: break-all;"></th>
                                </thead>
                                <tbody id="material_list" v-cloak>
                                <tr v-for="(item, array_index) in material_array">
                                    <td class="d-none"><input type="hidden" name="id[]" v-model="item.id"></td>
                                    <td class="center no-wrap" v-bind:data-action="array_index">@{{ array_index + 1 }}</td>
                                    <td>
                                        <div class="dynamic-select-wrapper" v-bind:data-index="array_index" v-bind:material-index="item.category_id" @click="materialCategoryChange">
                                            <div class="dynamic-select" style="">
                                                <input type="hidden"  name="category_id[]" v-model="item.category_id" v-bind:data-main-value="array_index"/>
                                                <div class="dynamic-select__trigger dynamic-arrow">@{{ item.category_name }}</div>
                                                <div class="dynamic-options" style="margin-top: -17px;">
                                                    <div class="dynamic-options-scroll" style="width:70%">
                                                        <span v-for="(category_Item, index) in materialCategoryList" v-bind:class="[item.category_id == category_Item.id ? 'dynamic-option selected' : 'dynamic-option ']" @click="setMaterialInfo(array_index, category_Item.id, item.category_id)">@{{ category_Item.name }}</span>
                                                    </div>
                                                    <div>
                                                    <span class="edit-list-btn" id="edit-list-btn" @click="openshipMaterialCategorylist(array_index)">
                                                        <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items" style="width: 36px; height: 36px; min-width: 36px; min-height: 36px;">
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dynamic-select-wrapper" v-bind:data-index="array_index" v-bind:material-index="item.type_id" @click="materialTypeChange">
                                            <div class="dynamic-select" style="">
                                                <input type="hidden"  name="type_id[]" v-model="item.type_id" v-bind:data-main-value="array_index"/>
                                                <div class="dynamic-select__trigger dynamic-arrow">@{{ item.type_name }}</div>
                                                <div class="dynamic-options" style="margin-top: -17px;">
                                                    <div class="dynamic-options-scroll" style="width:70%">
                                                        <span v-for="(type_Item, index) in materialTypeList" v-bind:class="[item.type_id == type_Item.id ? 'dynamic-option selected' : 'dynamic-option ']" @click="setMaterialTypeInfo(array_index, item.category_id, type_Item.id)">@{{ type_Item.name }}</span>
                                                    </div>
                                                    <div>
                                                    <span class="edit-list-btn" id="edit-list-btn" @click="openshipMateriallist(array_index)">
                                                        <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items" style="width: 36px; height: 36px; min-width: 36px; min-height: 36px;">
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><textarea class="form-control text-left auto-area" type="text" v-model="item.name" name="name[]" @keyup="textareaChange" required></textarea></td>
                                    <td><input class="form-control text-center" type="text" v-model="item.qty" name="qty[]" maxlength="3" required></td>
                                    <td><textarea class="form-control text-left auto-area" type="text" v-model="item.model_mark" name="model_mark[]" @keyup="textareaChange"></textarea></td>
                                    <td><textarea class="form-control text-left auto-area" type="text" v-model="item.sn" name="sn[]" @keyup="textareaChange"></textarea></td>
                                    <td><textarea class="form-control text-left auto-area" type="text" v-model="item.particular" name="particular[]" rows="1" @focus="particularFocus" @keyup="particularChange"></textarea></td>
                                    <td><textarea class="form-control text-left auto-area" type="text" v-model="item.manufacturer" name="manufacturer[]" @keyup="textareaChange"></textarea></td>
                                    <td><input class="form-control text-center" type="text" v-model="item.blt_year" name="blt_year[]"></td>
                                    <td><textarea class="form-control text-left auto-area" type="text" v-model="item.remark" name="remark[]" @keyup="textareaChange"></textarea></td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <a class="red" @click="deleteMaterialItem(item.id, item.is_tmp, array_index)">
                                                <i class="icon-trash" style="color: red!important;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>

                    <div id="modal-wizard-category" class="modal modal-draggable" aria-hidden="true" style="display: none; margin-top: 15%;">
                        <div class="dynamic-modal-dialog">
                            <div class="dynamic-modal-content" style="border: 0;">
                                <div class="dynamic-modal-header" data-target="#modal-category-contents">
                                    <div class="table-header">
                                        <button type="button"  style="margin-top: 8px; margin-right: 12px;" class="close" data-dismiss="modal" aria-hidden="true">
                                            <span class="white">&times;</span>
                                        </button>
                                        设备部门登记
                                    </div>
                                </div>
                                <div id="modal-material-category" class="dynamic-modal-body step-content">
                                    <div class="row">
                                        <form action="shipMaterialType" method="post" id="shipMaterialCategoryForm">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <div class="head-fix-div" style="height:300px;">
                                                <table class="table-bordered rank-table">
                                                    <thead>
                                                    <tr class="rank-tr" style="background-color: #d9f8fb;height:18px;">
                                                        <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:20%">OrderNo</th>
                                                        <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:50%">Name</th>
                                                        <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;"></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="rank-table">
                                                    <tr class="no-padding center" v-for="(categoryItem, index) in list">
                                                        <td class="d-none">
                                                            <input type="hidden" name="id[]" v-model="categoryItem.id">
                                                        </td>
                                                        <td class="no-padding center">
                                                            <input type="text" @focus="addNewRow(this)" class="form-control" name="order_no[]" v-model="categoryItem.order_no" style="width: 100%;text-align: center" autocomplete="off">
                                                        </td>
                                                        <td class="no-padding center">
                                                            <input type="text" class="form-control" name="name[]" v-model="categoryItem.name" style="width: 100%;text-align: center" autocomplete="off">
                                                        </td>
                                                        <td class="no-padding center">
                                                            <div class="action-buttons">
                                                                <a class="red" @click="deleteShipMaterial(categoryItem.id)"><i class="icon-trash"></i></a>
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

                    <div id="modal-wizard" class="modal modal-draggable" aria-hidden="true" style="display: none; margin-top: 15%;">
                        <div class="dynamic-modal-dialog">
                            <div class="dynamic-modal-content" style="border: 0;">
                                <div class="dynamic-modal-header" data-target="#modal-step-contents">
                                    <div class="table-header">
                                        <button type="button"  style="margin-top: 8px; margin-right: 12px;" class="close" data-dismiss="modal" aria-hidden="true">
                                            <span class="white">&times;</span>
                                        </button>
                                        设备种类登记
                                    </div>
                                </div>
                                <div id="modal-material-type" class="dynamic-modal-body step-content">
                                    <div class="row">
                                        <form action="shipMaterialType" method="post" id="shipMaterialForm">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <div class="head-fix-div" style="height:300px;">
                                                <table class="table-bordered rank-table">
                                                    <thead>
                                                    <tr class="rank-tr" style="background-color: #d9f8fb;height:18px;">
                                                        <th class="text-center sub-header style-bold-italic" style="background-color: #d9f8fb;width:20%">OrderNo</th>
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
                                                        <td class="no-padding center">
                                                            <input type="text" class="form-control" name="name[]" v-model="typeItem.name" style="width: 100%;text-align: center" autocomplete="off">
                                                        </td>
                                                        <td class="no-padding center">
                                                            <div class="action-buttons">
                                                                <a class="red" @click="deleteShipMaterial(typeItem.id)"><i class="icon-trash"></i></a>
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
        var materialListObj = null;
        var materialTypeObj = null;
        var shipMaterialCategoryList = [];
        var shipMaterialTypeList = [];
        var shipMateriallistTmp = new Array();
        var materialIdList = [];
        var materialIdListTmp = [];
        var IS_FILE_KEEP = '{!! IS_FILE_KEEP !!}';
        var IS_FILE_DELETE = '{!! IS_FILE_DELETE !!}';
        var IS_FILE_UPDATE = '{!! IS_FILE_UPDATE !!}';
        var ship_id = '{!! $shipId !!}';
        var select_year = $("#select-year").val();
        var isChangeStatus = false;
        var initLoad = true;
        var activeId = 0;
        var activeId_Category = 0;

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
            let currentObj = JSON.parse(JSON.stringify(materialListObj.material_array));
            if(JSON.stringify(currentObj) == JSON.stringify(shipMateriallistTmp))
                isChangeStatus = false;
            else
                isChangeStatus = true;

            if ($form.serialize() !== origForm && !submitted && isChangeStatus) {
                (e || window.event).returnValue = confirmationMessage;
            }
            return confirmationMessage;
        });

        $(function () {
            initialize();
        });

        function initialize() {
            materialListObj = new Vue({
                el: '#material_list',
                data() { return {
                    material_array: [],
                    materialListTmp: [],
                    materialCategoryList: [],
                    materialTypeList: [],
                    zh: vdp_translation_zh.js,
                    issuer_type: IssuerTypeData
                }
                },
                components: {
                    vuejsDatepicker
                },
                methods: {
                    materialTypeChange: function(event) {
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
                    materialCategoryChange: function(event) {
                        let hasClass = $(event.target).hasClass('open');
                        
                        if($(event.target).hasClass('open')) {
                            $(event.target).removeClass('open');
                            $(event.target).siblings(".dynamic-options").removeClass('open');
                            //$(event.target).siblings(".dynamic-options").removeClass('dynamic-popup-reverse');
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
                    particularFocus: function(event) {
                        if(event.target.value === ''){
                            event.target.value += '◦ ';
                        }
                    },
                    textareaChange: function(event) {
                        let item = event.target;
                        item.style.setProperty("height", item.scrollHeight + 'px', "important");
                    },
                    particularChange: function(event) {
                        var keycode = (event.keyCode ? event.keyCode : event.which);
                        if(keycode == 13) {
                            var text = $(event.target).val();
                            event.target.value += '◦ ';
                        }
                        let item = event.target;
                        item.style.setProperty("height", item.scrollHeight + 'px', "important");
                    },
                    setMaterialInfo: function(array_index, category_id, type_id) {
                        setMaterialInfo(category_id, type_id, array_index);
                        $(".dynamic-select__trigger").removeClass('open');
                        $(".dynamic-options").removeClass('open');
                    },
                    setMaterialTypeInfo: function(array_index, category_id, type_id) {
                        setMaterialInfo(category_id, type_id, array_index, false);
                        $(".dynamic-select__trigger").removeClass('open');
                        $(".dynamic-options").removeClass('open');
                    },
                    customFormatter(date) {
                        return moment(date).format('YYYY-MM-DD');
                    },
                    dateModify(e, index, type) {
                        $(e.target).on("change", function() {
                            materialListObj.material_array[index][type] = $(this).val();
                        });
                    },
                    customInput() {
                        return 'form-control';
                    },
                    openshipMaterialCategorylist(index) {
                        activeId_Category = index;
                        $('.only-modal-category-show').click();
                    },
                    openshipMateriallist(index) {
                        activeId = index;
                        $('.only-modal-show').click();
                    },
                    getClose: function() {
                        return '/assets/images/cancel.png';
                    },
                    deleteMaterialItem(material_id, is_tmp, array_index) {
                        document.getElementById('warning-audio').play();
                        if (is_tmp == 0) {
                            bootbox.confirm("Are you sure you want to delete?", function (result) {
                                if (result) {
                                    $.ajax({
                                        url: BASE_URL + 'ajax/shipManage/shipMaterial/delete',
                                        type: 'post',
                                        data: {
                                            id: material_id,
                                        },
                                        success: function (data, status, xhr) {
                                            materialListObj.material_array.splice(array_index, 1);
                                        }
                                    })
                                }
                            });
                        } else {
                            bootbox.confirm("Are you sure you want to delete?", function (result) {
                                if (result) {
                                    materialListObj.material_array.splice(array_index, 1);
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

                    $("[name='particular[]']").each(function(index) {
                        this.dispatchEvent(new Event("keyup"));
                    });

                    $(".auto-area").each(function(index) {
                        this.dispatchEvent(new Event("keyup"));
                    });

                    $("[name='qty[]']").on('keypress',function(e){
                        var charCode = (event.which) ? event.which : event.keyCode;
                        if (charCode > 31 && (charCode < 48 || charCode > 57))
                            return false;
                        return true;
                    });
                }
            });

            materialCategoryObj = new Vue({
                el: '#modal-material-category',
                data() {
                    return {
                        list: [],
                    }
                },
                methods: {
                    deleteShipMaterial(index) {
                        if(index == undefined || index == '')
                            return false;

                        bootbox.confirm("Are you sure you want to delete?", function (result) {
                            if (result) {
                                isChangeStatus = true;
                                $.ajax({
                                    url: BASE_URL + 'ajax/shipManage/material/category/delete',
                                    type: 'post',
                                    data: {
                                        id: index
                                    },
                                    success: function(data) {
                                        if (data == 0) {
                                            alert("It cannot be deleted because the related data remains!");
                                        }
                                        else {
                                            materialCategoryObj.list = Object.assign([], [], data);
                                        }
                                    }
                                })
                            }});
                    },
                    ajaxFormSubmit() {
                        var arr = new Array();
                        $("#modal-material-category  input[name='order_no[]']").each(function(){
                            if ($(this).val() != "") arr.push($(this).val());
                        });
                        for(var i=0; i<arr.length;i++){
                            for(var j=i+1;j<arr.length;j++){
                                if(arr[i]==arr[j]){
                                    alert("OrderNo is duplicated. Please check again!");
                                    return;
                                }
                            }
                        }         
                        let form = $('#shipMaterialCategoryForm').serialize();
                        $.post('shipMaterialCategory', form).done(function (data) {
                            let result = data;
                            materialCategoryObj.list = Object.assign([], [], result);
                            
                            materialListObj.materialCategoryList = Object.assign([], [], result);
                            shipMaterialCategoryList = Object.assign([], [], result);
                            
                            materialCategoryObj.list.forEach(function(value) {
                                if(value.id == materialListObj.material_array[activeId_Category].category_id)
                                    materialListObj.material_array[activeId_Category].category_name = value.name;
                            });
                            
                            materialListObj.material_array.forEach(function(value, key) {
                                if (value.category_id == materialListObj.material_array[activeId_Category].category_id)
                                {
                                    materialListObj.material_array[key].category_name = materialListObj.material_array[activeId_Category].category_name;
                                }
                            });
                            materialListObj.$forceUpdate();

                            // getShipInfo(ship_id);
                            $('.close').click();
                        });
                    },
                    addNewRow(e) {
                        isChangeStatus = true;
                        materialCategoryObj.list.push([]);
                    }
                }
            });

            materialTypeObj = new Vue({
                el: '#modal-material-type',
                data() {
                    return {
                        list: [],
                    }
                },
                methods: {
                    deleteShipMaterial(index) {
                        if(index == undefined || index == '')
                            return false;

                        bootbox.confirm("Are you sure you want to delete?", function (result) {
                            if (result) {
                                isChangeStatus = true;
                                $.ajax({
                                    url: BASE_URL + 'ajax/shipManage/material/type/delete',
                                    type: 'post',
                                    data: {
                                        id: index
                                    },
                                    success: function(data) {
                                        if (data == 0) {
                                            alert("It cannot be deleted because the related data remains!");
                                        }
                                        else {
                                            materialTypeObj.list = Object.assign([], [], data);
                                        }
                                    }
                                })
                            }});
                    },
                    ajaxFormSubmit() {
                        var arr = new Array();
                        $("#modal-material-type  input[name='order_no[]']").each(function(){
                            if ($(this).val() != "") arr.push($(this).val());
                        });
                        for(var i=0; i<arr.length;i++){
                            for(var j=i+1;j<arr.length;j++){
                                if(arr[i]==arr[j]){
                                    alert("OrderNo is duplicated. Please check again!");
                                    return;
                                }
                            }
                        }
                        
                        let form = $('#shipMaterialForm').serialize();
                        $.post('shipMaterialType', form).done(function (data) {
                            let result = data;
                            materialTypeObj.list = Object.assign([], [], result);
                            
                            materialListObj.materialTypeList = Object.assign([], [], result);
                            shipMaterialTypeList = Object.assign([], [], result);
                            
                            
                            materialTypeObj.list.forEach(function(value) {
                                if(value.id == materialListObj.material_array[activeId].type_id)
                                    materialListObj.material_array[activeId].type_name = value.name;
                            });
                            
                            materialListObj.material_array.forEach(function(value, key) {
                                if (value.type_id == materialListObj.material_array[activeId].type_id)
                                {
                                    materialListObj.material_array[key].type_name = materialListObj.material_array[activeId].type_name;
                                }
                            });
                            materialListObj.$forceUpdate();

                            // getShipInfo(ship_id);
                            $('.close').click();
                        });
                    },
                    addNewRow(e) {
                        isChangeStatus = true;
                        materialTypeObj.list.push([]);
                    }
                }
            });

            if (select_year == 0) $('#title_year').html('')
            else $('#title_year').html(select_year + '年');
            getShipInfo(ship_id, select_year);

        }

        function importPastYearData() {
            __alertAudio();
            bootbox.confirm("Are you sure to import the past year's data?", function (result) {
                if (result) {
                    var prev_year = select_year - 1;
                    $.ajax({
                        url: BASE_URL + 'ajax/shipManage/material/list',
                        type: 'post',
                        data: {
                            ship_id: ship_id,
                            year: prev_year
                        },
                        success: function(data, status, xhr) {
                            let reportLen = materialListObj.material_array.length;
                            for (var i=0;i<data['ship'].length;i++)
                            {
                                materialListObj.material_array.push([]);
                                materialListObj.material_array[reportLen]['category_id']  = data['ship'][i].category_id;
                                materialListObj.material_array[reportLen]['type_id']  = data['ship'][i].type_id;
                                materialListObj.material_array[reportLen]['is_tmp']  = 1;
                                setMaterialInfo(data['ship'][i].category_id, data['ship'][i].type_id, reportLen);
                                setMaterialInfo(data['ship'][i].category_id, data['ship'][i].type_id, reportLen, false);
                                materialListObj.material_array[reportLen]['name']  = data['ship'][i].name;
                                materialListObj.material_array[reportLen]['qty']  = data['ship'][i].qty;
                                materialListObj.material_array[reportLen]['model_mark']  = data['ship'][i].model_mark;
                                materialListObj.material_array[reportLen]['sn']  = data['ship'][i].sn;
                                materialListObj.material_array[reportLen]['particular']  = data['ship'][i].particular;
                                materialListObj.material_array[reportLen]['manufacturer']  = data['ship'][i].manufacturer;
                                materialListObj.material_array[reportLen]['blt_year']  = data['ship'][i].blt_year;
                                materialListObj.material_array[reportLen]['remark']  = data['ship'][i].remark;
                                reportLen ++;
                            }
                            isChangeStatus = true;
                        }
                    })
                }
            });
        }

        function getShipInfo(ship_id, year) {
            $.ajax({
                url: BASE_URL + 'ajax/shipManage/material/list',
                type: 'post',
                data: {
                    ship_id: ship_id,
                    year: year
                },
                success: function(data, status, xhr) {
                    let ship_id = data['ship_id'];
                    let ship_name = data['ship_name'];
                    let typeList = data['material_type'];
                    let categoryList = data['material_category'];
                    shipMaterialTypeList = data['material_type'];
                    shipMaterialCategoryList = data['material_category'];

                    $('[name=ship_id]').val(ship_id);
                    $('#ship_name').text(ship_name);
                    materialListObj.material_array = [];
                    Object.assign(materialListObj.material_array, data['ship']);
                    materialListObj.material_array.forEach(function(value, index) {
                        materialListObj.material_array[index]['is_tmp'] = 0;
                        setMaterialInfo(value['category_id'], value['type_id'], index);
                        setMaterialInfo(value['category_id'], value['type_id'], index, false);
                    });

                    materialListObj.materialTypeList = typeList;
                    materialListObj.materialCategoryList = categoryList;

                    Object.assign(materialTypeObj.list, shipMaterialTypeList);
                    materialTypeObj.list.push([]);

                    Object.assign(materialCategoryObj.list, shipMaterialCategoryList);
                    materialCategoryObj.list.push([]);

                    shipMateriallistTmp = JSON.parse(JSON.stringify(materialListObj.material_array));
                }
            })
        }

        function addMaterialItem() {
            let reportLen = materialListObj.material_array.length;
            let newMaterialCategoryId = 0;
            let newMaterialTypeId = 0;
            
            if(reportLen == 0) {
                newMaterialCategoryId = 1;
                newMaterialTypeId = 1;
            } else {
                newMaterialCategoryId = materialListObj.material_array[reportLen - 1]['category_id'];
                newMaterialTypeId = materialListObj.material_array[reportLen - 1]['type_id']
            }
            
            materialListObj.material_array.push([]);
            materialListObj.material_array[reportLen]['category_id']  = newMaterialCategoryId;
            materialListObj.material_array[reportLen]['type_id']  = newMaterialTypeId;
            materialListObj.material_array[reportLen]['is_tmp']  = 1;
            setMaterialInfo(newMaterialCategoryId, newMaterialTypeId, reportLen);
            setMaterialInfo(newMaterialCategoryId, newMaterialTypeId, reportLen, false);
            materialListObj.material_array[reportLen]['name']  = '';
            materialListObj.material_array[reportLen]['qty']  = '';
            materialListObj.material_array[reportLen]['model_mark']  = '';
            materialListObj.material_array[reportLen]['sn']  = '';
            materialListObj.material_array[reportLen]['particular']  = '';
            materialListObj.material_array[reportLen]['manufacturer']  = '';
            materialListObj.material_array[reportLen]['blt_year']  = '';
            materialListObj.material_array[reportLen]['remark']  = '';
            materialListObj.$forceUpdate();
            setTimeout(function() {
                $($('#material_list [name="name[]"]')[reportLen]).focus();
            }, 500);
            
            isChangeStatus = true;
        }

        function setMaterialInfo(categoryId, typeId, index = 0, material=true) {
            let status = 0;
            if(material)
            shipMaterialCategoryList.forEach(function(value, key) {
                if(value['id'] == categoryId) {
                    materialListObj.material_array[index]['category_id'] = categoryId;
                    materialListObj.material_array[index]['category_name'] = value['name'];
                    materialListObj.$forceUpdate();
                    status ++;
                }
            });
            else 

            shipMaterialTypeList.forEach(function(value, key) {
                if(value['id'] == typeId) {
                    materialListObj.material_array[index]['type_id'] = typeId;
                    materialListObj.material_array[index]['type_name'] = value['name'];
                    materialListObj.$forceUpdate();
                    status ++;
                }
            });
        }

        $('#select-ship').on('change', function() {
            ship_id = $("#select-ship").val();
            select_year = $("#select-year").val();
            if (select_year == 0) $('#title_year').html('')
            else $('#title_year').html(select_year + '年');
            location.href = "/shipManage/shipMaterialList?id=" + ship_id + "&year=" + select_year;
        });

        $('#select-year').on('change', function() {
            changeInfo();
        });

        function changeInfo() {
            ship_id = $("#select-ship").val();
            select_year = $("#select-year").val();
            if (select_year == 0) $('#title_year').html('')
            else $('#title_year').html(select_year + '年');

            //getShipInfo(ship_id, select_year);
            location.href = "/shipManage/shipMaterialList?id=" + ship_id + "&year=" + select_year;
        }

        $('#submit').on('click', function() {
            var name_list = $("textarea[name='name[]']");
            var qty_list = $("[name='qty[]']");
            var category_list = $("[name='category_id[]']");
            var type_list = $("[name='type_id[]']");
            for (var i=0;i<name_list.length;i++)
            {
                if(category_list[i].value == "") {
                    alert("Please select DPT.");
                    return;
                }

                if(type_list[i].value == "") {
                    alert("Please select Kinds.");
                    return;
                }

                if (name_list[i].value == "") {
                    alert("Please input name.");
                    name_list[i].focus();
                    console.log(name_list[i]);
                    return;
                }
                if (qty_list[i].value == "") {
                    alert("Please input qty.");
                    qty_list[i].focus();
                    return;
                }
                
            }
            $('#materialList-form').submit();
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