import AppForm from '../app-components/Form/AppForm';

Vue.component('post-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                post_name:  '' ,
                deleted:  false ,
                
            }
        }
    }

});