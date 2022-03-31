@extends('layouts.main')

@section('content')
@include('adminorder::message')



<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Pages Components</h3>

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
            <a href="{{ route('admin.pages.components.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create Page Component">
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
                <th>Content</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pageComponents as $pageComponent)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{!! $pageComponent->content !!}</td>
                    <td>
                        {{ $pageComponent->status=='1' ? 'Active':'Inactive'  }}
                        <a href="{{ route('admin.pages.update.pagecomponents.status',$pageComponent->id) }}" class="text-danger"><strong>Change</strong></a>
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.pages.components.edit', $pageComponent->id  ) }}">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <button data-toggle="modal" data-target="#delete-modal"
                            data-url="{{route('admin.pages.components.destroy',$pageComponent->id)}}"
                            class="btn btn-danger delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
            <tr>
                <td class="text-center" colspan="4">
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
