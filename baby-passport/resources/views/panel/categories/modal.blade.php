<form data-action="" method="POST" id="categoryForm" autocomplete="off">
    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModal"
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
                        <label for="category" class="label text-ce-soir">Categoría</label>
                        <input type="text" class="form-control btn-full-rounded" name="category" required>
                    </div>


                    <div class="form-group">
                        <label for="color" class="label text-ce-soir">Color de Fondo</label>
                        <select name="color" class="selectpicker form-control" data-live-search="true">
                            <option value="">Seleccione un color</option>
                            <option value="light" data-content="<span class='badge badge-dark text-light'>Light</span>" ></option>
                            <option value="mandys-pink" data-content="<span class='badge badge-mandys-pink text-light'>Mandys Pink</span>" ></option>
                            <option value="spray" data-content="<span class='badge badge-spray text-light'>Spray</span>" ></option>
                            <option value="ice-cold" data-content="<span class='badge badge-ice-cold text-light'>Ice Cold</span>" ></option>
                            <option value="ce-soir" data-content="<span class='badge badge-ce-soir text-light'>Ce Soir</span>" ></option>
                            <option value="grey-suit" data-content="<span class='badge badge-grey-suit text-light'>Grey Suit</span>" ></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="text_color" class="label text-ce-soir">Color de Texto</label>
                        <select name="text_color" class="selectpicker form-control" data-live-search="true">
                            <option value="">Seleccione un color</option>
                            <option value="light" data-content="<span class='badge badge-dark text-light'>Light</span>" ></option>
                            <option value="grey-suit" data-content="<span class='badge badge-light text-grey-suit'>Grey Suit</span>" ></option>
                        </select>
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
