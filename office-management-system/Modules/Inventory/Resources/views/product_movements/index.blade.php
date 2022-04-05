@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('inventory.Product Movement') }}</h3>
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
                                        <th scope="col">{{ __('sale.Branch / Warehouse') }}</th>
                                        <th scope="col">{{ __('sale.Purpose') }}</th>
                                        <th scope="col">{{ __('sale.Product Name') }}</th>
                                        <th scope="col">{{ __('sale.Quantity') }}</th>
                                        <th scope="col">{{ __('sale.Date') }}</th>
                                        <th scope="col">{{ __('sale.Created User') }}</th>
                                        <th scope="col">{{ __('sale.Updated User') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $key => $item)
                                        <tr>
                                            <th>{{ $key+1 }}</th>
                                            <th>{{ @$item->houseable->saleable->name }}</th>
                                            <td>{{ strtoupper($item->type) }}</td>
                                            <td>{{ @$item->productSku->product->product_name }}</td>
                                            <td class="text-center">{{ $item->in_out }}</td>
                                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime($item->date)) }}</td>
                                            <td>{{ userName($item->created_by) }}</td>
                                            <td class="text-center">{{ ($item->updated_by != null) ? userName($item->updated_by) : 'X' }}</td>
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
@endsection
