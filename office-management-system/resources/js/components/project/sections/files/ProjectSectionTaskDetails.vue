<template>
    <div class="project_slide_details project_slide_details_active" :class="{'class_name' : image_class}">
        <div class="project_slide_details_inner">
            <div class="project_slide_details_iner">
                <!-- project_slide_details_heder -->
                <div class="project_slide_details_header d-flex align-items-center">
                    <div class="project_slide_left">
                        <span class="primary-btn radius_30px  fix-gr-bg" @click="completeMarkTask"
                              v-if="!task.completed"> <i class="ti-check"></i>
                            {{ trans('project::project.mark_complete') }} </span>
                        <span class="primary-btn radius_30px  fix-gr-bg" @click="incompleteMarkTask"
                              v-if="task.completed"> <i class="ti-check"></i>
                            {{ trans('project::project.mark_incomplete') }} </span>
                    </div>
                    <div class="btn-group square_arrow_down_btn square_btn_32px " @click="addSubTask('append')">
                        <button>
                            <i class="ti-layout-list-thumb f_s_16"></i>
                        </button>
                    </div>
                    <div class="btn-group square_arrow_down_btn square_btn_32px " @click="likeTask(1)" v-if="!user_like">
                        <button>
                            <i class="ti-thumb-up f_s_16"></i> {{ like_count ? like_count : '' }}
                        </button>
                    </div>
                    <div class="btn-group square_arrow_down_btn square_btn_32px " @click="likeTask(0)" v-else>
                        <button style="color: blue">
                            <i class="ti-thumb-up f_s_16"></i>  {{ like_count ? like_count : '' }}
                        </button>
                    </div>
                    <div class="btn-group square_arrow_down_btn square_btn_32px ">
                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h  f_s_18"></i>
                        </button>
                        <div
                            class="dropdown-menu pm_dropdown_menu dropdown-menu-right mt-0 minWidth_260 multy_dropdown multy_dropdown_left">
                            <a class="dropdown-item" :href="'/task/'+task.uuid">
                                <i class="far fa-user filter_icon mr-2"></i>
                                {{ trans('project::project.full_screen') }}
                                
                            </a>
                            <span class="dropdown-item" @click.prevent="addTag">
                                <i class="far fa-user filter_icon mr-2"></i>
                                {{ trans('project::project.add_tag') }}
                                
                            </span>
                            <div class="menu_devider"></div>
                            <a href="#" @click.prevent="taskDelete" class="dropdown-item">
                                {{ trans('project::project.delete_task') }} </a>
                        </div>
                    </div>
                    <div class="btn-group square_arrow_down_btn square_btn_32px ">
                        <button class="project_d_hide" @click="taskDetailsClosed">
                            <i class="ti-shift-right f_s_16"></i>
                        </button>
                    </div>
                </div>
                <div class="project_d_body pb_30">
                    <div class="project_d_name">
                        <input class="task_textarea w-100" v-model="task.name" v-on:blur="submitTaskName()"
                               v-on:keyup="updateName($event)">
                    </div>
                    <div class="task_d_filed">
                        <template v-for="(field, field_index) in task.all_fields">
                            <project-section-task-details-fields :field="field" :project="project" :field_index="field_index" :task="task" :key="field_index+1" ref="project_field_details" />
                        </template>
                    </div>

                    <div class="mt_30">
                         <draggable :list="task.tasks" v group="section_tasks" :handle="'.sorthandle'" animation="200" 
                            @change="handleTaskChange()">
                            <transition-group >
                        <project-section-task-details-sub-tasks
                            :task="subtask"
                            :task_index="sub_task_index" @taskAdded="addSubTask"
                            @subtaskDeleted="deleteSubTask"
                            :ref="'sub_task_group_'+subtask.id"
                            :project="project"
                            :auth_user="auth_user"
                            @taskDetailsClosed="$emit('taskDetailsClosed')"
                            v-for="(subtask, sub_task_index) in task.tasks"
                            v-bind:key="subtask.id"
                            @showTask="showTask"
                            />
                           </transition-group>
                        </draggable>
                    </div>
                    <div class="add_subtask mt_20" >
                        <span class="primary-btn radius_30px  fix-gr-bg" @click="addSubTask('append')"> <i class="ti-plus"></i> {{ trans('project::project.add_subtask') }} </span>
                    </div>
                    <div class="project_d_thumbs mt_50">
                        <file-upload-input :button-text="'Upload document'" @showImage="AddClassForImage"  :token="taskForm.upload_token" module="task" :clear-file="clearAttachment" :module-id="task.id" ref="file_upload_input" @fileUploaded="getTask"></file-upload-input>
                    </div>
                    <div class="project_d_noteLists">
                        <div class="project_d_noteLists_header mb_10">
                            <div class="member_modal_avater d-flex align-items-center">
                                <div class="thumb thumb_32 mr-10">
                                    <img :src="userPhoto(task.creator)" alt="#">
                                </div>
                                <div class="modal_member_info">
                                    <span class="f_s_13 f_w_400 black_text mb-0 line_h_1">
                                        <a href="#" class="black_text">
                                            {{ task.creator ? task.creator.name : '' }}
                                        </a>
                                        <span>{{ trans('project::project.created_this_task') }} </span>
                                    </span>
                                    <span class="gray_text f_w_300"
                                          v-tooltip="formatDateTime(task.created_at)">{{ timeAgo(task.created_at) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="project_d_noteLists_header mb_10" v-for="(comment, index) in task.pined_comments"
                             v-bind:key="'pined_'+index+1">
                            <div class="member_modal_avater d-flex align-items-center">
                                <div class="thumb thumb_32 mr-10">
                                    <img :src="userPhoto(comment.creator)" alt="#">
                                </div>
                                <div class="modal_member_info">
                                    <span class="f_s_13 f_w_400 black_text mb-0 line_h_1">
                                        <a href="#" class="black_text">
                                            {{ comment.creator? comment.creator.name : '' }}
                                        </a>
                                        <span> {{ comment.event? comment.event.replace('_', ' ') : '' }} </span>
                                            <template v-if="comment.event == 'assigned_to'">
                                                    <span v-if="comment.new_id == auth_user.id">{{ trans('project::project.you') }} </span>
                                                    <span v-else>{{ comment.new ? comment.new.name : '' }} </span>
                                            </template>
                                            <template v-else-if="comment.event == 'added_to'">
                                                    {{ comment.new ? comment.new.name : '' }}
                                            </template>
                                            <template v-else-if="comment.event == 'remove_from'">
                                                    {{ comment.old ? comment.old.name : '' }}
                                            </template>
                                            <template v-else-if="(comment.event == 'completed') || (comment.event == 'incompleted')">
                                                     {{ trans('project::project.this_task') }}
                                            </template>
                                            <template v-else-if="(comment.event == 'update_field')">
                                                    {{ comment.field.name }} {{ trans('project::project.to') }}  "{{ comment.comment }}"
                                            </template>
                                            <template v-else-if="(comment.event == 'changed_to')">
                                                   {{ comment.new ? comment.new.option : '' }}
                                            </template>

                                    </span>
                                    <span class="gray_text f_w_300"  v-tooltip="formatDateTime(comment.created_at)">{{ timeAgo(comment.created_at) }}</span>
                                </div>
                                <div class="note_btns d-flex align-items-center">
                                <span class="ti-thumb-up mr_10"></span>
                                <div class="btn-group square_arrow_down_btn ">
                                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right mt-0  pm_mini_dropdown ">
                                    <span class="dropdown-item" v-if="!comment.pin_top" @click="pinToTop(comment.id, 1)"> {{ trans('project::project.pin_to_top') }} </span>
                                     <span class="dropdown-item" v-else @click="pinToTop(comment.id, 0)">{{ trans('project::project.unpin_to_top') }}</span>
                                    <span class="dropdown-item" href="#" v-if="comment.event == comment">{{ trans('project::project.edit_comment') }} </span>
                                    <span class="dropdown-item"  @click="deleteComment(comment.id)">{{ trans('project::project.delete_comment') }}</span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                            <div class="thumb_big ml_42" v-if="comment.event == 'attached'">
                                <a class="AttachmentImthumb_big_preview" :href="comment.new.filename" target="_blank">
                                    <img class="" :src="comment.new.filename" alt="">
                                </a>
                            </div>
                            <div class="thumb_big ml_42" v-else-if="!comment.event" v-html="comment.comment">

                            </div>
                        </div>
                        <div class="project_d_noteLists_header mb_10" v-for="(comment, index) in task.comments"
                             v-bind:key="index+1">
                            <div class="member_modal_avater d-flex align-items-center">
                                <div class="thumb thumb_32 mr-10">
                                    <img :src="userPhoto(comment.creator)" alt="#">
                                </div>
                                <div class="modal_member_info">
                                    <span class="f_s_13 f_w_400 black_text mb-0 line_h_1">
                                        <a href="#" class="black_text">
                                            {{ comment.creator? comment.creator.name : '' }}
                                        </a>
                                        <span> {{ comment.event? comment.event.replace('_', ' ') : '' }} </span>
                                            <template v-if="comment.event == 'assigned_to'">
                                                    <span v-if="comment.new_id == auth_user.id"> {{ trans('project::project.you') }}</span>
                                                    <span v-else>{{ comment.new ? comment.new.name : '' }} </span>
                                            </template>
                                            <template v-else-if="comment.event == 'added_to'">
                                                    {{ comment.new ? comment.new.name : '' }}
                                            </template>
                                            <template v-else-if="comment.event == 'remove_from'">
                                                    {{ comment.old ? comment.old.name : '' }}
                                            </template>
                                            <template v-else-if="(comment.event == 'completed') || (comment.event == 'incompleted')">
                                                    {{ trans('project::project.this_task') }}
                                            </template>
                                            <template v-else-if="(comment.event == 'update_field')">
                                                    {{ comment.field.name }} {{ trans('project::project.to') }} "{{ comment.comment }}"
                                            </template>
                                            <template v-else-if="(comment.event == 'changed_to')">
                                                   {{ comment.new ? comment.new.option : '' }}
                                            </template>

                                    </span>
                                    <span class="gray_text f_w_300"  v-tooltip="formatDateTime(comment.created_at)">{{ timeAgo(comment.created_at) }}</span>
                                </div>
                                <div class="note_btns d-flex align-items-center">
                                
                                <div class="btn-group square_arrow_down_btn ">
                                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right mt-0  pm_mini_dropdown ">
                                    <span class="dropdown-item" v-if="!comment.pin_top" @click="pinToTop(comment.id, 1)">{{ trans('project::project.pin_to_top') }}</span>
                                     <span class="dropdown-item" v-else @click="pinToTop(comment.id, 0)">{{ trans('project::project.unpin_to_top') }}</span>
                                    <span class="dropdown-item" href="#" v-if="comment.event == comment">{{ trans('project::project.edit_comment') }} </span>
                                    <span class="dropdown-item" @click="deleteComment(comment.id)">{{ trans('project::project.delete_comment') }}</span>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                            <div class="thumb_big ml_42" v-if="comment.event == 'attached'">
                                <a class="AttachmentImthumb_big_preview" :href="comment.new.filename" target="_blank">
                                    <img class="" :src="comment.new.filename" alt="">
                                </a>
                            </div>
                            <div class="thumb_big ml_42" v-else-if="!comment.event" v-html="comment.comment">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="project_d_footer d-flex">
                    <div class="thumb thumb_32 mr-10 mb_20">
                        <img :src="userPhoto(auth_user)" alt="#">
                    </div>
                    <div class="project_d_footer_right align-items-center w-100">
                        <html-editor name="description" :model.sync="taskForm.description" height="120" @htmlFocus="submitButton" :ref="'html_editor_'+task.id"></html-editor>
                        <div class="project_d_footer_bottom d-flex pl-0 pr-0">
                            <div class="leave_task d-flex align-items-center" v-if="submit_show">
                                <span class="f_s_14" @click="submitComment">{{ trans('project::project.submit') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
import ProjectSectionTaskDetailsFields from '../ProjectSectionTaskDetailsFields'
import ProjectSectionTaskDetailsSubTasks from './ProjectSectionTaskDetailsSubTasks'

export default {
    name: "project-section-task-details",
    components: {
        ProjectSectionTaskDetailsFields, ProjectSectionTaskDetailsSubTasks, draggable
    },
    props: {
        task_id: {
            type: [ String, Number ]
        },
        task_details: {
            type: Boolean
        },
        auth_user: {
            type: Object
        },
         project : {
            type: Object
        },
    },
    mounted() {
       this.getTask();
    },
    data() {
        return {
            input_changed: false,
            taskForm: {
                upload_token: '',
                description: ''
            },
            clearAttachment: true,
            like_count: 0,
            user_like: false,
            submit_show : 0,
            task: {},
            image_class: false
        }
    },

   
    methods: {
         AddClassForImage(val = false){
            this.image_class = val;
        },
        pinToTop(comment_id, val){
            axios.post('/comment/pin-to-top', {
                comment_id : comment_id,
                pin: val
            }).then( data => {
                this.task.comments = data.comments
                this.task.pined_comments = data.pined_comments
            })
        },
        deleteComment(comment_id){
            axios.post('/comment/delete', {
                comment_id : comment_id
            }).then( data => {
                this.task.comments = data.comments
                this.task.pined_comments = data.pined_comments;
                this.$nextTick(() => {
                    this.$refs.file_upload_input.fetchUploads();
                });    
            })
        },
        getTask(){
            $('.preloader').fadeIn('slow');
            axios.get('/task/'+this.task_id).then( data => {
                this.task = data.task;
                this.like_count = data.task.likes;
                this.user_like = data.task.user_like;
                $('.preloader').fadeOut('slow');
            });
        },
    
        showTask(parent_index){
            this.$emit('showSubtask', parent_index);
        },
        addSubTask(index){
            axios.post('/task/store', {
                parent_id: this.task.id,
                project_id: this.task.project_id,
                add_to: index
            }).then(data => {
                this.input_changed = true;
                if (index === 'prepend') {
                    this.task.tasks.unshift(data.data);
                } else if (index === 'append') {
                    this.task.tasks.push(data.data);
                } else {
                    this.task.tasks.splice(index, 0,data.data);
                }
                let task_id = data.data.id;
                let ref = 'sub_task_group_' + task_id;
                this.$nextTick(() => {
                    this.$refs[ref][0].focus_inputField();

                });
            });
        },
        deleteSubTask: function (task_index, previous) {
            this.task.tasks.splice(task_index, 1);
            if (previous) {
                this.previousTask(task_index - 1);
            }
        },
        previousTask(task_index) {
            let task = this.task.tasks[task_index];
            if (typeof (task) != 'undefined') {
                let task_id = task.id;
                let ref = 'sub_task_group_' + task_id;
                this.$nextTick(() => {
                    this.$refs[ref][0].focus_inputField();
                });

            } else {
                if (task_index <= -1) {
                    return ;
                }
                return this.previousTask(section_index, task_index);
            }

        },
        addTag() {
            let components = this.$refs.project_field_details;
            $.each(components, function (i, v) {
                v.focusTag();
            })
            // this.$refs.project_field_details.focusTag();
        },
        taskDetailsClosed: function () {
            this.$emit('taskDetailsClosed');
        },
        
        submitTaskName: function () {
            if (this.input_changed) {
                axios.post('/task/update_name', {
                    task_id: this.task.id,
                    name: this.task.name
                }).then(data => {

                });
                this.input_changed = false;
            }
        },
        completeMarkTask() {
            this.task.completed = 1
            let task_id = this.task.id;
            axios.post("/task-complete",{
                task_id,
                value : 1
            }).then(res => {
                this.task = res;
            })
        },
        incompleteMarkTask() {
            this.task.completed = 0;
            let task_id = this.task.id;
            axios.post("/task-complete",{
                task_id,
                value : 0
            }).then(res => {
                this.task = res;
            })
        },
        ucWord(text) {
            return helper.ucword(text);
        },
        userPhoto(user) {
            if(user){
                return helper.getUserProfilePhoto(user);
            }
            
        },
        timeAgo(time) {
            return helper.formatDateTimeFromNow(time);
        },
        formatDateTime(datetime) {
            return helper.formatDateTime(datetime);
        },
        taskDelete() {
            this.taskDetailsClosed();
            this.$emit('deleteTask');
            axios.post('/task-delete', {
                task_id: this.task.id
            })
            .then(data => {

            });
        },
        likeTask(value = 0){
            axios.post('/task-like', {
                task_id: this.task.id,
                value: value
            }).then(data => {
                this.like_count = data.count;
                this.user_like = data.user_like;
            });
        },
        submitComment(){
            axios.post('/task-comment', {
                task_id: this.task.id,
                comment: this.taskForm.description
            }).then( data => {
                this.task.comments.push(data.data);
                this.$emit('updateField', 'comments', this.task.comments);
                this.submit_show = 0;
                this.taskForm.description = '';
                let ref = 'html_editor_'+this.task.id;
                this.$nextTick(() => {
                    this.$refs[ref].destroyEditor();
                });
            });
        },
        submitButton(val){
            if(!val){
                if(!this.taskForm.description){
                    this.submit_show = 0;
                }
            }else{
                this.submit_show = 1;
            }
        },
        handleTaskChange() {
            let tasks = this.getTaskIds();
            this.$emit('updateField', 'tasks', this.task.tasks);
            axios.post('/set_sub_tasks', {
                tasks: tasks,
                task_id : this.task.id
            }).then(data => {
                //
            });
        },
        getTaskIds() {
            let ids = [];
            $.each(this.task.tasks, function (i, task) { 
               ids[i] = task.id
            })
            return ids;
        },
    },
}

</script>
