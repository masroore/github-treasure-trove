<table class="table Crm_table_active3">
    <thead>
    <tr>
        <th scope="col">{{ __('common.ID') }}</th>
        <th scope="col">{{__('common.Name')}}</th>
        <th scope="col">{{__('common.Bank Branch Name')}}</th>
        <th scope="col">{{__('common.Account Name')}}</th>
        <th scope="col">{{__('common.Bank Account Number')}}</th>
        <th scope="col">{{__('account.Balance')}}</th>
        <th scope="col">{{__('common.Status')}}</th>
        <th scope="col">{{__('common.Action')}}</th>
    </tr>
    </thead>
    <tbody>

        @foreach ($bank_accounts as $key=> $bank_account)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $bank_account->bank_name }}</td>
                <td>{{ $bank_account->branch_name }}</td>
                <td>{{ $bank_account->account_name }}</td>
                <td>{{ $bank_account->account_no }}</td>
                <td>{{ single_price($bank_account->BalanceAmount) }}</td>
                <td>
                   
                    @if($bank_account->chartAccount->status == 1)
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
                            {{ __('common.Select') }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"
                            aria-labelledby="dropdownMenu2">
                            <a href="{{ route('bank.account.history', $bank_account->id) }}" class="dropdown-item">{{__('account.Account History')}}</a>
                            <a href="#" data-toggle="modal" data-target="#ChartAccount_Edit" class="dropdown-item edit_chart_account" data-value="{{$bank_account}}" type="button">{{trans('common.Edit')}}</a>
                                <a href="javascript:void(0)" data-value="{{$bank_account->id}}" class="delete_ChartAccount">
                                    <button class="dropdown-item" type="button">{{__('common.Delete')}}</button>
                                </a>
                        </div>
                    </div>
                    <!-- shortby  -->
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
