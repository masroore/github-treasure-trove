import AppForm from '../app-components/Form/AppForm';

Vue.component('passenger-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                surname:  '' ,
                first_name:  '' ,
                second_name:  '' ,
                passport_series:  '' ,
                passport_number:  '' ,
                phone:  '' ,
                deleted:  false ,
                
            }
        }
    }

});