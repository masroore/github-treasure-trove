<form data-action="" method="POST" id="cityForm" autocomplete="off">
    <div class="modal fade" id="cityModal" role="dialog" aria-labelledby="cityModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-ce-soir" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{Form::hidden(null,null,["id"=>"id"])}}
                    {{Form::hidden('_method',null)}}


                    <div class="form-group">
                        <label for="category" class="label text-ce-soir">Ciudad</label>
                        <input type="text" class="form-control btn-full-rounded" name="city" required>
                    </div>

                    <div class="form-group">
                        <label for="image" class="label text-ce-soir">Imagen Póster</label>
                        {!! Form::file('image', ['id'=>'image']) !!}
                    </div>


                    <div class="form-group mt-3">
                        <label for="image" class="label text-ce-soir">Imagen Sitio web</label>
                        {!! Form::file('bg_image', ['id'=>'bg_image']) !!}

                    </div>


                    <div class="form-group mt-3">
                        <label for="copy" class="label text-ce-soir">Copy Cabecera Sitio Web</label>
                        <textarea class="form-control btn-full-rounded" name="copy"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>

                </div>
            </div>
        </div>
    </div>
</form>
