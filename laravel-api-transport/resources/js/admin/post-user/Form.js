import AppForm from '../app-components/Form/AppForm';

Vue.component('post-user-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                user_id:  '' ,
                post_id:  '' ,
                deleted:  false ,
                
            }
        }
    }

});