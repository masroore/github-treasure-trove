<template>
    <textarea class="form-control w-100" v-on:focus="activeEditor" rows="1"  placeholder="Click to write something"></textarea>
</template>

<style lang="" src="summernote/dist/summernote-bs4.min.css"></style>

<<script>
import 'summernote/dist/summernote-bs4';
    export default{
        props : {
            isUpdate: {
                default: false,
            },
            model: {
                required: true
            },
            height: {
                type: String,
                default: '150'
            }
        },
        data(){
            return {
                loadContent: false
            }
        },
        mounted() {
            
        },
        methods: {
            destroyEditor(){
                $(this.$el).summernote('destroy');
            },
           
            activeEditor(){
                vm.$emit('htmlFocus', 1);
                let config = {
                    height: this.height,
                    fontNames: ['sans-serif'],
                    fontNamesIgnoreCheck: ['sans-serif'],
                    disableResizeEditor: true,
                    focus: true
                };
                let vm = this;
               
                config.callbacks = {
                    onInit: function () {
                        $(vm.$el).summernote("code", vm.model);
                     
                    },
                    onChange: function () {
                        vm.$emit('update:model', $(vm.$el).summernote('code'));
                        vm.$emit('clearErrors');
                        
                    },
                    onBlur: function () {
                        vm.$emit('update:model', $(vm.$el).summernote('code'));
                        $(vm.$el).summernote('destroy');
                        // vm.$emit('htmlFocus', 0);
                        

                    },
                    onImageUpload: function(files) {
                        vm.sendFile(files[0]);
                    }
                };
                $(this.$el).summernote(config);
            },
            
            sendFile(file){
                var data = new FormData();
                data.append("file", file);
                axios.post('/api/upload/image',data)
                    .then(response => {
                        $(this.$el).summernote('insertImage', response.image_url);
                    })
                    .catch(error => {
                        if(error.response.status == 413 || error.response.status == 500)
                            toastr.error('File size too large');
                        else if(error.response.status == 422)
                            toastr.error(error.response.errors.file[0]);
                        else
                            helper.showErrorMsg(error);
                    })
            }
        },
        watch: {
            model(val) {
                if (!this.loadContent && this.isUpdate) {
                    $(this.$el).summernote("code", this.model);
                    this.loadContent = true;
                }
                if(!this.model)
                    $(this.$el).summernote("code", '');
            },
            isUpdate(val) {
                this.loadContent = val;
            }
        },
    }
</script>
