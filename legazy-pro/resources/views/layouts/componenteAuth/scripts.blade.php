<script src="{{asset('assets/js/auth/vendors.min.js')}}"></script>

<!-- BEGIN: Page Vendor JS-->
@stack('page_vendor_js')
<!-- END: Page Vendor JS-->

<script src="{{asset('assets/js/auth/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/auth/app-menu.min.js')}}"></script>
<script src="{{asset('assets/js/auth/app.min.js')}}"></script>
<script src="{{asset('assets/js/auth/page-auth-login.js')}}"></script>

@stack('page_js')

<!-- BEGIN: Custom js-->
@stack('custom_js')

<!-- END: Custom js-->