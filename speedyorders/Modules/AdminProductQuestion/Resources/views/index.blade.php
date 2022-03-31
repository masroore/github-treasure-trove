@extends('layouts.main')

@section('content')
<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Product Question List</h3>

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
            <a href="{{ route('admin.product.questions.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create product question">
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
                <th>Product </th><th>Customer </th><th>Name</th><th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productquestion as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->name ?? '' }}</td>
                    <td>{{ $item->customer->name ?? '' }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ ($item->status == 0) ? 'Answered':'Un-answered' }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.product.questions.edit', $item->id  ) }}">
                            <i class="fa fa-eye">Answer</i>
                        </a>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.product.questions.edit', $item->id  ) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button data-toggle="modal" data-target="#delete-modal"
                            data-url="{{route('admin.product.questions.destroy',$item->id)}}"
                            class="btn btn-danger delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
            <tr>
                <td class="text-center" colspan="7">
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
    </script>
@endsection
