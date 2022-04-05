<table class="table Crm_table_active3">
    <thead>
    <tr>

        <th scope="col">{{__('common.ID')}}</th>
        <th scope="col">{{__('common.Unit Type')}}</th>
        <th scope="col">{{__('common.Description')}}</th>
        <th scope="col">{{__('common.Status')}}</th>
        <th scope="col">{{__('common.Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($unit_types as $key=>$unit_type_value)
        <tr>


            <th>{{ $key+1 }}</th>
            <td>{{ $unit_type_value->name }}</td>
            <td>{{ $unit_type_value->description }}</td>
            <td>
                @if($unit_type_value->status == 1)
                    <span class="badge_1">{{__('common.Active')}}</span>
                @else
                    <span class="badge_4">{{__('common.DeActive')}}</span>
                @endif
            </td>
            <td>
                <!-- shortby  -->
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu2" data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        {{__('common.Select')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="dropdownMenu2">
                         @if(permissionCheck('unit_type.edit'))
                        <a href="#" data-toggle="modal" data-target="#Item_Edit"
                           class="dropdown-item edit_unit_type"
                           data-value="{{$unit_type_value->id}}" type="button">{{__('common.Edit')}}</a>
                        @endif
                        @if(permissionCheck('unit_type.destroy') && @$unit_type_value->products->count() == 0)

                        <a onclick="confirm_modal('{{route('unit_type.delete',$unit_type_value->id)}}');" class="dropdown-item ">{{__('common.Delete')}}</a>
                        @endif
                    </div>
                </div>
                <!-- shortby  -->
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
