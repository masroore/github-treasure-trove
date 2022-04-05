@if(permissionCheck('report'))
    @php

        $report = false;

        if(request()->is('report/*'))
        {
            $report = true;
        }

    @endphp

    <li class="{{ $report ?'mm-active' : '' }} report">
        <a href="javascript:void (0);" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="fas fa-bezier-curve"></span>
            </div>
            <div class="nav_title">
                <span>{{__('report.Reports')}}</span>
            </div>
        </a>
        <ul>
            <li class="#">
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="nav_title">
                        <span>{{ __('sale.Sale') }}</span>
                    </div>
                </a>
                <ul class="{{request()->is('report/sales-report') || request()->is('report/sales-report/*') ? 'mm-collapse mm-show' : ''}}">
                    @if(permissionCheck('sales_report.index'))
                        <li>
                            <a href="{{route('sales_report.index')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Sale Reports')}}</a>
                        </li>
                    @endif
                    @if(permissionCheck('product_sales_report.index'))
                        <li>
                            <a href="{{route('product_sales_report.index')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Product Wise Sale')}}</a>
                        </li>
                    @endif
                    @if(permissionCheck('sales_return_report.index'))
                        <li>
                            <a href="{{route('sales_return_report.index')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Sales Return')}}</a>
                        </li>
                    @endif
                    
                </ul>
            </li>
            <li class="#">
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="nav_title">
                        <span>{{ __('purchase.Purchase') }}</span>
                    </div>
                </a>
                <ul class="{{request()->is('report/purchase-report') || request()->is('report/purchase-report/*') ? 'mm-collapse mm-show' : ''}}">
                    @if(permissionCheck('purchase_report.index'))
                        <li>
                            <a href="{{route('purchase_report.index')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Purchase Reports')}}</a>
                        </li>
                    @endif
                    @if(permissionCheck('product_purchase_report.index'))
                        <li>
                            <a href="{{route('product_purchase_report.index')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Product wise Purchase')}}</a>
                        </li>
                    @endif
                    @if(permissionCheck('sale.history'))
                        <li>
                            <a href="{{route('purchase.history')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Purchase History')}}</a>
                        </li>
                    @endif
                </ul>
            </li>
            
            <li class="#">
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="nav_title">
                        <span>{{ __('common.Customer') }}</span>
                    </div>
                </a>
                <ul class="{{request()->is('report/customer-report') || request()->is('report/customer-report/*') ? 'mm-collapse mm-show' : ''}}">
                    @if(permissionCheck('customer_report.index'))
                        <li>
                            <a href="{{route('customer_report.index')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Customer Reports')}}</a>
                        </li>
                    @endif
                    @if(permissionCheck('customer.bill'))
                        <li>
                            <a href="{{route('customer.bill')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Customer Bill')}}</a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="#">
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="nav_title">
                        <span>{{ __('common.Supplier') }}</span>
                    </div>
                </a>
                <ul class="{{request()->is('report/supplier-report') || request()->is('report/supplier-report/*') ? 'mm-collapse mm-show' : ''}}">
                    @if(permissionCheck('supplier_report.index'))
                        <li>
                            <a href="{{route('supplier_report.index')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Supplier Reports')}}</a>
                        </li>
                    @endif
                    @if(permissionCheck('supplier.bill'))
                        <li>
                            <a href="{{route('supplier.bill')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Supplier Bill')}}</a>
                        </li>
                    @endif
                </ul>
            </li>
            
            
            <li class="#">
                <a href="javascript:;" class="has-arrow" aria-expanded="false">
                    <div class="nav_title">
                        <span>{{ __('report.Serial No Report') }}</span>
                    </div>
                </a>
                <ul class="{{request()->is('report/serial-no-index') || request()->is('report/serial-no-index/*') ? 'mm-collapse mm-show' : ''}}">
                    @if (permissionCheck('serial._product_report.index'))
                        <li>
                            <a href="{{route('serial._product_report.index')}}"
                               class="{{ $report ?'active' : '' }}"> {{__('report.Product Serial Report')}}</a>
                        </li>
                    @endif
                </ul>
            </li>
        </ul>
    </li>

@endif
