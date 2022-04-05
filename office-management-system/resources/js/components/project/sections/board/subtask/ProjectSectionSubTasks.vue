<template>
    <div class="task_seperate_single_list d-flex bordered_header sortitem">
                <div class="separated_sticky_cell board_task_cell">
                    <span class="task_number">{{ (task_index+ 1) }}</span>
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
                        :focus="focus_task_id == task.id"
                        >
                    </label>
                </div>
                <template v-for="(field, field_index) in task.fields">
                    <project-section-sub-task-field :field="field" :field_index="field_index" :task="task" :key="field_index+1" :project="project" @updateTaskFieldValue="updateTaskFieldValue"/>
                </template>
                <div class="chat_icon" @click="$emit('showTask', task_index)">
                    <span class="ti-comment"></span>
                </div>
            </div>
</template>

<script>
import ProjectSectionSubTaskField from './ProjectSectionSubTaskFields'
export default {
    name: "project-section-tasks",
    components : {
        ProjectSectionSubTaskField
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
            console.log('task')
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
        taskDelete(){
            this.$emit('taskDeleted', this.section_index, this.task_index, false)
        }
    },
}
</script>