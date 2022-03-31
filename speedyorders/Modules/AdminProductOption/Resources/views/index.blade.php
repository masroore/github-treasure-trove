@extends('layouts.main')

@section('content')

<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Option List</h3>

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

            <a href="{{ route('admin.product.options.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create Option">
                <i class="fa fa-plus"></i>
            </a>

            <a href="javascript:void(0)" data-toggle="modal" data-target="#option-modal" class="btn btn-info float-right mr-1"><i class="fa fa-download"></i></a>

        </div>
    </div>

    </div>
    <div class="card-body">
      <table id="commonTable" class="table table-bordered">
         <thead>
            <tr>
                <th>#</th>
                <th>Name</th><th>Type</th><th>Options</th><th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($options as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ ($item->type=='input') ? 'Textbox' : $item->type }}</td>
                    <td>{!!$item->optionValues->sortBy('sort_order')->pluck('name')->implode(",<br>")!!}</td>
                    <td>{{ $item->sort_order }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.product.options.edit', $item->id  ) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button data-toggle="modal" data-target="#delete-modal"
                            data-url="{{route('admin.product.options.delete',$item->id)}}"
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


<div class="modal" id="option-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6><strong>Make sure that excel is according to provided sample?</strong>
                    <a href="{{storage_path('/excel-sample/faq.xlsx')}}"><strong>sample found here</strong></a>
                </h6>
            </div>
            <form action="{{route('admin.product.options.import')}}" id="option-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" class="form-control" name="option_file" id="option-file">
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="option-modal-submit">Yes</button>
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

        $(document).on('click', '#option-modal-submit', function () {
          
                $(this).attr('disabled', true);
                $(this).html('<i class="fa fa-spinner fa-spin" style=""></i> Please Wait...');
               $('#option-form').submit();
            
        });

    </script>
@endsection
