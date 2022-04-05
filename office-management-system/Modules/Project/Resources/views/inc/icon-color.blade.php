<div class="project_color_dropdown color_dropdown_open" v-if="color_dropdown_open" >
    <div class="color_picker_hedear">
        <div class="color_chose_List">
            @foreach(COLOR_CODE as $color)
                <label class="Color_checkbox d-flex  ">
                    <input name="colors" type="radio" value="{{ $color }}" @if(gv(my_project_configuration($project), 'color', '0064fb') == $color) checked @endif @click="updateColor('{{$color}}')">
                    <span style="background: #{{$color}}" class="checkmark"></span>
                </label>
            @endforeach
        </div>
    </div>
    <div class="icon_picker_body">
        <div class="icon_List">
            @foreach(ICON as $icon)
                <label class="Color_checkbox icon_checkbox d-flex  ">
                    <input name="icon_pick" type="radio" value="{{ $icon }}" @if(gv(my_project_configuration($project), 'icon', 'ti-menu-alt') == $icon) checked @endif @click="updateIcon('{{ $icon }}')">
                    <span class="checkmark" @if(gv(my_project_configuration($project), 'icon', 'ti-menu-alt') == $icon) style="background: #{{gv(my_project_configuration($project), 'color', '0064fb')}}" @endif> <i class="{{ $icon }}"></i> </span>
                </label>
            @endforeach
        </div>
    </div>
    <div class="project_color_footer">
        <ul class="permission_list">
            <li>
                <label class="primary_checkbox d-flex mr-12 ">
                    <input type="checkbox">
                    <span class="checkmark mr-2"></span>
                    <p>{{ trans('project::project.set_for_everyone') }}</p>
                </label>

            </li>
        </ul>
    </div>
</div>
