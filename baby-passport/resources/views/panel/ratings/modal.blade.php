<form data-action="" method="POST" id="ratingForm" autocomplete="off">
    <div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModal"
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
                        <label for="color" class="label text-ce-soir">Nº Estrellas</label>
                        <select name="star_number" class="selectpicker form-control" data-live-search="true">
                            <option value="">Seleccione un color</option>
                            <option value="1" data-content="<i class='fas fa-star text-selective-yellow'>" ></option>
                            <option value="2" data-content="<i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'>" ></option>
                            <option value="3" data-content="<i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'>" ></option>
                            <option value="4" data-content="<i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'>" ></option>
                            <option value="5" data-content="<i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'> <i class='fas fa-star text-selective-yellow'>" ></option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="category" class="label text-ce-soir">Rating</label>
                        <input type="text" class="form-control btn-full-rounded" name="rating_description" required>
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
