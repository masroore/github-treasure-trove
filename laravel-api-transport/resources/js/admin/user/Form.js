import AppForm from '../app-components/Form/AppForm';

Vue.component('user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                email:  '' ,
                password:  '' ,
                surname:  '' ,
                first_name:  '' ,
                second_name:  '' ,
                passport_series:  '' ,
                passport_number:  '' ,
                inn:  '' ,
                scan:  '' ,
                birthday:  '' ,
                deleted:  false ,
                dismissed:  false ,
                api_token:  '' ,
                
            }
        }
    }

});