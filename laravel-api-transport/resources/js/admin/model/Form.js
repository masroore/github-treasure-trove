import AppForm from '../app-components/Form/AppForm';

Vue.component('model-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                model_name:  '' ,
                deleted:  false ,
                
            }
        }
    }

});