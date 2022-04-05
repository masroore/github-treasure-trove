<template>
    <div class="board_item">
        <div class="board_details_poup" @click="$emit('showTask', [task_index], section_index)"></div>
        <div class="board_name d-flex align-items-center justify-content-between">
            <h4> <label class="task_name mb-0" for="#">
                <input class="task_textarea" v-on:keyup="resizeInput($event)"
                        :ref="'task_'+task.id"
                        :style="{width: inputFieldWidth(task.name ? task.name.length : 0)}"
                        v-model="task.name"
                        v-on:blur="submitTaskName()"
                        v-on:keyup.enter="addTask()"
                        v-on:keyup.delete="checkDelete()"
                        :focus="focus_task_id == task.id"
                        >
            </label></h4>
            <div class="btn-group normal_dropdown_btn">
                <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-h minWidth_icon"></i>
                </button>
                <div class="dropdown-menu pm_mini_dropdown dropdown-menu-right  mt-0">
                    <a class="dropdown-item" @click.prevent="completeMarkTask" v-if="!task.completed">{{ trans('project::project.mark_conplete') }}</a>
                    <a class="dropdown-item" @click.prevent="completeMarkTask" v-else>{{ trans('project::project.mark_inconplete') }}</a>
                    <a class="dropdown-item" @click.prevent="taskDelete">{{trans('common.Delete')}}</a>
                </div>
            </div>
        </div>
        <div class="board_body d-flex">
            <div class="board_body_left d-flex">
                 <template v-for="(field, field_index) in task.fields">
                    <project-section-task-fields :field="field" :field_index="field_index" :task="task" :key="field_index+1" :project="project"/>
                </template>
               
            </div>
            <div class="board_body_right text-right">
                <div class="like_subtask_group">
                    <span class="subtask_icon " v-if="task.likes">
                        <i class="ti-thumb-up"></i> {{ task.likes }}
                    </span> 
                    <span class="subtask_icon " v-if="task.tasks.length">
                        <i class="ti-layout-list-thumb"></i> {{ task.tasks.length }}
                        <button class="subtask_toggle" type="button" data-toggle="collapse" :data-target="'#subtasklist_'+task.id" aria-expanded="false" :aria-controls="'subtasklist_'+task.id">
                        <i class="fas fa-caret-right"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="collapse board_subtask task_group_list " :id="'subtasklist_'+task.id">

            <project-section-sub-tasks
            :task="subtask" :section_index="section_index"
            :task_index="sub_task_index" @taskAdded="addSubTask"
            @subtaskDeleted="deleteSubTask"
            :focus_task_id="focus_task_id"
            :ref="'sub_task_group_'+subtask.id"
            :project="project"
            :auth_user="auth_user"
            v-for="(subtask, sub_task_index) in task.tasks"
            v-bind:key="subtask.id"
            @showTask="taskShow" @updateTaskFieldValue="updateTaskFieldValue"
        />
            
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import ProjectSectionTaskFields from './ProjectSectionTaskFields'
import ProjectSectionSubTasks from './subtask/ProjectSectionSubTasks'
export default {
    name: "project-section-tasks",
    components : {
        draggable, ProjectSectionTaskFields, ProjectSectionSubTasks
    },
    props: {
        "task" : {
            type : Object
        },
        "section_index" : {
            type: Number
        },
        "task_index" : {
            type: Number
        },
        "focus_task_id" : {
            type: Number
        },
        project:{
            type: Object
        },
        auth_user : {
            type: Object
        }
    },
    data() {
        return {
            input_changed : false,
            task_details: false
        }
    },
    mounted() {

    $('.subtask_toggle').on('click', function(){
            $(this).find('i').toggleClass('fa-caret-right fa-caret-down');
        })
    },

    methods: {
        updateTaskFieldValue(data){
            this.$emit('updateTaskFieldValue', data);
        },
        taskShow(task_index){
            this.$emit('showTask', [this.task_index, task_index], this.section_index);
        },
        addTask(){
            this.$emit('taskAdded', this.section_index, this.task_index + 1);
        },
        addSubTask(index){
                axios.post('/task/store', {
                    parent_id: this.task.id,
                    project_id: this.task.project_id,
                    add_to: index
                }).then(data => {
                    this.input_changed = true;
                    // this.task.tasks[index] = data;
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
        submitTaskName() {
            if (this.input_changed) {
                if (typeof (this.task) != 'undefined' && !this.task.name) {
                   this.$emit('taskDeleted', this.section_index, this.task_index, false)
                }
                axios.post('/task/update_name', {
                    task_id: this.task.id,
                    name: this.task.name
                }).then (data => {
                    this.$emit('taskUpdated', this.section_index, this.task_index, data)
                });
                this.input_changed = false;
            }
        },
        taskDelete() {
            console.log('delete');
            axios.post('/task-delete', {
                task_id: this.task.id
            })
            .then(data => {

            });
            this.$emit('taskDeleted', this.section_index, this.task_index, false)
            
        },
        checkDelete() {
            if (!this.task.name) {
                this.input_changed = false;
                this.$emit('taskDeleted', this.section_index, this.task_index, true)
                 axios.post('/task/update_name', {
                    task_id: this.task.id,
                    name: this.task.name
                }).then (data => {

                });
            }
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
                    return this.focus_inputField();
                }
                return this.previousTask(section_index, task_index);
            }

        },

        resizeInput: function (el) {
            if (!this.input_changed) {
                this.input_changed = true;
            }
            let length = el.target.value.length;
            if (18 > length) {
                length = 18;
            } else if (length > 50) {
                length = 50;
            }
            el.target.style.width = this.inputFieldWidth(length);
        },
        inputFieldWidth: function (length) {
            if (18 > length) {
                length = 18;
            } else if (length > 50) {
                length = 50;
            }
            return length * 8 + "px";
        },
        focus_inputField: function (){
            let ref = 'task_'+this.task.id;
            this.$nextTick(() => {
                this.$refs[ref].focus();
            });
        },
        closeTaskDetails : function(){
            this.task_details = false;
        },
        completeMarkTask(){
            this.task.completed = 1
            let task_id = this.task.id;
            axios.post("/task-complete",{
                task_id,
                value : 1
            }).then(res => {
                this.task.completed_at = res.completed_at;
                this.task.complete = res.complete;
                this.$emit('taskUpdated', this.section_index, this.task_index, res)
            })
        },
        incompleteMarkTask(){
            this.task.completed = 0;
            let task_id = this.task.id;
            axios.post("/task-complete",{
                task_id,
                value : 0
            }).then(res => {
                this.task.incompleted_at = res.incompleted_at;
                this.task.incomplete = res.incomplete;
                this.$emit('taskUpdated', this.section_index, this.task_index, res)
            })
        },
        // taskDelete(){
        //     this.$emit('taskDeleted', this.section_index, this.task_index, false)
        // }
    },
}
</script>
