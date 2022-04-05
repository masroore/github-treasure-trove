@extends('backEnd.master')
@section('mainContent')
    @if(session()->has('message-success'))
        <div class="alert alert-success mb-25" role="alert">
            {{ session()->get('message-success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->has('message-danger'))
        <div class="alert alert-danger">
            {{ session()->get('message-danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div id="add_payment">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{__("account.Create Recieve Voucher")}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{ route('voucher_recieve.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" id="voucher_type" name="voucher_type" value="">
                                    <div class="col-xl-6">
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
                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('account.Recieve From')}} *</label>
                                            <select class="primary_select mb-15" name="credit_account_id" id="credit_account_id" required onchange="getInvoice()">
                                                <option>{{ __('common.Select one') }}</option>
                                                @foreach ($recieve_from_accounts as $key => $recieve_from_account)
                                                    <option value="{{ $recieve_from_account->id }}">{{ $recieve_from_account->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('credit_account_id')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 invoice_list_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('account.Invoice No')}}</label>
                                            <div class="invoice_list">

                                            </div>
                                            <span class="text-danger">{{$errors->first('invoice_list')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('account.Narration')}} </label>
                                            <input class="primary_input_field" name="narration" placeholder="Narration" type="text">
                                            <span class="text-danger">{{$errors->first('narration')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('account.Amount')}} *</label>
                                            <input class="primary_input_field" name="debit_account_amount[]" placeholder="Amount" type="number">
                                            <span class="text-danger">{{$errors->first('debit_account_amount')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{__('account.Payment Recieved Account')}} *</label>
                                            <select class="primary_select mb-15" name="debit_account_id" id="debit_account_id" required>
                                                <option>{{ __('common.Select one') }}</option>
                                                @foreach ($recieve_by_accounts as $key => $recieve_by_account)
                                                    <option value="{{ $recieve_by_account->id }}">{{ $recieve_by_account->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">{{$errors->first('debit_account_id')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 cheque_no_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for=""> {{__('account.Cheque Number')}} </label>
                                            <input class="primary_input_field" name="cheque_no" id="cheque_no" placeholder="Cheque Number" type="text" value="{{old('cheque_no')}}" required>
                                            <span class="text-danger">{{$errors->first('cheque_no')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 cheque_date_div">
                                        <div class="primary_input mb-15">
                                            <div class="primary_input mb-15">
                                                <label class="primary_input_label" for="">{{__('account.Cheque Date')}}</label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input placeholder="Date" class="primary_input_field primary-input date form-control" id="cheque_date" type="text" name="cheque_date" value="" autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                        <button class="" type="button">
                                                            <i class="ti-calendar" id="start-date-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 bank_name_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label"
                                                   for=""> {{__('account.Bank Name')}} </label>
                                            <input class="primary_input_field" name="bank_name" id="bank_name" placeholder="Bank Name" type="text" value="{{old('bank_name')}}" required>
                                            <span class="text-danger">{{$errors->first('bank_name')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 bank_branch_div">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for=""> {{__('account.Bank Branch')}} </label>
                                            <input class="primary_input_field" name="bank_branch" id="bank_branch" placeholder="Bank Branch" type="text" value="{{old('bank_branch')}}" required>
                                            <span class="text-danger">{{$errors->first('bank_branch')}}</span>
                                        </div>
                                    </div>

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
        $(document).ready(function(){
            $('.invoice_list_div').hide();
            hideDiv();
            $( "#debit_account_id" ).change(function() {
                var debit_account_id = $('#debit_account_id').val();
                $.post('{{ route('get_accounts_configurable_type') }}', {_token:'{{ csrf_token() }}', id:debit_account_id}, function(data){
                    $('#voucher_type').val(data.configuration_group_id);
                    if (data.configuration_group_id == 1) {
                        $("#bank_branch").attr('disabled', true);
                        $("#bank_name").attr('disabled', true);
                        $("#cheque_date").attr('disabled', true);
                        $("#cheque_no").attr('disabled', true);
                        hideDiv();
                    }
                    else if (data.configuration_group_id == 2) {
                        $("#bank_branch").removeAttr("disabled");
                        $("#bank_name").removeAttr("disabled");
                        $("#cheque_date").removeAttr("disabled");
                        $("#cheque_no").removeAttr("disabled");
                        showDiv();
                    }
                });

            });
        });
        function getInvoice(){
            var acc_id = $("#credit_account_id").val();
            $.post('{{ route('get_invoice_lists') }}', {_token:'{{ csrf_token() }}', id:acc_id}, function(data){
                if (data != 0) {
                    $('.invoice_list').html(data);
                    $('.invoice_list_div').show();
                    $('#invoice_id').removeAttr("disabled");
                    $('select').niceSelect();
                }else {
                    $('.invoice_list_div').hide();
                    $('#invoice_id').attr('disabled', true);
                }
            });
        }

        function hideDiv()
        {
            $('.cheque_no_div').hide();
            $('.cheque_date_div').hide();
            $('.bank_name_div').hide();
            $('.bank_branch_div').hide();
        }

        function showDiv()
        {
            $('.cheque_no_div').show();
            $('.cheque_date_div').show();
            $('.bank_name_div').show();
            $('.bank_branch_div').show();
        }
    </script>
@endpush
