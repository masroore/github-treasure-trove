<template>
    <div class="single_task_d_field" :key="field_index+1">
        <div class="task_d_left">
            {{ field.name }}
        </div>
        <div class="task_d_right " v-if="field.type == 'user_id'">
            <div class="seperated_min_box border-0">
            <div class="dropdown asign_box_dropdown ">
                <button id="dLabel" class="dropdown-select" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="assigned_member d-flex align-items-center" v-if="field.pivot.user_id">
                        <div class="asign_avater">
                        <img :src="userPhoto(field.pivot.assinge)"
                         />
                        </div>
                        <span>{{ field.pivot.assinge.name.substring(0,13)+".." }}</span>
                        <div class="remove_assigned" @click="removeFieldValue"> <i
                                class="ti-close"></i> </div>

                    </div>
                    <div class="assigned_member d-flex align-items-center" v-else>
                        <div class="unassign_input">
                            <i class="far fa-user"></i>
                        </div>
                    </div>

                </button>
                <ul class="dropdown-menu asign_dropdown_list dropdown-menu-right" :id="'user_dropdown_'+task.id"
                    aria-labelledby="dLabel">
                    <li data-toggle="modal" data-target="#invite_email">
                        <div class="single_asign_member d-flex">
                            <div class="height_light_text">
                                <input type="text" @keyup="getCurrentTeamAllUser($event)">
                            </div>
                        </div>
                    </li>
                    <li v-for="user in teamUser" :key="'user_'+user.id" :style="{background: user.id == field.pivot.user_id ? '#e8ecee': ''}" @click="updateTaskFieldUser(user)">

                        <div class="single_asign_member d-flex">
                            <div class="asign_avater">
                            <img :src="userPhoto(user)"/>
                </div>
                            <div class="asign_title"><span> {{ user.name}} </span></div>
                            <div class="asign_subtitle"><span> {{ user.email }} </span></div>
                        </div>

                    </li>
                    
                </ul>
            </div>
            </div>
        </div>
        <div class="task_d_right" v-else-if="field.type == 'date'">
            <div class="drag_date_box visible_date ml_16">
                <div class="no-gutters input-right-icon d-flex">
                    <button id="start-date-icon" class="" type="button">
                        <i class="ti-calendar"></i>
                    </button>
                    <div class="col">
                        <div class="">
                         <datepicker v-model="field.pivot.date" @input="updateTaskFieldValue" input-class="primary-input">
                            </datepicker>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="task_d_right" v-else-if="field.type == 'dropdown'">
          <div class="btn-group normal_dropdown_btn ">
                <button type="button" class="dropdown-toggle  btn" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <span v-if="!field.pivot.option_id">-------------</span>
                    <span v-else> {{ field.pivot.option.option }}</span>
                </button>
                <div class="dropdown-menu pm_mini_dropdown dropdown-menu-right  mt-0">
                    <span class="dropdown-item"  @click="updateTaskFieldOption('')"
                        ><i class="fa fa-check mr-1" v-if="!field.pivot.value"></i>
                        -------------</span>
                    <span class="dropdown-item" v-for="option in field.options"  @click="updateTaskFieldOption(option.id)"
                        :key="option.id"><i class="fa fa-check mr-1" v-if="field.pivot.value == option.option"></i>
                        {{ option.option }}</span>

                </div>
            </div>
        </div>
        <div class="task_d_right" v-else-if="field.type == 'tags'">
           <div class='tag-input'>
                <span v-for='(tag, index) in task.tags' :key='tag.id' class='badge badge-success mr-1'>
                     {{ tag.name }} <span @click='removeTag(index)'>x</span>

                </span>

                <input type='text' class="w-100  border-0" @keydown.enter='addTag($event, task.id, field.id)' @keydown.188='addTag($event, task.id, field.id)' :ref="'tag_'+field.id"/>
            </div>
        </div>
        <div class="task_d_right" v-else-if="field.type == 'text'">
        <input type="text" v-model="field.pivot.text" class="w-100" v-on:blur="updateTaskFieldValue" />
        </div>
        <div class="task_d_right" v-else-if="field.type == 'number'">
        <span v-if="!number_edit" @click="number_edit = true" class="d-block w-100 pr-1 text-right">{{ previewNumberFormat(field.pivot.number) }}</span>
           <input type="number" step="0.01" v-model="field.pivot.number" class="w-100" v-on:blur="updateTaskFieldNumber" v-else/>
        </div>
    </div>



