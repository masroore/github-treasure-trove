@extends('layouts.main')
@section('ext_css')
<style>
    .p-2{
        padding: 2px;
    }

    .mb-5{
        margin-bottom: 5px;
    }
</style>
@endsection
@section('content')
<div class="hpanel">
    <div class="panel-body">
      
            
                <h4>Transaction</h4>
          
            <div class="row mb-5">
                <form method="GET" action="{{ route('admin.reports.customertransaction.index') }}" id="filterTransaction" >
                    @csrf
                <div class="col-md-3 col-sm-3 col-xs-4 p-2">
                 
                        <input type="date" class="form-control" name="startDate" placeholder="Start Date">
                        <span class="input-group-btn">
                        </span>
                  
                </div>
                <div class="col-md-3 col-sm-3 col-xs-4 p-2">
                   
                        <input type="date" class="form-control" name="endDate" placeholder="End Date">
                        <span class="input-group-btn">
                        
                 
                </div>
                <div class="col-md-3 col-sm-3 col-xs-4  p-2">
                   

                        <select class="form-control m-b js-dropdown-select2" name="customer_id" style="width: 100%">
                            <option value="">select customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->email }}</option>
                            @endforeach
                        </select>
                   
                </div>

                <div class="col-md-3 col-sm-3 col-xs-4 p-2">
                    <select class="form-control" name="type">
                        <option value="">select transaction type</option>
                        <option value="debit">debit</option>
                        <option value="credit">credit</option>
                    </select>
                </div>
               
                </form> 
                
               
                
            </div>
            <div class="row">
                <div class="col-md-12  ">

                    <form method="GET" action="{{ route('admin.reports.customertransaction.export') }}" id="hiddenTransForm">
                        @csrf
                            <input type="hidden" class="form-control" name="startDate" value="{{ $data['startDate']??''}}" >
                            <input type="hidden" class="form-control" name="endDate" value="{{ $data['endDate']??'' }}">
                            <input type="hidden" name="customer_id" value="{{ $data['customer_id']??'' }}">
                            <input type="hidden" name="type" value="{{$data['type']??''}}">
                            <button class="btn btn-success pull-right" type="submit" form="hiddenTransForm">Export to xlsx</button>
                  
                        </form>
                        <button type="submit" class="btn btn-primary  pull-right" form="filterTransaction">Filter</button>



                </div>
            </div>
           
            <div class="table-responsive">
            <table id="productTable" class="table table-bordered table-striped speedy-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @forelse($uTransactions as $uTransaction)
                <tr>
                    <td>{{ $uTransaction->customerUser->email }}</td>
                    <td>{{ $uTransaction->description }}</td>
                    <td class="text-center">
                        @if ($uTransaction->type)
                        <span class="badge {{$uTransaction->type=='debit'?'badge-danger':'badge-success'}}">{{ $uTransaction->type}}</span></td>
                            
                        @endif
                    <td>{{ $uTransaction->amount }}</td>
                </tr>
                @empty
                <tfoot>
                    <tr>
                        <td class="text-center" colspan="6">
                            <span>No data available in the table...</span>
                        </td>
                    </tr>
                </tfoot>
                @endforelse
            </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

@endsection
