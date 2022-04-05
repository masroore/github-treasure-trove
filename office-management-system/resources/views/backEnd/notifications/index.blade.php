@extends('backEnd.master')
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
        <form id="content_form" action="{{route('mark_notifications')}}" method="post">@csrf
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Notification List') }}</h3>
                            <li class="generate_btn mr-0" style="display: none;">
                                <a href="javascript:void(0)" onclick="formSubmit()"
                                   class="primary-btn radius_30px mb-10 mr-10 fix-gr-bg"><i
                                        class="ti-check"></i>{{trans('common.Mark selected as seen')}}</a>
                            </li>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active4">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            <label class="primary_checkbox d-flex " >
                                                <input type="checkbox" name="all_row"
                                                onchange="selectAllRow()"
                                                class="all_row">
                                                <span class="checkmark"></span>
                                            </label>
                                        </th>
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('common.Type') }}</th>
                                        <th scope="col">{{ __('common.Data') }}</th>
                                        <th scope="col">{{ __('common.Url') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($notifications as $key => $notification)
                                        <tr>
                                            <th scope="col">
                                                <label class="primary_checkbox d-flex">
                                                    <input name="notifications[]" class="row_select"
                                                           onchange="selectRow()"
                                                           data-id="{{ $notification->id }}"
                                                           value="{{ $notification->id }}" type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </th>
                                            <th>{{ $key+1 }}</th>
                                            <td><a href="{{$notification->url}}" onclick="notification_remove({{$notification->id}},'{{$notification->url}}')">{{$notification->type}} </a></td>
                                            <td>{{ $notification->data }}</td>
                                            <td>{{ $notification->url }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">

    function notification_remove(id,url)
    {
        $.ajax({
            url : "{{route('notification.update')}}",
            method : "POST",
            data : {
                id : id,
                _token : "{{csrf_token()}}",
            },
            success:function (result){
            }
        })
    }
    function selectRow() {
        let unchecked = 0;
        $.each($('.row_select'), function () {
            if ($(this).prop('checked') == false) {
                unchecked++;
            }
            let checked = false;
            $.each($('.row_select'), function () {
                if (this.checked){
                    checked = true;
                }
            })

            if (checked){
                $('.generate_btn').show();
            } else{
                $('.generate_btn').hide();
            }

            if (unchecked > 0) {
                $('.all_row').prop('checked', false)
            } else {
                $('.all_row').prop('checked', true);
            }
        })
    }
    function selectAllRow() {

        if ($('.all_row').prop('checked') == true) {
            $('.generate_btn').show();
            $.each($('.row_select'), function () {
                $(this).prop('checked', true)
            })
        } else {
            $('.generate_btn').hide();
            $.each($('.row_select'), function () {
                $(this).prop('checked', false)
            })
        }
    }
    function formSubmit() {
        $('#content_form').submit();
    }
    </script>
@endpush
