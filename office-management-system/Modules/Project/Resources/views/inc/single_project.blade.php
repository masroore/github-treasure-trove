@if($project)
    <div class="Single_recent_work" id="single_project" data-url="{{ route('project.show',$project->uuid) }}">
        <div class="recent_work_thumb" style="background: #{{ gv(my_project_configuration($project), 'color', '7F32FE') }};">
            <div class="recent_work_top d-flex align-items-center justify-content-between">
                <div class="icon">
                @if(gv(my_project_configuration($project), 'favourite', 0))
                    <i class="fas fa-star"></i>
                @else
                    <i class="ti-star"></i>
                @endif
                </div>
                <div class="btn-group normal_dropdown_btn">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h minWidth_icon"></i>
                    </button>
                    <div class="dropdown-menu pm_mini_dropdown  mt-0">
                        @if(gv(my_project_configuration($project), 'favourite', 0))
                            <a class="dropdown-item" onClick="unmarkFavorite({{ $project->id }})">{{ trans('project::project.remove_favorite') }}</a>
                        @else
                            <a class="dropdown-item" onClick="markFavorite({{ $project->id }})">{{ trans('project::project.add_to_favorite') }}</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="work_icon">
                <i class="{{ gv(my_project_configuration($project), 'icon', 'ti-menu-alt') }}"></i>
            </div>
            <div class="recent_work_bottom">
                <div class="recent_work_assignd">
                    @foreach($project->users as $user)
                        <div class="single_assignd">
                            <img src="{{ $user->ProfilePhotoUrl }}" alt="">
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="recent_work_content">
            <a href=""><span>{{ $project->name }}</span></a>
            <p>{{ $project->team->name }}</p>
        </div>
    </div>
    @endif

@push('js_after')
    <script>
        $(document).on('click', '#single_project', function(){
            var url = $(this).data('url')
            window.location.href = url
        })


       function markFavorite(project_id){
            
            $.post('{{ route('update-project-favorite') }}',{
                project_id : project_id,
                favorite : 1
            },res => {
                console.log(res)
                location.reload();
            })
        }


       function unmarkFavorite(project_id){
            $.post('{{ route('update-project-favorite') }}',{
                project_id : project_id,
                favorite : 0
            },res => {
                console.log(res)
                location.reload();
            })
        }

        
    </script>
@endpush

