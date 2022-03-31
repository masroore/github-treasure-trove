<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div v-for="(block, index) in blocks" :class="'col-sm-12 col-md-' + blockSize + ' mb-20'" :ref="index">
                    <div class="row col" :id="'info_' + index"></div>
                    <div class="row">
                        <div :class="'col-sm-12 col-md-' + imageSize">
                            <canvas :id="'preview_' + index" width="150" style="display:none"></canvas>
                            <label :for="'file_' + index" class="custom-file-upload">
                                <i class="fa fa-file-o mr-5"></i> Učitaj Dokument
                            </label>
                            <input type="file"
                                   :name="'block_doc_files[' + index + '][file]'" :id="'file_' + index"
                                   @change="uploadPDF($event, index)"
                                   accept="application/pdf,
                                   application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                                   application/msword,
                                   application/vnd.ms-excel,
                                   application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                                   application/zip,
                                   application/vnd.rar"/>
                        </div>
                        <div :class="'col-sm-12 col-md-' + (12 - imageSize)">
                            <div class="row">
                                <div class="col-sm-12 mb-10">
                                    <input type="text" class="form-control" v-model="block.title" :name="'blocks_docs[' + index + '][title]'" placeholder="Naslov dokumenta...">
                                    <input type="hidden" :name="'blocks_docs[' + index + '][id]'" v-model="block.id">
                                    <input type="hidden" :name="'blocks_docs[' + index + '][image]'" v-model="block.image">
                                </div>
                                <div class="col-sm-12 mb-10">
                                    <textarea class="form-control" rows="5" v-model="block.description" :name="'blocks_docs[' + index + '][description]'" placeholder="Kratak opis dokumenta..."></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-form-label">Poredak</div>
                                        <div class="col-sm-6 col-md-3">
                                            <input type="text" class="form-control" v-model="block.sort_order" :name="'blocks_docs[' + index + '][sort_order]'" placeholder="Set sort order...">
                                        </div>
                                        <div class="col-sm-12 col-md-3 text-right">
                                            <a href="#" @click.prevent="deleteBlock(block, index)" :class="'btn btn-square btn-block ' + block.deleteClass + ' mr-5 mb-5'">{{ block.deleteLabel }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-30">
                <div class="col-sm-12">
                    <a href="#" @click.prevent="addNewBlock" class="btn btn-square btn-outline-dark mr-5 mb-5">
                        <i class="fa fa-wifi mr-5"></i> Dodaj Novi Dokument
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        //
        props: {
            hasBlocks: {
                type: Object,
                required: false,
                default: null,
            },
            resourceId: {
                type: [String, Number],
                required: false,
                default: null,
            },
            deleteUrl: {
                type: String,
                required: false,
                default: window.location.origin + '/admin/apiv1/products/destroy-block',
            },
            blockSize: {
                type: [String, Number],
                required: false,
                default: 6,
            },
            imageSize: {
                type: [String, Number],
                required: false,
                default: 4,
            }
        },
        //
        data () {
            return {
                blocks: []
            }
        },
        //
        mounted () {
            if (this.hasBlocks) {
                this.hasBlocks = JSON.parse(this.hasBlocks);

                this.init();
            }
        },
        //
        methods: {
            //
            init() {
                this.hasBlocks.forEach((item) => {
                    this.blocks.push({
                        id: item.id,
                        product_id: this.resourceId ? this.resourceId : 0,
                        title: item.title,
                        description: item.description,
                        sort_order: item.sort_order,
                        image: item.path,
                        new: false,
                        deleteLabel: 'Obriši',
                        deleteClass: 'btn-outline-danger',
                    });
                });

                let cx = this;
                setTimeout(() => {
                    for (let i = 0; i < this.blocks.length; i++) {
                        if (this.blocks[i].image.substr(-3, 3) === 'pdf') {
                            import('pdfjs-dist/webpack').then((pdfjs) => {
                                pdfjs.getDocument(window.location.origin + '/' + this.blocks[i].image).then((item) => {
                                    item.getPage(1).then(page => {
                                        let preview = document.getElementById('preview_0');

                                        let info = document.getElementById('info_' + i);

                                        info.style['margin-bottom'] = "10px";
                                        info.innerHTML = this.blocks[i].image.substr(this.blocks[i].image.lastIndexOf('/') + 1) +
                                            ' /&nbsp;<b>' + this.humanFileSize(item._transport._lastProgress.total) + '</b>';

                                        let scale_required = preview.width / page.getViewport(1).width;
                                        let viewport = page.getViewport(scale_required);
                                        preview.height = viewport.height;

                                        let renderContext = {
                                            canvasContext: preview.getContext('2d'),
                                            viewport: viewport
                                        };

                                        preview.toBlob(blob => {
                                            let reader = new FileReader();
                                            reader.readAsDataURL(blob);
                                            /*reader.onloadend = () => {
                                                cx.blocks[i].image = reader.result;
                                            }*/
                                        });

                                        page.render(renderContext).then(response => {
                                            preview.style.display = 'inline-block';
                                        });
                                    });

                                    return item
                                })
                            });
                        } else {
                            let info = document.getElementById('info_' + i);

                            info.style['margin-bottom'] = "10px";
                            info.innerHTML = this.blocks[i].image.substr(this.blocks[i].image.lastIndexOf('/') + 1);
                        }
                    }
                }, 1000)
            },
            //
            //
            uploadPDF(event, index) {
                let file = event.target.files[0];

                if (file.size > 100*1024*1024) {
                    confirmPopUp.fire({ title: 'Greška..!', text: 'Veličina mora biti manja od 100 MB.', type: 'warning' })
                    return;
                }

                let info = document.getElementById('info_' + index);

                info.style['margin-bottom'] = "10px";
                info.innerHTML = file.name + ' /&nbsp;<b>' + this.humanFileSize(file.size) + '</b>';

                let cx = this;
                if (file.type === 'application/pdf') {
                    let preview = document.getElementById('preview_' + index);

                    import('pdfjs-dist/webpack').then((pdfjs) => {
                        pdfjs.getDocument(URL.createObjectURL(file)).then((item) => {
                            item.getPage(1).then(page => {
                                let scale_required = preview.width / page.getViewport(1).width;
                                let viewport = page.getViewport(scale_required);
                                preview.height = viewport.height;

                                let renderContext = {
                                    canvasContext: preview.getContext('2d'),
                                    viewport: viewport
                                };

                                preview.toBlob(blob => {
                                    let reader = new FileReader();
                                    reader.readAsDataURL(blob);
                                    reader.onloadend = () => {
                                        cx.blocks[index].image = reader.result;
                                    }
                                });

                                page.render(renderContext).then(response => {
                                    preview.style.display = 'inline-block';
                                });
                            });

                            return item
                        })
                    });
                }


            },
            //
            //
            //
            deleteBlock(block, index) {
                let cx = this;

                axios.post(cx.deleteUrl, { data: block.id })
                    .then(r => {
                        let canvas = document.getElementById('preview_' + index);
                        canvas.parentNode.removeChild(canvas);

                        cx.blocks.splice(index, 1);

                        successToast.fire({
                            text: ' Dokument je uspješno izbrisan.',
                        })
                    })
                    .catch(e => {
                        console.log(e)
                    })
            },
            //
            //
            addNewBlock() {
                let key = this.blocks.length;

                this.blocks.push({
                    id: 0,
                    product_id: this.resourceId ? this.resourceId : 0,
                    title: '',
                    description: '',
                    sort_order: key,
                    image: '',
                    new: true,
                    deleteLabel: 'Obriši',
                    deleteClass: 'btn-outline-danger',
                });

                console.log(this.blocks)
            },
            //
            //
            humanFileSize(bytes, si = true) {
                var thresh = si ? 1000 : 1024;
                if(Math.abs(bytes) < thresh) {
                    return bytes + ' B';
                }
                var units = si
                    ? ['kB','MB','GB','TB','PB','EB','ZB','YB']
                    : ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB'];
                var u = -1;
                do {
                    bytes /= thresh;
                    ++u;
                } while(Math.abs(bytes) >= thresh && u < units.length - 1);
                return bytes.toFixed(1)+' '+units[u];
            }
        }
    };
</script>

<style>
    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        border: none;
        display: inline-block;
        padding: 3px 10px 10px 0;
        cursor: pointer;
        font-size: 12px;
        color: #a00000;
    }
    .custom-file-upload:hover {
        color: black;
    }
</style>
