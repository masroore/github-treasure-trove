<!-- Modal -->
<div class="modal fade" id="modalEditServices" tabindex="-1" role="dialog" aria-labelledby="modalEditServicesTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditServicesTitle">Editar Paquetes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" class="form form-vertical" :action="Route" enctype="multipart/form-data">
                    <div class="form-body">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="">Package Name</label>
                                    <input type="text" name="name" class="form-control" required v-model="Service.name">
                                </fieldset>
                            </div>

                            <div class="col-12">
                                <fieldset class="form-group" v-model="Service.img">
                                    <label for="">Imagen</label>
                                    <input type="file" name="img" class="form-control" required accept="image/jpeg, image/png">
                                </fieldset>
                            </div>

                            <div class="col-12">
                                <fieldset class="form-group">
                                <select name="categories_id" class="form-control custom-select"  v-model="Service.categories_id">
                                    <label for="">Categoria</label>
                                    <option value="" disabled selected>Selecione una opcion</option>
                                    @foreach ( $categories as $categoria )

                                    <option value="{{$categoria->id}}">{{$categoria->categories_name}}</option>

                                    @endforeach

                                  </select>
                                </fieldset>
                                </div>



                            <div class="col-12 col-md-6">
                                <fieldset class="form-group">
                                    <label for="">Precio</label>
                                    <input type="number" name="price" class="form-control" required v-model="Service.price" step="any">
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-6">
                                <fieldset class="form-group">
                                    <label for="">Precio Rebajado</label>
                                    <input type="number" name="precio_rebajado" class="form-control" required v-model="Service.precio_rebajado" step="any">
                                </fieldset>
                            </div>

                            <div class="col-12 col-md-6">
                                <fieldset class="form-group">
                                    <label for="">Estado</label>
                                    <select name="status" class="form-control custom-select" v-model="Service.status">
                                        <option value="" disabled selected>Selecione una opcion</option>
                                        <option value="0">Desactivo</option>
                                        <option value="1">Activo</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="">Descripcion</label>
                                    <textarea name="description" class="form-control" id="summernoteEdit"></textarea>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
