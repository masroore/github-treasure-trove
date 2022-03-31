@extends('layouts.main')

@section('content')
<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Coupons List</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
        <!-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
        </button> -->
      </div>

      <div class="row no-print">
        <div class="col-12">
            <!--  <a href="{{ route('admin.products.import') }}" class="btn btn-success float-right" data-toggle="tooltip" data-placement="top" data-original-title="Import">
                <i class="fa fa-download"></i>
            </a> -->
            <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create Coupon">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    </div>
    <div class="card-body">
      <table id="commonTable" class="table table-striped">
         <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Min Order Amount</th>
                <th>StartDate</th>
                <th>ExpiryDate</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($coupons as $coupon)
            <tr>
                <td>{{ $coupon->code }}</td>
                <td>{{ $coupon->type }}</td>
                <td>{{ $coupon->amount }}</td>
                <td>{{ $coupon->min_order_amount }}</td>
                <td>{{ $coupon->start_date }}</td>
                <td>{{ $coupon->expiry_date }}</td>
                <td>
                    {{ $coupon->status=='1' ? 'Active':'Inactive'}}
                    <a href="{{ route('admin.coupons.update.status',$coupon->id) }}" class="text-danger"><strong>Change</strong></a>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.coupons.histories.details',$coupon->code ) }}">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.coupons.edit', $coupon->id ) }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button data-toggle="modal" data-target="#delete-modal"
                    data-url="{{route('admin.coupons.delete',$coupon->id)}}"
                    class="btn btn-danger delete">
                    <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tfoot>
                <tr>
                    <td class="text-center" colspan="10">
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
    </script>
@endsection
