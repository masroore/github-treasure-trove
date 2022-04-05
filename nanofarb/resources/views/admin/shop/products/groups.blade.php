@extends('admin.app')

@php
    $content_header = [
        'page_title' => 'Группы товаров',
        'small_page_title' => '',
        'url_back' => '',
        'url_create' => route('admin.products.create')
    ]
@endphp

@section('content')

@includeWhen(true, 'admin.shop.products.inc.filter')

<section class="content">
    @if(request()->has('filter') && !$productGroups->count())
        @include('admin.fields.empty-rows', [
            'msg_title' => 'Поиск не дал результатов',
            'msg_body' => 'Измените поисковый запрос, и попробуйте снова',
        ])
    @else
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Список групп товаров </h3>
                <div class="pull-right box-tools">
                    <a href="{{ request()->fullUrlWithQuery(['show_products_type_list' => 1]) }}"><i class="fa fa-align-justify"></i></a>
                </div>
            </div>
            <div class="box-body">
                @unless($productGroups->count())
                    @include('admin.fields.empty-rows', ['url_create' => route('admin.users.create')])
                @else
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Группы товаров</th>
                            <th style="width: 95px"><a href="{{ request()->fullUrlWithQuery(['product_group_collapse' => 'on']) }}" title="Развернуть/свернуть">Действия <i class="fa fa-angle-down"></i></a></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($productGroups as $group)
                        <tr>
                            <td title="Group: {{ $group->id }}">{{ optional($group->product)->name }}</td>
                            <td style="width: 90px">
                                <div class="btn-group">
                                    <a class="btn btn-xs btn-default" role="button" data-toggle="collapse" data-toggle="tooltip" title="Развернуть/свернуть группу"  href="#collapse_{{$group->id}}" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fa fa-chevron-down"></i>
                                    </a>

                                    <a href="{{ route('admin.products.create', ['product_group_id' => $group->id]) }}" class="btn btn-xs btn-success" data-toggle="tooltip" title="Создать товар группы"><i class="fa fa-plus"></i></a>
                                    {{--<a href="/src/pages/create-product.php" data-toggle="tooltip" title="Редактирование группы" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>--}}
                                    {{--<a href="#" data-url="{{ route('admin.products.group.destroy', $group) }}" class="btn btn-xs btn-danger js-action-destroy" data-toggle="tooltip" title="Удалить группу"><i class="fa fa-remove"></i></a>--}}
                                </div>
                            </td>
                        </tr>
                        <tr >
                            <td colspan="3">
                                <div class="collapse {{ session('product_group_collapse') }}" id="collapse_{{$group->id}}">
                                    @include('admin.shop.products.inc.table-products')
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endunless
            </div>

            <div class="box-footer">
                <div class="pull-right">
                    @include('admin.inc.pagination', ['pages' => $productGroups])
                </div>
            </div>

        </div>
    @endif
</section>
@endsection