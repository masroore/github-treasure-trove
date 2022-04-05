@extends('backEnd.master')
@section('mainContent')

    <div id="add_payment">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('common.Add New') }} {{ __('account.Contra Voucher') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{ route('contra.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('account.Date')}} *</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control" id="startDate" type="text" name="date" value="" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('account.Account Type')}} *</label>
                                            <select class="primary_select mb-15 payment_from" name="account_type" id="account_type" onchange="get_dynamic_text()" required>
                                                <option>{{__('account.Select one')}}</option>
                                                <option value="debit">{{ __('account.Debit') }}</option>
                                                <option value="credit">{{ __('account.Credit') }}</option>
                                            </select>
                                            <span class="text-danger">{{$errors->first('account_type')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('account.Select Account')}} *</label>
                                            <select class="primary_select mb-15 payment_from" name="account_id" id="account_id" required>
                                                <option>{{__('account.Select one')}}</option>
                                                @foreach ($accounts as $key => $account)
                                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for=""> {{__("account.Narration")}} </label>
                                            <input class="primary_input_field" name="narration" placeholder="{{__("account.Narration")}}" type="text" value="{{ old('narration') }}">
                                            <span class="text-danger">{{$errors->first('narration')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for=""> {{__("account.Amount")}} *</label>
                                            <input class="primary_input_field" name="main_amount" id="main_amount" value="0" type="number" min="0" step="0.01">
                                            <span class="text-danger">{{$errors->first('main_amount')}}</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <label class="primary_input_label text-center" for="" id="dynamic_text">{{ __('account.Please Enter Your credit details') }}</label>
                                <label class="h1 primary_input_label text-center gradient-color2" for="" id="alert_txt"></label>
                                <hr>
                                <div class="row form">
                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('Payment To')}} *</label>
                                            <select class="primary_select mb-15 payment_to" name="sub_account_id[]" id="debit_account_id" required>
                                                <option>{{__('account.Select one')}}</option>
                                                @foreach ($accounts as $key => $account)
                                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('payment_from')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('account.Amount')}} *</label>
                                            <input class="primary_input_field" name="sub_amount[]" placeholder="Amount" type="number">
                                            <span class="text-danger">{{$errors->first('sub_amount')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('account.Narration')}} </label>
                                            <input class="primary_input_field" name="sub_narration[]" placeholder="Narration" type="text">
                                            <span class="text-danger">{{$errors->first('amount')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('common.Action')}} </label>
                                            <button class="primary-btn btn-sm fix-gr-bg" id="add_payment_to_form"><i class="ti-plus"></i>{{__('account.Add')}}</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="sub_amounts" id="sub_amounts" value="">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="submit_btn text-center ">
                                            <button class="primary-btn semi_large2 fix-gr-bg"><i class="ti-check"></i>{{__("common.Save")}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push("scripts")
    <script type="text/javascript">
        $(document).ready(function () {

        });
        setInterval(function() {
            sum_amount();
        }, 3000);

        function sum_amount()
        {
            var main_amount = $('#main_amount').val();
            var sub_amounts = $("input[name='sub_amount[]']").map(function(){return $(this).val();}).get();
            var sum = 0;
            for (var i = 0; i < sub_amounts.length; i++) {
                sum = parseInt(sum) + parseInt(sub_amounts[i]);
            }
            $("#total_sum").html(sum);
            if (main_amount < sum) {
                var difference = 0;
                difference = parseInt(sum) - parseInt(main_amount);
                $("#alert_txt").html("**** Your given amount is larger than Total Amount and Difference is : " + difference + "$ ****");
            }
            else {
                $("#alert_txt").html("");
            }
            $("#sub_amounts").val(sum);
        }

        function get_dynamic_text(){
            var account_type = $('#account_type').val();
            if (account_type == 'debit') {
                $("#dynamic_text").html("---- Please Enter Your Credit details ----");
            }else {
                $("#dynamic_text").html("---- Please Enter Your Debit details ----");
            }
        }

        $(document).ready(function(){
            var i = 0;
            $(document).on('click', '#add_payment_to_form', function(e){
                i++;
                e.preventDefault();
                $( ".form" ).append('<div class="col-lg-4 row_id_'+i+'">'+
                    '<div class="primary_input mb-15">'+
                        '<select class="primary_select mb-15 payment_to" name="sub_account_id[]" id="payment_to" required>'+
                            '<option>Select one</option>'+
                            '@foreach ($accounts as $key => $chartAccount)'+
                                '<option value="{{ $chartAccount->id }}">{{ $chartAccount->name }}</option>'+
                            '@endforeach'+
                        '</select>'+
                    '</div>'+
                '</div>'+
                '<div class="col-lg-3 row_id_'+i+'">'+
                    '<div class="primary_input mb-15">'+
                        '<input class="primary_input_field" name="sub_amount[]" placeholder="Amount" type="number" value="">'+
                    '</div>'+
                '</div>'+
                '<div class="col-lg-4 row_id_'+i+'">'+
                    '<div class="primary_input mb-15">'+
                        '<input class="primary_input_field" name="sub_narration[]" placeholder="Narration" type="text" value="">'+
                    '</div>'+
                '</div>'+
                '<div class="col-lg-1 row_id_'+i+'">'+
                    '<div class="primary_input mb-15">'+
                        '<button class="primary-btn btn-sm fix-gr-bg delete_payment_to_form" data-status="'+i+'"><i class="ti-trash"></i>Delete</button>'+
                    '</div>'+
                '</div>' );
                $('select').niceSelect();
            });

            $(document).on('click', '.delete_payment_to_form', function(e){
                e.preventDefault();
                var i = $(this).data('status');
                $('.row_id_'+i).remove();
            });
        });

    </script>
@endpush
