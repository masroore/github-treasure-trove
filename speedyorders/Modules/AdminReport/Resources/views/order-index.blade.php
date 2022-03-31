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

<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Orders</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
        </button> -->
      </div>

      <form method="GET" action="{{ route('admin.reports.customerorder.index') }}" id="filterOrder">
        <div class="row">

        </div>

          
              <div class="col-md-12">
                  <div class="row">
                         @csrf
                            <div class="col-md-4 form-group">
                                <input type="date" class="form-control" name="startDate" placeholder="Start Date">
                                <span class="input-group-btn">
                                </span>
                            </div>
                            <div class="col-md-4 form-group">
                                <input type="date" class="form-control" name="endDate" placeholder="End Date">
                                <span class="input-group-btn">
                                </span>
                            </div>
                            <div class="col-md-4 form-group">
                                <select class="form-control m-b js-dropdown-select2" name="customer_id">
                                    <option value="">All</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <select name="status" id="status" class="form-control js-dropdown-select2">
                                    <option value="">Any</option>
                                    <option value="6" @if(old('status')=='6') selected @endif>Canceled</option>
                                    <option value="7" @if(old('status')=='7') selected @endif>Canceled Reversal</option>
                                    <option value="8" @if(old('status')=='8') selected @endif>Chargeback</option>
                                    <option value="4" @if(old('status')=='4') selected @endif>Complete</option>
                                    <option value="5" @if(old('status')=='5') selected @endif>Delivered</option>
                                    <option value="9" @if(old('status')=='9') selected @endif>Denied</option>
                                    <option value="10" @if(old('status')=='10') selected @endif>Expired</option>
                                    <option value="11" @if(old('status')=='11') selected @endif>Failed</option>
                                    <option value="1" @if(old('status')=='1') selected @endif>Pending</option>
                                    <option value="3" @if(old('status')=='3') selected @endif>Processed</option>
                                    <option value="2" @if(old('status')=='2') selected @endif>Processing</option>
                                    <option value="12" @if(old('status')=='12') selected @endif>Refunded</option>
                                    <option value="13" @if(old('status')=='13') selected @endif>Reversed</option>
                                    <option value="14" @if(old('status')=='14') selected @endif>Shipped</option>
                                    <option value="15" @if(old('status')=='15') selected @endif>Voided</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                
                                <input type="text" class="form-control" name="invoice_number" placeholder="Invoice Number">
                                
                            </div>
                  </div>
              </div>
       
      </form>

      <div class="row no-print">
        



            <div class="col-12">     


                <form method="GET" action="{{ route('admin.reports.customerorder.export') }}" id="hiddenOrderForm">
                    
                    @csrf
                    <input type="hidden" class="form-control" name="startDate" value="{{ $data['startDate']??''}}" >
                    <input type="hidden" class="form-control" name="endDate" value="{{ $data['endDate']??'' }}">
                    <input type="hidden" name="customer_id" value="{{ $data['customer_id']??'' }}">
                    <input type="hidden" name="status" value="{{ $data['status']??'' }}">
                    <input type="hidden" name="invoice_number" value="{{ $data['invoice_number']??'' }}">
                    
                </form>
                
                <button class="btn btn-success pull-right" type="submit" form="hiddenOrderForm">Export to xlsx</button>
                
                <button type="submit" class="btn btn-primary  pull-right" form="filterOrder">Filter</button>
            </div>
    </div>

    </div>
    <div class="card-body">
      <table id="commonTable" class="table table-bordered">
          <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Product Sku</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Tax</th>
                <th>Shipping Price</th>
                <th>Order Date</th>
                <th>Invoice No</th>
                <th>Address 1</th>
                <th>Payment Name</th>
                <th>Payment Company</th>
                <th>Payment Addres</th>
                <th>Payment Code</th>
                <th>Shipping Name</th>
                <th>Shipping Company</th>
                <th>Shipping Address</th>
                <th>Shipping City</th>
                <th>Shipping Method</th>
                <th>Latest Comment</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderProducts as $orderProduct)
            <tr>
                <td>{{ $orderProduct->order->first_name.' '.$orderProduct->order->last_name }}</td>
                <td>{{ $orderProduct->order->email }}</td>
                <td>{{ $orderProduct->sku }}</td>
                <td>{{ $orderProduct->quantity }}</td>
                <td>{{ $orderProduct->price }}</td>
                <td>{{ $orderProduct->tax }}</td>
                <td>{{ $orderProduct->shipping_price }}</td>
                <td>{{ $orderProduct->created_at }}</td>
                <td>{{ $orderProduct->order->invoice_number }}</td>
                <td>{{ $orderProduct->order->address1 }}</td>
                <td>{{ $orderProduct->order->payment_first_name.' '.$orderProduct->order->payment_last_name  }}</td>
                <td>{{ $orderProduct->order->payment_company }}</td>
                <td>{{ $orderProduct->order->payment_address1 }}</td>
                <td>{{ $orderProduct->order->payment_unique_code }}</td>
                <td>{{ $orderProduct->order->shipping_first_name.' '.$orderProduct->order->shipping_last_name }}</td>
                <td>{{ $orderProduct->order->shipping_company }}</td>
                <td>{{ $orderProduct->order->shipping_address1 }}</td>
                <td>{{ $orderProduct->order->shipping_city }}</td>
                <td>{{ $orderProduct->order->shipping_method }}</td>
                <td>{{ $orderProduct->order->orderHistories[0]->comment?? ' ' }}</td>
                
            </tr>
            
            @empty
            <tfoot>
                <tr>
                    <td class="text-center" colspan="20">
                        <span>No data available in the table...</span>
                    </td>
                </tr>
            </tfoot>
            @endforelse
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</section>
@endsection
@section('ext_js')
    <script type="text/javascript">
        $(".js-dropdown-select2").select2();
    </script>
@endsection
