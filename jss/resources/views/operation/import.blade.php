@extends('layout.header')
<?php
$isHolder = Session::get('IS_HOLDER');
$ships = Session::get('shipList');
?>
@section('content')
    <div class="main-content">
        <style>
            table {
                font-size: 12px;
            }
            .chosen-drop { width:260px !important;}
        </style>
        <div class="page-content">
            <div class="col-md-12">
                <div class="row">
                    <form action="import" method="get" class="form-search">
                        <div class="col-md-1.5">
                            <label class="control-label no-padding-right" style="float: left;padding-top: 6px">{{transShipOperation("import.ShipName")}}</label>
                            <div class="col-sm-9" style="width: 100px;">
                                <select class="form-control chosen-select" name="shipId" id="shipId">
                                    <option value="" @if(empty($shipId)) selected @endif>&nbsp;</option>
                                    @foreach($shipList as $ship)
                                        @if(!$isHolder)
                                        <option value="{{$ship['RegNo']}}"
                                                @if(isset($shipId) && ($shipId == $ship['RegNo'])) selected @endif>{{ $ship['shipName_Cn'] .' | ' .$ship['shipName_En']}}
                                        </option>
                                        @elseif(in_array($ship->shipID, $ships))
                                            <option value="{{$ship['RegNo']}}"
                                                    @if(isset($shipId) && ($shipId == $ship['RegNo'])) selected @endif>{{ $ship['shipName_Cn'] .' | ' .$ship['shipName_En']}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label no-padding-right" style="float: left;padding-top: 6px">{{transShipOperation("import.Voy")}}</label>
                            <div class="col-sm-4">
                                <select class="form-control chosen-select" name="firstVoy">
                                    <option value="" @if(empty($firstVoy)) selected @endif>&nbsp;</option>
                                    @foreach($voyList as $voy)
                                        <option value="{{$voy['id']}}"
                                                @if(isset($firstVoy) && ($firstVoy == $voy['id'])) selected @endif>{{$voy['Voy_No']}} | {{$voy['CP_No']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label no-padding-right" style="float: left;padding-top: 6px">~</label>
                            <div class="col-sm-4">
                                <select class="form-control chosen-select" name="endVoy">
                                    <option value="" @if(empty($endVoy)) selected @endif>&nbsp;</option>
                                    @foreach($voyList as $voy)
                                        <option value="{{$voy['id']}}"
                                                @if(isset($endVoy) && ($endVoy == $voy['id'])) selected @endif>{{$voy['Voy_No']}} | {{$voy['CP_No']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label no-padding-right" style="float: left;padding-top: 6px">{{transShipOperation("import.PaidVoy")}}</label>
                            <div class="col-sm-4">
                                <select class="form-control chosen-select" name="firstPaidVoy">
                                    <option value="" @if(empty($firstPaidVoy)) selected @endif>&nbsp;</option>
                                    @foreach($voyList as $voy)
                                        <option value="{{$voy['id']}}"
                                                @if(isset($firstPaidVoy) && ($firstPaidVoy == $voy['id'])) selected @endif>{{$voy['Voy_No']}} | {{$voy['CP_No']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label no-padding-right" style="float: left;padding-top: 6px">~</label>
                            <div class="col-sm-4">
                                <select class="form-control chosen-select" name="endPaidVoy">
                                    <option value="" @if(empty($endPaidVoy)) selected @endif>&nbsp;</option>
                                    @foreach($voyList as $voy)
                                        <option value="{{$voy['id']}}"
                                                @if(isset($endPaidVoy) && ($endPaidVoy == $voy['id'])) selected @endif>{{$voy['Voy_No']}} | {{$voy['CP_No']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label no-padding-right" style="float: left;padding-top: 6px">{{transShipOperation("import.AC Items")}}</label>
                            <div class="col-sm-9" style="width: 150px;">
                                <select class="form-control chosen-select" name="payMode">
                                    <option value="" @if(empty($payMode)) selected @endif>&nbsp;</option>
                                    @foreach($payList as $mode)
                                        <option value="{{$mode['id']}}" @if(isset($payMode) && ($payMode == $mode['id'])) selected @endif>{{$mode['AC_Detail_Item_Abb']}} | {{$mode['AC_Detail Item_Referance']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2" style="text-align: right; float:right;">
                            <button type="submit" class="btn btn-primary btn-sm" style="width: 80px"><i class="icon-search"></i>搜索</button>
                        </div>
                    </form>
                </div>
                <div class="space-6"></div>

                <div class="row" style="overflow-x: auto;">
                    <table class="arc-std-table table table-striped table-bordered table-hover data-table">
                        <thead>
                        <tr class="black br-hblue">
                            <th>{{transShipOperation("import.No")}}</th>
                            <th>{{transShipOperation("import.Object")}}</th>
                            <th>{{transShipOperation("import.ShipName")}}</th>
                            <th>{{transShipOperation("import.Voy")}}</th>
                            <th>{{transShipOperation("import.PaidVoy")}}</th>
                            <th>{{transShipOperation("import.Description")}}</th>
                            <th>{{transShipOperation("import.AC Items")}}</th>
                            <th>{{transShipOperation("import.Place")}}</th>
                            <th>{{transShipOperation("import.Amount")}}</th>
                            <th>{{transShipOperation("import.Curency")}}</th>
                            <th>{{transShipOperation("import.Account")}}</th>
                            <th>{{transShipOperation("import.Pay_Mthd")}}</th>
                            <th>{{transShipOperation("import.Appl_Date")}}</th>
                            <th>{{transShipOperation("import.Rcpt_Date")}}</th>
                            <th>{{transShipOperation("import.Ref_No")}}</th>
                            <th>{{transShipOperation("import.Cmplt")}}</th>
                            <th>{{transShipOperation("import.Recipt")}}</th>
                            @if(!$isHolder)
                                <th width="40px"></th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
						<?php $index = ($data->currentPage() - 1) * $data->perPage() + 1; ?>
                        @foreach($data as $list)
                            <tr>
                                <td data-id="{{$list->id}}">{{$index++}}</td>
                                <td class="center">{{ $list->Object }}</td>
                                <td class="center" data-ship="{{$list->ShipID}}">{{ is_null($list->shipName) ? '' : $list->shipName->shipName_Cn }}</td>
                                <td class="center" data-voy="{{$list->Voy}}">{{ is_null($list->voyNo)? '' : $list->voyNo->Voy_No }}</td>
                                <td class="center" data-voy="{{$list->Paid_Voy}}">{{ is_null($list->paidVoyNo)? '' : $list->paidVoyNo->Voy_No }}</td>
                                <td>{{ $list->Discription }}</td>
                                <td class="center" data-item="{{$list->AC_Items}}">{{ $list->acItemDetail == NULL ? '' : $list->acItemDetail->AC_Detail_Item_Abb }}</td>
                                <td>{{$list->Place}}</td>
                                <td style="text-align: right" data-amount="{{$list->Amount}}">{{ \App\Http\Controllers\Util::getNumberFt($list->Amount) }}</td>
                                <td class="center">{{$list->Curency}}</td>
                                <td class="center" data-account="{{$list->Account}}">@if(!empty($list->Account)){{$list->accountName->AccountName_En}}@endif</td>
                                <td class="center">{{$list->Pay_Mthd}}</td>
                                <td class="center">{{ convert_date($list->Appl_Date) }}</td>
                                <td class="center">{{ convert_date($list->Recipt_Date) }}</td>
                                <td class="center">{{$list->Ref_No}}</td>
                                <td><input type="checkbox" {{ $list->Completion ? 'checked' : '' }} disabled ></td>
                                <td><input type="checkbox" {{ $list->Recipt ? 'checked' : '' }} disabled ></td>
                                <td class="hidden" data-text="{{$list->Remark}}"></td>
                                @if(!$isHolder)
                                    <td class="action-buttons">
                                        <a href="javascript:void(0);" class="red row_trash_btn"><i class="icon-trash bigger-130"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    {!! $data->render() !!}
                </div>
                <div class="space-6"></div>
                @if(!$isHolder)
                    <div class="row">
                        <div class="input">
                            <form action="{{ action('Operation\OperationController@updateShipInvoice') }}" method="post" id="invoice-form">
                                <table class="table table-bordered table-hover " style="margin-bottom: 0px;">
                                    <thead >
                                    <tr class="black br-hblue">
                                        <th>{{transShipOperation("import.Object")}}</th>
                                        <th>{{transShipOperation("import.ShipName")}}</th>
                                        <th>{{transShipOperation("import.Voy")}}</th>
                                        <th>{{transShipOperation("import.PaidVoy")}}</th>
                                        <th>{{transShipOperation("import.Description")}}</th>
                                        <th>{{transShipOperation("import.AC Items")}}</th>
                                        <th>{{transShipOperation("import.Place")}}</th>
                                        <th width="7%">{{transShipOperation("import.Amount")}}</th>
                                        <th>{{transShipOperation("import.Curency")}}</th>
                                    </tr>
                                    <input class="hidden" name="invoice_id">
                                    <input class="hidden" name="_token" value="{{csrf_token()}}">
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div style="width: 130px;text-align: left;">
                                                <select name="Object" class="form-control chosen-select">
                                                    <option value="">&nbsp;</option>
                                                    <option value="Business">业务 | Business</option>
                                                    <option value="Budget">预算 | Budget</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width: 130px;">
                                                <select name="ShipID" class="form-control chosen-select">
                                                    <option value="">&nbsp;</option>
                                                    @foreach($shipList as $ship)
                                                        <option value="{{$ship['RegNo']}}" @if($ship['RegNo'] == $shipId) selected @endif>{{$ship['shipName_En']}} | {{$ship['shipName_Cn']}}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width: 80px" class="voy_select">
                                                <select class="form-control chosen-select" name="Voy">
                                                    @foreach($voyList as $voy)
                                                        <option value="{{$voy['id']}}">{{$voy['Voy_No']}} | {{$voy['CP_No']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width: 80px" class="voy_select">
                                                <select class="form-control chosen-select" name="Paid_Voy">
                                                    @foreach($voyList as $voy)
                                                        <option value="{{$voy['id']}}">{{$voy['Voy_No']}} | {{$voy['CP_No']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td><input type="text" name="Discription" style="width: 100%;"></td>
                                        <td>
                                            <div style="width: 130px">
                                                <select class="form-control chosen-select" name="AC_Items">
                                                    <option value="">&nbsp;</option>
                                                    @foreach($payList as $item)
                                                        <option value="{{$item['id']}}">{{$item['AC_Detail_Item_Abb']}} | {{$item['AC_Detail Item_Referance']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td><input type="text" class="form-control" name="Place"></td>
                                        <td><input type="text" class="form-control" name="Amount"></td>
                                        <td>
                                            <div>
                                                <select class="form-control chosen-select" name='Curency'>
                                                    <option value="">&nbsp;</option>
                                                    <option value="USD">USD</option>
                                                    <option value="FRT">FRT</option>
                                                    <option value="RUB">RUB</option>
                                                    <option value="RMB">RMB</option>
                                                    <option value="EUR">EUR</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class=" table table-bordered table-hover " style="margin-bottom: 8px;">
                                    <thead>
                                    <tr class="black br-hblue">
                                        <th>{{transShipOperation("import.Account")}}</th>
                                        <th>{{transShipOperation("import.Pay_Mthd")}}</th>
                                        <th>{{transShipOperation("import.Appl_Date")}}</th>
                                        <th>{{transShipOperation("import.Rcpt_Date")}}</th>
                                        <th>{{transShipOperation("import.Cmplt")}}</th>
                                        <th>{{transShipOperation("import.Recipt")}}</th>
                                        <th>RefNo</th>

                                        <th>Remark</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div style="width: 130px">
                                                <select class="form-control chosen-select" name="Account">
                                                    <option value="">&nbsp;</option>
                                                    @foreach($Account as $item)
                                                        <option value="{{$item['id']}}">{{ $item['AccountName_Cn'] }} | {{ $item['AccountName_En'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="width: 130px">
                                                <select class="form-control chosen-select" name="Pay_Mthd">
                                                    <option value="">&nbsp;</option>
                                                    @foreach($PayMode as $item)
                                                        <option value="{{ $item['PayMode_En'] }}">{{ $item['PayMode_Cn'] }} | {{ $item['PayMode_En'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td style="width: 130px;">
                                            <div class=" input-group" style="padding-left:5px;width:100%">
                                                <input class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" style="width:75%" name='Appl_Date' value="">
                                                <span class="input-group-addon" style="float: right;width:25%;">
                                            <i class="icon-calendar bigger-110"></i>
                                        </span>
                                            </div>
                                        </td>
                                        <td style="width: 130px;">
                                            <div class=" input-group" style="padding-left:5px;width:100%">
                                                <input class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" style="width:75%" name="Recipt_Date" value="">
                                                <span class="input-group-addon" style="float: right;width:25%;">
                                            <i class="icon-calendar bigger-110"></i>
                                        </span>
                                            </div>
                                        </td>
                                        <td class="center">
                                            <input type="checkbox" class="form-control" name="Completion" style="height:15px" value="1">
                                        </td>
                                        <td class="center">
                                            <input type="checkbox" class="form-control" name="Recipt" style="height:15px" value="1">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="RefNo">
                                        </td>
                                        <td>
                                            <textarea class="form-control" rows="1" name="Remark" style="height: 25px;"></textarea>
                                        </td>
                                        <td class="center"><button class="btn btn-sm btn-primary no-radius" id="btn-add-movement" style="width: 80px"><icon class="icon icon-save"></icon>登记</button></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="add-oli-box" style="display:none;padding-top:10px">
                                    供给原油
                                    <table class="table table-bordered table-hover " style="margin-bottom: 8px;">
                                        <thead >
                                        <tr class="black br-hblue">
                                            <th>{{transShipOperation("import.SupplyDate")}}</th>
                                            <th>{{transShipOperation("import.Place")}}</th>
                                            <th>{{transShipOperation("import.AC Items")}}</th>
                                            <th>{{transShipOperation("import.Description")}}</th>
                                            <th style="width:100px">{{transShipOperation("import.Part No")}}</th>
                                            <th style="width:100px">{{transShipOperation("import.QTY")}}</th>
                                            <th>{{transShipOperation("import.UNIT")}}</th>
                                            <th style="width:100px">{{transShipOperation("import.Price")}}</th>
                                            <th style="width:100px">{{transShipOperation("import.Amount")}}</th>
                                            <th>{{transShipOperation("import.Remark")}}</th>
                                            <th style="width:40px"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="supply_table">
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <script>

        var token = '<?php echo csrf_token() ?>';

        $(function() {


            var width = $('.data-table').width();
            if(width < 1600)
                $('.data-table').css('width', '1600px');

            $('.btn-init').on('click', function () {
                location.href = 'import';
            });

            $('#shipId').on('change', function() {
                var shipId = $(this).val();
                if(shipId.length < 1) {
                    $('[name=firstVoy]').html('');
                    $('[name=endVoy]').html();
                    return;
                }

                $.post('/operation/getVoyList', {'_token':token, 'shipId':shipId}, function(data) {
                    if(data) {
                        var list = jQuery.parseJSON(data);
                        var html = '<option value=""></option>';
                        for(var i=0; i<list.length; i++) {
                            var voyItem = list[i];
                            html += '<option value="' + voyItem.id + '">' + voyItem.Voy_No + ' | ' + voyItem.CP_No + '</option>';
                        }
                        $('.chosen-select').chosen('destroy');

                        $('[name=firstVoy]').html(html);
                        $('[name=endVoy]').html(html);

                        $('[name=firstPaidVoy]').html(html);
                        $('[name=endPaidVoy]').html(html);

                        $('.chosen-select').chosen();
                    }
                });
            });

            $('[name=ShipID]').on('change', function() {
                var shipId = $(this).val();
                if(shipId.length < 1) {
                    $('[name=Voy]').html('');
                    $('[name=Paid_Voy]').html();
                    return;
                }

                $.post('/operation/getVoyList', {'_token':token, 'shipId':shipId}, function(data) {
                    if(data) {
                        var list = jQuery.parseJSON(data);
                        var html = '<option value=""></option>';
                        for(var i=0; i<list.length; i++) {
                            var voyItem = list[i];
                            html += '<option value="' + voyItem.id + '">' + voyItem.Voy_No + ' | ' + voyItem.CP_No + '</option>';
                        }

                        $('.chosen-select').chosen('destroy');
                        $('[name=Voy]').html(html);
                        $('[name=Paid_Voy]').html(html);
                        $('.chosen-select').chosen();
                    }
                });
            });

            $('[name=AC_Items]').on('change', function() {
                var itemId = $(this).val();
                if((itemId == 4) || (itemId == 5) || (itemId == 8)) {
                    var invoiceId = $('[name=invoice_id]').val();
                    showOilSuppleDialog(invoiceId);
                    $('.add-oli-box').fadeIn();
                } else {
                    $('#supply_table').html('');
                    $('.add-oli-box').fadeOut();
                }
            });

            $('.row_trash_btn').on('click', function() {

                var tr = $(this).closest('tr');

                var tds = tr.children();

                var shipName = tds.eq(2).text();
                var voyNo = tds.eq(3).text();
                var invoiceId = tds.eq(0).data('id');

                bootbox.confirm("[" + shipName + "]号的 " + voyNo + "航次收入及支出表真要删除吗?", function (result) {
                    if (result) {
                        $.post('/operation/deleteShipInvoice', {'_token':token, 'invoice':invoiceId}, function(data) {
                            if(data == 'success') {
                                tr.remove();
                                $.gritter.add({
                                    title: '成功',
                                    text: '删除成功!',
                                    class_name: 'gritter-success'
                                });
                            }
                        });
                    }
                });


            });
            // 행선택시 편집
            $('.data-table tr').on('click', function(){
                $(this).closest('tbody').find('tr').removeClass('table-row-selected');
                $(this).addClass('table-row-selected');

                $('.chosen-select').chosen('destroy');
                var tds = $(this).children();
                var invoiceId = tds.eq(0).data('id');
                if(invoiceId == '0') {

                    $('[name=Object]').val('Business');
                    $('[name=invoice_id]').val('0');
                    $('[name=Voy]').html('');
                    $('[name=Paid_Voy]').html('');
                    $('[name=ShipID]').val('');
                    $('[name=Discription]').val('');

                    $('[name=AC_Items]').val('');
                    $('[name=Place]').val('');
                    $('[name=Amount]').val('');
                    $('[name=Curency]').val('USD');
                    $('[name=Account]').val('');
                    $('[name=Pay_Mthd]').val('');
                    $('[name=Appl_Date]').val('');
                    $('[name=Recipt_Date]').val('');
                    $('[name=Completion]').prop('checked', '');
                    $('[name=Recipt]').prop('checked', '');
                    $('[name=Remark]').val('');

                    $('#supply_table').html('');
                    $('.add-oli-box').fadeOut();
                    $('.chosen-select').chosen();

                    return;
                }
                var oldShipId = $('[name=ShipID]').val();
                var newShipId = tds.eq(2).data('ship');

                $('[name=Object]').val(tds.eq(1).text());
                $('[name=invoice_id]').val(invoiceId);
                $('[name=ShipID]').val(tds.eq(2).data('ship'));
                if(oldShipId == newShipId) {
                    $('[name=Voy]').val(tds.eq(3).data('voy'));
                    $('[name=Paid_Voy]').val(tds.eq(4).data('voy'));
                } else {
                    $('[name=Voy]').html('');
                    $('[name=Paid_Voy]').html('');
                    $('[name=Voy]').chosen();
                    $('[name=Paid_Voy]').chosen('');
                    $.post('/operation/getVoyList', {'_token':token, 'shipId':newShipId}, function(data) {
                        if(data) {
                            $('[name=Voy]').chosen('destroy');
                            $('[name=Paid_Voy]').chosen('destroy');

                            var list = jQuery.parseJSON(data);
                            var html = '';
                            for(var i=0; i<list.length; i++) {
                                var voyItem = list[i];
                                html += '<option value="' + voyItem.id + '">' + voyItem.Voy_No + '</option>';
                            }

                            $('[name=Voy]').html(html);
                            $('[name=Paid_Voy]').html(html);

                            var voyId = tds.eq(3).data('voy');
                            var payVoyId = tds.eq(4).data('voy');
                            $('[name=Voy]').val(voyId);
                            $('[name=Paid_Voy]').val(payVoyId);
                            $('[name=Voy]').chosen();
                            $('[name=Paid_Voy]').chosen();
                        }
                    });
                }
                $('[name=Discription]').val(tds.eq(5).text());
                $('[name=AC_Items]').val(tds.eq(6).data('item'));
                $('[name=Place]').val(tds.eq(7).text());
                $('[name=Amount]').val(tds.eq(8).data('amount'));
                $('[name=Curency]').val(tds.eq(9).text());
                $('[name=Account]').val(tds.eq(10).data('account'));
                $('[name=Pay_Mthd]').val(tds.eq(11).text());
                $('[name=Appl_Date]').val(tds.eq(12).text());
                $('[name=Recipt_Date]').val(tds.eq(13).text());
                $('[name=RefNo]').val(tds.eq(14).text());
                var check = tds.eq(15).find('input').prop('checked');
                if(check)
                    $('[name=Completion]').prop('checked', 'checked');
                else
                    $('[name=Completion]').prop('checked', '');

                check = tds.eq(16).find('input').prop('checked');
                if(check)
                    $('[name=Recipt]').prop('checked', 'checked');
                else
                    $('[name=Recipt]').prop('checked', '');

                $('[name=Remark]').val(tds.eq(17).data('text'));


                var itemId = tds.eq(6).data('item');
                if((itemId == 4) || (itemId == 5) || (itemId == 8)) {
                    showOilSuppleDialog(invoiceId);
                } else {
                    $('#supply_table').html('');
                    $('.add-oli-box').fadeOut();
                }

                $('.chosen-select').chosen();
            });

            $("#invoice-form").validate({
                rules: {
                    ShipID : 'required',
                    Voy: "required",
                    Paid_Voy: "required",
                    Appl_Date: "required",
                },
                messages: {
                    ShipID : '请选择船名。',
                    Voy: "请选择Voy。",
                    Paid_Voy: "请选择Paid_Voy。",
                    Appl_Date: "请选择Appl_Date。",
                }
            });

        });

        function showOilSuppleDialog(invoiceId) {
            $.post("/operation/getSupplyElement", {'_token': token, "invoice": invoiceId }, function (data) {
                if(data){
                    $('#supply_table').html(data);
                    $('.add-oli-box').fadeIn();

                    $('.date-picker').datepicker({autoclose: true}).next().on(ace.click_event, function () {
                        $(this).prev().focus();
                    });
                }
            });

        }

        function deleteOilSupply(that) {
            var tr = that.closest('tr');
            var tds = tr.children();

            var supplyDate = tds.eq(1).find('input').val();
            bootbox.confirm(supplyDate + "的原油供给情况真要删除吗?", function (result) {
                if (result) {
                    tr.remove();
                }
            });

        }

        function createShipOilSupply(that) {
            var tds = that.closest('tr').children();

            var supplyDate = tds.eq(1).find('input').val();
            var place = tds.eq(2).find('input').val();
            var count = tds.eq(6).find('input').val();
            var price = tds.eq(8).find('input').val();

            if((supplyDate.length < 1) || (place.length < 1) || (count.length < 1) || (price.length < 1)) {
                $.gritter.add({
                    title: '错误',
                    text: '请输入关于供给原油的正确的信息。',
                    class_name: 'gritter-error'
                });
                return;
            }
            tds.eq(11).html('<a href="javascript:void(0);" class="red" onclick="deleteOilSupply($(this))"><i class="icon-trash bigger-130"></i></a>');

            var newIndex = tds.eq(0).find('input').val() * 1 + 1;
            var html = '<tr><td class="hidden"><input name="new_'+ newIndex +'" value="' + newIndex +'"></td>' +
                '<td><div class=" input-group" style="padding-left:5px;width:100%">' +
                '<input class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" style="width:75%" name="SUPPLD_DATE_new_' + newIndex + '">' +
                '<span class="input-group-addon" style="float: right;width:25%;"><i class="icon-calendar bigger-110"></i></span>' +
                '</div></td>' +
                '<td><input type="text" class="form-control" name="PLACE_new_' + newIndex + '"></td>' +
                '<td><select class="form-control" name="AC_ITEM_new_' + newIndex + '">' +
                '<option value="DO">DO</option><option value="FO">FO</option>' +
                '<option value="LO">LO</option><option value="FW">FW</option><option value="S&S">S&S</option></select></td>' +
                '<td><input type="text" class="form-control" name="DESCRIPTION_new_' + newIndex + '"></td>' +
                '<td><input type="text" class="form-control" name="PART_NO_new_' + newIndex + '"></td>' +
                '<td><input type="number" class="form-control" name="QTY_new_' + newIndex + '"></td>' +
                '<td>' +
                '<select class="form-control" name="UNIT_new_1">' +
                '<option value="MT">MT</option>' +
                '<option value="Kg">Kg</option>' +
                '<option value="L">L</option>' +
                '</select>' +
                '</td>' +
                '<td><input type="number" class="form-control" name="PRCE_new_' + newIndex + '"></td>' +
                '<td><input type="number" class="form-control" name="AMOUNT_new_' + newIndex + '"></td>' +
                '<td><input type="text" class="form-control" name="REMARK_new_' + newIndex + '"></td>' +
                '<td class="action-buttons">' +
                '<a href="javascript:void(0)" class="red" onclick="createShipOilSupply($(this))"><i class="icon-plus bigger-130"></i></a>' +
                '</td>' +
                '</tr>';

            $('#supply_table').append(html);

            $('.date-picker').datepicker({autoclose: true}).next().on(ace.click_event, function () {
                $(this).prev().focus();
            });
        }

    </script>

@stop
