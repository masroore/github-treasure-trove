<!-- Vendor CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/vendors.min.css')}}">

<!-- CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/bootstrap-extended.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/colors.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/components.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/dark-layout.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/bordered-layout.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/semi-dark-layout.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/vertical-menu.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/form-validation.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/page-auth.min.css')}}">

<!-- CUSTOM CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/auth/style.css')}}">

<style>
    .auth-inner.row.m-0{
        height: 100vh;
    }
    .legazy_bg{
        background: url("{{ asset('assets/img/legazy_pro/bg.jpg') }}");
        justify-content: center;
        text-align:center;
        background-repeat:no-repeat;
        background-size: cover;
    }
</style>

@stack('custom_css')
