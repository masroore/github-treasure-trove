@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="row">
                            <div class="col-12">
                                <div class="box_header">
                                    <div class="main-title">
                                        <h3 class="mb-0" >{{__('contact.Supplier Invoice')}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="">
                                            <table class="table Crm_table_active">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">{{__('sale.Date')}}</th>
                                                        <th scope="col">{{__('sale.Invoice')}}</th>
                                                        <th scope="col">{{__('sale.Reference No')}}</th>
                                                        <th scope="col">{{__('quotation.Supplier')}}</th>
                                                        <th scope="col">{{__('common.Purchesed By')}}</th>
                                                        <th scope="col">{{__('common.Paid Status')}}</th>
                                                        <th scope="col">{{__('common.Amount')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total = 0;
                                                    @endphp
                                                    @foreach ($supplier->purchases as $key => $purchase)
                                                    @php
                                                        $total += $purchase->amount;
                                                    @endphp
                                                        <tr>
                                                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime($purchase->created_at)) }}</td>
                                                            <td><a onclick="getDetails({{ $purchase->id }})">{{$purchase->invoice_no}}</a></td>
                                                            <td><a onclick="getDetails({{ $purchase->id }})">{{$purchase->ref_no}}</a></td>
                                                            <td>
                                                                @if ($purchase->supplier_id)
                                                                    {{@$purchase->supplier->name}}
                                                                @endif
                                                            </td>
                                                             <td>{{@$purchase->user->name}}</td>
                                                            <td>
                                                                @if ($purchase->is_paid == 0)
                                                                    <h6><span class="badge_4">{{__('sale.Unpaid')}}</span></h6>
                                                                @elseif ($purchase->is_paid == 1)
                                                                    <h6><span class="badge_4">{{__('sale.Partial')}}</span></h6>
                                                                @else
                                                                    <h6><span class="badge_1">{{__('sale.Paid')}}</span></h6>
                                                                @endif
                                                            </td>
                                                            <td>{{ $purchase->amount }}</td>
                                                        </tr>
                                                    @endforeach
                                                        <tr>
                                                            <td colspan="6">{{ __('common.Total') }}</td>
                                                            <td colspan="1">{{ $total }}</td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>

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
    <script>
       

    </script>
@endpush
