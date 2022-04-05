import AppForm from '../app-components/Form/AppForm';

Vue.component('office-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                phone:  '' ,
                address:  '' ,
                city_id:  '' ,
                deleted:  false ,
                
            }
        }
    }

});