<div class="modal fade admin-query" id="IntroPrefix_Add">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Add New') }} {{ __('setup.Intro Prefix') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST" id="IntroPrefix_addForm">
                    <div class="row">

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setup.Prefix Name') }} *</label>
                                <input name="title" class="primary_input_field name" placeholder="{{ __('setup.Prefix Name') }}" type="text" required>
                                <span class="text-danger" id="title_error"></span>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('setup.Prefix Details') }} *</label>
                                <input name="prefix" class="primary_input_field name" placeholder="{{ __('setup.Prefix Details') }}" type="text" required>
                                <span class="text-danger" id="prefix_error"></span>
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
