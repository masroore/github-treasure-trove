

@push('vendor_css')
{{-- no funciona --}}
@endpush

@push('page_css')
{{-- no funcionas --}}
@endpush

@push('page_vendor_js')
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/app-assets/css/plugins/extensions/toastr.css')}}">
<script src="{{asset('assets/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
@endpush

@if (Session::has('msj-success'))
@push('custom_js')
<script>
    toastr.success("{{Session::get('msj-success')}}", '¡Notificacion!', { "progressBar": true });
</script>
@endpush
@endif

@if (Session::has('msj-info'))
@push('custom_js')
    <script>
        toastr.info("{{Session::get('msj-info')}}", '¡Aviso!', { "progressBar": true });
    </script>
@endpush
@endif

@if (Session::has('msj-warning'))
@push('custom_js')
    <script>
        toastr.warning("{{Session::get('msj-warning')}}", '¡Advertencia!', { "progressBar": true });
    </script>
@endpush
@endif

@if (Session::has('msj-danger'))
@push('custom_js')
    <script>
        toastr.error("{{Session::get('msj-danger')}}", '¡Error!', { "progressBar": true });
    </script>
@endpush
@endif

{{-- mensajes de errores --}}
@if ($errors->any())
@push('custom_js')
<script>
    let msjErrors = '<ul>';
</script>
        @foreach ($errors->all() as $error)
        <script>msjErrors = msjErrors+'<li>{{ $error }}</li>';</script>
        @endforeach
    <script>
        msjErrors = msjErrors+'</ul>';
        toastr.error(msjErrors, '¡Error!', { "progressBar": true });
    </script>
@endpush
@endif