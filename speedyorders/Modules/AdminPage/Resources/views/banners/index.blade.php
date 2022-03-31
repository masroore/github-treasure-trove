@extends('layouts.main')

@section('content')
@include('adminorder::message')
<div class="hpanel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 pull-left text-left">
                <h4>Banners List</h4>
            </div>
            <div class="col-md-1 pull-right text-right">
                <a href="{{ route('admin.pages.banners.create') }}" class="btn btn-primary-fade" data-toggle="tooltip" data-placement="top" data-original-title="Create Product">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <div class="col-md-4 pull-right text-right">
                <form method="GET" action="{{ route('admin.pages.banners.index') }}" accept-charset="UTF-8" role="search">
                    <div class="input-group"><input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-btn">
                                <button type="button" class="btn btn-primary-fade"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table id="productTable" class="table table-bordered table-striped speedy-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Image</th>
                        <th>First Title</th>
                        <th>First Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $banner->f_image }}</td>
                            <td>{{ $banner->f_title }}</td>
                            <td>{{ $banner->f_description }}</td>
                            <td>
                                {{ $banner->status=='1' ? 'Active':'Inactive'  }}
                                <a href="{{ route('admin.pages.update.banner.status',$banner->id) }}" class="text-danger"><strong>Change</strong></a>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.pages.banners.edit', $banner->id  ) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button data-toggle="modal" data-target="#delete-modal"
                                    data-url="{{route('admin.pages.banners.destroy',$banner->id)}}"
                                    class="btn btn-danger delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="17">
                            <span>No data available in the table...</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

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
