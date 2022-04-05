@extends('backEnd.master')
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('account.Account Cofiguration') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <div class="row">
                        @foreach (Modules\Setting\Model\BusinessSetting::where('category_type', 'voucher')->get() as $key => $voucher)
                            <div class="col-lg-3 col-md-4 col-sm-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ strtoupper(str_replace("_"," ",$voucher->type)) }}</label>
                                    <label class="switch_toggle" for="checkbox{{ $voucher->id }}">
                                        <input type="checkbox" id="checkbox{{ $voucher->id }}" @if ($voucher->status == 1) checked @endif value="{{ $voucher->id }}" onchange="update_active_status(this)">
                                        <div class="slider round"></div>
                                    </label>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-0 mt-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <form action="{{route("account.configuration.store")}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('setup.Cash Account') }}</label>
                                    <input type="hidden" name="account_category_id[]" value="1">
                                    <select class="primary_select mb-25" name="cash_acc_cat_id[]" id="cash_acc_cat_id" multiple>
                                        <option value="">{{ __('common.Choose') }}</option>
                                        @foreach ($accounts as $key => $account)
                                            <option value="{{ $account->id }}" @if (selected_account_config('1', $account->id)) selected @endif>{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('setup.Bank Account') }}</label>
                                    <input type="hidden" name="account_category_id[]" value="2">
                                    <select class="primary_select mb-25" name="bank_acc_cat_id[]" id="bank_acc_cat_id" multiple>
                                        <option value="">{{ __('common.Choose') }}</option>
                                        @foreach ($accounts as $key => $account)
                                            <option value="{{ $account->id }}" @if (selected_account_config('2', $account->id)) selected @endif>{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('setup.A\C Receivable') }}</label>
                                    <input type="hidden" name="account_category_id[]" value="3">
                                    <select class="primary_select mb-25" name="acc_recievable_id[]" id="acc_recievable_id" multiple>
                                        <option value="">{{ __('common.Choose') }}</option>
                                        @foreach ($accounts as $key => $account)
                                            <option value="{{ $account->id }}" @if (selected_account_config('3', $account->id)) selected @endif>{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('setup.A\C Payable') }}</label>
                                    <input type="hidden" name="account_category_id[]" value="4">
                                    <select class="primary_select mb-25" name="acc_payable_id" id="acc_payable_id">
                                        <option value="">{{ __('common.Choose') }}</option>
                                        @foreach ($accounts as $key => $account)
                                            <option value="{{ $account->id }}" @if (selected_account_config('4', $account->id)) selected @endif>{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{ __('setup.A\C Equity or Capital') }}</label>
                                    <input type="hidden" name="account_category_id[]" value="5">
                                    <select class="primary_select mb-25" name="acc_equity_id" id="acc_equity_id">
                                        <option value="">{{ __('common.Choose') }}</option>
                                        @foreach ($accounts as $key => $account)
                                            <option value="{{ $account->id }}" @if (selected_account_config('5', $account->id)) selected @endif>{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="submit_btn text-center ">
                                    <button class="primary-btn semi_large2 fix-gr-bg"><i class="ti-check"></i> {{ __('common.Save') }} </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@push('scripts')
    <script type="text/javascript">
    function update_active_status(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('update_activation_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                toastr.success("Successfully Updated","Success");
            }
            else{
                toastr.warning("Something went wrong");
            }
        });
    }
    </script>
@endpush
