<template>
<div class="project_color_dropdown" :class="{color_dropdown_open: open}"  >
    <div class="color_picker_hedear">
        <div class="color_chose_List">

                <label class="Color_checkbox d-flex  " v-for="(color, color_index) in colors" v-bind:key="color_index">
                    <input name="colors" type="radio" :checked="project_configuration.color == color" @click="updateColor(color)">
                    <span :style="{background: '#'+color}" class="checkmark"></span>
                </label>

        </div>
    </div>
    <div class="icon_picker_body">
        <div class="icon_List">

                <label class="Color_checkbox icon_checkbox d-flex" v-for="(icon, icon_index) in icons" v-bind:key="icon_index">
                    <input name="icon_pick" type="radio" :checked="project_configuration.icon == icon" @click="updateIcon(icon)">
                    <span class="checkmark" :style="{background: project_configuration.icon == icon ? '#'+project_configuration.color : ''}"> <i :class="icon"></i> </span>
                </label>

        </div>
    </div>

</div>
</template>

<script>
export default {
    name: "project-header-icon-color",

    props:{
        project_configuration: {
            type: Object
        },
        project_id :{
            type: Number
        },
        open:{
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            colors: ['f6f8f9', 'fb5779', 'ff7511', 'ffa800', 'ffd100', 'ace60f', '19db7e', '00d4c8', '48dafd', '0064fb', '6457f9', '9f46e4', 'ff78ff', 'ff4ba6', 'ff93af', '5a7896'],
            icons: ['ti-menu-alt', 'ti-crown', 'ti-palette', 'ti-briefcase', 'ti-package', 'ti-layout-tab', 'ti-layout-sidebar-right', 'ti-widget-alt']
        }
    },
    mounted() {
        var vm = this;
        $(document).click(function(event){
            if (!$(event.target).closest(".pm_project__icon ,.project_color_dropdown").length) {
                if (vm.open) {
                    vm.$emit('closeDropdown');
                }
            }
        });
    },
    methods: {
    updateColor(colorCode)
        {
            this.$emit('configurationUpdated', {
                color: colorCode,
                icon: this.project_configuration.icon,
                favourite: this.project_configuration.favourite
            })
            axios.post('/update-project-color',{
                project_id : this.project_id,
                color : colorCode
            }).then(res => {

            })
        },
        updateIcon(icon){
            this.$emit('configurationUpdated', {
                color: this.project_configuration.color,
                icon: icon,
                favourite: this.project_configuration.favourite
            })
            axios.post('/update-project-icon',{
                project_id : this.project_id,
                icon : icon
            }).then (res => {

            })
        },
    },
}
</script>
