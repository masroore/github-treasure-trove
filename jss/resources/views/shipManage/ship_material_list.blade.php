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
                    <div class="col-lg-7">
                        <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名: </label>
                        <select class="custom-select d-inline-block" id="select-ship" style="padding: 4px; max-width: 100px;">
                            @foreach($shipList as $ship)
                                <option value="{{ $ship['IMO_No'] }}"{{ isset($shipId) && $shipId == $ship['IMO_No'] ?  "selected" : "" }}>{{ $ship['NickName'] == '' ? $ship['shipName_En'] : $ship['NickName'] }}</option>
                            @endforeach
                        </select>
                        <select name="select-year" id="select-year" style="font-size:13px">
                            @for($i=date("Y");$i>=$start_year;$i--)
                            <option value="{{$i}}" @if($year==$i) selected @endif>{{$i}}年</option>
                            @endfor
                        </select>
                        <select name="select-category" id="select-category" style="font-size:13px">
                            <option value="0" selected></option>
                            @foreach($category as $cat)
                                <option value="{{ $cat['id'] }}">{{$cat['name']}}</option>
                            @endforeach
                        </select>
                        <select name="select-type" id="select-type" style="font-size:13px">
                            <option value="0" selected></option>
                            @foreach($type as $t)
                                <option value="{{ $t['id'] }}">{{$t['name']}}</option>
                            @endforeach
                        </select>
                        @if(isset($shipName['shipName_En']))
                            <strong class="f-right" style="font-size: 16px; padding-top: 6px;">"<span id="ship_name">{{ $shipName['shipName_En'] }}</span>" <span id="title_year"></span>设备清单</strong>
                        @endif
                    </div>
                    <div class="col-lg-5">
                        <div class="btn-group f-right">
                            <a onclick="javascript:fnExcelReport();" class="btn btn-warning btn-sm excel-btn">
                                <i class="icon-table"></i>{{ trans('common.label.excel') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 4px;">
                    <div class="head-fix-div common-list">
                        <form action="shipMaterialList" method="post" id="materialList-form" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" value="{{ $shipId }}" name="ship_id">
                            <table id="table-material-list">
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
                                </thead>
                                <tbody id="material_list" v-cloak>
                                <tr v-for="(item, array_index) in material_array">
                                    <td class="d-none"><input type="hidden" name="id[]" v-model="item.id"></td>
                                    <td class="center no-wrap" v-bind:data-action="array_index">@{{ array_index + 1 }}</td>
                                    <td style="padding-left: 5px!important;">@{{ item.category_name }}</td>
                                    <td style="padding-left: 5px!important;">@{{ item.type_name }}</td>
                                    <td><textarea class="form-control text-left auto-area" readonly type="text" v-model="item.name" name="name[]" @keyup="textareaChange"></textarea></td>
                                    <td><input class="form-control text-center" type="text" readonly v-model="item.qty" name="qty[]" maxlength="3"></td>
                                    <td><textarea class="form-control text-left auto-area" readonly type="text" v-model="item.model_mark" name="model_mark[]" @keyup="textareaChange"></textarea></td>
                                    <td><textarea class="form-control text-left auto-area" readonly type="text" v-model="item.sn" name="sn[]" @keyup="textareaChange"></textarea></td>
                                    <td><textarea class="form-control text-left auto-area" readonly type="text" v-model="item.particular" name="particular[]" rows="1" @keyup="particularChange"></textarea></td>
                                    <td><textarea class="form-control text-left auto-area" readonly type="text" v-model="item.manufacturer" name="manufacturer[]" @keyup="textareaChange"></textarea></td>
                                    <td><input class="form-control text-center" type="text" readonly v-model="item.blt_year" name="blt_year[]"></td>
                                    <td><textarea class="form-control text-left auto-area" readonly type="text" v-model="item.remark" name="remark[]" @keyup="textareaChange"></textarea></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
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
        var ship_id = $("#select-ship").val();
        var select_year = $("#select-year").val();
        var select_category = $("#select-category").val();
        var select_type = $("#select-type").val();
        var initLoad = true;

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
                    textareaChange: function(event) {
                        let item = event.target;
                        item.style.setProperty("height", item.scrollHeight + 'px', "important");
                    },
                    particularChange: function(event) {
                        let item = event.target;
                        item.style.setProperty("height", item.scrollHeight + 'px', "important");
                    },
                    setMaterialInfo: function(array_index, category_id, type_id) {
                        setMaterialInfo(category_id, type_id, array_index);
                        $(".dynamic-select__trigger").removeClass('open');
                        $(".dynamic-options").removeClass('open');
                    },
                    getClose: function() {
                        return '/assets/images/cancel.png';
                    }
                },
                updated() {
                    $("[name='particular[]']").each(function(index) {
                        this.dispatchEvent(new Event("keyup"));
                    });

                    $(".auto-area").each(function(index) {
                        this.dispatchEvent(new Event("keyup"));
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
                }
            });

            if (select_year == 0) $('#title_year').html('')
            else $('#title_year').html(select_year + '年');
            getShipInfo(ship_id, select_year, select_category, select_type);

        }

        function getShipInfo(ship_id, year, category, type) {
            $.ajax({
                url: BASE_URL + 'ajax/shipManage/material/list',
                type: 'post',
                data: {
                    ship_id: ship_id,
                    year: year,
                    category: category,
                    type: type,
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

        function setMaterialInfo(categoryId, typeId, index = 0) {
            let status = 0;
            shipMaterialCategoryList.forEach(function(value, key) {
                if(value['id'] == categoryId) {
                    materialListObj.material_array[index]['category_id'] = categoryId;
                    materialListObj.material_array[index]['category_name'] = value['name'];
                    materialListObj.$forceUpdate();
                    status ++;
                }
            });

            shipMaterialTypeList.forEach(function(value, key) {
                if(value['id'] == typeId) {
                    materialListObj.material_array[index]['type_id'] = typeId;
                    materialListObj.material_array[index]['type_name'] = value['name'];
                    materialListObj.$forceUpdate();
                    status ++;
                }
            });
        }

        function changeInfo() {
            ship_id = $("#select-ship").val();
            select_year = $("#select-year").val();
            select_category = $("#select-category").val();
            select_type = $("#select-type").val();
            if (select_year == 0) $('#title_year').html('')
            else $('#title_year').html(select_year + '年');
            getShipInfo(ship_id, select_year, select_category, select_type);
        }

        $('#select-ship').on('change', function() {
            ship_id = $("#select-ship").val();
            select_year = $("#select-year").val();
            location.href = "/shipManage/shipMaterialManage?id=" + ship_id + "&year=" + select_year;
        });
        
        $('#select-year, #select-category, #select-type').on('change', function() {
            changeInfo();
        });

        function fnExcelReport() {
            var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
            var real_tab = document.getElementById('table-material-list');
            var tab = real_tab.cloneNode(true);
            tab_text=tab_text+"<tr><td colspan='10' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + $('#select-ship option:selected').text() + '_' + $('#title_year').html() + "设备清单</td></tr>";
            for(var j = 0 ; j < tab.rows.length ; j++) 
            {
                if (j == 0) {
                    for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                        tab.rows[j].childNodes[i].style.width = '100px';
                        tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                    }
                    tab.rows[j].childNodes[2].style.width = '40px';
                    tab.rows[j].childNodes[8].style.width = '200px';
                    tab.rows[j].childNodes[12].style.width = '200px';
                    tab.rows[j].childNodes[16].style.width = '200px';
                    tab.rows[j].childNodes[18].style.width = '200px';
                }
                else {
                    var info = real_tab.rows[j].childNodes[8].childNodes[0].value;
                    tab.rows[j].childNodes[8].innerHTML = info;
                    tab.rows[j].childNodes[8].style.textAlign = "left";
                    info = real_tab.rows[j].childNodes[10].childNodes[0].value;
                    tab.rows[j].childNodes[10].innerHTML = info;
                    info = real_tab.rows[j].childNodes[12].childNodes[0].value;
                    tab.rows[j].childNodes[12].innerHTML = info;
                    tab.rows[j].childNodes[12].style.textAlign = "left";
                    info = real_tab.rows[j].childNodes[14].childNodes[0].value;
                    tab.rows[j].childNodes[14].innerHTML = info;
                    tab.rows[j].childNodes[14].style.textAlign = "left";
                    info = real_tab.rows[j].childNodes[16].childNodes[0].value;
                    info = info.replaceAll('\n', "<br />");
                    tab.rows[j].childNodes[16].innerHTML = info;
                    tab.rows[j].childNodes[16].style.textAlign = "left";
                    info = real_tab.rows[j].childNodes[18].childNodes[0].value;
                    tab.rows[j].childNodes[18].innerHTML = info;
                    tab.rows[j].childNodes[18].style.textAlign = "left";
                    info = real_tab.rows[j].childNodes[20].childNodes[0].value;
                    tab.rows[j].childNodes[20].innerHTML = info;
                    info = real_tab.rows[j].childNodes[22].childNodes[0].value;
                    tab.rows[j].childNodes[22].innerHTML = info;
                    tab.rows[j].childNodes[22].style.textAlign = "left";
                }
                
                tab.rows[j].childNodes[0].remove();
                //tab.rows[j].childNodes[13].remove();

                tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
            }
            tab_text=tab_text+"</table>";
            tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
            tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
            tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

            var filename = $('#select-ship option:selected').text() + '_' + $('#title_year').html() + "设备清单";
            exportExcel(tab_text, filename, filename);
            
            return 0;
        }
        
    </script>
@endsection