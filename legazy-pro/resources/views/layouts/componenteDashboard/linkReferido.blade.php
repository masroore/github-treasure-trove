@push('vendor_css')
{{--<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">--}}
<style>
    .swal2-icon.swal2-success .swal2-success-ring{
        border: .25em solid rgba(214,168,62,1) !important;
    }
    
    .swal2-icon.swal2-success [class^=swal2-success-line]{
        background: linear-gradient(90deg, rgba(172,118,19,1) 0%, rgba(214,168,62,1) 94%) !important;
    }

    .swal2-show, .swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left], .swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right], .swal2-icon.swal2-success .swal2-success-fix{
        background: #1b1b1b !important;
    }

    #swal2-title, #swal2-content{
        color: white;
    }
</style>
@endpush

@push('page_vendor_js')
<script src="{{asset('assets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
@endpush

@push('custom_js')
<script>
    function getlink(side) {
        var aux = document.createElement("input");
        aux.setAttribute("value", "{{route('register')}}?referred_id={{Auth::id()}}");
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);

        let lado = (side == 'I') ? 'Izquierda' : 'Derecha'

        Swal.fire({
            title: "Link Copiado = "+lado,
            text: "Ya puedes pegarlo en tu navegador",
            type: "success",
            background: '#1b1b1b',
            confirmButtonClass: 'btn btn-primary',
            buttonsStyling: false,
        }).then(function(result){
                // if (result.value) {
                //     window.location.reload();
                // }
            });
    }
</script>
@endpush
