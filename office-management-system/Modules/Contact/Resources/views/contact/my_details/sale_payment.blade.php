@extends('backEnd.master')
@section('mainContent')

        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__('sale.Payment')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <form action="{{ route('stripe.index') }}" method="GET" id="payment_form"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="white_box_50px box_shadow_white">
                                @if ($sale->payments()->exists())
                                    <h3>Total Paid: <span>$ {{ $sale->payments()->sum('amount')}}</span></h3>
                                @endif

                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12">
                                        <!-- Prefix  -->

                                        <div class="pos_payment_method mt-20">
                                            <div class="row">
                                                <div class="col-md-6 col-lg-6 col-sm-12">
                                                    <div class="primary_input mb-15">
                                                        @php
                                                        $payable = $sale->amount - $sale->payments()->sum('amount');
                                                        @endphp
                                                        <label class="primary_input_label" for="">{{__('sale.Amount')}}</label>
                                                        <input type="text" name="amount"
                                                               class="primary_input_field amount" value="{{  $payable < 0 ? 0 : $payable  }}" min="1" max="{{  $payable < 0 ? 0 : $payable  }}"  required=""
                                                               placeholder="{{__('sale.Enter Amount')}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-6 col-sm-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="">{{__('sale.Payment Method')}}</label>
                                                        <select class="primary_select mb-15 payment_method"
                                                                name="payment_method">
                                                            <option selected disabled value="">{{__("sale.Select")}}</option>

                                                            <option value="stripe">{{__('sale.Stripe')}}</option>
                                                            <option value="paypal">{{__('sale.Paypal')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="quick_amounts" name="quick_amounts">

                                        <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                                    </div>

                                </div>
                                <div class="row mt-30">
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <h6> {{__('sale.Total Quantity')}} : {{$sale->total_quantity}}</h6>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <h6> {{__('sale.Total Payable')}} : $ <span
                                                class="total_payable">{{  $payable < 0 ? 0 : $payable  }}</span></h6>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4">
                                        <button type="submit" class="primary-btn semi-large fix-gr-bg">
                                            {{__('sale.Finalize Payment')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                let i = 0;
                let amounts = [];
                let cash_amount = 0;
                $('.quick_cash_number').hide()
                $(".btn-copy").on('click', function () {
                    i += 1;
                    let main_div = '<div class="pos_payment_method mt-20">';
                    let row = '<div class="row">';
                    let cols = '<div class="col-md-6 col-lg-6 col-sm-12">';
                    let input_div = '<div class="primary_input mb-15">';
                    let label = '<label class="primary_input_label" for="">Amount</label>';
                    let label2 = ' <label class="primary_input_label" for="">Payment Method</label>';
                    let input_field = '<input type="text" name="amount[]" class="primary_input_field amount" placeholder="Enter Amount"></div></div>';
                    let select = '<select class="primary_select mb-15 payment_method" id="payment_method'+i+'" name="payment_method[]">'+
                    '<option selected disabled>Select</option>'+
                    '<option value="cash-00-Cash">Cash</option>'+
                    '@foreach(\Modules\Account\Entities\ChartAccount::where('configuration_group_id', 2)->get() as $bank_account)'+
                    '<option value="bank-{{ $bank_account->id }}">{{ $bank_account->name }}</option>'+
                    '@endforeach'+
                    '</select>'+
                    '</div></div></div></div>';
                    if ($('.pos_payment_method').length == 1)
                        $('.pos_payment_method').after(main_div + row + cols + input_div + label + input_field + cols + label2 + select);
                    else
                        $('.pos_payment_method').last().after(main_div + row + cols + input_div + label + input_field + cols + label2 + select);

                    $('select').niceSelect(); // add this
                })
                $(document).on('change', '.payment_method', function () {
                    let row = '<div class="row bank_info appended_inputs">';
                    let cols = '<div class="col-md-6 col-lg-6 col-sm-12">';
                    let input_div = '<div class="primary_input mb-15">';
                    let label = '<label class="primary_input_label" for="">Bank Name</label>';
                    let label2 = ' <label class="primary_input_label" for="">Branch</label>';
                    let label3 = ' <label class="primary_input_label" for="">Account No</label>';
                    let label4 = ' <label class="primary_input_label" for="">Account Owner</label>';
                    let bank_name = '<input type="text" name="bank_name[]" class="primary_input_field" placeholder="Bank Name"></div></div>';
                    let branch = '<input type="text" name="branch[]" class="primary_input_field" placeholder="Branch"></div></div>';
                    let account_no = '<input type="text" name="account_no[]" class="primary_input_field" placeholder="Account No"></div></div>';
                    let owner = '<input type="text" name="account_owner[]" class="primary_input_field" placeholder="Account Owner"></div></div>';
                    let end_row = '</div>';

                    if ($(this).val().split('-')[0] == 'bank')
                        $(this).closest($('.pos_payment_method'))
                            .append(row + cols + input_div + label + bank_name + cols + input_div + label2 + branch + end_row + row + cols + input_div + label3 + account_no + cols + input_div + label4 + owner + end_row)
                    else {

                        $(this).parent().parent().parent().find('.bank_info').remove();
                    }
                });

                $(document).on('click', '.add_cash', function () {
                    let selector = $(this).children('.quick_cash_number');
                    let value = selector.text();
                    let amount = $(this).data('id');
                    let total_amount = $('.total_amount').text();
                    let total_payable = parseFloat($('.total_payable').text());

                    let calculated_amount = (parseFloat(total_amount) + parseFloat(amount)).toFixed(2);
                    $('.total_amount').text(calculated_amount);
                    selector.show()

                    if (total_payable < calculated_amount)
                        $('.return_amount').text(calculated_amount - total_payable);

                    if (value) {
                        selector.text(parseInt(value) + 1)
                        amounts.push(amount);
                        $('.quick_amounts').val(amounts);
                    } else {
                        selector.text(1);
                        amounts.push(amount);
                        $('.quick_amounts').val(amounts)
                    }
                })

                $(document).on('click', '.clear_quick_cash', function () {
                    amounts = [];
                    let selector = $('.quick_cash_number');
                    selector.hide();
                    selector.text('');
                    let total_amount = 0;
                    $('.quick_amounts').val('');

                    $.each($('.amount'), function (index, value) {
                        let amount = $(this).val();
                        total_amount += parseFloat(amount);
                    });
                });

                $(document).on('focusout', '.amount', function () {
                    let selector = $('.total_amount');
                    let initial_amount = selector.text()
                    let amount = $(this).val();
                    let total_payable = parseFloat($('.total_payable').text());

                    let total_amount = 0;
                    if (!amount)
                            amount = 0;
                    total_amount = (parseFloat(amount) + parseFloat(initial_amount));

                    $('.total_amount').text(total_amount);

                    if (total_payable < total_amount)
                        $('.return_amount').text(total_amount - total_payable);
                })

                $(document).on('change', '.payment_method', function(){

                    let option = $('.payment_method').val();

                    if(option == 'stripe')
                    {
                        $('#payment_form').attr('action','{{ route("stripe.index") }}')
                        $('#payment_form').attr('method','GET')
                    }else{
                        $('#payment_form').attr('action','{{ route("paypal.process") }}')
                        $('#payment_form').attr('method','POST')
                    }


                    console.log(option)
                })
            })

        </script>
    @endpush
@endsection
