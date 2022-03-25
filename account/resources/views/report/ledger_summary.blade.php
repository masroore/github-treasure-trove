@extends('layouts.admin')

@section('page-title')
    {{__('Ledger Summary')}}
@endsection

@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }

    </script>
@endpush

@section('action-button')

    <div class="row d-flex justify-content-end">
        <div class="col-auto">
            {{ Form::open(array('route' => array('report.ledger'),'method' => 'GET','id'=>'report_ledger')) }}
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('start_date', __('Start Date'),['class'=>'text-type']) }}
                    {{ Form::date('start_date',$filter['startDateRange'], array('class' => 'month-btn form-control')) }}
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('end_date', __('End Date'),['class'=>'text-type']) }}
                    {{ Form::date('end_date',$filter['endDateRange'], array('class' => 'month-btn form-control')) }}
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="all-select-box">
                <div class="btn-box">
                     {{ Form::label('search_text', __('Search Here'),['class'=>'text-type']) }}
                     {{ Form::text('search_text', $filter['search_text'], array('class' => 'month-btn form-control')) }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3">
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('account', __('Account'),['class'=>'text-type']) }}
                    {{ Form::select('account',$accounts,isset($_GET['account'])?$_GET['account']:'', array('class' => 'form-control select2')) }}
                </div>
            </div>
        </div>
        <div class="col-auto my-auto">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_ledger').submit(); return false;" data-toggle="tooltip" data-original-title="{{__('apply')}}">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="{{route('report.ledger')}}" class="reset-btn" data-toggle="tooltip" data-original-title="{{__('Reset')}}">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>
            <a href="#" class="action-btn" onclick="saveAsPDF()" data-toggle="tooltip" data-original-title="{{__('Download')}}">
                <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
            </a>
             <a href="{{route('file-export')}}?start_date=<?php echo isset($_GET['start_date'])? $_GET['start_date']: ''; ?>&end_date=<?php echo isset($_GET['end_date'])? $_GET['end_date'] : ''; ?>&search_text=<?php echo isset($_GET['search_text'])? $_GET['search_text'] : ''; ?>&account=<?php echo isset($_GET['account'])? $_GET['account'] : ''; ?>" class="apply-btn" data-toggle="tooltip" data-original-title="Export Excel">
                <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
            </a>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('content')
    <div id="printableArea">
        <div class="row mt-4">
            <div class="col">
                <input type="hidden" value="{{__('Ledger').' '.'Report of'.' '.$filter['startDateRange'].' to '.$filter['endDateRange']}}" id="filename">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0">{{__('Report')}} :</h5>
                    <h5 class="report-text mb-0">{{__('Ledger Summary')}}</h5>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0">{{__('Duration')}} :</h5>
                    <h5 class="report-text mb-0">{{$filter['startDateRange'].' to '.$filter['endDateRange']}}</h5>
                </div>
            </div>
        </div>
        @if(!empty($account))
            <div class="row mt-4">
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">{{__('Account Name')}} :</h5>
                        <h5 class="report-text mb-0">{{$account->name}}</h5>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">{{__('Account Code')}} :</h5>
                        <h5 class="report-text mb-0">{{$account->code}}</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">{{__('Total Debit')}} :</h5>
                        <h5 class="report-text mb-0">{{\Auth::user()->priceFormat($filter['debit'])}}</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">{{__('Total Credit')}} :</h5>
                        <h5 class="report-text mb-0">{{\Auth::user()->priceFormat($filter['credit'])}}</h5>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">{{__('Balance')}} :</h5>
                        <h5 class="report-text mb-0">{{($filter['balance']>0)?__('Cr').'. '.\Auth::user()->priceFormat(abs($filter['balance'])):__('Dr').'. '.\Auth::user()->priceFormat(abs($filter['balance']))}}</h5>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="row mb-4">
            <div class="col-12 mb-4">
                <!--table table-flush-->
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th></th>
                        <th> #</th>
                        <th> {{__('Transaction Date')}}</th>
                        <th> {{__('Create At')}}</th>
                        <th> {{__('Description')}}</th>
                        <th> {{__('Debit')}}</th>
                        <th> {{__('Credit')}}</th>
                        <th> {{__('Balance')}}</th>
                        <th> {{__('Voucher Type')}}</th>
                        <th> {{__('Applicant Id')}}</th>
                        <th> {{__('Student Name')}}</th>
                        <th> {{__('Class')}}</th>
                        <th> {{__('Account Reg')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $balance=0;$debit=0;$credit=0; @endphp
                    @foreach($journalItems as  $item)
                    
                        <tr>
                            <td>
                                <a href="{{route('student-ledger')}}?journal_id=<?php echo $item->journal_entries_id; ?>&account=<?php echo $item->account; ?>" class="apply-btn" data-toggle="tooltip" data-original-title="Student Detail">
                                    <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                                </a>
                            </td>
                            <td class="Id">
                                <a href="{{ route('journal-entry.show',$item->journal) }}">{{ AUth::user()->journalNumberFormat($item->journal_id) }}</a>
                            </td>

                            <td>{{\Auth::user()->dateFormat($item->transaction_date)}}</td>
                            <td>{{\Auth::user()->dateFormat($item->created_at)}}</td>
                            <td>{{!empty($item->description)?$item->description:'-'}}</td>
                            <td>{{\Auth::user()->priceFormat($item->debit)}}</td>
                            <td>{{\Auth::user()->priceFormat($item->credit)}}</td>
                            <td>
                                @if($item->debit>0)
                                    @php $debit+=$item->debit @endphp
                                @else
                                    @php $credit+=$item->credit @endphp
                                @endif

                                @php $balance= $credit-$debit @endphp
                                @if($balance>0)
                                    {{__('Cr').'. '.\Auth::user()->priceFormat($balance)}}

                                @elseif($balance<0)
                                    {{__('Dr').'. '.\Auth::user()->priceFormat(abs($balance))}}
                                @else
                                    {{\Auth::user()->priceFormat(0)}}
                                @endif
                            </td>
                            <td>{{$item->vouchertype}}</td>
                            <td>{{$item->form_no}} </td>
                            <td>{{$item->fullName}} </td>
                            <td>{{$item->classes}} </td>
                             <td>{{$item->accounts_reg}} </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                 <?php 
                    if(isset($_GET['account'])){
                    ?>
                        {{ $journalItems->appends(['start_date' => $filter['startDateRange'],'end_date' => $filter['endDateRange'], 'search_text' => $filter['search_text'], 'account' => $_GET['account']])->links() }}
                <?php 
                     }else{
                        ?>
                        {{ $journalItems->links() }}
                        <?php
                     }
                 ?>
            </div>
        </div>
    </div>
@endsection
