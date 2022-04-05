<div class="modal fade admin-query" id="sale_info_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __("setup.Loan Detail's") }} - ({{ @$user->name }})</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{__('common.Name')}}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Email') }}:</label>
                            <label class="primary_input_label" for="">{{ __('common.Phone') }}:</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="">{{ @$user->name }}</label>
                            <label class="primary_input_label" for="">{{ @$user->email }}</label>
                            <label class="primary_input_label" for="">{{ @$user->staff->phone }}</label>
                        </div>
                    </div>
                </div>

                <table
                    class="table table-bordered">
                    <tr class="m-0">
                        <th>#</th>
                        <th>{{__('payroll.Total Loan')}}</th>
                        <th>{{__('payroll.Paid Amount')}}</th>
                        <th>{{__('payroll.Due Loan Amount')}}</th>
                        <th>{{__('payroll.Installment')}}</th>
                        <th>{{__('common.Status')}}</th>
                    </tr>

                    @foreach($user->loans as $key => $loan)
                        <tr>
                            <td class="p-2">{{$key+1}}</td>
                            <td class="p-2">{{single_price(@$loan->amount)}}</td>
                            <td class="p-2">{{single_price(@$loan->paid_loan_amount)}}</td>
                            <td class="p-2">{{single_price(@$loan->amount > $loan->paid_loan_amount ? $loan->amount - $loan->paid_loan_amount : 0)}}</td>
                            <td class="p-2">{{single_price($loan->monthly_installment)}}</td>
                            <td class="p-2">
                                @if ($loan->paid == 0)
                                    <h6><span class="badge_4">{{__('sale.Unpaid')}}</span></h6>
                                @else
                                    <h6><span class="badge_1">{{__('sale.Paid')}}</span></h6>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
