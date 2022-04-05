<template>
    <div v-if="project_delete_modal">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-dialog modal_650px   modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ trans('project::project.delete_title',{'project_name' : project.name } )}}</h4>
                            <button type="button" class="close " @click="$emit('modalClosed')">
                                <i class="ti-close "></i>
                            </button>
                        </div>

                        <div class="modal-body">

                            <div class="row">
                                <dir class="col-md-12">
                                    <p>
                                        {{ trans('project::project.delete_info')}}:
                                            <ul>
                                                <li>{{ trans('project::project.delete_info1')}}</li>
                                                <li>{{ trans('project::project.delete_info2')}}</li>
                                            </ul>
                                    </p>
                                </dir>

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center pt_20">
                                        <button type="submit" class="primary-btn semi_large2 fix-gr-bg"
                                                @click="submitProjectDelete"><i class="ti-check"></i>{{ trans('common.Delete') }}
                                        </button>

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
export default {

    props :{
        project : {
            type: Object
        },
        project_delete_modal:{
            type: Boolean
        }
    },
    mounted() {

    },
    name: "project-delate-modal",
    methods: {
        submitProjectDelete : function(){
            axios.post('project-delete', {
                project_id : this.project.id
            }).then(data => {
                this.modalClosed();
                toastr.success(data.message, 'Success');
                setTimeout(function(){
                    window.location.href = data.goto;
                }, 200);
            })
        },

        modalClosed : function(){
            this.$emit('modalClosed');
        }
    },

}
</script>
