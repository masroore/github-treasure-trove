
@extends('layouts.admin')

@section('page-title')
    {{__('Student Ledger')}}
@endsection

@section('action-button')

    <div class="row d-flex justify-content-end">
        <div class="col-auto">
            {{ Form::open(array('route' => array('report.ledger'),'method' => 'GET','id'=>'report_ledger')) }}
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('start_date', __('Start Date'),['class'=>'text-type']) }}
                    {{ Form::date('start_date','', array('class' => 'month-btn form-control')) }}
                </div>
            </div>
        </div>
        <div class="col-auto">
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('end_date', __('End Date'),['class'=>'text-type']) }}
                    {{ Form::date('end_date','', array('class' => 'month-btn form-control')) }}
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

@endsection

@section('content')
@foreach($studentledger as  $item)
     <div id="printableArea">
         <div class="row mt-4">
            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0">{{__('Student No')}} :</h5>
                    <h5 class="report-text mb-0">{{$item->student_id}}</h5>
                </div>
            </div>

            <div class="col">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0">{{__('Duration')}} :</h5>
                    <h5 class="report-text mb-0">{{\Auth::user()->dateFormat($item->create_date)}} to {{\Auth::user()->dateFormat($item->modify_date)}}</h5>
                </div>
            </div>
        </div>
     </div>  
     
     <div class="row mt-4">
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">Student name :</h5>
                        <h5 class="report-text mb-0">{{$item->name}}</h5>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">Father Name :</h5>
                        <h5 class="report-text mb-0">{{$item->name}}</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">Class :</h5>
                        <h5 class="report-text mb-0">{{$item->classes}}</h5>
                    </div>
                </div>
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">Status :</h5>
                        <h5 class="report-text mb-0">{{$item->active}}</h5>
                    </div>
                </div>

                <div class="col">
                    <div class="card p-4 mb-4">
                        <h5 class="report-text gray-text mb-0">Date :</h5>
                        <h5 class="report-text mb-0">{{\Auth::user()->dateFormat($item->create_date)}}</h5>
                    </div>
                </div>
            </div>
            
  <div class="row mt-4">
        <div class="col-12 mb-4">
             <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th></th>
                        <th> #</th>
                        <th> Date</th>
                        <th> Type</th>
                        <th> Vr .No</th>
                        <th> Narration</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>{{ AUth::user()->journalNumberFormat($item->journal_id) }}</td>
                            <td>{{\Auth::user()->dateFormat($item->transaction_date)}}</td>
                            <td></td>
                            <td>{{$item->accounts_reg}}</td>
                            <td></td>
                            <td>{{\Auth::user()->priceFormat($item->debit)}}</td>
                            <td>{{\Auth::user()->priceFormat($item->credit)}}</td>
                            <!--<td>{{\Auth::user()->priceFormat($item->balance)}}</td>-->
                            <td>{{\Auth::user()->priceFormat($item->debit - $item->credit)}}</td>
                        </tr>
                        @foreach($studentsledger as  $items)
                        <tr>
                            <td></td>
                            <td>{{ AUth::user()->journalNumberFormat($items->journal_entries_id) }}</td>
                            <td>{{\Auth::user()->dateFormat($items->date)}}</td>
                            <td></td>
                            <td>{{$items->narration}}</td>
                            <td></td>
                            <td>{{\Auth::user()->priceFormat($items->debit)}}</td>
                            <td>{{\Auth::user()->priceFormat($items->credit)}}</td>
                            <!--<td>{{\Auth::user()->priceFormat($item->balance)}}</td>-->
                            <td>{{\Auth::user()->priceFormat($items->debit - $item->credit)}}</td>
                        </tr>
                        @endforeach 
                    </tbody>  
            </table>        
        </div>    
    </div>
     @endforeach 
@endsection
