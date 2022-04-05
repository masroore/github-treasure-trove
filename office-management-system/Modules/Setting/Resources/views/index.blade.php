@extends('setting::layouts.master')
@section('page-title', app('general_setting')->site_title .' | Settings')
@section('mainContent')
    @include("backEnd.partials.alertMessage")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30">{{ __('setting.Settings') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="">
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- myTab  -->
                                <div class="white_box_30px mb_30">
                                    <ul class="nav custom_nav" id="myTab" role="tablist">

                                        @if(permissionCheck('update_activation_status'))
                                            <li class="nav-item">
                                                <a class="nav-link {{ permissionCheck('update_activation_status') && !isset($company) &&  !session()->has('invoice') && !session()->has('sms_template') && !session()->has('email_template') && !session()->has('g_set') && !session()->has('smtp_set') && !session()->has('sms_set') && !session()->has('background') ? 'active ' : '' }}"
                                                   id="activation-tab" data-toggle="tab" href="#Activation" role="tab"
                                                   aria-controls="home"
                                                   aria-selected="true">{{ __('setting.Activation') }}</a>
                                            </li>
                                        @endif


                                        @if(permissionCheck('general_settings.index'))
                                            <li class="nav-item">
                                                <a class="nav-link @if(session()->has('g_set')) active show @endif"
                                                   id="General-tab" data-toggle="tab" href="#General" role="tab"
                                                   aria-controls="home"
                                                   aria-selected="true">{{ __('setting.General') }}</a>
                                            </li>

                                        @endif

                                        @if(permissionCheck('company_information_update'))

                                            <li class="nav-item">
                                                <a class="nav-link {{isset($company) ? 'active show' : ''}}"
                                                   id="Company_Information-tab" data-toggle="tab"
                                                   href="#Company_Information" role="tab"
                                                   aria-controls="Company_Information"
                                                   aria-selected="false">{{ __('setting.Company Information') }}</a>
                                            </li>
                                        @endif

                                        @if(permissionCheck('invoice_settings.index'))

                                            <li class="nav-item">
                                                <a class="nav-link {{session()->has('invoice') ? 'active show' : ''}}"
                                                   id="invoice-tab" data-toggle="tab" href="#invoice" role="tab"
                                                   aria-controls="invoice"
                                                   aria-selected="false">{{ __('setting.Invoice Settings') }}</a>
                                            </li>
                                        @endif

                                        @if(permissionCheck('smtp_gateway_credentials_update'))
                                            <li class="nav-item">
                                                <a class="nav-link @if(session()->has('smtp_set')) active show @endif"
                                                   id="SMTP-tab" data-toggle="tab" href="#SMTP" role="tab"
                                                   aria-controls="contact"
                                                   aria-selected="false">{{ __('setting.SMTP') }}</a>
                                            </li>
                                        @endif

                                        @if(permissionCheck('sms_gateway_credentials_update'))
                                            <li class="nav-item">
                                                <a class="nav-link @if(session()->has('sms_set')) active show @endif"
                                                   id="SMS-tab" data-toggle="tab" href="#SMS" role="tab"
                                                   aria-controls="contact"
                                                   aria-selected="false">{{ __('setting.SMS') }}</a>
                                            </li>
                                        @endif
                                        @if(permissionCheck('email_template.index'))
                                            <li class="nav-item">
                                                <a class="nav-link @if(session()->has('email_template')) active show @endif"
                                                   id="Template-tab" data-toggle="tab" href="#TEMPLATE" role="tab"
                                                   aria-controls="contact"
                                                   aria-selected="false">{{ __('setting.Email Template') }}</a>
                                            </li>
                                        @endif

                                        @if(permissionCheck('sms_template.index'))
                                            <li class="nav-item">
                                                <a class="nav-link @if(session()->has('sms_template')) active show @endif"
                                                   id="SMSTemplate-tab" data-toggle="tab" href="#TEMPLATESMS" role="tab"
                                                   aria-controls="contact"
                                                   aria-selected="false">{{ __('setting.SMS Template') }}</a>
                                            </li>
                                        @endif



                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <!-- tab-content  -->
                                <div class="tab-content " id="myTabContent">
                                @if(permissionCheck('update_activation_status'))
                                    <!-- General -->
                                        <div
                                            class="tab-pane fade white_box_30px {{isset($company) || session()->has('invoice')  || session()->has('sms_template') || session()->has('g_set') || session()->has('email_template') || session()->has('smtp_set') || session()->has('sms_set') || session()->has('background') ? '' : 'active show'}}"
                                            id="Activation" role="tabpanel" aria-labelledby="Activation-tab">
                                            @include('setting::page_components.activation')
                                        </div>
                                        <!-- General -->
                                @endif
                                @if(permissionCheck('general_settings.index'))
                                    <!-- General -->
                                        <div
                                            class="tab-pane fade white_box_30px @if(session()->has('g_set')) active @endif show"
                                            id="General" role="tabpanel" aria-labelledby="General-tab">
                                            @include('setting::page_components.general_settings')
                                        </div>
                                @endif
                                @if(permissionCheck('company_information_update'))
                                    <!-- Company_Information  -->
                                        <div
                                            class="tab-pane fade white_box_30px {{isset($company) ? 'active show' : ''}}"
                                            id="Company_Information" role="tabpanel"
                                            aria-labelledby="Company_Information-tab">
                                            @include('setting::page_components.company_info_settings')
                                        </div>
                                @endif
                                @if(permissionCheck('invoice_settings.index'))
                                    <!-- invoice  -->
                                        <div
                                            class="tab-pane fade white_box_30px {{session()->has('invoice') ? 'active show' : ''}}"
                                            id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                                            @include('setting::page_components.invoice_settings')
                                        </div>
                                @endif


                                @if(permissionCheck('smtp_gateway_credentials_update'))
                                    <!-- SMTP  -->
                                        <div
                                            class="tab-pane fade white_box_30px  @if(session()->has('smtp_set')) active show @endif"
                                            id="SMTP" role="tabpanel" aria-labelledby="SMTP-tab">
                                            @include('setting::page_components.smtp_setting')
                                        </div>
                                @endif
                                @if(permissionCheck('sms_gateway_credentials_update'))
                                    <!-- SMS  -->
                                        <div
                                            class="tab-pane fade white_box_30px @if(session()->has('sms_set')) active show @endif"
                                            id="SMS" role="tabpanel" aria-labelledby="SMS-tab">
                                            @include('setting::page_components.sms_settings')
                                        </div>
                                @endif
                                @if(permissionCheck('email_template.index'))
                                    <!-- email template -->
                                        <div
                                            class="tab-pane fade white_box_30px @if(session()->has('email_template')) active show @endif"
                                            id="TEMPLATE" role="tabpanel" aria-labelledby="Template-tab">
                                            @include('setting::page_components.email_template')
                                        </div>
                                @endif
                                @if(permissionCheck('sms_template.index'))
                                    <!-- SMS Template -->
                                        <div
                                            class="tab-pane fade white_box_30px @if(session()->has('sms_template')) active show @endif"
                                            id="TEMPLATESMS" role="tabpanel" aria-labelledby="Template-tab">
                                            @include('setting::page_components.sms_template')
                                        </div>
                                        <!-- SMS Template -->
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            smtp_form();
        });

        function update_active_status(el) {
            if (el.checked) {
                var status = 1;
            } else {
                var status = 0;
            }
            $.post('{{ route('update_activation_status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function (data) {
                if (data == 1) {
                    toastr.success("Successfully Updated", "Success");
                } else {
                    toastr.warning("Something went wrong");
                }
            });
        }

        function smtp_form() {
            var mail_mailer = $('#mail_mailer').val();
            if (mail_mailer == 'smtp') {
                $('#sendmail').hide();
                $('#smtp').show();
            } else if (mail_mailer == 'sendmail') {
                $('#smtp').hide();
                $('#sendmail').show();
            }
        }


        function company_info_form_submit() {
            var company_name = $('#company_name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var vat_number = $('#vat_number').val();
            var address = $('#address').val();
            var country_name = $('#country_name').val();
            var zip_code = $('#zip_code').val();
            var company_info = $('#company_info').val();
            $.post('{{ route('company_information_update') }}', {
                _token: '{{ csrf_token() }}',
                phone: phone,
                company_name: company_name,
                email: email,
                vat_number: vat_number,
                address: address,
                country_name: country_name,
                zip_code: zip_code,
                company_info: company_info
            }, function (data) {
                if (data == 1) {
                    toastr.success("Successfully Updated", "Success");
                } else {
                    toastr.warning(data.error);
                }
            });
        }

        $(document).on('change', '#use_color', function(){
            if (this.checked){
                $('#dashboard_bg_color_section').show();
                $('#dashboard_bg_image_section').hide();
            } else{
                $('#dashboard_bg_image_section').show();
                $('#dashboard_bg_color_section').hide();
            }
        });

    </script>
@endpush
