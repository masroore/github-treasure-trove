                        <div class="form-group">
                            @if(old('galleryId'))
                                <input type="hidden" value="{{ old('galleryId') }}" id="oldGalleryId"></span>
                            @endif
                            <h4>Gallery Images</h4>
                            <form action="{{ route('admin.products.upload.media') }}" method="POST" id="uploadProductMediaForm" >
                                @csrf
                                <table id="gallery-table"
                                    class="footable table table-stripped table-bordered toggle-arrow-tiny default breakpoint footable-loaded"
                                    data-page-size="8" data-filter="#filter">

                                    <thead>
                                        <tr>
                                            @if(old('galleryId')==null)
                                            <th class="footable-visible">Image</span></th>
                                            <th class="footable-visible">Sort order</span></th>
                                            @endif
                                            <th class="footable-sortable">Action</span></th>
                                        </tr>
                                    </thead>

                                    <tbody id="galleryBody">
                                            @if(isset($productGalleries))
                                                @foreach($productGalleries as $productImage)
                                                    <tr id='{{ $productImage->id }}' style='display: table-row;' class='footable-even'>
                                                        <td class='footable-visible footable-first-column'>
                                                            <img src="{{ asset('images/products/'.$productImage->image) }}" alt="" style="width:100px;">
                                                        </td>
                                                        <td class='footable-visible'>
                                                            {{ $productImage->order }}
                                                        </td>
                                                        <td class='footable-visible footable-last-column'>
                                                            <button type='button' class='btn btn-danger deleteGalleryImage'><i class='fa fa-trash'></i> </button>
                                                            <button type='button' class='btn btn-danger editGalleryImage'><i class='fa fa-pencil'></i> </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                    </tbody>

                                    <tfoot>
                                        <tr style="display: table-row;" class="footable-even">
                                            <td class="footable-visible footable-first-column"></td>
                                            <td class="footable-visible">
                                                <button type="button" name="uploadImagesBtn" form="uploadProductMediaForm" class="btn btn-primary" id="uploadImagesBtn">Upload Images</button>
                                            </td>
                                            <td class="footable-visible footable-last-column">
                                                <button type="button" id="addGalleryImage" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </form>

                        </div>
