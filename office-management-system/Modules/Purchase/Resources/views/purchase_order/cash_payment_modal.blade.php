<div class="modal fade admin-query" id="Pos_Payment_Multiple">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('pos.Cash Payment')}}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-6 text-center">
                        <table class="text-center">
                            <tr>
                                <td> <h3>{{__('report.Supplier')}}:</h3></td>
                                <td><h3>{{ $supplier }}</h3></td>
                            </tr>
                            <tr>
                                <td><h4>{{__('pos.Total Qty')}}:</h4></td>
                                <td><h4>{{ $total_qty }}</h4></td>
                            </tr>
                            <tr>
                                <td><h4>{{__('pos.Total Bill')}}:</h4></td>
                                <td class="total_bill_amount"><h4>{{ single_price($total_amount) }}</h4></td>
                            </tr>
                            <tr>
                                <td>{{__('pos.Recieved Amount')}}:</td>
                                <td class="total_recieved_amount"></td>
                            </tr>
                            <tr>
                                <td>{{__('pos.Change Amount')}}:</td>
                                <td class="total_change_amount"></td>
                            </tr>
                        </table>
                    </div>
                    <input type="hidden" name="totall_bill" id="totall_bill" value="{{ $total_amount }}">
                    <div class="col-6 text-left">
                        <input type="hidden" class="quick_amounts" name="quick_amounts">
                        <ul class="quick_cash_list quick_cash">
                            <li><a class="add_cash" data-id="5000" href="javascript:void(0)">5000 <span class="quick_cash_number"></span></a></li>
                            <li><a class="add_cash" data-id="1000" href="javascript:void(0)">1000 <span class="quick_cash_number"></span></a></li>
                            <li><a class="add_cash" data-id="500" href="javascript:void(0)">500 <span class="quick_cash_number"></span></a></li>
                            <li><a class="add_cash" data-id="100" href="javascript:void(0)">100 <span class="quick_cash_number"></span></a></li>
                            <li><a class="add_cash" data-id="50" href="javascript:void(0)">50 <span class="quick_cash_number"></span></a></li>
                            <li><a class="add_cash" data-id="20" href="javascript:void(0)">20 <span class="quick_cash_number"></span></a></li>
                            <li><a class="add_cash" data-id="10" href="javascript:void(0)">10 <span class="quick_cash_number"></span></a></li>
                            <li class="clear_quick_cash"><a href="javascript:void(0)">{{__('pos.Clear')}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="primary-btn semi_large2 fix-gr-bg" data-dismiss="modal"><i class="ti-close"></i>{{ __('common.Cancel') }}</button>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="primary-btn semi_large2 fix-gr-bg"><i class="ti-check"></i>{{ __('common.Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        let i = 0;
        let amounts = [];
        $('.quick_cash_number').hide();
        $(document).on('click','.add_cash',function (){
            let selector = $(this).children('.quick_cash_number');
            let value = selector.text();
            let amount = $(this).data('id');
            var total_amount = 0;
            var total_bill = $('#totall_bill').val();
            var change_amount = 0;
            selector.show()

            if (value)
            {
                selector.text(parseInt(value)+1)
                amounts.push(amount);
                $('.quick_amounts').val(amounts);
            }
            else {
                selector.text(1);
                amounts.push(amount);
                $('.quick_amounts').val(amounts);
            }
            for (var i = 0; i < amounts.length; i++) {
                total_amount += amounts[i];
            }
            $('.total_recieved_amount').text(total_amount);
            $('.total_change_amount').text((total_amount - total_bill).toFixed(2));
        })

        $(document).on('click','.clear_quick_cash',function (){
            amounts = [];
            $('.quick_amounts').val('');
            let selector = $('.quick_cash_number');
            selector.hide();
            selector.text('');
            $('.total_recieved_amount').text('');
            $('.total_change_amount').text('');
        })
    })
</script>
