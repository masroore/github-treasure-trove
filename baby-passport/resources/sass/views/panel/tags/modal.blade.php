<form data-action="" method="POST" id="tagForm" autocomplete="off">
    <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="tagModal" aria-hidden="true">
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
                        <label for="exampleInputEmail1" class="label text-ce-soir">Etiqueta</label>
                        <input type="text" class="form-control btn-full-rounded" name="tag" required>
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
