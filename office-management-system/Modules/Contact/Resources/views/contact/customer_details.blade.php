<div class="modal fade admin-query" id="Customer_info_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Customer Details') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('common.Name') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Email') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Phone') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Address') }}:</label>
                            <label class="primary_input_label" for="">{{ __('setup.Country') }}:</label>
                            <label class="primary_input_label" for="">{{ __('contact.State') }}:</label>
                            <label class="primary_input_label" for="">{{ __('contact.City') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Tax Number') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Opening Balance') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Registered Date') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Active Status') }}:</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ $customer->name }}.</label>
                            <label class="primary_input_label" for="">{{ $customer->email }}.</label>
                            <label class="primary_input_label" for="">{{ $customer->mobile }}.</label>
                            <label class="primary_input_label" for="">{{ $customer->address }}.</label>
                            <label class="primary_input_label" for="">{{ @$customer->country->name }}.</label>
                            <label class="primary_input_label" for="">{{ $customer->state }}.</label>
                            <label class="primary_input_label" for="">{{ $customer->city }}.</label>
                            <label class="primary_input_label" for="">{{ $customer->tax_number }}.</label>
                            <label class="primary_input_label" for="">{{ single_price($customer->opening_balance) }}.</label>
                            <label class="primary_input_label" for="">{{ date(app('general_setting')->dateFormat->format, strtotime($customer->created_at)) }}</label>
                            @if ($customer->is_active == 1)
                                <span class="badge_1">Active</span>
                            @else
                                <span class="badge_4">De-Active</span>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <label class="primary_input_label" for="">
                            @php
                                echo $customer->note;
                            @endphp
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $( "#status" ).change(function() {
            var voucher_id = $('#voucher_id').val();
            var status = $('#status').val();
            $.post('{{ route('set_voucher_approval') }}', {_token:'{{ csrf_token() }}', id:voucher_id, status:status}, function(data){
                if (data == 1) {
                    toastr.success("Status has been updated Successfully.","Success");
                    location.reload();
                }
                else{
                     toastr.error("Something went wrong","error");
                }
            });
        });
    });

    setInterval(function() {
        sum();
    }, 1000);

    function sum()
    {
        var debits = $("input[name='debit[]']").map(function(){return $(this).val();}).get();
        var credits = $("input[name='credit[]']").map(function(){return $(this).val();}).get();
        var total_debit = 0;
        var total_credit = 0;
        for (var i = 0; i < debits.length; i++) {
            total_debit = parseInt(total_debit) + parseInt(debits[i]);
        }
        for (var i = 0; i < credits.length; i++) {
            total_credit = parseInt(total_credit) + parseInt(credits[i]);
        }
        $("#total_debit").html(total_debit.toFixed(2));
        $('#total_credit').html(total_credit.toFixed(2));
    }
</script>
