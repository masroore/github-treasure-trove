@extends('dashboard.errorBase')

@section('content')

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="clearfix">
            <h1 class="float-left display-3 mr-4">404</h1>
            <h4 class="pt-3">Oops! Estas perdido.</h4>
            <p class="text-muted">La página a la que intentas acceder no se encuentra.</p>
          </div>
          <div class="input-prepend input-group">
            <div class="input-group-prepend"><span class="input-group-text">
                <svg class="c-icon">
                  <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-magnifying-glass"></use>
                </svg></span></div>
            <input class="form-control" id="prependedInput" size="16" type="text" placeholder="Que estas buscando?"><span class="input-group-append">
              <button class="btn btn-info" type="button">Buscar</button></span>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('javascript')

@endsection