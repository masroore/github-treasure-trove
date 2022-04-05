@if(permissionCheck('project'))
@if(count($user_favourite) > 0)
<li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
        <div class="nav_icon_small">
            <span class="fa fa-users"></span>
        </div>
        <div class="nav_title">
            <span>{{ trans('project::project.favourites') }}</span>
        </div>
    </a>
    <ul>
        @foreach($user_favourite as $project)
        <li>
            <a href="{{ route('project.show',$project->uuid) }}"> <span class="color_boxed mr_10" style="background: #{{ gv(my_project_configuration($project), 'color', '7F32FE') }};"></span> {{ Str::limit($project->name, 20, '...') }}</a>
        </li>
        @endforeach

    </ul>
</li>
@endif

@php
    $nav = ['team.show', 'project.show'];
@endphp
<li class="{{ spn_nav_item_open($nav, 'mm-active') }}">
    <!-- Team  -->
    <a href="javascript:" class="has-arrow" aria-expanded="{{ spn_nav_item_open($nav, 'true') }}">
        <div class="nav_icon_small">
            <span class="fa fa-users"></span>
        </div>
        <div class="nav_title">
            <span>{{ trans('project::project.project') }}</span>
        </div>
    </a>
    <ul class="mm-collapse opcity_remove">
        @foreach($global_teams as $key => $global_team)
            <li class="position-relative ">
                <a href="{{ route('team.show', $global_team->id) }}" class="left_arrow_menu has-arrow ">{{ $global_team->name }}</a>
                <div class="btn-group create_pro_btns">
                    <button type="button" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-plus"></i>
                    </button>
                    <div class="dropdown-menu pm_dropdown_menu dropdown-menu-right">
                        <a href="{{ route('project.create', $global_team->id) }}" class="dropdown-item">{{ trans('project::project.create') }}</a>
                    </div>
                </div>
                <div class="btn-group create_pro_btns main_sujj_more">
                    <button type="button" class="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-more-alt"></i>
                    </button>
                    <div class="dropdown-menu pm_dropdown_menu dropdown-menu-right">
                        <a href="{{ route('user.team.remove', $global_team->id) }}" class="dropdown-item">{{ __('project::team.remove_me') }}</a>
                    </div>
                </div>
                <ul class="mm-collapse @if((isset($model) and $model->getTable() == 'teams' and $model->id == $global_team->id) or  ( isset($model) and $model->getTable() == 'projects' and $model->team->id == $global_team->id)) mm-show @endif">
                    <div class="team_memberList">

                        <!-- small_avater  -->

                        @foreach($global_team->allUsers() as $user)
                            <div class="small_avater">
                                <img src="{{ $user->ProfilePhotoUrl }}" alt="">
                                <div class="hover_img">
                                    <img src="{{ $user->ProfilePhotoUrl }}" alt="">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="">
                        <a class="btn-modal pointer" data-container="invite_modal"
                           data-href="{{ route('team.invite.create', $global_team->id) }}"><i class="ti-plus"></i> {{ trans('project::project.invite_people') }}</a>
                    </div>

                    @foreach($global_team->projects as $project)
                        <li>
                            <a href="{{ route('project.show', $project->uuid) }}" class="{{ (isset($model) and $model->getTable() == 'projects' and $model->id == $project->id) ? 'active' : ''  }}"> <span class="color_boxed mr_10" style="background: #{{ gv(my_project_configuration($project), 'color', '7F32FE') }};"></span> {{ Str::limit($project->name, 20, '...') }}</a>

                        </li>
                    @endforeach

                </ul>
            </li>
        @endforeach

        <li><a class="dropdown-item pl_32 btn-modal pointer" data-container="team_modal"
               data-href="{{ route('team.create') }}">{{ trans('project::team.create') }} </a></li>
    </ul>
</li>

@endif
