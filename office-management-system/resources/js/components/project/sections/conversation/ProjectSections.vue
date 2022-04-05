<template>
  <div class="tab-pane fade gray_content  active show" >
      <div class="conversion_wrapper">
          <div class="conversion_wrapper_inner">
             <!-- conversion_sender_wrap  -->
              <div class="conversion_sender_wrap mb_15">
                  <div class="conversion_descreption_text">
                       <html-editor name="description" :model.sync="comment" height="120" :ref="'html_editor'"></html-editor>
                  </div>
                  <div class="conversion_sender_footer mt-1">
                      <div class="conversion_sender_footer_left">

                      </div>
                      <div class="conversion_sender_footer_right">
                          <button class="primary-btn  fix-gr-bg" type="submit" @click="submitComment"> {{trans('project::project.post')}} </button>
                      </div>
                  </div>
              </div>

              <!-- conversion_msg_wrapper  -->
              <div class="conversion_msg_wrapper mb_15" v-for="(comment, index) in project.comments" v-bind:key="index + 1">
                <!-- conversion_msg_contents  -->
                  <div class="conversion_msg_contents">
                      <div class="conversion_msg_inner">
                        <!-- conversion_msg_contents_hader  -->
                          <div class="conversion_msg_contents_hader d-flex justify-content-between " >
                              <div class="title_conv">
                                   <div class="conversion_msg_contents_subhader mb_10 d-flex align-items-center">
                                        <div class="thumb thumb_32 mr-10">
                                            <img :src="comment.user.avatar" :alt="comment.user.name">
                                        </div>
                                        <p>{{ comment.user.name }} <span>{{ comment.user.created_at }}</span> </p>
                                    </div>
                              </div>
                              <div class="title_conv_tool d-flex align-items-center">

                                    <div class="btn-group square_arrow_down_btn square_btn_32px ">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h  f_s_16"></i>
                                        </button>
                                        <div class="dropdown-menu pm_dropdown_menu dropdown-menu-right mt-0 minWidth_185 multy_dropdown multy_dropdown_left">
                                            <span @click="editComment(comment.id)" class="dropdown-item">{{ trans('project::project.edit_comment')}}</span>
                                            <span @click="deleteComment(comment.id)" class="dropdown-item">{{ trans('project::project.delete_comment') }}</span>
                                        </div>
                                    </div>
                              </div>
                          </div>

                          <div class="conversion_msg_text">
                              <p v-html=" comment.comment" v-if="edit_comment_id != comment.id"> </p>
                               <div v-if="edit_comment_id == comment.id">
