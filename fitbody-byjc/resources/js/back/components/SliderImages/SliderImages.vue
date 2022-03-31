<template>
    <div class="SliderImages">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <h5 class="text-black mb-0 mt-20">Slider Images</h5>
                </div>
                <div class="col-9 text-right">

                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>
            <div class="row items-push">
                <div class="col-lg-3">
                    <p class="text-muted">Add nice and clean photos to better showcase your intentions to the world...</p>
                </div>
                <div class="col-lg-7 offset-lg-1">

                    <div v-for="(row, index) in rows">
                        <hr class="mb-30 mt-50" v-if="rows && index">

                        <div>

                            <div class="row mb-30 mt-20" v-if="row.file_url != ''">
                                <div class="options-container fx-item-zoom-in fx-overlay-zoom-out">
                                    <img class="img-thumbnail options-item" :src="row.file_url" alt="">
                                    <div class="options-overlay bg-primary-dark-op">
                                        <div class="options-overlay-content">
                                            <h3 class="h4 text-white mb-5">{{ row.file.name }}</h3>
                                            <!--<h4 class="h6 text-white-op mb-15">More Details</h4>
                                            <a class="btn btn-sm btn-rounded btn-primary min-width-75" href="{{ route('slider.edit.image', ['path' => $image->image, 'type' => 'slider', 'id' => $slider->id]) }}">
                                                <i class="fa fa-thumbs-up"></i> Uredi
                                            </a>
                                            <a href="#" class="btn btn-sm btn-rounded btn-danger min-width-75" onclick="ShouldDeleteImage('{{ json_encode(['id' => $image->id, 'path' => $image->image, 'type' => 'slider', 'type_id' => $slider->id]) }}')">
                                                <i class="fa fa-thumbs-up"></i> Obriši
                                            </a>-->
                                        </div>
                                    </div>
                                </div>

                                <!--<img class="preview" :src="row.file_url">-->
                            </div>

                            <div class="row mb-30 mt-20">
                                <div class="col-6">
                                    <label class="fileContainer">
                                        {{ row.file.name }}
                                        <input type="file" @change="setFilename" :id="index" accept="image/*">
                                    </label>
                                </div>
                                <div class="col-1 pt-5 text-right">
                                    <verte v-model="row.text_color" picker="square" model="hex"></verte>
                                </div>
                                <div class="col-5 pt-5">
                                    <label>Choose Text Color</label>
                                </div>
                            </div>

                            <div class="form-group mb-20">
                                <label>Text Placement</label>
                                <v-select :options="text_placement" v-model="row.text_placement" class="bottommargin-sm"></v-select>
                            </div>

                            <div class="form-group mb-20">
                                <label>Message Title</label>
                                <input type="text" class="form-control" v-model="row.message_title" placeholder="Type short message title">
                            </div>

                            <div class="form-group mb-20">
                                <label>Title</label>
                                <input type="text" class="form-control" v-model="row.title" placeholder="Type short title">
                            </div>

                            <div class="form-group mb-20">
                                <label>Subtitle</label>
                                <input type="text" class="form-control" v-model="row.subtitle" placeholder="Type short description">
                            </div>

                            <div class="form-group mb-30">
                                <label>Button Text</label>
                                <input type="text" class="form-control" v-model="row.button" placeholder="Type short button text">
                            </div>

                            <div class="form-group mb-30">
                                <label>URL Link</label>
                                <input type="text" class="form-control" v-model="row.url" placeholder="Type URL link of the slider">
                            </div>

                            <div class="col-4" v-if="rows.length > 0">
                                <button @click="RemoveRow(index)" class="btn btn-block btn-warning"><i class="glyphicon glyphicon-plus"></i><span>Obriši Slider</span></button>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-30 mt-20">
                        <div :class="rows.length > 0 ? 'col-12' : 'col-12'">
                            <a href="javascript:;" @click="AddRow()" class="btn btn-block btn-success">
                                <i class="si si-plus"></i>
                                <span>{{ rows.length < 1 ? 'Dodaj Slider Fotografiju' : 'Dodaj drugu Slider Fotografiju'}}</span>
                            </a>
                        </div>
                    </div>

                    <div class="row mb-30" v-if="rows.length > 0">
                        <div class="col-12 text-right">
                            <hr>
                            <a href="javascript:;" @click="SaveSliders()" class="btn btn-primary">
                                <i class="si si-plus"></i> Save Sliders
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            upload_url: String,
            get_url: String,
            group: String
        },
        //
        data() {
            return {
                rows: [{
                    message_title: "",
                    title: "",
                    subtitle: '',
                    button: '',
                    url: '',
                    back_color: '#e32b2b',
                    text_placement: 'Left',
                    file: {
                        name: 'Odaberi Slider Fotografiju'
                    },
                    file_url: ''
                }],
                colors: {},
                text_placement: ['Left', 'Center', 'Right']
            }
        },
        //
        mounted() {
            this.Setup()
        },
        //
        methods: {
            /**
             * Setup autocomplete functions.
             *
             * @constructor
             */
            Setup() {
                let cx = this

                axios.get(cx.get_url)
                    .then(r => {
                        if (r.data.length) {
                            cx.rows = [];

                            for (let i = 0; i < r.data.length; i++) {
                                let imagename = r.data[i].image.slice(r.data[i].image.lastIndexOf('/') + 1)

                                cx.rows.push({
                                    message_title: r.data[i].message,
                                    title: r.data[i].title,
                                    subtitle: r.data[i].subtitle,
                                    button: r.data[i].button,
                                    url: r.data[i].url,
                                    text_color: r.data[i].text_color,
                                    text_placement: r.data[i].text_placement,
                                    file: {
                                        name: imagename
                                    },
                                    file_url: r.data[i].baseimage,
                                    filename: imagename
                                })
                            }
                        }
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },


            /**
             * Add row to sliders.
             *
             * @constructor
             */
            AddRow() {
                this.rows.push({
                    message_title: "",
                    title: "",
                    subtitle: '',
                    button: '',
                    url: '',
                    text_color: '#e32b2b',
                    text_placement: 'Left',
                    file: {
                        name: 'Promijeni Slider Fotografiju'
                    },
                    file_url: ''
                })
            },


            /**
             * Remove row from sliders.
             *
             * @constructor
             */
            RemoveRow(index) {

                this.rows.splice(index, 1)
            },


            /**
             * Set image file and preview.
             *
             * @constructor
             */
            setFilename(event) {
                let file = event.target.files[0]
                this.rows[Number(event.target.id)].file = file
                this.rows[Number(event.target.id)].filename = file.name

                let reader = new FileReader()
                let cx = this

                reader.onload = e => {
                    cx.rows[Number(event.target.id)].file_url = e.target.result
                }

                reader.readAsDataURL(file)
            },


            /**
             * Save sliders.
             *
             * @constructor
             */
            SaveSliders() {
                let cx = this

                console.log(this.rows)

                axios.post(cx.upload_url, {data: cx.rows, group: cx.group})
                    .then(r => {
                        console.log(r.data)
                        /*if (r.data.success) {
                          location = this.redirect + '/' + r.data.response
                        }*/
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
        }
    };
</script>

<style>
    .fileContainer {
        overflow: hidden;
        position: relative;
    }

    .fileContainer [type=file] {
        cursor: inherit;
        display: block;
        font-size: 999px;
        filter: alpha(opacity=0);
        min-height: 34px;
        min-width: 100%;
        opacity: 0;
        position: absolute;
        right: 0;
        text-align: right;
        top: 0;
    }

    .fileContainer {
        background: #E3E3E3;
        float: left;
        padding: .5em 1.5rem;
        height: 34px;
    }

    .fileContainer [type=file] {
        cursor: pointer;
    }


    img.preview {
        width: 200px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
    }
</style>
