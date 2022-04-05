        @if(permissionCheck('conditional'))

        @php

            $conditional = false;

            if(request()->is('conditional-sales') || request()->is('conditional-sale/*'))
            {
                $conditional = true;
                $sale = false;
            }

        @endphp

        <li class="{{ $conditional ?'mm-active' : '' }}">
            <a href="javascript:void (0);" class="has-arrow" aria-expanded="false">
                <div class="nav_icon_small">
                    <span class="fas fa-gavel"></span>
                </div>
                <div class="nav_title">
                    <span>{{__('sale.Conditional Sale')}}</span>
                </div>
            </a>
            <ul>
                <li>
                    <a href="{{route('conditional.sale.index')}}" class="{{request()->is('conditional-sales') || request()->is('conditional-sale/*') ?'active':''}}"> {{__('sale.Sale on Condition')}}</a>
                </li>
            </ul>
        </li>
        @endif
