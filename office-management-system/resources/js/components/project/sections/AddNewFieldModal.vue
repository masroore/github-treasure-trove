<template>
    <div v-if="add_new_field_modal">

        <transition name="modal">
            <div class="modal-mask">
                    <div class="modal-dialog modal-dialog-centered modal-lg">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><span v-if="!add_new_field_form.id">{{  trans('project::project.add_new_field') }}</span> <span
                                        v-else>{{ trans('project::project.edit_field') }} }}</span></h4>
                                <button type="button" class="close " @click="addNewFormFieldClose()">
                                    <i class="ti-close "></i>
                                </button>
                            </div>

                            <div class="modal-body p-0">
                                <!-- modal_tab -->
                               
                                <div class="tab-content modal_tab_container" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                         aria-labelledby="home-tab">
                                        <div class="row mt_30">
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label for="name" class="primary_input_label required">{{ trans('project::project.field_title') }}</label>
                                                    <input class="primary_input_field" :placeholder="trans('project::project.field_title')"
                                                           required="" name="name" type="text"
                                                           v-model="add_new_field_form.name">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label for="name">{{ trans('project::project.field_type') }}
                                                    </label>

                                                    <v-select label="name" v-model="add_new_field_form.type" group-values="field_type" group-label="field_group" :group-select="false" name="type" id="type" :options="[
                                                    { id: 'text', name : trans('common.text')},
                                                    { id: 'dropdown', name : trans('common.dropdown')},
                                                    { id: 'number', name : trans('common.number')},
                                                    { id: 'date', name : trans('common.date')},
                                                    ]" 
                                                    @option:selected="onFieldTypeSelect"  v-if="!add_new_field_form.id">
                                                       
                                                    </v-select>
                                                    <p v-else>{{ add_new_field_form.type }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" v-if="add_new_field_form.type=='number'">
                                            <div class="col-xl-3">
                                                <div class="primary_input mb-25">
                                                    <label for="name"
                                                           class="primary_input_label required">{{ trans('project::project.format') }}</label>

                                                             <v-select label="name" v-model="add_new_field_form.format"  name="format" id="format" :options="[
                                    { id: 'number', name : trans('project::project.number')},
                                    { id: 'percent', name : trans('project::project.percent')},
                                    { id: 'usd', name : trans('project::project.usd')},
                                    { id: 'custom', name : trans('project::project.custom_label')},
                                    { id: 'unformat', name : trans('project::project.unformat')},
                                                   
                                                    ]" 
                                                    @option:selected="onNumberFormatSelect"  >
                                                       
                                                    </v-select>

                                                </div>
                                            </div>
                                            <div class="col-xl-2" v-if="add_new_field_form.format == 'custom'">
                                                <div class="primary_input mb-25">
                                                    <label for="label" class="primary_input_label">{{ trans('project::project.label') }}</label>
                                                    <input class="primary_input_field" id="label" :placeholder="trans('project::project.label')"
                                                           type="text" v-model="add_new_field_form.label">
                                                </div>
                                            </div>
                                            <div class="col-xl-2" v-if="add_new_field_form.format == 'custom'">
                                                <div class="primary_input mb-25">
                                                    <label for="position"
                                                           class="primary_input_label required">{{ trans('project::project.position') }}</label>
                                     <v-select label="name" v-model="add_new_field_form.position"  name="position" id="position" :options="[
                                    { id: 'left', name : 'Left'},
                                    { id: 'right', name : trans('project::project.right')},
                                                    ]" 
                                                    @option:selected="onPositionFormatSelect"  >
                                                       
                                                    </v-select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-xl-2" v-if="add_new_field_form.format != 'unformat'">
                                                <div class="primary_input mb-25">
                                                    <label for="decimal"
                                                           class="primary_input_label required">{{ trans('project::project.decimals') }}</label>
                                                           <v-select label="decimals" v-model="add_new_field_form.decimals"  name="decimals" id="decimals" :options="[0,1,2,3,4,5,6
                                                    ]" 
                                                    @option:selected="onPositionFormatSelect"  >
                                                       
                                                    </v-select>
                                                   
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="primary_input mb-25">
                                                    <label for="preview"
                                                           class="primary_input_label required">{{ trans('project::project.preview') }}</label>
                                                    {{ previewNumberFormat(1000) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" v-if="add_new_field_form.type=='dropdown'">
                                            <div class="col-xl-12">
                                                <draggable :list="add_new_field_form.options" group="section"
                                                           animation="200">
                                                    <transition-group>
                                                        <div class="primary_input mb-10 d-flex align-items-center"
                                                             v-for="(option, index) in add_new_field_form.options"
                                                             :key="index+1">
                                                            <input type="text" v-model="option.option" class="w-75 primary_input_field"
                                                                   :ref="'option_'+index"> <div class="delete_icon primary-btn radius_30px  fix-gr-bg">
                                                                       <i class="fa fa-trash m-0 "
                                                                                              style="cursor: pointer;"
                                                                                              @click="removeOption(index)"></i></div> 
                                                        </div>
                                                    </transition-group>
                                                </draggable>
                                            </div>
                                            <div class="col-xl-12">
                                                <p class="primary-btn radius_30px  fix-gr-bg mt-10 mb-10" style="cursor: pointer" @click="addNewOption()"><i
                                                        class="fa fa-plus"></i> {{ trans('project::project.add_new_option') }}</p>
                                            </div>

                                        </div>

                                        
                                        <div class="row mb-25">
                                            <div class="col-lg-12 text-center">
                                                <div class="d-flex justify-content-center pt_20">
                                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg mr-1" v-if="add_new_field_form.id"
                                                            @click="deleteField()">
                                                        <i class="ti-check"></i>{{ trans('project::project.delete_field') }}
                                                    </button>
                                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg"
                                                            @click="submitAddNewField()">
                                                        <i class="ti-check"></i>{{ trans('project::project.save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!--/ modal_tab -->


                            </div>

                        </div>


                    </div>
            </div>
        </transition>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import vSelect from 'vue-select'
export default {
    components:{
        draggable, vSelect
    },
    props :{
        project : {
            type: Object
        },
        add_new_field_modal:{
            type: Boolean
        },
        field_id : {
            default: null
        }
    },
    data() {
        return {
            field_edit: false,
            add_new_field_form: {
                id: '',
                type: 'dropdown',
                name: '',
                format: 'number',
                label: '',
                decimals: 2,
                position: 'left',
                options: [
                    {
                        option: 'Option 1',
                        color: 'fff'
                    }, {
                        option: 'Option 2',
                        color: 'fff'
                    }
                ],
                library: false,
                notify: false,
                editable: false
            }
        }
    },
    mounted() {
        console.log(this.field_id);
        if(this.field_id){

            this.field_edit = true;
            axios.post('/field/edit', {
                'field_id': this.field_id
            }). then(data => {
                this.add_new_field_form.id = data.id;
                this.add_new_field_form.type = data.type;
                this.add_new_field_form.name = data.name;
                this.add_new_field_form.format = data.format;
                this.add_new_field_form.label = data.label;
                this.add_new_field_form.decimals = data.decimals;
                this.add_new_field_form.position = data.position ?? 'left';
                this.add_new_field_form.options = data.options;
                this.add_new_field_form.library = data.library;
                this.add_new_field_form.notify = data.workspace_id ? true : false;
                this.add_new_field_form.editable = data.editable;
                this.add_new_field_modal = true;
            })
        }
    },
    methods: {
        submitAddNewField() {
            if (!this.add_new_field_form.name) {
                return;
            }
            axios.post('/field/store', {
                id: this.add_new_field_form.id,
                type: this.add_new_field_form.type,
                name: this.add_new_field_form.name,
                format: this.add_new_field_form.format,
                label: this.add_new_field_form.label,
                decimals: this.add_new_field_form.decimals,
                position: this.add_new_field_form.position,
                options: this.add_new_field_form.options,
                library: this.add_new_field_form.library,
                notify: this.add_new_field_form.notify,
                editable: this.add_new_field_form.editable,
                project_id: this.project.id

            }).then (data => {
                this.$emit('newFieldAdded')
                this.addNewFormFieldClose()
            });
        },

        removeOption(option_index) {
            this.add_new_field_form.options.splice(option_index, 1);
            if (!this.add_new_field_form.options.length) {
                this.addNewOption();
            }
        },
        addNewOption() {
            this.add_new_field_form.options.push(
                {
                    option: '',
                    color: 'ffff'
                }
            );
            let length = this.add_new_field_form.options.length - 1;

            var ref = 'option_' + length;
            this.$nextTick(() => {
                this.$refs[ref][0].focus()
            });
        },
        previewNumberFormat(number) {
//
            if (this.add_new_field_form.format == 'percent') {
                number = 100;
                return number.toFixed(this.add_new_field_form.decimals) + '%';
            }
            if (this.add_new_field_form.format == 'Usd') {
                return '$' + number.toFixed(this.add_new_field_form.decimals);
            }

            if (this.add_new_field_form.format == 'custom') {
                if (this.add_new_field_form.position == 'right') {
                    return number.toFixed(this.add_new_field_form.decimals) + this.add_new_field_form.label
                } else {

                    return this.add_new_field_form.label + number.toFixed(this.add_new_field_form.decimals)

                }

            }

            if (this.add_new_field_form.format != 'unformat') {
                return number.toFixed(this.add_new_field_form.decimals)
            }
            return number;
        },
        addNewFormFieldClose() {
            this.add_new_field_form.id = '';
            this.add_new_field_form.type = 'dropdown';
            this.add_new_field_form.name = '';
            this.add_new_field_form.format = 'number';
            this.add_new_field_form.label = '';
            this.add_new_field_form.decimals = 2;
            this.add_new_field_form.position = 'left';
            this.add_new_field_form.options = [
                {
                    option: 'Option 1',
                    color: 'ffff'
                }, {
                    option: 'Option 2',
                    color: 'ffff'
                }
            ];
            this.add_new_field_form.library = false;
            this.add_new_field_form.notify = false;
            this.add_new_field_form.editable = false;

            this.$emit('modalClosed');
        },
        deleteField(){
            axios.post('/field/delete', {
                field_id: this.field_id,
            }).then (data => {
                this.$emit('newFieldAdded')
                this.addNewFormFieldClose()
            });
        },
       
        onFieldTypeSelect (select){
            this.add_new_field_form.type = select.id;
        },
        onNumberFormatSelect (select){
            this.add_new_field_form.format = select.id;
        },
        onPositionFormatSelect (select){
            this.add_new_field_form.position = select.id;
        }
    },
}
</script>
