<template>
    <div class="tab-pane fade show active pl-0" id="list" role="tabpanel" aria-labelledby="list-tab">
        <!-- page_toolbar_wrapper  -->
        <div class="page_toolbar_wrapper d-flex ">
            <div class="left_toolbar">
                <div class="btn-group common_dropdown_1 ">
                    <button type="button" class="btn " @click="$emit('addTask', 0, 'prepend')" v-if="totalSection"><i class="ti-plus"></i> {{ trans('project::project.add_task') }}</button>

                    <button type="button" class="btn " @click="$emit('addSection')" v-else><i class="ti-plus"></i> {{ trans('project::project.add_section') }}</button>
                    
                    <button type="button" class="btn dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">{{ trans('project::project.add_task') }}</span>
                    </button>
                    <div class="dropdown-menu pm_mini_dropdown mt-0 ">
                        <span class="dropdown-item" @click="$emit('addSection')">{{ trans('project::project.add_section') }}</span>
                    </div>
                </div>
            </div>
            <div class="right_toolbar">
                <div class="btn-group normal_dropdown_btn">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-check-circle minWidth_icon"></i> {{ completed_name }}
                    </button>
                    <div class="dropdown-menu pm_mini_dropdown dropdown-menu-right  mt-0 multy_dropdown">
                        <span class="dropdown-item" @click="completeFilter('Incomplete tasks', 2, '')">  <i class="ti-check f_s_12 check_maRk" v-if="completed === 2"></i> {{ trans('project::project.incomplete_task') }}</span>
                        <span class="dropdown-item"  @click="completeFilter('Completed tasks', 1, '')">  <i class="ti-check f_s_12 check_maRk" v-if="completed === 1"></i> {{ trans('project::project.completed_task') }}</span>
                        <li><span class="dropdown-item justify-content-between pr-3" >
                            <i class="ti-check f_s_12 check_maRk" v-if="completed_at != ''"></i> {{ trans('project::project.complete_since') }}: <i class="ti-angle-right"></i> </span>
                            <ul>
                                <li><span class="dropdown-item" @click="completeFilter('Since: Today', '', 'today')"> <i class="ti-check f_s_12 check_maRk" v-if="completed_at == 'today'"></i>  {{ trans('project::project.today') }}</span></li>
                                <li><span class="dropdown-item" @click="completeFilter('Since: Yesterday', '', 'yesterday')"> <i class="ti-check f_s_12 check_maRk" v-if="completed_at == 'yesterday'"></i> {{ trans('project::project.yesterday') }}</span></li>
                                <li><span class="dropdown-item" @click="completeFilter(trans('project::project.since_week', {'week' : 1}), '', '1week')"> <i class="ti-check f_s_12 check_maRk" v-if="completed_at == '1week'"></i>{{ trans('project::project.week', {'week' : 1}) }}</span></li>

                                <li><span class="dropdown-item" @click="completeFilter(trans('project::project.since_week', {'week' : 2}), '', '2week')"> <i class="ti-check f_s_12 check_maRk" v-if="completed_at == '2week'"></i>{{ trans('project::project.week', {'week' : 2}) }}</span></li>

                                <li><span class="dropdown-item" @click="completeFilter(trans('project::project.since_week', {'week' : 3}) , '', '3week')"> <i class="ti-check f_s_12 check_maRk" v-if="completed_at == '3week'"></i>{{ trans('project::project.week', {'week' : 3}) }}</span></li>
                            </ul>
                        </li>
                        <a class="dropdown-item"  @click="completeFilter('All tasks', '', '')">
                             <i class="ti-check f_s_12 check_maRk" v-if="(completed === '' && completed_at=== '')"></i>{{ trans('project::project.all_tasks') }}</a>
                    </div>
                </div>
                <div class="btn-group normal_dropdown_btn">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-sort-amount-up minWidth_icon"></i> {{ trans('project::project.sort') }} {{ sort_name }}
                    </button>
                    <div class="dropdown-menu pm_mini_dropdown dropdown-menu-right  mt-0">
                        <span class="dropdown-item" @click="sortByField('', '')"><i class="fa fa-check mr-1" v-if="sort === ''"></i> {{ trans('project::project.none') }}</span>
                        <span class="dropdown-item" v-for="(field, field_index)  in project.fields" @click="sortByField(field.id, field.name)" :key="field_index">
                            <i class="fa fa-check mr-1" v-if="sort === field.id"></i>
                            {{ field.name }}
                        </span>
                        <span class="dropdown-item" @click="sortByField(trans('project::project.alphabeticaly'), 'Alphabetical')">
                            <i class="fa fa-check mr-1" v-if="sort === 'Alphabetical'"></i> {{ trans('project::project.alphabeticaly') }}
                        </span>
                    </div>
                </div>

                <div class="btn-group normal_dropdown_btn">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-check-circle minWidth_icon"></i> {{ trans('project::project.fields') }}
                    </button>
                    <div class="dropdown-menu pm_mini_dropdown dropdown-menu-right  mt-0">
                        <div class="dropdown-item justify-content-between pr-3" v-for="(field, field_index) in project.fields" :key="field_index">
                            {{field.name}}
                            <i class="fa fa-pencil-alt" v-if="!field.default" @click="editField(field.id)"></i>
                            <label class="switch_toggle" for="checkbox"  @click="setFieldVisibility(field.id)">
                                <input type="checkbox" v-model="field.pivot.visibility" :checked="field.pivot.visibility">
                                <div class="slider round"></div>
                            </label>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item mb-1" @click="add_new_field_modal=true">
                            <i class="fas fa-plus filter_icon mr-1 "></i>{{ trans('project::project.add_new_field') }}
                        </div>
                    </div>
                </div>
                <div class="btn-group normal_dropdown_btn">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-h minWidth_icon"></i>
                    </button>
                    <div class="dropdown-menu pm_mini_dropdown dropdown-menu-right  mt-0">
                        <span class="dropdown-item" @click="saveLayout('list')">{{ trans('project::project.save_layout') }}</span>
                    </div>
                </div>
            </div>
        </div>
 <add-new-field-modal :add_new_field_modal="add_new_field_modal" :project="project"  @modalClosed="closeModal" @newFieldAdded="addNewField" :field_id="edit_field_id" v-if="add_new_field_modal"/>
       
    </div>

