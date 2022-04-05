@extends('project::layouts.master_project', ['title' => __('project::project.create')])

@section('content')
    <div class="Pm_blank_project_form">
        <div class="main-title mb_50">
            <h3>{{ __('project::project.new_project') }}</h3>
        </div>
        @php
            $form_id = 'project_add_form';
            if(isset($quick_add)){
            $form_id = 'quick_add_project';
            }
        @endphp

        {!! Form::open(['url' => route('project.store'), 'method' => 'post', 'id' => $form_id, 'files' =>true ]) !!}
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <div class="primary_input mb-20">
                    {{ Form::label('name', __('project::project.name'), ['class' => 'primary_input_label required']) }}
                    {{ Form::text('name', null, ['placeholder' => __('project::project.name'), 'class'=> 'primary_input_field', 'required', 'id' => 'name', 'autofocus']) }}
                </div>

            </div>
            <div class="col-xl-6">
                <div class="primary_input mb-15">
                    {{ Form::label('team_id', __('project::project.team'), ['class' => 'primary_input_label required']) }}
                    {{ Form::select('team_id', $teams, $team_id ?? null, ['class'=> 'primary_select', 'required', 'id' => 'team_id', 'data-parsley-errors-container' => '#team_id_error']) }}
                   <span id="team_id_error"></span>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="primary_input mb-15">
                    {{ Form::label('privacy', __('project::project.privacy'), ['class' => 'primary_input_label required']) }}
                    {{ Form::select('privacy', [1 => __('project::project.public_to_team'), 2 => __('project::project.private_to_project_member'), 3=> __('project::project.private_to_me')], null, ['class'=> 'primary_select', 'required', 'id' => 'privacy', 'data-parsley-errors-container' => '#privacy_error']) }}
                    <span id="privacy_error"></span>
                </div>
            </div>
            <div class="col-xl-12 mb_50 mt-3">
                <label class="primary_input_label" for="">{{ __('project::project.default_view') }}</label>
                <input type="hidden" name="default_view" value="list" id="default_view">
                <ul class="nav project_view_layout" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" onclick="changeDefaultView('list')" data-toggle="tab"
                           href="#list_view" role="tab" aria-controls="home" aria-selected="true"> <i
                                class="ti-menu-alt"></i> {{ __('project::project.list_view') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" onclick="changeDefaultView('board')" data-toggle="tab"
                           href="#board_view" role="tab" aria-controls="profile" aria-selected="false"> <i
                                class="ti-blackboard"></i> {{ __('project::project.board_view') }}</a>
                    </li>
                   
                </ul>
            </div>
            <div class="col-12">


                <button type="submit" class="primary-btn  fix-gr-bg w-100 text-center submit"> {{ __('project::project.create') }}
                </button>

                <button type="button" class="primary-btn fix-gr-bg w-100 text-center submitting" disabled style="display: none;">
                    <span class="ti-lock mr-2"></span>
                    {{ __('project::project.saving') }}
                </button>


            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="Pm_blank_project_preview">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="list_view" role="tabpanel" aria-labelledby="home-tab">.
                <img class="tab_imgs" src="{{ asset('public/img/layout/list_view.svg') }}" alt="">
            </div>
            <div class="tab-pane fade" id="board_view" role="tabpanel" aria-labelledby="profile-tab">
                <img class="tab_imgs" src="{{ asset('public/img/layout/board_view.svg') }}" alt="">
            </div>
        </div>
    </div>
    @endsection

@push('js_after')
<script type="text/javascript">
    _formValidation('{{ $form_id }}');
    $('.primary_select').niceSelect();
    function changeDefaultView(val) {
        $('#default_view').val(val);
    }
</script>
@endpush
