@php
    $hasProblem = empty($product->txCategory) ? "Внимание! Не указана основная категория товара. Возможны проблемы в работе системы" : "";
@endphp

<tr @if($hasProblem) title="{{ $hasProblem }}" style="background: #FA8072;" @endif>
    <td>{{ $product->id }}</td>
    <td>{{ $product->sku }}</td>
    <td><a href="#"><img src="{{ optional($product->getFirstMedia('images'))->getUrl('thumb') ?? 'https://via.placeholder.com/50x50' }}" alt=""></a></td>
    <td style="width: 220px">{{ $product->name }}</td>
    <td>{{ Currency::format($product->price, $product->currency) }}</td>
    <td>{{ $product->consumption }}</td>
    <td style="text-align: center">
        @if($product->publish)<i class="fa fa-check-square-o"></i>@else<i class="fa fa-square-o"></i>@endif
    </td>
    <td>{{ $product->created_at }}</td>
    <td>{{ $product->locale }}</td>
    <td style="text-align: center">
        <input class="js-action-change radio"
               type="radio"
               data-url="{{ route('admin.products.group.default', $product) }}"
               data-destination="{{ request()->fullUrl() }}"
               name="default[{{ $product->product_group_id }}]"
               value="{{ $product->id }}"
               @if($product->group->default_product_id == $product->id) checked @endif
               id="default{{ $product->id }}"
        >
        <label for="default{{ $product->id }}"></label>
    </td>
    <td style="width: 110px">
        <div class="btn-group">
            <a href="{{ route_alias('products.show', $product) }}" data-toggle="tooltip" title="Просмотр" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
            <a href="{{ route('admin.products.edit', $product) }}" data-toggle="tooltip" title="Редактировать" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
            <a href="#" data-url="{{ route('admin.products.destroy', $product) }}" data-destination="{{ request()->fullUrl() }}" data-toggle="tooltip" title="Удалить" class="btn btn-xs btn-danger js-action-destroy"><i class="fa fa-remove"></i></a>
        </div>
    </td>
</tr>