<div class="conversion_descreption_text" >
                                    <html-editor name="description" :model.sync="comment.comment" height="120" :ref="'edit_html_editor_'+comment.id"></html-editor>
                                </div>
                                <div class="conversion_sender_footer mt-1">
                                    <div class="conversion_sender_footer_left">

                                    </div>
                                    <div class="conversion_sender_footer_right">
                                        <button class="primary-btn  fix-gr-bg" type="submit" @click="submitEditComment(index)"> {{trans('project::project.Update')}} </button>
                                        <button class="primary-btn  fix-gr-bg" type="submit" @click="edit_comment_id = ''"> {{trans('common.Cancel')}} </button>
                                    </div>
                                </div>

                               </div>
                            
                          </div>
                      </div>
                    <div class="conversion_msg_history d-flex" v-for="(replay, r_index) in comment.comments" v-bind:key="r_index + 1">
                        <div class="conversion_msg_history_left">
                            <div class="thumb thumb_32 mr-15">
                                <img :src="replay.user.avatar" :alt="replay.user.name">
                            </div>
                        </div>
                        <div class="conversion_msg_history_right d-flex justify-content-between w-100">
                            <div class="conversion_msg_history_header d-flex justify-content-between w-100">
                                <div class="conversion_msg_history_header_left">
                                    <p>{{ replay.user.name }} <span> {{ replay.crated_at }}</span> </p>
                                </div>
                                <div class="conversion_msg_history_header_right d-flex ">

                                    <div class="btn-group square_arrow_down_btn ">
                                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ti-angle-down f_s_11"></i>
                                        </button>
                                        <div class="dropdown-menu pm_dropdown_menu dropdown-menu-right mt-0 minWidth_185 multy_dropdown multy_dropdown_left">
                                            <span @click="editComment(replay.id)" class="dropdown-item">{{ trans('project::project.edit_comment')}}</span>
                                            <span @click="deleteComment(replay.id)" class="dropdown-item">{{ trans('project::project.delete_comment') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="conversion_msg_history_body">
                                <p v-html=" replay.comment" v-if="edit_comment_id != replay.id"> </p>
                               <div v-if="edit_comment_id == replay.id">
<div class="conversion_descreption_text" >
                                    <html-editor name="description" :model.sync="replay.comment" height="120" :ref="'edit_html_editor_'+replay.id"></html-editor>
                                </div>
                                <div class="conversion_sender_footer mt-1">
                                    <div class="conversion_sender_footer_left">

                                    </div>
                                    <div class="conversion_sender_footer_right">
                                        <button class="primary-btn  fix-gr-bg" type="submit" @click="submitEditComment(index, r_index)"> {{trans('project::project.Update')}} </button>
                                        <button class="primary-btn  fix-gr-bg" type="submit" @click="edit_comment_id = ''"> {{trans('common.Cancel')}} </button>
                                    </div>
                                </div>

                               </div>
                            </div>
                        </div>
                    </div>
                  </div>

                  <!-- conversion_msg_wrapper_footer  -->
                  <div class="conversion_msg_wrapper_footer d-flex">
                    <div class="project_d_footer d-flex  w-100">
                        <div class="thumb thumb_32 mr-10 mb_20">
                            <img src="http://project_crm.test/public/frontend/img/chat/sender.png" alt="#">
                        </div>
                        <div class="project_d_footer_right align-items-start  d-flex w-100 flex-column justify-content-end">
                            <html-editor name="description" :model.sync="comment.replay" height="120" :ref="'html_editor_'+comment.id"></html-editor>
                            <div class="project_d_footer_bottom d-flex justify-content-end pl-0 pr-0 mt-20 w-100">
                                <div class="leave_task d-flex align-items-center justify-content-end w-100">
                                     <button class="primary-btn  fix-gr-bg" type="submit" @click="submitReplayComment(index)"> post </button>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
              </div>


              <!-- conversion_card -->
            <div class="conversion_card">
                <div class="thumb">
                    <img src="http://project_crm.test/public/frontend/img/project/chat.svg" alt="">
                </div>
                <h3>{{ trans('project::project.project_info3') }}</h3>
                <p>{{ trans('project::project.project_info4') }}:
                    <a href="#">portfolio-showcase@mail.asana.com</a></p>
            </div>
          </div>
      </div>
  </div>
</div>
</template>

<script>
export default {
    name: 'project-conversations-section',
    props :{
        project_id : {
            type:  String
        },
    },
    data() {
        return {
            comment : '',
            project: {},
            edit_comment_id : ''
        }
    },
    mounted() {
        this.getProjectDetails();
        
    },
    methods: {
        deleteComment(comment_id){
             axios.post('/project-comment-delete', {
                project_id: this.project.id,
                comment_id: comment_id
            }).then(data => {
                this.project = data.project;
            });
        },
        submitComment(){
             axios.post('/project-comment', {
                project_id:this.project_id,
                comment: this.comment
            }).then(data => {
                this.project = data.project;
                this.comment = '';
                this.$nextTick(() => {
                   this.$refs.html_editor.destroyEditor();
                });

            });
        },
        submitReplayComment(comment_index){
            var comment = this.project.comments[comment_index];
            axios.post('/project-comment', {
                project_id:this.project_id,
                parent_id: comment.id,
                comment: comment.replay
            }).then(data => {
                this.project = data.project;
            });
        },
        getProjectDetails : function() {
          $('.preloader').fadeIn('slow');
            axios.post('/projects', {
                project_id:this.project_id
            }).then(data => {
                this.project = data.project;
                $('.preloader').fadeOut('slow');
            });
        },
        editComment(comment_id){
            this.edit_comment_id = comment_id;
            this.$nextTick(() => {
                let ref = 'edit_html_editor_'+comment_id;
                this.$refs[ref][0].activeEditor();
                this.$refs[ref][0].scrollTo = { top: 0, behavior: 'smooth' }
            });
            return;
        
        },
        submitEditComment(comment_index, replay_index){
            var comment = {};
            if(typeof(replay_index) != 'undefined'){
                console.log('replay')
                comment = this.project.comments[comment_index].comments[replay_index];
            } else{
                console.log('comment')
                comment = this.project.comments[comment_index];
            }
            
            axios.post('/project-comment-edit', {
                project_id: this.project.id,
                comment_id: comment.id,
                comment: comment.comment
            }).then(data => {
                this.project = data.project;
                this.edit_comment_id = '';
            });
        }

    },
}
</script>
