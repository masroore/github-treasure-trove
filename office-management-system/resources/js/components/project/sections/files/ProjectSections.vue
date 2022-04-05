<template>
<div>
    <div class="tab-pane fade gray_content  active show " >
        <div class="project_file_wrapper">
            <div class="project_file_wrapper_inner">
                <div class="single_project_file" v-for="(image, index) in images" v-bind:key="index+1">
                    <div @click="showImage(index)" class="project_file_d_open"></div>
                    <div class="project_file_header">
                        <div class="img_icon">
                            <i class="ti-image"></i>
                        </div>
                        <div class="project_file_info">
                            <span class="img_title" >{{ image.user_filename }}</span>
                            <span class="img_label" > <span @click="showTask(image.task.uuid)" class="cursor_pointer">{{ image.task.name }}</span> . {{ image.user.name }}</span>
                        </div>
                    </div>
                    <div class="project_file_preview">
                        <img :src="image.filename" :alt="image.user_filename" v-if="fileType(image.file_type) == 'img'">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="show_modal">
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <button type="button" class="btn-prev Next_prev_btn" @click.prevent="show_prev()">
                    <i class="ti-angle-left"></i>
                </button>
                <button type="button" class="btn-next Next_prev_btn" @click.prevent="show_next()">
                    <i class="ti-angle-right"></i>
                </button>
                <div class="modal-dialog full_width_modal ">
                    <div class="modal-content">
                        <div class="modal_header d-flex">
                            <div class="modal_bar_left">
                                <div class="modal_d_title">
                                    <span style="cursor: pointer;">{{ show_image.user_filename }}</span>
                                    <p>{{ formatDateTime(show_image.created_at) }}</p>
                                </div>
                                <a :href="show_image.filename" download class="primary-btn radius_30px  fix-gr-bg"> <i class="ti-download"></i> {{trans('project::project.Download')}}</a>
                            </div>
                            <div class="modal_bar_right">
                                <button type="button" @click.prevent="show_modal= false">
                                    <i class="ti-close "></i>
                                </button>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="image_preview">
                                <div data-dismiss="modal" class="modal_close_overly"></div>
                                <img :src="show_image.filename" :alt="show_image.user_filename" v-if="fileType(show_image.file_type) == 'img'">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </transition>
    </div>

    <project-section-task-details :task_id="details_task" :project="project" v-if="task_details" @taskDetailsClosed="closeTaskDetails" :auth_user="auth_user" @showSubtask="subtaskShow" ref="project_details"/>
</div>
</template>

<script>
import ProjectSectionTaskDetails from './ProjectSectionTaskDetails'
export default {
    components : {
        ProjectSectionTaskDetails
    },
    name: 'project-files-sections',
    props:{
        project_id :{
            type: String
        }
    },
    data() {
        return {
            show_modal :false,
            images :[],
            show_image_index : '',
            show_image : {},
            details_task: '',
            task_details : false,
            show_task_parent : [],
            project : {},
            auth_user : {}
        }
    },
    mounted() {
        this.getImages();
        this.getSections();
    },
    methods: {       
        getSections: function () {
            $('.preloader').fadeIn('slow');
            axios.post('/sections', {
                project_id: this.project_id
            })
            .then(response => {
                this.project = response.project;
                this.auth_user = response.auth_user;
                $('.preloader').fadeOut('slow');
            });
        },
        showTask(task_id){
            this.details_task = task_id;
            this.task_details = true;
            this.$nextTick(() => {
                this.$refs.project_details.getTask();
            });
        },
        closeTaskDetails(){
            this.task_details = false;
            this.details_task = '';
        },
        subtaskShow(task_id){
            this.closeTaskDetails();
            this.showTask(task_id);
        },
       
        
        getImages(){
            axios.post('get_images', {
                project_id : this.project_id
            }).then(data => {
                this.images = data.data
            })
        },
        showImage(index){
            this.show_image_index = index;
            this.show_image = this.images[index];
            this.show_modal = true;
        },
         fileType(file_type){
            let image = ['image/png', 'image/svg+xml', 'image/tiff', 'image/webp', 'image/bmp', 'image/gif', 'image/vnd.microsoft.icon', 'image/jpeg'];
            let txt = ['text/plain'];
            if(image.includes(file_type)){
                return 'img';
            } else if(txt.includes(file_type)){
                return 'txt'
            }
        },
        formatDateTime(datetime) {
            return helper.formatDateTime(datetime);
        },
        show_next(){
            let next_index = this.show_image_index + 1;
            if(this.images[next_index]){
                this.show_image_index = next_index;
                this.show_image = this.images[next_index];
            } else{
                this.show_modal = false;
            }
        },
        show_prev(){
            let next_index = this.show_image_index - 1;
            if(this.images[next_index]){
                this.show_image_index = next_index;
                this.show_image = this.images[next_index];
            } else{
                this.show_modal = false;
            }
        }
    },
    
}
</script>