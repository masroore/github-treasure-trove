@if(permissionCheck('purchase'))


    @php

        $purchase = false;

        if(request()->is('purchase/*') && !request()->is('purchase/purchase/receive-list/*') )
        {
            $purchase = true;
        }

    @endphp


    <li class="{{ $purchase ?'mm-active' : '' }}">
        <a href="javascript:void (0);" class="has-arrow" aria-expanded="false">
            <div class="nav_icon_small">
                <span class="fas fa-store-alt"></span>
            </div>
            <div class="nav_title">
                <span>{{__('purchase.Purchase')}}</span>
            </div>
        </a>
        <ul>

            @if(permissionCheck('purchase_order.index'))
                <li>
                    <a href="{{route('purchase_order.index')}}"
                       class="{{request()->is('purchase/purchase_order') || request()->is('purchase/purchase_order/*') ? 'active' : ''}}"> {{__('purchase.Purchase Order')}}</a>
                </li>
            @endif
            @if(permissionCheck('purchase.suggest'))
                <li>
                    <a href="{{route('purchase.suggest')}}"
                       class="{{request()->is('purchase/suggested-list') ? 'active' : ''}}"> {{__('purchase.Stock Alert List')}}</a>
                </li>
            @endif
            @if(permissionCheck('purchase.return.index'))
                <li>
                    <a href="{{route('purchase.return.index')}}"
                       class="{{request()->is('purchase/purchase-return-list') ? 'active' : ''}}"> {{__('purchase.Purchase Return List')}}</a>
                </li>
            @endif
            @if(permissionCheck('purchase.return.index'))
                <li>
                    <a href="{{route('cnf.index')}}"
                       class="{{request()->is('cnf') ? 'active' : ''}}"> {{__('purchase.CNF')}}</a>
                </li>
            @endif

        </ul>
    </li>
@endif
