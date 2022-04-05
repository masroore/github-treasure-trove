<!DOCTYPE html>
<html lang="en">
    <!--begin::Head-->
    <head><base href="">
        <meta charset="utf-8" />
        <title>GSA</title>
        <meta name="description" content="Updates and statistics" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="canonical" href="https://keenthemes.com/metronic" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Page Vendors Styles(used by this page)-->
        <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles-->
        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/devextreme/21.1.5/css/dx.light.css" rel="stylesheet">
        {{-- <link data-theme="generic.light" href="{{ asset('assets/plugins/devex/css/dx.light.css')}}" data-active="true"/>
        <link href="{{ asset('assets/plugins/devex/css/dx.common.css')}}"/> --}}
        <link rel="stylesheet" href="{{asset('assets/gsa/fa/css/font-awesome.min.css')}}">
        <!--end::Global Theme Styles-->
        <!--begin::Layout Themes(used by all pages)-->
        <!--end::Layout Themes-->
        <style type="text/css">
            .exs{
              background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='%23505050D1' stroke-width='4' stroke-dasharray='14%2c 23%2c 16' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e");
            }
            td.details-control {
    background: url('{{ asset("assets/img/icon/details_open.png") }}') no-repeat center center;
    cursor: pointer;
}
tr.details td.details-control {
    background: url('{{ asset("assets/img/icon/details_close.png") }}') no-repeat center center;
}
            
.exs{
              background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='%23505050D1' stroke-width='4' stroke-dasharray='14%2c 23%2c 16' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e");
            }
        </style>
    </head>
@php
$level = 'admin';
if(Auth::user()->level == 2):
    $level = 'customer';
elseif(Auth::user()->level == 3):
    $level = 'agen';
elseif(Auth::user()->level == 4):
    $level = 'kurir';
