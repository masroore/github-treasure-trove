<!-- Add Modal Item_Details -->
<div class="modal fade admin-query" id="Item_Details">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Add New') }} {{ __('account.Bank Accounts') }}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form method="POST" id="chart_account_form">
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ trans('common.Bank Name') }} *</label>
                                <input name="bank_name" class="primary_input_field" placeholder="{{ trans('common.Bank Name') }}" type="text" required>
                                <span class="text-danger" id="bank_name_error"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Branch Name') }} *</label>
                                <input name="branch_name" class="primary_input_field" placeholder="{{ __('common.Branch Name') }}" type="text" required>
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>


                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Account Number') }} *</label>
                                <input name="account_no" class="primary_input_field" placeholder="{{ __('common.Account Number') }}" type="text" required>
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>


                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Account Name') }}</label>
                                <input name="account_name" class="primary_input_field" placeholder="{{ __('common.Account Name') }}" type="text">
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>

                        


                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                       for="">{{ __('common.Description') }}</label>
                                <input name="description" class="primary_input_field" placeholder="{{ __('common.Description') }}" type="text">
                                <span class="text-danger" id="description_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input">
                                <label class="primary_input_label"
                                       for="">{{ __('common.Status') }}</label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12 ">
                                            <input name="status" value="1" checked type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{trans('common.Active')}}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option"
                                               class="primary_checkbox d-flex mr-12">
                                            <input name="status" value="0" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{trans('common.DeActive')}}</p>
                                    </li>
                                </ul>
                                <span class="text-danger" id="status_error"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
