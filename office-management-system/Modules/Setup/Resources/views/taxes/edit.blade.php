@if (isset($tax))
    <div class="modal fade admin-query" id="Tax_Edit">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('setup.Edit Tax InFo') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('tax.update', $tax->id) }}" id="tax_EditForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <input type="text" style="display: none;" class="edit_id">
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                    <input name="name" class="primary_input_field name" placeholder="{{ __('common.Name') }}" value="{{ $tax->name }}" type="text" required>
                                    <span class="text-danger" id="edit_name_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('setup.Rate') }} (%) *</label>
                                    <input name="rate" min="0" step="0.01" class="primary_input_field rate" type="number" value="{{ $tax->number }}" required>
                                    <span class="text-danger" id="edit_rate_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Description') }}</label>
                                    <textarea class="primary_textarea height_112 description" placeholder="{{ __('common.Description') }}" name="description" spellcheck="false">{{ $tax->number }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Update') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endif
