@extends('backEnd.master')
@section('mainContent')
    @php
        $chartAccount = Modules\Account\Entities\ChartAccount::where('contactable_type', 'Modules\Inventory\Entities\ShowRoom')->where('contactable_id', $showroom->id)->first();
        $openingBalance = Modules\Account\Entities\TypeOpeningBalance::where('account_id', $chartAccount->id)->first();
        if ($openingBalance) {
            $currentBalance = 0 + $openingBalance->amount;
        }
        else {
            $currentBalance = 0;
        }
    @endphp
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('inventory.ShowRoom Details') }}</h3>
                            </div>
                            @if ($currentBalance == 0)
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="#"  data-toggle="modal" data-target="#openning_balance_Add"><i class="ti-plus"></i>{{ __('common.Opening Balance Add') }}</a></li>
                                </ul>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-lg-3 col-sm-12">
                                <h3>{{$showroom->name}}</h3>
                                <table class="table table-borderless supplier_view">
                                    <tr><td>{{ __('common.Name') }}:</td><td>{{ $showroom->name }}</td></tr>
                                    <tr><td>{{ __('common.Email') }}:</td><td>{{ $showroom->email }}</td></tr>
                                    <tr><td>{{ __('common.Phone') }}:</td><td>{{ $showroom->phone }}</td></tr>
                                    <tr><td>{{ __('common.Address') }}:</td><td>{{ $showroom->address }}</td></tr>
                                    <tr><td>{{ __('common.Registered Date') }}:</td><td>{{ date(app('general_setting')->dateFormat->format, strtotime($showroom->created_at)) }}</td></tr>
                                    <tr>
                                        <td>{{ __('common.Active Status') }}:</td>
                                        <td>
                                            @if ($showroom->status == 1)
                                                <span class="badge_1">Active</span>
                                            @else
                                                <span class="badge_4">De-Active</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 col-lg-3 col-sm-12 supplier_profile">
                                <h3>{{__('sale.Sale Information')}}</h3>
                                <table class="table table-borderless supplier_view">
                                    <tr><td>{{__('purchase.Total Invoice')}} : {{$showroom->accounts['total_invoice']}}</td></tr>
                                    <tr><td>{{__('purchase.Due Invoice')}} : {{$showroom->accounts['due_invoice']}}</td></tr>
                                </table>
                                <a href="" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="fa fa-bars"></i> {{__('product.Products')}}</a>
                            </div>
                            <div class="col-md-1 col-lg-1 col-sm-12"></div>
                            <div class="col-md-5 col-lg-5 col-sm-12 supplier_profile">
                                <h3>{{__('inventory.Earnings Information')}}</h3>
                                <table class="table table-borderless supplier_view">
                                    @if ($showroom->accounts)
                                        <tr><td>{{__('purchase.Total Balance')}} : {{single_price($showroom->accounts['total'])}}</td></tr>
                                        <tr><td>{{__('purchase.Due Balance')}} : {{single_price($showroom->accounts['due'])}}</td></tr>
                                    @endif
                                </table>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <a href="" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="fa fa-plus"></i>{{__('purchase.Add Balance')}}</a>
                                        <a href="" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="fa fa-minus"></i>{{__('purchase.Subtract Balance')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="QA_section QA_section_heading_custom check_box_table">
                                    <div class="QA_table ">
                                        <!-- table-responsive -->
                                        <div class="">
                                            <table class="table Crm_table_active3">
                                                <tbody>
                                                    <tr>
                                                        <th scope="col">{{ __('account.Date') }}</th>
                                                        <th scope="col">{{ __('account.Description') }}</th>
                                                        <th scope="col">{{ __('account.Debit') }}</th>
                                                        <th scope="col">{{ __('account.Credit') }}</th>
                                                        <th scope="col" class="text-right">{{ __('account.Balance') }}</th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ __('account.Openning Balance') }}</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td class="text-right">{{ single_price($currentBalance) }}</td>
                                                    </tr>
                                                    @php
                                                        $transactions =  $chartAccount->transactions()->Approved()->get();
                                                    @endphp
                                                    @foreach ($transactions as $key => $payment)
                                                        @if ($payment->type == "Cr")
                                                            @php
                                                                $currentBalance -= $payment->amount;
                                                            @endphp
                                                        @else
                                                            @php
                                                                $currentBalance += $payment->amount;
                                                            @endphp
                                                        @endif
                                                        <tr>
                                                            <td>{{ date(app('general_setting')->dateFormat->format, strtotime(@$payment->voucherable->date)) }}</td>
                                                            <td>{{ @$payment->voucherable->narration }}</td>
                                                            <td>
                                                                @if ($payment->type == "Dr")
                                                                    {{ single_price($payment->amount) }}
                                                                    <input type="hidden" name="debit[]" value="{{ $payment->amount }}">
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($payment->type == "Cr")
                                                                    {{ single_price($payment->amount) }}
                                                                    <input type="hidden" name="credit[]" value="{{ $payment->amount }}">
                                                                @endif
                                                            </td>
                                                            <td class="text-right">{{ single_price($currentBalance) }}</td>
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
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade admin-query" id="openning_balance_Add">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.Opening Balance Add') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="#" method="POST" id="openning_balance_addForm">
                        <div class="row">
                            <input type="hidden" name="type" value="showroom">
                            <input type="hidden" name="showroom_id" value="{{ $showroom->id }}">
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('contact.Opening Balance')}} *</label>
                                    <input name="opening_balance" class="primary_input_field name" placeholder="{{__('contact.Opening Balance')}}" type="number" step="0.01" min="0" required>
                                    <span class="text-danger" id="title_error"></span>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.Save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#openning_balance_addForm").on("submit", function (event) {
                event.preventDefault();
                let formData = $(this).serializeArray();
                $.each(formData, function (key, message) {
                    $("#" + formData[key].name + "_error").html("");
                });
                $.ajax({
                    url: "{{route("showroom_openning_balance.store")}}",
                    data: formData,
                    type: "POST",
                    success: function (response) {
                        $("#openning_balance_Add").modal("hide");
                        $("#openning_balance_addForm").trigger("reset");
                        toastr.success("Successfully Added Opening Balance","Success");
                        location.reload();
                    },
                    error: function (error) {
                        if (error) {
                            $.each(error.responseJSON.errors, function (key, message) {
                                $("#" + key + "_error").html(message[0]);
                            });
                        }
                        toastr.warning("Something went wrong");
                    }
                });
            });
        });
        function openning_balance_add_modal(){
            $('#edit_form').html(data);
            $('#ShowRoom_Edit').modal('show');
        }
    </script>
@endpush
