<div class="hpanel">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-3">
                <h5><strong>{{$option_data['name']}}</strong> </h5>
            </div>

             <div class="col-md-2">
                <h5>Is Required</h5>
             </div>

            <div class="col-md-3">                
                <select name="option[required][{{$option_data['id']}}]" id="option[required][{{$option_data['id']}}]" class="form-control">
                    <option value="0">No</option>
                    <option value="1" selected >Yes</option>
                </select>
            </div>

            <div class="col-md-4 pull-right text-right">
                <button class="btn btn-danger delete-hpanel"><i class="pe-7s-close-circle"></i></button>
            </div>
        </div>
    </div>

    <input type="hidden" name="option[input][{{$option_data['id']}}]" value="">

    <?php /*
    <div class="panel-body">
        <table
            class="option-values-table footable table table-bordered toggle-arrow-tiny default breakpoint footable-loaded"
            data-page-size="8" data-filter="#filter">
            <thead>
                <tr>
                    <th class="footable-visible">Value</span></th>
                </tr>
            </thead>
            <tbody>
                <tr style="display: table-row;" class="footable-even">
                    <td class="footable-visible" colspan="5">
                        <input type="text" class="form-control" name="option[input][{{$option_data['id']}}]" placeholder="{{$option_data['name']}}"
                            required>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>*/?>
</div>
