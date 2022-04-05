@csrf
<div class="col-xl-12">
    <div class="primary_input mb-25">
        {{ Form::label('name', __('project::workspace.name') , ['class' => 'primary_input_label required']) }}
        {{ Form::text('name', null , ["class" => "primary_input_field", "placeholder" => __('project::workspace.name'), "required"]) }}
    </div>
</div>

<div class="col-xl-12">
    <div class="tagInput_field mb-25">
        {{ Form::label('members', __('project::workspace.member') , ['class' => 'primary_input_label']) }}
        {{ Form::textarea('members', null , ["class" => "primary_input_field tag-input", "placeholder" => __('project::workspace.member'), "data-role" => "tagsinput"]) }}
        <div id="user-suggestion-list"></div>
    </div>
</div>

<div class="col-lg-12 text-center">
    <div class="d-flex justify-content-center pt_20">
        <button type="submit" class="primary-btn semi_large2 fix-gr-bg submit" id="save_button_parent"><i
                class="ti-check"></i>{{ __('project::workspace.Save') }}
        </button>
        <button type="button" class="primary-btn semi_large2 fix-gr-bg submitting" disabled style="display: none;">
            <span class="ti-lock mr-2"></span>
            {{ __('project::workspace.Saving') }}
        </button>

    </div>
</div>


