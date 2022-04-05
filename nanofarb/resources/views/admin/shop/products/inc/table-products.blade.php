<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Артикул</th>
        <th>Фото</th>
        <th>Название</th>
        <th>Цена</th>
        <th>Расход, кг</th>
        <th style="text-align: center">Статус</th>
        <th>Создано</th>
        <th>Locale</th>
        <th style="text-align: center">По умолчанию</th>
        <th width="110px">Действия</th>
    </tr>
    </thead>
    <tbody>
    @foreach($group->products->sortBy('created_at') as $product)
        @include('admin.shop.products.inc.tr-product')
    @endforeach
    </tbody>
</table>