</template>

<script>
import AddNewFieldModal from './AddNewFieldModal'
export default {
    name: "project_section_header",
    components : {
        AddNewFieldModal
    },
    props : {
        project : {
            type: Object
        },
        totalSection : {
            type : Number
        }
    },
    data(){
        return {
            add_new_field_modal: false,
            sort : '',
            sort_name : '',
            task: '',
            completed_name: 'Incomplete tasks',
            completed: 2,
            completed_at: '',
            edit_field_id: ''
        }
    },

    methods: {
        saveLayout(default_view = 'list'){
            axios.post('/project-default-view', {
                project_id: this.project.id,
                view: default_view
            });
        },
        completeFilter(completed_name, completed, completed_at){
            this.completed_name = completed_name;
            this.completed = completed;
            this.completed_at = completed_at;
            this.$emit('completeFilter', completed, completed_at)
        },

        sortByField(field_id, field_name) {
            if (field_id == this.sort) {
                this.sort = '';
                this.sort_name = '';
            } else{
                this.sort = field_id;
                 if (field_id === '') {
                    this.sort_name = '';
                }
                this.sort_name = ': ' + field_name;
            }

             this.$emit('projectSorted', field_id);
        },
        setFieldVisibility(field_id) {
            axios.post('/project/setFieldVisibility', {
                project_id: this.project.id,
                field_id: field_id
            }).then(data => {
                this.$emit('projectUpdated');
            });
        },

        closeModal : function(){
            this.add_new_field_modal = false;
            this.edit_field_id = '';
        },
        addNewField(){
            this.$emit('projectUpdated',)
        },
        editField(field_id){
            this.edit_field_id = field_id;
            this.add_new_field_modal = true;
        },
        showNewFieldModal(){
            this.add_new_field_modal = true;
        }
    },
}
</script>
