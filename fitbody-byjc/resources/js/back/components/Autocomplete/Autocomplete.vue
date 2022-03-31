<template>
    <div class="Autocomplete">
        <input type="text" :placeholder="placeholder" v-model="query" @keyup="autoComplete" class="form-control" @keydown.enter="select(query)">
        <div class="panel-footer" v-if="results.length">
            <ul class="list-group">
                <li class="list-group-item" v-for="result in results" @click="select(result.name)">
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
            target: String,
            placeholder: String,
            min: Number
        },
        //
        data() {
            return {
                query: '',
                results: []
            }
        },
        //
        mounted() {
        },
        //
        methods: {
            autoComplete(){
                this.results = []

                if (this.query.length > this.min) {
                    axios.get(this.url, { params: { query: this.query }}).then(response => {
                        this.results = response.data;
                    })
                }
            },

            select(search) {
                let url = new URL(location.href)
                let params = new URLSearchParams(url.search)
                let keys = []

                for(var key of params.keys()) {
                    keys.push(key)
                }

                keys.forEach((value) => {
                    if (params.has(value)) {
                        params.delete(value)
                    }
                })

                if (search != '') {
                    params.append('search', search)
                }

                url.search = params
                location.href = url
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
