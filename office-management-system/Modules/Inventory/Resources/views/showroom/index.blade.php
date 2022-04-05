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
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('inventory.Branch List') }}</h3>
                            @if (permissionCheck('showroom.store'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"  data-toggle="modal" data-target="#ShowRoom_Add"><i class="ti-plus"></i>{{ __('common.Add New') }} {{ __('inventory.Branch') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('common.Name') }}</th>
                                        <th scope="col">{{ __('common.Address') }}</th>
                                        <th scope="col">{{ __('common.Email') }}</th>
                                        <th scope="col">{{ __('common.Phone') }}</th>
                                        <th scope="col">{{ __('common.Status') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($showrooms as $key => $showroom)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $showroom->name }}</td>
                                            <td>{{ $showroom->address }}</td>
                                            <td>{{ $showroom->email }}</td>
                                            <td>{{ $showroom->phone }}</td>
                                            <td>
                                                @if ($showroom->status == 1)
                                                    <span class="badge_1">{{ __('inventory.Active') }}</span>
                                                @else
                                                    <span class="badge_4">{{ __('inventory.De-Active') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        <a href="{{ route('showroom.show', $showroom->id) }}" class="dropdown-item">{{__('common.View')}}</a>
                                                        @if (permissionCheck('showroom.edit'))
                                                            <a href="#" data-toggle="modal" data-target="#Item_Edit" class="dropdown-item edit_brand" onclick="edit_showroom_modal({{ $showroom->id }})">{{__('common.Edit')}}</a>
                                                        @endif
                                                        @if (permissionCheck('showroom.destroy') && $showroom->stocks->count() == 0)
                                                            <a onclick="confirm_modal('{{route('showroom.destroy', $showroom->id)}}');" class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
                                            </td>
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
    </section>
    <div id="edit_form">

    </div>
    <div class="modal fade admin-query" id="ShowRoom_Add">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Add New') }} {{ __('inventory.Branch') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="#" method="POST" id="showroom_addForm">
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Name') }} *</label>
                                    <input name="name" class="primary_input_field name" placeholder="{{ __('common.Name') }}" type="text" required>
                                    <span class="text-danger" id="name_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Email') }}</label>
                                    <input name="email" class="primary_input_field name" placeholder="{{ __('common.Email') }}" type="email">
                                    <span class="text-danger" id="email_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Phone') }}</label>
                                    <input name="phone" class="primary_input_field name" placeholder="{{ __('common.Phone') }}" type="text">
                                    <span class="text-danger" id="phone_error"></span>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Status') }} *</label>
                                    <select class="primary_select mb-25" name="status" id="status">
                                        <option value="1">{{ __('inventory.Active') }}</option>
                                        <option value="2">{{ __('inventory.De-Active') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.Address') }}</label>
                                    <textarea class="primary_textarea height_112" placeholder="{{ __('common.Address') }}" name="address" spellcheck="false"></textarea>
                                    <span class="text-danger" id="address_error"></span>
                                </div>
                            </div>

                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
        $("#showroom_addForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("showroom.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#ShowRoom_Add").modal("hide");
                    $("#showroom_addForm").trigger("reset");
                    toastr.success("ShowRoom has been added Successfully");
                    location.reload();
                },
                error: function (error) {
                    if (error) {
                        $.each(error.responseJSON.errors, function (key, message) {
                            $("#" + key + "_error").html(message[0]);
                        });
                    }
                }

            });
        });
        function edit_showroom_modal(el){
            $.post('{{ route('showroom.edit') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#edit_form').html(data);
                $('#ShowRoom_Edit').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
