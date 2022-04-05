import AppForm from '../app-components/Form/AppForm';

Vue.component('schedule-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                date:  '' ,
                time:  '' ,
                cost:  '' ,
                confirmed:  false ,
                transport_id:  '' ,
                route_id:  '' ,
                deleted:  false ,
                
            }
        }
    }

});