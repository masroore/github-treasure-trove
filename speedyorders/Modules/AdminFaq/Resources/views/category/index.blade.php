@extends('layouts.main')

@section('content')

<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Faq Category List</h3>

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
            <a href="{{ route('admin.faq.categories.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create FAQ category">
                <i class="fa fa-plus"></i>
            </a>

            <a  href="javascript:void(0)" data-toggle="modal" data-target="#faq-category-modal" class="btn btn-info float-right mr-1"><i class="fa fa-download"></i></a>

        </div>
    </div>

    </div>
    <div class="card-body">
      <table id="commonTable" class="table table-bordered">
         <thead>
            <tr>
                <th>#</th>
                <th>Name</th><th>Meta-tag</th><th>Sort Order</th><th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqcategory as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td><td>{{ $item->meta_tag }}</td><td>{{ $item->sort_order }}</td>
                    <td>
                        {{ $item->status=='1' ? 'Active':'Inactive'  }}
                        <a href="{{ route('admin.faq.categories.update.status',$item->id) }}" class="text-danger"><strong>Change</strong></a>
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.faq.categories.edit', $item->id  ) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button data-toggle="modal" data-target="#delete-modal"
                            data-url="{{route('admin.faq.categories.destroy',$item->id)}}"
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
            <tfoot>
                <tr>
                    <td class="text-center" colspan="6">
                        <span>{!! $faqcategory->render() !!}</span>
                    </td>
                </tr>
            </tfoot>
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</section>

@include('commons.delete_modal')

<div class="modal" id="faq-category-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6><strong>Make sure that excel is according to provided sample?</strong>
                    <a href="{{storage_path('/excel-sample/faq-category.xlsx')}}"><strong>sample found here</strong></a>
                </h6>
            </div>
            <form action="{{route('admin.faq.categories.import')}}" id="faq-category-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" class="form-control" name="faq_category_file" id="faq-category-file">
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="faq-modal-submit">Yes</button>
                </div>
            </form>

        </div>
    </div>
</div>
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

        $(document).on('click', '#faq-modal-submit', function () {
            $('#faq-modal-submit').click(function (e) {
                $(this).attr('disabled', true);
                $(this).html('<i class="fa fa-spinner fa-spin" style=""></i> Please Wait...');
               // $('#faq-category-modal').submit();
            })
        });
    </script>
@endsection
