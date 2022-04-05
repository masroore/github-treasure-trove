import AppForm from '../app-components/Form/AppForm';

Vue.component('route-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                departure_city_id:  '' ,
                arrival_city_id:  '' ,
                distance:  '' ,
                user_id:  '' ,
                deleted:  false ,
                
            }
        }
    }

});