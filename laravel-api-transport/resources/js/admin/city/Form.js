import AppForm from '../app-components/Form/AppForm';

Vue.component('city-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                city_name:  '' ,
                deleted:  false ,
                
            }
        }
    }

});