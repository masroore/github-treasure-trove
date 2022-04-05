@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('inventory.Expense Lists') }}</h3>
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
                                        <th scope="col">{{ __('inventory.Branch Name') }}</th>
                                        <th scope="col">{{ __('inventory.TXN id') }}</th>
                                        <th scope="col">{{ __('inventory.Amount') }}</th>
                                        <th scope="col">{{ __('account.Approved') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($expenses as $key => $expense)
                                        <tr>

                                            <td>{{ $key+1 }}</td>
                                            <td>{{ @$expense->showroom->name }}</td>
                                            <td>{{ @$expense->voucher->tx_id }}</td>
                                            <td>{{ single_price(@$expense->voucher->amount) }}</td>
                                            <td>
                                                @if (@$expense->voucher->is_approve == 0)
                                                    <span class="badge_3">{{__('account.Pending')}}</span>
                                                @elseif (@$expense->voucher->is_approve == 1)
                                                    <span class="badge_1">{{__('account.Approved')}}</span>
                                                @else
                                                    <span class="badge_4">{{__('account.Cancelled')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <!-- shortby  -->
                                                <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        {{ __('common.Select') }}
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                        @if (@$expense->voucher->is_approve != 1)
                                                            @if (permissionCheck('expenses.edit'))
                                                                <a href="{{ route('expenses.edit', $expense->id) }}" class="dropdown-item edit_brand">{{__('common.Edit')}}</a>
                                                            @endif
                                                            @if (permissionCheck('expenses.destroy') && $expense->voucher->is_approve != 1)
                                                                <a onclick="confirm_modal('{{route('expenses.destroy', $expense->id)}}');" class="dropdown-item edit_brand">{{__('common.Delete')}}</a>
                                                            @endif
                                                        @else
                                                            <a href="#" class="dropdown-item edit_brand">{{__('account.Approved')}}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- shortby  -->
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
        </div>
    </section>
    <div id="Voucher_info">

    </div>
@include('backEnd.partials.delete_modal')
@endsection

@push("scripts")
    <script type="text/javascript">
        function voucher_detail(el){
            $.post('{{ route('get_voucher_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                $('#Voucher_info').html(data);
                $('#Voucher_info_modal').modal('show');
                $('select').niceSelect();
            });
        }
    </script>
@endpush
