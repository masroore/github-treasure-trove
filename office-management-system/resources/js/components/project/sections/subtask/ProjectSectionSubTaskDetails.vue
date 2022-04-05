<template>
    <div class="project_slide_details project_slide_details_active" v-if="task_details">
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
                            <a href="#" @click.prevent="taskDelete" class="dropdown-item">{{ trans('project::project.delete_task') }}</a>
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
                               v-on:keyup="input_changed=true">
                    </div>
                    <div class="task_d_filed">
                        <template v-for="(field, field_index) in task.all_fields">
                            <project-section-task-details-fields :field="field" :project="project" :field_index="field_index" :task="task" :key="field_index+1" ref="project_field_details"/>
                        </template>
                    </div>

                    <div class="mt_30">
                        <project-section-task-details-sub-tasks
                            :task="subtask" 
                            :task_index="sub_task_index" @taskAdded="addSubTask"
                            @subtaskDeleted="deleteSubTask"
                            :ref="'sub_task_group_'+subtask.id"
                            :project="project"
                            :auth_user="auth_user"
                            v-for="(subtask, sub_task_index) in task.tasks"
                            v-bind:key="subtask.id" />
                    </div>
                    <div class="add_subtask mt_10" @click="addSubTask('append')">
                        <span class="primary-btn radius_30px  fix-gr-bg"> <i class="ti-plus"></i>{{ trans('project::project.add_task') }} </span>
                    </div>
                    <div class="project_d_thumbs mt_50">
                        <file-upload-input :button-text="'Upload document'" :token="taskForm.upload_token" module="task" :clear-file="clearAttachment" :module-id="task.id"></file-upload-input>
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
                                            {{ task.creator.name }}
                                        </a>
                                        <span>{{ trans('project::project.created_task') }} </span>
                                    </span>
                                    <span class="gray_text f_w_300"
                                          v-tooltip="formatDateTime(task.created_at)">{{ timeAgo(task.created_at) }}</span>
                                </div>
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
                                                    <span v-if="comment.new_id == auth_user.id">{{ trans('project::project.you') }}</span>
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
import ProjectSectionTaskDetailsFields from '../ProjectSectionTaskDetailsFields'
// import ProjectSectionTaskDetailsSubTasks from './ProjectSectionTaskDetailsSubTasks'

export default {
    name: "project-section-sub-task-details",
    components: {
        ProjectSectionTaskDetailsFields
    },
    props: {
        task: {
            type: Object
        },
        task_details: {
            type: Boolean
        },
        auth_user: {
            type: Object
        },
        project : {
            type: Object
        }
    },
    mounted() {
        axios.post('/task-chek-like', {
            task_id : this.task.id
        }).then( data => {
            this.like_count = data.count;
            this.user_like = data.user_like;
        });
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
            submit_show : 0
        }
    },
    methods: {
        addSubTask(index){
            axios.post('/task/store', {
                parent_id: this.task.id,
                project_id: this.task.project_id,
                add_to: index
            }).then(data => {
                this.input_changed = true;
                // this.task.tasks[index] = data;
                if (index === 'prepend') {
                    this.task.tasks.unshift(data);
                } else if (index === 'append') {
                    this.task.tasks.push(data);
                } else {
                    this.task.tasks.splice(index, 0,data);
                }
                let task_id = data.id;
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
            this.$emit('completeMarkTask');
        },
        incompleteMarkTask() {
            this.$emit('incompleteMarkTask');
        },
        ucWord(text) {
            return helper.ucword(text);
        },
        userPhoto(user) {
            return helper.getUserProfilePhoto(user);
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
                this.task.comments.push(data);
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
            
        }
    },
}

</script>
