@push('page_css')
    <style>
        .file-drop-area label {
            display: block;
            padding: 2em;
            border: 1px solid #CCCCCC;
            background-color: #eee;
            text-align: center;
            cursor: pointer;
        }
    </style>
@endpush

<div class="row">
    <div class="col-12">
        <div class="file-drop-area">
            <label for="files">Dodajte fotografije u galeriju...</label>
            <input name="new_gallery_images[][image]" id="files" type="file" multiple>
        </div>
    </div>
</div>
@if (isset($page))
    <div class="row items-push" id="new-images">
        @if (! empty($page->blocks->groupBy('type')['image']))
            @foreach($page->blocks->groupBy('type')['image'] as $key => $block)
                @if ($block->type == 'image')
                    <div class="col-lg-3 col-md-4 animated fadeIn mb-30 py-20" id="{{ 'image_id_' . $block->id }}">
                        <div>
                            <div class="slim"
                                 {{--data-service="{{ route('images.ajax.upload') }}"--}}
                                 data-ratio="16:9"
                                 data-size="1280,720"
                                 data-max-file-size="2"
                                 data-meta-type="image"
                                 data-meta-type_id="{{ $block->page_id }}"
                                 data-meta-image_id="{{ $block->id }}"
                                 data-will-remove="removeImage">
                                <img src="{{ asset($block->path) }}" alt="{{ 'image_' . $block->id }}"/>
                                <input type="file" name="gallery_images[{{ $block->id }}][image]"/>
                            </div>
                        </div>
                        <div class="row form-group mt-10">
                            <label class="col-sm-10 col-md-8 col-form-label" for="bso-{{ $block->id }}">Poredak fotografije</label>
                            <div class="col-sm-2 col-md-4 text-right">
                                <input type="text" class="form-control js-tooltip-enabled" id="bso-{{ $block->id }}" name="gallery_images[{{ $block->id }}][sort_order]" value="{{ $key }}" data-toggle="tooltip" data-placement="top" title="Poredak fotografije">
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@else
    <div class="row items-push" id="new-images"></div>
@endif

@push('page_js')
    <script src="{{ asset('js/plugins/slim/slim.kickstart.js') }}"></script>

    <script>
        //
        let blocks = "{{ (isset($page) && isset($page->blocks->groupBy('type')['image'])) ? count($page->blocks->groupBy('type')['image']) : 0 }}";
        let created_id = 0;
        // get a reference to the file drop area and the file input
        var fileDropArea = document.querySelector('.file-drop-area');
        var fileInput = fileDropArea.querySelector('input');
        var fileInputName = fileInput.name;

        // listen to events for dragging and dropping
        fileDropArea.addEventListener('dragover', handleDragOver);
        fileDropArea.addEventListener('drop', handleDrop);
        fileInput.addEventListener('change', handleFileSelect);

        function handleDragOver(e) {
            e.preventDefault();
        }
        function handleDrop(e) {
            e.preventDefault();
            handleFileItems(e.dataTransfer.items || e.dataTransfer.files);
        }
        function handleFileSelect(e) {
            handleFileItems(e.target.files);
        }

        // loops over a list of items
        function handleFileItems(items) {
            let l = items.length;
            for (let i=0; i<l; i++) {
                handleItem(items[i]);
            }
        }

        function handleItem(item) {
            // get file from item
            let file = item;
            if (item.getAsFile && item.kind == 'file') {
                file = item.getAsFile();
            }

            handleFile(file);
        }

        // now we're sure each item is a file
        function handleFile(file) {
            createCropper(file);
        }

        // create an Image Cropper for each passed file
        function createCropper(file) {
            // create container element for cropper
            let holder = document.getElementById('new-images');

            let col = document.createElement('div');
            col.className = 'col-lg-3 col-md-4 animated fadeIn mb-30 py-20';

            let cropper = document.createElement('div');

            // insert this element after the file drop area
            col.insertAdjacentElement('afterbegin', cropper);
            col.insertAdjacentHTML('beforeend', '<div class="row form-group mt-10">\n' +
                '                            <label class="col-sm-10 col-md-8 col-form-label" for="bso-' + created_id + '">Poredak fotografije</label>\n' +
                '                            <div class="col-sm-2 col-md-4 text-right">\n' +
                '                                <input type="text" class="form-control js-tooltip-enabled" id="bso-' + created_id + '" name="new_gallery_images[' + created_id + '][sort_order]" value="' + blocks + '" data-toggle="tooltip" data-placement="top" title="Poredak fotografije">\n' +
                '                            </div>\n' +
                '                        </div>');

            holder.insertAdjacentElement('beforeend', col);

            // create a Slim Cropper
            Slim.create(cropper, {
                ratio: '16:9',
                size: '1280,720',
                maxFileSize: '2',
                service: false,
                meta: {
                    type: 'image',
                    type_id: "{{ isset($page) ? $page->id : '' }}",
                    image_id: 0
                },
                defaultInputName: fileInputName,
                didInit: function() {
                    // load the file to our slim cropper
                    this.load(file);

                },
                didRemove: function(data, slim) {
                    col.parentNode.removeChild(col)
                    // destroy the slim cropper
                    this.destroy();

                }
            });

            blocks++;
            created_id++;
        }

        function handleXHRRequest(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");

            console.log(fileInput)
        }

        function removeImage(data, slim) {
            if (data.meta.hasOwnProperty('image_id')) {
                axios.post("{{ route('page.block.destroy') }}", { data: data.meta.image_id })
                    .then((response) => {
                        successToast.fire({
                            text: 'Fotografija je uspješno izbrisana',
                        })

                        let elem = document.getElementById('image_id_' + data.meta.image_id);

                        elem.parentNode.removeChild(elem);
                    })
                    .catch((error) => {
                        errorToast.fire({
                            text: ' - Greška u brisanju fotografije..! Molimo pokušajte ponovo.',
                        })
                    })
            } else {
                errorToast.fire({
                    text: 'Glavna slika se ne može izbrisati..!',
                })
            }

            //slim.destroy();
        }

        // hide file input, we can now upload with JavaScript
        fileInput.style.display = 'none';

        // remove file input name so it's value is
        // not posted to the server
        fileInput.removeAttribute('name');
    </script>

@endpush
