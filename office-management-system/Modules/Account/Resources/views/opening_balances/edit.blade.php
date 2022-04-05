@extends('backEnd.master')
@section('mainContent')
    <div id="add_payment">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('account.Update Opening Balance') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="white_box_50px box_shadow_white">
                            <!-- Prefix  -->
                            <form action="{{ route('openning_balance.update', $timeInterval->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">{{ __('account.Account Time Period') }</label>
                                            <div class="primary_datepicker_input">
                                                <input class="primary_input_field" id="asset_amount" name="time_period" type="text" value="{{ $timeInterval->start_date }} to {{ $timeInterval->end_date }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="primary_input mb-15">
                                            <label class="primary_input_label" for="">Date</label>
                                            <div class="primary_datepicker_input">
                                                <input class="primary_input_field" id="date" name="date" type="text" value="{{ date('m/d/Y', strtotime($timeInterval->end_date)) }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h4>Assets Side</h4>
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <button type="button" class="primary-btn icon-only fix-gr-bg" onclick="addMoreAsset()">
                                                    <span class="ti-plus"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <table class="w-100 table-responsive" id="tableAssets">
                                            <tbody id="addAssetsTableBody">
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($timeInterval->openning_balance_histories->where('acc_type', 'asset') as $key => $history)
                                                    <tr id="AssetsRow{{ $key }}">
                                                        <td width="60%" class="pr-30">
                                                            <label class="primary_input_label" for="">Account Name</label>
                                                            <div class="input-effect mt-10">
                                                                <select class="primary_select mb-15" name="asset_account_id[]" id="asset_account_id" required>
                                                                    <option>Select one</option>
                                                                    @foreach ($assetAccounts as $key => $assetAccount)
                                                                        <option value="{{ $assetAccount->id }}" {{ ($assetAccount->id == $history->account_id) ? "selected" : null }}>{{ $assetAccount->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td width="25%">
                                                            <label class="primary_input_label" for="">{{ __('account.Amount') }}</label>
                                                            <div class="input-effect mt-10">
                                                                <input class="primary_input_field" id="asset_amount" name="asset_amount[]" onkeyup="checkBothside()" placeholder="{{__("account.Amount")}}" type="number" min="0" step="0.01" value="{{ $history->amount }}">
                                                            </div>
                                                        </td>

                                                        @if ($i != 0)
                                                            <td width="15%">
                                                                <div class="input-effect">
                                                                    <button class="primary-btn icon-only fix-gr-bg close-deductions mt-4 ml-2" onclick="delete_assetsRow({{ $i }}, event)"><span class="ti-close"></span></button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                                <input type="hidden" name="asset_id" id="asset_id" value="{{ $i }}">
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col">
                                                <table class="w-100 table-responsive">
                                                    <tbody>
                                                        <tr>
                                                            <td width="20%" class="pr-30">
                                                                <h5>{{ __('account.Total Assets') }} : </h5>
                                                            </td>
                                                            <td width="80%">
                                                                <h5 id="totalAssets"> 0 </h5>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <h4>{{ __('account.Liability Side') }}</h4>
                                            </div>
                                            <div class="col-lg-6 text-right">
                                                <button type="button" class="primary-btn icon-only fix-gr-bg" onclick="addMoreLiability()">
                                                    <span class="ti-plus"></span>
                                                </button>
                                            </div>
                                        </div>
                                        <table class="w-100 table-responsive" id="tableLiabilities">
                                            <tbody id="addLiabilitiesTableBody">
                                                @php
                                                    $j = 0;
                                                @endphp
                                                @foreach ($timeInterval->openning_balance_histories->where('acc_type', 'liability') as $k => $historyLiability)
                                                    <tr id="LiabilitiesRow{{ $k }}">
                                                        <td width="60%" class="pr-30">
                                                            <label class="primary_input_label" for="">{{ __('account.Account Name') }</label>
                                                            <div class="input-effect mt-10">
                                                                <select class="primary_select mb-15" name="liability_account_id[]" id="liability_account_id" required>
                                                                    <option>Select one</option>
                                                                    @foreach ($liabilityAccounts as $key => $liabilityAccount)
                                                                        <option value="{{ $liabilityAccount->id }}" {{ ($liabilityAccount->id == $historyLiability->account_id) ? "selected" : null }}>{{ $liabilityAccount->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td width="25%">
                                                            <label class="primary_input_label" for="">{{ __('account.Amount') }</label>
                                                            <div class="input-effect mt-10">
                                                                <input class="primary_input_field" id="liability_amount" name="liability_amount[]" onkeyup="checkBothside()" type="number" min="0" step="0.01" value="{{ $historyLiability->amount }}">
                                                            </div>
                                                        </td>

                                                        @if ($j != 0)
                                                            <td width="15%">
                                                                <div class="input-effect">
                                                                    <button class="primary-btn icon-only fix-gr-bg close-deductions mt-4 ml-2" onclick="delete_liabilityRow({{ $i }}, event)"><span class="ti-close"></span></button>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @php
                                                            $j++;
                                                        @endphp
                                                    </tr>
                                                @endforeach
                                                <input type="hidden" name="liability_id" id="liability_id" value="{{ $j }}">
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col">
                                                <table class="w-100 table-responsive">
                                                    <tbody>
                                                        <tr>
                                                            <td width="20%" class="pr-30">
                                                                <h5>Total Liability : </h5>
                                                            </td>
                                                            <td width="80%">
                                                                <h5 id="totalLiability"> 0 </h5>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="assetamount" id="assetamount" value="">
                                <input type="hidden" name="liabilityamount" id="liabilityamount" value="">
                                <div class="row">
                                    <div class="col-12 mt-4">
                                        <label class="h1 primary_input_label text-center gradient-color2" for="" id="alert_txt"></label>
                                        <span class="text-danger">{{$errors->first('assetamount')}}</span>
                                        <div class="submit_btn text-center ">
                                            <button class="primary-btn semi_large2 fix-gr-bg" id="save"><i class="ti-check"></i>{{__("common.Save")}}</button>
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
            checkBothside();
        });
        function addMoreAsset(){
            var table = document.getElementById("tableAssets");
            var table_len = (table.rows.length);
            var id = parseInt(table_len);
            var row = table.insertRow(table_len).outerHTML = '<tr id="row' + id + '">'+
            '<td width="60%" class="pr-30">'+
            '<div class="input-effect mt-10">'+
            '<select class="primary_select mb-15" name="asset_account_id[]" id="asset_account_id" required>'+
            '<option>Select one</option>'+
            '@foreach ($assetAccounts as $key => $assetAccount)'+
            '<option value="{{ $assetAccount->id }}">{{ $assetAccount->name }}</option>'+
            '@endforeach'+
            '</select>'+
            '</div>'+
            '</td>'+
            '<td width="25%">'+
            '<div class="input-effect mt-10">'+
            '<input class="primary_input_field" id="asset_amount' + id + '" name="asset_amount[]" placeholder="{{__("account.Amount")}}" onkeyup="checkBothside()" type="number" min="0" step="0.01" value="0">'+
            '</div>'+
            '</td>'+
            '<td width="15%">'+
            '<div class="input-effect mt-10">'+
            '<button class="primary-btn icon-only fix-gr-bg close-deductions" onclick="delete_assets(' + id + ')"><span class="ti-close"></span></button>'+
            '</div>'+
            '</td>'+
            '</tr>';
            $('select').niceSelect();
        }

        function delete_assetsRow(id, event){
            event.preventDefault();
            var table = document.getElementById("tableAssets");
            var rowCount = table.rows.length;
            $("#AssetsRow" + id).html("");
        }

        function delete_liabilityRow(id, event){
            event.preventDefault();
            var table = document.getElementById("tableLiabilities");
            var rowCount = table.rows.length;
            $("#LiabilitiesRow" + id).html("");
        }

        function delete_assets(id, event){
            var table = document.getElementById("tableAssets");
            var rowCount = table.rows.length;
            $("#row" + id).html("");
        }

        function addMoreLiability(){
            var table = document.getElementById("tableLiabilities");
            var table_len = (table.rows.length);
            var id = parseInt(table_len);
            var row = table.insertRow(table_len).outerHTML = '<tr id="row' + id + '">'+
            '<td width="60%" class="pr-30">'+
            '<div class="input-effect mt-10">'+
            '<select class="primary_select mb-15" name="liability_account_id[]" id="liability_account_id" required>'+
            '<option>Select one</option>'+
            '@foreach ($liabilityAccounts as $key => $liabilityAccount)'+
            '<option value="{{ $liabilityAccount->id }}">{{ $liabilityAccount->name }}</option>'+
            '@endforeach'+
            '</select>'+
            '</div>'+
            '</td>'+
            '<td width="25%">'+
            '<div class="input-effect mt-10">'+
            '<input class="primary_input_field" id="liability_amount' + id + '" name="liability_amount[]" placeholder="{{__("account.Amount")}}" onkeyup="checkBothside()" type="number" min="0" step="0.01" value="0">'+
            '</div>'+
            '</td>'+
            '<td width="15%">'+
            '<div class="input-effect mt-10">'+
            '<button class="primary-btn icon-only fix-gr-bg close-deductions" onclick="delete_liabilities(' + id + ')"><span class="ti-close"></span></button>'+
            '</div>'+
            '</td>'+
            '</tr>';
            $('select').niceSelect();
        }

        function delete_liabilities(id){
            var table = document.getElementById("tableLiabilities");
            var rowCount = table.rows.length;
            $("#row" + id).html("");
        }

        function checkBothside(){
            var liability_amount = $("input[name='liability_amount[]']").map(function(){return $(this).val();}).get();
            var asset_amount = $("input[name='asset_amount[]']").map(function(){return $(this).val();}).get();
            var asset_sum = 0;
            var liability_sum = 0;
            for (var i = 0; i < asset_amount.length; i++) {
                asset_sum = parseInt(asset_sum) + parseInt(asset_amount[i]);
            }
            for (var j = 0; j < liability_amount.length; j++) {
                liability_sum = parseInt(liability_sum) + parseInt(liability_amount[j]);
            }
            if (asset_sum != liability_sum) {
                $("#alert_txt").html("**** Both Side Entry Amounts are not same !!! ****");
            }
            else {
                $("#alert_txt").html("**** Both Side Entry Amounts equal and Button is enabled now !!! ****");
            }
            $("#totalAssets").html(asset_sum);
            $("#totalLiability").html(liability_sum);
            $("#assetamount").val(asset_sum);
            $("#liabilityamount").val(liability_sum);
        }
    </script>
@endpush
