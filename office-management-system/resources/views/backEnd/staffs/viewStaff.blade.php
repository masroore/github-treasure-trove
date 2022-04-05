@extends('backEnd.master')
@section('mainContent')
<section class="mb-40 student-details">

@if(session()->has('message-success'))
   <div class="alert alert-success">
      {{ session()->get('message-success') }}
   </div>
   @elseif(session()->has('message-danger'))
   <div class="alert alert-danger">
      {{ session()->get('message-danger') }}
   </div>
   @endif
   <div class="container-fluid p-0">
      <div class="row">
         <div class="col-lg-3">
            <!-- Start Student Meta Information -->
            <div class="main-title">
               <h3 class="mb-20">@lang('common.Staff Info')</h3>
            </div>
            <div class="student-meta-box">
               <div class="student-meta-top"></div>
               <img class="student-meta-img img-100" src="{{ file_exists(@$staffDetails->user->avatar) ? asset(@$staffDetails->user->avatar) : asset('public/backEnd/img/Fred_man-512.png') }}"  alt="">
               <div class="white-box">
                  <div class="single-meta mt-10">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('common.Name') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{@$staffDetails->user->name}}@endif
                        </div>
                     </div>
                  </div>
                  @if ($staffDetails->user->role_id != 1)
                      <div class="single-meta">
                         <div class="d-flex justify-content-between">
                            <div class="name">
                               {{ __('common.Employee Id') }}
                            </div>
                            <div class="value">
                               @if(isset($staffDetails)){{$staffDetails->employee_id}}@endif
                            </div>
                         </div>
                      </div>
                      <div class="single-meta">
                         <div class="d-flex justify-content-between">
                            <div class="name">
                               {{ __('common.Opening Balance') }}
                            </div>
                            <div class="value">
                               @if(isset($staffDetails)){{single_price($staffDetails->opening_balance)}}@endif
                            </div>
                         </div>
                      </div>
                  @endif
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('common.Username') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{@$staffDetails->user->username}}@endif
                        </div>
                     </div>
                  </div>
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('role.Role') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{@$staffDetails->user->role->name}}@endif
                        </div>
                     </div>
                  </div>
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('department.Department') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{ !empty($staffDetails->department != null)? $staffDetails->department->name:''}}@endif
                        </div>
                     </div>
                  </div>
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('showroom.Branch') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{ @$staffDetails->showroom->name }}@endif
                        </div>
                     </div>
                  </div>
                  <div class="single-meta">
                     <div class="d-flex justify-content-between">
                        <div class="name">
                           {{ __('inventory.Warehouse') }}
                        </div>
                        <div class="value">
                           @if(isset($staffDetails)){{ !empty($staffDetails->warehouse != null)? $staffDetails->warehouse->name:''}}@endif
                        </div>
                     </div>
                  </div>
                   @if ($staffDetails->user->role_id != 1)
                      <div class="single-meta">
                         <div class="d-flex justify-content-between">
                            <div class="name">
                               {{ __('common.Date of Joining') }}
                            </div>
                            <div class="value">
                               @if(isset($staffDetails))
                               {{ date(app('general_setting')->dateFormat->format, strtotime($staffDetails->date_of_joining)) }}
                               @endif
                            </div>
                         </div>
                      </div>
                      <div class="single-meta">
                         <div class="d-flex justify-content-between">
                            <div class="name">
                               {{ __('common.Employment Type') }}
                            </div>
                            <div class="value">
                               @if(isset($staffDetails))
                               {{ $staffDetails->employment_type }}
                               @endif
                            </div>
                         </div>
                      </div>
                      <div class="single-meta">
                         <div class="d-flex justify-content-between">
                            <div class="name">
                               {{ __('common.Last Date Of Provisional Period') }}
                            </div>
                            <div class="value">
                               @if(isset($staffDetails))
                               {{ date(app('general_setting')->dateFormat->format, strtotime(\Carbon\Carbon::now()->addMonths($staffDetails->provisional_months))) }}
                               @endif
                            </div>
                         </div>
                      </div>
                  @endif
               </div>
            </div>
            <!-- End Student Meta Information -->
         </div>
         <!-- Start Student Details -->
         <div class="col-lg-9 staff-details">
            <ul class="nav nav-tabs tabs_scroll_nav" role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" href="#studentProfile" role="tab" data-toggle="tab">{{ __('common.Profile') }}</a>
               </li>
               @if ($staffDetails->user->role->type != "system_user")
                   <li class="nav-item">
                      <a class="nav-link" href="#staffDocuments" role="tab" data-toggle="tab">{{ __('common.Documents') }}</a>
                   </li>
                  
                   <li class="nav-item">
                      <a class="nav-link" href="#Transactions" role="tab" data-toggle="tab">{{ __('common.Transactions') }}</a>
                   </li>
               @endif
               <li class="nav-item edit-button">
                  <a href="{{ route('staffs.edit', $staffDetails->id) }}" class="primary-btn small fix-gr-bg">{{ __('common.Edit') }}
                  </a>
               </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
               <!-- Start Profile Tab -->
               <div role="tabpanel" class="tab-pane fade show active" id="studentProfile">
                  <div class="white-box">
                     <h4 class="stu-sub-head">{{ __('common.Personal Info') }}</h4>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-5">
                              <div class="">
                                 {{ __('common.Phone') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-6">
                              <div class="">
                                 @if(isset($staffDetails)){{$staffDetails->phone}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="single-info">
                        <div class="row">
                           <div class="col-lg-5 col-md-6">
                              <div class="">
                                 {{ __('common.Email') }}
                              </div>
                           </div>
                           <div class="col-lg-7 col-md-7">
                              <div class="">
                                 @if(isset($staffDetails)){{@$staffDetails->user->email}}@endif
                              </div>
                           </div>
                        </div>
                     </div>
                     @if ($staffDetails->user->role_id != 1)
                         <div class="single-info">
                            <div class="row">
                               <div class="col-lg-5 col-md-6">
                                  <div class="">
                                    {{ __('common.Date of Birth') }}
                                  </div>
                               </div>
                               <div class="col-lg-7 col-md-7">
                                  <div class="">
                                     @if(isset($staffDetails))
                                     {{$staffDetails->date_of_birth != ""? date('m/d/Y', strtotime($staffDetails->date_of_birth)):''}}
                                     @endif
                                  </div>
                               </div>
                            </div>
                         </div>
                         <!-- Start Parent Part -->
                         <h4 class="stu-sub-head mt-40">{{ __('common.Address') }}</h4>
                         <div class="single-info">
                            <div class="row">
                               <div class="col-lg-5 col-md-5">
                                  <div class="">
                                     {{ __('common.Current Address') }}
                                  </div>
                               </div>
                               <div class="col-lg-7 col-md-6">
                                  <div class="">
                                     @if(isset($staffDetails)){{$staffDetails->current_address}}@endif
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="single-info">
                            <div class="row">
                               <div class="col-lg-5 col-md-5">
                                  <div class="">
                                     {{ __('common.Permanent Address') }}
                                  </div>
                               </div>
                               <div class="col-lg-7 col-md-6">
                                  <div class="">
                                     @if(isset($staffDetails)){{$staffDetails->permanent_address}}@endif
                                  </div>
                               </div>
                            </div>
                         </div>
                     <!-- End Parent Part -->
                         <!-- Start Transport Part -->
                         <h4 class="stu-sub-head mt-40">{{ __('common.Bank Account Details') }}</h4>
                         <div class="single-info">
                            <div class="row">
                               <div class="col-lg-5 col-md-5">
                                  <div class="">
                                     {{ __('common.Account Name') }}
                                  </div>
                               </div>
                               <div class="col-lg-7 col-md-6">
                                  <div class="">
                                     @if(isset($staffDetails)){{$staffDetails->bank_account_name}}@endif
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="single-info">
                            <div class="row">
                               <div class="col-lg-5 col-md-5">
                                  <div class="">
                                    {{ __('common.Bank Account Number') }}
                                  </div>
                               </div>
                               <div class="col-lg-7 col-md-6">
                                  <div class="">
                                     @if(isset($staffDetails)){{$staffDetails->bank_account_no}}@endif
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="single-info">
                            <div class="row">
                               <div class="col-lg-5 col-md-5">
                                  <div class="">
                                     {{ __('common.Bank Name') }}
                                  </div>
                               </div>
                               <div class="col-lg-7 col-md-6">
                                  <div class="">
                                     @if(isset($staffDetails)){{$staffDetails->bank_name}}@endif
                                  </div>
                               </div>
                            </div>
                         </div>
                         <div class="single-info">
                            <div class="row">
                               <div class="col-lg-5 col-md-5">
                                  <div class="">
                                     {{ __('common.Bank Branch Name') }}
                                  </div>
                               </div>
                               <div class="col-lg-7 col-md-6">
                                  <div class="">
                                     @if(isset($staffDetails)){{$staffDetails->bank_branch_name}}@endif
                                  </div>
                               </div>
                            </div>
                         </div>
                         <!-- End Transport Part -->
                     @endif
                  </div>
               </div>
               <!-- End Profile Tab -->
               @if(isset($staffDetails))<input type="hidden" name="user_id" id="user_id" value="{{ @$staffDetails->user->id }}">@endif
              
               <!-- End payroll Tab -->
               <!-- Start Documents Tab -->
               <div role="tabpanel" class="tab-pane fade" id="staffDocuments">
                  <div class="white-box">
                     <div class="text-right mb-20">
                        <button type="button" data-toggle="modal" data-target="#add_document_madal" class="primary-btn tr-bg text-uppercase bord-rad">
                        {{__('common.Upload Document')}}
                        <span class="pl ti-upload"></span>
                        </button>
                     </div>
                     <div class="QA_section QA_section_heading_custom check_box_table">
                         <div class="QA_table ">
                             <table class="table Crm_table_active">
                                 <thead>
                                 <tr>
                                     <th scope="col">{{__('common.Document Title')}}</th>
                                     <th scope="col">{{__('common.Action')}}</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                     @isset($staffDocuments)
                                         @foreach ($staffDocuments as $key => $staffDocument)
                                             <tr>
                                                 <td> <a href="{{asset($staffDocument->documents)}}" download target="_blank">{{ $staffDocument->name }}</a></td>
                                                 <td>
                                                     <div class="dropdown CRM_dropdown">
                                                         <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                 id="dropdownMenu2" data-toggle="dropdown"
                                                                 aria-haspopup="true"
                                                                 aria-expanded="false">
                                                             {{ __('common.Select') }}
                                                         </button>
                                                         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                             <a href="{{asset($staffDocument->documents)}}" class="dropdown-item" download>{{__('common.Download')}}</a>
                                                             <a onclick="confirm_modal('{{route('staff_document.destroy', $staffDocument->id)}}');" class="dropdown-item">{{__('common.Delete')}}</a>
                                                         </div>
                                                     </div>
                                                 </td>
                                             </tr>
                                         @endforeach
                                     @endisset
                                 </tbody>
                             </table>
                         </div>
                     </div>
                  </div>
               </div>
               <!-- End Documents Tab -->
           
               <!-- Add Document modal form start-->
               <div class="modal fade admin-query" id="add_document_madal">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title">{{__('common.Upload Document')}}</h4>
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                           <div class="container-fluid">
                              <form class="" action="{{ route('staff_document.store') }}" method="post" enctype="multipart/form-data">
                                  @csrf
                                  <div class="row">
                                    <input type="hidden" name="staff_id" value="{{$staffDetails->id}}">
                                    <div class="col-xl-12">
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="">{{ __('common.Name') }}</label>
                                            <input name="name" class="primary_input_field name" placeholder="{{ __('common.Name') }}" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('common.Avatar') }}</label>
                                            <div class="primary_file_uploader">
                                                <input class="primary-input" type="text" id="placeholderFileOneName"
                                                       placeholder="Browse file" readonly="">
                                                <button class="" type="button">
                                                    <label class="primary-btn small fix-gr-bg" for="document_file_1">{{ __('common.Browse') }}</label>
                                                    <input type="file" class="d-none" name="file" id="document_file_1">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-lg-12 text-center mt-40">
                                        <div class="mt-40 d-flex justify-content-between">
                                           <button type="button" class="primary-btn tr-bg" data-dismiss="modal">{{ __('common.Cancel') }}</button>
                                           <button class="primary-btn fix-gr-bg" type="submit">{{ __('common.Save') }}</button>
                                        </div>
                                     </div>
                                  </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            
               @if ($staffDetails->user->role->type != "system_user")
                   <div role="tabpanel" class="tab-pane fade" id="Transactions">
                      <div class="white-box">
                          <div class="QA_section QA_section_heading_custom check_box_table">
                              <ul class="d-flex">
                                  <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" target="_blank" href="{{route('staffs.report_print',$staffDetails->id)}}"><i class="ti-pen"></i>{{__('report.Print')}}</a></li>
                              </ul>
                              <div class="QA_table ">
                                  <table class="table">
                                      <thead>
                                          <tr>
                                              <th scope="col">{{ __('account.Date') }}</th>
                                              <th scope="col">{{ __('account.Description') }}</th>
                                              <th scope="col">{{ __('account.Debit') }}</th>
                                              <th scope="col">{{ __('account.Credit') }}</th>
                                              <th scope="col" class="text-right">{{ __('account.Balance') }}</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @php
                                              $chartAccount = Modules\Account\Entities\ChartAccount::where('contactable_type', 'App\User')->where('contactable_id', @$staffDetails->user->id)->first();
                                              if ($chartAccount && $chartAccount->transactions()->exists())
                                              {
                                                 $transactions =  $chartAccount->transactions()->Approved()->get();
                                              }
                                              $currentBalance = 0 + $staffDetails->opening_balance;
                                          @endphp

                                          <tr>
                                              <td> {{ __('account.Openning Balance') }}</td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td class="text-right">{{ single_price($currentBalance) }}</td>
                                          </tr>
                                          @isset($transactions)
                                          @foreach ($transactions as $key => $payment)
                                              @if ($payment->type == "Cr")
                                                  @php
                                                      $currentBalance -= $payment->amount;
                                                  @endphp
                                              @else
                                                  @php
                                                      $currentBalance += $payment->amount;
                                                  @endphp
                                              @endif
                                              <tr>
                                                  <td>{{ date(app('general_setting')->dateFormat->format, strtotime(@$payment->voucherable->date)) }}</td>
                                                  <td>{{ @$payment->voucherable->narration }}</td>
                                                  <td>
                                                      @if ($payment->type == "Dr")
                                                          {{ single_price($payment->amount) }}
                                                          <input type="hidden" name="debit[]" value="{{ $payment->amount }}">
                                                      @endif
                                                  </td>
                                                  <td>
                                                      @if ($payment->type == "Cr")
                                                          {{ single_price($payment->amount) }}
                                                          <input type="hidden" name="credit[]" value="{{ $payment->amount }}">
                                                      @endif
                                                  </td>
                                                  <td class="text-right">{{ single_price($currentBalance) }}</td>
                                              </tr>
                                          @endforeach
                                          <tr>
                                              <td> {{ __('account.Current Balance') }}</td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td class="text-right">{{ single_price($currentBalance) }}</td>
                                          </tr>
                                          @endisset
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                   </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</section>
<div class="edit_form">

</div>

@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script type="text/javascript">
       

      
    </script>
@endpush
