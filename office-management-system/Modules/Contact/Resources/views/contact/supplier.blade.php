@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__("common.Suppliers")}} </h3>
                    @if(permissionCheck('add_contact.store'))
                    <ul class="d-flex">
                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route("add_contact.index")}}"><i
                                    class="ti-plus"></i>{{__('common.New Contact')}}</a>
                        </li>
                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route('contact_csv_upload')}}"><i class="ti-export"></i>{{__('common.Upload Via CSV')}}</a>
                        </li>
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
                                <th scope="col">{{__('common.Sl')}}</th>
                                <th scope="col">{{__('common.Contact ID')}}</th>
                                <th scope="col">{{__('common.Supplier Name')}}</th>
                                <th scope="col">{{__('common.Email')}}</th>
                                <th scope="col">{{__('common.Phone')}}</th>
                                <th scope="col">{{__('common.Pay Term')}}</th>
                                <th scope="col">{{__('common.Tax Number')}}</th>
                                <th scope="col">{{ __('setting.Active') }}</th>
                                <th scope="col">{{__('common.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($suppliers as $key => $supplier_value)
                                <tr>
                                    <th>{{$key+1}}</th>
                                    <td>{{$supplier_value->contact_id}}</td>
                                    <td>{{$supplier_value->name}}</td>
                                    <td>{{$supplier_value->email}}</td>
                                    <td>{{$supplier_value->mobile}}</td>
                                    <td>{{$supplier_value->pay_term}} {{$supplier_value->pay_term_condition}} </td>
                                    <td>{{$supplier_value->tax_number}}</td>
                                    <td>
                                        <label class="switch_toggle" for="active_checkbox{{ $supplier_value->id }}">
                                            <input type="checkbox" id="active_checkbox{{ $supplier_value->id }}" @if ($supplier_value->is_active == 1) checked @endif value="{{ $supplier_value->id }}" onchange="update_active_status(this)" {{ permissionCheck('languages.update_active_status') ? '' : 'disabled' }}>
                                            <div class="slider round"></div>
                                        </label>
                                    </td>
                                    <td>
                                        <!-- shortby  -->
                                        <div class="dropdown CRM_dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                {{__('common.Select')}}
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                <a href="{{route('add_contact.edit',$supplier_value->id)}}" class="dropdown-item" type="button">{{__('common.Edit')}}</a>
                                                <a href="{{route('supplier.view',$supplier_value->id)}}" class="dropdown-item" type="button">{{__('common.View')}}</a>
                                                <a onclick="confirm_modal('{{route('add_contact.delete',$supplier_value->id)}}');" class="dropdown-item ">{{__('common.Delete')}}</a>

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
        @include('backEnd.partials.delete_modal')
        <div class="modal fade admin-query" id="Import_Customer">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('common.Import Customer')}}</h4>
                        <button type="button" class="close " data-dismiss="modal">
                            <i class="ti-close "></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <p>Opposed to using Content here, content here, making it look like readable
                                        English. </p>
                                </div>
                                <div class="col-12">
                                    <div class="primary_input mb-35">
                                        <label class="primary_input_label" for="">{{__('common.Choose CSV File')}}</label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="placeholderFileOneName"
                                                   placeholder="Browse CSV file" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg"
                                                       for="document_file_1">{{__('common.Browse')}}</label>
                                                <input type="file" class="d-none" name="file" id="document_file_1">
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center">
                                    <div class="d-flex justify-content-center">
                                        <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent"
                                                data-dismiss="modal" type="button"><i class="ti-check"></i> {{__('common.Import Item')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--/ Import Lead -->
    </div>
@endsection

@push("scripts")
   <script type="text/javascript">
       function update_active_status(el){
           if(el.checked){
               var status = 1;
           }
           else{
               var status = 0;
           }
           $.post('{{ route('contact.update_active_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
               if(data == 1){
                   toastr.success("Updated Successfully","Success");
               }
               else{
                   toastr.error('Something went wrong');
               }
           });
       }
    </script>
@endpush
