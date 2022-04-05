<template>
    <div class="tab-content">
        <project-section-header :project="project" @projectUpdated="updateProject" @projectSorted="sortProject" @addSection="addSection" @addTask="addTask" @completeFilter="completeFilter" ref="project_section_header" :totalSection="sections.length"/>
        <div class="scrollable_list scrolled_width">
             <!-- order_page_topbar  -->
             <div class="shadow_whitebox" ></div>
        <div class="order_page_topbar">
            <div class="order_page_topbar_left d-flex bordered_header">
                <div class="task_headeing">
                    <span>#</span>
                    {{ trans('project::project.task_name') }}
                </div>
                <div class="btn-group square_arrow_down_btn">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ti-angle-down"></i>
                    </button>
                    <div class="dropdown-menu pm_dropdown_menu dropdown-menu-right mt-0">
                        <span @click="sortByField('Alphabetical', trans('project::project.alphabeticaly'))" class="dropdown-item">{{ trans('project::project.sort_alphabeticaly') }}</span>
                    </div>
                </div>
            </div>
            <div class="order_page_topbar_right">
                <div class="order_list">


                    <!-- single_order_list  -->
                    <div class="single_order_list" v-for="(field, field_index) in project.visible_fields"
                        :key="field_index" :class="{'maxWidth_200px' : field.type=='tags'}">
                        <span>{{ field.name }}</span>
                        <div class="btn-group square_arrow_down_btn ">
                            <button type="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="ti-angle-down"></i>
                            </button>
                            <div class="dropdown-menu pm_dropdown_menu dropdown-menu-right mt-0 minWidth_185 multy_dropdown multy_dropdown_left">
                                <span @click="sortByField(field.id, field.name)" class="dropdown-item">{{ trans('project::project.sort_by') }}</span>

                                <span @click="setFieldVisibility(field.id)" class="dropdown-item">{{ trans('project::project.hide_column') }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- single_order_list  -->


                    <!-- single_order_list  -->
                    <div class="single_order_list mini_width_icon p-0">
                        <div class="btn-group square_arrow_down_btn mini_width_icon ">
                            <button type="button" @click="addNewField">
                                <i class="ti-plus"></i>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>


         <draggable :list="sections" group="section" handle='.sorthandle' animation="200"
            @change="handleSectionChange()" :disabled="disabled">
            <transition-group>
                <div class="task_group_wrapper sortitem ml-1 pl-0 position-relative"
                    v-for="(section, section_index) in sections" :key="section.id">
                    <span class="sorthandle"> </span>
                    <div class="task_group_header d-flex align-items-center ">
                        <div class="toggle_button" @click="toggleTaskGroup(section.id)">
                            <i class="fas fa-caret-down" :id="'section_toggle_icon_'+section.id"></i>
                        </div>
                        <div class="task_group_title d-flex align-items-center">
                            <h4 class="f_s_16 f_w_400 mb-0 mr-3 ml-3" v-text="section.name"
                                @click="editSection(section.id)" v-if="edited_section_id != section.id"></h4>

                            <h4 class="f_s_16 f_w_400 mb-0 mr-3 ml-3" v-else>
                                <input type="text" v-model="section.name" class="form-control"
                                    v-on:blur="submitSectionName(section_index)" :ref="'section_'+section.id"
                                    v-on:keyup="resizeSectionInput($event)"
                                    :style="{width: sectionFieldWidth(section.name.length)}"
                                    v-on:keyup.enter="addTask(section_index, 'prepend')"">
                            </h4>

                            <div class="create_list mr-2" @click="addTask(section_index, 'prepend')">
                                <i class="ti-plus"></i>
                            </div>
                            <div class="btn-group square_arrow_down_btn">
                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-more-alt"></i>
                                </button>
                                <div class="dropdown-menu pm_dropdown_menu mt-0">
                                    <span class="dropdown-item" @click="editSection(section.id)">{{ trans('project::section.rename') }} </span>
                                    <span @click="deleteSection(section_index)" class="dropdown-item">{{ trans('project::section.delete') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="task_group_list " :id="'section_group_list_'+section.id">
                        <draggable :list="section.tasks" v group="section_tasks" :handle="'.sorthandle'" animation="200" :disabled="disabled"
                            @change="handleTaskChange()">
                            <transition-group >
                                <project-section-tasks :task="task" :section_index="section_index"
                                    :task_index="task_index"
                                    @taskDeleted="deleteTask"
                                    v-for="(task, task_index) in section.tasks" :key="task.id"
                                    @showTask="taskShow"
                                    :focus_task_id="focus_task_id" :ref="'task_group_'+task.id" @taskAdded="addTask" :project="project" @taskUpdated="updateTask" :auth_user="auth_user" @updateTaskFieldValue="updateTaskFieldValue" />
                            </transition-group>
                        </draggable>
                    </div>
                    <div class="task_group_list add_task_sticky" v-if="section.tasks.length">
                        <!-- task_seperate_single_list  -->
                        <div class="task_seperate_single_list d-flex bordered_header sortitem"
                             @click="addTask(section_index, 'append')">
                            <i class="ti-plus pl_32"></i>
                            <label class="task_name mb-0"> Add Task </label>
                        </div>
                    </div>

                </div>
            </transition-group>
        </draggable>

         <div class="add_section_button ">
            <span class="create_task_wrap"  @click="addSection()"> <i class="ti-plus"></i> {{ trans('project::section.add') }}</span>
        </div>

        </div>


        <div v-if="delete_section_modal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">
                                        {{ trans('project::section.confirm_delete_msg') }}
                                    </h4>
                                    <button type="button" class="close " @click="closeSectionDeleteModal()">
                                        <i class="ti-close "></i>
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <h3 class="mb-4"> {{ trans('project::section.section_info', {'section_name' : delete_section.name, 'task' : delete_section.tasks ? delete_section.tasks.length : 0}) }} </h3>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="primary_input mb-25">
                                                <ul class="permission_list mb-35">
                                                    <li>
                                                        <label class="primary_checkbox d-flex " @click="delete_task=false">
                                                            <input type="radio" @click="delete_task=true"
                                                                :checked="!delete_task">
                                                            <span class="checkmark mr-12"></span>
                                                            <p> {{ trans('project::section.keep_task', {'task' : delete_section.tasks
                                                                ? delete_section.tasks.length : 0}) }} </p>
                                                        </label>
                                                        <p></p>
                                                    </li>
                                                    <li>
                                                        <label class="primary_checkbox d-flex mr-12 "
                                                            @click="delete_task=true">
                                                            <input type="radio" :checked="delete_task">
                                                            <span class="checkmark mr-12"></span>
                                                            <p>
                                                                {{ trans('project::section.delete_task', {'task' : delete_section.tasks
                                                                ? delete_section.tasks.length : 0}) }}
                                                            </p>
                                                        </label>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 text-center">
                                            <div class="d-flex justify-content-center pt_20">
                                                <button type="submit" class="primary-btn semi_large2 fix-gr-bg"
                                                        @click="submitSectionDelete()"><i class="ti-check"></i>{{ trans('project::project.save') }}
                                                </button>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <project-section-task-details :task_id="details_task" v-if="task_details" @taskDetailsClosed="closeTaskDetails" :project="project" :auth_user="auth_user" @showSubtask="subtaskShow" @updateTaskFieldValue="updateTaskFieldValue" :parent_index="show_task_parent" ref="project_details" @updateField="updateField"/>

    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import ProjectSectionTasks from './ProjectSectionTasks'
    import projectSectionHeader from './ProjectSectionHeader'
    import ProjectSectionTaskDetails from './ProjectSectionTaskDetails'
    export default {
        name: "project-sections",
        components: {
            draggable,
            ProjectSectionTasks,
            projectSectionHeader,
            ProjectSectionTaskDetails
        },
        props: [
            'project_id'
        ],
        data() {
            return {
                sections: [],
                edited_section_id: '',
                input_changed: false,
                focus_task_id: 0,
                project: {},
                disabled: false,
                auth_user: {},
                details_task : '',
                task_details: false,
                show_section_index: '',
                show_task_parent : [],
                show_task_index : '',
                parent_index : [0,0,0],
                task_index : '',
                delete_section_modal:false,
                delete_task: false,
                filter: {
                    completed: 2,
                    field_id : '',
                    completed_at: ''
                },
            }
        },
        mounted() {
                $(".scrollable_list").on("scroll", function () {
                    var cur = $(this).scrollLeft();
                    if (cur == 0) {
                        $(this).removeClass('sticky_active');
                    }
                    else {
                        $(this).addClass('sticky_active');
                    }
                });
                $(".scrollable_list").trigger("scroll");
            this.getSections();
            // window.addEventListener('scroll', this.updateScroll);

        },
        watch:{
            'filter.completed': function () {
                this.getSections();
            },
            'filter.field_id': function () {
                this.getSections();
            },
            'filter.completed_at': function () {
                this.getSections();
            }
        },

        methods: {
            addNewField(){
                this.$nextTick(() => {
                    this.$refs.project_section_header.showNewFieldModal();
                });
            },
            setFieldVisibility(field_id){
                this.$nextTick(() => {
                    this.$refs.project_section_header.setFieldVisibility(field_id);
                });
            },
            sortByField(field_id, field_name){
                this.$nextTick(() => {
                    this.$refs.project_section_header. sortByField(field_id, field_name);
                });
            },
            updateTaskFieldValue(data){
                this.sections[this.show_section_index] = data.data;
            },
            updateField(field, value){
                var oldTaskCode = "this.sections["+this.show_section_index+"]";
                $.each(this.show_task_parent, function(i, v){
                    oldTaskCode += "['tasks']["+v+"]";
                });
                var oldObject = eval(oldTaskCode);
                oldObject[field] = value;
            },
            sectionLoop(){
                var task = this.sections[this.show_section_index];
                $.each(this.show_task_parent, function(i, v){
                    task = task.tasks[v];
                })
                this.details_task =  task.uuid;
            },
            subtaskShow(parent_index){
                this.closeTaskDetails();
                this.taskShow(parent_index, this.show_section_index);

            },
            taskShow(parent_index, section_index){

                this.show_task_parent = parent_index;
                this.show_section_index = section_index;
                // var vm = this;
                this.sectionLoop();
                this.task_details = true
                this.$nextTick(() => {
                    this.$refs.project_details.getTask();
                });


            },
            closeTaskDetails(){
                this.task_details = false;
                this.details_task = '';
            },
            getSections: function () {
                $('.preloader').fadeIn('slow');
                axios.post('/sections', {
                    project_id: this.project_id,
                    field_id : this.filter.field_id,
                    completed: this.filter.completed,
                    completed_at : this.filter.completed_at
                })
                .then(response => {
                    this.sections = response.sections;
                    this.project = response.project;
                    this.auth_user = response.auth_user;
                    $('.preloader').fadeOut('slow');
                });
            },
            addSection() {
                axios.post('/section/store', {
                        project_id: this.project.id,
                        add_to: this.sections.length
                    })
                    .then(data => {
                        this.input_changed = true;
                        this.sections.push(data);
                        this.editSection(data.id)
                    });
            },
            sectionFieldWidth: function (length) {
                if (18 > length) {
                    length = 18;
                } else if (length > 50) {
                    length = 50;
                }
                return length * 12 + "px";
            },
            editSection(section_id) {
                this.edited_section_id = section_id
                var ref = 'section_' + section_id;
                this.$nextTick(() => {
                    this.$refs[ref][0].focus()
                });
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
            submitSectionName: function (section_index) {
                this.edited_section_id = '';
                if (this.input_changed) {
                    let section = this.sections[section_index];
                    if (!section.name) {
                        this.sectionDeleteonBackspace(section_index)
                    }
                    axios.post('/section/update_name', {
                        section_id: section.id,
                        name: section.name
                    }).then(data => {
                        //
                    });
                    this.input_changed = false;
                }
            },
            deleteTask: function (section_index, task_index, previous) {
                this.sections[section_index].tasks.splice(task_index, 1);
                if (previous) {
                    this.previousTask(section_index, task_index - 1);
                }

            },

            previousTask(section_index, task_index) {
                let section = this.sections[section_index]
                if (typeof (section) != 'undefined') {
                    let task = section.tasks[task_index];
                    if (typeof (task) != 'undefined') {
                        let task_id = task.id;
                        let ref = 'task_group_' + task_id;
                        this.$nextTick(() => {
                            this.$refs[ref][0].focus_inputField();
                        });

                    } else {
                        if (task_index <= -1) {
                            section_index = section_index - 1;
                            if (section_index === -1) {
                                return;
                            }
                            task_index = this.sections[section_index].tasks.length - 1;
                        }
                        return this.previousTask(section_index, task_index);
                    }
                }
            },

            addTask(section_index, add_to = 'append') {

                let section = this.sections[section_index];
                axios.post('/task/store', {
                    section_id: section.id,
                    project_id: section.project_id,
                    add_to: add_to
                }).then(data => {
                    this.input_changed = true;
                    if (add_to === 'prepend') {
                        section.tasks.unshift(data.data);
                    } else if (add_to === 'append') {
                        section.tasks.push(data.data);
                    } else {
                        section.tasks.splice(add_to, 0, data.data);
                    }
                    let task_id = data.data.id;
                    let ref = 'task_group_' + task_id;
                    this.$nextTick(() => {
                        this.$refs[ref][0].focus_inputField();
                        this.$refs[ref][0].changeInput(true);

                    });
                });
            },

            handleTaskChange() {
                let tasks = this.getTaskIds(this.sections);
                axios.post('/set_tasks', {
                    tasks: tasks
                }).then(data => {
                    //
                });
            },
            getTaskIds(sections) {
                let ids = [];
                $.each(sections, function (i, section) {
                    ids[section.id] = [];
                    $.each(section.tasks, function (j, task) {
                        ids[section.id][j] = task.id
                    })
                })
                return ids;
            },
            toggleTaskGroup(section_id) {
                let element = document.getElementById('section_group_list_' + section_id);
                let icon = document.getElementById('section_toggle_icon_' + section_id);
                if (element.classList.contains('task_group_wrapper_hide')) {
                    element.classList.remove("task_group_wrapper_hide");
                    icon.classList.remove("roted");
                    element.style.display = 'block'
                } else {
                    element.classList.add("task_group_wrapper_hide");
                    icon.classList.add("roted");
                    element.style.display = 'none'
                }
            },

            updateProject() {
                this.disabled = false;
                this.getSections();
            },
            submitSectionDelete() {
                let delete_section = this.delete_section;
                let delete_task = this.delete_task;
                this.closeSectionDeleteModal();
                axios.post('/section/delete', {
                    section_id: delete_section.id,
                    delete_task: delete_task
                }).then(data => {
                    toastr.success(data.message, i18n.common.success);
                    this.getSections();
                });
            },
            sectionDeleteonBackspace(section_index) {
                let section = this.sections[section_index];
                if (!section.name && !section.tasks.length) {
                    this.input_changed = false
                    this.delete_section = section;
                    this.submitSectionDelete();
                }
            },
            deleteSection(section_index) {
                this.delete_section = this.sections[section_index];
                if (this.delete_section.tasks.length) {
                    this.delete_section_modal = true;
                } else {
                    this.submitSectionDelete();
                }
            },
            closeSectionDeleteModal() {
                this.delete_section = {};
                this.delete_task = false;
                this.delete_section_modal = false;
            },
            sortProject(field_id){
                if(field_id){
                    this.disabled = true;
                } else{
                    this.disabled = false;
                }
                this.filter.field_id = field_id;
            },

            completeFilter(completed, completed_at){
                this.filter.completed = completed;
                this.filter.completed_at = completed_at;
            },
            updateTask(section_index, task_index, task){
                this.sections[section_index].tasks[task_index] = task;
            },
            handleSectionChange() {
                let ids = this.getSectionIds(this.sections);
                axios.post('/set_sections', {
                    sections: ids
                });
            },
            getSectionIds(sections) {
                let ids = {};
                ids = jQuery.map(sections, function (section) {
                    return section.id;
                })
                return ids;
            },
            resizeSectionInput: function (el) {
                if (!this.input_changed) {
                    this.input_changed = true;
                }
                let length = el.target.value.length;
                if (18 > length) {
                    length = 18;
                } else if (length > 50) {
                    length = 50;
                }
                el.target.style.width = this.sectionFieldWidth(length);
            },

        },
    }

</script>
