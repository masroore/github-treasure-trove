@extends('layouts.main')

@section('content')

<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Zone Price List</h3>

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
            <a href="{{ route('admin.zoneprice.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create Delivery Time">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    </div>

    </div>
    <div class="card-body">
      <table id="commonTable" class="table table-bordered">
         <thead>
            <tr>
                <th>Group Name</th>
                <th>Zip Code</th>
                <th>Package</th>
                <th>Delivery Time</th>                    
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($zoneprices as $zoneprice)
            <tr>
                <td>{{ (isset($zoneprice->group)) ? $zoneprice->group->group_name : '' }}</td>
                <td>{{ (isset($zoneprice->zip_code)) ? $zoneprice->zip_code : '' }}</td>
                <td>{{ (isset($zoneprice->package)) ? $zoneprice->package->package_name : '' }}</td>
                <td>{{ (isset($zoneprice->deliverytime)) ? $zoneprice->deliverytime->name : '' }}</td>
                
                <td>
                    {{ $zoneprice->price }}
                </td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.zoneprice.edit', $zoneprice->id ) }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button data-toggle="modal" data-target="#delete-modal"
                    data-url="{{route('admin.zoneprice.delete',$zoneprice->id)}}"
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
