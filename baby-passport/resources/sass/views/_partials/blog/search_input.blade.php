<form action="{{route("web.getBlogByQuery")}}" method="GET" class="mb-3">


    <div class="card">

        <div class="card-body">

            <h3 class="h3-responsive text-ce-soir">Búsqueda</h3>

            <div class="md-form">
                <input
                        type="text"
                        class="form-control btn-full-rounded"
                        name="query"
                        placeholder="tema,palabra clave,etiqueta...">

            </div>
            <div class="mt-1 float-right clearfix">
                <button type="submit" class="btn btn-ce-soir white-text btn-md">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>


        </div>
    </div>


</form>

