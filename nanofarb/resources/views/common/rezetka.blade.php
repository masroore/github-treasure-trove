<?php echo '
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
'; ?>
<yml_catalog date="{{\Carbon\Carbon::now()->format('Y-m-d H:m')}}">
    <shop>
        <name>{{ variable('app_name') }}</name>
        <company>{{ variable('company_name', 'Company Name') }}</company>
        <url>{{ config('app.url') }}</url>
        <currencies>
            <currency id="UAH" rate="1"/>
        </currencies>
        <categories>price_promo
            @foreach($categories as $category)
            <category id="{{ $category->id }}" @if($category->parent_id) parentId="{{ $category->parent_id }}" @endif>{{ $category->name }}</category>
            @endforeach
        </categories>
        <offers>
            @foreach($products as $product)
            <offer id="{{ $product->id }}" available=@if($product->availability)"true"@else"false"@endif>
                <url>{{ route_alias('product.show', $product) }}</url>
                @if($product->getCalculatePrice('sale') && variable('shop_external_use_promo_old_price'))
                    <price>{{ ceil($product->getCalculatePrice('price_old') / 100) }}</price>
                    <price_promo>{{ ceil($product->getCalculatePrice('price') / 100) }}</price_promo>
                @elseif($product->getCalculatePrice('price_old') && variable('shop_external_use_promo_old_price'))
                    <price>{{ ceil($product->getCalculatePrice('price') / 100) }}</price>
                    <price_old>{{ ceil($product->getCalculatePrice('price_old') / 100) }}</price_old>
                @else
                    <price>{{ ceil($product->getCalculatePrice('price') / 100) }}</price>
                @endif
                <currencyId>UAH</currencyId>
                <categoryId>{{ $product->category_id }}</categoryId>
                @foreach($product->getMedia('images') as $media)
                    <picture>{{ url($media->getUrl('xml-rozetka')) }}</picture>
                @endforeach
                <vendor>{{ variable('xml_vendor', 'Nanofarb') }}</vendor>
                <stock_quantity>{{ $product->availability ? 1000 : 0 }}</stock_quantity>

                @php
                    $values = $product->values->where('attribute_id', 2);//цвет
                    $colorStr = '';
                    if ($values->count() == 1) {
                        $colorStr = $values->first()->value;
                    }
                @endphp
                <name>{{ $product->name }} {{ $colorStr }} ({{ $product->sku }})</name>
                <description><![CDATA[{!! $product->description !!}]]></description>

                @php
                    $attrs = $product->getUniqueAttrs();
                @endphp
                @foreach($attrs as $attr)
                    @php
                    $values = $product->values->where('attribute_id', $attr->id)
                    @endphp
                    @if($values->count() == 1)
                        <param name="{{ $attr->title }}">{{ $values->first()->value_suffix }}</param>
                    @elseif($values->count()  > 1)
                        <param name="{{ $attr->title }}">
                @foreach($values as $value)
                {{ $value->value_suffix }}@if(!$loop->last), @endif
                @endforeach
                {{--
                                        <![CDATA[
                @foreach($values as $value)
                {{ $value->value_suffix }}@if(!$loop->last)<br>@endif
                @endforeach
                                        ]]>
                --}}

                        </param>
                    @endif
                @endforeach
                @foreach(variable_json('xml_attributes_values', []) as $item)
                    @if(!empty($item['key']) && !empty($item['value']))
                    <param name="{{ $item['key'] }}">{{ $item['value'] }}</param>
                    @endif
                @endforeach
                <param name="Артикул">{{ $product->sku }}</param>
            </offer>
            @endforeach
        </offers>
    </shop>
</yml_catalog>
