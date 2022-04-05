<template>
<div>
    <div class="task_group_list details_subtask ">
        <div class="task_seperate_single_list d-flex bordered_header sortitem">
            <span class="sorthandle"> </span>
            <div class="separated_sticky_cell separated_sticky_cell_details">
                <span class="task_number">{{ task_index+1 }}</span>
                <div class="complete_mark ml-3 mr-1">
                <i class="far fa-check-circle"  @click="completeMarkTask()" v-if="!task.completed"></i>
                <i class="fas fa-circle"  @click="incompleteMarkTask()" v-else></i>
            </div>
            <label class="task_name mb-0" for="#">
                <input class="task_textarea" v-on:keyup="resizeInput($event)"
                        :ref="'task_'+task.id"
                        :style="{width: inputFieldWidth(task.name ? task.name.length : 0)}"
                        v-model="task.name"
                        v-on:blur="submitTaskName()"
                        v-on:keyup.enter="addTask()"
                        v-on:keyup.delete="checkDelete()"
                        >
            </label>
             <span class="chat_icon" v-if="task.comment_count">
                <i class="ti-comment"></i> {{ task.comment_count }}
            </span>
            <span class="chat_icon ml-1" v-if="task.likes.length">
                <i class="ti-thumb-up"></i> {{ task.likes.length }}
            </span>
            <span class="chat_icon ml-1" v-if="task.tasks.length">
                <i class="ti-layout-list-thumb"></i> {{ task.tasks.length }}
            </span>
                
            </div>
            <template v-for="(field, field_index) in task.fields">
                <project-section-details-sub-task-fields :field="field" :field_index="field_index" :task="task" :key="field_index+1" :project="project"/>
            </template>
            <div class="chat_icon" @click="openSubtaskDetails">
                <span class="ti-comment"></span>
            </div>
        </div>
    </div>
    
</div>

</template>

<script>
import draggable from 'vuedraggable'
import ProjectSectionTaskField from '../ProjectSectionTaskFields'
import ProjectSectionDetailsSubTaskFields from './ProjectSectionDetailsSubTaskFields'
export default {
    name: "project-section-task-details-sub-tasks",
    components : {
        draggable, ProjectSectionTaskField, ProjectSectionDetailsSubTaskFields
    },
    props: {
        task : {
            type : Object
        },
        task_index : {
            type: Number
        },
        auth_user : {
            type: Object
        },
        project :{
            type: Object
        },
        parent_index:{
            type: Array
        }
    },
    data() {
        return {
            input_changed : false,
            task_details: false,
            subtask_details : false,
            parent_push:  false,
        }
    },
    mounted() {
    $('.subtask_toggle').on('click', function(){
            $(this).find('i').toggleClass('fa-caret-right fa-caret-down');
        })
    },
    methods: {
        openSubtaskDetails(){
            if(!this.parent_push){
                this.parent_index.push(this.task_index);
                this.parent_push = true;
            }
            
            this.$emit('showTask', this.parent_index);
        },
        addTask(){
            this.$emit('taskAdded', this.task_index + 1);
        },
        submitTaskName() {
            
            if (typeof (this.task) != 'undefined' && !this.task.name) {
               this.checkDelete();
            }
            if (this.input_changed) {
               
                axios.post('/task/update_name', {
                    task_id: this.task.id,
                    name: this.task.name
                }).then (data => {
                    this.$emit('taskUpdated', this.task_index, data)
                });
                this.input_changed = false;
            }
        },
        checkDelete() {
            if (!this.task.name) {
                this.input_changed = false;
                this.$emit('subtaskDeleted', this.task_index, true)
                 axios.post('/task/update_name', {
                    task_id: this.task.id,
                    name: this.task.name
                }).then (data => {

                });
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
        closeSubTaskDetails:  function(){
            this.subtask_details = false;
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
                this.$emit('taskUpdated', this.task_index, res)
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
                this.$emit('taskUpdated', this.task_index, res)
            })
        },
        taskDelete(){
            this.$emit('subtaskDeleted', this.task_index, false)
        }
    },
}
</script>
