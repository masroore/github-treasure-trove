@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">


                    <div class="col-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-md-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.Supplier purchase product list') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="QA_section QA_section_heading_custom check_box_table">
                            <div class="QA_table ">

                                 <table class="table table-bordered">
                                        <tr class="m-0">
                                            <th scope="col">{{__('sale.Product Name')}}</th>
                                            <th scope="col">{{__('sale.SKU')}}</th>
                                            <th scope="col">{{__('sale.Price')}}</th>
                                            <th scope="col">{{__('sale.Quantity')}}</th>
                                            <th scope="col">{{__('sale.Tax')}}</th>
                                            <th scope="col">{{__('sale.Discount')}}</th>
                                            <th scope="col">{{__('sale.Invoice')}}</th>
                                            <th scope="col">{{__('sale.Date')}}</th>
                                            <th scope="col">{{__('sale.SubTotal')}}</th>
                                        </tr>

                                        @foreach($purchaseHistory as $key=> $item)
                                            @php
                                                $variantName = variantName($item);
                                            @endphp

                                            @if ($item->productable->product)
                                                @php
                                                    $type =$item->product_sku_id.",'sku'" ;
                                                @endphp
                                                <tr>
                                                    <td><input type="hidden" name="items[]" value="{{$item->product_sku_id}}">
                                                        {{$item->productable->product->product_name}} <br>
                                                        @if ($variantName)
                                                            ({{ $variantName }})
                                                        @endif
                                                    </td>
                                                    <td>{{$item->productable->sku}}</td>
                                                    <td>{{single_price($item->price)}}</td>
                                                    <td>{{$item->quantity}}</td>
                                                    <td>{{$item->tax}}%</td>
                                                    <td>{{$item->discount}}%</td>
                                                    <td>{{$item->itemable->invoice_no}}</td>
                                                    <td>{{$item->itemable->date}}</td>
                                                    <td>{{single_price($item->sub_total)}}</td>
                                                </tr>
                                            @else
                                                @php
                                                    $type =$item->product_sku_id.",'combo'" ;
                                                @endphp
                                                <tr>
                                                    <td>{{$item->productable->name}} </br>
                                                    </td>

                                                    <td class="product_sku"></td>

                                                    <td>{{single_price($item->price)}}</td>

                                                    <td>{{$item->quantity}}</td>

                                                    <td>{{$item->tax}}%</td>

                                                    <td>{{$item->discount}}%</td>
                                                    <td>{{$item->itemable->invoice_no}}</td>
                                                    <td>{{$item->itemable->date}}</td>
                                                    <td> {{single_price($item->sub_total)}} </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tfoot>

                                        </tfoot>
                                    </table>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
    </section>
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
