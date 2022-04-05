<div class="modal fade admin-query" id="payments">
    <div class="modal-dialog modal_1000px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('sale.Payments History')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row mt-10">
                        <div class="col-12">
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table ">
                                    <!-- table-responsive -->
                                    <div class="">
                                        <table class="table Crm_table_active3">
                                            <tr class="m-0">
                                                <th scope="col">{{__('sale.Date')}}</th>
                                                <th scope="col">{{__('sale.Payment Method')}}</th>
                                                <th scope="col">{{__('sale.Amount')}}</th>
                                            </tr>
                                            @php
                                                $total_amount = 0;
                                            @endphp

                                            @foreach($sale->payments as $key=> $payment)
                                                @php
                                                    $paid = $payment->amount - $payment->return_amount;
                                                    $total_amount += $paid;
                                                @endphp
                                                <tr>
                                                    <td>{{date(app('general_setting')->dateFormat->format, strtotime($payment->created_at))}}</td>
                                                    <td>{{$payment->payment_method}}</td>
                                                    <td> {{single_price($paid)}} </td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <td colspan="2"
                                                    style="text-align: right">{{__('purchase.Total Amount')}}</td>
                                                <td>{{single_price($total_amount)}}</td>
                                            </tr>
                                            </tfoot>
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
</div>
