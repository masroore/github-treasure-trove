@php
        $php_session_id = session()->getId();
        $cart_counts = App\Models\TempCart::where('php_session_id', $php_session_id)->count();
@endphp
<div class="row">
        <div class="col-lg-7 col-xl-6 mx-lg-auto px-0">
            <ul class="d-flex menu-dark-pills">
                 <li><a href="{{route('cart')}}" class="{{(isset($activePage) && $activePage=='Cart') ? 'active' : ''}}" title="Cart">Cart</a></li>
                    <li><a href="{{route('delivery')}}" title="Delivery" class="{{(isset($activePage) && $activePage=='Delivery') ? 'active' : ''}}">Delivery</a></li>
                    <li><a href="javascript:void(0)" class="{{(isset($activePage) && $activePage=='Payment') ? 'active' : ''}}" title="Payment">Payment</a></li>
                    <li><a href="javascript:void(0)" class="{{(isset($activePage) && $activePage=='Receipt') ? 'active' : ''}}" title="Receipt">Receipt</a></li>
                    
                <!-- @if($cart_counts > 0)
                    <li><a href="{{route('cart')}}" class="{{(isset($activePage) && $activePage=='Cart') ? 'active' : ''}}" title="Cart">Cart</a></li>
                    <li><a href="{{route('delivery')}}" title="Delivery" class="{{(isset($activePage) && $activePage=='Delivery') ? 'active' : ''}}">Delivery</a></li>
                    <li><a href="javascript:void(0)" class="{{(isset($activePage) && $activePage=='Payment') ? 'active' : ''}}" title="Payment">Payment</a></li>
                    <li><a href="javascript:void(0)" class="{{(isset($activePage) && $activePage=='Receipt') ? 'active' : ''}}" title="Receipt">Receipt</a></li>
                @else
                    <li><a href="javascript:void(0)" class="{{(isset($activePage) && $activePage=='Cart') ? 'active' : ''}}" title="Cart">Cart</a></li>
                    <li><a href="javascript:void(0)" title="Delivery" class="{{(isset($activePage) && $activePage=='Delivery') ? 'active' : ''}}">Delivery</a></li>
                    <li><a href="javascript:void(0)" class="{{(isset($activePage) && $activePage=='Payment') ? 'active' : ''}}" title="Payment">Payment</a></li>
                    <li><a href="javascript:void(0)" class="{{(isset($activePage) && $activePage=='Receipt') ? 'active' : ''}}" title="Receipt">Receipt</a></li>
                @endif -->
            </ul>
        </div>
    </div>