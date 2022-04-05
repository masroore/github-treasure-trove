        @if(permissionCheck('inventory'))
           @php
                $inventory = false;

                if((request()->is('inventory/*') && !request()->is('inventory/showroom') && !request()->is('inventory/warehouse') && !request()->is('inventory/showroom/*')) || request()->is('purchase/purchase/receive-list/*'))
                {
                    $inventory = true;
                }

            @endphp

        <li class="{{ $inventory ?'mm-active' : '' }} report">
            <a href="javascript:;" class="has-arrow" aria-expanded="false">
                <div class="nav_icon_small">
                    <span class="fa fa-university"></span>
                </div>
                <div class="nav_title">
                    <span>{{ __('inventory.Inventory') }}</span>
                </div>
            </a>
            <ul>
                @if (permissionCheck('add_opening_stock_create'))
                    <li>
                        <a href="{{route('add_opening_stock_create')}}" class="{{request()->is('inventory/product/add-opening-stock') ? 'active' : ''}}"> {{__('common.Add Opening Stock')}}</a>
                    </li>
                @endif
                @if (permissionCheck('purchase_order.recieve.index'))
                    <li>
                        <a href="{{route('purchase_order.recieve.index')}}" class="{{request()->is('inventory/purchase-order-recieve') || request()->is('purchase/purchase/receive-list/*') ? 'active' : ''}}"> {{__('purchase.Recieve Your Product')}} </a>
                    </li>
                @endif
                @if (permissionCheck('purchase_order.cost_of_goods.index'))
                    <li>
                        <a href="{{route('purchase_order.cost_of_goods.index')}}" class="{{request()->is('inventory/inventory/cost-of-goods-history') ? 'active' : ''}}"> {{__('inventory.Product Costing')}}({{__('inventory.Sales')}}) </a>
                    </li>
                @endif

                @if(permissionCheck('stock-transfer.index'))
                    <li>
                        <a href="{{route('stock-transfer.index')}}" class="{{request()->is('inventory/stock-transfer') || request()->is('inventory/stock-transfer/*') ? 'active' : '' }}"> {{__('common.Stock Transfer')}}</a>
                    </li>
                @endif
                @if(permissionCheck('stock.report'))
                    <li>
                        <a href="{{route('stock.report')}}" class="{{request()->is('inventory/stock-report') ? 'active' : ''}}"> {{__('common.Stock List')}} </a>
                    </li>
               @endif
                @if(permissionCheck('product_movement.index'))
                <li>
                    <a href="{{ route('product_movement.index') }}" class="{{request()->is('inventory/product-movement') ? 'active' : ''}}">{{ __('inventory.Product Movement') }}</a>
                </li>
                @endif
                @if(permissionCheck('stock_adjustment.index'))
                <li>
                    <a href="{{route('stock_adjustment.index')}}" class="{{request()->is('inventory/stock-adjustment/*') ? 'active' : ''}}"> {{__('common.Stock Adjustment')}} </a>
                </li>
                @endif
                @if(permissionCheck('stock_adjustment.index'))
                <li>
                    <a href="{{route('stock.product.info')}}" class="{{request()->is('inventory/stock-product-info') ? 'active' : ''}}"> {{__('inventory.Product Info')}} </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
