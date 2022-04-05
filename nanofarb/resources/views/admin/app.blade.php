@include('admin.layouts.begin')
<div class="wrapper">
    @include('admin.layouts.header')
    @include('admin.layouts.aside')
    <div class="content-wrapper">

        @include('admin.layouts.content-header', array_merge([
            'page_title' => 'Админ панель',
            'small_page_title' => '',
            'url_back' => '',
            'url_create' => ''
        ], $content_header ?? []))
{{--

        <div class="col-md-12">
            <br> <!-- TODO -->
            @include('admin.inc.notifications')
        </div>
--}}

        @yield('content')
    </div>
    @include('admin.layouts.footer')
    <div class="control-sidebar-bg"></div>
</div>
@include('admin.layouts.end')

@stack('modals')
@yield('modals')
@include('admin.inc.toastr')
