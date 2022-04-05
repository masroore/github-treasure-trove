<!DOCTYPE html>
<html>


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('page-title') - {{ setting('app_name') }}</title>
    <!-- plugins:css -->
    <script src="https://kit.fontawesome.com/6c1803817f.js" crossorigin="anonymous" `SameSite=None`></script>
    <link href="/assets/css/opp.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/corona/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/corona/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->

    <link rel="stylesheet" href="/assets/corona/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/assets/corona/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/corona/vendors/owl-carousel-2/owl.theme.default.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/corona/css/modern-vertical/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/corona/images/favicon.png" />
    <link rel="stylesheet" href="/assets/corona/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/corona/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="/assets/corona/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link href="/assets/css/theme/blue.min.css" id="theme" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="/assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css" />

    <style>
        .select2-search { background-color: #0a0a0a; }
        .select2-results { background-color: #0a0a0a; }
    </style>
    @yield('styles')

    @hook('app:styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.4.4/umd/popper.min.js" integrity="sha512-eUQ9hGdLjBjY3F41CScH3UX+4JDSI9zXeroz7hJ+RteoCaY+GP/LDoM8AO+Pt+DRFw3nXqsjh9Zsts8hnYv8/A==" crossorigin="anonymous"></script>
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.js"></script>


</head>
<body >
    <div class="container-scroller">
        @include('partials.defaultNavBar')
        <div class="container-fluid page-body-wrapper">
            @include('partials.defaultNavBarTop')
            <div class="main-panel">
                <div class="content-wrapper ">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @yield('modals')
    @include('invoice.partials.customerModal')

    <script src="/assets/corona/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/vendors/select2/select2.min.js"></script>
    <script src="/assets/js/select2.js"></script>
    <script src="/assets/corona/js/off-canvas.js"></script>
    <script src="/assets/corona/js/hoverable-collapse.js"></script>
    <script src="/assets/corona/js/misc.js"></script>
    <script src="/assets/corona/js/settings.js"></script>
    <script src="/assets/corona/js/todolist.js"></script>
    <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/moment/moment.min.js"></script>
    <script src="/assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js"></script>

    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/corona/js/dashboard.js"></script>

    <script>

        $('#customerModal').on('shown.bs.modal', function (){

            $('#datepicker-popup').datepicker({
                todayHighlight: true,
            });

            $('.selectBasic').select2({
                theme: "bootstrap"
            });

            $('#customerInvoiceForm').load('/customer/form', function () {
                $( "#newCustomer" ).hide();
            });
        });

        function customerChange() {
            var customer = document.getElementById("customer").value;

            if(customer == 0){
                console.log('New Customer')
                $( "#newCustomer" ).show();
            }
            else {
                console.log('Existing Customer')
                $( "#newCustomer" ).hide();
            }
        }

    </script>

    <script>
        $('.toast').toast('show')
    </script>

    @yield('scripts')

    @hook('app:scripts')
</body>

</html>
