@extends('layouts.main')

@section('content')
@include('adminorder::message')


<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Orders List</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>

      <div class="row no-print">
        <div class="col-12">

            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create new order">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    </div>
    <div class="card-body">
      <table id="commonTable" class="table table-bordered">
         <thead>
            <tr>
                <th>#</th>
                <th>Order Id</th>
                <th>Customer User</th>
                <th>Invoice Number</th>
                <th>Invoice Prefix</th>
                <th>First Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $item)
                @php
                    $firstname = (isset($item->customerUser->customer->first_name)) ? $item->customerUser->customer->first_name : '';
                    $last_name = (isset($item->customerUser->customer->last_name)) ? $item->customerUser->customer->last_name : '';
                    $name = $firstname." ".$last_name;
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->uuid}}</td>
                    <td>{{ $name}}</td>                            
                    <td>{{ $item->invoice_number }}</td>
                    <td>{{ $item->invoice_prefix }}</td>
                    <td>{{ $item->first_name }}</td>
                    <td>
                        @php
                            $status = "Pending";
                            switch($item->status){
                                case 2:
                                    $status = "Processing";
                                break;
                                case 3:
                                    $status = "Processed";
                                break;

                                case 4:
                                    $status = "Complete";
                                break;
                                case 5:
                                    $status = "Delivered";
                                break;
                                case 6:
                                    $status = "Canceled";
                                break;
                                case 7:
                                    $status = "Canceled Reversal";
                                break;
                                case 8:
                                    $status = "Chargeback";
                                break;
                                case 9:
                                    $status = "Denied";
                                break;
                                case 10:
                                    $status = "Expired";
                                break;
                                case 11:
                                    $status = "Failed";
                                break;
                                case 12:
                                    $status = "Refunded";
                                break;
                                case 13:
                                    $status = "Reversed";
                                break;
                                case 14:
                                    $status = "Shipped";
                                break;
                                case 15:
                                    $status = "Voided";
                                break;

                            }
                           

                        @endphp  
                        {{$status}}

                        <?php /*<a href="{{ route('admin.orders.update.status',$item->id) }}" class="text-danger"><strong>Change</strong></a> */?>
                        
                    </td>
                    <td>
                        @if($item->status == 2)
                            <a class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Process Order" href="{{ route('admin.orders.process', $item->id  ) }}">
                                <i class="fa fa-tasks"></i>
                            </a>
                        @endif

                        <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="View Order Details" href="{{ route('admin.orders.show', $item->id  ) }}">
                            <i class="fa fa-eye"></i>
                        </a>

                        <a class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Show  Order Report" href="{{ route('admin.orders.invoices.show', $item->id  ) }}">
                            <i class="fa fa-file"></i>
                        </a>
                        <a class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Edit  Order" href="{{ route('admin.orders.edit', $item->id  ) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <button data-toggle="modal" title="Delete Order" data-target="#delete-modal" data-url="{{route('admin.orders.delete',$item->id)}}" class="btn btn-danger  delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
            <tr>
                <td class="text-center" colspan="8">
                    <span>No data available in the table...</span>
                </td>
            </tr>
            @endforelse
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</section>

@include('commons.delete_modal')
@endsection
@section('ext_js')
    <script>

        $(document).on('click', '.delete', function () {
            var actionUrl = $(this).attr('data-url');

            $('#delete-form').attr('action', actionUrl);

            $('#modal-submit').click(function (e) {
                $(this).attr('disabled', true);
                $(this).html('<i class="fa fa-spinner fa-spin" style=""></i> Please Wait...');
                $('#delete-form').submit();
            })
        });

        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        });

    </script>
@endsection
