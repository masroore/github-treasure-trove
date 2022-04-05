@extends('dashboard.authBase')

@section('css')
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ladda-themeless.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container" style="display:none">
  <div class="row justify-content-center">
    @if(isset($email_exists))
    <h1>Ya haz generado una prueba</h1>
    @endif
    @if(isset($can_informe))
    <h1>Tu reporte pronto estará disponible</h1>
    @endif
    <a href="https://birs.ai">
      <div class="text-center">
        <img src="{{ url('/assets/brand/Birs_logo_800_white_orange_v2.png') }}" alt="Birs Logo" style="width:50%;">
      </div>
    </a>
  </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/coreui-utils.js') }}"></script>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  const env_url_base = "{{ env('APP_URL') }}";
  $(function(){
    $(".container").fadeIn(1000);
  });
</script>

@endsection