{{-- el admin no vera puntos pero si vera el de los demas --}}
@if(Auth::user()->admin == 1 && Route::is('genealogy_type_id') )
    <div class="col-md-6 col-sm-12 text-center">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" d-flex white mt-2">
                            <button class="btn-tree text-left" style="width: 247px;">Puntos Por la Derecha: {{$binario['totald']}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" d-flex white mt-2">
                            <button class="btn-tree text-left" style="width: 247px;">Puntos por la Izquierda: {{$binario['totali']}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- el usuario vera sus puntos pero el de los demas no --}}
@if(Auth::user()->admin == 0 && Route::is('genealogy_type') )
    <div class="col-md-6 col-sm-12 text-center">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" d-flex white mt-2">
                            <button class="btn-tree text-left" style="width: 247px;">Puntos Por la Derecha: {{$binario['totald']}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" d-flex white mt-2">
                            <button class="btn-tree text-left" style="width: 247px;">Puntos por la Izquierda: {{$binario['totali']}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif