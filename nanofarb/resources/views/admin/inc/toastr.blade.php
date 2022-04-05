<script>
    // $(function () {
    //     $('[data-toggle="tooltip"]').tooltip()
    // });
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "6000",
        "extendedTimeOut": "1000",
        "positionClass": "toast-bottom-right"
    }

    @php
        $flashKeys = [
            'warning',
            'success',
            'info',
            'error',
        ]
    @endphp

    @foreach ($flashKeys as $keyName)
        @if (\Illuminate\Support\Facades\Session::has($keyName))
            toastr.{{$keyName}}("{{ \Illuminate\Support\Facades\Session::get($keyName) }}");
        @endif
    @endforeach

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}');
        @endforeach
    @endif
</script>