<div class="modal fade admin-query" id="Tax_Add">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Add New') }} {{ __('setup.Tax') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="#" id="tax_addForm">
                    @csrf
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                <input name="name" class="primary_input_field name" placeholder="{{ __('common.Name') }}" type="text" required>
                                <span class="text-danger" id="name_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setup.Rate') }} (%) *</label>
                                <input name="rate" min="0" step="0.01" class="primary_input_field name" type="number" required>
                                <span class="text-danger" id="rate_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Status') }}</label>
                                <select class="primary_select mb-25" name="status" id="status" required>
                                    <option value="1">{{ __('inventory.Active') }}</option>
                                    <option value="2">{{ __('inventory.De-Active') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Description') }}</label>
                                <textarea class="primary_textarea height_112" placeholder="{{ __('common.Description') }}" name="description" spellcheck="false"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center pt_20">
                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
