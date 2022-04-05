<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/icon.png') }}">
        <link rel="mask-icon" href="{{ asset('img/icon.png') }}" color="#5bbad5">

        <script src="{{ asset('js/jquery/jquery-3.6.0.min.js') }}"></script>

        <!-- CSS only -->
        <link href="{{ asset('css/boostrap_css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2/select2.css') }}">
        <link href="{{ asset('css/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/datepicker/bootstrap-datepicker.css') }}">

        <script src="{{ asset('js/jqueryForm/jquery.form.min.js') }}"></script>

        <script src="{{ asset('js/formValidate/jquery.validate.min.js') }}"></script>
        @if (app()->getLocale()!= 'en')
        <script src="{{ asset('js/formValidate/messages_'.app()->getLocale().'.js') }}"></script>
        @endif

        <!-- JavaScript Bundle with Popper -->
        <script src="{{ asset('js/boostrap/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('js/select2/select2.js') }}"></script>
        <script src="{{ asset('js/select2/select2.'.app()->getLocale().'.js') }}"></script>


        <script src="{{ asset('js/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('js/toastr/toastr.min.js') }}"></script>

        <script src="{{ asset('js/datatables/datatables.min.js') }}"></script>  
        <script src="{{ asset('js/datepicker/bootstrap-datepicker.js') }}"></script>    

        <script defer src="{{ asset('js/fontAwesome/all.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <title>{{ config('app.name') }}</title>
    </head>
    <body class="{{Auth::user()->theme_name}}" oncontextmenu="return false;">
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{asset('img/logo.png')}}" alt=“logo”>           
                <span>Firstswitch</span>
            </div>
            <div class="menu-bar"><i class="fa fa-list"></i></div>
        </div>   
        <div class="main-content">
            <header>
                <img alt=“header-logo” class="header-logo" src="{{asset('img/logo.png')}}">
                <h3>
                    @yield('title')
                </h3>
                <div class="border-btn"></div>
                <div class="btn-group">
                    <button class="model-drop btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-img">
                            <img style="max-width:40px" alt="avatar" src="{{asset('avatar/'.Auth::user()->avatar)}}" />
                        </div>
                    </button>
                    <ul class="model-dropdown dropdown-menu">
                        <div class="local-user">
                            <div class="name-user">{{ Auth::user()->username }}</div>
                            <div class="rol-user">{{ Auth::user()->name_user.' '.Auth::user()->surname_user}}</div>
                        </div>
                        <div class="sub-title">{{__('Tema')}}</div>
                        <button class="switch" id="switch">
                            <span title="{{__('light')}}" class="back"></span>
                            <span title="{{__('dark')}}"></span>
                        </button>
                        <div class="data-user">
                            <li>
                                <div class="language-option">
                                    @if(App::getLocale() == 'en')
                                    <a href="{{route('language', 'es')}}">
                                        <span class="fas fa-language"></span>
                                        <span>{{ __('Spanish') }}</span>
                                    </a>
                                    @else
                                    <a href="{{route('language', 'en')}}">
                                        <span class="fas fa-language"></span>
                                        <span>{{ __('English') }}</span>
                                    </a>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <a href="logout">
                                    <span class="fa fa-power-off"></span>
                                    <span>{{ __('Log Out') }}</span>
                                </a>
                            </li>
                        </div>
                    </ul>
                </div>
            </header>
            <main>
                @yield('content')
            </main>
        </div>
        <script type="text/javascript">
            document.oncontextmenu = function () {
                return false;
            }
            var translation_msg = {
                "very_weak"      : "{{__('very weak')}}",
                "weak"           : "{{__('weak')}}",
                "medium"         : "{{__('medium')}}",
                "average"        : "{{__('average')}}",
                "strong"         : "{{__('strong')}}",
                "pass_not_match" : "{{__('Password not match')}}",    
                "confirmed"      : "{{__('Confirmed')}}",  
            }
            var URL_LANGUAJE_DATATABLE = "{{ asset('js/datatables/'.app()->getLocale().'.json') }}";
            $(function (){
                @if (session()->get('currentModule') != null)
                    $("#link_{{session()->get('currentModule')}}").click();
                @endif

                @if(Session::has('msg'))
                    toastr['{{ Session::get('msg')['type'] }}']('{{ Session::get('msg')[__('message')] }}');
                @endif

            });
            function loadingWait(params){

                Swal.fire({
                    title: '{{__("Please Wait ... !")}}',
                    html: '{{__("Processing Data")}}',
                    allowOutsideClick: false, showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            }
        </script>
    </body>
</html>

