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
                                        <h3 class="mb-0" >{{__('contact.Supplier Return')}}</h3>
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
                                                        <th scope="col">{{__('sale.Reference No')}}</th>
                                                        <th scope="col">{{__('common.Customer')}}</th>
                                                        <th scope="col">{{__('common.Paid Status')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($supplier->purchases->where('return_status', 1) as $key => $sale)
                                                        <tr>
                                                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime($sale->created_at)) }}</td>
                                                            <td><a onclick="getDetails({{ $sale->id }})">{{$sale->invoice_no}}</a></td>
                                                            <td>
                                                                @if ($sale->supplier)
                                                                    {{@$sale->supplier->name}}
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if ($sale->return_status == 0)
                                                                    <h6><span class="badge_4">{{__('common.Pending')}}</span></h6>
                                                                @else
                                                                    <h6><span class="badge_1">{{__('common.Approve')}}</span></h6>
                                                                @endif
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
                </div>
            </div>
        </div>
    </section>


@endsection
@push('scripts')
    <script>
       

    </script>
@endpush
