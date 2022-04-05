import AppForm from '../app-components/Form/AppForm';

Vue.component('ticket-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                passenger_id:  '' ,
                schedule_id:  '' ,
                deleted:  false ,
                
            }
        }
    }

});