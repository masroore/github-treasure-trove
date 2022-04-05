@php
    $setting = app('general_setting');
@endphp
@include('backEnd.partials.header')

@section('content')

@show


</div>
</div>

<div class="has-modal modal fade" id="showDetaildModal">
    <div class="modal-dialog modal-dialog-centered" id="modalSize">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="showDetaildModalTile">{{ __('common.New Client Information') }}</h4>
                <button type="button" class="close icons" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="showDetaildModalBody">

            </div>

            <!-- Modal footer -->

        </div>
    </div>
</div>


<!--  Start Modal Area -->
<div class="modal fade invoice-details" id="showDetaildModalInvoice">
    <div class="modal-dialog large-modal modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.Add Invoice') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="showDetaildModalBodyInvoice">
            </div>

        </div>
    </div>
</div>

<!-- ================Footer Area ================= -->
<footer class="footer-area">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 text-center">
                <p> </p>
            </div>
        </div>
    </div>
</footer>
<!-- ================End Footer Area ================= -->

{!! Toastr::message() !!}
<script src="{{ asset('js/lang') }}"></script>
@stack('js_before')
<script type="text/javascript">

</script>
@stack('js_after')
<div class="modal fade animated team_modal infix_biz_modal" id="remote_modal" tabindex="-1" role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
</div>

<div class="modal fade animated project_modal infix_biz_modal" id="remote_modal" tabindex="-1" role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
</div>

<div class="modal fade animated invite_modal infix_biz_modal" id="remote_modal" tabindex="-1" role="dialog" aria-labelledby="remote_modal_label" aria-hidden="true" data-backdrop="static">
</div>
</body>
</html>
