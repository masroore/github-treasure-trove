<form data-action="" method="POST" id="productForm" autocomplete="off">
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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


                    <div id="smartwizard">
                        <ul>
                            <li>
                                <a href="#step-1">Información General</a>
                            </li>
                            <li>
                                <a href="#step-2">Detalles</a>
                            </li>
                            <li>
                                <a href="#step-3">Confirmación</a>
                            </li>

                        </ul>

                        <div>

                            <!--STEP 1 --->
                            <div id="step-1" class="">

                                <div class="step-content-container">
                                    <div class="form-group">
                                        <label for="category" class="label text-ce-soir">Producto</label>
                                        <input type="text"
                                               class="form-control btn-full-rounded"
                                               name="product[product]"
                                               required
                                               data-parsley-group="general">
                                    </div>

                                    <div class="form-group">
                                        <label for="category" class="label text-ce-soir">Descripción</label>
                                        <textarea class="form-control btn-full-rounded"
                                                  name="product[description]"
                                                  data-parsley-group="general"
                                                  ></textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- END STEP 1-->


                            <!-- STEP 2 -->
                            <div id="step-2" class="">

                                <button class="btn btn-ce-soir btn-full-rounded pull-right mb-3" id="addDetail">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>

                                <div class="step-content-container">
                                    <table class="table table-striped table-bordered" id="tbDetailsProduct">
                                        <thead>
                                        <tr>
                                            <th scope="col">Detalle</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                            <!-- END STEP 2-->

                            <!--STEP 3 -->
                            <div id="step-3">
                                <div class="jumbotron text-center bg-light">
                                    <h2 class="text-ce-soir"> Datos del producto capturados correctamente.</h2>
                                    <p class="text-grey-suit">Si desea cambiar información regrese a los pasos
                                        anteriores</p>

                                    <button class="btn btn-ce-soir btn-full-rounded btn-medium">
                                        <i class="fa fa-save"></i> Guardar
                                    </button>
                                </div>
                            </div>
                            <!--END STEP 3 -->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
