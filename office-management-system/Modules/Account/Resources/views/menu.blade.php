@if(permissionCheck('accounts'))
   @php

        $account = false;
        $transfer = false;

        if(request()->is('account/*'))
        {
            $account = true;
        }
        if(request()->is('transfer/*'))
        {
            $transfer = true;
        }

    @endphp

<li class="{{ $account ?'mm-active' : '' }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fa fa-bar-chart"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('account.Accounts') }}</span>
        </div>
    </a>
    <ul>
        @if (permissionCheck('expenses.create'))
        <li>
            <a href="{{ route('expenses.create') }}">{{ __('inventory.Add Expense') }}</a>
        </li>
        @endif
        @if (permissionCheck('expenses.index'))
            <li>
                <a href="{{ route('expenses.index') }}">{{ __('inventory.Expense Lists') }}</a>
            </li>
        @endif

        @if (permissionCheck('income.create'))
        <li>
            <a href="{{ route('income.create') }}">{{ __('inventory.Add Income') }}</a>
        </li>
        @endif
        @if (permissionCheck('income.index'))
            <li>
                <a href="{{ route('income.index') }}">{{ __('inventory.Income Lists') }}</a>
            </li>
        @endif

        @if(permissionCheck('bank_accounts.index'))
        <li>
            <a href="{{ route('bank_accounts.index') }}">{{ __('account.Bank Accounts') }}</a>
        </li>
        @endif
      
        @if(permissionCheck('openning_balance.create'))
        <li>
            <a href="{{ route('openning_balance.create') }}">{{ __('account.Opening Balance') }}</a>
        </li>
         @endif
        @if(permissionCheck('char_accounts.index'))
        <li>
            <a href="{{ route('char_accounts.index') }}">{{ __('account.Chart Of Accounts') }}</a>
        </li>
         @endif

        <li class="#">
            <a href="javascript:;" class="has-arrow" aria-expanded="false">
                <div class="nav_title">
                    <span>{{ __('account.Report') }}</span>
                </div>
            </a>
            <ul class="{{request()->is('report/sales-report') || request()->is('report/sales-report/*') ? 'mm-collapse mm-show' : ''}}">



                @if(permissionCheck('transaction.index'))
                <li>
                    <a href="{{ route('transaction.index') }}">{{ __('account.Transactions') }}</a>
                </li>
                 @endif

                 @if(permissionCheck('statement.index'))
                <li>
                    <a href="{{ route('statement.index') }}">{{ __('account.Statement') }}</a>
                </li>
                 @endif

                 @if (permissionCheck('profit.index'))
                    <li>
                        <a href="{{ route('profit.index') }}">{{ __('report.Profit & Loss') }}</a>
                    </li>
                @endif

                @if (permissionCheck('account.balance.index'))
                    <li>
                        <a href="{{ route('account.balance.index') }}">{{ __('account.Account Balance') }}</a>
                    </li>
                @endif

                @if (permissionCheck('income_by_customer'))
                    <li>
                        <a href="{{ route('income_by_customer') }}">{{ __('account.Income By Customer') }}</a>
                    </li>
                @endif


                @if (permissionCheck('expense_by_supplier'))
                    <li>
                        <a href="{{ route('expense_by_supplier') }}">{{ __('account.Expense By Supplier') }}</a>
                    </li>
                @endif

                @if (permissionCheck('sale_tax'))
                    <li>
                        <a href="{{ route('sale_tax') }}">{{ __('account.Sales Tax') }}</a>
                    </li>
                @endif




            </ul>
        </li>

    </ul>
</li>
<li class="{{ $transfer ?'mm-active' : '' }}">
    <a href="javascript:;" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fa fa-bar-chart"></span>
        </div>
        <div class="nav_title">
            <span>{{ __('account.Transfer') }}</span>
        </div>
    </a>
    <ul>
        <li>
            <a href="{{ route('transfer_showroom.create') }}">{{ __('account.Make A Transfer') }}</a>
        </li>
        <li>
            <a href="{{ route('transfer_showroom.index') }}">{{ __('account.Transfered Lists') }}</a>
        </li>
    </ul>
</li>
@endif
