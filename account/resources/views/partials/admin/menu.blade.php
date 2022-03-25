@php
    $logo=asset(Storage::url('uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
    $company_small_logo=Utility::getValByName('company_small_logo');
@endphp

<div class="sidenav custom-sidenav" id="sidenav-main">
    <!-- Sidenav header -->
    <div class="sidenav-header d-flex align-items-center">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}" class="navbar-brand-img"/>
        </a>
        <div class="ml-auto">
            <div class="sidenav-toggler sidenav-toggler-dark d-md-none" data-action="sidenav-unpin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="scrollbar-inner">
        <div class="div-mega">
            <h3>Financial</h3>
            <ul class="navbar-nav navbar-nav-docs">
                <li class="nav-item">
                    @if(\Auth::guard('customer')->check())
                        <a href="{{route('customer.dashboard')}}" class="nav-link {{ (Request::route()->getName() == 'customer.dashboard') ? ' active' : '' }}">
                            <i class="fas fa-fire"></i>{{__('Dashboard')}}
                        </a>
                    @elseif(\Auth::guard('vender')->check())
                        <a href="{{route('vender.dashboard')}}" class="nav-link {{ (Request::route()->getName() == 'vender.dashboard') ? ' active' : '' }}">
                            <i class="fas fa-fire"></i>{{__('Dashboard')}}
                        </a>
                    @else
                        <a href="{{route('dashboard')}}" class="nav-link {{ (Request::route()->getName() == 'dashboard') ? ' active' : '' }}">
                            <i class="fas fa-fire"></i>{{__('Dashboard')}}
                        </a>
                    @endif
                </li>
                
                @if( Gate::check('manage chart of account'))
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::segment(1) == 'chart-of-account' || Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance')?' active':'collapsed'}}" href="#navbar-double-entry" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'bill' )?'true':'false'}}" aria-controls="navbar-double-entry">
                            <i class="fas fa-balance-scale"></i>Master Records ({{ __('Chart of Accounts') }})
                            <i class="fas fa-sort-up"></i>
                        </a>
                        <div class="collapse {{ (Request::segment(1) == 'chart-of-account' || Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance')?'show':''}}" id="navbar-double-entry">
                            <ul class="nav flex-column submenu-ul">
                                @can('manage chart of account')
                                    <li class="nav-item {{ (Request::route()->getName() == 'chart-of-account.index') ? ' active' : '' }}">
                                        <a href="{{ route('chart-of-account.index') }}" class="nav-link">{{ __('Chart of Accounts') }}</a>
                                    </li>
                                @endcan
                                    <!-- <li class="nav-item"><a href="#" class="nav-link">Account Creation</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Account Edit</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Account Delete</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Account Active/Inactive</a></li> -->
                            </ul>
                        </div>
                    </li>
                @endif
                    <li class="nav-item">
                        <a class="nav-link {{ ( Request::segment(1) == 'journal-entry')?' active':'collapsed'}}" href="#navbar-general-ledger" data-toggle="collapse" role="button" aria-expanded="{{ ( Request::segment(2) == 'journal-entry')?'true':'false'}}" aria-controls="navbar-general-ledger">
                            <i class="fas fa-balance-scale"></i>General Ledger
                            <i class="fas fa-sort-up"></i>
                        </a>
                        <div class="collapse {{ (Request::segment(1) == 'journal-entry')?'show':''}}" id="navbar-general-ledger">
                            <ul class="nav flex-column submenu-ul">
                                @if( Gate::check('manage journal entry') )
                                    <!-- <li class="nav-item {{ (Request::route()->getName() == 'document-entry.index') ? ' active' : '' }}" ><a href="{{ route('document-entry.index') }}" class="nav-link">Document Entry</a></li> -->
                                   <!--  <li class="nav-item"><a href="#" class="nav-link">Document Display</a></li>
                                    <li class="nav-item"><a href="#" class="nav-link">Document Edit</a></li> -->
                                    @can('manage journal entry')
                                        <li class="nav-item {{ (Request::route()->getName() == 'journal-entry.index' || Request::route()->getName() == 'journal-entry.show') ? ' active' : '' }}">
                                            <a href="{{ route('journal-entry.index') }}" class="nav-link">{{ __('Journal Account') }}</a>
                                        </li>
                                    @endcan
                                @endif    
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-general-receivables" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-general-receivables">
                            <i class="fas fa-money-bill-alt"></i>Receivables
                            <i class="fas fa-sort-up"></i>
                        </a>
                         <div class="collapse" id="navbar-general-receivables">
                            <ul class="nav flex-column submenu-ul">
                                 @if( Gate::check('manage invoice') ||  Gate::check('manage revenue') ||  Gate::check('manage credit note'))
                                    <li class="nav-item">
                                        <a class="nav-link {{ (Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note')?' active':'collapsed'}}" href="#navbar-income" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note')?'true':'false'}}" aria-controls="navbar-income">
                                            Master Records(Customer Accounts)
                                            <!--{{__('Income')}}-->
                                        </a>
                                        <div class="collapse {{ (Request::segment(1) == 'invoice' || Request::segment(1) == 'revenue' || Request::segment(1) == 'credit-note')?'show':''}}" id="navbar-income">
                                            <ul class="nav flex-column submenu-ul">
                                                @if(Gate::check('manage customer'))
                                                    <li class="nav-item">
                                                        <a href="{{ route('customer.index') }}" class="nav-link {{ (Request::segment(1) == 'customer')?'active':''}}">
                                                            <!--<i class="fas fa-user-ninja"></i>-->
                                                            {{__('Customer')}}
                                                        </a>
                                                    </li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Customer Creation</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Customer Edit</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Customer Delete</a></li>
                                                @endif
                                                @can('manage invoice')
                                                    <li class="nav-item {{ (Request::route()->getName() == 'invoice.index' || Request::route()->getName() == 'invoice.create' || Request::route()->getName() == 'invoice.edit' || Request::route()->getName() == 'invoice.show') ? ' active' : '' }}">
                                                        <a href="{{ route('invoice.index') }}" class="nav-link">Document entry
                                                            <!--{{ __('Invoice') }}-->
                                                            </a>
                                                    </li>
                                                    <li class="nav-item {{ (Request::route()->getName() == 'invoice.show') ? ' active' : '' }}">
                                                        <a href="{{ route('invoice.index') }}" class="nav-link">Document Display
                                                            <!--{{ __('Invoice') }}-->
                                                            </a>
                                                    </li>
                                                    <li class="nav-item {{ (Request::route()->getName() == 'invoice.edit') ? ' active' : '' }}">
                                                        <a href="{{ route('invoice.index') }}" class="nav-link">Document Edit
                                                            <!--{{ __('Invoice') }}-->
                                                            </a>
                                                    </li>
                                                @endcan
                                                @can('manage revenue')
                                                    <li class="nav-item {{ (Request::route()->getName() == 'revenue.index' || Request::route()->getName() == 'revenue.create' || Request::route()->getName() == 'revenue.edit') ? ' active' : '' }}">
                                                        <a href="{{route('revenue.index')}}" class="nav-link">{{ __('Revenue') }}</a>
                                                    </li>
                                                @endcan
                                                @can('manage credit note')
                                                    <li class="nav-item {{ (Request::route()->getName() == 'credit.note' ) ? ' active' : '' }}">
                                                        <a href="{{route('credit.note')}}" class="nav-link">{{ __('Credit Note') }}</a>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="#navbar-general-reporting-receivables" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-general-reporting-receivables">
                                        <!--<i class="fas fa-balance-scale"></i>-->
                                        Reporting
                                        <!--<i class="fas fa-sort-up"></i>-->
                                    </a>
                                    <div class="collapse" id="navbar-general-reporting-receivables">
                                        <ul class="nav flex-column submenu-ul">
                                                <li class="nav-item"><a href="#" class="nav-link">Account Balances</a></li>
                                                <li class="nav-item"><a href="#" class="nav-link">Individual Customer Account</a></li>
                                                <li class="nav-item"><a href="#" class="nav-link">Age Analysis</a></li>
                                                <!--<li class="nav-item"><a href="#" class="nav-link">WHT Reports</a></li>-->
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>    
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-general-payables" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-general-payables">
                            <i class="fas fa-balance-scale"></i>Payables
                            <i class="fas fa-sort-up"></i>
                        </a>
                        <div class="collapse" id="navbar-general-payables">
                            <ul class="nav flex-column submenu-ul">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-general-vendor" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-general-vendor">
                                            Master Records(Vendor Accounts)
                                        </a>
                                        <div class="collapse" id="navbar-general-vendor">
                                            <ul class="nav flex-column submenu-ul">
                                                    <!--<li class="nav-item"><a href="#" class="nav-link">Vendor</a></li>-->
                                                    @if(Gate::check('manage vender'))
                                                        <li class="nav-item">
                                                            <a href="{{ route('vender.index') }}" class="nav-link {{ (Request::segment(1) == 'vender')?'active':''}}">
                                                                <!--<i class="fas fa-sticky-note"></i>-->
                                                                {{__('Vendor')}}
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li class="nav-item"><a href="#" class="nav-link">Vendor Creation</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Vendor Edit</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Vendor Delete</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Document Entry</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Document Display</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Document Edit</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#navbar-general-reporting" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-general-reporting">
                                            Reporting
                                        </a>
                                        <div class="collapse" id="navbar-general-reporting">
                                            <ul class="nav flex-column submenu-ul">
                                                    <li class="nav-item"><a href="#" class="nav-link">Account Balances</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Individual Customer Account</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">Age Analysis</a></li>
                                                    <li class="nav-item"><a href="#" class="nav-link">WHT Reports</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    
                            </ul>
                        </div>
                    </li>
                 
                @if( Gate::check('manage bank account') ||  Gate::check('manage transfer'))
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::segment(1) == 'bank-account' || Request::segment(1) == 'transfer')?' active':'collapsed'}}" href="#navbar-banking" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'bank-account' || Request::segment(1) == 'transfer')?'true':'false'}}" aria-controls="navbar-banking">
                            <i class="fas fa-university"></i>{{__('Banking')}}
                            <i class="fas fa-sort-up"></i>
                        </a>
                        <div class="collapse {{ (Request::segment(1) == 'bank-account' || Request::segment(1) == 'transfer')?'show':''}}" id="navbar-banking">
                            <ul class="nav flex-column submenu-ul">
                                @can('manage bank account')
                                    <li class="nav-item {{ (Request::route()->getName() == 'bank-account.index' || Request::route()->getName() == 'bank-account.create' || Request::route()->getName() == 'bank-account.edit') ? ' active' : '' }}">
                                        <a href="{{ route('bank-account.index') }}" class="nav-link">{{ __('Account') }}</a>
                                    </li>
                                @endcan
                                @can('manage transfer')
                                    <li class="nav-item {{ (Request::route()->getName() == 'transfer.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transfer.edit') ? ' active' : '' }}">
                                        <a href="{{route('transfer.index')}}" class="nav-link">{{ __('Transfer') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endif
                  @if(Gate::check('manage assets'))
                    <li class="nav-item">
                        <a href="{{ route('account-assets.index') }}" class="nav-link {{ (Request::segment(1) == 'account-assets')?'active':''}}">
                            <i class="fas fa-calculator"></i>{{__('Assets')}} Accounting
                        </a>
                    </li>
                @endif
                @if( Gate::check('balance sheet report') ||  Gate::check('ledger report') ||  Gate::check('trial balance report'))
                    <li class="nav-item">
                        <a class="nav-link {{ ( Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance')?' active':'collapsed'}}" href="#navbar-double-entrys" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'bill' )?'true':'false'}}" aria-controls="navbar-double-entrys">
                            <i class="fas fa-balance-scale"></i>
                            Reporting
                            <!--{{__('Double Entry')}}-->
                            <i class="fas fa-sort-up"></i>
                        </a>
                        <div class="collapse {{ ( Request::segment(2) == 'ledger' ||  Request::segment(2) == 'balance-sheet' ||  Request::segment(2) == 'trial-balance')?'show':''}}" id="navbar-double-entrys">
                            <ul class="nav flex-column submenu-ul">
                                @can('ledger report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.ledger' ) ? ' active' : '' }}">
                                        <a href="{{route('report.ledger')}}" class="nav-link">{{ __('Ledger Summary') }}</a>
                                    </li>
                                @endcan
                                <li class="nav-item"><a href="#" class="nav-link">Account Balances</a></li>
                                 @can('trial balance report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'trial.balance' ) ? ' active' : '' }}">
                                        <a href="{{route('trial.balance')}}" class="nav-link">{{ __('Trial Balance') }}</a>
                                    </li>
                                @endcan
                                @can('balance sheet report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.balance.sheet' ) ? ' active' : '' }}">
                                        <a href="{{route('report.balance.sheet')}}" class="nav-link">{{ __('Balance Sheet') }}</a>
                                    </li>
                                @endcan
                                @can('manage transaction')
                                    <li class="nav-item {{ (Request::route()->getName() == 'transaction.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transaction.edit') ? ' active' : '' }}">
                                        <a href="{{ route('transaction.index') }}" class="nav-link">{{ __('Transaction') }}</a>
                                    </li>
                                @endcan
                                @can('statement report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.account.statement') ? ' active' : '' }}">
                                        <a href="{{route('report.account.statement')}}" class="nav-link">{{ __('Account Statement') }}</a>
                                    </li>
                                @endcan
                                @can('income report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.income.summary' ) ? ' active' : '' }}">
                                        <a href="{{route('report.income.summary')}}" class="nav-link">{{ __('Income Summary') }}</a>
                                    </li>
                                @endcan
                                @can('expense report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.expense.summary' ) ? ' active' : '' }}">
                                        <a href="{{route('report.expense.summary')}}" class="nav-link">{{ __('Expense Summary') }}</a>
                                    </li>
                                @endcan
                                @can('income vs expense report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.income.vs.expense.summary' ) ? ' active' : '' }}">
                                        <a href="{{route('report.income.vs.expense.summary')}}" class="nav-link">{{ __('Income VS Expense') }}</a>
                                    </li>
                                @endcan
                                @can('tax report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.tax.summary' ) ? ' active' : '' }}">
                                        <a href="{{route('report.tax.summary')}}" class="nav-link">{{ __('Tax Summary') }}</a>
                                    </li>
                                @endcan
                                @can('loss & profit report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.profit.loss.summary' ) ? ' active' : '' }}">
                                        <a href="{{route('report.profit.loss.summary')}}" class="nav-link">{{ __('Profit & Loss') }}</a>
                                    </li>
                                @endcan
                                @can('invoice report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.invoice.summary' ) ? ' active' : '' }}">
                                        <a href="{{route('report.invoice.summary')}}" class="nav-link">{{ __('Invoice Summary') }}</a>
                                    </li>
                                @endcan
                                @can('bill report')
                                    <li class="nav-item {{ (Request::route()->getName() == 'report.bill.summary' ) ? ' active' : '' }}">
                                        <a href="{{route('report.bill.summary')}}" class="nav-link">{{ __('Bill Summary') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endif
                 <li class="nav-item">
                        <a class="nav-link" href="#navbar-general-panel" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-general-panel">
                            <i class="fas fa-balance-scale"></i>Control Panel
                            <i class="fas fa-sort-up"></i>
                        </a>
                        <div class="collapse" id="navbar-general-panel">
                            <ul class="nav flex-column submenu-ul">
                                    @can('manage customer proposal')
                    <li class="nav-item">
                        <a href="{{route('customer.proposal')}}" class="nav-link {{ (Request::route()->getName() == 'customer.proposal' || Request::route()->getName() == 'customer.proposal.show') ? ' active' : '' }}">
                            <i class="fas fa-file"></i>{{__('Proposal')}}
                        </a>
                    </li>
                @endcan
                @can('manage customer invoice')
                    <li class="nav-item">
                        <a href="{{route('customer.invoice')}}" class="nav-link {{ (Request::route()->getName() == 'customer.invoice' || Request::route()->getName() == 'customer.invoice.show') ? ' active' : '' }} ">
                            <i class="fas fa-file"></i>{{__('Invoice')}}
                        </a>
                    </li>
                @endcan
                @can('manage customer payment')
                    <li class="nav-item">
                        <a href="{{route('customer.payment')}}" class="nav-link {{ (Request::route()->getName() == 'customer.payment') ? ' active' : '' }} ">
                            <i class="fas fa-money-bill-alt"></i>{{__('Payment')}}
                        </a>
                    </li>
                @endcan
                @can('manage customer transaction')
                    <li class="nav-item">
                        <a href="{{route('customer.transaction')}}" class="nav-link {{ (Request::route()->getName() == 'customer.transaction') ? ' active' : '' }}">
                            <i class="fas fa-history"></i>{{__('Transaction')}}
                        </a>
                    </li>
                @endcan
                @can('manage vender bill')
                    <li class="nav-item">
                        <a href="{{route('vender.bill')}}" class="nav-link {{ (Request::route()->getName() == 'vender.bill' || Request::route()->getName() == 'vender.bill.show') ? ' active' : '' }} ">
                            <i class="fas fa-file"></i>{{__('Bill')}}
                        </a>
                    </li>
                @endcan
                @can('manage vender payment')
                    <li class="nav-item">
                        <a href="{{route('vender.payment')}}" class="nav-link {{ (Request::route()->getName() == 'vender.payment') ? ' active' : '' }} ">
                            <i class="fas fa-money-bill-alt"></i>{{__('Payment')}}
                        </a>
                    </li>
                @endcan
                @can('manage vender transaction')
                    <li class="nav-item">
                        <a href="{{route('vender.transaction')}}" class="nav-link {{ (Request::route()->getName() == 'vender.transaction') ? ' active' : '' }}">
                            <i class="fas fa-history"></i>{{__('Transaction')}}
                        </a>
                    </li>
                @endcan
                @if(\Auth::user()->type=='super admin')
                    @can('manage user')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ (Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit') ? ' active' : '' }}">
                                <i class="fas fa-columns"></i>{{__('User') }}
                            </a>
                        </li>
                    @endcan
                @else
                    @if( Gate::check('manage user') || Gate::check('manage role'))
                        <li class="nav-item">
                            <a class="nav-link {{ (Request::segment(1) == 'users' || Request::segment(1) == 'roles' || Request::segment(1) == 'permissions' )?' active':'collapsed'}}" href="#navbar-staff" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'users' || Request::segment(1) == 'roles' || Request::segment(1) == 'permissions' )?'true':'false'}}" aria-controls="navbar-staff">
                                <i class="fas fa-users"></i>{{__('Staff')}}
                                <i class="fas fa-sort-up"></i>
                            </a>
                            <div class="collapse {{ (Request::segment(1) == 'users' || Request::segment(1) == 'roles' || Request::segment(1) == 'permissions')?'show':''}}" id="navbar-staff">
                                <ul class="nav flex-column submenu-ul">
                                    @can('manage user')
                                        <li class="nav-item {{ (Request::route()->getName() == 'users.index' || Request::route()->getName() == 'users.create' || Request::route()->getName() == 'users.edit') ? ' active' : '' }}">
                                            <a href="{{ route('users.index') }}" class="nav-link">{{ __('User') }}</a>
                                        </li>
                                    @endcan
                                    @can('manage role')
                                        <li class="nav-item {{ (Request::route()->getName() == 'roles.index' || Request::route()->getName() == 'roles.create' || Request::route()->getName() == 'roles.edit') ? ' active' : '' }}">
                                            <a href="{{route('roles.index')}}" class="nav-link">{{ __('Role') }}</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endif
                @endif
                @if(Gate::check('manage product & service'))
                    <li class="nav-item">
                        <a href="{{ route('productservice.index') }}" class="nav-link {{ (Request::segment(1) == 'productservice')?'active':''}}">
                            <i class="fas fa-shopping-cart"></i>{{__('Product & Service')}}
                        </a>
                    </li>
                @endif
                
                
                @if(Gate::check('manage proposal'))
                    <li class="nav-item">
                        <a href="{{ route('proposal.index') }}" class="nav-link {{ (Request::segment(1) == 'proposal')?'active':''}}">
                            <i class="fas fa-receipt"></i>{{__('Proposal')}}
                        </a>
                    </li>
                @endif
               

                @if( Gate::check('manage bill')  ||  Gate::check('manage payment') ||  Gate::check('manage debit note'))
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::segment(1) == 'bill' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note'  )?' active':'collapsed'}}" href="#navbar-expense" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'bill' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note'  )?'true':'false'}}" aria-controls="navbar-expense">
                            <i class="fas fa-money-bill-wave-alt"></i>{{__('Expense')}}
                            <i class="fas fa-sort-up"></i>
                        </a>
                        <div class="collapse {{ (Request::segment(1) == 'bill' || Request::segment(1) == 'payment' || Request::segment(1) == 'debit-note'  )?'show':''}}" id="navbar-expense">
                            <ul class="nav flex-column submenu-ul">
                                @can('manage bill')
                                    <li class="nav-item {{ (Request::route()->getName() == 'bill.index' || Request::route()->getName() == 'bill.create' || Request::route()->getName() == 'bill.edit' || Request::route()->getName() == 'bill.show') ? ' active' : '' }}">
                                        <a href="{{ route('bill.index') }}" class="nav-link">{{ __('Bill') }}</a>
                                    </li>
                                @endcan
                                @can('manage payment')
                                    <li class="nav-item {{ (Request::route()->getName() == 'payment.index' || Request::route()->getName() == 'payment.create' || Request::route()->getName() == 'payment.edit') ? ' active' : '' }}">
                                        <a href="{{route('payment.index')}}" class="nav-link">{{ __('Payment') }}</a>
                                    </li>
                                @endcan
                                @can('manage debit note')
                                    <li class="nav-item {{ (Request::route()->getName() == 'debit.note' ) ? ' active' : '' }}">
                                        <a href="{{route('debit.note')}}" class="nav-link">{{ __('Debit Note') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endif


                @if(Gate::check('manage goal'))
                    <li class="nav-item">
                        <a href="{{ route('goal.index') }}" class="nav-link {{ (Request::segment(1) == 'goal')?'active':''}}">
                            <i class="fas fa-bullseye"></i>{{__('Goal')}}
                        </a>
                    </li>
                @endif
               
                @if(Gate::check('manage plan'))
                    <li class="nav-item">
                        <a href="{{ route('plans.index') }}" class="nav-link {{ (Request::segment(1) == 'plans')?'active':''}}">
                            <i class="fas fa-trophy"></i>{{__('Plan')}}
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage coupon'))
                    <li class="nav-item">
                        <a href="{{ route('coupons.index') }}" class="nav-link {{ (Request::segment(1) == 'coupons')?'active':''}}">
                            <i class="fas fa-gift"></i>{{__('Coupon')}}
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage order'))
                    <li class="nav-item">
                        <a href="{{ route('order.index') }}" class="nav-link {{ (Request::segment(1) == 'orders')?'active':''}}">
                            <i class="fas fa-cart-plus"></i>{{__('Order')}}
                        </a>
                    </li>
                @endif

                @if( Gate::check('income report') || Gate::check('expense report') || Gate::check('income vs expense report') || Gate::check('tax report')  || Gate::check('loss & profit report') || Gate::check('invoice report') || Gate::check('bill report') || Gate::check('invoice report') ||  Gate::check('manage transaction') ||  Gate::check('statement report') )
                   <?php
                        
                    ?>
                    <!--<li class="nav-item">-->
                    <!--    <a class="nav-link {{ ((Request::segment(1) == 'report' || Request::segment(1) == 'transaction') &&  Request::segment(2) != 'ledger' &&  Request::segment(2) != 'balance-sheet' &&  Request::segment(2) != 'trial-balance')?' active':'collapsed'}}" href="#navbar-reports" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'report' || Request::segment(1) == 'transaction')?'true':'false'}}" aria-controls="navbar-reports">-->
                    <!--        <i class="fas fa-chart-area"></i>{{__('Report')}}-->
                    <!--        <i class="fas fa-sort-up"></i>-->
                    <!--    </a>-->
                    <!--    <div class="collapse {{ ((Request::segment(1) == 'report' || Request::segment(1) == 'transaction') &&  Request::segment(2) != 'ledger' &&  Request::segment(2) != 'balance-sheet' &&  Request::segment(2) != 'trial-balance')?'show':''}}" id="navbar-reports">-->
                    <!--        <ul class="nav flex-column submenu-ul">-->
                    <!--            @can('manage transaction')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'transaction.index' || Request::route()->getName() == 'transfer.create' || Request::route()->getName() == 'transaction.edit') ? ' active' : '' }}">-->
                    <!--                    <a href="{{ route('transaction.index') }}" class="nav-link">{{ __('Transaction') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->
                    <!--            @can('statement report')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'report.account.statement') ? ' active' : '' }}">-->
                    <!--                    <a href="{{route('report.account.statement')}}" class="nav-link">{{ __('Account Statement') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->
                    <!--            @can('income report')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'report.income.summary' ) ? ' active' : '' }}">-->
                    <!--                    <a href="{{route('report.income.summary')}}" class="nav-link">{{ __('Income Summary') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->
                    <!--            @can('expense report')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'report.expense.summary' ) ? ' active' : '' }}">-->
                    <!--                    <a href="{{route('report.expense.summary')}}" class="nav-link">{{ __('Expense Summary') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->
                    <!--            @can('income vs expense report')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'report.income.vs.expense.summary' ) ? ' active' : '' }}">-->
                    <!--                    <a href="{{route('report.income.vs.expense.summary')}}" class="nav-link">{{ __('Income VS Expense') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->
                    <!--            @can('tax report')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'report.tax.summary' ) ? ' active' : '' }}">-->
                    <!--                    <a href="{{route('report.tax.summary')}}" class="nav-link">{{ __('Tax Summary') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->
                    <!--            @can('loss & profit report')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'report.profit.loss.summary' ) ? ' active' : '' }}">-->
                    <!--                    <a href="{{route('report.profit.loss.summary')}}" class="nav-link">{{ __('Profit & Loss') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->
                    <!--            @can('invoice report')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'report.invoice.summary' ) ? ' active' : '' }}">-->
                    <!--                    <a href="{{route('report.invoice.summary')}}" class="nav-link">{{ __('Invoice Summary') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->
                    <!--            @can('bill report')-->
                    <!--                <li class="nav-item {{ (Request::route()->getName() == 'report.bill.summary' ) ? ' active' : '' }}">-->
                    <!--                    <a href="{{route('report.bill.summary')}}" class="nav-link">{{ __('Bill Summary') }}</a>-->
                    <!--                </li>-->
                    <!--            @endcan-->

                    <!--        </ul>-->
                    <!--    </div>-->
                    <!--</li>-->
                    <?php
                        
                    ?>
                @endif

                @if(Gate::check('manage constant tax') || Gate::check('manage constant category') ||Gate::check('manage constant unit') ||Gate::check('manage constant payment method') ||Gate::check('manage constant custom field') || Gate::check('manage constant chart of account'))
                    <li class="nav-item">
                        <a class="nav-link {{ (Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')?' active':'collapsed'}}" href="#navbar-constant" data-toggle="collapse" role="button" aria-expanded="{{ (Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) ==
                        'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')?'true':'false'}}" aria-controls="navbar-constant">
                            <i class="fas fa-cog"></i>{{__('Constant')}}
                            <i class="fas fa-sort-up"></i>
                        </a>
                        <div class="collapse {{ (Request::segment(1) == 'taxes' || Request::segment(1) == 'product-category' || Request::segment(1) == 'product-unit' || Request::segment(1) == 'payment-method' || Request::segment(1) == 'custom-field' || Request::segment(1) == 'chart-of-account-type')?'show':''}}" id="navbar-constant">
                            <ul class="nav flex-column submenu-ul">
                                @can('manage constant tax')
                                    <li class="nav-item {{ (Request::route()->getName() == 'taxes.index' ) ? ' active' : '' }}">
                                        <a href="{{ route('taxes.index') }}" class="nav-link">{{ __('Taxes') }}</a>
                                    </li>
                                @endcan
                                @can('manage constant category')
                                    <li class="nav-item {{ (Request::route()->getName() == 'product-category.index' ) ? 'active' : '' }}">
                                        <a href="{{route('product-category.index')}}" class="nav-link">{{ __('Category') }}</a>
                                    </li>
                                @endcan
                                @can('manage constant unit')
                                    <li class="nav-item {{ (Request::route()->getName() == 'product-unit.index' ) ? ' active' : '' }}">
                                        <a href="{{route('product-unit.index')}}" class="nav-link">{{ __('Unit') }}</a>
                                    </li>
                                @endcan
                                @can('manage constant custom field')
                                    <li class="nav-item {{ (Request::route()->getName() == 'custom-field.index' ) ? 'active' : '' }}">
                                        <a href="{{route('custom-field.index')}}" class="nav-link">{{ __('Custom Field') }}</a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endif
                @if(Auth::user()->type == 'super admin')
                    <li class="nav-item">
                        <a href="{{route('custom_landing_page.index')}}" class="nav-link">
                            <i class="fas fa-clipboard"></i>{{__('Landing page')}}
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage system settings'))
                    <li class="nav-item">
                        <a href="{{ route('systems.index') }}" class="nav-link {{ (Request::route()->getName() == 'systems.index') ? ' active' : '' }}">
                            <i class="fas fa-sliders-h"></i>{{__('System Setting')}}
                        </a>
                    </li>
                @endif
                @if(Gate::check('manage company settings'))
                    <li class="nav-item">
                        <a href="{{ route('company.setting') }}" class="nav-link {{ (Request::route()->getName() == 'systems.index') ? ' active' : '' }}">
                            <i class="fas fa-sliders-h"></i>{{__('Company Setting')}}
                        </a>
                    </li>
                @endif
                            </ul>
                        </div>
                </li>
                
                
            </ul>
        </div>
    </div>
</div>
