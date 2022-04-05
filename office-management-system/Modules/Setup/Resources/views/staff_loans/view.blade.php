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
            </div>
        </div>
    </div>
</div>
