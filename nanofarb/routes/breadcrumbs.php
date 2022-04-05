<?php

// Home
Breadcrumbs::for('home', function ($trail, string $endName = ''): void {
    $trail->push('NanoFarb', route_alias('home'));
    if ($endName) {
        $trail->push($endName, '#');
    }
});

// Home > [Categories] (Продукция)
Breadcrumbs::for('categories', function ($trail, $category = null): void {
    $trail->parent('home');
    $trail->push(trans('site.Продукция'), route_alias('category.index'));
    if ($category instanceof \Kalnoy\Nestedset\NestedSet) {
        foreach ($category->ancestors as $ancestor) {
            $trail->push($ancestor->name, route_alias('categories.show', $ancestor));
        }
    }
});

// Home > [Category]
Breadcrumbs::for('category', function ($trail, $category): void {
    //$trail->parent('home');
    $trail->parent('categories');
    foreach ($category->ancestors as $ancestor) {
        $trail->push($ancestor->name, route_alias('categories.show', $ancestor));
    }
    $trail->push($category->name, route_alias('categories.show', $category));
});

// Home > [Category] > Product
Breadcrumbs::for('product.show', function ($trail, $product): void {
    $trail->parent('category', $product->txCategory);
    $trail->push($product->name, route_alias('products.show', $product));
});

// Home > Page
Breadcrumbs::for('page', function ($trail, $page): void {
    $trail->parent('home');
    $trail->push($page->name, route_alias('pages.show', $page));
});

// Home > Sale
Breadcrumbs::for('sale.index', function ($trail): void {
    $trail->parent('home');
    $trail->push(trans('site.Акции'), route_alias('sale.index'));
});

// Home > Sale > Some sale
Breadcrumbs::for('sale.show', function ($trail, $sale): void {
    $trail->parent('sale.index');
    $trail->push($sale->name, route_alias('sale.show', $sale));
});

// Home > News
Breadcrumbs::for('news.index', function ($trail): void {
    $trail->parent('home');
    $trail->push(trans('site.Новости'), route_alias('news.index'));
});

// Home > News > Some news
Breadcrumbs::for('news.show', function ($trail, $node): void {
    $trail->parent('news.index');
    $trail->push($node->name, route_alias('news.show', $node));
});
