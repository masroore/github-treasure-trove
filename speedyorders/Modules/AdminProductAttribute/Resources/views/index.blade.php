@extends('layouts.main')

@section('content')


<section class="content">
    <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Attribute List</h3>

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

            <a href="{{ route('admin.product.attributes.create') }}" class="btn btn-primary float-right mr-1" data-toggle="tooltip" data-placement="top" data-original-title="Create Option">
                <i class="fa fa-plus"></i>
            </a>

            <a href="javascript:void(0)" data-toggle="modal" data-target="#attribute-modal" class="btn btn-info float-right mr-1"><i class="fa fa-download"></i></a>

        </div>
    </div>

    </div>
    <div class="card-body">
      <table id="commonTable" class="table table-bordered">
         <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Attribute Values</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attributes as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->attribute_label }}</td>
                    <td>{{ $item->input_type }}</td>
                    <td>
                        @if(!empty($item->attributeValues))
                            @foreach($item->attributeValues as $attr_value)
                                {{$attr_value->name}} <br>
                            @endforeach
                        @endif

                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('admin.product.attributes.edit', $item->id  ) }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button data-toggle="modal" data-target="#delete-modal"
                            data-url="{{route('admin.product.attributes.delete',$item->id)}}"
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


<div class="modal" id="attribute-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6><strong>Make sure that csv file is according to provided sample?</strong>
                    <a href="{{url('/Attributes_Sample.csv')}}"><strong>sample found here</strong></a>
                </h6>
            </div>
            <form action="{{route('admin.product.attributes.import')}}" id="attribute-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="file" class="form-control" name="attribute_file" id="attribute-file">
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="attribute-modal-submit">Import</button>
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

        $(document).on('click', '#attribute-modal-submit', function () {
          
                $(this).attr('disabled', true);
                $(this).html('<i class="fa fa-spinner fa-spin" style=""></i> Please Wait...');
               $('#attribute-form').submit();
            
        });

    </script>
@endsection
