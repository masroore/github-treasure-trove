@extends('backEnd.master')
@section('mainContent')
    <div class="row">
        <div class="col-12">
            <div class="box_header common_table_header">
                <div class="main-title d-md-flex">
                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('report.Product Serial Report')}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="QA_section QA_section_heading_custom check_box_table">
                <div class="QA_table">
                    <!-- table-responsive -->
                    <div class="">
                        <table class="table Crm_table_active4">
                            <thead>
                            <tr>
                                <th scope="col">{{__('sale.Sl')}}</th>
                                <th scope="col">{{__('common.Serial Key')}}</th>
                                <th scope="col">{{__('common.Product Name')}}</th>
                                <th scope="col">{{__('common.Is Sold')}}</th>
                                <th scope="col">{{__('sale.Invoice')}}</th>
                                <th scope="col">{{__('report.Sold Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($serials as $key=> $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $item->seiral_no }}</td>
                                    <td>{{ @$item->product_sku->product->product_name }}</td>
                                    <td>
                                        @if ($item->is_sold == 0)
                                            <h6><span class="badge_4">{{__('common.Not Yet')}}</span></h6>
                                        @else
                                            <h6><span class="badge_1">{{__('common.Sold')}}</span></h6>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->product_item_details_part_number)
                                            <a onclick="getDetails({{ $item->product_item_details_part_number->sale_id }})">{{ @$item->product_item_details_part_number->sale->invoice_no }}</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->product_item_details_part_number)
                                            {{date(app('general_setting')->dateFormat->format, strtotime(@$item->product_item_details_part_number->created_at)) }}
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
    <div id="getDetails">

    </div>
@endsection
@push('scripts')
    <script>
        function getDetails(el){
            $.post('{{ route('get_sale_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#getDetails').html(data);
                $('#sale_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
