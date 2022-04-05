<table class="table Crm_table_active3">
    <thead>
    <tr>

        <th scope="col">{{__('common.ID')}}</th>
        <th scope="col">{{__('common.Name')}}</th>
        <th scope="col">{{__('common.Description')}}</th>
        <th scope="col">{{__('common.Status')}}</th>
        <th scope="col">{{__('common.Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($models as $key=>$models_value)
        <tr>

            <th>{{ $key+1 }}</th>
            <td>{{ $models_value->name }}</td>
            <td>{{ $models_value->description }}</td>
            <td>
                @if($models_value->status == 1)
                    <span class="badge_1">{{__('common.Active')}}</span>
                @else
                    <span class="badge_4">{{__('common.DeActive')}}</span>
                @endif
            </td>
            <td>
                <div class="dropdown CRM_dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenu2" data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false">
                        {{__('common.Select')}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="dropdownMenu2">
                         @if(permissionCheck('model.edit'))
                        <a href="#" data-toggle="modal" data-target="#Item_Edit"
                           class="dropdown-item edit_model_type"
                           data-value="{{$models_value->id}}" type="button">{{__('common.Edit')}}</a>
                        @endif

                        @if(permissionCheck('model.destroy') && @$models_value->products->count() == 0)
                            <a onclick="confirm_modal('{{route('model.delete',$models_value->id)}}');" class="dropdown-item ">{{__('common.Delete')}}</a>
                        </a>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
