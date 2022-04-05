<template>
    <div>
          <!-- <vue-picture-swipe :items="return_file"  /> -->
          <ul class="d-flex">
                <li v-for="(uploaded_file, index) in uploaded_files" v-bind:key="uploaded_file.id">
                    <span @click.prevent="showImage(index)">
                        <div class="attach_img_preview">
                            <img :src="uploaded_file.filename" :alt="uploaded_file.user_filename" v-if="fileType(uploaded_file.file_type) == 'img'">

                            <span v-else>{{ uploaded_file.user_filename }}</span>
                            
                        </div>
                    </span>
                </li>
            </ul>
          <div class="btn-group square_arrow_down_btn doted_sqare_btn "  >
                <button type="button" :disabled="isUploadDisabled" @click="launchFilePicker">
                    <i class="ti-plus"></i>
                </button>
            </div>
      
        <input type="file" style="display:none" ref="file" v-uploader />
       <!--  <file-upload-progress :progress="progress" style="margin-top: 10px;"></file-upload-progress> -->
       
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
                                            <span>{{ show_image.user_filename }}</span>
                                            <p>{{ formatDateTime(show_image.created_at) }}</p>
                                        </div>
                                        <a :href="show_image.filename" download class="primary-btn radius_30px  fix-gr-bg"> <i class="ti-download"></i> {{trans('project::project.Download')}}</a>
                                    </div>
                                    <div class="modal_bar_right">
                                        <button type="button" @click.prevent="closeModal">
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
    </div>
</template>

<script>
    import fileUploadProgress from './file-upload-progress.vue'

    export default {
        components : { fileUploadProgress },
        props: {
            buttonText: {
                default: 'Choose File',
            },
            token: {
                required: true
            },
            module: {
                required: true
            },
            moduleId: {
                default: ''
            },
            clearFile: {
                default: false
            }
        },
        directives: {
            uploader: {
              bind(el, binding, vnode) {
                el.addEventListener('change', e => {
                  vnode.context.file = e.target.files[0];
                });
              }
            },
        },
        watch: {
            
            file(file){
                let fileExtension = file.name.substr((file.name.lastIndexOf('.') + 1));

                if(this.allowed_file_extensions.indexOf(fileExtension) == -1){
                    toastr.error('File not allowed');
                    this.isUploadDisabled = false;
                } else if(file.size > 41943040){
                    toastr.error('File size too large');
                    this.isUploadDisabled = false;
                } else {
                    let formData = new FormData();
                    formData.append('file', file);
                    formData.append('token', this.token);
                    formData.append('module', this.module);
                    formData.append('module_id', this.moduleId || '');
                    axios.post('/api/upload',formData, {
                        onUploadProgress: progressEvent => {
                            this.progress = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                        }
                    }).then(response => {
                        toastr.success(response.message);
                        this.uploaded_files.push(response.upload);
                        this.$emit('fileUploaded');
                    }).catch(error => {
                        if(error.response.status == 413)
                            toastr.error('File size too large');
                        else
                            helper.showErrorMsg(error);
                    }).then(() => {
                        this.progress = 0;
                        this.isUploadDisabled = false;
                    });
                    this.$refs.file.value = '';
                }
            },
            clearFile(val){
                this.uploaded_files = [];
            },
            moduleId(val){
                if(val)
                    this.fetchUploads();
            }
        },
        mounted(){
            console.log(this.module);
            if(this.moduleId)
                this.fetchUploads();

            axios.post('/api/upload/extension',{module: this.module})
                .then(response => {
                    this.allowed_file_extensions = response;
                })
                .catch(error => {

                });
        },
        computed: {
            authToken(){
                return helper.getAuthToken();
            },
            isFileSelected(){
                return this.isUploadDisabled ? true : false;
            }
        },
       
        methods: {
            fileType(file_type){
                let image = ['image/png', 'image/svg+xml', 'image/tiff', 'image/webp', 'image/bmp', 'image/gif', 'image/vnd.microsoft.icon', 'image/jpeg'];
                let txt = ['text/plain'];
                if(image.includes(file_type)){
                    return 'img';
                } else if(txt.includes(file_type)){
                    return 'txt'
                }
            },
            launchFilePicker() {
                this.$refs.file.click();
            },
            cancelUpload(){
                if (this.request) {
                    this.request.abort();
                }
                this.isUploadDisabled = false;
            },
            confirmDelete(uploaded_file){
                return dialog => this.deleteUpload(uploaded_file);
            },
            deleteUpload(uploaded_file){
                let loader = this.$loading.show();
                axios.post('/api/upload/'+uploaded_file.id,{
                    token: uploaded_file.upload_token,
                    module_id: this.moduleId || ''
                }).then(response => {
                    this.uploaded_files = this.uploaded_files.filter(function (item) {
                        return uploaded_file.id != item.id;
                    });
                    toastr.success(response.message);
                    loader.hide();
                }).catch(error => {
                    loader.hide();
                    helper.showErrorMsg(error);
                });
            },
            fetchUploads(){
                this.uploaded_files = [];
                axios.post('/api/upload/fetch',{
                    module: this.module,
                    module_id: this.moduleId
                })
                .then(response => {
                    this.uploaded_files = response;
                    this.pictureSwipe();
                })
                .catch(error => {
                    helper.showErrorMsg(error);
                });
            },
            pictureSwipe(){
                let uploaded_files = this.uploaded_files;
                let return_file = [];
                $.each(uploaded_files, function (i, v){
                    return_file.push({
                        src: v.filename,
                        thumbnail: v.filename,
                        w: 600,
                        h: 400
                    })
                });
               this.return_file = return_file;
            },
        showImage(index){
            this.show_image_index = index;
            this.show_image = this.uploaded_files[index];
            this.show_modal = true;
            this.$emit('showImage', true)
        },

        showImageBy(image_id){
            var vm = this;
            $.each(vm.uploaded_files, function (i, v){
                if (v.id == image_id) {
                    vm.showImage(i);
                    return;
                }
            });
           
        },

        formatDateTime(datetime) {
            return helper.formatDateTime(datetime);
        },
        show_next(){
            let next_index = this.show_image_index + 1;
            if(this.uploaded_files[next_index]){
                this.show_image_index = next_index;
                this.show_image = this.uploaded_files[next_index];
            } else{
                this.show_modal = false;
                this.$emit('showImage', false)
            }
        },
        show_prev(){
            let next_index = this.show_image_index - 1;
            if(this.uploaded_files[next_index]){
                this.show_image_index = next_index;
                this.show_image = this.uploaded_files[next_index];
            } else{
                this.show_modal = false;
                this.$emit('showImage', false)
            }
        },
        closeModal(){
            this.show_modal = false;
            this.$emit('showImage', false)
        }
        },
        data() {
            return {
              file: '',
              isUploadDisabled: false,
              progress: 0,
              uploaded_files: [],
              allowed_file_extensions: [],
              return_file : [],
              show_modal :false,
              show_image_index : '',
              show_image : {}
            }
        }
    }
</script>

<style>
    .upload-file-list{
        list-style: none;
        padding:0px;
    }
</style>
