<tr>
    <th scope="col">
        <label class="primary_checkbox d-flex">
            <input name="sms1" type="checkbox">
            <span class="checkmark"></span>
        </label>
    </th>
    <td>{{ account_type($child_account->type) }}</td>
    <th>{{ $child_account->code }}</th>
    <td>
        @for ($i = 1; $i < $child_account->level; $i++)
            <strong>-</strong>
        @endfor
        <strong>-></strong> {{ $child_account->name }}</td>
        <td>{{ $child_account->is_group == 1 ? 'Yes' : 'No' }}</td>
        <td>{{ single_price($child_account->BalanceAmount) }}</td>
    <td class="pending">
        @if($child_account->status == 1)
            <span class="success">{{ __('common.Active') }}</span>
        @else
            <span class="pending">{{ __('common.DeActive') }}</span>
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
                 @if ($charAccount->id > "22")
                     <a href="#" data-toggle="modal" data-target="#ChartAccount_Edit" class="dropdown-item edit_chart_account" data-value="{{$child_account->id}}" type="button">{{ __('common.Edit') }}</a>
                     <a href="#" data-value="{{$child_account->id}}" class="delete_ChartAccount">
                         <button class="dropdown-item" type="button">{{__('common.Delete')}}</button>
                     </a>
                 @else
                     <span class="success dropdown-item">{{__('common.Not Editable')}}</span>
                 @endif

            </div>
        </div>
        <!-- shortby  -->
    </td>
</tr>
@if ($child_account->categories)
    @foreach ($child_account->categories as $child_account)
        @include('account::chart_accounts.page_component.child_account_list', ['child_account' => $child_account])
    @endforeach
@endif
