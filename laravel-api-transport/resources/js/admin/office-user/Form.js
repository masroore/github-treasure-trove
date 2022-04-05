import AppForm from '../app-components/Form/AppForm';

Vue.component('office-user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                office_id:  '' ,
                deleted:  false ,
                
            }
        }
    }

});