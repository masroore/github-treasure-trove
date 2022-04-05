<template>
    <div v-if="project_edit_modal">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-dialog modal_650px   modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ trans('project::project.project_details')}}</h4>
                            <button type="button" class="close " @click="$emit('modalClosed')">
                                <i class="ti-close "></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <!-- project member list  -->
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="project_name">{{trans('project::project.name')}}</label>
                                        <input class="primary_input_field" id="project_name" v-model="project.name" :placeholder="trans('project::project.name')" type="text" @blur="updateProject">
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="project_team">{{trans('project::project.team')}}</label>
                                         <input class="primary_input_field" id="project_team" v-model="project.team.name" :placeholder="trans('project::project.team')" type="text" disabled>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row no-gutters  align-items-center w-100">
                                        <div class="col-lg-6">
                                            <div class="single_modal_member_list pl-2 mb-25 mr-20  d-flex align-items-center justify-content-between">
                                                <div class="dropdown asign_box_dropdown">
                                                <button id="dLabel" class="dropdown-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <div class="assigned_member d-flex align-items-center">
                                                        <div class="asign_avater">
                                                            <img :src="project.owner.avatar" :alt="project.owner.name">
                                                        </div>
                                                        <span>{{ project.owner.name }}</span>
                                                    </div>
                                                </button>
                                                <ul class="dropdown-menu asign_dropdown_list dropdown-menu-right" aria-labelledby="dLabel">
                                                        <li data-toggle="modal" data-target="#invite_email">
                                                            <div class="single_asign_member d-flex">
                                                                <div class="height_light_text">
                                                                    <input type="text" @keyup="getCurrentTeamAllUser($event)">
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li v-for="user in teamUser" :key="'user_'+user.id" :style="{background: user.id == project.user_id ? '#e8ecee': ''}" @click="project.user_id = user.id">
                                                            <div class="single_asign_member d-flex">
                                                                <div class="asign_avater">
                                                                    <img :src="user.avatar"/>
                                                                </div>
                                                                <div class="asign_title">
                                                                    <span> {{ user.name}} </span>
                                                                </div>
                                                                <div class="asign_subtitle">
                                                                    <span> {{ user.email }} </span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="drag_date_box visible_date mb-25">
                                                <div class="no-gutters input-right-icon d-flex">
                                                    <button id="start-date-icon" class="" type="button">
                                                        <i class="ti-calendar"></i>
                                                    </button>
                                                    <div class="col">
                                                        <div class="">
                                                            <datepicker v-model="project.due_date" input-class="primary-input"></datepicker>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for=""> {{trans('common.Description')}}</label>
                                        <textarea @blur="updateProject" class="primary_textarea height_100px" :placeholder="trans('project::project.click_to_add_description')" v-model="project.description" ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
 import Datepicker from 'vuejs-datepicker';
export default {
    components:{
        Datepicker
    },
    props :{
        project : {
            type: Object
        },
        project_edit_modal:{
            type: Boolean
        },
        teamUser:{
            type: Array
        }
    },
    data() {
        return {
            tags: [] ,
            suggestedUser: [],
            tag: ''
        }
    },
    mounted() {
        
    },
    watch :{
        'project.due_date' : function(){
            this.updateProject();
        },
        'project.user_id' : function(){
            this.updateProject();
        }
    },
    name: "project-details-modal",
    methods: {
        updateProject : function(){
            axios.post('project-update', {
                project_id : this.project.id,
                due_date : this.project.due_date,
                description: this.project.description,
                user_id : this.project.user_id,
                name: this.project.name
            }).then(data => {
                this.project.user_id =  data.data.user_id;
                this.project.owner =  data.data.owner;
                this.project.users = data.data.users;
            })
        },
         getCurrentTeamAllUser(event) {
            let value = event.target.value;
            axios.get("/get-user-suggestion-priority",{
                params:{
                    team_id : this.project.team_id,
                    value: value
                }
            }).then(res => {
                this.teamUser = res;
            })
        },
        shareProject: function () {
            var url = "/share-project";
            axios.get(url, {params: {members: this.tags, project_id: this.project.id}}).then(data => {
                if (data.success) {
                    toastr.success(data.message, 'Success');
                    this.modalClosed();
                }
            })
        },
        removeUser: function (userId) {
            axios.post('/remove-user-form-project', {
                project_id: this.project.id,
                user_id: userId
            }).then (data => {
                toastr.success("User remove", 'Success');
            });
        },
        suggestMembers: function (e) {
            const val = e.target.value
            var url = "/get-user-suggestion-priority";
            axios.get(url, {params:{value: val, team_id: this.project.team_id}}).then (data => {
                this.suggestedUser = data
            })

        },
        addToTag: function (email) {
            if (this.tags.indexOf(email) == -1) {
                this.tags.push({ text: email })
            }
        },
        modalClosed : function(){
            this.$emit('modalClosed');
        }
    },

}
</script>
