<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"><strong>Customers Details</strong></a></li>
    <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">Products</a></li>
    <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">Payment</a></li>
    <li class=""><a data-toggle="tab" href="#tab-4" aria-expanded="false">Shipping</a></li>
    <li class=""><a data-toggle="tab" href="#tab-5" aria-expanded="false">Extras</a></li>
    <li class=""><a data-toggle="tab" href="#tab-6" aria-expanded="false">Coupon</a></li>
</ul>
<br>

<div class="tab-content">
    <div id="tab-1" class="tab-pane active">
        @include('adminorder::formelements.general')
    </div>

    <div id="tab-2" class="tab-pane">
        @include('adminorder::formelements.product')
    </div>

    <div id="tab-3" class="tab-pane">
        @include('adminorder::formelements.payment')
    </div>

    <div id="tab-4" class="tab-pane">
        @include('adminorder::formelements.shippment')
    </div>
    <div id="tab-5" class="tab-pane">
        @include('adminorder::formelements.extra')
    </div>

    <div id="tab-6" class="tab-pane">

        <div class="form-group">
            <label class="control-label">Choose Coupon</label>
                <select name="coupon_id" class="form-control js-dropdown-select2" id="coupon_id">
                    <option value="">Select</option>

                    @if(old('coupon_id') || !isset($coupons))
                        @foreach ($coupons as $row=>$coupon)
                            <option value="{{ $coupon->id }}" @if($coupon->id==old('coupon_id')) selected @endif >{{ $coupon->code }}</option>
                        @endforeach
                    @else
                        @foreach ($coupons as $row=>$coupon)
                            <option value="{{ $coupon->id }}" @if($coupon->id==old('coupon_id',$coupon->id)) selected @endif>{{ $coupon->code }}</option>
                        @endforeach
                    @endif
                </select>
        </div>

    </div>

</div>


