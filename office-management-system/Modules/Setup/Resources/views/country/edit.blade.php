<div class="modal fade admin-query" id="Country_Edit">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('setup.Edit Info Country') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="{{ route('country.update',$country->id) }}" method="POST" id="country_editForm">
                    @method('PUT')
                    @csrf
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.Name') }}</label>
                                <input name="name" class="primary_input_field name" placeholder="{{ __('common.Name') }}" type="text" value="{{ $country->name }}" required>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="description">{{ __('setup.Description') }}</label>
                                <textarea name="description" class="primary_textarea name" placeholder="{{ __('setup.Description') }}" >{!! $country->description !!}</textarea>
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
