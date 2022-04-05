@extends('layouts.app')

@section('content')


<div class="container atention-center-container pb-5">

<h1 class="h1-responsive mb-3 text-spray text-center">CONSULTA TU MÉDICO BABY PASSPORT PARA MÁS INFORMACIÓN</h1>
<div class="text-grey-suit mb-5 lead">Selecciona tu médico más cercano:</div>
<div class="row">

<div class="col-12 col-lg-8">
<div class="pb-5 button-border-maps " id="map"></div>
</div>
<div class="col-12 col-lg-4">
<div class="mapIndex">
</div>
</div>
</div>


</div>


@endsection()


@section('custom_scripts')
<script src="{{asset(mix('js/web/atention-center.js'))}}">

</script>


<script
async
defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCIxFRzwrdGm6GzehPRsesYDxjpSwOqXM&callback=$.renderMap"
></script>

<script>

function mapDoctor() {

   let nameDoctor= document.getElementById("maps-doctor").value

    text = `*Quiero información sobre el doctor* ${nameDoctor} %0a`;
            window.open(
                "https://api.whatsapp.com/send?phone=524428053502" + "&text=" + text
            );
    
            return false;
                
    }

</script>
@endsection()