</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        name: 'project-section-task-details-fields',
        components: {
            Datepicker
        },
        props: {
            field: {
                type: Object
            },
            field_index: {
                type: Number
            },
            task: {
                type: Object
            },
            project:{
                type: Object
            }

        },

        data() {
            return {
                teamUser: [],
                number_edit : false
            }
        },
        mounted() {
           this.teamUser = this.project.users;
        },
        methods: {
            updateTaskFieldOption(option_id){
                axios.post('/get_options', {
                    id: option_id,
                }).then(data => {
                    this.field.pivot.option = data;
                    this.field.pivot.option_id = option_id;
                    this.updateTaskFieldValue();
                });
            },
            updateTaskFieldUser(user){
                this.field.pivot.user_id = user.id;
                this.field.pivot.assinge = user;
                this.updateTaskFieldValue();

            },
            updateTaskFieldValue() {
                let field = this.field.pivot;
                axios.post('/task/update_field', {
                    task_id: field.task_id,
                    field_id: field.field_id,
                    user_id: field.user_id,
                    date : field.date,
                    number : field.number,
                    text : field.text,
                    option_id: field.option_id
                }).then(data => {
                    this.$emit('updateTaskFieldValue', data)
                });
            },
            updateTaskFieldNumber() {
                this.number_edit = false;
                this.updateTaskFieldValue();
            },
            addTag(event, task_id, field_id) {
                event.preventDefault()
                var val = event.target.value.trim()
                if (val.length > 0) {
                    this.field_value = this.field_value + ', ' + val;
                    axios.post('/store-tag', {
                        value: val,
                        task_id: task_id,
                        field_id: field_id
                    }).then(data => {
                        if(data){
                            this.task.tags.push(data.tag)
                            this.$emit('updateTaskFieldValue', data.section)
                        }

                    });
                    event.target.value = ''
                }
            },
            removeTag(index) {
                let tag = this.task.tags[index];
                this.task.tags.splice(index, 1);
                axios.post('/remove-tag', {
                        task_id: this.task.id,
                        tag_id: tag.id
                    }).then(data => {

                    });
            },
            userPhoto(user){
                return helper.getUserProfilePhoto(user);
            },
            getCurrentTeamAllUser(event) {
                let value = event.target.value;
                axios.get("/get-user-suggestion-priority",{
                    params:{
                        team_id : this.project.team_id,
                        value: value
                    }

                }).then(res => {
                    this.teamUser = res.data;
                })
            },
            previewNumberFormat(number) {
                if(typeof(number) == "undefined" || number == null){
                    number = 0;
                }

                number = parseFloat(number)
                if (this.field.format == 'percent') {
                    return number.toFixed(this.field.decimal) + '%';
                }
                if (this.field.format == 'Usd') {
                    return '$' + number.toFixed(this.field.decimal);
                }

                if (this.field.format == 'custom') {
                    if (this.field.position == 'right') {
                        return number.toFixed(this.field.decimal) + this.field.label
                    } else {
                        return this.field.label + number.toFixed(this.field.decimal)
                    }
                }

                if (this.field.format != 'unformat') {
                    return number.toFixed(this.field.decimal)
                }
                return number;
            },
            focusTag(){
                let tag_id = this.$refs['tag_'+this.field.id];
                if(typeof(tag_id) != 'undefined'){
                    this.$nextTick(() => {
                        tag_id.focus();
                    });
                }
            },
             removeFieldValue() {
                let field = this.field.pivot;
                this.field.pivot.user_id  = ''
                this.field.pivot.date  = ''
                this.field.pivot.number  = ''
                this.field.pivot.text  = ''
                this.field.pivot.option_id = ''
                axios.post('/task/update_field', {
                    task_id: field.task_id,
                    field_id: field.field_id,
                    user_id: null,
                    date : null,
                    number : null,
                    text : null,
                    option_id: null
                }).then(data => {
                    this.$emit('updateTaskFieldValue', data)
                });
            },
        },

    }

</script>