endif;
@endphp
    <!--end::Head-->
    <!--begin::Body-->
    <body id="kt_body" class="header-fixed header-mobile-fixed page-loading">
        <!--begin::Main-->
        <!--begin::Header Mobile-->
        <div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
            <!--begin::Logo-->
            <a href="{{ url('/') }}">
                <img alt="Logo" src="{{ asset('assets/img/sigis.png') }}" class="max-h-40px" />
            </a>
            <div class="topbar-item">
                <div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <div class="d-flex flex-column text-right pr-3">
                        <span class="text-white opacity-100 font-weight-bold font-size-xs d-md-inline">{{ $level }}</span>
                        <span class="text-white font-weight-bolder font-size-xs d-md-inline">{{ Auth::user()->username }}</span>
                    </div>
                    <span class="symbol symbol-35">
                        <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30"><i class="fa fa-user text-white"></i></span>
                    </span>
                </div>
            </div>
            <!--end::Logo-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_topbar_toggle">
                    <span></span>
                </button>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Header Mobile-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->
                    <div id="kt_header" class="header flex-column header-fixed">
                        <!--begin::Top-->
                        <div class="header-top" style="background-color:white;">
                            <!--begin::Container-->
                            <div class="container">
                                
                                <!--begin::Left-->
                                <div class="d-none d-lg-flex align-items-center mr-3">
                                    
                                    
                                    <div class="topbar-item">
										<div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
											<div class="d-flex flex-column text-right pr-3">
												<span class="text-success opacity-100 font-weight-normal font-size-sm d-none d-md-inline">{{ $level }}</span>
												<span class="text-success font-weight-bolder font-size-md d-none d-md-inline">{{ Auth::user()->username }}</span>
											</div>
											<span class="symbol symbol-35">
												<span class="symbol-label font-size-h5 font-weight-bold text-success bg-white-o-30"><i class="fa fa-user text-success"></i></span>
											</span>
										</div>
									</div>
                                    <!--begin::Logo-->
                                    <a href="{{ url('/') }}" class="mr-20">
                                        {{-- <img alt="Logo" src="{{ asset('assets/img/sigis.png') }}" class="max-h-65px" /> --}}
                                    </a>
                                    <!--end::Logo-->
                                    <!--begin::Desktop Search-->
                                    <!--end::Desktop Search-->
                                </div>
                                <!--end::Left-->
                                <!--begin::Topbar-->
                                <div class="topbar">
                                    <!--begin::My Cart-->
                                    <div class="dropdown">
                                        <!--begin::Toggle-->
                                        <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                            <div class="btn btn-icon btn-outline-success btn-sm mr-2">
                                                <span class="svg-icon svg-icon-xl"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo2\dist/../src/media/svg/icons\Communication\Address-card.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <rect x="0" y="0" width="24" height="24"/>
            <path d="M6,2 L18,2 C19.6568542,2 21,3.34314575 21,5 L21,19 C21,20.6568542 19.6568542,22 18,22 L6,22 C4.34314575,22 3,20.6568542 3,19 L3,5 C3,3.34314575 4.34314575,2 6,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"/>
        </g>
    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </div>
                                        </div>
                                        @if(Request::url() !== $urls)
                                        <div class="topbar-item">
                                         <a class="btn btn-icon btn-outline-primary w-auto d-flex align-items-center px-2" href="{{ url()->previous() }}">
                                            <div class="d-flex flex-column text-right pr-3">
                                                <span class="font-size-sm d-none d-md-inline">Kembali</span>
                                            </div>
                                            <span class="symbol symbol-35">
                                                <span class="symbol-label bg-white-o-30"> <i class="flaticon2-back"></i></span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="topbar-item ml-2">
                                        <a class="btn btn-icon btn-outline-primary w-auto d-flex align-items-center px-2" href="{{ url('/')  }}">
                                           <span class="symbol symbol-35">
                                               <span class="symbol-label bg-white-o-30">  <i class=" mb-10 mt-10 fa fa-home" aria-hidden="true"></i></span>
                                           </span>
                                       </a>
                                   </div>
                                         @endif
                                        <!--end::Toggle-->
                                        <!--begin::Dropdown-->
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-xl dropdown-menu-anim-up">
                                                <!--begin::Header-->
                                                <div class="d-flex align-items-center py-10 px-8 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url({{asset('assets/media/misc/bg-1.jpg')}})">
                                                    <span class="btn btn-md btn-icon bg-white-o-15 mr-4">
                                                        <i class="flaticon-user text-success"></i>
                                                    </span>
                                                    
                                                    <h4 class="text-white m-0 flex-grow-1 mr-3">Hi, {{ Auth::user()->username }}</h4>
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Scroll-->
                                                <div class="scroll scroll-push" data-scroll="true" data-height="250" data-mobile-height="200">
                                                   {{--  <div class="separator separator-solid"></div> --}}
                                                   <div class="p-8">
                                                    <div class="
                                                    
                                                    @if((int) Auth::user()->level !== 1)
                                                    d-none
                                                    @else
                                                    d-flex
                                                    align-items-center justify-content-between mb-7
                                                    
                                                    @endif">
                                                        <a href="{{ url('/log') }}" class="text-right"> Logs Aktivitas</a>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-7">
                                                        <a href="#" class="text-right" data-toggle="modal" data-target="#myModal"> Ganti Password</a>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between mb-7">
                                                        <a href="{{ url('/logout') }}" class="text-right" onclick="event.preventDefault();
                                                                         document.getElementById('logout-form').submit();" >
                                                               <i class="icon-logout"> </i>Logout
                                                            </a>
                                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </div>
                                                </div>
                                                    </div>
                                                    <!--end::Item-->
                                                <!--end::Scroll-->
                                                <!--begin::Summary-->
                                                <!--end::Summary-->
                                            
                                        </div>
                                        <!--end::Dropdown-->
                                    </div>

                                    <!--end::User-->
                                </div>
                                <!--end::Topbar-->
                            </div>
                            <!--end::Container-->
                        </div>
                    </div>
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Entry-->
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class="container-fluid">
                                @yield('content')
                            </div>
                            <!--end::Container-->
                        </div>
                        <!--end::Entry-->
                    </div>
                    <!--end::Content-->
                    <!--begin::Footer-->
                    <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                        <!--begin::Container-->
                        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <!--begin::Copyright-->
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted font-weight-bold mr-2">2021©</span>
                                <a href="javascript:void(0)" target="_blank" class="text-dark-75 text-hover-primary">GSA</a>
                            </div>
                            <!--end::Copyright-->
                            <!--begin::Nav-->
                            <!--end::Nav-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Main-->
        <!-- begin::User Panel-->
        
        <!-- end::User Panel-->
        <!--begin::Quick Panel-->
        
        <!--end::Quick Panel-->
        <!--begin::Chat Panel-->
        <!--end::Chat Panel-->
        <!--begin::Scrolltop-->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
          
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title text-left">Ganti Password</h4>
                </div>
                <div class="modal-body">
                    <form class="form" method="POST" action="{{url('master/gantipassword')}}">  
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" required readonly class="form-control" style="background-color:#e4e4e4;" name="username" value="{{ Auth::user()->username }}" />        
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" required  class="form-control" name="password" id="password" value="" />        
                        </div>
                        <div class="form-group">
                            <label>Ketik Password Ulang:</label>
                            <input type="password" required  class="form-control" name="repassword" id="repassword" value="" />        
                        </div>
                        <button type='submit' id='changepassword' class="btn btn-primary mr-2">Ganti Password</button>
                    </form>
                    <br>
                    <div class="col-md-12 col-xs-12 g-margin-t-10--xs alert alert-danger d-none" role="alert" id="passwordalert">
                        Password doesn't match
                    </div>
                    <div class="col-md-12 col-xs-12 g-margin-t-10--xs alert alert-danger d-none" role="alert" id="passwordlength">
                        Password length minimum 8 characters
                    </div> 
                </div> 
              </div>
          
            </div>
          </div>
        <div id="kt_scrolltop" class="scrolltop">
            <span class="svg-icon">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                        <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </div>
        
        <div style="position: fixed; width:100%;height:100%; top:0px; left:0px;z-index:200000;background-color:rgba(0,0,0,0.6);" class="d-none" id="loading">
            <img src="{{asset('assets/gsa/img/loading.gif')}}" style="position: absolute;z-index:10; top:0; bottom:0;left:0;right:0; margin:auto; width:5%;">
        </div>
        <!--end::Scrolltop-->
        <!--begin::Sticky Toolbar-->
        <!--end::Sticky Toolbar-->
        <!--begin::Demo Panel-->
        <!--end::Demo Panel-->
        <!--begin::Global Config(global config for global JS scripts)-->
        <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
        <!--end::Global Config-->
        <!--begin::Global Theme Bundle(used by all pages)-->
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js')}}"></script>
        <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
        <script src="{{ asset('assets/plugins/forms/submit/jquery.form.js')}}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
        <!--end::Global Theme Bundle-->
        <!--begin::Page Vendors(used by this page)-->
        <script src="{{ asset('assets/js/pages/features/miscellaneous/sweetalert2.js')}}"></script>
        <script src="{{ asset('assets/js/pages/features/miscellaneous/toastr.js')}}"></script>
        <!--end::Page Vendors-->
        <!--begin::Page Scripts(used by this page)-->
        <script src={{ asset('assets/js/pages/jquery.number.js') }}></script>
        <script src="{{ asset('assets/js/pages/widgets.js')}}"></script>
        <script src="{{ asset('assets/plugins/devex/js/jszip.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/devex/js/dx.all.js')}}"></script>
        <script src="{{ asset('assets/gsa/js/custom_ajax.js')}}"></script>
        <script type="text/javascript">
            $('form').submit(function(){
                $('body').find('button[type=submit]').prop('disabled', true);
            });
            function checkpassword() {  
                var password    = $('#password'  ).val();
                var repassword  = $('#repassword').val();
                // if(old_password!=''){
                console.log(password)
                console.log(repassword)
                if($('#password').val().length>0 && $('#password').val().length<8){
                    $('#passwordlength' ).removeClass('d-none')
                    $('#passwordalert'  ).addClass('d-none')
                    $("#changepassword" ).prop('disabled', true);
                }
                else{
                    console.log('masuk')
                    $('#passwordlength').addClass('d-none')
                    if(password!=repassword){
                        console.log('masuk if')
                        $('#passwordalert'  ).removeClass('d-none') 
                    }
                    else if(password==repassword){
                        console.log('masuk else')
                        $('#passwordalert'  ).addClass('d-none') 
                        $("#changepassword" ).prop('disabled', false);
                    }
                }                   
            }
            $('#password').keyup(function(){
                checkpassword()
            })

            $('#repassword').keyup(function(){
                checkpassword()
            })
            var timertyping = null; 
            toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "2000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            };
            $('.select2').select2({
        });
            var base_url = '{{ env('APP_URL').'/' }}';
            $('.rupiah').number(true)
            
