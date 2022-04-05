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
        <link href="{{ asset('css/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" >
		<link href="{{ asset('css/boostrap_css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/fontawesome/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/normalize.css') }}" rel="stylesheet" >
        <link href="{{ asset('css/main.css') }}"  rel="stylesheet">
        <link href="{{ asset('css/select2/select2.css') }}"  rel="stylesheet">
        <link href="{{ asset('css/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/toastr/toastr.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/datepicker/bootstrap-datepicker.css') }}"  rel="stylesheet">
        <link href="{{ asset('css/autoComplete/jquery-ui.min.css') }}"  rel="stylesheet">
        <link href="{{ asset('css/daterangepicker/daterangepicker.css') }}"  rel="stylesheet">

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
        <script src="{{ asset('js/alphaNum/jquery.alphanum.js') }}"></script>    
        <script src="{{ asset('js/fontAwesome/brands.min.js') }}"></script>
        <script src="{{ asset('js/autoComplete/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('js/inputmask/jquery.inputmask.js') }}"></script> 
        <script src="{{ asset('js/inputmask/jquery.maskMoney.min.js') }}"></script> 
        <script src="{{ asset('js/daterangepicker/moment.min.js') }}"></script> 
        <script src="{{ asset('js/daterangepicker/daterangepicker.js') }}"></script> 
        <script src="{{ asset('js/highcharts/highcharts.js') }}"></script> 
        <script src="{{ asset('js/highcharts/highcharts-more.js') }}"></script>
        <script src="{{ asset('js/iconpicker/iconpicker.js') }}"></script>  
        
        <script src="{{ asset('js/main.js') }}"></script>
        <title>{{ config('app.name') }}</title>

    </head>

    <body class="{{Auth::user()->theme_name}}" >	
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{asset('img/logo.png')}}">           
                <span>Firstswitch</span>
            </div>
            <div class="menu-bar"><i class="fa fa-list"></i></div>
            <div class="sidebar-menu">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed noneed" type="button" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                <a id="home" class="current" href="{{url('/home')}}">
                                    <i class="fa fa-home"></i>
                                    <span>{{ __('Home') }}</span>
                                </a>
                            </button>
                        </h2>
                    </div>				
                    @foreach($Menu as $value)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo{{$value['id']}}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo{{$value['id']}}" aria-expanded="false" aria-controls="flush-collapseTwo{{$value['id']}}">
                                <a><i class="fa {{ $value['icon'] }}"></i> <span>{{__('menu.'.$value['name_menu'])}}</span></a>
                            </button>
                        </h2>
                        <div id="flush-collapseTwo{{$value['id']}}" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo{{$value['id']}}" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                @foreach($value['process'] as $value2)
                                {{--<a id="link_{{$value2['route']}}" class="menu-item" title="{{__('menu.'.$value2['description'])}}" onClick="getMenuAction('')" href="{{route($value2['route'])}}"><span>{{__('menu.'.$value2['name_process'])}}</span></a> --}}
								<a id="link_{{$value2['route']}}" class="menu-item" title="{{__('menu.'.$value2['description'])}}" onClick="getMenuAction(this, '{{route($value2['route'])}}')" href="#"><span>{{__('menu.'.$value2['name_process'])}}</span></a> 
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>   
        <div class="main-content">

            <header>
                <img class="header-logo" src="{{asset('img/logo.png')}}">

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
                            <div class="rol-user"><i class="fa fa-user"></i><span>{{ Auth::user()->name_user.' '.Auth::user()->surname_user}}</span></div>
                            <div class="rol-user"><i class="fa fa-id-card"></i><span>{{ Auth::user()->storage ['name_storage']}}</span></div>
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
                                        <i class="fas fa-language"></i>
                                        <span>{{ __('Spanish') }}</span>
                                    </a>

                                    @else

                                    <a href="{{route('language', 'en')}}">
                                        <i class="fas fa-language"></i>
                                        <span>{{ __('English') }}</span>
                                    </a>

                                    @endif
                                </div>
                            </li>
                            <li>
                                <a href="logout">
                                    <i class="fa fa-power-off"></i>
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

            <div class="footer">
                2021 &#169; Desing By Corporaci&oacute;n Puro Pago C.A.
            </div>

        </div>
		
        <script type="text/javascript">
            var rangepicker_apply  = "{{__('Accept')}}";
            var rangepicker_cancel = "{{__('Cancel')}}";
            var rangepicker_days   = [
                "{{__('Su')}}",
                "{{__('Mo')}}",
                "{{__('Tu')}}",
                "{{__('We')}}",
                "{{__('Th')}}",
                "{{__('Fr')}}",
                "{{__('Sa')}}"
            ];
            var rangepicker_months = [            
                "{{__('January')}}",
                "{{__('February')}}",
                "{{__('March')}}",
                "{{__('April')}}",
                "{{__('May')}}",
                "{{__('June')}}",
                "{{__('July')}}",
                "{{__('August')}}",
                "{{__('September')}}",
                "{{__('October')}}",
                "{{__('November')}}",
                "{{__('December')}}"
            ];
			
			@if (env('APP_DEBUG')==false)
				
				eval("setInterval(function(){ debugger; },  1000)"); 
				
				document.oncontextmenu = function () {
					return false;
				}
				$(document).keydown(function(event) {
					if (!event.ctrlKey){ return true; }
					event.preventDefault();
				});
				
				$("body").keydown(function(e){
					//well so you need keep on mind that your browser use some keys 
					//to call some function, so we'll prevent this
					//now we caught the key code.
					//your keyCode contains the key code, F1 to F12 
					//is among 112 and 123. Just it.
					var keyCode = e.keyCode || e.which;
					if (keyCode==123){
						e.preventDefault();		
					}
				});
			@endif
			
			
            var MSG_VALIDATION = "{{__('Please Check the Form')}}";
            var URL_LANGUAJE_DATATABLE = "{{ asset('js/datatables/'.app()->getLocale().'.json') }}";

            @if (Session::has('msg'))
            toastr["{{ Session::get('msg')['type'] }}"]("{{ Session::get('msg')[__('message')] }}");
            @endif
            $(document).ready(function () {
                $('body').on('click', function (e){
                    $('.sidebar.hide .collapse').removeClass('show');
                });
                idleLogout();
				@if (session()->get('currentModule') != null)
                    $("#link_{{session()->get('currentModule')}}").click();
                @endif
            });
            function loadingWait(params) {
                Swal.fire({
                    title: '{{__("Please Wait ... !")}}',
                    html: '{{__("Processing Data")}}',
                    allowOutsideClick: false, showConfirmButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
            }

            function idleLogout() {
                var time = {{ Auth::user()->time_inactivity }};
                var t;
                var time_remaing = 0;
                var time_out = time; // value in seconds
                window.onload = resetTimer;
                window.onmousemove = resetTimer;
                window.onmousedown = resetTimer; // catches touchscreen presses as well      
                window.ontouchstart = resetTimer; // catches touchscreen swipes as well 
                window.onclick = resetTimer; // catches touchpad clicks as well
                window.onkeypress = resetTimer;
                window.addEventListener('scroll', resetTimer, true); // improved; see comments

                var myVar = setInterval(myTimer, 1000);
                function myTimer() {
                    time_remaing++;
                    if (time_remaing == time_out) {
                        Swal.fire({
                            title: "{{ __('Do you want to extend the session?') }}",
                            icon: 'question',
                            showDenyButton: true,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            confirmButtonText: "{{ __('Yes') }}",
                            confirmButtonColor: "var(--color-primary)",
                            denyButtonText: "{{ __('No') }}",
                            denyButtonColor: "var(--bs-gray)"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                resetTimer();
                                $.get('{{route("extend_login")}}', function (response) {
                                }, 'json');
                            } else if (result.isDenied) {
                                clearInterval(myVar);
                                $.get('{{route("logout")}}', function (){ window.location.reload();});
                            }
                        });
                    }
                    if (time_remaing == (time_out + 10)) {
                        clearInterval(myVar);
                        Swal.close();
                        $('#reLogin').modal('show');
                        $.get('{{route("end_login")}}', function (response) {
                            $('#reLoginBody').html(response);
                        }, 'html').fail(function (){  window.location.reload(); });
                    }
                }
                function resetTimer() {
                    time_remaing = 0;
                }
            }
        </script>
		

		<!-- Modal -->
		<div class="modal fade" id="reLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div id="reLoginBody" class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">{{__('Login')}}</h5>
						
					</div>
					<div  class="modal-body">
						<div class="fa-3x">
						  
						  <i class="fas fa-spinner fa-pulse"></i>
						  
						</div>
					</div>
					<div class="modal-footer">
						
						
					</div>
				</div>
			</div>
		</div>
    </body>
</html>

