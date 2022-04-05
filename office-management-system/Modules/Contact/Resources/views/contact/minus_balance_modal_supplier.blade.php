<div class="modal fade admin-query" id="substractBalanceModal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('purchase.Subtract Balance')}}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('customer.minus_balance.store') }}" id="substractBalanceModalForm">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
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
                                <label class="primary_input_label"
                                       for=""> {{__("account.Amount")}} </label>
                                <input class="primary_input_field" name="sub_amount[]" id="main_amount" value="0" type="number" min="0" step="0.01">
                                <span class="text-danger">{{$errors->first('main_amount')}}</span>
                            </div>
                        </div>
                        <input class="primary_input_field" name="account_type" placeholder="{{__('account.Account Type')}}" type="hidden" value="dedit" readonly>

                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{__('contact.Select account to add balance')}} *</label>
                                <select class="primary_select mb-15 payment_from" name="account_id" id="account_id" required>
                                    <option>{{__('account.Select one')}}</option>
                                    @foreach ($accounts as $key => $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for=""> {{__("account.Narration")}} </label>
                                <input class="primary_input_field" name="narration" placeholder="{{__('account.Narration')}}" type="text" value="{{ old('narration') }}">
                                <span class="text-danger">{{$errors->first('narration')}}</span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{__('contact.Substaction Balance From')}}</label>
                                <input class="primary_input_field" name="name_customer" placeholder="{{__('contact.Substaction Balance From')}}}" type="text" value="{{ \Modules\Account\Entities\ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $supplier->id)->first()->name }}" readonly>
                                <input class="primary_input_field" name="sub_account_id[]" placeholder="{{__('contact.Substaction Balance From')}}}" type="hidden" value="{{ \Modules\Account\Entities\ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $supplier->id)->first()->id }}" readonly>
                                <span class="text-danger">{{$errors->first('sub_account_id')}}</span>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                        id="save_button_parent"><i
                                        class="ti-check"></i>{{__('purchase.Subtract Balance')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
