@extends('backEnd.master')
@section('mainContent')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('dashboard.Payment Due List')}}</h3>
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
                                <th scope="col">{{__('sale.Invoice No')}}</th>
                                <th scope="col">{{__('sale.Date')}}</th>
                                <th scope="col">{{__('showroom.Branch')}}</th>
                                <th scope="col">{{__('sale.Payable Amount')}}</th>
                                <th scope="col">{{__('sale.Customer')}}</th>
                                <th scope="col">{{__('common.Paid Amount')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dues as $sale)
                                <tr>
                                    <th><a href="javascript:void(0)" onclick="getDetails({{ $sale->id }})">{{$sale->invoice_no}}</a></th>
                                    <td class="nowrap">{{$sale->date}}</td>
                                    <td>{{$sale->saleable->name}}</td>
                                    <td>{{single_price($sale->payable_amount)}}</td>
                                    <td>{{$sale->customer->name}}</td>
                                    <td>{{$sale->payments->sum('amount') - $sale->payments->sum('return_amount')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="getDetails">
    </div>
    @include('backEnd.partials.delete_modal')
    @include('backEnd.partials.approve_modal')
@endsection
@push('scripts')
    <script>
        function saleInfo(id) {
            let input = '<input type="hidden" name="id" value="' + id + '" "> ';
            $('#delivery_info').append(input);
        }

        function getDetails(el){
            $.post('{{ route('get_sale_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
