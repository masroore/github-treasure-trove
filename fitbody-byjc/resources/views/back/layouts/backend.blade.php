<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>{{ $appinfo->name }}</title>

        <meta name="description" content="">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('media/images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('media/images/favicon-16x16.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

        <!-- Fonts and Styles -->
        @stack('css_before')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="{{ asset('/css/core.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('/css/sweetalert2.css') }}">
        <link rel="stylesheet" id="css-theme" href="{{ asset('/css/skladisna-logistika.css') }}">
        @stack('css_after')

        <!-- Scripts -->
        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
        <script type="text/javascript">
            window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode===13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
        </script>
    </head>
    <body>

        <div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-narrow {{ (isset($settings) && $settings->sidebar_inverse) ? 'sidebar-inverse' : '' }}">
            <!-- Side Overlay-->
            <aside id="side-overlay">
                <!-- Side Header -->
                <div class="content-header content-header-fullrow">
                    <div class="content-header-section align-parent">
                        <!-- Close Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                        <!-- END Close Side Overlay -->

                        <!-- User Info -->
                        <div class="content-header-item">
                            <a class="img-link mr-5" href="javascript:void(0)">
                                <img class="img-avatar img-avatar32" src="{{ asset('media/images/avatar.jpg') }}" alt="">
                            </a>
                            <a class="align-middle link-effect text-primary-dark font-w600" href="javascript:void(0)">{{ auth()->user()->name }}</a>
                        </div>
                        <!-- END User Info -->
                    </div>
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                <div class="content-side">
                    <p>
                        Content..
                    </p>
                </div>
                <!-- END Side Content -->
            </aside>
            <!-- END Side Overlay -->

            @include('back.layouts.partials.sidebar'/*, ['data' => $data]*/)

            @include('back.layouts.partials.topbar')

            <!-- Main Container -->
            <main id="main-container">
                @yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="opacity-0">
                <div class="content py-20 font-size-xs clearfix">
                    <div class="float-right">
                        Crafted with <i class="fa fa-heart text-pulse"></i> by <a class="font-w600" href="https://www.agmedia.hr" target="_blank">agmedia</a>
                    </div>
                    <div class="float-left">
                        <a class="font-w600" href="https://www.agmedia.hr" target="_blank">AGbase</a> &copy; <span class="js-year-copy"></span>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <!-- Codebase Core JS -->
        <script src="{{ asset('js/core.js') }}"></script>

        <!-- Laravel Scaffolding JS -->
        <script src="{{ asset('js/lara.js') }}"></script>
        <script src="{{ asset('js/sweetalert2.js') }}"></script>

        <script>
          const confirmPopUp = Swal.mixin({
            buttonsStyling: false,
            customClass: {
              confirmButton: 'btn btn-success m-5',
              cancelButton: 'btn btn-danger m-5',
              input: 'form-control'
            }
          })

          const successToast = Swal.mixin({
            type: 'success',
            timer: 3000,
            position: 'top-end',
            showConfirmButton:false,
            toast: true,
          })

          const errorToast = Swal.mixin({
            type: 'error',
            timer: 3000,
            position: 'top-end',
            showConfirmButton:false,
            toast: true,
          })
        </script>

        <script>
            $(() => {
                $('#page-header-notifications').on('click', ($event) => {
                    axios.post("{{ route('notifications.read') }}", {data: 'delete'})
                        .then(r => {
                            console.log(r.data)
                        })
                        .catch(e => {
                            console.log(e)
                        })
                })

                $('#sidebar-inverse-toggle').on('click', ($event) => {
                    axios.get("{{ route('sidebar.inverse.toggle') }}")
                        .then(r => {
                            console.log(r.data)
                        })
                        .catch(e => {
                            console.log(e)
                        })
                })
            })

        </script>

        <script>
          function slugify(string) {
            const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
            const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
            const p = new RegExp(a.split('').join('|'), 'g')

            return string.toString().toLowerCase()
              .replace(/\s+/g, '-') // Replace spaces with -
              .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
              .replace(/&/g, '-and-') // Replace & with 'and'
              .replace(/[^\w\-]+/g, '') // Remove all non-word characters
              .replace(/\-\-+/g, '-') // Replace multiple - with single -
              .replace(/^-+/, '') // Trim - from start of text
              .replace(/-+$/, '') // Trim - from end of text
          }

        </script>

        @stack('js_after')
    </body>
</html>
