@if(session('insufficient_product_quantity'))
<div class="alert alert-danger alert-dismissable">
    <button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
    <strong><i class="fa fa-check"></i></strong> {!! Session::get('insufficient_product_quantity') !!}
</div>
@elseif(session('invalid_coupon'))
    <div class="alert alert-danger alert-dismissable">
        <button class="close" data-dismiss="alert"><i class="fa fa-times-circle"></i></button>
        <strong><i class="fa fa-warning"></i></strong> {!! Session::get('invalid_coupon') !!}
    </div>
@endif
