<template>
    <div class="Autosuggestion form-group mb-50">
        <label v-if="title != ''">{{ title }}</label>
        <input type="text" class="form-control" :name="target" :placeholder="placeholder" v-model="query" @keyup="autoComplete()">
        <input type="hidden" :name="target + '_id'" v-model="id">
        <input v-if="target == 'user'" type="hidden" :name="'recipient'" v-model="id">
        <div class="panel-footer" v-if="results.length">
            <ul class="list-group">
                <li class="list-group-item" v-for="result in results" @click="select(result)">
                    {{ result.name }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            url: String,
            min: Number,
            title: {
                type: String,
                required: false,
                default: ''
            },
            placeholder: {
                type: String,
                required: false,
                default: ''
            },
            target: {
                type: String,
                required: false,
                default: ''
            },
        },
        //
        data() {
            return {
                query: '',
                results: [],
                id: 0
            }
        },
        //
        mounted() {
            console.log(this.url)
            console.log(this.target)
            console.log(this.min)
        },
        //
        methods: {
            autoComplete(){
                this.results = []

                if (this.query.length > this.min) {
                    axios.get(this.url, { params: { query: this.query }}).then(response => {
                        this.results = response.data
                    })
                }
            },

            select(search) {
                console.log(search)

                this.query = search.name
                this.id = search.id
                this.results = []
            }
        }
    };
</script>
<style>
    .panel-footer {
        width: 100%;
        position: absolute;
        z-index: 999;
        padding-right: 30px;
    }

    ul li {
        cursor: pointer;
    }
    ul li:hover {
        background-color: #eeeeee;
    }
</style>
