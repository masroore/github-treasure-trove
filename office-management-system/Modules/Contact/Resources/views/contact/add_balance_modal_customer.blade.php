<div class="modal fade admin-query" id="addBalanceModal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('purchase.Add Balance')}}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('customer.voucher_recieve.store') }}" id="addBalanceModalForm">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="voucher_type" name="voucher_type" value="">
                        <div class="col-xl-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{__('account.Date')}}</label>
                                <div class="primary_datepicker_input">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="Date" class="primary_input_field primary-input date form-control" id="startDate" type="text" name="date" value="" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{__('contact.Balance Adding Account')}}</label>
                                <input class="primary_input_field" name="credit_account_name" placeholder="{{__('contact.Substaction Balance From')}}}" type="text" value="{{ \Modules\Account\Entities\ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $customer->id)->first()->name }}" readonly>
                                <input class="primary_input_field" name="credit_account_id" placeholder="{{__('contact.Substaction Balance From')}}}" type="hidden" value="{{ \Modules\Account\Entities\ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $customer->id)->first()->id }}" readonly>
                                <span class="text-danger">{{$errors->first('credit_account_id')}}</span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{ __('account.Narration')}} </label>
                                <input class="primary_input_field" name="debit_account_narration[]" placeholder="Narration" type="text">
                                <span class="text-danger">{{$errors->first('debit_account_narration')}}</span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{__('account.Amount')}} </label>
                                <input class="primary_input_field" name="debit_account_amount[]" placeholder="Amount" type="number">
                                <span class="text-danger">{{$errors->first('debit_account_amount')}}</span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{__('account.Recieve By')}}</label>
                                <select class="primary_select mb-15" name="debit_account_id" id="debit_account_id" required>
                                    <option>Select one</option>
                                    @foreach ($recieve_by_accounts as $key => $recieve_by_account)
                                        <option value="{{ $recieve_by_account->id }}">{{ $recieve_by_account->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{$errors->first('debit_account_id')}}</span>
                            </div>
                        </div>

                        <div class="col-lg-6 cheque_no_div">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                       for=""> {{('account.Cheque Number')}} </label>
                                <input class="primary_input_field" name="cheque_no" id="cheque_no" placeholder="Cheque Number" type="text" value="{{old('cheque_no')}}" required>
                                <span class="text-danger">{{$errors->first('cheque_no')}}</span>
                            </div>
                        </div>

                        <div class="col-lg-6 cheque_date_div">
                            <div class="primary_input mb-15">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="">{{__('account.Cheque Date')}}</label>
                                    <div class="primary_datepicker_input">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="">
                                                    <input placeholder="Date" class="primary_input_field primary-input date form-control" id="cheque_date" type="text" name="cheque_date" value="" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <button class="" type="button">
                                                <i class="ti-calendar" id="start-date-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 bank_name_div">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                       for=""> {{__('account.Bank Name')}} </label>
                                <input class="primary_input_field" name="bank_name" id="bank_name" placeholder="Bank Name" type="text" value="{{old('bank_name')}}" required>
                                <span class="text-danger">{{$errors->first('bank_name')}}</span>
                            </div>
                        </div>

                        <div class="col-lg-6 bank_branch_div">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{__('account.Bank Branch')}} </label>
                                <input class="primary_input_field" name="bank_branch" id="bank_branch" placeholder="Bank Branch" type="text" value="{{old('bank_branch')}}" required>
                                <span class="text-danger">{{$errors->first('bank_branch')}}</span>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                        id="save_button_parent"><i
                                        class="ti-check"></i>{{ __('purchase.Add Balance') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
