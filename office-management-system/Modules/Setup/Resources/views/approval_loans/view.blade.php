<div class="modal fade admin-query" id="ApplyLoanview">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Apply Loan Details') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-6">
                       <img src="{{ asset(($loan->user != null and $loan->user->avatar) ? $loan->user->avatar : "public/backEnd/img/Fred_man-512.png") }}" id="view_common_image" style="height:200px;">
                    </div>

                    <div class="col-xl-6">
                        <p>{{__('common.Name')}} : <span>{{ $loan->user != null ? $loan->user->name : "Removed" }}</span></p>
                        <p>{{__('common.Email')}} : <span>{{ $loan->user != null ? $loan->user->email : "Removed" }}</span></p>
                        <p>{{__('common.Phone')}} : <span>{{ $loan->user != null ? $loan->user->staff->phone : "Removed" }}</span></p>
                        <p>{{__('common.Staff ID')}} : <span>{{ $loan->user != null ? $loan->user->staff->employee_id : "Removed" }}</span></p>
                        <p>{{__('common.Title')}} : <span>{{ $loan->title }}</span></p>
                        <p>{{__('department.Department')}} : <span></span>{{ @$loan->department->name }}</p>
                        <p>{{__('common.Loan Type')}} : <span></span>{{ $loan->lone_type }}</p>
                        <p>{{__('common.Applied Date')}} : <span></span>{{ date(app('general_setting')->dateFormat->format, strtotime($loan->apply_date)) }}</p>
                        <p>{{__('common.Loan Date')}} : <span></span>{{ date(app('general_setting')->dateFormat->format, strtotime($loan->loan_date)) }}</p>
                        <p>{{__('common.Amount')}} : <span></span>{{ single_price($loan->amount) }}</p>
                        <p>{{__('common.Paid Loan Amount')}} : <span ></span>{{ single_price($loan->paid_loan_amount) }}</p>
                        <p>{{__('common.Total Month')}} : <span></span>{{ $loan->total_month }}</p>
                        <p>{{__('common.Monthly Installment')}} : <span></span>{{ single_price($loan->monthly_installment) }}</p>
                    </div>

                    <div class="col-xl-12">
                        <label class="primary_input_label" for="">{{__('common.Description')}}</label>
                        <p id="view_product_description">{{ $loan->note }}</p>
                    </div>
                </div>
                @if ($loan->approval != 1)
                    <div class="row">
                        <input type="hidden" name="loan_id" id="loan_id" value="{{ $loan->id }}">
                        <div class="col-xl-9 mt-2">
                            <button type="submit" class="primary-btn btn-sm fix-gr-bg" data-dismiss="modal"><i class="ti-close"></i>{{ __('account.Cancel') }}</button>
                        </div>
                        <div class="col-xl-3">
                            <div class="primary_input mb-15 mt-1">
                                <select class="primary_select mb-15" name="approval" id="approval" required>
                                    <option>Select one</option>
                                    <option value="1">{{ __('account.Approve') }}</option>
                                    <option value="0">{{ __('account.Pending') }}</option>
                                    <option value="2">{{ __('account.Cancel') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $( "#approval" ).change(function() {
            var apply_leave_id = $('#loan_id').val();
            var approval = $('#approval').val();
            $.post('{{ route('set_approval_applied_loan') }}', {_token:'{{ csrf_token() }}', id:apply_leave_id, approval:approval}, function(data){
                if (data == 1) {
                    toastr.success("Aproval has been changed Successfully");
                    location.reload();
                }
                else{
                    toastr.warning("Something went wrong");
                }
            });
        });
    });
</script>
