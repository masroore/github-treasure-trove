<div class="space-4"></div>
<div class="row">
    <div class="col-md-12">
        <input class="hidden" name="_token" value="{{csrf_token()}}">
        <input class="hidden" name="memberId" value="{{$memberId}}">
        <div class="col-md-12">
            <div class="space-4"></div>
                <table class="table table-bordered">
                    <tbody>
                        <tr class="">
                            <td class="center sub-header style-bold-italic" style="width:3%">No</td>
                            <td class="center sub-header style-bold-italic" style="width:40%">Type of certificates</td>
                            <td class="center sub-header style-bold-italic" style="width:15%">Certificates No</td>
                            <td class="center sub-header style-bold-italic" style="width:15%">Issue Date</td>
                            <td class="center sub-header style-bold-italic" style="width:15%">Expiry Date</td>
                            <td class="center sub-header style-bold-italic" style="">Issued by</td>
                        </tr>
                        @for($index=0;$index<5;$index++)
                        <tr>
                            <td class="center sub-small-header" style="">
                                {{$index + 1}}
                            </td>
                            @if($index == 0)
                            <td class="td-header sub-small-header" style="">
                                <input type="text" class="form-control style-bold-italic" name="Other_Name[]" style="padding-left: 0px!important;width: 100%;background:transparent!important;" value="Medical Certificate for Seafarers" readonly autocomplete="off">
                            </td>
                            @else
                            <td class="no-padding style-bold-italic">
                                <input type="text" class="form-control style-bold-italic" name="Other_Name[]" style="padding-left: 2px!important;width: 100%;" value="@if(isset($othercert[$index])){{$othercert[$index]->CertName}}@endif" autocomplete="off">
                            </td>    
                            @endif
                            <td class="center no-padding">
                                <input type="text" class="form-control" name="Other_CertNo[]" style="width: 100%;text-align: center" value="@if(isset($othercert[$index])){{$othercert[$index]->CertNo}}@endif" autocomplete="off">
                            </td>
                            <td class="center no-padding">
                                <div class="input-group">
                                    <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="Other_CertIssue[]"
                                        value="@if(isset($othercert[$index])){{$othercert[$index]->IssueDate}}@endif" autocomplete="off">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </td>
                            <td class="center no-padding">
                                <div class="input-group">
                                    <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="Other_CertExpire[]"
                                        value="@if(isset($othercert[$index])){{$othercert[$index]->ExpireDate}}@endif" autocomplete="off">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </td>
                            <td class="center no-padding">
                                <input type="text" class="form-control" name="Other_IssuedBy[]" style="width: 100%;text-align: center" value="@if(isset($othercert[$index])){{$othercert[$index]->IssuedBy}}@endif" autocomplete="off">
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
    </div>
</div>

