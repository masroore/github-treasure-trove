@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.Customers')}} </h3>
                    @if(permissionCheck('add_contact.store'))
                    <ul class="d-flex">
                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route("add_contact.index")}}"><i class="ti-plus"></i>{{__('common.New Contact')}}</a>
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
                                <th scope="col">{{ __('common.Sl') }}</th>
                                <th scope="col">{{ __('common.Contact ID') }}</th>
                                <th scope="col">{{ __('common.Customer Name') }}</th>
                                <th scope="col">{{ __('common.Email') }}</th>
                                <th scope="col">{{ __('common.Phone') }}</th>
                                <th scope="col">{{ __('common.Pay Term') }}</th>
                                <th scope="col">{{ __('common.Tax Number') }}</th>
                                <th scope="col">{{ __('setting.Active') }}</th>
                                <th scope="col">{{ __('common.Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $key => $customer_value)
                                <tr>
                                    <th>{{$key+1}}</th>
                                    <td>{{$customer_value->contact_id}}</td>
                                    <td>{{$customer_value->name}}</td>
                                    <td>{{$customer_value->email}}</td>
                                    <td>{{$customer_value->mobile}}</td>
                                    <td>{{$customer_value->pay_term??''  }} {{$customer_value->pay_term_condition??'' }} </td>
                                    <td>{{$customer_value->tax_number}}</td>
                                    <td>
                                        <label class="switch_toggle" for="active_checkbox{{ $customer_value->id }}">
                                            <input type="checkbox" id="active_checkbox{{ $customer_value->id }}" @if ($customer_value->is_active == 1) checked @endif value="{{ $customer_value->id }}" onchange="update_active_status(this)" {{ permissionCheck('languages.update_active_status') ? '' : 'disabled' }}>
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
                                                 <a href="{{route('customer.view',$customer_value->id)}}" class="dropdown-item">{{__('common.View')}}</a>
                                                 @if(permissionCheck('add_contact.edit') && $customer_value->id > 1)
                                                 <a href="{{route('add_contact.edit',$customer_value->id)}}" class="dropdown-item">{{__('common.Edit')}}</a>
                                                 @endif

                                                 @if(permissionCheck('add_contact.destroy') && $customer_value->id > 1)

                                                    <a onclick="confirm_modal('{{route('add_contact.delete',$customer_value->id)}}');" class="dropdown-item ">{{__('common.Delete')}}</a>

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
    @include('backEnd.partials.delete_modal')
    <div id="Customer_info">

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
