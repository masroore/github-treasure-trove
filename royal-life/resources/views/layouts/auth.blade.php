<!DOCTYPE html>
<html lang="es">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Valdusoft admin">
    <meta name="keywords" content="Valdusoft">
    <meta name="author" content="Valdusoft">

    <title>Royal Life</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/royal_green/logos/favicon_royal.png') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    @include('layouts.componenteAuth.styles')

</head>

<body>
    @yield('content')
    @include('layouts.componenteAuth.scripts')
</body>

</html>
