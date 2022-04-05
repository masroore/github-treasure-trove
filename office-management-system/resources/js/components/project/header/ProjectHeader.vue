<template>
<div>
    <div class="pm_project__icon">
        <button class="cursor_pointer" @click.prevent="color_dropdown_open = !color_dropdown_open" :style="{ background: '#'+ project_configuration.color }">
            <i :class="[project_configuration.icon]"></i>
        </button>
        <project-header-icon-color :project_configuration="project_configuration"  :project_id="project.id" @configurationUpdated="updateConfiguration" :open="color_dropdown_open" @closeDropdown="dropdownClose"/>
    </div>
    <div class="pm_project__title">
        <!-- pm_project_title_top  -->
        <div class="pm_project_title_top">
            <h3>{{ project.name ? project.name.length >= 33 ? project.name.substring(0,33)+"..." : project.name : ''}} </h3>
            <div class="btn-group square_arrow_down_btn ">
                <button type="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                    <i class="ti-angle-down"></i>
                </button>
                <div class="dropdown-menu pm_dropdown_menu dropdown-menu-right mt-0 minWidth_185 multy_dropdown">
                    <span @click="project_edit_modal = true" class="dropdown-item"> <i class="ti-info-alt mr-1"></i> {{ trans('project::project.edit_project_details') }}</span>
                    <input type="hidden" ref="hidden_link">
                    <span class="dropdown-item" @click="saveLayout(blade)" v-if="blade != 'fiels' || blade != 'conversation'"> <i class="fa fa-check-circle mr-1"></i> {{ trans('project::project.save_layout_as_default') }}</span>

                    <li><span class="dropdown-item justify-content-between pr-3" >{{ trans('project::project.set_icon_and_color') }} <i class="ti-angle-right"></i> </span>
                        <ul class="pm_project__icon " >
                            <li>
                                <project-header-icon-color :project_configuration="project_configuration"  :project_id="project.id" :open="true" @configurationUpdated="updateConfiguration"/>
                            </li>
                        </ul>
                    </li>

                    <span @click="copyProjectLink" class="dropdown-item">{{ trans('project::project.copy_project_link') }}</span>
                    <span @click="project_delete_modal = true" class="dropdown-item">{{ trans('common.Delete') }} </span>

                </div>

            </div>
            <div class="pm_title_details" @click="project_edit_modal = true">
                <i class="ti-info-alt"></i>
            </div>
            <div class="project_rating">
                <i class="fas fa-star" :style="{color: '#'+project_configuration.color}" @click="removeFavorite" v-if="project_configuration.favourite == 1"></i>
                <i class="far fa-star" @click="markFavorite" v-else></i>

            </div>
        </div>
        <!-- tab navigation  -->
        <div class="pm_tab_navBar">

            <ul class="nav" >
                <li class="nav-item">
                    <a :class="{'active' : blade == ''}" :href="project_url+'/project/'+project.uuid+'/list'" >{{ trans('project::project.list') }}</a>
                </li>
                <li class="nav-item">
                   <a :class="{'active' : blade == 'board'}" :href="project_url+'/project/'+project.uuid+'/board'" >{{ trans('project::project.board') }}</a>
                </li>

                <li class="nav-item">
                    <a :class="{'active' : blade == 'files'}" :href="project_url+'/project/'+project.uuid+'/files'" >{{ trans('project::project.files') }}</a>
                </li>
                 <li class="nav-item">
                    <a :class="{'active' : blade == 'conversation'}" :href="project_url+'/project/'+project.uuid+'/conversation'" >{{ trans('project::project.conversation') }}</a>
                </li>

            </ul>
        </div>
    </div>

    <div class="pm_share__project">
        <div data-toggle="modal" type="button" data-target="#share_project"
             class="project_owner_head mr_10 cursor_pointer avater_group">
                <div class="thumb thumb_24" v-for="(user, user_index) in project.users" v-bind:key="user_index + 1">
                    <img :src="user.avatar" :alt="user.name">
                </div>
        </div>
        <div type="button" class="pm_share_btn cursor_pointer" v-on:click="share_modal=true">
            <i class="fas fa-user-friends"></i> {{ trans('project::project.share') }}
        </div>
    </div>
    <project-header-share-modal :project="project" :share_modal="share_modal" @modalClosed="closeModal" @projectUpdated="updateProject"/>

    <project-details-modal :project="project" :teamUser="project.users" :project_edit_modal="project_edit_modal" @modalClosed="closeModal"/>

    <project-delete-modal :project="project"  :project_delete_modal="project_delete_modal" @modalClosed="closeModal"/>
</div>
</template>

<script>
import ProjectHeaderIconColor from './ProjectHeaderIconColor'
import ProjectHeaderShareModal from './ProjectHeaderShareModal'
import ProjectDetailsModal from './ProjectDetailsModal'
import ProjectDeleteModal from './ProjectDeleteModal'
export default {
    name: "project-header",
    props: {
        project_id : {
            type:  String
        },
        blade:{
            type: String
        }
    },
    components:{
        ProjectHeaderIconColor, ProjectHeaderShareModal, ProjectDetailsModal, ProjectDeleteModal
    },
    data() {
        return {
            project : {},
            project_configuration : {},
            color_dropdown_open: false,
            share_modal:false,
            project_url : PROJECT_URL,
            project_edit_modal: false,
            project_delete_modal : false
        }
    },
    mounted() {
        this.getProjectDetails();

    },
    methods: {
        copyProjectLink(){
            const el = document.createElement('textarea');
            el.value = window.location.href;
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            const selected =  document.getSelection().rangeCount > 0  ? document.getSelection().getRangeAt(0) : false;
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            if (selected) {
                document.getSelection().removeAllRanges();
                document.getSelection().addRange(selected);
            }
            toastr.success('Project link successfull copy to clipboard', 'Copied');
        },
         saveLayout(default_view = 'list'){
            if(!default_view){
                default_view = 'list';
            }
            console.log(default_view)
            axios.post('/project-default-view', {
                project_id: this.project.id,
                view: default_view
            });
        },
        updateProject(data){
            this.project = data;
        },
        getProjectDetails : function() {
            axios.post('/projects', {
                project_id:this.project_id
            }).then(data => {
                this.project = data.project;
                this.project_configuration = data.project_configuration;
            });
        },
        markFavorite(){
             axios.post('/update-project-favorite',{
                project_id : this.project.id,
                favorite : 1
            }).then(res => {
                this.project_configuration = res
            })
        },
        removeFavorite(){
             axios.post('/update-project-favorite',{
                project_id : this.project.id,
                favorite : 0
            }).then(res => {
                this.project_configuration = res
            })
        },
        updateConfiguration (project_configuration){
            this.project_configuration = project_configuration;
        },
        closeModal : function(){
            this.share_modal = false;
            this.project_edit_modal = false;
            this.project_delete_modal = false;
        },
        dropdownClose(){
            this.color_dropdown_open = false;
        }
    }
}
</script>
