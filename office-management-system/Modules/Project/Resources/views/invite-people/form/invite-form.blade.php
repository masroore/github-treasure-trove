@csrf

<input type="hidden" name="team_id" value="{{ $team->id }}">

<div class="col-xl-12">
    <div class="mb-25">
        {{ Form::label('project_id', __('project::project.select_project') , ['class' => 'primary_input_label']) }}
        {{ Form::select('project_id', $projects, null , ["class" => "primary_select", "placeholder" => __('project::project.select_project'), 'data-parsley-errors-container' => '#project_id_error']) }}
        <span id="project_id_error"></span>

    </div>
</div>

<div class="col-xl-12">
    <div class="tagInput_field mb-25">
        {{ Form::label('members', __('project::team.member') , ['class' => 'primary_input_label required']) }}
        {{ Form::textarea('members', null , ["class" => "primary_input_field tag-input", "placeholder" => __('project::team.member'), "required", "data-role" => "tagsinput"]) }}
        <div id="user-suggestion-list"></div>
    </div>
</div>

<div class="col-lg-12 text-center">
    <div class="d-flex justify-content-center pt_20">
        <button type="submit" class="primary-btn semi_large2 fix-gr-bg submit" id="save_button_parent"><i class="ti-check"></i>{{ __('project::project.save') }}
        </button>
        <button type="button" class="primary-btn semi_large2 fix-gr-bg submitting" disabled style="display: none;">
            <span class="ti-lock mr-2"></span>
           {{  __('project::project.saving') }}
        </button>

    </div>
</div>
