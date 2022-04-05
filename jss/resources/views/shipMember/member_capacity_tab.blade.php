<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <input class="hidden" name="_token" value="{{csrf_token()}}">
        <input class="hidden" name="memberId" value="{{$memberId}}">
        <div class="col-md-12">
            <div class="space-4"></div>
            <table class="table table-bordered" style="table-layout:fixed;">
                <tbody>
                    <tr class="">
                        <td class="center sub-header style-bold-italic" style="width:3%">No</td>
                        <td class="center sub-header style-bold-italic" style="width:28%">Type of certificates</td>
                        <td class="center sub-header style-bold-italic" style="width:30%">Capacity</td>
                        <td class="center sub-header style-bold-italic" style="width:13%">Certificates No</td>
                        <td class="center sub-header style-bold-italic" style="width:9%">Issue Date</td>
                        <td class="center sub-header style-bold-italic" style="width:9%">Expire Date</td>
                        <td class="center sub-header style-bold-italic" style="">Issued by</td>
                    </tr>
                    <tr>
                        <td class="center sub-small-header" style="">
                            1
                        </td>
                        <td class="no-padding sub-small-header style-bold-italic" style="">
                            COC: Certificate of Competency (for Officerts only)
                        </td>
                        <td class="no-padding">
                            <?php $cap = "";
                            $capacity_id = 0; ?>
                            @foreach ($capacityList as $type)
                                @if ($type->id == $capacity['CapacityID'])
                                <?php $cap = $type->Capacity_En; 
                                $capacity_id = $type->id;
                                ?>
                                @endif
                            @endforeach
                            <div class="dynamic-select-wrapper">
                                <div class="dynamic-select" style="color:#12539b">
                                    <input type="hidden"  name="CapacityID" value="{{$capacity_id}}"/>
                                    <div class="dynamic-select__trigger"><input type="text" class="form-control dynamic-select-span" value="{{$cap}}" readonly>
                                        <div class="arrow"></div>
                                    </div>
                                    <div class="dynamic-options" style="width:456px;">
                                        <div class="dynamic-options-scroll">
                                            @if ($cap == "")
                                            <span class="dynamic-option selected" data-value="" data-text="" style="width:437px">&nbsp;</span>
                                            @else
                                            <span class="dynamic-option" data-value="" data-text="" style="width:437px">&nbsp;</span>
                                            @endif
                                            @foreach ($capacityList as $type)
                                                @if ($type->id == $capacity['CapacityID'])
                                                <span class="dynamic-option selected" data-value="{{$type->id}}" data-text="{{$type->Capacity_En}}" style="width:437px">{{$type->Capacity_En}}</span>
                                                @else
                                                <span class="dynamic-option" data-value="{{$type->id}}" data-text="{{$type->Capacity_En}}" style="width:437px">{{$type->Capacity_En}}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div>
                                            <span class="edit-list-btn" id="edit-list-btn" onclick="javascript:openCapacityList('capacity')">
                                                <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="ItemNo" value="{{$capacity['ItemNo']}}" style="width: 100%;text-align: center">
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="COC_IssuedDate"
                                        value="{{$capacity['COC_IssuedDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="COC_ExpiryDate"
                                        value="{{$capacity['COC_ExpiryDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="COC_Remarks" value="{{$capacity['COC_Remarks']}}" style="width: 100%;text-align: center">
                        </td>
                    </tr>
                    <tr>
                        <td class="center sub-small-header" style="">
                            2
                        </td>
                        <td class="no-padding sub-small-header style-bold-italic" style="">
                            COE: Certificate of Endorsement (by third Flag only)
                        </td>
                        <td class="no-padding">
                            <?php $cap = "";
                            $capacity_id = 0;
                             ?>
                            @foreach ($capacityList as $type)
                                @if ($type->id == $capacity['COEId'])
                                <?php $cap = $type->Capacity_En; 
                                $capacity_id = $type->id;
                                ?>
                                @endif
                            @endforeach
                            <div class="dynamic-select-wrapper">
                                <div class="dynamic-select" style="color:#12539b">
                                    <input type="hidden"  name="COEId" value="{{$capacity_id}}"/>
                                    <div class="dynamic-select__trigger"><input type="text" class="form-control dynamic-select-span" value="{{$cap}}" readonly>
                                        <div class="arrow"></div>
                                    </div>
                                    <div class="dynamic-options" style="width:456px;">
                                        <div class="dynamic-options-scroll">
                                            @if ($cap == "")
                                            <span class="dynamic-option selected" data-value="" data-text="" style="width:437px">&nbsp;</span>
                                            @else
                                            <span class="dynamic-option" data-value="" data-text="" style="width:437px">&nbsp;</span>
                                            @endif
                                            @foreach ($capacityList as $type)
                                                @if ($type->id == $capacity['COEId'])
                                                <span class="dynamic-option selected" data-value="{{$type->id}}" data-text="{{$type->Capacity_En}}" style="width:437px">{{$type->Capacity_En}}</span>
                                                @else
                                                <span class="dynamic-option" data-value="{{$type->id}}" data-text="{{$type->Capacity_En}}" style="width:437px">{{$type->Capacity_En}}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div>
                                            <span class="edit-list-btn" id="edit-list-btn" onclick="javascript:openCapacityList('capacity')">
                                                <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--select class="form-control" name="COEId">
                                <option value="0">&nbsp;</option>
                                @foreach($capacityList as $type)
                                <option value="{{$type['id']}}" @if($capacity['COEId'] == $type['id'])) selected @endif>{{$type['Capacity_En']}}</option>
                                @endforeach
                            </select-->
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="COENo" value="{{$capacity['COENo']}}" style="width: 100%;text-align: center">
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="COE_IssuedDate"
                                        value="{{$capacity['COE_IssuedDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="COE_ExpiryDate"
                                        value="{{$capacity['COE_ExpiryDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="COE_Remarks" value="{{$capacity['COE_Remarks']}}" style="width: 100%;text-align: center">
                        </td>
                    </tr>
                    <tr>
                        <td class="center sub-small-header" style="">
                            3
                        </td>
                        <td class="no-padding sub-small-header style-bold-italic" style="" colspan="2">
                            GOC: GMDSS general operator (for Officerts only)
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="GMDSS_NO" value="{{$capacity['GMDSS_NO']}}" style="width: 100%;text-align: center">
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="GMD_IssuedDate"
                                        value="{{$capacity['GMD_IssuedDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="GMD_ExpiryDate"
                                        value="{{$capacity['GMD_ExpiryDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="GMD_Remarks" value="{{$capacity['GMD_Remarks']}}" style="width: 100%;text-align: center">
                        </td>
                    </tr>
                    <tr>
                        <td class="center sub-small-header" style="">
                            4
                        </td>
                        <td class="no-padding sub-small-header style-bold-italic" style="" colspan="2">
                            GOC Endorsement (by third Flag only)
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="COE_GOCNo" value="{{$capacity['COE_GOCNo']}}" style="width: 100%;text-align: center">
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="COE_GOC_IssuedDate"
                                        value="{{$capacity['COE_GOC_IssuedDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="COE_GOC_ExpiryDate"
                                        value="{{$capacity['COE_GOC_ExpiryDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="COE_GOC_Remarks" value="{{$capacity['COE_GOC_Remarks']}}" style="width: 100%;text-align: center">
                        </td>
                    </tr>
                    <tr>
                        <td class="center sub-small-header" style="">
                            5
                        </td>
                        <td class="no-padding" style="" colspan="2">
                            <select class="form-control style-bold-italic sub-small-header" name="WatchID" style="height:18px;padding:0px!important;-webkit-appearance: none;">
                                <option value="0" @if($capacity['WatchID'] == 0)) selected @endif>Navigation watch rating</option>
                                <option value="1" @if($capacity['WatchID'] == 1)) selected @endif>Engineroom watch rating</option>
                            </select>
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="WatchNo" value="{{$capacity['WatchNo']}}" style="width: 100%;text-align: center">
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="Watch_IssuedDate"
                                        value="{{$capacity['Watch_IssuedDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="input-group">
                                <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="Watch_ExpiryDate"
                                        value="{{$capacity['Watch_ExpiryDate']}}">
                                                        <span class="input-group-addon">
                                                            <i class="icon-calendar bigger-110"></i>
                                                        </span>
                            </div>
                        </td>
                        <td class="no-padding">
                            <input type="text" class="form-control" name="Watch_Remarks" value="{{$capacity['Watch_Remarks']}}" style="width: 100%;text-align: center">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="space-2"></div>
        </div>
    </div>
</div>