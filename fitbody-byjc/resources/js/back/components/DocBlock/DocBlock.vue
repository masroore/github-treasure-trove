<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Laravel Vue JS Image Upload - ItSolutionStuff.com</div>

                    <div class="card-body">
                        <div v-if="success != ''" class="alert alert-success" role="alert">
                            {{success}}
                        </div>
                        <form @submit="formSubmit" enctype="multipart/form-data">
                            <strong>Name:</strong>
                            <input type="text" class="form-control" v-model="name">
                            <strong>Image:</strong>
                            <input type="file" class="form-control" v-on:change="onImageChange">

                            <button class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                name: '',
                image: '',
                success: ''
            };
        },
        methods: {
            onImageChange(e){
                console.log(e.target.files[0]);
                this.image = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let formData = new FormData();
                formData.append('image', this.image);

                axios.post('/apiv1/pages/block', formData, config)
                    .then(function (response) {
                        console.log(response)

                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {
                        console.log(error)

                        currentObj.output = error;
                    });
            }
        }
    }
</script>
