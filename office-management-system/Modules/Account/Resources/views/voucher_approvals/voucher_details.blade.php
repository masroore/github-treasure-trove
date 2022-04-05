<div class="modal fade admin-query" id="Voucher_info_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('account.Transaction Details') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ __('account.Tx Id') }}</label>
                            <label class="primary_input_label" for="">{{ __('account.Date') }}</label>
                            <label class="primary_input_label" for="">{{ __('account.Created By') }}</label>
                            <label class="primary_input_label" for="">{{ __('account.Narration') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">: {{ $voucher->tx_id }}</label>
                            <label class="primary_input_label" for="">: {{ date('d-m-Y', strtotime($voucher->date)) }}</label>
                            <label class="primary_input_label" for="">: {{ $voucher->user->email }}</label>
                            <label class="primary_input_label" for="">: {{ $voucher->narration }}</label>
                        </div>
                    </div>
                </div>
                @if ($voucher->document != null)
                    <hr>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('account.Bank Name') }}</label>
                                <label class="primary_input_label" for="">{{ __('account.Bank Branch') }}</label>
                                <label class="primary_input_label" for="">{{ __('account.Cheque No') }}</label>
                                <label class="primary_input_label" for="">{{ __('account.Cheque Date') }}</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">: {{ $voucher->document->bank_name }}</label>
                                <label class="primary_input_label" for="">: {{ $voucher->document->bank_branch }}</label>
                                <label class="primary_input_label" for="">: {{ $voucher->document->cheque_date }}</label>
                                <label class="primary_input_label" for="">: {{ $voucher->document->cheque_no }}</label>
                            </div>
                        </div>
                    </div>
                @endif
                <hr>
                <div class="col-xl-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="col">
                                <table class="table Crm_table_active3">
                                    <tbody>
                                        <tr>
                                            <th scope="col">{{ __('account.Account Name') }}</th>
                                            <th scope="col">{{ __('account.Debit') }}</th>
                                            <th scope="col">{{ __('account.Credit') }}</th>
                                        </tr>
                                        @foreach ($voucher->transactions as $key => $payment)
                                            <tr>
                                                <td>{{ $payment->account->name }}</td>
                                                <td>
                                                    @if ($payment->type == "Dr")
                                                        {{ single_price($payment->amount) }}
                                                        <input type="hidden" name="debit[]" value="{{ $payment->amount }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($payment->type == "Cr")
                                                        {{ single_price($payment->amount) }}
                                                        <input type="hidden" name="credit[]" value="{{ $payment->amount }}">
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>{{ __('account.Total') }}</td>
                                            <td id="total_debit"></td>
                                            <td id="total_credit"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <input type="hidden" name="voucher_id" id="voucher_id" value="{{ $voucher->id }}">
                    <div class="col-xl-9 mt-2">
                        <button type="submit" class="primary-btn semi_large2 fix-gr-bg" data-dismiss="modal"><i class="ti-close"></i>{{ __('account.Cancel') }}</button>
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
                    toastr.success('Status has been updated Successfully.');
                    location.reload();
                }
                else{
                    toastr.error('Something went wrong');
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
