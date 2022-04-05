@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">

        @include('leave::leave_defines.components.create')
        @include('backEnd.partials.deleteModalAjaxRequest',['item_name' => 'Leave Define'])

        <div class="container-fluid p-0">
            <div class="row">
                @if(permissionCheck('leave_define.store'))
                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('leave.Leave Define List') }}</h3>
                                <ul class="d-flex">
                                    <li>
                                        <button class="primary-btn radius_30px mr-10 fix-gr-bg"
                                                onclick="createModalShow()">
                                            <i class="ti-plus"></i>{{ __('common.Add New') }} {{ __('leave.Leave Define') }}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="" id="leave_define_table">
                                {{-- Leave Define List --}}
                                @include('leave::leave_defines.components.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')

    <script>
        var baseUrl = $('#app_base_url').val();
        var total_days = 0;
        $(document).ready(function () {

            $('#leave_define_create_form').on('submit', function (event) {
                event.preventDefault();
                var formData = new FormData(this);

                formData.append('_token', "{{ csrf_token() }}");

                let url = '';

                if (formData.get('id') == '') {
                    url = "{{ route('leave_define.store')}}";
                } else {
                    url = "{{ route('leave_define.update')}}";
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#leave_define_table').empty().html(response.TableData);
                            toastr.success(response.success);
                            CRMTableThreeReactive()
                            $('#leave_define_add').modal('hide');
                            resetForm();
                        } else {
                            toastr.error(response);
                        }
                    },
                    error: function (response) {
                        $('#role_id_error').text(response.responseJSON.errors.role_id);
                        $('#leave_type_id_error').text(response.responseJSON.errors.leave_type_id);
                        $('#total_days_error').text(response.responseJSON.errors.total_days);
                        $('#max_forward_error').text(response.responseJSON.errors.max_forward);
                    }

                });
            });

            $('#deleteItemModal').on('submit', function (event) {
                event.preventDefault();
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_item_id').val());

                $.ajax({
                    url: "{{ route('leave_define.delete')}}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#leave_define_table').empty().html(response.TableData);
                            toastr.success(response.success);
                            CRMTableThreeReactive()
                            $('#deleteItemModal').modal('hide');
                        } else {
                            toastr.error(response);
                        }
                    },
                });
            });

            $(document).on('change','#user_id',function (){
                let values = $(this).val();

                values.forEach(function (value,index){
                    if (value != '' && values.length > 0)
                    {
                        $('.specific_year').show();
                    }
                    else
                        $('.specific_year').hide();
                });
            })
        });

        function createModalShow() {
            $('#leave_define_add').modal('show');
            $('.modal-title span').text('{{ trans('common.Add New') }}');
            resetForm();
        }

        function showDeleteModal(imteId) {
            $('#delete_item_id').val(imteId);
            $('#deleteItemModal').modal('show');
        }

        function editLeaveDefine(item) {
            resetForm();
            if (item.user_id) {
                $('.role_id').hide();
                $('.user_id').hide();
            }

            $('#role_id').val(item.role_id);

            $('#leave_define_add').modal('show');
            $('.modal-title span').text('{{ trans('common.Edit') }}');
            $('#item_id').val(item.id);

            $('#leave_type_id').val(item.leave_type_id);
            $('#total_days').val(item.total_days);
            $('#max_forward').val(item.max_forward);
            if (item.balance_forward == 1) {
                $('#status_active').prop("checked", true);
                $('.max_forward').show();
            } else {
                $('#status_active').prop("checked", false);
                $('.max_forward').hide();
            }
            if (item.adjusted == 1) {
                $('#adjusted').prop("checked", true);
            } else {
                $('#adjusted').prop("checked", false);
            }
            if (item.year != '') {
                $('.specific_year').show();
                $('#year').prop("checked", true);
            } else {
                $('.specific_year').hide();
                $('#year').prop("checked", false);
            }
            $('select').niceSelect('update');
        }

        function resetForm() {
            $('.role_id').show();
            $('.user_id').show();
            $('#leave_define_create_form')[0].reset();
            $('#role_id').val('');
            $('#role_id_error').text('');
            $('#leave_type_id').val('');
            $('#leave_type_id_error').text('');
            $('#total_days_error').text('');
            $('#max_forward_error').text('');
            $('#max_forward').val('');
            $('#total_days').val('');
            $('#status_active').prop("checked", false);
            $('#adjusted').prop("checked", false);
            $('.max_forward').hide();
            $('.specific_year').hide();
            $('#year').prop("checked", false);
            $('select').niceSelect('update');
        }

        function setMaxForward(selector) {
            if ($(selector).is(':checked')) {
                $('.max_forward').show();
            } else {
                $('.max_forward').hide();
            }
        }

        $(document).on('keyup', '.total_days', function () {
            total_days = parseInt($(this).val());
        })

        function checkForwardBalance(selector) {
            let forward_balance = parseInt($(selector).val());
            console.log('forward_balance = ' + forward_balance, 'total_days =' + total_days);

            if (forward_balance > total_days) {
                toastr.warning('{{trans('leave.your entered days exceed the total days')}}');
            }
        }

        function getUserByRole(el) {
            let val = $(el).val();

            $.ajax({
                'method': 'POST',
                'url': '{{route('get.role.users')}}',
                data: {
                    role_id: val,
                    _token: '{{csrf_token()}}',
                },
                success: function (result) {
                    $('#user_id').html(result);
                    $('select').niceSelect('update');
                }
            });
        }

    </script>
@endpush
