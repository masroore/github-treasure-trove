<table class="table Crm_table_active3">
    <thead>
    <tr>

        <th scope="col">{{__('common.ID')}}</th>
        <th scope="col">{{__('common.Name')}}</th>
        <th scope="col">{{__('common.Code')}}</th>
        <th scope="col">{{__('common.Parent')}}</th>
        <th scope="col">{{__('common.Description')}}</th>
        <th scope="col">{{__('common.Status')}}</th>
        <th scope="col">{{__('common.Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $key=>$category_value)
        <tr>

            <th>{{ $key+1 }}</a></th>
            <td>@if ($category_value->level > 0)
                        @for ($i = 1; $i < $category_value->level; $i++)
                            -
                        @endfor
                        ->
                        @endif
                        {{ $category_value->name }}</td>

            <td>{{ $category_value->code }}</td>
            <td>{{ @$category_value->parentCat->name ?? 'N/A' }} </td>
            <td>{{ $category_value->description }}</td>
            <td>
                @if($category_value->status == 1)
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
                        @if(permissionCheck('category.edit'))
                            <a href="#" data-toggle="modal" data-target="#Item_Edit"
                               class="dropdown-item edit_category"
                               data-value="{{$category_value->id}}" type="button">{{__('common.Edit')}}</a>
                        @endif

                        @if(permissionCheck('category.destroy') && $category_value->products->count() == 0)

                                <a onclick="confirm_modal('{{route('category.delete',$category_value->id)}}');" class="dropdown-item ">{{__('common.Delete')}}</a>

                        @endif
                    </div>
                </div>
                <!-- shortby  -->
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
