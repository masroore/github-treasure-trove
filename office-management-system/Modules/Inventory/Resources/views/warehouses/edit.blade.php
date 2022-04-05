<div class="modal fade admin-query" id="Warehouse_Edit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('inventory.Edit Warehouse Info') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('warehouse.update',$warehouse->id) }}" method="POST" id="division_editForm">
                    @csrf
                    <div class="row">

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                <input name="name" class="primary_input_field name" placeholder="{{ __('common.Name') }}" type="text" value="{{ $warehouse->name }}" required>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Email') }}</label>
                                <input name="email" class="primary_input_field name" placeholder="{{ __('common.Email') }}" type="email" value="{{ $warehouse->email }}">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Phone') }}</label>
                                <input name="phone" class="primary_input_field name" placeholder="{{ __('common.Phone') }}" type="text" value="{{ $warehouse->phone }}">
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Status') }} *</label>
                                <select class="primary_select mb-25" name="status" id="status" required>
                                    <option value="1"@if ($warehouse->status == 1) selected @endif>{{ __('inventory.Active') }}</option>
                                    <option value="2"@if ($warehouse->status == 2) selected @endif>{{ __('inventory.De-Active') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Address') }}</label>
                                <textarea class="primary_textarea height_112" placeholder="{{ __('common.Address') }}" name="address" spellcheck="false">{{ $warehouse->address }}</textarea>
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
