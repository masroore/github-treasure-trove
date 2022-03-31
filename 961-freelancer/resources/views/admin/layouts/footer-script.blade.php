        <!-- JAVASCRIPT -->
        <script src="{{ URL::asset('admin-assets/assets/libs/jquery/jquery.min.js')}}"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        <script src="{{ URL::asset('admin-assets/assets/libs/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{ URL::asset('admin-assets/assets/libs/metismenu/metismenu.min.js')}}"></script>
        <script src="{{ URL::asset('admin-assets/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ URL::asset('admin-assets/assets/libs/node-waves/node-waves.min.js')}}"></script>
       
        <script src="{{ URL::asset('admin-assets/assets/js/select2.min.js')}}"></script>
        @yield('script')
        <!-- Plugins js -->
        <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->

         <script src="{{asset('admin-assets/assets/datatable/jquery.dataTables.min.js')}}"></script>
         <script src="{{asset('admin-assets/assets/datatable/dataTables.bootstrap4.min.js')}}"></script>
         <script src="{{asset('admin-assets/assets/js/datatable.js')}}"></script>
         <script src="{{ URL::asset('assets/js/notify.js') }}"></script>
        <!-- App js -->
        <script src="{{ URL::asset('admin-assets/assets/js/app.js')}}"></script>
        
        @yield('script-bottom')