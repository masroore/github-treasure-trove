@extends('layouts.main')

@section('content')
<div class="hpanel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4 pull-left text-left">
                <h4>State Tax List</h4>
            </div>
            <div class="col-md-1 pull-right text-right">
                <a href="{{ route('admin.reports.tax.create') }}" class="btn btn-primary-fade" data-toggle="tooltip" data-placement="top" data-original-title="Create State Tax">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            <div class="col-md-4 pull-right text-right">
                <form method="GET" action="{{ route('admin.reports.tax.index') }}" accept-charset="UTF-8" role="search">
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
                        
                        <th>State Code</th>
                        <th>Tax Percentage</th>
                        <th>Default</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tax as $taxData)
                        <tr>
                            <td>{{ $taxData->state_code }}</td>
                            <td>{{ $taxData->tax_percentage }}</td>
                            <td>
                                {{ $taxData->is_default=='1' ? 'Yes':'No'  }}
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.reports.tax.edit', $taxData->id  ) }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button data-toggle="modal" data-target="#delete-modal"
                                    data-url="{{route('admin.reports.tax.destroy',$taxData->id)}}"
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
                                <span>{!! $tax->render() !!}</span>
                            </td>
                        </tr>
                    </tfoot>
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
