@extends('project::layouts.master', ['title' => $model->name])

@section('header_content')
    <!-- pm_project_icon  -->
<div class="header_iner infixbiz_subheader border_bottom_1px d-flex justify-content-between align-items-center">
<div class="pm_project_top__header">
<div>
<div class="pm_project__title">
        <!-- pm_project_title_top  -->
        <div class="pm_project_title_top">
            <h3>{{ $model->name }}</h3>
        </div>
        <!-- tab navigation  -->
        <div class="pm_tab_navBar">
            <ul class="nav" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="active" id="overview-tab" data-toggle="tab" href="#overview" role="tab"
                       aria-controls="overview" aria-selected="true">{{ __('project::project.overview') }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="pm_share__project">
        <div data-toggle="modal" type="button" data-target="#share_project"
             class="project_owner_head mr_10 cursor_pointer avater_group justify-content-end">
            @foreach($model->allUsers() as $user)
                <div class="thumb thumb_24">
                <img src="{{ $user->ProfilePhotoUrl }}" alt="">
                </div>
            @endforeach
        </div>
        <div  type="button" data-container="invite_modal" data-href="{{ route('team.invite.create', $model->id) }}" class="pm_share_btn cursor_pointer btn-modal">
            <i class="fas fa-user-friends"></i> {{__('project::project.Share')}}
        </div>
    </div>
</div>
    
</div>
</div>
@endsection

@section('content')
    <div class="tab-content" id="tabcontent">
        <!-- list  -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">

            <!-- team_overview_area::start   -->
            <div class="team_overview_area">
                <div class="team_overview_left">

                    <div class="single_teamMembers">
                        <div class="sub_title">
                            <h4>{{ __('project::project.description') }}</h4>
                        </div>
                        {!! Form::model($model, ['url' => route('team.update', $model->id), 'method' => 'put', 'id' => 'content_form' ]) !!}
                        {{ Form::hidden('type', 'description') }}
                        {{ Form::textarea('description', Null, ['class' => 'primary_textarea height_104 mb_20 border-0', 'placeholder' => __('project::team.add_description'), 'id' => 'update_description', 'data-parsley-errors-container' => '#update_description_error' ] ) }}
                        <span id="update_description_error"></span>
                        {!! Form::close() !!}
                        <div class="sub_title">
                            <h4>{{ __('project::project.member') }}</h4>
                        </div>
                        <div class="team_member_lists">
                            @foreach($model->allUsers() as $user)
                                <div class="member_modal_avater d-flex align-items-center mb_10">
                                    <div class="thumb thumb_32 mr-15">
                                        <img src="{{ $user->ProfilePhotoUrl  }}" alt="#">
                                    </div>
                                    <div class="modal_member_info">
                                        <p class="f_s_11 f_w_400 line_h_1">{{ $user->name }} @if($user->id == $model->id)
                                                <span
                                                    class="badge badge-warning">{{ __('project::project.owner') }}</span> @endif
                                        </p>
                                        <h3 class="f_s_13 f_w_400 mb-0 line_h_1">{{ $user->email }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="team_overview_right">

                    <div class="sub_title">
                        <h4>{{ __('project::project.projects') }}</h4>
                    </div>
                    <div class="recent_work_viewFile_lists pt-0">
                        <!-- Single_recent_work  -->
                        <a href="{{ route('project.create', $model->id) }}">
                            <div class="Single_recent_work">
                                <div class="recent_work_thumb dashed_line">
                                    <div class="work_icon">
                                        <i class="ti-plus"></i>
                                    </div>
                                </div>
                                <div class="recent_work_content">
                                    <span>{{__('project::project.New Project')}}</span>
                                </div>
                            </div>
                        </a>
                    @foreach($model->projects as $project)
                        <!-- Single_recent_work  -->
                        @includeIf('project::inc.single_project', ['project' => $project])
                            <!-- Single_recent_work  -->
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- team_overview_area::end -->
        </div>

        <div class="tab-pane fade " id="conversation" role="tabpanel" aria-labelledby="conversation-tab">
            <h2>{{__('project::project.Conversation Tab')}}</h2>
        </div>

        <div class="tab-pane fade " id="calender" role="tabpanel" aria-labelledby="calender-tab">
            <h2>{{__('project::project.Calender Tab')}}</h2>
        </div>
    </div>

@endsection

@push('js_after')
    <script>
        _formValidation('content_form')
        $(document).on('click', '#update_description', function () {
            $(this).removeClass('border-0');
        });

        $(document).on('blur', '#update_description', function () {
            $(this).addClass('border-0');
            $('#content_form').submit();
        })
    </script>
@endpush
