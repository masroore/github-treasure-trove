@extends('layouts.main')

@section('content')
<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Review List</h3>

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
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create Review">
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
                <th>Product Id</th>
                <th>Customer</th>
                <th>Name</th>
                <th>Review</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->name ?? null}}</td><td>{{ $item->customer->fname ??null }}</td>
                    <td>{{ $item->author }}</td>
                    <td>{{ $item->text }}</td>
                    <td>
                        {{ $item->status=='1' ? 'Active':'Inactive' }}
                        <a href="{{ route('admin.reviews.update.status',$item->id) }}" class="text-danger"><strong>Change</strong></a>

                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.reviews.edit', $item->id  ) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button data-toggle="modal" data-target="#delete-modal"
                            data-url="{{route('admin.reviews.destroy',$item->id)}}"
                            class="btn btn-danger delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
            <tr>
                <td class="text-center" colspan="6">
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
