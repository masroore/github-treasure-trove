@extends('layouts.main')

@section('content')


<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Coupons History List</h3>

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
            <!-- <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create Coupon">
                <i class="fa fa-plus"></i>
            </a> -->
        </div>
    </div>

    </div>
    <div class="card-body">
      <table id="commonTable" class="table table-bordered">
         <thead>
            <tr>
                <th>Coupon Code</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($couponHistories as $couponHistory)
            <tr>
                <td>{{ $couponHistory->coupon_code }} </td>
                <td>{{ $couponHistory->total }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.coupons.histories.details',$couponHistory->coupon_code ) }}">
                        <i class="fa fa-eye"></i>
                    </a>
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

@endsection
@section('ext_js')
    <script>
    </script>
@endsection
