@extends('layouts/MasterLogin')
@section('content')

            @if (session()->has('message'))
                    <div class="alert alert-warning my-3">
                        {{ session('message') }}
                    </div>
            @endif
                
            <!--layout-->
            <p>Para configurar tu autenticación por 2FA debes descargar la aplicación GOOGLE AUTENTICATOR, luego escanear el siguiente codigo.<p>
                    
            <img class="my-4 img-fluid" src="data:image/png;base64, {{ $QR_Image }}">
                   
            <div class="text-center">
                <a href="{{ route('form_validacion') }}" class="btn btn-outline-primary btn-lg"> Confirmar vinculación</a>
            </div>    

@endsection


