<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">
            <label class="primary_checkbox d-flex ">
                <input type="checkbox">
                <span class="checkmark"></span>
            </label>
        </th>
        <th scope="col">{{__('setting.Priner Name')}}</th>
        <th scope="col">{{__('setting.Connection Type')}}</th>
        <th scope="col">{{__('setting.Characters Per Line')}}</th>
        <th scope="col">{{__('setting.IP')}}</th>
        <th scope="col">{{__('setting.Post')}}</th>
        <th scope="col">{{__('setting.Port')}}</th>
        <th scope="col">{{__('setting.Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($printers as $key=>$value)
        <tr>

            <th scope="col">
                <label class="primary_checkbox d-flex">
                    <input name="sms1" type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </th>
            <td>{{ $value->name }}</td>
            <td>{{ $value->connection_type }}</td>
            <td>{{ $value->char_per_line }}</td>
            <td>{{ $value->ip }}</td>
            <td>{{ $value->port }}</td>
            <td>{{ $value->path }}</td>

            <td>
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu2" data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        {{__('common.select')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="dropdownMenu2">
                         @if(permissionCheck('printer.edit'))
                        <a href="#" data-toggle="modal" data-target="#Item_Edit"
                           class="dropdown-item edit_model_type"
                           data-value="{{$value->id}}" type="button">{{__('common.Edit')}}</a>
                        @endif
                        @if(permissionCheck('printer.delete'))
                         <a onclick="confirm_modal('{{route('printer.delete', $value->id)}}');" class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
