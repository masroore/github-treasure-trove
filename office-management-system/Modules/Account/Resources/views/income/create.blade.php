@extends('backEnd.master')
@section('mainContent')

    <div id="add_payment">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('common.Add New') }} {{ __('inventory.Income') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{ route('income.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">




                                    <div class="col-xl-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('account.Date')}} *</label>
                                            <div class="primary_datepicker_input">
                                                <div class="no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="">
                                                            <input placeholder="Date" class="primary_input_field primary-input date form-control" id="startDate" type="text" name="date" value="{{ date('m/d/Y') }}" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                    <button class="" type="button">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </button>
                                                </div>
                                            </div>
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
                                            <label class="primary_input_label" for="">{{__('A / C Head')}} *</label>
                                            <select class="primary_select mb-15 payment_to" name="account_id" id="account_id" required>
                                                <option>{{__('account.Select one')}}</option>
                                                @foreach ($accounts as $key => $account)
                                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('payment_from')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('account.Amount')}} *</label>
                                            <input class="primary_input_field" name="amount" placeholder="Amount" type="number">
                                            <span class="text-danger">{{$errors->first('amount')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('account.Transaction Note')}} </label>
                                            <input class="primary_input_field" name="note" placeholder="{{__('account.Transaction Note')}}" type="text">
                                            <span class="text-danger">{{$errors->first('note')}}</span>
                                        </div>
                                    </div>



                                </div>

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
        setInterval(function() {
            sum_amount();
        }, 3000);
        function sum_amount()
        {
            var sub_amounts = $("input[name='sub_amount[]']").map(function(){return $(this).val();}).get();
            var sum = 0;
            for (var i = 0; i < sub_amounts.length; i++) {
                sum = parseInt(sum) + parseInt(sub_amounts[i]);
            }
            $("#sub_amounts").val(sum);
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
