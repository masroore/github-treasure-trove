<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">
            <div class="table-responsive">
                <table class="table table-bordered general">
                    <tbody>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left">
                            <span class="text-danger style-header">Seamanbook No*</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="crewNum" class="form-control" maxlength="12" style="width:100%" value="@if(isset($info)){{$info['crewNum']}}@endif" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left">
                            <span class="text-danger style-header">Name in English*</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="realname" class="form-control" style="width:100%" value="@if(isset($info)){{$info['realname']}}@endif" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left">
                            <span class="style-header">Name in Chinese</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="GivenName" class="form-control" style="width:100%" value="@if(isset($info)){{$info['GivenName']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left">
                            <span class="style-header">Gender</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <select class="form-control" name="Sex" style="padding:0px!important;color:#12539b!important">
                                <option value="0" @if(isset($info) && ($info['Sex'] == 0)) selected @endif>{{trans('shipMember.captions.male')}}</option>
                                <option value="1" @if(isset($info) && ($info['Sex'] == 1)) selected @endif>{{trans('shipMember.captions.female')}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left">
                            <span class="style-header">Birthday</span>
                        </td>
                        <td class="custom-td-dec-text">
                            <div class="input-group">
                                <input class="form-control date-picker"
                                    name="birthday"
                                    type="text" data-date-format="yyyy-mm-dd"
                                    value="@if(isset($info)){{$info['birthday']}}@endif">
                                <span class="input-group-addon">
                                            <i class="icon-calendar "></i>
                                        </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1">
                            <span class="style-header">BirthPlace</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2">
                            <input type="text" name="BirthPlace" class="form-control first-input" value="@if(isset($info)){{$info['BirthPlace']}}@endif" placeholder="" style="border-right: 1px solid #cccccc!important;" autocomplete="true">
                            <input type="text" name="BirthCountry" class="form-control second-input" value="@if(isset($info)){{$info['BirthCountry']}}@endif" placeholder="" autocomplete="true">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left">
                            <span class="style-header">Issued Date</span>
                        </td>
                        <td class="custom-td-dec-text">
                            <div class="input-group">
                                <input class="form-control date-picker"
                                    name="IssuedDate"
                                    type="text" data-date-format="yyyy-mm-dd"
                                    value="@if(isset($info)){{$info['IssuedDate']}}@endif">
                                <span class="input-group-addon">
                                            <i class="icon-calendar "></i>
                                        </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left">
                            <span class="style-header">Expire Date</span>
                        </td>
                        <td class="custom-td-dec-text">
                            <div class="input-group">
                                <input class="form-control date-picker"
                                    name="ExpiryDate"
                                    type="text" data-date-format="yyyy-mm-dd"
                                    value="@if(isset($info)){{$info['ExpiryDate']}}@endif">
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
        <div class="col-md-8" style="padding-right:0!important;">
            <div class="table-responsive">
                <table class="table table-bordered general">
                    <tbody>
                    <tr>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%">
                            <span class="text-danger style-header" disabled>Passport No</span>
                        </td>
                        <td class="custom-td-report-text" style="width: 40%">
                            <input type="text" name="PassportNo" class="form-control" style="width:100%" value="@if(isset($info)){{$info['PassportNo']}}@endif">
                        </td>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%;margin-left:20px;">
                            <span class="text-danger style-header">Ship Name</span>
                        </td>
                        <td class="custom-td-report-text" style="width:30%;">
                            <select name="ShipId" class="form-control" style="padding:0px!important;color:#12539b!important">
                                <option value="0">&nbsp;</option>
                                @foreach($shipList as $ship)
                                    <option value="{{$ship['IMO_No']}}" @if($info['ShipId'] == $ship['IMO_No'])) selected @endif>{{$ship['shipName_En']}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td rowspan="6" style="width:10%">
                            <span class="profile-picture">
                                <img id="avatar" class="editable img-responsive" src="@if(isset($info) && $info['crewPhoto'] != '' && !empty($info['crewPhoto'])) /uploads/crewPhoto/{{$info['crewPhoto']}} @endif" alt="照片">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left;width:10%">
                            <span class="text-danger style-header">Nationality*</span>
                        </td>
                        <td class="custom-td-report-text" style="width: 40%">
                            <div class="dynamic-select-wrapper">
                                <div class="dynamic-select" style="color:#12539b">
                                    <input type="hidden"  name="Nationality" value="@if(isset($info)){{$info['Nationality']}}@endif"/>
                                    <div class="dynamic-select__trigger"><input type="text" class="form-control dynamic-select-span" style="background:white!important;" value="@if(isset($info)){{$info['Nationality']}}@endif" readonly>
                                        <div class="arrow"></div>
                                    </div>
                                    <div class="dynamic-options">
                                        <div class="dynamic-options-scroll">
                                            @if ($info['Nationality'] == "")
                                            <span class="dynamic-option selected" data-value="" data-text="">&nbsp;</span>
                                            @else
                                            <span class="dynamic-option" data-value="" data-text="">&nbsp;</span>
                                            @endif
                                            @foreach ($nationList as $item)
                                                @if ($item->name == $info['Nationality'])
                                                <span class="dynamic-option selected" data-value="{{$item->name}}" data-text="{{$item->name}}">{{$item->name}}</span>
                                                @else
                                                <span class="dynamic-option" data-value="{{$item->name}}" data-text="{{$item->name}}">{{$item->name}}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div>
                                            <span class="edit-list-btn" id="edit-list-btn" onclick="javascript:openDynamicPopup('nationality')">
                                                <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%;margin-left:20px;">
                            <span class="style-header">Rank(职务)</span>
                        </td>
                        <td style="width:40%;">
                            <?php $rank = "";
                            $rank_id = 0;
                                ?>
                            @foreach ($posList as $item)
                                @if ($item->id == $info['DutyID_Book'])
                                <?php $rank = $item->Abb; 
                                $rank_id = $item->id;
                                ?>
                                @endif
                            @endforeach
                            <div class="dynamic-select-wrapper">
                                <div class="dynamic-select" style="color:#12539b">
                                    <input type="hidden"  name="DutyID_Book" value="{{$rank_id}}"/>
                                    <div class="dynamic-select__trigger"><input type="text" class="form-control dynamic-select-span" style="background:white!important;" value="{{$rank}}" readonly>
                                        <div class="arrow"></div>
                                    </div>
                                    <div class="dynamic-options" style="width:315px;">
                                        <div class="dynamic-options-scroll">
                                            @if ($rank == "")
                                            <span class="dynamic-option selected" data-value="" data-text="">&nbsp;</span>
                                            @else
                                            <span class="dynamic-option" data-value="" data-text="">&nbsp;</span>
                                            @endif
                                            @foreach ($posList as $item)
                                                @if ($item->id == $info['DutyID_Book'])
                                                    <span class="dynamic-option selected" data-value="{{$item->id}}" data-text="{{$item->Abb}}">{{$item->Duty_En.' ('.$item->Abb.')'}}</span>
                                                @else
                                                    <span class="dynamic-option" data-value="{{$item->id}}" data-text="{{$item->Abb}}">{{$item->Duty_En.' ('.$item->Abb.')'}}</span>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div>
                                            <span class="edit-list-btn" id="edit-list-btn" onclick="javascript:openRankList('rank')">
                                                <img src="{{ cAsset('assets/img/list-edit.png') }}" alt="Edit List Items">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%">
                            <span class="style-header">Issued Date</span>
                        </td>
                        <td class="custom-td-report-text" style="width:40%;">
                            <div class="input-group">
                                <input class="form-control date-picker"
                                    name="PassportIssuedDate"
                                    type="text" data-date-format="yyyy-mm-dd"
                                    value="@if(isset($info)){{$info['PassportIssuedDate']}}@endif">
                                <span class="input-group-addon">
                                    <i class="icon-calendar "></i>
                                </span>
                            </div>
                        </td>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%;margin-left:20px;">
                            <span class="style-header">Wage (Month)</span>
                        </td>
                        <td class="custom-td-report-text" style="width:40%;">
                            <select onchange="javascript:selectCurrency()" class="form-control currency-type" name="WageCurrency" id="wageCurrency" style="border-right: 1px solid #cccccc!important;color:@if(isset($info) && ($info['WageCurrency'] == 0)) red!important; @else #12539b!important; @endif">
                                <option value="0" @if(isset($info) && ($info['WageCurrency'] == 0)) selected @endif style="color:red!important;">{{g_enum('CurrencyLabel')['CNY']}}</option>
                                <option value="1" @if(isset($info) && ($info['WageCurrency'] == 1)) selected @endif style="color:#12539b!important;">{{g_enum('CurrencyLabel')['USD']}}</option>
                                <!--option value="2" @if(isset($info) && ($info['WageCurrency'] == 2)) selected @endif>{{g_enum('CurrencyLabel')['OTHER']}}</option-->
                            </select>
                            <input type="text" name="Salary" class="form-control currency-input" value="@if(isset($info)){{$info['Salary']}}@endif" placeholder="">
                        </td>
                    </tr>
                    <tr>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%">
                            <span class="style-header">Expire Date</span>
                        </td>
                        <td class="custom-td-report-text" style="width:40%;">
                            <div class="input-group">
                                <input class="form-control date-picker"
                                    name="PassportExpiryDate"
                                    type="text" data-date-format="yyyy-mm-dd"
                                    value="@if(isset($info)){{$info['PassportExpiryDate']}}@endif">
                                <span class="input-group-addon">
                                    <i class="icon-calendar "></i>
                                </span>
                            </div>
                        </td>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%;margin-left:20px;">
                            <span class="style-header">Date (Sign On)</span>
                        </td>
                        <td class="custom-td-report-text" style="width:40%">
                            <div class="input-group">
                                <input class="form-control date-picker"
                                    name="DateOnboard"
                                    type="text" data-date-format="yyyy-mm-dd"
                                    value="@if(isset($info)){{$info['DateOnboard']}}@endif">
                                <span class="input-group-addon">
                                    <i class="icon-calendar "></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left;width:10%">
                            <span class="style-header">身份证号</span>
                        </td>
                        <td class="custom-td-report-text" style="width:40%">
                            <input type="text" name="CertNo" class="form-control d-in-block" style="width:100%" value="@if(isset($info)){{$info['CertNo']}}@endif">
                        </td>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%;margin-left:20px;">
                            <span class="style-header">Port (Sign On)</span>
                        </td>
                        <td style="width:40%">
                            <input type="text" name="PortID_Book" class="form-control d-in-block" style="width:100%" value="@if(isset($info)){{$info['PortID_Book']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left;width:10%">
                            <span class="style-header">身份手机</span>
                        </td>
                        <td class="custom-td-report-text" style="width:40%">
                            <input type="text" name="phone" class="form-control" style="width:100%" value="@if(isset($info)){{$info['phone']}}@endif" placeholder="">
                        </td>
                        <td class="no-padding custom-td-label1" style="text-align:left;width:10%;margin-left:20px;">
                            <span class="style-header">Date (Sign Off)</span>
                        </td>
                        <td class="custom-td-report-text" style="width:40%">
                            <div class="input-group">
                                <input class="form-control date-picker"
                                    name="DateOffboard"
                                    type="text" data-date-format="yyyy-mm-dd"
                                    value="@if(isset($info)){{$info['DateOffboard']}}@endif">
                                <span class="input-group-addon">
                                    <i class="icon-calendar "></i>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left;width:10%">
                            <span class="style-header">家属手机</span>
                        </td>
                        <td class="custom-td-report-text" style="width:40%">
                            <input type="text" name="OtherContacts" class="form-control" style="width:100%" value="@if(isset($info)){{$info['OtherContacts']}}@endif">
                        </td>
                        <td class="custom-td-label1" style="text-align:left;width:10%;margin-left:20px;">
                            <span class="style-header">HomeAddress</span>
                        </td>
                        <td class="custom-td-report-text" colspan="2" style="width:40%;">
                            <input type="text" name="address" class="form-control" style="width:100%" value="@if(isset($info)){{$info['address']}}@endif">
                        </td>
                    </tr>
                    <tr>
                        <td class="custom-td-label1" style="text-align:left;width:10%">
                            <span class="style-header">Bank Information</span>
                        </td>
                        <td class="custom-td-report-text" colspan="4">
                            <input type="text" name="BankInformation" class="form-control" style="width:100%" value="@if(isset($info)){{$info['BankInformation']}}@endif">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <div class="blue td-header">Last Three Sea service Record</div>
        <table class="table table-bordered">
            <tbody id="history_table">
            <tr class="">
                <td class="center sub-header style-bold-italic" style="width:10%">From</td>
                <td class="center sub-header style-bold-italic" style="width:10%">To</td>
                <td class="center sub-header style-bold-italic" style="width:20%">Ship Name</td>
                <td class="center sub-header style-bold-italic" style="width:15%">Rank</td>
                <td class="center sub-header style-bold-italic" style="width:6%">GT</td>
                <td class="center sub-header style-bold-italic" style="width:8%">Ship Type</td>
                <td class="center sub-header style-bold-italic" style="width:8%">Power (kW)</td>
                <td class="center sub-header style-bold-italic" style="width:18%">Trading Area</td>
                <td class="center sub-header style-bold-italic"></td>
            </tr>
            @if($historyList != null)
            @foreach($historyList as $history)
                <tr>
                    <td class="no-padding">
                        <div class="input-group">
                            <input onfocus="addHistory(this)" class="form-control date-picker" style="width: 100%;text-align: center"
                                type="text" data-date-format="yyyy-mm-dd"
                                name="FromDate[]"
                                value="{{$history['FromDate']}}" autocomplete="off">
                            <span class="input-group-addon">
                                <i class="icon-calendar bigger-110"></i>
                            </span>
                        </div>
                    </td>
                    <td class="no-padding">
                        <div class="input-group">
                            <input onfocus="addHistory(this)" class="form-control date-picker" style="width: 100%;text-align: center"
                                type="text" data-date-format="yyyy-mm-dd"
                                name="ToDate[]"
                                value="{{$history['ToDate']}}" autocomplete="off">
                            <span class="input-group-addon">
                                <i class="icon-calendar bigger-110"></i>
                            </span>
                        </div>
                    </td>
                    <td class="no-padding">
                        <input onfocus="addHistory(this)" type="text" class="form-control" name="ShipName[]" 
                            value="{{$history['Ship']}}" style="width: 100%;text-align: center" autocomplete="off">
                    </td>
                    <td class="no-padding">
                        <select onfocus="addHistory(this)" name="DutyID[]" class="form-control" style="padding:0px!important;color:#12539b!important">
                            <option value="0" @if($history['DutyID'] == '0') selected @endif>&nbsp;</option>
                            @foreach($posList as $pos)
                                <option value="{{$pos['id']}}" @if($history['DutyID'] == $pos['id']) selected @endif>{{$pos['Duty_En']}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="no-padding">
                        <input onfocus="addHistory(this)" type="text" class="form-control" name="GT[]"
                            value="{{$history['GrossTonage']}}" style="width: 100%;text-align: center" autocomplete="off">
                    </td>
                    <td class="no-padding">
                        <select onfocus="addHistory(this)" class="form-control" style="padding:0px!important;color:#12539b!important" name="ShipType[]">
                            <option value="0" @if($history['ShipType'] == 0) selected @endif></option>
                            @foreach($typeList as $type)
                                <option value="{{$type['id']}}" @if($type['id'] == $history['ShipType']) selected @endif>{{$type['ShipType']}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="no-padding">
                        <input onfocus="addHistory(this)" type="text" class="form-control" name="Power[]"
                            value="{{$history['Power']}}" style="width: 100%;text-align: center" autocomplete="off">
                    </td>
                    <td class="no-padding">
                        <input onfocus="addHistory(this)" type="text" class="form-control" name="TradingArea[]"
                            value="{{$history['SailArea']}}" style="width: 100%;text-align: center" autocomplete="off">
                    </td>
                    <td class="center no-padding">
                        <div class="action-buttons">
                            <a class="red" onclick="javascript:deleteHistory(this)">
                                <i class="icon-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>    
