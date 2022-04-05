@foreach ($ChartOfAccountList as $charAccount)
    <tr>

        <td>{{ account_type($charAccount->type) }}</td>
        <th>{{ $charAccount->code }}</th>
        <td><strong>-></strong> {{ $charAccount->name }}</td>
        <td>{{ $charAccount->is_group  == 1 ? 'Yes' : 'No' }}</td>
        <th>{{ single_price($charAccount->BalanceAmount) }}</th>
        <td class="pending">
            @if($charAccount->status == 1)
                <span class="badge_1">{{__('common.Active')}}</span>
            @else
                <span class="badge_2">{{__('common.DeActive')}}</span>
            @endif
        </td>
        <td>
            <!-- shortby  -->
            <div class="dropdown CRM_dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenu2" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                    {{ __('common.Select') }}
                </button>
                <div class="dropdown-menu dropdown-menu-right"
                    aria-labelledby="dropdownMenu2">
                    @if ($charAccount->id > "33")
                        <a href="#" data-toggle="modal" data-target="#ChartAccount_Edit" class="dropdown-item edit_chart_account" data-value="{{$charAccount->id}}" type="button">Edit</a>
                        <a href="#" data-value="{{$charAccount->id}}" class="delete_ChartAccount">
                            <button class="dropdown-item" type="button">{{__('common.Delete')}}</button>
                        </a>
                        <a onclick="confirm_modal('{{route('char_accounts.destroy',$charAccount->id)}}');" class="dropdown-item ">{{__('common.Delete')}}</a>
                    @else
                        <a href="#" data-toggle="modal" data-target="#RenameAccount" class="dropdown-item rename_account" onclick="get_data_modal({{$charAccount}})" type="button">Edit</a>

                    @endif
                </div>
            </div>
            <!-- shortby  -->
        </td>
    </tr>

    @foreach ($charAccount->childrenCategories as $child_account)
        @include('account::chart_accounts.page_component.child_account_list', ['child_account' => $child_account])
    @endforeach
@endforeach
