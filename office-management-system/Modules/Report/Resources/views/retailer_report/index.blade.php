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
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('agent.Retailer List') }}</h3>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table">
                            <div class="" id="item_table">
                                {{-- Agent List --}}
                                <!-- table-responsive -->
                                <div class="">
                                    <table class="table Crm_table_active3">
                                        <thead>
                                        <tr>
                                            <th scope="col">
                                                <label class="primary_checkbox d-flex ">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </th>
                                            <th scope="col">{{ __('common.ID') }}</th>
                                            <th scope="col">{{ __('common.Name') }}</th>
                                            <th scope="col">{{ __('agent.Email') }}</th>
                                            <th scope="col">{{ __('agent.Phone') }}</th>
                                            <th scope="col">{{ __('agent.Address') }}</th>
                                            <th scope="col">{{ __('common.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($AgentList as $key => $item)
                                            <tr>
                                                <th scope="col">
                                                    <label class="primary_checkbox d-flex">
                                                        <input name="sms1" type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </th>
                                                <th>{{ $key + 1 }}</th>
                                                <td>{{ @$item->user->name }}</td>
                                                <td><a href="mailto:{{ @$item->user->email }}">{{ @$item->user->email }}</a></td>
                                                <td><a href="tel:{{ $item->phone }}">{{ $item->phone }}</a></td>
                                                <td>{{ $item->address }}</td>
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
                                                            @if(permissionCheck('agent.edit'))
                                                            <a href="{{ route('agent.edit', $item->id) }}" class="dropdown-item edit_brand">{{__('common.Edit')}}</a>
                                                            @endif
                                                            
                                                            <a href="{{ route('agent.show', $item->id) }}" class="dropdown-item edit_brand">{{__('common.View')}}</a>
                                                      
                                                        </div>
                                                    </div>
                                                    <!-- shortby  -->
                                                </td>
                                            </tr>
                                        @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@include('backEnd.partials.approve_modal')
@endsection

@push('scripts')

    <script>
        var baseUrl = $('#app_base_url').val();

        $(document).ready(function() {

            $('#deleteItemModal').on('submit',function(event){
                event.preventDefault();
                var formData = new FormData();
                formData.append('_token',"{{ csrf_token() }}");
                formData.append('id',$('#delete_item_id').val());

                $.ajax({
                    url: "{{ route('agent.delete')}}",
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        resetAfterChange(response.TableData);
                        toastr.success('Agent has been deleted successfully!')
                        $('#deleteItemModal').modal('hide');

                    },
                    error: function(response) {
                        toastr.error('Something wrong !')
                    }
                });
            });

        });


        function showDeleteModal(imteId){
           $('#delete_item_id').val(imteId);
           $('#deleteItemModal').modal('show');
           console.log(imteId);
        }

        function resetAfterChange(tableData){
            $('#item_table').empty();
            $('#item_table').html(tableData);
            CRMTableThreeReactive();
            resetForm();
        }

    </script>
@endpush
