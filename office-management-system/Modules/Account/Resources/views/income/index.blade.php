@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('inventory.Income Lists') }}</h3>
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
                                        <th scope="col">{{ __('inventory.Account') }}</th>
                                        <th scope="col">{{ __('inventory.Amount') }}</th>
                                        <th scope="col">{{ __('account.Narration') }}</th>
                                        <th scope="col">{{ __('account.Date') }}</th>
                                        <th scope="col">{{ __('common.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($incomes as $key => $income)

                                        <tr>

                                            <td>{{ $income->id }}</td>
                                            <td>{{ @$income->account->name }}</td>
                                            <td>{{ single_price(@$income->voucher->amount) }}</td>
                                            <td>
                                                {{ $income->voucher->narration }}

                                            </td>
                                            <td>
                                               {{ date("d F, Y", strtotime($income->voucher->created_at)) }}
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

                                                            <a href="{{ route('income.edit', $income->id) }}" class="dropdown-item edit_brand">{{__('common.Edit')}}</a>
                                                            <a onclick="confirm_modal('{{route('income.destroy1', $income->id)}}');" class="dropdown-item edit_brand">{{__('common.Delete')}}</a>

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
