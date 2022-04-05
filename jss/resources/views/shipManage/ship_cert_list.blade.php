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
        <div class="page-content" id="cert_list" v-cloak>
            <div class="page-header">
                <div class="col-sm-3">
                    <h4><b>船舶证书</b></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label class="custom-label d-inline-block font-bold" style="padding: 6px;">船名:</label>
                    <select class="custom-select d-inline-block" style="padding: 4px;max-width: 100px;" @change="changeShip">
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
                <div class="col-md-6">
                    <div class="btn-group f-right">
                        <button class="btn btn-report-search btn-sm search-btn d-none" @click="doSearch()"><i class="icon-search"></i>搜索</button>
                        <a class="btn btn-sm btn-danger refresh-btn-over d-none" type="button" @click="refresh">
                            <img src="{{ cAsset('assets/images/refresh.png') }}" class="report-label-img">恢复
                        </a>
                        <button class="btn btn-warning btn-sm excel-btn" @click="onExport"><i class="icon-table"></i>{{ trans('common.label.excel') }}</button>
                    </div>
                    <div class="f-right" style="margin-right: 12px; padding-top: 2px;">
                        <label class="font-bold">提前:</label>
                        <select class="text-center" style="width: 60px;" name="expire_date" v-model="expire_date" @change="onExpireChange">
                            <option value="0">All</option>
                            <option value="60">60</option>
                            <option value="90">90</option>
                            <option value="120">120</option>
                        </select>
                        <input type="hidden" class="text-center" style="width: 60px;" name="ship_id" v-model="ship_id">
                        <label>天</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="margin-top: 4px;">
                    <div class="row">
                        <table class="table-bordered rank-table" id="table-ship-cert-list">
                            <thead>
                                <th class="text-center style-header" style="width:60px;word-break: break-all;">{!! trans('shipManage.shipCertlist.No') !!}</th>
                                <th class="text-center style-header" style="width:60px;word-break: break-all;">{{ trans('shipManage.shipCertlist.Code') }}</th>
                                <th class="text-center style-header" style="width:280px;word-break: break-all;">{{ trans('shipManage.shipCertlist.name of certificates') }}</th>
                                <th class="text-center style-header" style="width:120px;word-break: break-all;">{{ trans('shipManage.shipCertlist.issue_date') }}</th>
                                <th class="text-center style-header" style="width:120px;word-break: break-all;">{{ trans('shipManage.shipCertlist.expire_date') }}</th>
                                <th class="text-center style-header" style="width:120px;word-break: break-all;">{!! trans('shipManage.shipCertlist.due_endorse') !!}</th>
                                <th class="text-center style-header" style="width:80px;word-break: break-all;">{{ trans('shipManage.shipCertlist.issuer') }}</th>
                                <th class="text-center style-header" style="width:40px;word-break: break-all;"><img src="{{ cAsset('assets/images/paper-clip.png') }}" width="15" height="15"></th>
                                <th class="text-center style-header" style="width:200px;word-break: break-all;">{{ trans('shipManage.shipCertlist.remark') }}</th>
                            </thead>
                            <tbody>
                            <tr v-for="(item, array_index) in cert_array">
                                <td class="center no-wrap">@{{ item.order_no }}</td>
                                <td class="center no-wrap">@{{ item.code }}</td>
                                <td class="text-left">@{{ item.cert_name }}</td>
                                <td class="center"><span>@{{ item.issue_date }}</span></td>
                                <td class="center"><span>@{{ item.expire_date }}</span></td>
                                <td class="center"><span>@{{ item.due_endorse }}</span></td>
                                <td class="center"><span>@{{ issuer_type[item.issuer] }}</span></td>
                                <td class="text-center">
                                    <label><a v-bind:href="item.attachment_link" target="_blank" v-bind:class="[item.attachment_link == '' || item.attachment_link == undefined ? 'visible-hidden' : '']"><img src="{{ cAsset('assets/images/document.png') }}" width="15" height="15" style="cursor: pointer;"></a></label>
                                </td>
                                <td class="text-left"><span>@{{ item.remark }}</span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ cAsset('assets/js/moment.js') }}"></script>
    <script src="{{ cAsset('assets/js/vue.js') }}"></script>
    <script src="https://unpkg.com/vuejs-datepicker"></script>

	<?php
	echo '<script>';
	echo 'var IssuerTypeData = ' . json_encode(g_enum('IssuerTypeData')) . ';';
	echo '</script>';
	?>
    <script>
        var certListObj = null;
        var shipCertTypeList = [];

        $(function () {
            // Initialize
            initialize();
        });

        function initialize() {
            // Create Vue Obj
            certListObj = new Vue({
                el: '#cert_list',
                data: {
                    cert_array: [],
                    certTypeList: [],
                    issuer_type: IssuerTypeData,
                    expire_date: 0,
                    ship_id: 0,
                },
                methods: {
                    customFormatter(date) {
                        return moment(date).format('YYYY-MM-DD');
                    },

                    doSearch() {
                        this.getShipCertInfo();
                    },
                    changeShip(e) {
                        this.ship_id = e.target.value;console.log(e.target.value)
                        this.getShipCertInfo();
                    },
                    refresh() {
                        this.expire_date = 0;
                        this.getShipCertInfo();
                    },
                    onExport() {
                        //location.href='/shipManage/shipCertExcel?id=' + this.ship_id;
                        //WEN XIANG_船舶证书_20210719
                        var tab_text="<table border='1px' style='text-align:center;vertical-align:middle;'>";
                        var real_tab = document.getElementById('table-ship-cert-list');
                        var tab = real_tab.cloneNode(true);
                        tab_text=tab_text+"<tr><td colspan='8' style='font-size:24px;font-weight:bold;border-left:hidden;border-top:hidden;border-right:hidden;text-align:center;vertical-align:middle;'>" + '"' + $('#ship_name').html() + '"' + "CERTIFICATES</td></tr>";
                        for(var j = 0 ; j < tab.rows.length ; j++) 
                        {
                            if (j == 0) {
                                for (var i=0; i<tab.rows[j].childElementCount*2;i+=2) {
                                    tab.rows[j].childNodes[i].style.width = '100px';
                                    tab.rows[j].childNodes[i].style.backgroundColor = '#d9f8fb';
                                }
                                tab.rows[j].childNodes[0].style.width = '60px';
                                tab.rows[j].childNodes[2].style.width = '60px';
                                tab.rows[j].childNodes[4].style.width = '300px';
                                tab.rows[j].childNodes[16].style.width = '200px';
                            }
                            
                            tab.rows[j].childNodes[13].remove();
                            tab.rows[j].childNodes[13].remove();

                            tab_text=tab_text+"<tr style='text-align:center;vertical-align:middle;font-size:16px;'>"+tab.rows[j].innerHTML+"</tr>";
                        }
                        tab_text=tab_text+"</table>";
                        tab_text= tab_text.replaceAll(/<A[^>]*>|<\/A>/g, "");
                        tab_text= tab_text.replaceAll(/<img[^>]*>/gi,"");
                        tab_text= tab_text.replaceAll(/<input[^>]*>|<\/input>/gi, "");

                        var filename = '"' + $('#ship_name').html() + '"' + "CERTIFICATES";
                        exportExcel(tab_text, filename, filename);
                        
                        return 0;
                    },
                    getShipCertInfo() {
                        getShipInfo(this.ship_id, this.expire_date);
                    },
                    onExpireChange(e) {
                        this.expire_date = $(e.target).val();
                        this.getShipCertInfo();
                    }
                }
            });

            certListObj.ship_id = '{!! $shipId !!}';
            getShipInfo(certListObj.ship_id, certListObj.expire_date);
        }

        function getShipInfo(ship_id, expire_date) {
            $.ajax({
                url: BASE_URL + 'ajax/shipManage/cert/list',
                type: 'post',
                data: {
                    ship_id: ship_id,
                    expire_date: expire_date
                },
                success: function(data, status, xhr) {
                    let ship_name = data['ship_name'];
                    shipCertTypeList = data['cert_type'];
                    $('#ship_name').text(ship_name);
                    certListObj.cert_array = data['ship'];
                    certListObj.certTypeList = shipCertTypeList;
                    certListObj.ship_id = data['ship_id'];
                    certListObj.cert_array.forEach(function(value, index) {
                        setCertInfo(value['cert_id'], index);
                    });
                    totalRecord = data['ship'].length;

                }
            })
        }


        function setCertInfo(certId, index = 0) {
            shipCertTypeList.forEach(function(value, key) {
                if(value['id'] == certId) {
                    certListObj.cert_array[index]['order_no'] = value['order_no'];
                    certListObj.cert_array[index]['cert_id'] = certId;
                    certListObj.cert_array[index]['code'] = value['code'];
                    certListObj.cert_array[index]['cert_name'] = value['name'];
                    certListObj.$forceUpdate();
                }
            });
        }

        $('#select-ship').on('change', function() {
            getShipInfo($(this).val());
        });

    </script>
@endsection