var loadPanel = $(".loadpanel").dxLoadPanel({
        shadingColor: "rgba(0,0,0,0.4)",
        position: { of: "#awb" },
        visible: false,
        showIndicator: true,
        showPane: true,
        shading: true,
        closeOnOutsideClick: false,
        onShown: function(){
            setTimeout(function () { 
                loadPanel.hide();          
            }, 2000);
        },
        onHidden: function(){
        }      
    }).dxLoadPanel("instance");
    $('.datepicker').datepicker({
               rtl: KTUtil.isRTL(),
               todayHighlight: true,
               orientation: "bottom left",
               autoclose: true
              });
    $('.datepicker_readonly').datepicker({
               rtl: KTUtil.isRTL(),
               todayHighlight: true,
               orientation: "bottom left",
               minDate: 0,
               maxDate:0,
              }).attr('readonly','readonly'); 
        </script>
        @yield('script')
        <!--end::Page Scripts-->
        <script type="text/javascript">

            $(document) .ajaxStart(function () {
                $('#loading').removeClass('d-none')
                console.log('start')
            })          .ajaxStop(function () {
                $('#loading').addClass('d-none')
                console.log('stop')
            }); 
            
            $( document ).ready(function() {
                @isset($awbbelumditerima[0])
                    $('#modalpenerima').modal('show'); 
                @endif
            });
        </script>
    </body>
    
@if(Session::get('message') == "Password Updated")
<script type="text/javascript">
    toastr.success("Password berhasil dirubah!");
</script>
@endif 
    <!--end::Body-->
</html>