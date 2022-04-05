
                <!-- Add Modal Item_Details -->
                <div class="modal fade admin-query" id="Item_Details">
                    <div class="modal-dialog modal_800px modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('common.Add New') }} {{ __('account.Chart Of Accounts') }}</h4>
                                <button type="button" class="close " data-dismiss="modal">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form method="POST" id="chart_account_form">
                                    <div class="row">

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Name') }}</label>
                                                <input name="name" class="primary_input_field" placeholder="Name" type="text" required>
                                                <span class="text-danger" id="name_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12" class="account_type" id="account_type">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.Type') }}</label>
                                                <select class="primary_select mb-25" name="type" id="type" required>
                                                    <option value="1">{{__('account.Asset')}}</option>
                                                    <option value="2">{{__('account.Liability')}}</option>
                                                    <option value="3">{{__('account.Expense')}}</option>
                                                    <option value="4">{{__('account.Income')}}</option>
                                                    <option value="5">{{__('account.Equity')}}</option>
                                                </select>
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
                                                       for="">{{ __('common.Is Group / Cost Center') }}</label>
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12 ">
                                                            <input name="is_group" value="1" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{__('common.Yes')}}</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="is_group" value="0" checked type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{__('common.No')}}</p>
                                                    </li>
                                                </ul>
                                                <span class="text-danger" id="is_group_error"></span>
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
                                                        <p>{{__('common.Active')}}</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option"
                                                               class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="0" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{__('common.DeActive')}}</p>
                                                    </li>
                                                </ul>
                                                <span class="text-danger" id="status_error"></span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                       for="">{{ __('account.Add as Sub Account') }} </label>
                                                <label data-id="color_option"
                                                       class="primary_checkbox d-flex mr-12">
                                                    <input name="as_sub_category" value="1" class="as_sub_category" type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 parent_chartAccount" style="display: none;">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{ __('account.Select parent Account') }} </label>
                                                <div id="parent_chart_account_list"></div>
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
