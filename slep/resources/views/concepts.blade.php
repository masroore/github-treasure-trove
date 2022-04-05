@extends('dashboard.authBase')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ladda-themeless.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container" id="container-onboarding" style="display:none">
  <div class="row justify-content-center">
    <div class="col-md-12 col-sm-12">
        <div class="card">
          <div class="card-body">

              <div class="text-center">
                <img src="{{ url('/assets/brand/Birs_logo_800_white_orange_v2.png') }}" class="rounded mx-auto d-block" alt="Birs Logo" style="width: 5vw;margin-top: -1vw">
              </div>

            <p class="text-muted text-center">Ud. ha seleccionado los conceptos: <strong>{{ $final_concepts }}</strong></p>
            <h5 class="text-center">Por favor seleccione 1 elemento de cada columna...</h5><br>
            <div class="card">
                <div class="card-body">
                  <div class="row">
                  @foreach($final_return as $key => $valor)
                    <div class="col-md-4 col-sm-12" style="margin-bottom:2%;">
                    <p class="text-center"><strong id="concept-{{ $key }}-title">{{ ucfirst($valor->concept) }} </strong></p>
                      <div class="list-group" id="concept-{{ $key }}-list" role="tablist">
                      @if(count($valor->keyword_ideas)>0)
                        @foreach($valor->keyword_ideas as $item)
                          <a class="list-group-item list-group-item-action concept{{ $key }}" id="{{ $item->keywords }}" data-toggle="tab" role="tab" aria-controls="list-home" aria-selected="false">
                            {{ ucfirst($item->keywords) }}
                          </a>
                        @endforeach
                      @else
                          <a class="list-group-item list-group-item-action concept{{ $key }}" id="{{ ucfirst($valor->concept) }}" data-toggle="tab" role="tab" aria-controls="list-home" aria-selected="false">
                            {{ ucfirst($valor->concept) }}
                          </a>
                      @endif
                      </div>
                    </div>
                  @endforeach
                  </div>
                  <div class="row">

                    <!--button id="selectionButton" class="btn btn-block btn-primary" onclick="makeCampaign('{{ $url_base }}')" style="background-color: #B82601;border-color: #B82601;" disabled>
                      <span id="btn_selection_span" style="min-width: 100%;min-height: 100%;display: inline-block; background-color: #B82601;border-color: #B82601;">Seleccionar</span>
                    </button-->
                  </div>
                </div>
              </div>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/coreui-utils.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/spin.min.js') }}"></script>
<script src="{{ asset('js/ladda.min.js') }}"></script>
<script src="{{ asset('js/loading-buttons.js') }}"></script>
<script type="text/javascript">
  const url_base = @json($url_base);
  const final_return = @json($final_return);
  const uid = @json($uid);
  const nc = @json($nombre_campania);
</script>
<script>
  $(function(){
    f1=false;f2=false;f3=false
    var concept0s = document.getElementsByClassName("concept0");
    var concept1s = document.getElementsByClassName("concept1");
    var concept2s = document.getElementsByClassName("concept2");
    document.getElementById("concept-0-title").setAttribute("style", "color:#b8013c;");
    document.getElementById("concept-1-title").setAttribute("style", "color:#B82601;");
    document.getElementById("concept-2-title").setAttribute("style", "color:#b85e01;");
    $("#container-onboarding").fadeIn(1000);

    $('#concept-0-list a,#concept-1-list a,#concept-2-list a').on('click', function (e) {
      if($("#concept-0-list a.active")[0] === undefined){}else{f1=true}
      if($("#concept-1-list a.active")[0] === undefined){}else{f2=true}
      if($("#concept-2-list a.active")[0] === undefined){}else{f3=true}
      if(f1&f2&f3){
        for (var i = 0; i<concept0s.length; i++) {concept0s[i].classList.add("disabled");}
        for (var i = 0; i<concept1s.length; i++) {concept1s[i].classList.add("disabled");}
        for (var i = 0; i<concept2s.length; i++) {concept2s[i].classList.add("disabled");}
        makeCampaign(url_base)}
      });
  });
  function makeCampaign_false(url){
    url+='/campaign_onboarding/'+uid+'&'+nc+'&'+$("#concept-0-list a.active")[0].id+'&'+$("#concept-1-list a.active")[0].id+'&'+$("#concept-2-list a.active")[0].id;
    console.log(url)
  }
  function makeCampaign(url){
    url+='/campaign_onboarding/'+uid+'&'+nc+'&'+$("#concept-0-list a.active")[0].id+'&'+$("#concept-1-list a.active")[0].id+'&'+$("#concept-2-list a.active")[0].id;
    console.log(url)
    $.ajax({                                  
      url: url,       
      type: 'get',
      complete: function () {},
      success: function (response) {
        console.log('Campaña creada!');
        window.location.href=url_base+'/success_onboarding/'
      },
      error: function (jqXHR, exception) {
          if (jqXHR.status === 0) {
              console.log('Not connect.\n Verify Network.');
          } else if (jqXHR.status == 404) {
              console.log('Requested page not found. [404]');
          } else if (jqXHR.status == 500) {
              console.log('Internal Server Error [500].')
          } else if (exception === 'parsererror') {
              console.log('Requested JSON parse failed.');
          } else if (exception === 'timeout') {
              console.log('Time out error.');
          } else if (exception === 'abort') {
              console.log('Ajax request aborted.');
          } else {
              console.log('Uncaught Error.\n' + jqXHR.responseText);
          }
      },
    }); 
  }
</script>

@endsection