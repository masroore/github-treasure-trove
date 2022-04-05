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
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ $payment->tx_id }} {{ __('common.Details') }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="row">
                        <input type="hidden" name="voucher_id" id="voucher_id" value="{{ $payment->id }}">
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="">{{ __('account.Set Approval') }</label>
                                <select class="primary_select mb-15" name="status" id="status" required>
                                    <option>Select one</option>
                                    <option value="1" @if ($payment->is_approve == 1) selected @endif>{{ __('account.Approve') }}</option>
                                    <option value="0" @if ($payment->is_approve == 0) selected @endif>{{ __('account.Pending') }}</option>
                                    <option value="2" @if ($payment->is_approve == 2) selected @endif>{{ __('account.Cancel') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active">
                                    <thead>
                                    <tr>
                                        <th scope="col">
                                            <label class="primary_checkbox d-flex ">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                        </th>
                                        <th scope="col">{{ __('common.ID') }}</th>
                                        <th scope="col">{{ __('common.Name') }}</th>
                                        <th scope="col">{{ __('account.Account Name') }}</th>
                                        <th scope="col">{{ __('account.Amount') }}</th>
                                 
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payment->transactions as $key => $payment)
                                        <tr>
                                            <th scope="col">
                                                <label class="primary_checkbox d-flex">
                                                    <input name="sms1" type="checkbox">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </th>
                                            <th>{{ $key+1 }}</th>
                                            <td>{{ $payment->type }}</td>
                                            <td>{{ $payment->account->name }}</td>
                                            <td>{{ single_price($payment->amount) }}</td>
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

@push("scripts")
    <script type="text/javascript">
        $(document).ready(function(){
            $( "#status" ).change(function() {
                var voucher_id = $('#voucher_id').val();
                var status = $('#status').val();
                $.post('{{ route('set_voucher_approval') }}', {_token:'{{ csrf_token() }}', id:voucher_id, status:status}, function(data){
                    if (data == 1) {
                        toastr.success("Status has been changed Successfully","Success");
                        location.reload();
                    }
                    else{
                        toastr.error('Something went wrong');
                    }
                });

            });
        });
    </script>
@endpush
