<template>
    <div v-if="share_modal">

        <transition name="modal">
            <div class="modal-mask">
                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{trans('project::project.Share')}} {{ project.name }}</h4>
                                <button type="button" class="close " @click="modalClosed">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body p-0">
                                <!-- modal_tab -->
                                <ul class="nav modal_common_tab p-0 mb_20" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                                           role="tab" aria-controls="home" aria-selected="true">{{ trans('project::project.invite_with_email') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content modal_tab_container" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                         aria-labelledby="home-tab">
                                        <div class="primary_vue_tag mb_20">

                                            <vue-tags-input
                                                v-model="tag"
                                                :tags="tags"
                                                @tags-changed="newTags => tags = newTags"
                                                ti-duplicate
                                                readonly
                                            />
                                        </div>

                                        <input class="primary_input_field" type="text" @keyup="suggestMembers" ref="suggested_user">

                                        <div class="mt-3" id="user-suggestion-list" v-if="suggestedUser">
                                            <ul class="asign_dropdown_list">
                                                <li v-for="user in suggestedUser" :key="user.id">
                                                    <div class="single_asign_member d-flex"
                                                         @click="addToTag(user.email)">
                                                        <div class="asign_avater">
                                                            <img :src="user.avatar" :alt="user.namne">
                                                        </div>
                                                        <div class="asign_title"><span> {{ user.name}} </span></div>
                                                        <div class="asign_subtitle"><span> {{ user.email }} </span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <button class="primary-btn radius_30px  fix-gr-bg mt-15 mb-15" v-if="tags.length" @click="shareProject">{{ trans('project::project.share_now') }}</button>
                                    </div>
                                </div>





                                <!-- project member list  -->
                                <div class="modal_member_list">
                                    <div
                                        class="modal_member_list_header d-flex align-items-center justify-content-between">
                                        <span class="f_s_16 f_w_400">{{ trans('project::project.project_members') }}</span>
                                        <a class="f_s_16 f_w_400 required_mark_theme" data-toggle="modal" type="button"
                                           data-target="#manage_notification" href="#">{{ trans('project::project.manage_notifications') }}</a>
                                    </div>


                                        <div
                                            class="single_modal_member_list  d-flex align-items-center justify-content-between" v-for="(user, user_index) in project.users" :key="user_index">


                                            <div class="member_modal_avater d-flex align-items-center">
                                                <div class="thumb thumb_32 mr-15">
                                                    <img :src="user.avatar" :alt="user.name">
                                                </div>
                                                <div class="modal_member_info">
                                                    <h3 class="f_s_13 f_w_400 mb-0 line_h_1">{{ user.name }}</h3>
                                                    <p class="f_s_11 f_w_400 line_h_1">{{ user.email }}</p>
                                                </div>
                                            </div>
                                            <div class="btn-group transparent_dropdown_btn">
                                                <button type="button" class="dropdown-toggle" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    <span v-if="project.user_id == user.id">{{trans('project::project.Owner')}}</span> <span v-else>{{trans('project::project.Member')}}</span> <i class="ti-angle-down minWidth_icon" v-if="project.user_id != user.id"></i>
                                                </button>
                                                <div class="dropdown-menu pm_mini_dropdown mt-0" v-if="project.user_id != user.id">
                                                    <a class="dropdown-item" @click="removeUser(user.id)">
                                                        {{ trans('project::project.remove_from_project')}} </a>
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
</template>

<script>
import VueTagsInput from '@johmun/vue-tags-input';
export default {
    components:{
        VueTagsInput
    },
    props :{
        project : {
            type: Object
        },
        share_modal:{
            type: Boolean
        }
    },
    data() {
        return {
            tags: [] ,
            suggestedUser: [],
            tag: ''
        }
    },
    name: "project-header-share-modal",
    methods: {
        shareProject: function () {
            $('.preloader').fadeIn('slow');
            var url = "/share-project";
            var user_emails = [];

             $.each(this.tags, function (i, v) {
                user_emails.push(v.text);
            })

            axios.get(
                url, {params: {members: user_emails, project_id: this.project.id}
                }).then(data => {
                if (data.success) {
                    this.$emit('projectUpdated', data.project);
                    $('.preloader').fadeOut('slow');
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
                this.suggestedUser = data.data
            })

        },
        addToTag: function (email) {
            if (this.tags.indexOf(email) == -1) {
                this.tags.push({ text: email });

                this.$nextTick(() => {
                    this.$refs.suggested_user.value = "";
                    this.$refs.suggested_user.focus();
                    this.suggestedUser = [];
                });
            }
        },
        modalClosed : function(){
            this.$emit('modalClosed');
        }
    },

}
</script>
