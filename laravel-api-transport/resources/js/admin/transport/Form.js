import AppForm from '../app-components/Form/AppForm';

Vue.component('transport-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                car_number:  '' ,
                total_seats:  false ,
                model_id:  '' ,
                deleted:  false ,
                
            }
        }
    }

});