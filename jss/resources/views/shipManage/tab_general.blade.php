<?php
$isHolder = Session::get('IS_HOLDER');
$shipList = Session::get('shipList');
?>

<div class="row">
    <div class="col-md-12">
        <div class="space-6"></div>
        <div class="col-md-4">
            <div class="table-responsive">
                <table class="table table-bordered general" style="font-weight: bold">
                    <tbody>
                    <tr>
                        <td class="no-padding custom-td-label1" style="text-align: left;width:20%" colspan="2">
                            <span class="text-danger style-header">{{ trans('shipManage.General.ShipName') }}*</span>
                        </td>
                        <td class="custom-td-report-text" style="width: 80%" colspan="2">
                            <input type="text" name="shipName_En" class="form-control" placeholder="{{ trans('shipManage.placeholder.english') }}" style="width:100%" value="@if(isset($shipInfo['shipName_En'])){{$shipInfo['shipName_En']}}@endif" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="no-padding custom-td-label1" style="text-align: left;width:20%" colspan="2">
                            <span class="style-header">{{ trans('shipManage.General.ShipName_Cn') }}</span>
                        </td>
                        <td class="custom-td-report-text" style="width: 80%" colspan="2">
                            <input type="text" name="shipName_Cn" class="form-control" placeholder="{{ trans('shipManage.placeholder.chinese') }}" style="width:100%" value="@if(isset($shipInfo['shipName_Cn'])){{$shipInfo['shipName_Cn']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="no-padding custom-td-label1" style="text-align: left;width:20%" colspan="2">
                            <span class="text-danger style-header">{{ trans('shipManage.General.NickName') }}*</span>
                        </td>
                        <td class="custom-td-report-text" style="width: 80%" colspan="2">
                            <input type="text" name="NickName" class="form-control" placeholder="{{ trans('shipManage.placeholder.ENGLISH') }}" style="width:100%" value="@if(isset($shipInfo['NickName'])){{$shipInfo['NickName']}}@endif" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                            <span class="text-danger style-header">{{ trans('shipManage.General.IMO_No') }}*</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="IMO_No" class="form-control" value="@if(isset($shipInfo['IMO_No'])){{$shipInfo['IMO_No']}}@endif" required minlength="7" maxlength="7">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                            <span class="style-header">{{ trans('shipManage.General.Class') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="Class" class="form-control auto-complete" value="@if(isset($shipInfo['Class'])){{$shipInfo['Class']}}@endif"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                            <span class="style-header">{{ trans('shipManage.General.OfficeNo') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="RegNo" class="form-control" style="width:100%" value="@if(isset($shipInfo['RegNo'])){{$shipInfo['RegNo']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                            <span class="style-header">{{ trans('shipManage.General.RegType') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <select class="form-control" id="RegStatus" name="RegStatus" style="padding:0px!important;color:#12539b!important">
                                @foreach(g_enum('ShipRegStatus') as $key => $item)
                                    <option value="{{ $key }}" {{ isset($shipInfo['RegStatus']) && $shipInfo['RegStatus'] == $key ? 'selected' : '' }}>{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                            <span class="style-header">{{ trans('shipManage.General.CallSign') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="CallSign" class="form-control" style="width:100%" value="@if(isset($shipInfo['CallSign'])){{$shipInfo['CallSign']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                        <span class="style-header">{{ trans('shipManage.General.MMSI') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="MMSI" class="form-control" style="width:100%" value="@if(isset($shipInfo['MMSI'])){{$shipInfo['MMSI']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                        <span class="style-header">{{ trans('shipManage.General.INMARSAT') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="3">
                            <input type="text" name="INMARSAT" class="form-control" style="width:100%" value="@if(isset($shipInfo['INMARSAT'])){{$shipInfo['INMARSAT']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                        <span class="style-header">{{ trans('shipManage.General.OriginalName') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="3">
                            <input type="text" name="OriginalShipName" class="form-control" style="width:100%" value="@if(isset($shipInfo['OriginalShipName'])){{$shipInfo['OriginalShipName']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                            <span class="sub-title style-header">{{ trans('shipManage.General.FormerName1') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="3">
                            <input type="text" name="FormerShipName" class="form-control" style="width:100%" value="@if(isset($shipInfo['FormerShipName'])){{$shipInfo['FormerShipName']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                            <span class="sub-title style-header">{{ trans('shipManage.General.FormerName2') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="3">
                            <input type="text" name="SecondFormerShipName" class="form-control" style="width:100%" value="@if(isset($shipInfo['SecondFormerShipName'])){{$shipInfo['SecondFormerShipName']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                        <span class="style-header">{{ trans('shipManage.General.Flag') }}</span>
                        </td>
                        <td class="custom-td-report-text" style="width: 25%" colspan="2">
                            <input type="text" name="Flag" class="form-control auto-complete" placeholder="英文" style="width:100%" value="@if(isset($shipInfo['Flag'])){{$shipInfo['Flag']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: left" colspan="2">
                        <span class="style-header">{{ trans('shipManage.General.port of Reg') }}</span>
                        </td>
                        <td class="custom-td-report-text" style="width: 25%" colspan="2">
                            <input type="text" name="PortOfRegistry" class="form-control auto-complete" placeholder="英文" style="width:100%" value="@if(isset($shipInfo['PortOfRegistry'])){{$shipInfo['PortOfRegistry']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align: center" rowspan="4">
                        <span class="style-header">{{ trans('shipManage.General.owner') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="3">
                            <input type="text" name="Owner_Cn" class="form-control" style="width:100%" value="@if(isset($shipInfo['Owner_Cn'])){{$shipInfo['Owner_Cn']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="small-title">
                        <span class="style-header">{{ trans('shipManage.General.Owner_Address_Cn') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="OwnerAddress_Cn" class="form-control" style="width:100%" value="@if(isset($shipInfo['OwnerAddress_Cn'])){{$shipInfo['OwnerAddress_Cn']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="small-title">
                        <span class="style-header">{{ trans('shipManage.General.Tel No') }} / {{ trans('shipManage.General.Fax No') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="OwnerTelnumber" class="form-control first-input" value="@if(isset($shipInfo['OwnerTelnumber'])){{$shipInfo['OwnerTelnumber']}}@endif" style="border-right: 1px solid #cccccc!important;">
                            <input type="text" name="OwnerFax" class="form-control second-input" value="@if(isset($shipInfo['OwnerFax'])){{$shipInfo['OwnerFax']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="small-title">
                        <span class="style-header">{{ trans('shipManage.General.Email Address') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="email" name="OwnerEmail" class="form-control" style="width:100%" value="@if(isset($shipInfo['OwnerEmail'])){{$shipInfo['OwnerEmail']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" rowspan="4">
                        <span class="style-header">{{ trans('shipManage.General.ISM') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="3">
                            <input type="text" name="ISM_Cn" class="form-control" style="width:100%" value="@if(isset($shipInfo['ISM_Cn'])){{$shipInfo['ISM_Cn']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="small-title">
                        <span class="style-header">{{ trans('shipManage.General.Address_Cn') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="ISMAddress_Cn" class="form-control" style="width:100%" value="@if(isset($shipInfo['ISMAddress_Cn'])){{$shipInfo['ISMAddress_Cn']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="small-title">
                        <span class="style-header">{{ trans('shipManage.General.Tel No') }} / {{ trans('shipManage.General.Fax No') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="ISMTelnumber" class="form-control first-input" style="border-right: 1px solid #cccccc!important;" value="@if(isset($shipInfo['ISMTelnumber'])){{$shipInfo['ISMTelnumber']}}@endif">
                            <input type="text" name="ISMFax" class="form-control second-input" value="@if(isset($shipInfo['ISMFax'])){{$shipInfo['ISMFax']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="small-title">
                        <span class="style-header">{{ trans('shipManage.General.Email Address') }}</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="ISMEmail" class="form-control" style="width:100%" value="@if(isset($shipInfo['ISMEmail'])){{$shipInfo['ISMEmail']}}@endif">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered general" style="font-weight: bold">
                            <tbody>
                            <tr>
                                <td class="custom-td-label1" colspan="1" style="text-align: left; width: 20%;">
                                <span class="style-header">{{ trans('shipManage.General.Ship Type') }}</span>
                                </td>
                                <td class="custom-td-dec-text">
                                    <!--select class="form-control" id="ShipType" name="ShipType" style="padding:0px!important;color:#12539b!important">
                                        @foreach($shipType as $type)
                                            <option value="{{$type['id']}}" @if($type['id'] == $shipInfo['ShipType']) selected @endif>{{$type['ShipType']}}</option>
                                        @endforeach
                                    </select-->
                                    <?php $sel = "";
                                    $sel_id = 0;
                                    ?>
                                    @foreach ($shipType as $type)
                                        @if ($type->id == $shipInfo['ShipType'])
                                        <?php $sel = $type->ShipType; 
                                        $sel_id = $type->id;
                                        ?>
                                        @endif
                                    @endforeach
                                    <div class="dynamic-select-wrapper">
                                        <div class="dynamic-select" style="color:#12539b">
                                            <input type="hidden"  name="ShipType" value="{{$sel_id}}"/>
                                            <div class="dynamic-select__trigger"><input type="text" class="form-control dynamic-select-span" style="background:white!important;" value="{{$sel}}" readonly>
                                                <div class="arrow"></div>
                                            </div>
                                            <div class="dynamic-options">
                                                <div class="dynamic-options-scroll">
                                                    @if ($sel == "")
                                                    <span class="dynamic-option selected" data-value="" data-text="">&nbsp;</span>
                                                    @else
                                                    <span class="dynamic-option" data-value="" data-text="">&nbsp;</span>
                                                    @endif
                                                    @foreach ($shipType as $type)
                                                        @if ($type->id == $shipInfo['ShipType'])
                                                            <span class="dynamic-option selected" data-value="{{$type->id}}" data-text="{{$type->ShipType}}">{{$type->ShipType}}</span>
                                                        @else
                                                            <span class="dynamic-option" data-value="{{$type->id}}" data-text="{{$type->ShipType}}">{{$type->ShipType}}</span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div>
                                                    <span class="edit-list-btn" id="edit-list-btn" onclick="javascript:openShipTypeList('shiptype')">
                                                        <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left; width: 20%;">
                                    <span class="text-pink style-header">{{ trans('shipManage.General.Hull') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="text" name="Hull" class="form-control" style="width:100%" value="@if(isset($shipInfo['Hull'])){{$shipInfo['Hull']}}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td class="small-title">
                                <span class="style-header">{{ trans('shipManage.General.Notation') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <textarea type="text" name="HullNotation" class="form-control" style="resize: none;" rows="2">{{ isset($shipInfo['HullNotation']) ? $shipInfo['HullNotation'] : '' }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1">
                                    <span class="text-pink style-header">{{ trans('shipManage.General.Machinery') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="text" name="Machinery" class="form-control" style="width:100%" value="@if(isset($shipInfo['Machinery'])){{$shipInfo['Machinery']}}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td class="small-title">
                                <span class="style-header">{{ trans('shipManage.General.Notation') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <textarea type="text" name="MachineryNotation" class="form-control" style="resize: none;" rows="2">{{ isset($shipInfo['MachineryNotation']) ? $shipInfo['MachineryNotation'] : '' }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left; width: 20%;">
                                    <span class="text-pink style-header">{{ trans('shipManage.General.Refrigerater') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="text" name="Refrigerater" class="form-control" style="width:100%" value="@if(isset($shipInfo['Refrigerater'])){{$shipInfo['Refrigerater']}}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td class="small-title">
                                <span class="style-header">{{ trans('shipManage.General.Notation') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <textarea type="text" name="RefrigeraterNotation" class="form-control" style="resize: none;" rows="2">{{ isset($shipInfo['RefrigeraterNotation']) ? $shipInfo['RefrigeraterNotation'] : '' }}</textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-bordered general">
                            <tbody>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left; width: 40%;">
                                <span class="text-danger style-header">{{ trans('shipManage.General.Registration Date') }}*</span>
                                </td>
                                <td class="custom-td-dec-text">
                                    <div class="input-group">
                                        <input class="form-control date-picker" name="RegDate" type="text" style="display: block;" data-date-format="yyyy-mm-dd" value="@if(isset($shipInfo['RegDate'])){{$shipInfo['RegDate']}}@endif" required>
                                        <span class="input-group-addon">
                                            <i class="icon-calendar "></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.Renewal Date') }}</span>
                                </td>
                                <td class="custom-td-dec-text">
                                    <div class="input-group">
                                        <input class="form-control date-picker"
                                               name="RenewDate"
                                               type="text" data-date-format="yyyy-mm-dd"
                                               value="@if(isset($shipInfo['RenewDate'])){{$shipInfo['RenewDate']}}@endif" disabled>
                                        <span class="input-group-addon">
                                                    <i class="icon-calendar "></i>
                                                </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.Expiry Date') }}</span>
                                </td>
                                <td class="custom-td-dec-text">
                                    <div class="input-group">
                                        <input class="form-control date-picker"
                                               name="KCExpiryDate"
                                               type="text" data-date-format="yyyy-mm-dd"
                                               value="@if(isset($shipInfo['KCExpiryDate'])){{$shipInfo['KCExpiryDate']}}@endif" disabled>
                                        <span class="input-group-addon">
                                                    <i class="icon-calendar "></i>
                                                </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left;white-space: nowrap">
                                <span class="style-header">{{ trans('shipManage.General.Conditional Date') }}</span>
                                </td>
                                <td class="custom-td-dec-text">
                                    <div class="input-group">
                                        <input class="form-control date-picker"
                                               name="ConditionalDate"
                                               type="text" data-date-format="yyyy-mm-dd"
                                               value="@if(isset($shipInfo['ConditionalDate'])){{$shipInfo['ConditionalDate']}}@endif" disabled>
                                        <span class="input-group-addon">
                                                    <i class="icon-calendar "></i>
                                                </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.Deletion Date') }}</span>
                                </td>
                                <td class="custom-td-dec-text">
                                    <div class="input-group">
                                        <input class="form-control date-picker"
                                               name="DelDate"
                                               type="text" data-date-format="yyyy-mm-dd"
                                               value="@if(isset($shipInfo['DelDate'])){{$shipInfo['DelDate']}}@endif">
                                        <span class="input-group-addon">
                                                    <i class="icon-calendar "></i>
                                                </span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered general">
                            <tbody>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left; width: 20%;">
                                <span class="style-header">{{ trans('shipManage.General.GrossTon') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="GrossTon" class="form-control" style="width:100%" value="@if(isset($shipInfo['GrossTon'])){{$shipInfo['GrossTon']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.NetTon') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="NetTon" class="form-control" style="width:100%" value="@if(isset($shipInfo['NetTon'])){{$shipInfo['NetTon']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(DeadWeight)mt') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="Deadweight" class="form-control" style="width:100%" value="@if(isset($shipInfo['Deadweight'])){{$shipInfo['Deadweight']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(Displacement)mt') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="Displacement" class="form-control" style="width:100%" value="@if(isset($shipInfo['Displacement'])){{$shipInfo['Displacement']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(Ballast)㎥') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="Ballast" class="form-control" style="width:100%" value="@if(isset($shipInfo['Ballast'])){{$shipInfo['Ballast']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(FuelBunkers)㎥') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="FuelBunker" class="form-control" style="width:100%" value="@if(isset($shipInfo['FuelBunker'])){{$shipInfo['FuelBunker']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="table-responsive">
                        <table class="table table-bordered general">
                            <tbody>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left; width: 20%;">
                                <span class="style-header">{{ trans('shipManage.General.(LOA)m') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="LOA" class="form-control" style="width:100%" value="@if(isset($shipInfo['LOA'])){{$shipInfo['LOA']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(LBP)m') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="LBP" class="form-control" style="width:100%" value="@if(isset($shipInfo['LBP'])){{$shipInfo['LBP']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(Lconvention)m') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="Length" class="form-control" style="width:100%" value="@if(isset($shipInfo['Length'])){{$shipInfo['Length']}}@endif" min="0" autocomplete="off">
                                </td>                                    </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(BM)m') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="BM" class="form-control" style="width:100%" value="@if(isset($shipInfo['BM'])){{$shipInfo['BM']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(DM)m') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="DM" class="form-control" style="width:100%" value="@if(isset($shipInfo['DM'])){{$shipInfo['DM']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left;">
                                <span class="style-header">{{ trans('shipManage.General.(Draught)m') }}</span>
                                </td>
                                <td class="custom-td-report-text">
                                    <input type="number" name="Draught" class="form-control" style="width:100%" value="@if(isset($shipInfo['Draught'])){{$shipInfo['Draught']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <div class="table-responsive">
                        <table class="table table-bordered general" style="font-weight: bold">
                            <tbody>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left; width: 20%;">
                                <span class="style-header">{{ trans('shipManage.General.(ShipBuilder)m') }}</span>
                                </td>
                                <td class="custom-td-report-text" colspan="3">
                                    <input type="text" name="ShipBuilder" class="form-control" style="width:100%" value="@if(isset($shipInfo['ShipBuilder'])){{$shipInfo['ShipBuilder']}}@endif">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.BuildDate/Place') }}</span>
                                </td>
                                <td class="custom-td-report-text" colspan="3">
                                    <input type="text" name="BuildPlace_Cn" class="form-control" style="width:100%" value="@if(isset($shipInfo['BuildPlace_Cn'])){{$shipInfo['BuildPlace_Cn']}}@endif">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered general">
                            <tbody>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left; width: 20%;">
                                <span class="style-header">{{ trans('shipManage.General.(KeelDate)m') }}</span>
                                </td>
                                <td class="custom-td-report-text keel-date">
                                    <div class="input-group">
                                        <input class="form-control date-picker"
                                               name="KeelDate"
                                               type="text" data-date-format="yyyy-mm-dd"
                                               value="@if(isset($shipInfo['KeelDate'])){{$shipInfo['KeelDate']}}@endif">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar "></i>
                                    </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                            <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(LaunchDate)m') }}</span>
                                </td>
                                <td class="custom-td-report-text keel-date">
                                    <div class="input-group">
                                        <input class="form-control date-picker"
                                               name="LaunchDate"
                                               type="text" data-date-format="yyyy-mm-dd"
                                               value="@if(isset($shipInfo['LaunchDate'])){{$shipInfo['LaunchDate']}}@endif">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar "></i>
                                    </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(DeliveryDate)m') }}</span>
                                </td>
                                <td class="custom-td-report-text keel-date">
                                    <div class="input-group">
                                        <input class="form-control date-picker"
                                               name="DeliveryDate"
                                               type="text" data-date-format="yyyy-mm-dd"
                                               value="@if(isset($shipInfo['DeliveryDate'])){{$shipInfo['DeliveryDate']}}@endif">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar "></i>
                                    </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left">
                                <span class="style-header">{{ trans('shipManage.General.(ConversionDate)m') }}</span>
                                </td>
                                <td class="custom-td-report-text keel-date" style="width:100%!important">
                                    <div class="input-group">
                                        <input class="form-control date-picker"
                                               name="ConversionDate"
                                               type="text" data-date-format="yyyy-mm-dd"
                                               value="@if(isset($shipInfo['ConversionDate'])){{$shipInfo['ConversionDate']}}@endif">
                                        <span class="input-group-addon">
                                        <i class="icon-calendar "></i>
                                    </span>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="table-responsive">
                        <table class="table table-bordered general">
                            <tbody>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left; width: 20%;">
                                <span class="style-header">{{ trans('shipManage.General.(Bridge)m') }}</span>
                                </td>
                                <td class="custom-td-report-text keel-date" style="width:100%!important">
                                    <input type="number" name="DeckErection_B" class="form-control" style="width:100%" value="@if(isset($shipInfo['DeckErection_B'])){{$shipInfo['DeckErection_B']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left;">
                                <span class="style-header">{{ trans('shipManage.General.(Forecastle)m') }}</span>
                                </td>
                                <td class="custom-td-report-text keel-date">
                                    <input type="number" name="DeckErection_F" class="form-control" style="width:100%" value="@if(isset($shipInfo['DeckErection_F'])){{$shipInfo['DeckErection_F']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left;">
                                <span class="style-header">{{ trans('shipManage.General.(Poop)m') }}</span>
                                </td>
                                <td class="custom-td-report-text keel-date">
                                    <input type="number" name="DeckErection_P" class="form-control" value="@if(isset($shipInfo['DeckErection_P'])){{$shipInfo['DeckErection_P']}}@endif" min="0" autocomplete="off">
                                </td>                         </tr>
                            <tr>
                                <td class="custom-td-label1" style="text-align: left;">
                                <span class="style-header">{{ trans('shipManage.General.(Deckhouse)m') }}</span>
                                </td>
                                <td class="custom-td-report-text keel-date">
                                    <input type="number" name="DeckErection_H" class="form-control" value="@if(isset($shipInfo['DeckErection_H'])){{$shipInfo['DeckErection_H']}}@endif" min="0" autocomplete="off">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>