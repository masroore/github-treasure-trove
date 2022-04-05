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
                            <td class="center sub-header style-bold-italic" style="width:25%">Type of certificates</td>
                            <td class="center sub-header style-bold-italic" style="width:15%">STCW Clause</td>
                            <td class="center sub-header style-bold-italic" style="width:15%">Certificates No</td>
                            <td class="center sub-header style-bold-italic" style="width:13%">Issue Date</td>
                            <td class="center sub-header style-bold-italic" style="width:13%">Expiry Date</td>
                            <td class="center sub-header style-bold-italic" style="">Issued by</td>
                        </tr>
                        <?php $index = 0; ?>
                        @if($security != null)
                        @foreach($security as $cert)
                        <tr>
                            <td class="center sub-small-header" style="">
                                {{$index + 1}}
                            </td>
                            <td class="td-header sub-small-header style-bold-italic" style="">
                                {{$cert->title}}
                            </td>
                            <td class="center no-padding">
                                <input type="text" class="form-control" name="Train_STCW[]" style="width: 100%;text-align: center" value="@if(isset($training[$index])){{$training[$index]->STCW}}@endif" autocomplete="off">
                            </td>
                            <td class="center no-padding">
                                <input type="text" class="form-control" name="Train_CertNo[]" style="width: 100%;text-align: center" value="@if(isset($training[$index])){{$training[$index]->CertNo}}@endif" autocomplete="off">
                            </td>
                            <td class="center no-padding">
                                <div class="input-group">
                                    <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="Train_CertIssue[]"
                                        value="@if(isset($training[$index])){{$training[$index]->IssueDate}}@endif" autocomplete="off">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </td>
                            <td class="center no-padding">
                                <div class="input-group">
                                    <input class="form-control date-picker" style="width: 100%;text-align: center"
                                        type="text" data-date-format="yyyy-mm-dd"
                                        name="Train_CertExpire[]"
                                        value="@if(isset($training[$index])){{$training[$index]->ExpireDate}}@endif" autocomplete="off">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </td>
                            <td class="center no-padding">
                                <input type="text" class="form-control" name="Train_IssuedBy[]" style="width: 100%;text-align: center" value="@if(isset($training[$index])){{$training[$index]->IssuedBy}}@endif" autocomplete="off">
                            </td>
                        </tr>
                        <?php $index++?>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
    </div>
</div>

