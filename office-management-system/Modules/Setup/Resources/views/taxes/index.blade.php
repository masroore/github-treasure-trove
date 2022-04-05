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
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('setup.Tax List') }}</h3>
                            @if (permissionCheck('tax.store'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="#" onclick="resetAddForm()" data-toggle="modal" data-target="#Tax_Add"><i class="ti-plus"></i>{{ __('common.Add New') }} {{ __('setup.Tax') }}</a></li>
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
                                        <th scope="col">{{ __('common.Description') }}</th>
                                        <th scope="col">{{ __('setup.Rate') }}</th>
                                        <th scope="col">{{ __('setup.Status') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($taxes as $key => $tax)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $tax->name }}</td>
                                            <td>{{ $tax->description }}</td>
                                            <td>{{ $tax->rate }} %</td>
                                            <td>
                                                <label class="switch_toggle" for="active_checkbox{{ $tax->id }}">
                                                    <input type="checkbox" id="active_checkbox{{ $tax->id }}" @if ($tax->status == 1) checked @endif value="{{ $tax->id }}" onchange="update_active_status(this)">
                                                    <div class="slider round"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        @if (permissionCheck('tax.edit'))
                                                            <a href="#" data-toggle="modal" data-target="#Tax_Edit" class="dropdown-item edit_tax" data-value="{{$tax->id}}" type="button">{{__('common.Edit')}}</a>
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

@include('setup::taxes.create')
@include('setup::taxes.edit')
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">

        var baseUrl = $('#app_base_url').val();

      
        function resetAddForm()
        {
            document.getElementById("tax_addForm").reset();
        }

        $("#tax_addForm").on("submit", function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: "{{route("tax.store")}}",
                data: formData,
                type: "POST",
                success: function (response) {
                    $("#Tax_Add").modal("hide");
                    document.getElementById("tax_addForm").reset();
                    toastr.success("Successfully Added","Success");
                    window.location.reload();
                },
                error: function (error) {
                    toastr.warning("Something went wrong");
                    if (error) {
                        $.each(error.responseJSON.errors, function (key, message) {
                            $("#" + key + "_error").html(message[0]);
                        });
                    }
                }
            });
        });

        $(".edit_tax").on("click", function (event) {
            event.preventDefault();
            let id = $(this).data("value");
            $.ajax({
                url: baseUrl + "/setup/tax/" + id + "/edit",
                type: "GET",
                success: function (response) {
                    $(".edit_id").val(response.id);
                    $(".name").val(response.name);
                    $(".rate").val(response.rate);
                    $(".description").val(response.description);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $(document).on("submit", "#tax_EditForm", function (event) {
            event.preventDefault();
            let id = $(".edit_id").val();
            let formData = $(this).serializeArray();
            $.each(formData, function (key, message) {
                $("#edit_" + formData[key].name + "_error").html("");
            });
            $.ajax({
                url: baseUrl + "/setup/tax/update/" + id,
                data: formData,
                type: "POST",
                dataType: "JSON",
                success: function (response) {
                    $("#Tax_Edit").modal("hide");
                    document.getElementById("tax_EditForm").reset();
                    toastr.success("Successfully Updated","Success");
                    window.location.reload();
                },
                error: function (error) {
                    toastr.warning("Something went wrong");
                    if (error) {
                        $.each(error.responseJSON.errors, function (key, message) {
                            $("#edit_" + key + "_error").html(message[0]);
                        });
                    }
                }
            });
        });

        function update_active_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('tax.update_active_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    toastr.success("Successfully Updated","Success");
                }
                else{
                    toastr.warning("Something went wrong");
                }
            });
        }
    </script>
@endpush
