<template>
    <div class="seperated_min_box p-0" :key="'field_'+field_index+1" :class="{'min_width200':field.type == 'tags'}" >
        <template v-if="field.type == 'user_id'">
            <div class="dropdown asign_box_dropdown">
                <button id="dLabel" class="dropdown-select" type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="assigned_member d-flex align-items-center" v-if="field.pivot.user_id">
                        <div class="asign_avater">
                        <img :src="userPhoto(field.pivot.assinge)"
                         />
                        </div>
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
                    <li>
                     <div class="single_asign_member d-flex">
                            <div class="height_light_text">
                                <i class="ti-plus"></i>
                                <span>{{ trans('project::project.invite_teammates_via_email') }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!--/ dropdown  -->
        </template>
        <template v-else-if="field.type == 'date' && field.default">
            <div class="drag_date_box">
                <div class="no-gutters input-right-icon d-flex">
                    <button id="start-date-icon" class="" type="button">
                        <i class="ti-calendar"></i>
                    </button>
                    <div class="col">
                        <div class="">
                            <datepicker v-model="field.pivot.date" @input="updateTaskFieldValue" input-class="primary-input">
                            </datepicker>
                            <!-- <label>lang.date_of_birth *</label> -->
                            <!-- <span class="focus-border"></span> -->
                        </div>
                    </div>
                </div>
            </div>
        </template>
    
    </div>

</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        name: 'project-section-sub-task-fields',
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
                    this.$emit('updateTaskFieldValue', data);
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
                            this.task.tags.push(data)
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
                    this.teamUser = res;
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
            removeFieldValue() {
                let field = this.field.pivot;
                field.user_id  = ''
                field.date  = ''
                field.number  = ''
                field.text  = ''
                field.option_id = ''
                axios.post('/task/update_field', {
                    task_id: field.task_id,
                    field_id: field.field_id,
                    user_id: null,
                    date : null,
                    number : null,
                    text : null,
                    option_id: null
                }).then(data => {
                    this.$emit('updateTaskFieldValue', data);
                });
            },
        }
    }

</script>
