@extends('layouts.admin')
@section('page-title')
    {{__('Journal Entry Create')}}
@endsection
@push('script-page')
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('assets/js/custom/journal-entry-create.js')}}"></script>
@endpush
@section('content')

    {{ Form::open(array('url' => 'journal-entry','class'=>'w-100')) }}
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        {{ Form::label('journal_number', __('Journal Number'),['class'=>'form-control-label']) }}
                        <div class="form-icon-user">
                            <span><i class="fas fa-file"></i></span>
                            <input type="text" class="form-control prefixjournal" value="{{\Auth::user()->journalWithPrefix($journalId,'#JUR')}}" data-prefix = <?php echo sprintf("%05d", $journalId); ?> readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        {{ Form::label('date', __('Transaction Date'),['class'=>'form-control-label']) }}
                        <div class="form-icon-user">
                            <span><i class="fas fa-calendar"></i></span>
                            {{ Form::text('date', '', array('class' => 'form-control datepicker','required'=>'required')) }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        {{ Form::label('reference', __('Reference'),['class'=>'form-control-label']) }}
                        <div class="form-icon-user">
                            <span><i class="fas fa-joint"></i></span>
                            {{ Form::text('reference', '', array('class' => 'form-control')) }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="form-group">
                        {{ Form::label('vouchertype', __('vouchertype'),['class'=>'form-control-label']) }}
                        <div class="form-icon-user">
                            <!--<span><i class="fas fa-joint"></i></span>-->
                            {{ Form::select('vouchertype', array('JUR' => 'Journal Voucher', 'BPV' => 'Bank payment Voucher', 'CPV' => 'Cash payment Voucher', 'BR' => 'Bank Receipt' , 'CR' => 'Cash Receipt'), 'JV', array('class' => 'form-control','required'=>'required'))  }}
                            <!--{{ Form::text('vouchertype', '', array('class' => 'form-control')) }}-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8">
                    <div class="form-group">
                        {{ Form::label('description', __('Description'),['class'=>'form-control-label']) }}
                        {{ Form::textarea('description', '', array('class' => 'form-control','rows'=>'2')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card repeater">
                <div class="item-section py-4">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                            <div class="all-button-box">
                                <a href="#" data-repeater-create="" class="btn btn-xs btn-white btn-icon-only width-auto" data-toggle="modal" data-target="#add-bank">
                                    <i class="fas fa-plus"></i> {{__('Add Account')}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" data-repeater-list="accounts" id="sortable-table">
                            <thead>
                            <tr>
                                <th>{{__('Account')}}</th>
                                <th>{{__('Debit')}}</th>
                                <th>{{__('Credit')}} </th>
                                <th>{{__('Description')}}</th>
                                <th class="text-right">{{__('Amount')}} </th>
                                <th width="2%"></th>
                            </tr>
                            </thead>

                            <tbody class="ui-sortable" data-repeater-item>
                            <tr>
                                <td width="25%">
                                        {{ Form::select('account', $accounts,'', array('class' => 'form-control select2','required'=>'required')) }}
                                </td>

                                <td>
                                    <div class="form-group price-input">
                                        {{ Form::text('debit','', array('class' => 'form-control debit','required'=>'required','placeholder'=>__('Debit'),'required'=>'required')) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group price-input">
                                        {{ Form::text('credit','', array('class' => 'form-control credit','required'=>'required','placeholder'=>__('Credit'),'required'=>'required')) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {{ Form::text('description','', array('class' => 'form-control','placeholder'=>__('Description'))) }}
                                    </div>
                                </td>
                                <td class="text-right amount">0.00</td>
                                <td>
                                    <a href="#" class="fas fa-trash text-danger" data-repeater-delete></a>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td></td>
                                <td class="text-right"><strong>{{__('Total Credit')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                <td class="text-right totalCredit">0.00</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="text-right"><strong>{{__('Total Debit')}} ({{\Auth::user()->currencySymbol()}})</strong></td>
                                <td class="text-right totalDebit">0.00</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 text-right">
        <input type="submit" value="{{__('Create')}}" class="btn-create btn-xs badge-blue radius-10px">
        <input type="button" value="{{__('Cancel')}}" onclick="location.href = '{{route("journal-entry.index")}}';" class="btn-create btn-xs bg-gray radius-10px">
    </div>
    {{ Form::close() }}

@endsection


